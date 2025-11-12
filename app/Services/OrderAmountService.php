<?php

namespace App\Services;

class OrderAmountService
{
    public function calculateTotal(
        array $vendorCart,
        array $coupon,
        array $shipping,
        int $vendorId
    ): array {
        $totalCartAmount = array_sum($vendorCart['totals']);
        $cartAmount = $vendorCart['totals'][$vendorId] ?? 0;
        $shippingCost = $shipping['rate'][$vendorId] ?? 0;
        $totalWeight = $shipping['total_weights'][$vendorId] ?? 0;

        $vendorDiscount = 0;
        $couponVendorId = $coupon['vendor_id'] ?? null;
        $discount = $coupon['discount'] ?? 0;

        if ($couponVendorId === null && $totalCartAmount > 0) {
            $vendorDiscount = $discount * ($cartAmount / $totalCartAmount);
        } elseif ($couponVendorId == $vendorId) {
            $vendorDiscount = $discount;
        }

        $totalAmount = ($cartAmount + $shippingCost) - $vendorDiscount;

        return [
            'sub_total' => $cartAmount,
            'shipping_cost' => $shippingCost,
            'discount_amount' => $vendorDiscount,
            'total_weight' => $totalWeight,
            'total_amount' => $totalAmount,
            'coupon_id' => $couponVendorId == $vendorId || $couponVendorId === null ? ($coupon['id'] ?? null) : null,
        ];
    }
}
