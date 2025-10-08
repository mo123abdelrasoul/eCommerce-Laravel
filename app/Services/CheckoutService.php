<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\CouponUser;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CheckoutService
{
    protected $paymentService;
    protected $orderService;
    protected $shippingService;

    public function __construct(PaymentService $paymentService, OrderService $orderService, ShippingService $shippingService)
    {
        $this->paymentService = $paymentService;
        $this->orderService = $orderService;
        $this->shippingService = $shippingService;
    }
    public function handle($cart, $checkoutData)
    {
        $cartErrors = $this->validateCart($cart);
        if (!empty($cartErrors)) {
            return [
                'success' => false,
                'errors' => $cartErrors
            ];
        }
        $cartTotal = $this->calculateCartTotal($cart);
        $order = $this->orderService->handle($cart, $cartTotal, $checkoutData);
        // $couponCode = $checkoutData['coupon'] ?? null;
        // $cartProducts = array_keys($cart);
        // $cartCategories = Product::whereIn('id', $cartProducts)->pluck('category_id')->toArray();
        // $userId = Auth::id();
        // $couponResult = $this->applyCoupon($cartTotal, $couponCode, $cartProducts, $cartCategories, $userId);
        // if (!$couponResult['success']) {
        //     return [
        //         'success' => false,
        //         'errors' => $couponResult['errors']
        //     ];
        // }
        // $shippingResult = $this->shippingService->calculate($cart, $checkoutData, $cartTotal);
        // if (!$shippingResult['success']) {
        //     return [
        //         'success' => false,
        //         'errors' => $shippingResult['errors']
        //     ];
        // }
    }
    public static function validateCart($cart)
    {
        $errors = [];
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
        foreach ($cart as $productId => $qty) {
            if (!isset($products[$productId])) {
                $errors[] = "Product with ID {$productId} not found.";
                continue;
            }
            $product = $products[$productId];
            $validQty = filter_var($qty, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);
            if ($validQty === false) {
                $errors[] = "Invalid quantity for {$product->name}.";
                continue;
            }
            if ($qty > $product->quantity) {
                $errors[] = "Not enough stock for {$product->name}.";
                continue;
            }
            if ($product->status !== 'approved') {
                $errors[] = "{$product->name} is not available.";
                continue;
            }
        }
        return $errors;
    }
    public static function calculateCartTotal($cart)
    {
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
        $total = 0;
        foreach ($cart as $productId => $qty) {
            $productAfterDiscount = $products[$productId]->price * (1 - ($products[$productId]->discount / 100));
            $total += $productAfterDiscount * $qty;
        }
        return $total;
    }
}
