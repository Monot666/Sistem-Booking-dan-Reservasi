<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = \App\Models\Booking::with(['user', 'resource'])
            ->orderByDesc('created_at')
            ->get();
            
        return view('admin.bookings', compact('bookings'));
    }
}
