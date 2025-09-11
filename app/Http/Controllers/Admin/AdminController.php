<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => [
                'required',
                'email',
                'exists:admins,email'
            ],
            'password' => 'required|min:6'
        ]);

        $remember = $request->has('remember');
        if (Auth::guard('admins')->attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']], $remember)) {
            $vendor = Auth::guard('admins')->user();
            if (!is_null($vendor->deleted_at)) {
                Auth::guard('admins')->logout();
                return back()->with('error', 'Your account has been deactivated. Please contact support.');
            }
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Invalid email or password');
    }

    public function logout(Request $request)
    {
        $admin = Auth::guard('admins')->user();
        if (!$admin) {
            return redirect()->route('admin.login');
        }
        Auth::guard('admins')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
