<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class LoginVendorController extends Controller
{

    public function index()
    {
        return view('vendor.login');
    }

    public function VendorLoginForm(Request $request)
    {
        $validatedData = $request->validate([
            'email' => [
                'required',
                'email',
                'exists:vendors,email'
            ],
            'password' => 'required|min:6'
        ]);
        $remember = $request->has('remember');
        if (Auth::guard('vendors')->attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']], $remember)) {
            $vendor = Auth::guard('vendors')->user();
            if (!is_null($vendor->deleted_at)) {
                Auth::guard('vendors')->logout();
                return back()->with('error', 'Your account has been deactivated. Please contact support.');
            }
            $orders = DB::table('orders')->where('vendor_id', $vendor->id)->get();
            // return redirect()->route('vendor.dashboard');
            return redirect()->intended(route('vendor.dashboard'));
        }
        return back()->with('error', 'Invalid email or password');
    }

    public function VendorLogoutForm($lang, Request $request)
    {
        $vendor = Auth::guard('vendors')->user();
        if (!$vendor) {
            return redirect()->route('vendor.login');
        }
        Auth::guard('vendors')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('vendor.login');
    }
}
