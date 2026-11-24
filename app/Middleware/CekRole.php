<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekRole
{
    // dipakai: CekRole::class . ':1,2'  (daftar id role yang boleh masuk)
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!in_array((string) session('idrole'), $roles, true)) {
            abort(403, 'Anda tidak punya akses ke halaman ini');
        }
        return $next($request);
    }
}
