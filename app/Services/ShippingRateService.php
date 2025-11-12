<?php

namespace App\Services;

use App\Models\VendorShippingRate;
use Illuminate\Support\Facades\DB;

class ShippingRateService
{
    public function updateVendorRates($vendor, array $rates): bool
    {
        try {
            DB::beginTransaction();
            VendorShippingRate::where('vendor_id', $vendor->id)->delete();
            foreach ($rates as $rate) {
                VendorShippingRate::create([
                    'vendor_id' => $vendor->id,
                    'shipping_region_id' => $rate['region'],
                    'shipping_method_id' => $rate['method'],
                    'min_weight' => $rate['min_weight'],
                    'max_weight' => $rate['max_weight'] ?? null,
                    'rate' => $rate['rate'],
                ]);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            return false;
        }
    }
}
