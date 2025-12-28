<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        $admin = auth()->guard('admins')->user();

        if (!$admin) {
            return redirect()->route('admin.login', app()->getLocale());
        }

        if (
            !$admin->hasAnyRole(['admin', 'admin viewer']) ||
            !$admin->can($permission)
        ) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
