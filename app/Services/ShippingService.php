<?php

namespace App\Services;

use App\Models\City;
use App\Models\Product;
use App\Models\ShippingMethod;
use App\Models\ShippingPolicy;
use App\Models\ShippingRate;

class ShippingService
{
    public function calculate($cart, $checkoutData, $cartTotal)
    {
        $regionId = $this->getRegionIdByCity($checkoutData['city']);
        $shippingMethodId = $checkoutData['shipping_method'];
        $method = ShippingMethod::with('policy')->find($shippingMethodId);
        $policy = $method->policy;
        $chargeableWeight  = $this->calculateWeights($cart);
        $rate = $this->getRate($regionId, $shippingMethodId, $chargeableWeight, $policy, $cartTotal);
        return [
            'success' => true,
            'rate' => $rate
        ];
    }
    private function getRegionIdByCity($cityId)
    {
        return City::where('id', $cityId)->value('region_id');
    }
    private function calculateWeights($cart)
    {
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
        $weight = 0;
        $volumetric_weight = 0;
        $divisor = config('shipping.default.volumetric_divisor', 5000);
        foreach ($cart as $productId => $qty) {
            $product = $products[$productId];
            $weight += $product->weight * $qty;
            $volumetric_weight += (($product->height * $product->width * $product->length) / $divisor) * $qty;
        }
        return max($weight, $volumetric_weight);
    }
    private function getRate($regionId, $shippingMethodId, $chargeableWeight, $policy, $cartTotal)
    {
        $rate = ShippingRate::where('shipping_region_id', $regionId)
            ->where('shipping_method_id', $shippingMethodId)
            ->where('min_weight', '<=', $chargeableWeight)
            ->where(function ($query) use ($chargeableWeight) {
                $query->where('max_weight', '>=', $chargeableWeight)
                    ->orWhereNull('max_weight');
            })
            ->first();
        if (!$rate) {
            return $this->calculateByPolicy($policy, $chargeableWeight, $cartTotal);
        }
        return $rate->rate;
    }
    public function calculateByPolicy($policy, $chargeableWeight, $cartTotal)
    {
        if ($policy->type == 'weight') {
            if ($policy->free_shipping_threshold !== null && $policy->free_shipping_threshold <= $cartTotal) {
                return 0;
            } elseif ($policy->weight_ranges !== null) {
                $weights = json_decode($policy->weight_ranges, true);
                foreach ($weights as $weight) {
                    if ($weight['min'] <= $chargeableWeight && ($weight['max'] >= $chargeableWeight || $weight['max'] == null)) {
                        $rate = $weight['price'];
                        return $rate;
                    }
                }
            }
            $basePrice = $policy->base_price ?? 0;
            $pricePerKg = $policy->price_per_kg ?? 0;
            $rate = $basePrice + ($chargeableWeight * $pricePerKg);
            return $rate;
        } elseif ($policy->type == 'flat') {
            if ($policy->free_shipping_threshold !== null && $policy->free_shipping_threshold <= $cartTotal) {
                return 0;
            }
            return $policy->base_price ?? 0;
        }
        return 0;
    }
}
