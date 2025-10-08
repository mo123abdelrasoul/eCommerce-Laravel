<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\CouponUser;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CouponService
{
    public function applyCoupon($cartTotal, $couponCode = null, $cartProducts = [], $cartCategories = [], $userId = null)
    {
        if (!$couponCode) {
            return [
                'status' => 'failed',
                'message' => 'No coupon code provided',
            ];
        }
        if (!$userId && Auth::check()) {
            $userId = Auth::id();
        }
        $coupon = Coupon::where('code', $couponCode)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('approval_status', 'approved')
            ->where('status', 'active')
            ->first();
        if (!$coupon) {
            return [
                'status' => 'failed',
                'message' => 'Invalid or expired coupon code',
            ];
        }
        $couponErrors = $this->validateCoupon($cartTotal, $coupon, $cartProducts, $cartCategories, $userId);
        if (!empty($couponErrors)) {
            return [
                'status' => 'failed',
                'message' => 'Coupon validation failed',
            ];
        }
        $discountAmount = $this->calculateDiscountAmount($cartTotal, $coupon, $cartProducts);
        if ($discountAmount <= 0) {
            return [
                'status' => 'failed',
                'message' => 'Coupon not applicable to the current cart.',
            ];
        }
        return [
            'status' => 'success',
            'message' => 'Coupon applied successfully',
            'discount' => $discountAmount,
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
