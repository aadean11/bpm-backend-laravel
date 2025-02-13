<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('user')) {
            return redirect()->route('login')->with('alert', 'Harap login terlebih dahulu!');
        }

        return $next($request);
    }
}

