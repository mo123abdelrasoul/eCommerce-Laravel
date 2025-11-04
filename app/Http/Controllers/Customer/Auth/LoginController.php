<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        $featured_products = Product::where('status', 'approved')
            ->where('featured', true)
            ->limit(4)
            ->get();
        $best_selling_products = Product::where('status', 'approved')
            ->limit(7)
            ->get();
        return view('customer.pages.home', [
            'lang' => app()->getLocale(),
            'featured_products' => $featured_products,
            'best_selling_products' => $best_selling_products
        ]);
    }

    public function showLoginForm()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('home', ['lang' => app()->getLocale()]);
        }
        return view('customer.auth.login');
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
        $user = User::where('email', $validatedData['email'])->first();
        if (!$user) {
            return back()->with('error', 'Invalid email or password');
        }
        if ($user->trashed()) {
            return back()->with('error', 'Your account has been deactivated.');
        }
        if (!Hash::check($validatedData['password'], $user->password)) {
            return back()->with('error', 'Invalid email or password');
        }
        Auth::guard('web')->login($user, $remember);
        return redirect()->route('home', ['lang' => app()->getLocale()]);
    }

    public function logout(Request $request)
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            return redirect()->route('user.login', ['lang' => app()->getLocale()]);
        }
        return redirect()->route('user.login', ['lang' => app()->getLocale()]);
    }
}
