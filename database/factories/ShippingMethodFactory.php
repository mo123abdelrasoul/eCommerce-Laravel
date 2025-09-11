<?php

namespace Database\Factories;

use App\Models\ShippingMethod;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShippingMethod>
 */
class ShippingMethodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Standard Shipping',
                'Express Delivery',
                'Same Day Delivery',
                'Next Day Shipping',
                'International Shipping'
            ]),
            'price' => $this->faker->randomFloat(2, 20, 200),
            'vendor_id' => Vendor::inRandomOrder()->first()?->id ?? Vendor::factory(),
            'delivery_time' => $this->faker->randomElement([
                '2-5 days',
                '1-2 days',
                'Same day',
                '3-7 days',
                'Up to 14 days'
            ]),
            'status' => $this->faker->boolean(80),
        ];
    }
}
