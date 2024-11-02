<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthtenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('user')->check()) {
            toast('Akses anda ditolak!','error')->timerProgressBar()->autoClose(5000);
            return redirect()->route('user.dashboard');
        } elseif (Auth::guard('admin')->check()) {
            toast('Akses anda ditolak!','error')->timerProgressBar()->autoClose(5000);
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
