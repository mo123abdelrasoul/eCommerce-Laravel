<?php

namespace App\Http\Controllers\Customer\Shipping;

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
            'subtotal' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
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
            \Illuminate\Support\Facades\Log::error('Shipping calculation failed', [
                'request' => $validated,
                'service_response' => $shippingService
            ]);
            return response()->json([
                'status' => 'failed',
                'message' => $shippingService['message'] ?? 'shipping calculation failed',
                'shipping_rate' => null
            ], 422);
        }
        $shipping = $shippingService['total_shipping'];
        $subtotal = $validated['subtotal'] ?? 0;
        $discount = $validated['discount'] ?? 0;
        $finalTotal = max(0, ($subtotal + $shipping - $discount));
        return response()->json([
            'status' => 'success',
            'message' => 'Shipping calculated successfully',
            'total_shipping' => $shipping,
            'formatted' => [
                'total_shipping' => format_currency($shipping),
                'total' => format_currency($finalTotal),
            ],
        ]);
    }
}
