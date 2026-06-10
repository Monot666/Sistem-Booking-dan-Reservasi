<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ewallet;
use Illuminate\Http\Request;

/**
 * Manages the user's saved e-wallets.
 */
class EwalletController extends Controller
{
    /**
     * Display the user's saved e-wallets.
     */
    public function index()
    {
        $wallets = Ewallet::where('user_id', auth()->id())->get();

        return view('profile.ewallet', compact('wallets'));
    }

    /**
     * Store a new e-wallet for the user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'phone' => 'required|string|max:20',
        ]);

        Ewallet::create([
            'user_id' => auth()->id(),
            'name'    => $request->name,
            'phone'   => $request->phone,
        ]);

        return back()->with('success', 'E-Wallet added successfully.');
    }

    /**
     * Update an existing e-wallet.
     */
    public function update(Request $request, $id)
    {
        $wallet = Ewallet::findOrFail($id);
        abort_if($wallet->user_id !== auth()->id(), 403);

        $request->validate([
            'name'  => 'sometimes|required|string|max:100',
            'phone' => 'sometimes|required|string|max:20',
        ]);

        $wallet->update([
            'name'  => $request->name,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'E-Wallet updated successfully.');
    }

    /**
     * Delete an e-wallet.
     */
    public function destroy($id)
    {
        $wallet = Ewallet::findOrFail($id);
        abort_if($wallet->user_id !== auth()->id(), 403);

        $wallet->delete();

        return back()->with('success', 'E-Wallet deleted successfully.');
    }
}
