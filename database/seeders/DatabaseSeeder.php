<?php

namespace Database\Seeders;

use App\Models\Commune;
use App\Models\DeliveryType;
use App\Models\Package;
use App\Models\PackageStatus;
use App\Models\Store;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            WilayaAndCommuneSeeder::class,
            PackageStatusSeeder::class,
            DeliveryTypeSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $communes = Commune::all();
        $packagesStatuses = PackageStatus::all();
        $deliveryTypes = DeliveryType::all();

        Store::factory(5000)
            ->has(
                Package::factory(100)
                    ->recycle($communes)
                    ->recycle($packagesStatuses)
                    ->recycle($deliveryTypes),
            )
            ->create();
    }
}
