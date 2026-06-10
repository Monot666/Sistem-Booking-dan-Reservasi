<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;

/**
 * Admin controller for viewing payment/financial data.
 */
class PaymentController extends Controller
{
    /**
     * Display the finance overview with all payments.
     */
    public function index()
    {
        $payments = Payment::with('booking', 'booking.room', 'booking.user')
            ->latest()
            ->get();

        return view('admin.finance', compact('payments'));
    }
}
