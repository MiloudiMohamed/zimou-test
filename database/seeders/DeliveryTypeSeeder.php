<?php

namespace Database\Seeders;

use App\Models\DeliveryType;
use Illuminate\Database\Seeder;

class DeliveryTypeSeeder extends Seeder
{
    public function run(): void
    {
        DeliveryType::factory(2)
            ->sequence(
                ['name' => 'Home Delivery'],
                ['name' => 'Pickup Point']
            )
            ->create();
    }
}
