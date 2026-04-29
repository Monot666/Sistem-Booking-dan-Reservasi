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
            'name'        => 'required|string|max:255',
            'gender'      => 'nullable|string',
            'city'        => 'nullable|string|max:100',
            'phone'       => 'nullable|string|max:20',
            'birth_day'   => 'nullable|numeric|between:1,31',
            'birth_month' => 'nullable|string',
            'birth_year'  => 'nullable|numeric|digits:4',
        ], [
            'name.required' => 'Nama lengkap tidak boleh kosong.',
        ]);

        // 2. Update Data
        $user->name   = $request->name;
        $user->gender = $request->gender;
        $user->city   = $request->city;
        $user->phone  = $request->phone;

        if ($request->birth_day && $request->birth_month && $request->birth_year) {
            $months = [
                'January' => '01', 'February' => '02', 'March' => '03', 'April' => '04',
                'May' => '05', 'June' => '06', 'July' => '07', 'August' => '08',
                'September' => '09', 'October' => '10', 'November' => '11', 'December' => '12'
            ];
            
            $monthNum = $months[$request->birth_month] ?? '01';
            $dayNum = sprintf('%02d', $request->birth_day);
            $user->birthdate = $request->birth_year . '-' . $monthNum . '-' . $dayNum;
        }
        
        $user->save();

        return back()->with('success', 'Profil kamu berhasil diperbarui!');
    }
}

