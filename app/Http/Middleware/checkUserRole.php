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
    public function handle(Request $request, Closure $next, $role)
    {
        $currentPath = $request->path();
        if (str_contains($currentPath, 'vendor-login') || str_contains($currentPath, 'vendor/')) {
            $determinedRole = 'vendor';
        } elseif (str_contains($currentPath, 'admin-login') || str_contains($currentPath, 'admin/')) {
            $determinedRole = 'admin';
        } elseif (str_contains($currentPath, 'user-login') || $currentPath === '/') {
            $determinedRole = 'user';
        } else {
            $determinedRole = $role;
        }
        $guards = [
            'vendor' => 'vendors',
            'admin' => 'admins',
            'user' => 'web'
        ];
        if (!array_key_exists($determinedRole, $guards)) {
            abort(403, 'Invalid role');
        }
        if (Auth::guard($guards[$determinedRole])->check()) {
            return $next($request);
        }
        $loginRoutes = [
            'vendor' => 'vendor.login',
            'admin' => 'admin.login',
            'user' => 'user.login'
        ];
        // dd($currentPath, $determinedRole, $guards, $loginRoutes[$determinedRole], ['lang' => app()->getLocale()]);


        return redirect()->guest(
            route($loginRoutes[$determinedRole], ['lang' => app()->getLocale()])
        );
    }
}
