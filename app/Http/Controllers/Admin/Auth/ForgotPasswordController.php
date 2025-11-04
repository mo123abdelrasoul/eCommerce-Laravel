<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('admin.auth.passwords.email');
    }

    public function sendResetLinkEmail($lang, Request $request)
    {
        $request->validate(['email' => 'required|email']);

        try {
            $status = Password::broker('admins')->sendResetLink(
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
