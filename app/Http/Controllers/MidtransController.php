<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function webhook(Request $request)
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');

        try {
            // Log payload for debugging
            Log::info('Midtrans Webhook Payload: ', $request->all());

            $notification = new \Midtrans\Notification();
            
            $transaction = $notification->transaction_status;
            $type = $notification->payment_type;
            $order_id = $notification->order_id;
            $fraud = $notification->fraud_status;

            // Extract the real order ID before the dash
            $realOrderId = explode('-', $order_id)[0];
            $booking = Booking::with('user', 'roomUnit')->where('no_pesanan', $realOrderId)->first();

            if (!$booking) {
                return response()->json(['message' => 'Booking not found'], 404);
            }

            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        // Pending
                    } else {
                        $this->handleSuccess($booking, $notification->gross_amount, $type);
                    }
                }
            } else if ($transaction == 'settlement') {
                $this->handleSuccess($booking, $notification->gross_amount, $type);
            } else if ($transaction == 'pending') {
                // Pending
            } else if ($transaction == 'deny') {
                $booking->status = \App\Enums\BookingStatus::Cancelled;
                $booking->save();
            } else if ($transaction == 'expire') {
                $booking->status = \App\Enums\BookingStatus::Cancelled;
                $booking->save();
            } else if ($transaction == 'cancel') {
                $booking->status = \App\Enums\BookingStatus::Cancelled;
                $booking->save();
            }

            return response()->json(['message' => 'Ok']);
        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response()->json(['message' => 'Error'], 500);
        }
    }

    private function handleSuccess($booking, $amount, $method)
    {
        if ($booking->status === \App\Enums\BookingStatus::Confirmed) {
            return; // Already confirmed
        }

        \App\Models\Transaction::create([
            'booking_id'  => $booking->id,
            'date'        => now(),
            'description' => 'Room Booking - BK' . str_pad($booking->id, 3, '0', STR_PAD_LEFT),
            'type'        => \App\Enums\TransactionType::Revenue,
            'amount'      => $amount,
            'method'      => $method,
            'status'      => 'Completed',
        ]);

        $booking->status = \App\Enums\BookingStatus::Confirmed;
        $booking->save();

        try {
            // Determine recipient email (fallback to user's email if booking doesn't have one)
            $recipientEmail = $booking->email ?? ($booking->user ? $booking->user->email : null);
            if ($recipientEmail) {
                \Illuminate\Support\Facades\Mail::to($recipientEmail)->send(new \App\Mail\PaymentConfirmed($booking));
            }
        } catch (\Exception $e) {
            Log::error('Mail Error (Webhook): ' . $e->getMessage());
        }
    }
}
