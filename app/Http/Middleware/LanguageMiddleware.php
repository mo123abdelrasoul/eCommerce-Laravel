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
    public function handle(Request $request, Closure $next): Response
    {
        $url = $request->path();
        $segments = explode('/', trim($url, '/'));
        $supported = ['en', 'ar'];

        if (!empty($segments) && in_array($segments[0], $supported)) {
            $lang = $segments[0];
        } else {
            // لو مفيش لغة في URL، حدد default
            $lang = 'en';
            // عمل redirect URL بنفس المسار مع إضافة اللغة
            $newUrl = '/' . $lang . ($url !== '/' ? '/' . $url : '');
            return redirect($newUrl);
        }

        App::setLocale($lang);
        session(['locale' => $lang]);

        return $next($request);
        // $url = $request->path();
        // $segments = explode('/', trim($url, '/'));
        // $supported = ['en', 'ar'];
        // if (!empty($segments) && in_array($segments[0], $supported)) {
        //     $lang = $segments[0];
        // } else {
        //     $lang = 'en';
        // }
        // App::setLocale($lang);
        // session(['locale' => $lang]);
        // return $next($request);
    }
}
