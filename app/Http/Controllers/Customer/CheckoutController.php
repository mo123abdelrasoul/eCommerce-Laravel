<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ShippingMethod;
use App\Services\CheckoutService;
use App\Services\CouponService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected $checkoutService;
    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }
    public function showCheckoutForm($lang)
    {
        $products = Product::select('id', 'name', 'image', 'price')->whereIn('id', array_keys(Session::get('cart', [])))->get();
        $cities = City::select('id', 'name')->where('is_active', true)->get();
        $shipping_methods = ShippingMethod::select('id', 'name', 'description')->where('is_active', true)->get();
        $payment_methods = PaymentMethod::select('id', 'name')->get();
        if ($products->isEmpty()) {
            return Redirect::route('cart.index', app()->getLocale())->with('error', __('Your cart is empty. Please add items to your cart before proceeding to checkout.'));
        }
        return view('user.checkout.index', compact('products', 'cities', 'shipping_methods', 'payment_methods'));
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
            'street_number' => 'required|string|max:50',
            'street_name' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'notes' => 'nullable|string|max:1000',
            'coupon_code' => 'nullable|string|max:255',
            'city' => 'required|integer',
            'shipping_method' => 'required|integer',
            'payment_method' => 'required|integer'
        ]);
        $data = $this->checkoutService->handle($cart, $checkoutData);
    }
    public function applyCoupon($lang, Request $request, CheckoutService $checkoutService)
    {
        $validation = $request->validate([
            'coupon_code' => 'required|string|max:255',
            'total' => 'required|numeric|min:0'
        ]);
        if (session('coupon_code') === $validation['coupon_code']) {
            return response()->json([
                'status' => 'failed',
                'message' => 'This coupon is already applied.'
            ], 400);
        }
        session()->forget(['discount_value', 'coupon_code']);
        $cart = Session::get('cart', []);
        $cartProducts = array_keys($cart);
        $cartCategories = Product::whereIn('id', $cartProducts)->pluck('category_id')->toArray();
        $userId = Auth::id();
        $couponResult = (new CouponService())->applyCoupon(
            $validation['total'],
            $validation['coupon_code'],
            $cartProducts,
            $cartCategories,
            $userId
        );
        if ($couponResult['status'] === 'failed') {
            return response()->json([
                'status' => 'failed',
                'message' => $couponResult['message']
            ], 400);
        }
        session()->put('discount_value', $couponResult['discount']);
        session()->put('coupon_code', $validation['coupon_code']);
        return response()->json([
            'status' => 'success',
            'message' => $couponResult['message'],
            'discount' => $couponResult['discount'],
        ]);
    }
}
