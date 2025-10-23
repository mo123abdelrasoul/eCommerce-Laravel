<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        if (!Auth::guard('admins')->check()) {
            return view('admin.auth.login');
        }
        return redirect()->route('admin.dashboard');
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => [
                'required',
                'email',
            ],
            'password' => 'required|min:6'
        ]);
        $remember = $request->has('remember');
        $admin = Admin::where('email', $validatedData['email'])->first();
        if (!$admin) {
            return back()->with('error', 'Invalid email or password');
        }
        if ($admin->trashed()) {
            return back()->with('error', 'Your account has been deactivated.');
        }
        if (Hash::check($validatedData['password'], $admin->password)) {
            return back()->with('error', 'Invalid email or password');
        }
        Auth::guard('admins')->login($admin, $remember);
        return redirect()->intended(route('admin.dashboard', ['lang' => app()->getLocale()]));
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
        return redirect()->route('admin.login', app()->getLocale());
    }
}
