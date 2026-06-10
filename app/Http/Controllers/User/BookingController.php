<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
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
        $booking = Booking::with('room', 'user', 'payments')->findOrFail($id);

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

        // Schedule conflict validation
        if ($request->resource_id) {
            $isConflict = Booking::where('resource_id', $request->resource_id)
                ->where('status', '!=', \App\Enums\BookingStatus::Cancelled)
                ->where(function ($query) use ($start, $end) {
                    $query->where('start_time', '<', $end)
                          ->where('end_time', '>', $start);
                })->exists();

            if ($isConflict) {
                return back()
                    ->withErrors(['conflict' => 'Schedule conflict! Please choose a different time.'])
                    ->withInput();
            }
        }

        $noPesanan     = rand(100000000, 999999999);
        $specialRequest = $request->has('request') ? implode(', ', $request->input('request')) : '-';
        
        $room = $request->resource_id ? Room::find($request->resource_id) : null;
        $roomNameSnapshot = $room ? $room->name : ($request->input('room_name') ?? 'Superior Double');
        $roomPriceSnapshot = $room ? $room->price_per_hour : ($request->price ?? 445000);

        $pricePerNight = (int) $roomPriceSnapshot;
        $taxAndFee     = 140000;
        $totalPrice    = ($pricePerNight * $nights) + $taxAndFee;

        $booking = Booking::create([
            'no_pesanan'       => $noPesanan,
            'user_id'          => Auth::id(),
            'resource_id'      => $request->resource_id,
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
     * Process a payment for a booking.
     */
    public function processPayment(Request $request)
    {
        $data = $request->validate([
            'booking_id' => 'required|integer|exists:bookings,id',
            'amount'     => 'required|numeric|min:0.01',
            'method'     => 'required|string|in:card,bank_transfer,ewallet',
        ]);

        $booking = Booking::with('payments')->findOrFail($data['booking_id']);

        // Authorization: ensure booking belongs to the authenticated user
        abort_if($booking->user_id !== Auth::id(), 403);

        // Only allow payment for pending bookings
        if ($booking->status !== \App\Enums\BookingStatus::Pending) {
            return back()->with('error', 'This booking can no longer be paid.');
        }

        Payment::create([
            'booking_id' => $booking->id,
            'amount'     => $data['amount'],
            'method'     => $data['method'],
            'status'     => \App\Enums\PaymentStatus::Paid,
        ]);

        // Mark booking as confirmed after payment
        $booking->status = \App\Enums\BookingStatus::Confirmed;
        $booking->save();

        return redirect()->route('bookings.show', $booking->id)
            ->with('success', 'Payment successful! Your booking has been confirmed.');
    }
}
