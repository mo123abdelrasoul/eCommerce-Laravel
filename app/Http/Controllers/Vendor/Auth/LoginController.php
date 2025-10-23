<?php

namespace App\Http\Controllers\Vendor\Auth;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('vendors')->check()) {
            return redirect()->route('vendor.dashboard', ['lang' => app()->getLocale()]);
        }
        return view('vendor.auth.login');
    }
    public function dashboard()
    {
        $vendor = Auth::guard('vendors')->user();
        if (!$vendor) {
            return redirect()->route('vendor.login');
        }
        $orders = Order::with(['customer:id,name'])->where('vendor_id', $vendor->id)->get();
        $total_orders = 0;
        if (!$orders->isEmpty()) {
            foreach ($orders as $order) {
                $total_orders += $order->total_amount;
            }
        }
        $ordersCount = Order::where('vendor_id', $vendor->id)->count();
        $productsCount = Product::where('vendor_id', $vendor->id)->count();
        return view('vendor.dashboard', compact('orders', 'ordersCount', 'productsCount', 'total_orders'));
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
        $vendor = Vendor::where('email', $validatedData['email'])->first();
        if (!$vendor) {
            return back()->with('error', 'Invalid email or password');
        }
        if ($vendor->trashed()) {
            return back()->with('error', 'Your account has been deactivated.');
        }
        if (Hash::check($validatedData['password'], $vendor->password)) {
            return back()->with('error', 'Invalid email or password');
        }
        Auth::guard('vendors')->login($vendor, $remember);
        return redirect()->intended(route('vendor.dashboard', ['lang' => app()->getLocale()]));
    }

    public function logout($lang, Request $request)
    {
        // dd($lang, $request);
        $vendor = Auth::guard('vendors')->user();
        if (!$vendor) {
            return redirect()->route('vendor.login');
        }
        Auth::guard('vendors')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('vendor.login', app()->getLocale());
    }
}
