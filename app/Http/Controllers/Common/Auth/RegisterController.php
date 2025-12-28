<?php

namespace App\Http\Controllers\Common\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('home', ['lang' => app()->getLocale()]);
        }
        return view('common.auth.register');
    }

    public function registerForm(Request $request)
    {
        $role = $request->input('role');
        $validatedData = $request->validate(
            [
                'name' => 'required|max:255|min:3|string',
                'email' => [
                    'required',
                    'email',
                    $role === 'customer'
                        ? Rule::unique('users', 'email')
                        : Rule::unique('vendors', 'email')
                ],
                'password' => 'required|min:6|confirmed',
                'phone' => 'required|digits_between:10,15',
                'role' => 'required|in:customer,vendor'
            ]
        );
        if ($validatedData['role'] == 'customer') {
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'phone' => $validatedData['phone'],
            ]);
            return redirect()->route('user.login', ['lang' => app()->getLocale()]);
        }
        if ($validatedData['role'] == 'vendor') {
            $vendor = Vendor::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'phone' => $validatedData['phone'],
            ]);
            event(new Registered($vendor));
            auth('vendors')->login($vendor);
            return redirect()->route('vendor.verification.notice', ['lang' => app()->getLocale()])
                ->with('message', 'A verification link has been sent to your email.');
        }
    }
}
