<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CouponService
{
    protected $validator;
    protected $calculator;

    public function __construct()
    {
        $this->validator = new CouponValidator();
        $this->calculator = new CouponDiscountCalculator();
    }

    public function applyCoupon(array $vendorCartTotals, ?string $couponCode, array $cart)
    {
        if (!$couponCode) {
            return ['status' => 'failed', 'message' => 'No coupon code provided'];
        }
        $userId = Auth::id();
        $coupon = Coupon::where('code', $couponCode)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('approval_status', 'approved')
            ->where('status', 'active')
            ->first();
        if (!$coupon) {
            return ['status' => 'failed', 'message' => 'Invalid or expired coupon code'];
        }
        if ($coupon->vendor_id) {
            return $this->applyVendorCoupon($vendorCartTotals, $coupon, $cart, $userId);
        } else {
            return $this->applyGlobalCoupon($vendorCartTotals, $coupon, $cart, $userId);
        }
    }

    private function applyVendorCoupon($vendorCartTotals, Coupon $coupon, $cart, $userId)
    {
        $vendorProductsData = Product::whereIn('id', array_keys($cart))
            ->where('vendor_id', $coupon->vendor_id)
            ->get(['id', 'category_id']);
        $vendorProducts = $vendorProductsData->pluck('id')->toArray();
        $vendorCategories = $vendorProductsData->pluck('category_id')->toArray();
        $vendorTotal = $vendorCartTotals[$coupon->vendor_id] ?? 0;
        $errors = $this->validator->validate($coupon, $vendorTotal, $vendorProducts, $vendorCategories, $userId);
        if ($errors) {
            return ['status' => 'failed', 'message' => implode(', ', $errors)];
        }
        $discountAmount = $this->calculator->calculate($coupon, $vendorTotal, $vendorProducts);
        if ($discountAmount <= 0) {
            return ['status' => 'failed', 'message' => 'Coupon not applicable to the current cart.'];
        }
        return [
            'status' => 'success',
            'message' => 'Coupon applied successfully',
            'id' => $coupon->id,
            'vendor_id' => $coupon->vendor_id,
            'discount' => $discountAmount,
        ];
    }

    private function applyGlobalCoupon($vendorCartTotals, Coupon $coupon, $cart, $userId)
    {
        $cartProducts = array_keys($cart);
        $cartCategories = Product::whereIn('id', $cartProducts)->pluck('category_id')->toArray();
        $cartTotal = array_sum($vendorCartTotals);
        $errors = $this->validator->validate($coupon, $cartTotal, $cartProducts, $cartCategories, $userId);
        if ($errors) {
            return ['status' => 'failed', 'message' => implode(', ', $errors)];
        }
        $discountAmount = $this->calculator->calculate($coupon, $cartTotal, $cartProducts);
        if ($discountAmount <= 0) {
            return ['status' => 'failed', 'message' => 'Coupon not applicable to the current cart.'];
        }
        return [
            'status' => 'success',
            'message' => 'Coupon applied successfully',
            'id' => $coupon->id,
            'vendor_id' => null,
            'discount' => $discountAmount,
        ];
    }

    public function createCoupon(array $data): ?Coupon
    {
        try {
            $data = $this->prepareCouponData($data);
            return Coupon::create($data);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function updateCoupon(Coupon $coupon, array $data): bool
    {
        try {
            $data = $this->prepareCouponData($data, $coupon->id);
            return $coupon->update($data);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function deleteCoupon(Coupon $coupon): bool
    {
        try {
            return $coupon->delete();
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function prepareCouponData(array $data, $couponId = null): array
    {
        $prepared = $data;

        if (!empty($data['excluded_product_ids'])) {
            $ids = array_filter(array_map('trim', explode(',', $data['excluded_product_ids'])));
            $prepared['excluded_product_ids'] = !empty($ids) ? json_encode($ids) : null;
        } else {
            $prepared['excluded_product_ids'] = null;
        }

        if (!empty($data['excluded_category_ids'])) {
            $ids = array_filter(array_map('trim', explode(',', $data['excluded_category_ids'])));
            $prepared['excluded_category_ids'] = !empty($ids) ? json_encode($ids) : null;
        } else {
            $prepared['excluded_category_ids'] = null;
        }

        return $prepared;
    }
}
