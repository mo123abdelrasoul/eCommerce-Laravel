<?php

namespace App\Services;

use App\Models\ShippingMethod;

class ShippingMethodService
{
    public function getActiveMethods()
    {
        return ShippingMethod::Active()->get();
    }

    public function getVendorMethods($vendor)
    {
        return $vendor->shippingMethods;
    }

    public function updateVendorMethods($vendor, array $methods): bool
    {
        try {
            $selectedMethodIds = collect($methods)
                ->filter(fn($item) => isset($item['enabled']))
                ->keys()
                ->toArray();
            $vendor->shippingMethods()->sync($selectedMethodIds);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
