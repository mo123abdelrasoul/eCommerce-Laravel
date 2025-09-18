<?php

namespace Database\Seeders;

use App\Models\ShippingMethod;
use App\Models\ShippingPolicy;
use App\Models\ShippingRate;
use App\Models\ShippingRegion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = ShippingRegion::all();
        $methods = ShippingMethod::all();
        $policies = ShippingPolicy::all();

        foreach ($regions as $region) {
            foreach ($methods as $method) {
                foreach ($policies as $policy) {

                    ShippingRate::create([
                        'shipping_policy_id' => $policy->id,
                        'shipping_region_id' => $region->id,
                        'shipping_method_id' => $method->id,
                        'min_weight' => 0,
                        'max_weight' => 1,
                        'min_price' => 0,
                        'max_price' => 1000,
                        'rate' => $policy->type === 'weight' ? 20 : 30
                    ]);
                }
            }
        }
    }
}
