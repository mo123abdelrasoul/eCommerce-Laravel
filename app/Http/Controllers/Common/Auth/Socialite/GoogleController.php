<?php

namespace App\Http\Controllers\Common\Auth\Socialite;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    protected string $provider = 'google';
    protected string $defaultPassword = 'my-google';

    public function redirect($lang, Request $request)
    {
        session(['social_redirect_url' => url()->previous()]);
        session(['social_login_type' => $request->get('type', 'user')]);
        return Socialite::driver($this->provider)->redirect();
    }

    public function callback()
    {
        try {
            $user = Socialite::driver($this->provider)->stateless()->user();
            $type = session('social_login_type', 'user');
            [$guard, $model, $route] = $this->getUserConfig($type);
            $findUser = $this->findOrCreateSocialUser($model, $user);
            Auth::guard($guard)->login($findUser);
            $redirectUrl = $this->getRedirectUrl($route);
            session()->forget(['social_redirect_url', 'social_login_type']);
            return redirect()->to($redirectUrl);
        } catch (Exception $e) {
            Log::error('Google login failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            session()->forget(['social_redirect_url', 'social_login_type']);
            return redirect()
                ->route($this->getLoginRoute(session('social_login_type', 'user')), [
                    'lang' => app()->getLocale(),
                ])
                ->with('error', 'Google login failed, please try again.');
        }
    }

    private function getUserConfig(string $type): array
    {
        return match ($type) {
            'vendor' => ['vendors', 'App\Models\Vendor', 'vendor.dashboard'],
            'admin' => ['admins', 'App\Models\Admin', 'admin.dashboard'],
            default  => ['web', 'App\Models\User', 'home'],
        };
    }

    private function findOrCreateSocialUser(string $model, $user)
    {
        $findUser = $model::where('social_id', $user->id)
            ->orWhere('email', $user->email)
            ->first();
        if ($findUser && !$findUser->social_id) {
            $findUser->update([
                'social_id'   => $user->id,
                'social_type' => $this->provider,
            ]);
        }
        if (!$findUser) {
            $findUser = $model::create([
                'name'        => $user->name,
                'email'       => $user->email,
                'social_id'   => $user->id,
                'social_type' => $this->provider,
                'password'    => Hash::make($this->defaultPassword),
            ]);
        }
        return $findUser;
    }

    private function getRedirectUrl(string $defaultRoute): string
    {
        return session('social_redirect_url')
            ?? session('url.intended')
            ?? route($defaultRoute, ['lang' => app()->getLocale()]);
    }

    private function getLoginRoute(string $type): string
    {
        return match ($type) {
            'vendor' => 'vendor.login',
            'admin'  => 'admin.login',
            default  => 'user.login',
        };
    }
}
