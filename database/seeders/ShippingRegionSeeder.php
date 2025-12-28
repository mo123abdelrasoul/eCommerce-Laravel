<?php

namespace Database\Seeders;

use App\Models\ShippingRegion;
use Illuminate\Database\Seeder;

class ShippingRegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            ['name' => 'القاهرة الكبرى', 'description' => 'تشمل القاهرة والجيزة'],
            ['name' => 'الإسكندرية', 'description' => 'مدينة الإسكندرية'],
            ['name' => 'الدلتا', 'description' => 'محافظات الدلتا'],
            ['name' => 'الصعيد', 'description' => 'محافظات الصعيد'],
            ['name' => 'السويس', 'description' => 'مدينة السويس']
        ];

        foreach ($regions as $region) {
            ShippingRegion::create($region);
        }
    }
}
