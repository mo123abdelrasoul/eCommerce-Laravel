<?php

namespace App\Services\Customer;

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
        $couponCode = $checkoutData['coupon'] ?? null;
        $z = array_keys($cart);
        $cartCategories = Product::whereIn('id', $cartProducts)->pluck('category_id')->toArray();
        $userId = Auth::id();
        $couponResult = $this->applyCoupon($cartTotal, $couponCode, $cartProducts, $cartCategories, $userId);
        if (!$couponResult['success']) {
            return [
                'success' => false,
                'errors' => $couponResult['errors']
            ];
        }
        $shippingResult = $this->shippingService->calculate($cart, $checkoutData, $cartTotal);
        if (!$shippingResult['success']) {
            return [
                'success' => false,
                'errors' => $shippingResult['errors']
            ];
        }
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
    private function applyCoupon($cartTotal, $couponCode = null, $cartProducts = [], $cartCategories = [], $userId = null)
    {
        if (!$couponCode) {
            return [
                'success' => true,
                'total' => $cartTotal,
                'discountAmount' => 0,
            ];
        }
        $coupon = Coupon::where('code', $couponCode)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('approval_status', 'approved')
            ->where('status', 'active')
            ->first();
        if (!$userId && Auth::check()) {
            $userId = Auth::id();
        }
        $couponErrors = $this->validateCoupon($cartTotal, $coupon, $cartProducts, $cartCategories, $userId);
        if (!empty($couponErrors)) {
            return [
                'success' => false,
                'errors' => $couponErrors
            ];
        }
        $discountAmount = $this->calculateDiscountAmount($cartTotal, $coupon, $cartProducts);
        $cartTotal -= $discountAmount;
        return [
            'success' => true,
            'total' => $cartTotal,
            'discountAmount' => $discountAmount,
        ];
    }
    private function validateCoupon($total, $coupon, $cartProducts = [], $cartCategories = [], $userId = null)
    {
        $errors = [];
        if (!$coupon) {
            $errors[] = "Your coupon code unavailable";
            return $errors;
        }
        $couponUser = null;
        if ($userId) {
            $couponUser = CouponUser::where('user_id', $userId)
                ->where('coupon_id', $coupon->id)
                ->first();
        }
        if ($couponUser && $couponUser->times_used >= $coupon->usage_limit_per_user) {
            $errors[] = 'You reached the maximum usage for this coupon.';
        }
        if ($coupon->usage_limit !== null && $coupon->times_used >= $coupon->usage_limit) {
            $errors[] = "Your coupon code ({$coupon->code}) has expired (usage limit reached).";
        }
        if ($coupon->min_order_amount !== null && $coupon->min_order_amount > $total) {
            $errors[] = "Coupon Apply only on minimum Order {$coupon->min_order_amount}";
        }
        if ($coupon->max_order_amount !== null && $coupon->max_order_amount < $total) {
            $errors[] = "Coupon Apply only on maximum Order {$coupon->max_order_amount}";
        }
        if (!$coupon->applies_to_all_products && !empty($cartProducts)) {
            $excluded_products = $coupon->excluded_product_ids ? json_decode($coupon->excluded_product_ids, true) : [];
            if (array_intersect($cartProducts, $excluded_products)) {
                $errors[] = "This coupon cannot be applied to some of your products.";
            }
        }
        if (!$coupon->applies_to_all_categories && !empty($cartCategories)) {
            $excludedCategories = $coupon->excluded_category_ids ? json_decode($coupon->excluded_category_ids, true) : [];
            if (array_intersect($cartCategories, $excludedCategories)) {
                $errors[] = "This coupon cannot be applied to some of your categories.";
            }
        }
        return $errors;
    }
    private function calculateDiscountAmount($total, $coupon, $cartProducts)
    {
        $discountAmount = 0;
        if ($coupon->discount_type == 'percentage') {
            $discountAmount = $total * ($coupon->discount_value / 100);
            if ($coupon->max_discount && $discountAmount > $coupon->max_discount) {
                $discountAmount = $coupon->max_discount;
            }
        } elseif ($coupon->discount_type == 'fixed_cart') {
            $discountAmount = $coupon->discount_value;
        } elseif ($coupon->discount_type == 'fixed_product') {
            $cartItemsCount = count($cartProducts);
            $discountAmount = $coupon->discount_value * $cartItemsCount;
        }
        return $discountAmount;
    }
}
