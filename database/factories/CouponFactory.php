<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vendor_id' => 1,
            'code' => strtoupper($this->faker->lexify('COUPON????')),
            'discount_type' => $this->faker->randomElement(['percentage', 'fixed_cart', 'fixed_product']),
            'discount_value' => $this->faker->numberBetween(5, 50),
            'max_discount' => $this->faker->optional()->numberBetween(50, 200),
            'min_order_amount' => $this->faker->optional()->numberBetween(100, 500),
            'usage_limit' => $this->faker->optional()->numberBetween(20, 50),
            'usage_limit_per_user' => 1,
            'start_date' => $this->faker->dateTimeBetween('-15 days', '+2 days'),
            'end_date' => $this->faker->dateTimeBetween('+3 days', '+20 days'),
            'status' => $this->faker->randomElement(['active', 'expired', 'disabled']),
            'approval_status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
        ];
    }
}
