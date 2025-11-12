<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\CouponUser;

class CouponValidator
{
    public function validate(Coupon $coupon, float $total, array $cartProducts = [], array $cartCategories = [], ?int $userId = null): array
    {
        $errors = [];
        if (!$coupon) {
            $errors[] = "Coupon not found.";
            return $errors;
        }
        if ($userId) {
            $couponUser = CouponUser::where('user_id', $userId)
                ->where('coupon_id', $coupon->id)
                ->first();

            if ($couponUser && $couponUser->times_used >= $coupon->usage_limit_per_user) {
                $errors[] = "You reached the maximum usage for this coupon.";
            }
        }
        if ($coupon->usage_limit !== null && $coupon->times_used >= $coupon->usage_limit) {
            $errors[] = "Coupon usage limit reached.";
        }
        if ($coupon->min_order_amount !== null && $coupon->min_order_amount > $total) {
            $errors[] = "Coupon applies only on minimum order of {$coupon->min_order_amount}.";
        }
        if ($coupon->max_order_amount !== null && $coupon->max_order_amount < $total) {
            $errors[] = "Coupon applies only on maximum order of {$coupon->max_order_amount}.";
        }
        if (!$coupon->applies_to_all_products && !empty($cartProducts)) {
            $excludedProducts = $coupon->excluded_product_ids ? json_decode($coupon->excluded_product_ids, true) : [];
            if (array_intersect($cartProducts, $excludedProducts)) {
                $errors[] = "Coupon cannot be applied to some products in your cart.";
            }
        }
        if (!$coupon->applies_to_all_categories && !empty($cartCategories)) {
            $excludedCategories = $coupon->excluded_category_ids ? json_decode($coupon->excluded_category_ids, true) : [];
            if (array_intersect($cartCategories, $excludedCategories)) {
                $errors[] = "Coupon cannot be applied to some categories in your cart.";
            }
        }
        return $errors;
    }
}
