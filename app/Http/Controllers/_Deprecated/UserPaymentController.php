<?php

/**
 * @deprecated This controller is no longer in use.
 * Payment logic is now handled by App\Http\Controllers\User\BookingController::processPayment().
 * Kept for reference only — do NOT register in routes.
 */

namespace App\Http\Controllers\_Deprecated;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserPaymentController extends Controller
{
    public function store(Request $request)
    {
        return app(\App\Http\Controllers\PembayaranController::class)->store($request);
    }
}
