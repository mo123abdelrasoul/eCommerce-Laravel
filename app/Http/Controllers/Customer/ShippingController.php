<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\CheckoutService;
use App\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShippingController
{
    protected $checkoutService;
    protected $shippingService;

    public function __construct(CheckoutService $checkoutService, ShippingService $shippingService)
    {
        $this->checkoutService = $checkoutService;
        $this->shippingService = $shippingService;
    }
    public function getShippingRate(Request $request)
    {
        $validated = $request->validate([
            'city' => 'required|integer',
            'shipping_method' => 'required|integer',
        ]);
        $cart = Session::get('cart', []);
        $cartValidation = $this->checkoutService->validateCart($cart);
        if (!empty($cartValidation)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'cart validation failed',
                'shipping_rate' => null
            ], 422);
        }
        $shippingService = $this->shippingService->calculate($validated);
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
            'total_shipping' => $shippingService['total_shipping']
        ]);
    }
}
