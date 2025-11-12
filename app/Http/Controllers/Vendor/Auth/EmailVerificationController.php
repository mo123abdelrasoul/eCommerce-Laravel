<?php

namespace App\Http\Controllers\Vendor\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function notice()
    {
        return view('vendor.auth.verify-email');
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect()->route('vendor.dashboard', app()->getLocale())
            ->with('message', 'Your email has been verified.');
    }

    public function resend(Request $request)
    {
        $request->user('vendors')->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    }
}
