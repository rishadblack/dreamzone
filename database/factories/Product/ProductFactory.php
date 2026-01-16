<?php

namespace Database\Factories\Product;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product\Product>
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
            'code' => fake()->ean8(),
            'name' => fake()->sentence(3),
            'brand_id' => fake()->numberBetween(1, 4),
            'category_id' => fake()->numberBetween(1, 4),
            'unit_id' => fake()->numberBetween(1, 4),
            'purchase_price' => fake()->randomFloat(2, 10, 20),
            'sale_price' => fake()->randomFloat(2, 10, 20),
            'status' => 1,
        ];
    }
}
