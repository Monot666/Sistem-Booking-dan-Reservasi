<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

/**
 * Handles all user authentication: login, register, logout, OTP verification, and password reset.
 * Fully standalone — no Fortify dependency.
 */
class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function login()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('login');
    }

    /**
     * Attempt to authenticate the user.
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // If email not verified, send OTP and redirect to verification page
            if (!$user->hasVerifiedEmail()) {
                $user->sendEmailVerificationNotification();
                return redirect()->route('verification.notice');
            }

            return $this->redirectByRole($user);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah!',
        ]);
    }

    /**
     * Show the registration form.
     */
    public function register()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('register');
    }

    /**
     * Handle new user registration.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        // Auto-login after registration
        Auth::login($user);

        // Send OTP for email verification
        $user->sendEmailVerificationNotification();

        return redirect()->route('verification.notice');
    }

    /**
     * Show the OTP verification form.
     */
    public function showOtpForm()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->hasVerifiedEmail()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.verify-otp');
    }

    /**
     * Resend OTP to the authenticated user.
     */
    public function resendOTP(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->hasVerifiedEmail()) {
            return $this->redirectByRole($user);
        }

        $user->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }

    /**
     * Show forgot password form.
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send password reset link via email.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show password reset form.
     */
    public function showResetPasswordForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Handle password reset.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    /**
     * Log the user out and invalidate the session.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * Redirect user based on their role.
     */
    private function redirectByRole($user)
    {
        $role = $user->role->value ?? $user->role;

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'finance') {
            return redirect()->route('finance.dashboard');
        } elseif ($role === 'content_creator') {
            return redirect()->route('content.dashboard');
        }

        return redirect()->intended('/');
    }
}
