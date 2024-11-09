<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => Str::random(10),
            'name' => fake()->company(),
            'email' => fake()->safeEmail(),
            'phones' => fake()->phoneNumber(),
            'company_name' => fake()->optional()->company(),
            'capital' => fake()->optional()->randomFloat(2, 1000, 100000),
            'address' => fake()->optional()->address(),
            'register_commerce_number' => fake()->optional()->regexify('[0-9]{10}'),
            'nif' => fake()->optional()->regexify('[0-9]{15}'),
            'legal_form' => fake()->numberBetween(1, 5),
            'status' => fake()->boolean(),
            'can_update_preparing_packages' => fake()->boolean(),
        ];
    }
}
