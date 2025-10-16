<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\CouponUser;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CouponService
{
    public function applyCoupon($vendorCartTotals, $couponCode = null, $cart)
    {
        if (!$couponCode) {
            return [
                'status' => 'failed',
                'message' => 'No coupon code provided',
            ];
        }
        $userId = Auth::id();
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
        if (!empty($coupon->vendor_id)) {
            return $this->applyVendorCoupon($vendorCartTotals, $coupon, $cart, $userId);
        }
        return $this->applyGlobalCoupon($vendorCartTotals, $coupon, $cart, $userId);
    }

    private function applyVendorCoupon($vendorCartTotals, $coupon, $cart, $userId)
    {
        $vendorProductsData = Product::whereIn('id', array_keys($cart))
            ->where('vendor_id', $coupon->vendor_id)
            ->get(['id', 'category_id']);
        $vendorProducts = $vendorProductsData->pluck('id')->toArray();
        $vendorCategories = $vendorProductsData->pluck('category_id')->toArray();
        $vendorTotal = $vendorCartTotals[$coupon->vendor_id] ?? 0;
        $couponErrors = $this->validateCoupon($vendorTotal, $coupon, $vendorProducts, $vendorCategories, $userId);
        if (!empty($couponErrors)) {
            return [
                'status' => 'failed',
                'message' => 'Coupon validation failed',
            ];
        }
        $discountAmount = $this->calculateDiscountAmount($vendorTotal, $coupon, $vendorProducts);
        if ($discountAmount <= 0) {
            return [
                'status' => 'failed',
                'message' => 'Coupon not applicable to the current cart.',
            ];
        }
        return [
            'status' => 'success',
            'message' => 'Coupon applied successfully',
            'vendor_id' => $coupon->vendor_id,
            'discount' => $discountAmount,
        ];
    }

    private function applyGlobalCoupon($vendorCartTotals, $coupon, $cart, $userId)
    {
        $cartProducts = array_keys($cart);
        $cartCategories = Product::whereIn('id', $cartProducts)->pluck('category_id')->toArray();
        $cartTotals = array_sum($vendorCartTotals);
        $couponErrors = $this->validateCoupon($cartTotals, $coupon, $cartProducts, $cartCategories, $userId);
        if (!empty($couponErrors)) {
            return [
                'status' => 'failed',
                'message' => 'Coupon validation failed',
            ];
        }
        $discountAmount = $this->calculateDiscountAmount($cartTotals, $coupon, $cartProducts);
        if ($discountAmount <= 0) {
            return [
                'status' => 'failed',
                'message' => 'Coupon not applicable to the current cart.',
            ];
        }
        return [
            'status' => 'success',
            'message' => 'Coupon applied successfully',
            'vendor_id' => null,
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
        switch ($coupon->discount_type) {
            case 'percentage':
                $discountAmount = $total * ($coupon->discount_value / 100);
                if ($coupon->max_discount && $discountAmount > $coupon->max_discount) {
                    $discountAmount = $coupon->max_discount;
                }
                break;

            case 'fixed_cart':
                $discountAmount = min($coupon->discount_value, $total);
                break;

            case 'fixed_product':
                $discountAmount = $coupon->discount_value * count($cartProducts);
                break;
        }
        return max(0, $discountAmount);
    }
}
