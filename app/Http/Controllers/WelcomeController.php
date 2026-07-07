<?php

namespace App\Http\Controllers; // Ini harus ada!

use App\Models\Banner;
use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    public function index()
    {
        // Banner utama ("Foto 1" dari layout Dashboard)
        // supaya saat Content Creator upload Foto 1, halaman / ikut berubah.
        $banner = Banner::where('is_active', 1)
            ->where('layout_name', 'Dashboard')
            ->where('position', 'Foto 1')
            ->first();

        // Mengambil data untuk Explore
        $exploreBanners = Banner::where('layout_name', 'Dashboard Explore')
            ->where('is_active', 1)
            ->orderBy('position', 'asc')
            ->get();

        // Mengambil data untuk Fasilitas (PASTIKAN INI ADA)
        $fasilitasBanners = Banner::where('layout_name', 'Fasilitas Hotel')
            ->where('is_active', 1)
            ->orderBy('position', 'asc')
            ->get();

        // KIRIM KEDUANYA KE VIEW
        return view('welcome', compact('banner', 'exploreBanners', 'fasilitasBanners'));
    }
}

