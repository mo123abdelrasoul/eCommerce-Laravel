<?php

namespace App\Services;

use App\Models\Coupon;

class CouponDiscountCalculator
{
    public function calculate(Coupon $coupon, float $total, array $cartProducts = []): float
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
