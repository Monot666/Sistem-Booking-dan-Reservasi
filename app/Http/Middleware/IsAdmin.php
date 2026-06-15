<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin {
    public function handle(Request $request, Closure $next) {
        $role = auth()->check() ? (auth()->user()->role->value ?? auth()->user()->role) : null;
        if ($role === 'admin') {
            return $next($request);
        }
        
        // Return 403 Forbidden for web requests
        abort(403, 'Unauthorized. Admin only.');
    }
}
