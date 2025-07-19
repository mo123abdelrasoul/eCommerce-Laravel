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
        $path = $request->path();
        $segments = explode('/', trim($path, '/'));

        $lang = null;

        // Check if first segment is a valid language
        if (!empty($segments) && in_array($segments[0], ['en', 'ar'])) {
            $lang = $segments[0];
        }

        // If no valid language in URL but session has it
        if ($lang === null && session()->has('locale')) {
            $lang = session('locale');
            return redirect("/$lang" . $request->getRequestUri());
        }

        // If still no language at all, fallback to 'en'
        if ($lang === null) {
            $lang = 'en';
            return redirect("/$lang" . $request->getRequestUri());
        }

        // Set locale and continue
        App::setLocale($lang);
        session(['locale' => $lang]); // Sync the session too

        return $next($request);
    }
}
