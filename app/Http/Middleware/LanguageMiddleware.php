<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    protected $supported = ['en', 'ar'];

    public function handle(Request $request, Closure $next)
    {
        $segment = $request->segment(1);

        if (!in_array($segment, $this->supported)) {
            $lang = Session::get('locale', 'en');
            return redirect("/{$lang}{$request->getRequestUri()}");
        }

        App::setLocale($segment);
        Session::put('locale', $segment);

        return $next($request);
    }
}
