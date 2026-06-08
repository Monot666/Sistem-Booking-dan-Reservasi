<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsContentCreator {
    public function handle(Request $request, Closure $next) {
        if (auth()->check() && auth()->user()->role === 'content_creator') {
            return $next($request);
        }
        
        abort(403, 'Unauthorized. Content Creator role only.');
    }
}
