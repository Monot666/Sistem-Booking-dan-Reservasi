<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Handles user authentication: login, register, and logout.
 */
class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function login()
    {
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

            // Role-based redirect
            if ($user->role === \App\Enums\UserRole::Admin) {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->role === \App\Enums\UserRole::Finance) {
                return redirect()->route('finance.dashboard');
            } elseif ($user->role === \App\Enums\UserRole::ContentCreator) {
                return redirect()->route('content.dashboard');
            }

            return redirect()->intended('/');
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
            'password' => 'required|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login.');
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
}
