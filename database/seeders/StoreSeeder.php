<?php

namespace Database\Seeders;

use App\Models\Commune;
use App\Models\DeliveryType;
use App\Models\PackageStatus;
use App\Models\Store;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Concurrency;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Prompts\Output\ConsoleOutput;
use PDO;
use Symfony\Component\Console\Helper\ProgressBar;

class StoreSeeder extends Seeder
{
    protected array $communes;

    protected array $packagesStatuses;

    protected array $deliveryTypes;

    public function __construct(protected Generator $faker)
    {
        $this->communes = Commune::pluck('id')->flip()->toArray();
        $this->packagesStatuses = PackageStatus::pluck('id')->flip()->toArray();
        $this->deliveryTypes = DeliveryType::query()->pluck('id')->flip()->toArray();
    }

    public function run(): void
    {

        $this->command->info("\nCreating stores...\n");

        $stores = Concurrency::driver('fork')->run([
            fn () => $this->storesAttributes(),
            fn () => $this->storesAttributes(),
            fn () => $this->storesAttributes(),
            fn () => $this->storesAttributes(),
            fn () => $this->storesAttributes(),
            fn () => $this->storesAttributes(),
            fn () => $this->storesAttributes(),
            fn () => $this->storesAttributes(),
            fn () => $this->storesAttributes(),
            fn () => $this->storesAttributes(),
        ]);

        foreach ($stores as $store) {
            DB::table('stores')->insert($store);
        }

        $this->command->info("Stores created successfully!\n");

        $this->command->info("Creating packages...\n");

        $packages = [];

        DB::table('stores')
            ->select('id')
            ->latest('id')
            ->chunk(100, function ($chunk) use (&$packages) {
                foreach ($chunk as $store) {
                    for ($i = 0; $i < 100; $i++) {
                        $packages[] = $this->packageAttributes($store->id);
                    }
                }
            });

        $output = new ConsoleOutput;
        $progressBar = new ProgressBar($output, 500_000);
        $progressBar->start();

        DB::connection()->getPdo()->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

        foreach (array_chunk($packages, 5000) as $chunk) {
            DB::table('packages')->insert($chunk);
            $progressBar->advance(5000);
        }

        DB::connection()->getPdo()->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $progressBar->finish();

        $this->command->info("\n\nPackages created successfully!\n");
    }

    protected function storesAttributes(): array
    {
        return Store::factory(500)->raw();
    }

    protected function packageAttributes(int $storeId): array
    {
        $communeId = array_rand($this->communes);
        $deliveryTypeId = array_rand($this->deliveryTypes);
        $statusId = array_rand($this->packagesStatuses);

        return [
            'uuid' => (string) Str::uuid(),
            'tracking_code' => 'ZE-'.strtoupper(Str::random(10)),
            'commune_id' => $communeId,
            'delivery_type_id' => $deliveryTypeId,
            'status_id' => $statusId,
            'store_id' => $storeId,
            'address' => $this->faker->streetAddress(),
            'name' => $this->faker->sentence(4, true),
            'client_first_name' => $this->faker->firstName(),
            'client_last_name' => $this->faker->lastName(),
            'client_phone' => '077'.rand(1000000, 9999999),
            'delivery_price' => 120,
            'free_delivery' => false,
            'price' => $price = rand(1, 99) * 100,
            'price_to_pay' => $toPay = $price + rand(1, 5) * 100,
            'total_price' => $toPay + rand(1, 5) * 100,
        ];
    }
}
