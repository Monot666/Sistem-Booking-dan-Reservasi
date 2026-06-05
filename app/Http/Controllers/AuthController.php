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

            // 1. Ambil data user yang berhasil login
            $user = Auth::user();

            // --- LOGIKA REDIRECT BERDASARKAN ROLE ---
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard'); // Ke Dashboard Admin
            } 
            elseif ($user->role === 'finance') {
                return redirect()->route('finance.dashboard'); // Ke Dashboard Finance
            } 
            elseif ($user->role === 'content_creator') {
                // Route untuk content creator disiapkan di sini (bisa diubah nanti)
                return redirect()->intended('/content/dashboard'); 
            }

            // Default jika yang login adalah 'user' (tamu hotel biasa)
            return redirect()->intended('/'); 
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