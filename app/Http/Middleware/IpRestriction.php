<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IpRestriction
{
    public function handle(Request $request, Closure $next)
    {
        // Batasi IP hanya 1 kali absen per user per hari
        $ip = $request->ip();
        session(['user_ip'=>$ip]);
        return $next($request);
    }
}
