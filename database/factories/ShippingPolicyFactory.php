<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShippingPolicy>
 */
class ShippingPolicyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['شحن اقتصادي', 'شحن سريع', 'شحن مجاني']),
            'type' => $this->faker->randomElement(['flat', 'weight', 'price', 'free']),
            'base_price' => $this->faker->randomFloat(2, 10, 50),
            'price_per_kg' => $this->faker->randomFloat(2, 5, 15),
            'free_shipping_threshold' => $this->faker->randomFloat(2, 300, 1000),
            'weight_ranges' => json_encode([
                ['min' => 0, 'max' => 1, 'price' => 20],
                ['min' => 1, 'max' => 3, 'price' => 30],
                ['min' => 3, 'max' => 5, 'price' => 40],
                ['min' => 5, 'max' => null, 'price' => 50]
            ]),
            'is_active' => true
        ];
    }
}
