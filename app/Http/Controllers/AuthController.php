<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // --- LOGIN SECTION ---
    
    public function login()
    {
        return view('login');
    }

    public function loginAction(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // --- LOGIKA REDIRECT BERDASARKAN ROLE ---
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard'); // Ke Dashboard Admin
            }

            return redirect()->intended('/'); // User biasa ke Landing Page
        }

        return back()->withErrors([
            'email' => 'Email atau password salah!',
        ]);
    }


    // --- REGISTER SECTION ---

    public function register()
    {
        return view('register');
    }

    public function registerAction(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Set default role saat daftar adalah 'user'
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    // --- LOGOUT SECTION ---

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}

