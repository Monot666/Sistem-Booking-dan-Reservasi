<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OTPVerificationController extends Controller
{
    /**
     * Verify the user's email address using the provided OTP.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|string|size:6',
        ]);

        $user = Auth::user();

        if ($user->otp_code === $request->otp_code && now()->lessThan($user->otp_expires_at)) {
            $user->markEmailAsVerified();
            $user->otp_code = null;
            $user->otp_expires_at = null;
            $user->save();

            return redirect()->intended('/')->with('success', 'Email Anda telah berhasil diverifikasi.');
        }

        return back()->withErrors(['otp_code' => 'Kode OTP tidak valid atau telah kedaluwarsa.']);
    }
}
