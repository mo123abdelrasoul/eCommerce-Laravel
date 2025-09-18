<?php

namespace Database\Seeders;

use App\Models\ShippingPolicy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingPolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $policies = [
            [
                'name' => 'شحن حسب الوزن',
                'type' => 'weight',
                'base_price' => 20.00,
                'price_per_kg' => 5.00,
                'is_active' => true
            ],
            [
                'name' => 'شحن ثابت',
                'type' => 'flat',
                'base_price' => 30.00,
                'is_active' => true
            ],
            [
                'name' => 'شحن مجاني',
                'type' => 'free',
                'free_shipping_threshold' => 500.00,
                'is_active' => true
            ]
        ];

        foreach ($policies as $policy) {
            ShippingPolicy::create($policy);
        }
    }
}
