<?php

namespace App\Http\Controllers\Vendor\Auth;

use App\Http\Controllers\Controller;
use App\Services\VendorAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $authService;

    public function __construct(VendorAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginForm()
    {
        if (Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.dashboard', app()->getLocale());
        }
        return view('vendor.auth.login');
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        $remember = $request->has('remember');
        $result = $this->authService->attemptLogin(
            $validatedData['email'],
            $validatedData['password']
        );
        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }
        Auth::guard('vendors')->login($result['vendor'], $remember);
        return redirect()->route('vendor.dashboard', app()->getLocale());
    }

    public function logout(Request $request)
    {
        Auth::guard('vendors')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('vendor.login', app()->getLocale());
    }
}
