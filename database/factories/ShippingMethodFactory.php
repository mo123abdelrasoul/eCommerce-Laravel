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
                'توصيل عادي',
                'توصيل سريع',
                'توصيل فائق'
            ]),
            'carrier' => $this->faker->randomElement([
                'مكتب بريد',
                'شركة الشحن السريع',
                'أمازون للشحن'
            ]),
            'delivery_time' => $this->faker->numberBetween(1, 7),
            'description' => $this->faker->sentence(),
            'is_active' => true
        ];
    }
}
