<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $role = auth()->user()->role->value ?? auth()->user()->role;

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'finance') {
            return redirect()->route('finance.dashboard');
        } elseif ($role === 'content_creator') {
            return redirect()->route('content.dashboard');
        }

        return redirect()->intended('/');
    }
}
