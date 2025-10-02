<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Product;
use App\Models\ShippingMethod;
use App\Services\Customer\CheckoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function showCheckoutForm($lang)
    {
        $products = Product::select('id', 'name', 'image', 'price')->whereIn('id', array_keys(Session::get('cart', [])))->get();
        $cities = City::select('id', 'name')->where('is_active', true)->get();
        $shipping_methods = ShippingMethod::select('id', 'name', 'description')->where('is_active', true)->get();
        if ($products->isEmpty()) {
            return Redirect::route('cart.index', app()->getLocale())->with('error', __('Your cart is empty. Please add items to your cart before proceeding to checkout.'));
        }
        return view('user.checkout.index', compact('products', 'cities', 'shipping_methods'));
    }
    public function process($lang, Request $request)
    {
        $user = Auth::guard('web')->user();
        if (!$user) {
            return back()->with('error', 'You Must Login First.');
        }
        $cart = Session::get('cart', []);
        $checkoutData = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email',
            'phone' => 'required|digits_between:10,15',
            'address' => 'nullable|string|max:1000',
            'coupon_code' => 'nullable|string|max:255',
            'city' => 'required|integer',
            'shipping_method' => 'required|integer'
        ]);
        $data = (new CheckoutService())->handle($cart, $checkoutData);
    }
}
