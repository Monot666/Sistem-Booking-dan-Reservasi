<?php

// File ini didepresiasi karena flow pemesanan sudah dipakai oleh App\Http\Controllers\user\PemesananController.
// Hapus saja dari penggunaan route agar tidak terjadi mismatch.

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ReviewPemesanan extends Controller
{
    /**
     * Menampilkan halaman review pemesanan berdasarkan kamar yang dipilih.
     */
    public function index(Request $request)
    {
        // Tangkap data dari halaman pilih kamar (dengan nilai default jika kosong)
        $roomName = $request->input('room_name', 'Superior Double');
        $optionType = $request->input('option_type', 'Room Only');
        $bedInfo = $request->input('bed_info', '1 double bed');
        $breakfastInfo = $request->input('breakfast_info', 'Without Breakfast');
        $pricePerNight = (int) $request->input('price', 445000);
        
        // Atur biaya pajak & pelayanan tetap (sesuai mockup)
        $taxAndFee = 140000;
        
        // Hitung total harga keseluruhan
        $totalPrice = $pricePerNight + $taxAndFee;

        // Oper data ke view review-pemesanan.blade.php
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

    /**
     * Menyimpan atau memproses data review/pemesanan (Method POST).
     */
   public function store(Request $request)
    {
        // 1. Validasi input dari form blade kamu
        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'no_hp' => 'required',
            'email' => 'required|email',
            'room_name' => 'required',
            'price' => 'required|numeric'
        ]);

        // 2. Generate nomor pesanan acak 9 digit
        $noPesanan = rand(100000000, 999999999);

        // 3. Satukan data checkbox permintaan khusus menjadi string biasa
        $permintaan = $request->has('request') ? implode(', ', $request->input('request')) : '-';

        // 4. PROSES INSERT: Simpan data ke database MySQL menggunakan Model Pemesanan
        $pemesanan = \App\Models\Pemesanan::create([
            'no_pesanan' => $noPesanan,
            'user_id' => auth()->id(), // Mengisi ID user jika sudah login
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

        // 5. FIX UTAMA: Pindah halaman menggunakan REDIRECT, bukan return view!
        // Kita bawa parameter 'id' dari data yang baru saja masuk ke database
        return redirect()->route('user.pembayaran', ['id' => $pemesanan->id]);
    }
}