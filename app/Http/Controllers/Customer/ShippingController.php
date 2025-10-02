<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\Customer\CheckoutService;
use App\Services\Customer\ShippingService;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function getShippingRate(Request $request)
    {
        $checkoutData = [
            'city' => $request->city,
            'shipping_method' => $request->shipping_method
        ];
        $cart = session()->get('cart', []);
        $cartValidation = CheckoutService::validateCart($cart);
        if (!empty($cartValidation)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'cart validation failed'
            ]);
        }
        $cartTotal = CheckoutService::calculateCartTotal($cart);
        $shippingService = (new ShippingService())->calculate($cart, $checkoutData, $cartTotal);
        if (!$shippingService['success']) {
            return response()->json([
                'status' => 'failed',
                'message' => 'shipping calculation failed'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => $shippingService['rate']
        ]);
    }
}
