<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('iduser')) {
            return redirect()->route('login')->with('err', 'Silakan login dulu');
        }
        return $next($request);
    }
}
