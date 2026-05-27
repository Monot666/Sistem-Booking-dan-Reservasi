<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemesanan; // Memastikan Model Pemesanan di-import

class PemesananController extends Controller
{
    // 1. Menampilkan Halaman Review
    public function review(Request $request)
    {
        $roomName = $request->input('room_name', 'Superior Double');
        $optionType = $request->input('option_type', 'Room Only');
        $bedInfo = $request->input('bed_info', '1 double bed');
        $breakfastInfo = $request->input('breakfast_info', 'Without Breakfast');
        $pricePerNight = (int) $request->input('price', 445000);
        $taxAndFee = 140000;
        $totalPrice = $pricePerNight + $taxAndFee;

        // Mengarah ke file resources/views/user/review-pemesanan.blade.php
        return view('user.review-pemesanan', compact(
            'roomName', 'optionType', 'bedInfo', 'breakfastInfo', 'pricePerNight', 'taxAndFee', 'totalPrice'
        ));
    }

    // 2. Memproses Data Form & REDIRECT ke Pembayaran
    public function store(Request $request)
    {
        // Validasi input form dari user
        // (price & total_price diturunkan dari frontend; kita hitung ulang total pada backend agar aman)
        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'no_hp' => 'required',
            'email' => 'required|email',
            'room_name' => 'required|string|max:255',
            'option_type' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'request' => 'nullable|array',
            'request.*' => 'string|max:255',
        ]);

        // Generate No. Pesanan unik acak 9 digit
        $noPesanan = rand(100000000, 999999999);

        // Satukan array checkbox permintaan khusus menjadi teks string biasa
        $permintaan = $request->has('request') ? implode(', ', $request->input('request')) : '-';

        // Mengambil nilai price_per_night dari request, jika kosong gunakan default 445000
        $pricePerNight = (int) ($request->price ?? 445000);
        $taxAndFee = 140000;
        $totalPrice = $pricePerNight + $taxAndFee;

        // PROSES INSERT: Simpan data ke database MySQL dengan nilai backup (??) jika field opsional kosong
        $pemesanan = Pemesanan::create([
            'no_pesanan' => $noPesanan,
            'user_id' => auth()->id(), // Mengisi ID user yang sedang login
            'nama_pemesan' => $request->nama_pemesan,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'nama_pengunjung' => $request->nama_pengunjung ?? $request->nama_pemesan,
            'permintaan_khusus' => $permintaan,
            'room_name' => $request->room_name ?? 'Superior Double',
            'option_type' => $request->option_type ?? 'Room Only',
            'price_per_night' => $pricePerNight,
            'tax_and_fee' => $taxAndFee,
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);

        // FIX UTAMA: Mengarahkan redirect ke rute 'user.pembayaran' sesuai isi web.php kamu
        return redirect()->route('user.pembayaran', ['id' => $pemesanan->id]);
    }

    // 3. Menampilkan Halaman Pembayaran Berdasarkan ID dari DB
    public function pembayaran($id)
    {
        // Cari data di DB, jika tidak ada otomatis memunculkan error 404
        $pemesanan = Pemesanan::findOrFail($id);

        // Mengarah ke file resources/views/user/pembayaran.blade.php
        return view('user.pembayaran', compact('pemesanan'));
    }
}