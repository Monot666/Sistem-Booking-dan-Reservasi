<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class AdminPaymentController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        // Placeholder data for admin finance page.
        $payments = Payment::with('booking', 'booking.resource', 'booking.user')
            ->latest()
            ->get();

        return view('admin.finance', compact('payments'));
    }
}

