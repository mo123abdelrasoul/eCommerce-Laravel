<?php

namespace App\Services;

use App\Models\City;
use App\Models\Product;
use App\Models\ShippingMethod;
use App\Models\ShippingPolicy;
use App\Models\ShippingRate;
use App\Models\Vendor;

class ShippingService
{
    public function calculate($checkoutData)
    {
        $cart = session()->get('cart', []);
        $vendorsData = $this->prepareVendorCarts($cart);
        $regionId = $this->getRegionIdByCity($checkoutData['city']);
        $shippingMethodId = $checkoutData['shipping_method'];
        $method = ShippingMethod::with('policy')->find($shippingMethodId);
        if (!$method || !$method->policy) {
            return ['success' => false, 'message' => 'Shipping policy not found.'];
        }
        $policy = $method->policy;
        $weights = $this->calculateWeights($vendorsData['products']);
        $rates = $this->calculateVendorRates($regionId, $shippingMethodId, $weights, $policy, $vendorsData['totals']);
        return [
            'success' => true,
            'rate' => $rates,
            'total_weights' => $weights,
            'total_shipping' => array_sum($rates),
        ];
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
            if (!isset($products[$productId])) {
                continue;
            }
            $product = $products[$productId];
            $vendorId = $product->vendor_id;
            $discountedPrice = $product->price - $product->discount;
            if ($discountedPrice < 0) {
                $discountedPrice = 0;
            }
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

    private function calculateWeights($vendorProductsCart): array
    {
        $realWeight = [];
        $volumetricWeight = [];
        $divisor = config('shipping.default.volumetric_divisor', 5000);
        foreach ($vendorProductsCart as $vendorId => $cart) {
            $realWeight[$vendorId] = 0;
            $volumetricWeight[$vendorId] = 0;
            foreach ($cart as $item) {
                $qty = $item['quantity'];
                $height = $item['height'] ?? 0;
                $width  = $item['width'] ?? 0;
                $length = $item['length'] ?? 0;
                $weight = $item['weight'] ?? 0;
                $realWeight[$vendorId] += $weight * $qty;
                $volumetricWeight[$vendorId] += (($height * $width * $length) / $divisor) * $qty;
            }
        }
        $finalWeight = [];
        foreach ($realWeight as $vendorId => $weight) {
            $finalWeight[$vendorId] = max($weight, $volumetricWeight[$vendorId]);
        }
        return $finalWeight;
    }

    private function calculateVendorRates($regionId, $methodId, array $weights, $policy, array $totals)
    {
        $vendorRates = [];
        foreach ($weights as $vendorId => $weight) {
            $rate = $this->getRateForVendor($regionId, $methodId, $weight);
            $vendorRates[$vendorId] = $rate ? (float) $rate->rate : $this->calculateRateByPolicy($policy, $weight, $totals[$vendorId]);
        }
        return $vendorRates;
    }

    private function getRateForVendor($regionId, $methodId, $weight)
    {
        return ShippingRate::where('shipping_region_id', $regionId)
            ->where('shipping_method_id', $methodId)
            ->where('min_weight', '<=', $weight)
            ->where(function ($query) use ($weight) {
                $query->where('max_weight', '>=', $weight)
                    ->orWhereNull('max_weight');
            })
            ->orderBy('min_weight', 'desc')
            ->first();
    }

    public function calculateRateByPolicy($policy, $vendorWeight, $vendorTotal): float
    {
        if ($policy->type == 'weight') {
            if ($policy->free_shipping_threshold !== null && $policy->free_shipping_threshold <= $vendorTotal) {
                return (float) 0;
            } elseif ($policy->weight_ranges !== null) {
                $weights = json_decode($policy->weight_ranges, true);
                foreach ($weights as $weight) {
                    if ($weight['min'] <= $vendorWeight && ($weight['max'] >= $vendorWeight || $weight['max'] == null)) {
                        return (float) $weight['price'];
                    }
                }
            }
            $basePrice = $policy->base_price ?? 0;
            $pricePerKg = $policy->price_per_kg ?? 0;
            $rate = $basePrice + ($vendorWeight * $pricePerKg);
            return (float) $rate;
        } elseif ($policy->type == 'flat') {
            if ($policy->free_shipping_threshold !== null && $policy->free_shipping_threshold <= $vendorTotal) {
                return (float) 0;
            }
            return (float) ($policy->base_price ?? 0);
        }
        return (float) 0;
    }

    private function getRegionIdByCity($cityId)
    {
        return City::where('id', $cityId)->value('region_id') ?? 0;
    }
}
