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
}
