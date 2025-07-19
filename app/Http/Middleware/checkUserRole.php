<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class checkUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (Auth::guard('vendors')->check() && $role == 'vendor') {
            return $next($request);
        }
        if (Auth::guard('admins')->check() && $role == 'admin') {
            return $next($request);
        }
        if (Auth::guard('web')->check() && $role == 'user') {
            return $next($request);
        }
        if ($role == 'user') {
            return redirect()->guest(route('login'));
        }
        if ($role == 'vendor') {
            return redirect()->guest(route('vendor.login'));
        }
        if ($role == 'admin') {
            return redirect()->guest(route('admin.login'));
        }
    }
}
