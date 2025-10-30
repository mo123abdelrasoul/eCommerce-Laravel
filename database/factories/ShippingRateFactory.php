<?php

namespace Database\Factories;

use App\Models\ShippingRegion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShippingRate>
 */
class ShippingRateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'shipping_region_id' => ShippingRegion::factory(),
            'min_weight' => $this->faker->randomFloat(2, 0, 5),
            'max_weight' => $this->faker->randomFloat(2, 5, 20),
            'min_price' => $this->faker->randomFloat(2, 0, 100),
            'max_price' => $this->faker->randomFloat(2, 100, 1000),
            'rate' => $this->faker->randomFloat(2, 10, 100)
        ];
    }
}
