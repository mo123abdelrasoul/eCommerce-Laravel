<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'status' => 'approved',
            'vendor_id' => 1,
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id,
            'featured' => $this->faker->boolean(20),
            'quantity' => $this->faker->numberBetween(0, 100),
            'deleted_at' => null,
            'sku' => strtoupper($this->faker->bothify('??###')),
            'discount' => $this->faker->randomFloat(2, 0, 0.3), // Up to 30% discount
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
