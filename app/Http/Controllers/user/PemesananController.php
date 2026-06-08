<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Resource;

class PemesananController extends Controller
{
    // 1. Menampilkan Halaman Review
    public function review(Request $request)
    {
        $resourceId = $request->input('resource_id');
        $resource = Resource::find($resourceId);

        $checkin = $request->input('checkin', now()->format('Y-m-d'));
        $checkout = $request->input('checkout', now()->addDay()->format('Y-m-d'));

        // Hitung Durasi (Malam)
        $start = \Carbon\Carbon::parse($checkin);
        $end = \Carbon\Carbon::parse($checkout);
        $nights = max(1, $start->diffInDays($end));

        // Format Tanggal untuk View
        $checkinDisplay = $start->translatedFormat('D, d M Y');
        $checkoutDisplay = $end->translatedFormat('D, d M Y');

        $roomName = $resource ? $resource->name : $request->input('room_name', 'Superior Double');
        $optionType = $request->input('option_type', 'Room Only');
        $bedInfo = $request->input('bed_info', '1 double bed');
        $breakfastInfo = $request->input('breakfast_info', 'Without Breakfast');
        $pricePerNight = $resource ? (int)$resource->price_per_hour : (int) $request->input('price', 445000);
        
        $taxAndFee = 140000;
        $totalRoomPrice = $pricePerNight * $nights;
        $totalPrice = $totalRoomPrice + $taxAndFee;

        return view('user.review-pemesanan', compact(
            'roomName', 'optionType', 'bedInfo', 'breakfastInfo', 'pricePerNight', 
            'taxAndFee', 'totalPrice', 'resourceId', 'checkin', 'checkout', 
            'nights', 'checkinDisplay', 'checkoutDisplay'
        ));
    }

    // 2. Memproses Data Form & REDIRECT ke Pembayaran
    public function store(Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'no_hp' => 'required',
            'email' => 'required|email',
            'resource_id' => 'nullable|exists:resources,id',
            'price' => 'required|numeric|min:0',
            'checkin' => 'required|date',
            'checkout' => 'required|date|after:checkin',
            'request' => 'nullable|array',
            'request.*' => 'string|max:255',
        ]);

        $noPesanan = rand(100000000, 999999999);
        $permintaan = $request->has('request') ? implode(', ', $request->input('request')) : '-';

        $checkin = $request->input('checkin');
        $checkout = $request->input('checkout');
        $start = \Carbon\Carbon::parse($checkin);
        $end = \Carbon\Carbon::parse($checkout);
        $nights = max(1, $start->diffInDays($end));

        $pricePerNight = (int) ($request->price ?? 445000);
        $taxAndFee = 140000;
        $totalPrice = ($pricePerNight * $nights) + $taxAndFee;

        // Gunakan model Booking
        $booking = Booking::create([
            'no_pesanan' => $noPesanan,
            'user_id' => auth()->id(),
            'resource_id' => $request->resource_id, 
            'nama_pemesan' => $request->nama_pemesan,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'nama_pengunjung' => $request->nama_pengunjung ?? $request->nama_pemesan,
            'permintaan_khusus' => $permintaan,
            'start_time' => $start,
            'end_time' => $end,
            'total_price' => $totalPrice,
            'tax_and_fee' => $taxAndFee,
            'status' => 'pending'
        ]);

        return redirect()->route('user.pembayaran', ['id' => $booking->id]);
    }

    // 3. Menampilkan Halaman Pembayaran Berdasarkan ID dari DB
    public function pembayaran($id)
    {
        $pemesanan = Booking::with('resource')->findOrFail($id);

        return view('user.pembayaran', compact('pemesanan'));
    }
}