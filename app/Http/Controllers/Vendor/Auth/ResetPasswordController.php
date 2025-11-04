<?php

namespace App\Http\Controllers\Vendor\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    protected function broker()
    {
        return Password::broker('vendors');
    }
    protected function guard()
    {
        return Auth::guard('vendors');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('vendor.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset($lang, Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);
        $status = $this->broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->setRememberToken(Str::random(60));
                $user->save();
            }
        );
        return $status == Password::PASSWORD_RESET
            ? redirect()->route('vendor.login', app()->getLocale())->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
