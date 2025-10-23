<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

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
}
