<?php

/**
 * @deprecated This controller is no longer in use.
 * The booking review flow is now handled by App\Http\Controllers\User\BookingController.
 * Kept for reference only — do NOT register in routes.
 */

namespace App\Http\Controllers\_Deprecated;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewPemesanan extends Controller
{
    public function index(Request $request)
    {
        $roomName = $request->input('room_name', 'Superior Double');
        $optionType = $request->input('option_type', 'Room Only');
        $bedInfo = $request->input('bed_info', '1 double bed');
        $breakfastInfo = $request->input('breakfast_info', 'Without Breakfast');
        $pricePerNight = (int) $request->input('price', 445000);
        
        $taxAndFee = 140000;
        $totalPrice = $pricePerNight + $taxAndFee;

        return view('user.review-pemesanan', compact(
            'roomName',
            'optionType',
            'bedInfo',
            'breakfastInfo',
            'pricePerNight',
            'taxAndFee',
            'totalPrice'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'no_hp' => 'required',
            'email' => 'required|email',
            'room_name' => 'required',
            'price' => 'required|numeric'
        ]);

        $noPesanan = rand(100000000, 999999999);
        $permintaan = $request->has('request') ? implode(', ', $request->input('request')) : '-';

        $pemesanan = \App\Models\Pemesanan::create([
            'no_pesanan' => $noPesanan,
            'user_id' => auth()->id(),
            'nama_pemesan' => $request->nama_pemesan,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'nama_pengunjung' => $request->nama_pengunjung ?? $request->nama_pemesan,
            'permintaan_khusus' => $permintaan,
            'room_name' => $request->room_name,
            'option_type' => $request->option_type ?? 'Room Only',
            'price_per_night' => (int) $request->price,
            'tax_and_fee' => 140000,
            'total_price' => (int) $request->price + 140000,
            'status' => 'pending'
        ]);

        return redirect()->route('user.pembayaran', ['id' => $pemesanan->id]);
    }
}
