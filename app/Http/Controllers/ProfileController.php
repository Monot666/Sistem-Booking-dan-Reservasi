<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil (Personal Data).
     */
    public function index()
    {
        // Masuk ke folder profile, cari file profile.blade.php
        return view('profile.profile');
    }

    /**
     * Memperbarui data profil user.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama lengkap tidak boleh kosong.',
        ]);

        // 2. Update Data
        $user->name = $request->name;
        $user->save();

        return back()->with('success', 'Profil kamu berhasil diperbarui!');
    }
}

