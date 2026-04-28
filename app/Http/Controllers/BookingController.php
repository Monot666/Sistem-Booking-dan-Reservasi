<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Resource;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmation;

class BookingController extends Controller {
    /**
     * Get all bookings for the authenticated user.
     */
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with('resource')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'message' => 'Success',
            'data' => $bookings
        ], 200);
    }

    /**
     * Get a single booking detail.
     */
    public function show($id)
    {
        $booking = Booking::findOrFail($id);

        // Authorization check: ensure booking belongs to authenticated user
        if ($booking->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Unauthorized access to this booking'
            ], 403);
        }

        $booking->load('resource', 'user', 'payments');

        return response()->json([
            'message' => 'Success',
            'data' => $booking
        ], 200);
    }

    /**
     * Create a new booking.
     */
    public function store(Request $request) {
        $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'agree_terms' => 'required|accepted', // Logika baru: User harus menyetujui syarat sebelum booking masuk kalender
        ]);

        // VALIDASI BENTROK JADWAL (Logic Inti Modul 4)
        $isConflict = Booking::where('resource_id', $request->resource_id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                      });
            })->exists();

        if ($isConflict) {
            return response()->json([
                'message' => 'Jadwal bentrok! Silahkan pilih waktu lain.'
            ], 422);
        }

        $resource = Resource::find($request->resource_id);
        $start = Carbon::parse($request->start_time);
        $end = Carbon::parse($request->end_time);
        $hours = $start->diffInHours($end);
        
        // At least 1 hour price if less than an hour
        $totalPrice = max(1, $hours) * $resource->price_per_hour;

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'resource_id' => $request->resource_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);

        // KIRIM EMAIL KONFIRMASI
        try {
            Mail::to(auth()->user()->email)->send(new BookingConfirmation($booking));
        } catch (\Exception $e) {
            // Log error or handle silently for now
            // To ensure the booking process itself doesn't fail just because email failed
        }

        $booking->load('resource');

        return response()->json([
            'message' => 'Booking berhasil! Silakan cek email Anda untuk konfirmasi.',
            'data' => $booking
        ], 201);
    }
}
