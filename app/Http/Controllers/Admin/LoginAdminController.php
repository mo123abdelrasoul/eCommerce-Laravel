<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginAdminController extends Controller
{

    public function ShowAdminLoginForm()
    {
        return view('admin.login');
    }
    public function AdminLoginForm(Request $request)
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
}
