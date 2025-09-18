<?php

namespace Database\Seeders;

use App\Models\ShippingMethod;
use Database\Factories\ShippingMethodFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            [
                'name' => 'توصيل عادي',
                'carrier' => 'مكتب بريد',
                'delivery_time' => 7,
                'description' => 'توصيل خلال 7 أيام عمل'
            ],
            [
                'name' => 'توصيل سريع',
                'carrier' => 'شركة الشحن السريع',
                'delivery_time' => 3,
                'description' => 'توصيل خلال 3 أيام عمل'
            ],
            [
                'name' => 'توصيل فائق',
                'carrier' => 'أمازون للشحن',
                'delivery_time' => 1,
                'description' => 'توصيل خلال 24 ساعة'
            ]
        ];

        foreach ($methods as $method) {
            ShippingMethod::create($method);
        }
    }
}
