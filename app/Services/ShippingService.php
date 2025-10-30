<?php

namespace App\Services;

use App\Models\City;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\VendorShippingRate;

class ShippingService
{
    public function calculate($checkoutData)
    {
        $cart = session()->get('cart', []);
        $vendorsData = $this->prepareVendorCarts($cart);
        $regionId = $this->getRegionIdByCity($checkoutData['city']);
        $shippingMethodId = $checkoutData['shipping_method'];
        return $this->calculateCartShipping($vendorsData, $regionId, $shippingMethodId);
    }

    public function prepareVendorCarts(array $cart): array
    {
        if (empty($cart)) {
            return ['products' => [], 'totals' => []];
        }
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
        $vendorProductsCart = [];
        $vendorCartTotal = [];
        foreach ($cart as $productId => $qty) {
            if (!isset($products[$productId])) continue;
            $product = $products[$productId];
            $vendorId = $product->vendor_id;
            $discountedPrice = max(0, $product->price - $product->discount);
            $vendorProductsCart[$vendorId][] = [
                'id' => $productId,
                'name' => $product->name,
                'originalPrice' => $product->price,
                'discountedPrice' => $discountedPrice,
                'quantity' => $qty,
                'weight' => $product->weight,
                'height' => $product->height,
                'width' => $product->width,
                'length' => $product->length,
            ];
            $vendorCartTotal[$vendorId] = ($vendorCartTotal[$vendorId] ?? 0) + ($discountedPrice * $qty);
        }
        return [
            'products' => $vendorProductsCart,
            'totals' => $vendorCartTotal
        ];
    }

    private function calculateVendorWeight(array $cartItems): float
    {
        $weight = 0;
        $divisor = config('shipping.default.volumetric_divisor', 5000);
        foreach ($cartItems as $item) {
            $realWeight = ($item['weight'] ?? 0) * $item['quantity'];
            $volumetricWeight = ((($item['height'] ?? 0) * ($item['width'] ?? 0) * ($item['length'] ?? 0)) / $divisor) * $item['quantity'];
            $weight += max($realWeight, $volumetricWeight);
        }
        return $weight;
    }

    private function checkVendorShippingMethod(Vendor $vendor, int $methodId): bool
    {
        return $vendor->shippingMethods->contains($methodId);
    }

    private function getVendorShippingRate(int $vendorId, int $methodId, int $regionId, float $weight)
    {
        return VendorShippingRate::where('vendor_id', $vendorId)
            ->where('shipping_method_id', $methodId)
            ->where('shipping_region_id', $regionId)
            ->where('min_weight', '<=', $weight)
            ->where(function ($query) use ($weight) {
                $query->where('max_weight', '>=', $weight)
                    ->orWhereNull('max_weight');
            })
            ->orderBy('min_weight', 'desc')
            ->first();
    }

    private function calculateCartShipping(array $vendorsData, int $regionId, int $shippingMethodId): array
    {
        $vendorIds = array_keys($vendorsData['products']);
        $vendorRates = [];
        $totalShipping = 0;
        foreach ($vendorIds as $vendorId) {
            $vendor = Vendor::with('shippingMethods')->find($vendorId);
            if (!$vendor) continue;
            if (!$this->checkVendorShippingMethod($vendor, $shippingMethodId)) {
                return [
                    'success' => false,
                    'message' => __("Vendor ({$vendor->name}) does not support the selected shipping method."),
                ];
            }
            $cartItems = $vendorsData['products'][$vendorId];
            $weight = $this->calculateVendorWeight($cartItems);
            $rate = $this->getVendorShippingRate($vendorId, $shippingMethodId, $regionId, $weight);
            if (!$rate) {
                return [
                    'success' => false,
                    'message' => __("Vendor ({$vendor->name}) does not shipping for this region and weight."),
                ];
            }
            $vendorRates[$vendorId] = (float) $rate->rate;
            $totalShipping += $rate->rate;
        }
        return [
            'success' => true,
            'rate' => $vendorRates,
            'total_weights' => array_map(fn($items) => $this->calculateVendorWeight($items), $vendorsData['products']),
            'total_shipping' => $totalShipping,
        ];
    }
    private function getRegionIdByCity($cityId)
    {
        return City::where('id', $cityId)->value('region_id') ?? 0;
    }
}
