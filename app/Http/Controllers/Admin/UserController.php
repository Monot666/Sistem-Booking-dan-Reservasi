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

        // Bisa disesuaikan kembali jika menggunakan redirect ke halaman view (misal: redirect()->back()->with('success', 'Role berhasil diubah'))
        return response()->json([
            'success' => true,
            'message' => 'Role pengguna berhasil diperbarui.',
            'data' => $user
        ]);
    }
}
