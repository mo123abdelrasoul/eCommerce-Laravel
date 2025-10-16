<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\CouponUser;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutService
{
    protected $paymentService;
    protected $orderService;
    protected $shippingService;
    protected $couponService;

    public function __construct(PaymentService $paymentService, OrderService $orderService, ShippingService $shippingService, CouponService $couponService)
    {
        $this->paymentService = $paymentService;
        $this->orderService = $orderService;
        $this->shippingService = $shippingService;
        $this->couponService = $couponService;
    }
    public function handle($checkoutData, $cart)
    {
        $cartErrors = $this->validateCart($cart);
        if (!empty($cartErrors)) {
            return [
                'success' => false,
                'errors' => $cartErrors
            ];
        }
        $vendorCart = $this->shippingService->prepareVendorCarts($cart);
        $coupon = ['discount' => 0, 'vendor_id' => null];
        if (!empty($checkoutData['coupon_code'])) {
            $coupon = $this->couponService->applyCoupon(
                $vendorCart['totals'],
                $checkoutData['coupon_code'],
                $cart
            );
        }
        $shipping = $this->shippingService->calculate($checkoutData);
        $orders = $this->orderService->createPendingOrder($checkoutData, $coupon, $shipping, $vendorCart);
        $payment = $this->paymentService->process($orders['totalAmount'], $checkoutData);
        if ($payment['success']) {
            return redirect()->away($payment['payment_url']);
        } else {
            dd($payment['message']);
        }
    }
    public function validateCart($cart)
    {
        $cart = session()->get('cart', []);
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
}
