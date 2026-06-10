<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Handles user profile display and updates.
 */
class ProfileController extends Controller
{
    /**
     * Show the user's profile page.
     */
    public function index()
    {
        return view('profile.profile');
    }

    /**
     * Update the user's profile data.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Full name is required.',
        ]);

        $user->name = $request->name;
        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}
