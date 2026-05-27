<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Cek apakah yang login beneran admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Maaf, halaman ini hanya untuk Admin.');
        }

        return view('admin.dashboard');
    }
}