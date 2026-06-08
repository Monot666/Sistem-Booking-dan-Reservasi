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
        // Cek apakah user sudah verifikasi email/OTP
        if (!auth()->user()->hasVerifiedEmail()) {
            return redirect()->route('profile')->withErrors(['verification' => 'Silakan verifikasi akun Anda terlebih dahulu di menu profil sebelum melakukan pemesanan.']);
        }

        $bookings = Booking::where('user_id', auth()->id())
            ->with('resource')
            ->orderBy('created_at', 'desc')
            ->get();

        // /user/booking harus menampilkan halaman user booking
        return view('user.booking', compact('bookings'));
    }

    /**
     * Get a single booking detail.
     */
    public function show($id)
    {
        // Cek apakah user sudah verifikasi email/OTP
        if (!auth()->user()->hasVerifiedEmail()) {
            return redirect()->route('profile')->withErrors(['verification' => 'Silakan verifikasi akun Anda terlebih dahulu.']);
        }

        $booking = Booking::with('resource', 'user', 'payments')->findOrFail($id);

        // Authorization check: ensure booking belongs to authenticated user
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        return view('profile.order_detail', compact('booking'));
    }

    /**
     * Create a new booking.
     */
    public function store(Request $request) {
        // Cek apakah user sudah verifikasi email/OTP
        if (!auth()->user()->hasVerifiedEmail()) {
            return redirect()->route('profile')->withErrors(['verification' => 'Silakan verifikasi akun Anda terlebih dahulu.']);
        }

        $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'agree_terms' => 'required|accepted',
        ]);

        // VALIDASI BENTROK JADWAL (Logic Inti Modul 4)
        // Using overlap logic: (StartA < EndB) AND (EndA > StartB)
        $isConflict = Booking::where('resource_id', $request->resource_id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($request) {
                $query->where('start_time', '<', $request->end_time)
                      ->where('end_time', '>', $request->start_time);
            })->exists();

        if ($isConflict) {
            return back()->withErrors(['conflict' => 'Jadwal bentrok! Silahkan pilih waktu lain.'])->withInput();
        }

        $resource = Resource::find($request->resource_id);
        $start = Carbon::parse($request->start_time);
        $end = Carbon::parse($request->end_time);
        $hours = $start->diffInHours($end);
        
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
            // Log error
        }

        return redirect()->route('profile.orders')->with('success', 'Booking berhasil! Silakan cek email Anda untuk konfirmasi.');
    }
}
