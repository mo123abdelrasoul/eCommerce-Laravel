<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\CheckoutService;
use App\Services\ShippingService;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function getShippingRate(Request $request)
    {
        $validated = $request->validate([
            'city' => 'required|string|max:255',
            'shipping_method' => 'required|string|max:255',
        ]);
        session()->forget('shipping_rate');
        // $checkoutData = [
        //     'city' => $request->city,
        //     'shipping_method' => $request->shipping_method
        // ];
        $cart = session()->get('cart', []);
        $cartValidation = CheckoutService::validateCart($cart);
        if (!empty($cartValidation)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'cart validation failed',
                'shipping_rate' => null
            ], 422);
        }
        $cartTotal = CheckoutService::calculateCartTotal($cart);
        $shippingService = (new ShippingService())->calculate($cart, $validated, $cartTotal);
        if (!$shippingService['success']) {
            return response()->json([
                'status' => 'failed',
                'message' => 'shipping calculation failed',
                'shipping_rate' => null

            ], 422);
        }
        session()->put('shipping_rate', $shippingService['rate']);
        return response()->json([
            'status' => 'success',
            'message' => 'Shipping calculated successfully',
            'shipping_rate' => $shippingService['rate']
        ]);
    }
}
