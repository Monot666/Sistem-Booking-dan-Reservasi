<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking; // Pastikan Model Booking dipanggil di sini

/**
 * Admin dashboard controller.
 */
class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // 1. Mengambil 5 data pesanan terbaru dari database
        // (with(['user', 'room']) digunakan untuk menarik data nama tamu dan tipe kamar sekaligus)
        $recentBookings = Booking::with(['user', 'room'])
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

        // 2. Mengirimkan variabel $recentBookings ke halaman dashboard admin
        return view('admin.dashboard', compact('recentBookings'));
    }
}