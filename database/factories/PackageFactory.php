<?php

namespace Database\Factories;

use App\Models\Commune;
use App\Models\DeliveryType;
use App\Models\PackageStatus;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'tracking_code' => 'ZE-'.strtoupper(Str::random(10)),
            'commune_id' => Commune::factory(),
            'delivery_type_id' => DeliveryType::factory(),
            'status_id' => PackageStatus::factory(),
            'store_id' => Store::factory(),
            'address' => fake()->address(),
            'can_be_opened' => fake()->boolean(),
            'name' => fake()->optional()->name(),
            'client_first_name' => fake()->firstName(),
            'client_last_name' => fake()->lastName(),
            'client_phone' => fake()->phoneNumber(),
            'client_phone2' => fake()->optional()->phoneNumber(),
            'cod_to_pay' => fake()->randomFloat(2, 0, 500),
            'commission' => fake()->randomFloat(2, 0, 50),
            'status_updated_at' => fake()->optional()->dateTime(),
            'delivered_at' => fake()->optional()->dateTime(),
            'delivery_price' => fake()->randomFloat(2, 5, 50),
            'extra_weight_price' => fake()->numberBetween(0, 100),
            'free_delivery' => fake()->boolean(),
            'packaging_price' => fake()->numberBetween(0, 20),
            'partner_cod_price' => fake()->randomFloat(2, 0, 100),
            'partner_delivery_price' => fake()->numberBetween(0, 50),
            'partner_return' => fake()->randomFloat(2, 0, 30),
            'price' => fake()->randomFloat(2, 50, 200),
            'price_to_pay' => fake()->randomFloat(2, 10, 150),
            'return_price' => fake()->numberBetween(0, 40),
            'total_price' => fake()->randomFloat(2, 100, 300),
            'weight' => fake()->numberBetween(500, 2000),
            'created_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
