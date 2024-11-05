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

        if (Auth::guard('admin')->check()) {
            if ($request->is('admin/*')) {
                return $next($request);
            }
            toast('Hak akses anda ditolak!', 'error')->timerProgressBar()->autoClose(5000);
            return redirect()->route('admin.dashboard');
        }

        if (Auth::guard('user')->check()) {
            if ($request->is('user/*')) {
                return $next($request);
            }
            toast('Hak akses anda ditolak!', 'error')->timerProgressBar()->autoClose(5000);
            return redirect()->route('user.dashboard');
        }

        toast('Hak akses anda ditolak!', 'error')->timerProgressBar()->autoClose(5000);
        return redirect()->route('showLogin');
    }
}
