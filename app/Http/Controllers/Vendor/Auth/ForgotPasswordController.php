<?php

namespace App\Http\Controllers\Vendor\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('vendor.auth.passwords.email');
    }

    public function sendResetLinkEmail($lang, Request $request)
    {
        $request->validate(['email' => 'required|email']);

        try {
            $status = Password::broker('vendors')->sendResetLink(
                $request->only('email')
            );
            if ($status !== Password::RESET_LINK_SENT) {
                return back()->withErrors(['email' => __($status)]);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Unable to send reset link. Please try again later.' . $e->getMessage()]);
        }
        return back()->with('status', 'We have emailed your password reset link!');
    }
}
