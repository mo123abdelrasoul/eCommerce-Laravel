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
        ShippingMethod::factory()->count(10)->create();
    }
}
