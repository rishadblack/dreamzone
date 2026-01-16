<?php

namespace Database\Factories\Contact;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ContactFactory extends Factory
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
            // 'name' => fake()->sentence(3),
            'company_name' => fake()->company(),
            'contact_group_id' => fake()->numberBetween(1, 4),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'user_id' => 1,
            'status' => 1,
        ];
    }
}
