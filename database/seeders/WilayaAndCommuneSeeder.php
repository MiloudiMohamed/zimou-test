<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class WilayaAndCommuneSeeder extends Seeder
{
    public function run(): void
    {
        $wilayas = config('wilayas');
        $communes = config('communes');

        DB::table('wilayas')->insert(
            Arr::map($wilayas, fn ($wilaya) => ['name' => $wilaya])
        );

        DB::table('communes')->insert($communes);
    }
}
