<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCustomerPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        $customer = auth()->guard('web')->user();
        if (!$customer) {
            return redirect()->route('user.login', app()->getLocale());
        }
        if (!$customer->hasRole('customer') || !$customer->can($permission)) {
            abort(403, 'Unauthorized');
        }
        return $next($request);
    }
}
