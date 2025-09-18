<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShippingRegion>
 */
class ShippingRegionFactory extends Factory
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
                'القاهرة الكبرى',
                'الجيزة',
                'الإسكندرية',
                'الدلتا',
                'الصعيد',
                'السويس'
            ]),
            'description' => $this->faker->sentence(),
            'is_active' => true
        ];
    }
}
