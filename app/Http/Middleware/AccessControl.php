<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AccessControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('logout')) {
            return $next($request);
        }

        if (!Auth::guard('admin')->check() && !Auth::guard('user')->check()) {
            return $next($request);
        }

        if (Auth::guard('admin')->check() && $request->is('admin/*')) {
            return $next($request);
        }

        if (Auth::guard('user')->check() && $request->is('user/*')) {
            return $next($request);
        }

        toast('Akses anda ditolak!', 'error')->timerProgressBar()->autoClose(5000);
        return Auth::guard('admin')->check() ? redirect()->route('admin.dashboard') : redirect()->route('user.dashboard');
    }
}
