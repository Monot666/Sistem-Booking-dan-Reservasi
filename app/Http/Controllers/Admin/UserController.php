<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna.
     */
    public function index()
    {
        $users = User::all();
        // Return json for now since frontend is not requested
        return response()->json($users);
    }

    /**
     * Memperbarui role pengguna.
     */
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,user,content creator,finance'
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        // Menggunakan redirect ke halaman view agar frontend HTML berjalan tanpa JS
        return redirect()->back()->with('success', 'Role pengguna berhasil diperbarui.');
    }
}
