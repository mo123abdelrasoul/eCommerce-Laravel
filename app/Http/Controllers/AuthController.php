<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

// use Illuminate\Validation\ValidationException

class AuthController extends Controller
{

    /* Start Show Register Form */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('home', ['lang' => app()->getLocale()]);
        }
        return view('register');
    }
    /* End Show Register Form */


    /* Start Handle Register Form */
    public function registerForm(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|max:255|min:3|string',
                'email' => 'required|email',
                'password' => 'required|min:6|confirmed',
                'phone' => 'required|digits_between:10,15',
                'role' => 'required'
            ]
        );
        if ($validatedData['role'] == 'customer') {
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'phone' => $validatedData['phone'],
            ]);
            return redirect()->route('login', ['lang' => app()->getLocale()]);
            // return redirect()->route('login');
        }
        if ($validatedData['role'] == 'vendor') {
            $vendor = Vendor::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'phone' => $validatedData['phone'],
            ]);
            return redirect()->route('vendor.login', ['lang' => app()->getLocale()]);
            // return redirect()->route('vendor.login');
        }
    }
    /* End Handle Register Form */


    /* Start Show Login Form */
    public function ShowUserLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('home', ['lang' => app()->getLocale()]);
        }
        return view('user.login', ['lang' => app()->getLocale()]);
    }

    public function UserLoginForm(Request $request)
    {
        $validatedData = $request->validate([
            'email' => [
                'required',
                'email',
                'exists:users,email'
            ],
            'password' => 'required|min:6'
        ]);

        $remember = $request->has('remember');
        if (Auth::guard('web')->attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']], $remember)) {
            $user = Auth::guard('web')->user();
            if (!is_null($user->deleted_at)) {
                Auth::guard('web')->logout();
                return back()->with('error', 'Your account has been deactivated. Please contact support.');
            }
            return redirect()->route('home', ['lang' => app()->getLocale()]);
        }
        return back()->with('error', 'Invalid email or password');
    }
    /* End Show Login Form */


    /* Start Logout Form */


    public function logout(Request $request)
    {
        if (Auth::guard('admins')->check()) {
            Auth::guard('admins')->logout();
            return redirect()->route('admin.login', ['lang' => app()->getLocale()]);
        }
        if (Auth::guard('vendors')->check()) {
            Auth::guard('vendors')->logout();
            return redirect()->route('vendor.login', ['lang' => app()->getLocale()]);
        }
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            return redirect()->route('login', ['lang' => app()->getLocale()]);
        }
        return redirect()->route('login', ['lang' => app()->getLocale()]);
    }


    /* End Logout Form */
}
