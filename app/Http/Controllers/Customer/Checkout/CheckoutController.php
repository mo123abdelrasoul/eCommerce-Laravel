<?php

namespace App\Http\Controllers\Customer\Checkout;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ShippingMethod;
use App\Services\CheckoutService;
use App\Services\CouponService;
use App\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected $checkoutService;
    protected $shippingService;
    protected $couponService;
    public function __construct(CheckoutService $checkoutService, ShippingService $shippingService, CouponService $couponService)
    {
        $this->checkoutService = $checkoutService;
        $this->shippingService = $shippingService;
        $this->couponService = $couponService;
    }
    public function showCheckoutForm($lang)
    {
        $products = Product::select('id', 'name', 'image', 'price')->whereIn('id', array_keys(Session::get('cart', [])))->get();
        if ($products->isEmpty()) {
            return Redirect::route('cart.index', app()->getLocale())->with('error', __('Your cart is empty. Please add items to your cart before proceeding to checkout.'));
        }
        return response()
            ->view('customer.checkout.index', [
                'products' => $products,
                'cities' => City::active()->select('id', 'name')->get(),
                'shipping_methods' => ShippingMethod::active()->select('id', 'name', 'description')->get(),
                'payment_methods' => PaymentMethod::select('id', 'name')->get(),
            ])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
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
        $checkout = $this->checkoutService->handle($checkoutData, $cart);
        if (is_array($checkout) && isset($checkout['success']) && $checkout['success'] === false) {
            return redirect()->back()
                ->with('error', true)
                ->with('message', $checkout['message'] ?? 'Something went wrong');
        }
        if (is_array($checkout) && isset($checkout['redirect_url'])) {
            return redirect()->away($checkout['redirect_url']);
        }
        if (is_array($checkout) && isset($checkout['success']) && $checkout['success'] === true) {
            return redirect()->route('user.checkout.success', ['lang' => $lang])
                ->with('success', true)
                ->with('message', $checkout['message'] ?? 'Order placed successfully.');
        }
        return redirect()->back()
            ->with('error', true)
            ->with('message', 'Unexpected checkout response.');
    }
    public function applyCoupon($lang, Request $request)
    {
        $validation = $request->validate([
            'coupon_code' => 'required|string|max:255',
            'total' => 'required|numeric|min:0',
            'shipping' => 'nullable|numeric|min:0'
        ]);
        $cart = Session::get('cart', []);
        $vendorCart = $this->shippingService->prepareVendorCarts($cart);
        $couponResult = $this->couponService->applyCoupon(
            $vendorCart['totals'],
            $validation['coupon_code'],
            $cart
        );
        $subtotal = $validation['total'];
        $shipping = $validation['shipping'] ?? 0;
        $discount = $couponResult['discount'] ?? 0;
        $finalTotal = max(0, ($subtotal + $shipping - $discount));
        if ($couponResult['status'] === 'failed') {
            return response()->json([
                'status' => 'failed',
                'message' => $couponResult['message'],
                'formatted' => [
                    'discount' => format_currency(0),
                    'total' => format_currency($subtotal + $shipping),
                ],
            ], 400);
        }
        return response()->json([
            'status' => 'success',
            'message' => $couponResult['message'],
            'discount' => $discount,
            'formatted' => [
                'discount' => '-' . format_currency($discount),
                'total' => format_currency($finalTotal),
            ],
        ]);
    }

    public function success($lang)
    {
        return view('customer.checkout.success', [
            'message' => session('message', 'Your order has been placed successfully!'),
        ]);
    }
}
