<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        $guests = \App\Models\User::where('role', \App\Enums\UserRole::User)
            ->withCount('bookings')
            ->withMax('bookings', 'start_time')
            ->get();
            
        return view('admin.guests', compact('guests'));
    }
}
