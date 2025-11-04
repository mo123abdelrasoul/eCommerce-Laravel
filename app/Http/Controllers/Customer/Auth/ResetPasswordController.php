<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    protected function broker()
    {
        return Password::broker('users');
    }
    protected function guard()
    {
        return Auth::guard('users');
    }
    public function showResetForm(Request $request, $token = null)
    {
        return view('customer.auth.passwords.reset')->with(
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
                $user->save();
            }
        );
        return $status == Password::PASSWORD_RESET
            ? redirect()->route('user.login', app()->getLocale())->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
