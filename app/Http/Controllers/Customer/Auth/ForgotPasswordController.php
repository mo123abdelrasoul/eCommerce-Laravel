<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('customer.auth.passwords.email');
    }

    public function sendResetLinkEmail($lang, Request $request)
    {
        $request->validate(['email' => 'required|email']);

        try {
            $status = app('auth.password.broker')->sendResetLink(
                $request->only('email')
            );
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Unable to send reset link. Please try again later.' . $e->getMessage()]);
        }
        return back()->with('status', 'We have emailed your password reset link!');
    }
}
