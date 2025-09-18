<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\ShippingRegion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = ShippingRegion::pluck('id', 'name');

        $cities = [
            ['name' => 'Cairo', 'region_id' => $regions['greater_cairo']],
            ['name' => 'Giza', 'region_id' => $regions['greater_cairo']],
            ['name' => 'Qalyubia', 'region_id' => $regions['greater_cairo']],

            ['name' => 'Alexandria', 'region_id' => $regions['alexandria']],

            ['name' => 'Dakahlia', 'region_id' => $regions['delta']],
            ['name' => 'Sharqia', 'region_id' => $regions['delta']],
            ['name' => 'Gharbia', 'region_id' => $regions['delta']],
            ['name' => 'Monufia', 'region_id' => $regions['delta']],
            ['name' => 'Kafr El Sheikh', 'region_id' => $regions['delta']],

            ['name' => 'Suez', 'region_id' => $regions['suez_canal']],
            ['name' => 'Ismailia', 'region_id' => $regions['suez_canal']],
            ['name' => 'Port Said', 'region_id' => $regions['suez_canal']],

            ['name' => 'Aswan', 'region_id' => $regions['upper_egypt']],
            ['name' => 'Luxor', 'region_id' => $regions['upper_egypt']],
            ['name' => 'Sohag', 'region_id' => $regions['upper_egypt']],
            ['name' => 'Assiut', 'region_id' => $regions['upper_egypt']],
            ['name' => 'Minya', 'region_id' => $regions['upper_egypt']],
        ];

        foreach ($cities as $city) {
            City::firstOrCreate(['name' => $city['name']], $city);
        }
    }
}
