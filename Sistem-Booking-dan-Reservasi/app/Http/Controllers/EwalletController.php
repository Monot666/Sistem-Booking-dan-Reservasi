<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ewallet;

class EwalletController extends Controller
{
    public function index()
    {
        $wallets = Ewallet::where('user_id', auth()->id())->get();
        return view('profile.ewallet', compact('wallets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required'
        ]);

        Ewallet::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'phone' => $request->phone
        ]);

        return back()->with('success', 'E-Wallet berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $wallet = Ewallet::findOrFail($id);
        
        // Authorization check: ensure wallet belongs to authenticated user
        if ($wallet->user_id !== auth()->id()) {
            return back()->with('error', 'Anda tidak memiliki akses ke e-wallet ini');
        }

        $wallet->update([
            'name' => $request->name,
            'phone' => $request->phone
        ]);

        return back()->with('success', 'E-Wallet berhasil diupdate');
    }

    public function destroy($id)
    {
        $wallet = Ewallet::findOrFail($id);
        
        // Authorization check: ensure wallet belongs to authenticated user
        if ($wallet->user_id !== auth()->id()) {
            return back()->with('error', 'Anda tidak memiliki akses ke e-wallet ini');
        }
        
        $wallet->delete();

        return back()->with('success', 'E-Wallet berhasil dihapus');
    }
}