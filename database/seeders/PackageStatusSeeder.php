<?php

namespace Database\Seeders;

use App\Models\PackageStatus;
use Illuminate\Database\Seeder;

class PackageStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statues = [
            'pending',
            'accepted',
            'cancelled',
            'shipped',
            'delivered',
            'returned',
            'refunded',
        ];

        foreach ($statues as $status) {
            PackageStatus::create(['name' => $status]);
        }
    }
}
