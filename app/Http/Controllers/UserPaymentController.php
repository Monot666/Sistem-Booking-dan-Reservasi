<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserPaymentController extends Controller
{
    /**
     * Backward-compatible wrapper.
     * Route pembayaran user sekarang memakai PembayaranController.
     */
    public function store(Request $request)
    {
        return app(\App\Http\Controllers\PembayaranController::class)->store($request);
    }
}

