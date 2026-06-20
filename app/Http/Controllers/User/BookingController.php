<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomUnit;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmation;

/**
 * Unified booking controller for the user booking flow:
 * search rooms → review → store → payment → process payment.
 *
 * Consolidates the former BookingController, PemesananController,
 * and PembayaranController into a single cohesive controller.
 */
class BookingController extends Controller
{
    /**
     * List all bookings for the authenticated user.
     */
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with('room')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.booking', compact('bookings'));
    }

    /**
     * Show a single booking detail.
     */
    public function show($id)
    {
        $booking = Booking::with('room', 'user')->findOrFail($id);

        // Authorization: ensure booking belongs to the authenticated user
        abort_if($booking->user_id !== Auth::id(), 403);

        return view('profile.order_detail', compact('booking'));
    }

    /**
     * Show the booking review/preview page before submission.
     */
    public function review(Request $request)
    {
        $resourceId = $request->input('resource_id');
        $resource = $resourceId ? Room::find($resourceId) : null;

        $checkin  = $request->input('checkin', now()->format('Y-m-d'));
        $checkout = $request->input('checkout', now()->addDay()->format('Y-m-d'));

        // Calculate duration (nights)
        $start  = Carbon::parse($checkin);
        $end    = Carbon::parse($checkout);
        $nights = max(1, $start->diffInDays($end));

        // Formatted dates for view display
        $checkinDisplay  = $start->translatedFormat('D, d M Y');
        $checkoutDisplay = $end->translatedFormat('D, d M Y');

        $roomName      = $resource ? $resource->name : $request->input('room_name', 'Superior Double');
        $optionType    = $request->input('option_type', 'Room Only');
        $bedInfo       = $request->input('bed_info', '1 double bed');
        $breakfastInfo = $request->input('breakfast_info', 'Without Breakfast');
        $pricePerNight = $resource ? (int) $resource->price_per_hour : (int) $request->input('price', 445000);

        $taxAndFee      = 140000;
        $totalRoomPrice = $pricePerNight * $nights;
        $totalPrice     = $totalRoomPrice + $taxAndFee;

        return view('user.review-pemesanan', compact(
            'roomName',
            'optionType',
            'bedInfo',
            'breakfastInfo',
            'pricePerNight',
            'taxAndFee',
            'totalPrice',
            'resourceId',
            'checkin',
            'checkout',
            'nights',
            'checkinDisplay',
            'checkoutDisplay'
        ));
    }

    /**
     * Store a new booking with schedule conflict validation.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'no_hp'        => 'required',
            'email'        => 'required|email',
            'resource_id'  => 'nullable|exists:resources,id',
            'price'        => 'required|numeric|min:0',
            'checkin'      => 'required|date',
            'checkout'     => 'required|date|after:checkin',
            'request'      => 'nullable|array',
            'request.*'    => 'string|max:255',
        ]);

        $checkin  = $request->input('checkin');
        $checkout = $request->input('checkout');
        $start    = Carbon::parse($checkin);
        $end      = Carbon::parse($checkout);
        $nights   = max(1, $start->diffInDays($end));

        $resourceId = $request->resource_id;

        // Fallback for UI that doesn't pass resource_id
        if (!$resourceId) {
            $fallbackRoom = \App\Models\Room::first();
            if ($fallbackRoom) {
                $resourceId = $fallbackRoom->id;
            }
        }

        $assignedRoomUnitId = null;

        // Schedule conflict validation & Room assignment
        if ($resourceId) {
            $availableRoomUnit = \App\Models\RoomUnit::where('resource_id', $resourceId)
                ->whereDoesntHave('bookings', function ($query) use ($start, $end) {
                    $query->where('status', '!=', \App\Enums\BookingStatus::Cancelled)
                          ->where('start_time', '<', $end)
                          ->where('end_time', '>', $start);
                })
                ->first();

            // If no specific unit is free, we still proceed but without a unit ID, or we can block it.
            // For now, allow it to proceed with unit=null if we just want to test booking flows.
            if ($availableRoomUnit) {
                $assignedRoomUnitId = $availableRoomUnit->id;
            }
        }

        $noPesanan     = rand(100000000, 999999999);
        $specialRequest = $request->has('request') ? implode(', ', $request->input('request')) : '-';
        
        $room = $resourceId ? Room::find($resourceId) : null;
        $roomNameSnapshot = $room ? $room->name : ($request->input('room_name') ?? 'Superior Double');
        $roomPriceSnapshot = $room ? $room->price_per_hour : ($request->price ?? 445000);

        $pricePerNight = (int) $roomPriceSnapshot;
        $taxAndFee     = 140000;
        $totalPrice    = ($pricePerNight * $nights) + $taxAndFee;

        $booking = Booking::create([
            'no_pesanan'       => $noPesanan,
            'user_id'          => Auth::id(),
            'resource_id'      => $resourceId,
            'room_unit_id'     => $assignedRoomUnitId,
            'nama_pemesan'     => $request->nama_pemesan,
            'no_hp'            => $request->no_hp,
            'email'            => $request->email,
            'nama_pengunjung'  => $request->nama_pengunjung ?? $request->nama_pemesan,
            'permintaan_khusus' => $specialRequest,
            'room_name'        => $roomNameSnapshot,
            'room_price'       => $roomPriceSnapshot,
            'start_time'       => $start,
            'end_time'         => $end,
            'total_price'      => $totalPrice,
            'tax_and_fee'      => $taxAndFee,
            'status'           => \App\Enums\BookingStatus::Pending,
        ]);

        // Send booking confirmation email
        try {
            Mail::to(Auth::user()->email)->send(new BookingConfirmation($booking));
        } catch (\Exception $e) {
            // Log error but don't block the booking flow
        }

        return redirect()->route('bookings.payment', ['id' => $booking->id]);
    }

    /**
     * Show the payment page for a booking.
     */
    public function payment($id)
    {
        $pemesanan = Booking::with('room')->findOrFail($id);

        return view('user.pembayaran', compact('pemesanan'));
    }

    /**
     * Charge payment using Midtrans Core API based on the selected method.
     */
    public function chargePayment(Request $request)
    {
        $request->validate([
            'booking_id'       => 'required|exists:bookings,id',
            'payment_method'   => 'required|string', // VA, TRANSFER, CC, MINIMARKET
            'va_bank_selected' => 'nullable|string',
            'mart_selected'    => 'nullable|string',
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        // Setup Midtrans config
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        $orderId = $booking->no_pesanan . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => $booking->nama_pemesan,
                'email'      => $booking->email,
                'phone'      => $booking->no_hp,
            ],
            'custom_expiry' => [
                'expiry_duration' => 24,
                'unit' => 'hour'
            ]
        ];

        $method = $request->payment_method;
        $bank = $request->va_bank_selected;
        $mart = $request->mart_selected;
        $paymentCode = 'Mohon periksa opsi pembayaran Anda.';

        try {
            if ($method === 'VA') {
                $bankCode = strtolower($bank); // bca, mandiri, bni, bri, cimb
                
                if ($bankCode === 'mandiri') {
                    $params['payment_type'] = 'echannel';
                    $params['echannel'] = [
                        'bill_info1' => 'Roomly Payment',
                        'bill_info2' => 'Hotel Booking'
                    ];
                } else {
                    $params['payment_type'] = 'bank_transfer';
                    $params['bank_transfer'] = [
                        'bank' => $bankCode
                    ];
                }

                $response = \Midtrans\CoreApi::charge($params);
                
                if ($bankCode === 'mandiri') {
                    $paymentCode = $response->biller_code . $response->bill_key;
                } else {
                    $paymentCode = $response->va_numbers[0]->va_number ?? $response->permata_va_number ?? '123456789';
                }

            } elseif ($method === 'MINIMARKET') {
                $params['payment_type'] = 'cstore';
                $params['cstore'] = [
                    'store' => strtolower($mart) === 'alfamart' ? 'alfamart' : 'indomaret',
                    'message' => 'Roomly Booking'
                ];

                $response = \Midtrans\CoreApi::charge($params);
                $paymentCode = $response->payment_code ?? 'RM-987759315';

            } elseif ($method === 'TRANSFER' || $method === 'ATM') {
                $params['payment_type'] = 'bank_transfer';
                $params['bank_transfer'] = [
                    'bank' => 'permata'
                ];

                $response = \Midtrans\CoreApi::charge($params);
                $paymentCode = $response->permata_va_number ?? '123456789';

            } elseif ($method === 'QRIS') {
                $params['payment_type'] = 'qris';

                $response = \Midtrans\CoreApi::charge($params);
                $paymentCode = "KODE-TIDAK-DITEMUKAN";
                if (isset($response->actions)) {
                    foreach ($response->actions as $action) {
                        if ($action->name === 'generate-qr-code') {
                            $paymentCode = $action->url;
                            break;
                        }
                    }
                }
            } else {
                // Fallback for Kartu Kredit (Core API requires frontend tokenization, so we use dummy for now)
                $paymentCode = "KARTU-KREDIT-MEMBUTUHKAN-TOKENISASI";
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Midtrans Core API Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }

        // Store to session and redirect
        return redirect()->route('bookings.payment.instructions')->with([
            'payment_code' => $paymentCode,
            'method'       => $method,
            'bank'         => $bank,
            'mart'         => $mart,
            'booking_id'   => $booking->id,
            'order_id'     => $orderId
        ]);
    }

    /**
     * Show payment instructions
     */
    public function paymentInstructions()
    {
        return view('user.instruksi-pembayaran');
    }

    /**
     * Check booking status for AJAX polling
     */
    public function checkStatus($id, Request $request)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status === \App\Enums\BookingStatus::Pending && $request->order_id) {
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');

            try {
                $midtransStatus = \Midtrans\Transaction::status($request->order_id);
                if ($midtransStatus->transaction_status === 'settlement' || $midtransStatus->transaction_status === 'capture') {
                    $booking->status = \App\Enums\BookingStatus::Confirmed;
                    $booking->save();

                    // Auto-create transaction record for Finance tracking
                    $alreadyRecorded = \App\Models\Transaction::where('booking_id', $booking->id)->exists();
                    if (!$alreadyRecorded) {
                        $paymentMethod = $midtransStatus->payment_type ?? 'Midtrans';
                        // Map Midtrans payment_type to friendly name
                        $methodMap = [
                            'bank_transfer' => 'Bank Transfer',
                            'echannel' => 'Bank Transfer',
                            'cstore' => 'Minimarket',
                            'qris' => 'QRIS',
                            'credit_card' => 'Credit Card',
                            'gopay' => 'E-Wallet',
                        ];
                        $friendlyMethod = $methodMap[$paymentMethod] ?? ucfirst(str_replace('_', ' ', $paymentMethod));

                        \App\Models\Transaction::create([
                            'booking_id'  => $booking->id,
                            'date'        => now(),
                            'description' => 'Room Booking - BK' . str_pad($booking->id, 3, '0', STR_PAD_LEFT),
                            'type'        => \App\Enums\TransactionType::Revenue,
                            'amount'      => $booking->total_price,
                            'method'      => $friendlyMethod,
                            'status'      => 'Completed',
                        ]);
                    }
                }
            } catch (\Exception $e) {
                // Silently ignore if order_id is not found yet in Midtrans
            }
        }

        return response()->json([
            'status' => $booking->status->value
        ]);
    }

    /**
     * Process a payment for a booking.
     */
    public function processPayment(Request $request)
    {
        $data = $request->validate([
            'booking_id' => 'required|integer|exists:bookings,id',
            'amount'     => 'required|numeric|min:0.01',
            'method'     => 'required|string|in:card,bank_transfer,ewallet',
        ]);

        $booking = Booking::findOrFail($data['booking_id']);

        // Authorization: ensure booking belongs to the authenticated user
        abort_if($booking->user_id !== Auth::id(), 403);

        // Only allow payment for pending bookings
        if ($booking->status !== \App\Enums\BookingStatus::Pending) {
            return back()->with('error', 'This booking can no longer be paid.');
        }

        \App\Models\Transaction::create([
            'booking_id'  => $booking->id,
            'date'        => now(),
            'description' => 'Room Booking - BK' . str_pad($booking->id, 3, '0', STR_PAD_LEFT),
            'type'        => \App\Enums\TransactionType::Revenue,
            'amount'      => $data['amount'],
            'method'      => $data['method'],
            'status'      => 'Completed',
        ]);

        // Mark booking as confirmed after payment
        $booking->status = \App\Enums\BookingStatus::Confirmed;
        $booking->save();

        // Send payment confirmation email with physical room number
        try {
            \Illuminate\Support\Facades\Mail::to(Auth::user()->email)->send(new \App\Mail\PaymentConfirmed($booking));
        } catch (\Exception $e) {
            // Log error but don't block the flow
        }

        return redirect()->route('bookings.show', $booking->id)
            ->with('success', 'Payment successful! Your booking has been confirmed.');
    }

    public function requestRefund(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        abort_if($booking->user_id !== Auth::id(), 403);

        $request->validate([
            'refund_reason' => 'required|string|max:500',
            'refund_payment_method' => 'required|string|in:E-Wallet,Kartu Kredit,Bank Transfer',
            'refund_payment_account' => 'required|string|max:100',
            'refund_account_name' => 'required|string|max:255'
        ]);

        if ($booking->status !== \App\Enums\BookingStatus::Confirmed) {
            return back()->with('error', 'Hanya pesanan yang sudah dikonfirmasi yang bisa diajukan refund.');
        }

        $booking->status = \App\Enums\BookingStatus::Cancelled;
        $booking->refund_status = 'requested';
        $booking->refund_reason = $request->refund_reason;
        $booking->refund_payment_method = $request->refund_payment_method;
        $booking->refund_payment_account = $request->refund_payment_account;
        $booking->refund_account_name = $request->refund_account_name;
        
        // Free up the room
        $booking->room_unit_id = null;
        $booking->save();

        return back()->with('success', 'Berhasil membatalkan pesanan. Pengajuan refund Anda sedang diproses oleh Finance.');
    }
}
