<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsFinance {
    public function handle(Request $request, Closure $next) {
        if (auth()->check() && auth()->user()->role === 'finance') {
            return $next($request);
        }
        
        abort(403, 'Unauthorized. Finance role only.');
    }
}
