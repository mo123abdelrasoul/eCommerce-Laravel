<?php

namespace App\Http\Controllers\Common\Localization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function changeLanguage($language)
    {
        if (in_array($language, ['en', 'ar'])) {
            session(['locale' => $language]);
            App::setLocale($language);

            // Get previous URL and replace the lang segment
            $previousUrl = url()->previous();
            $parsed = parse_url($previousUrl);
            $segments = explode('/', $parsed['path']);
            if (in_array($segments[1] ?? '', ['en', 'ar'])) {
                $segments[1] = $language;
            } else {
                array_splice($segments, 1, 0, $language);
            }
            return redirect(implode('/', $segments));
        }
        return redirect()->back();
    }
}
