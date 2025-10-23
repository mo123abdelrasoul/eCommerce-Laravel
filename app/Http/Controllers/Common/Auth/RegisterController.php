<?php

namespace App\Http\Controllers\Common\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /* Start Show Register Form */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('home', ['lang' => app()->getLocale()]);
        }
        return view('common.auth.register');
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
        }
    }
    /* End Handle Register Form */
}
