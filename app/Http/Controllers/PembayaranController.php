<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'booking_id' => 'required|integer|exists:bookings,id',
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|string|in:card,bank_transfer,ewallet',
        ]);

        $booking = Booking::with('payments')->findOrFail($data['booking_id']);

        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Only allow payment for pending bookings
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Booking ini tidak bisa diproses pembayaran lagi.');
        }

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'amount' => $data['amount'],
            'method' => $data['method'],
            'status' => 'paid',
        ]);

        // Since current UI seems to treat payment as full payment,
        // set booking confirmed when user pays.
        $booking->status = 'confirmed';
        $booking->save();

        return redirect()->route('bookings.show', $booking->id)
            ->with('success', 'Pembayaran berhasil! Booking kamu sudah dikonfirmasi.');
    }
}
