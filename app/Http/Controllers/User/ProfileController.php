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
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'gender' => 'nullable|in:Male,Female',
        ], [
            'name.required' => 'Full name is required.',
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->city = $request->city;
        $user->gender = $request->gender;

        if ($request->filled(['birth_year', 'birth_month', 'birth_day'])) {
            $monthNum = date('m', strtotime($request->birth_month));
            $user->birthdate = $request->birth_year . '-' . $monthNum . '-' . str_pad($request->birth_day, 2, '0', STR_PAD_LEFT);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar && \Illuminate\Support\Facades\Storage::exists('public/' . $user->avatar)) {
                \Illuminate\Support\Facades\Storage::delete('public/' . $user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Show the user's order history.
     */
    public function orders()
    {
        $bookings = \App\Models\Booking::with(['resource', 'user'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profile.orders', compact('bookings'));
    }
}
