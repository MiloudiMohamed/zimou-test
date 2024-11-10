<?php

use App\Livewire\ListPackages;
use App\Models\Package;
use App\Models\PackageStatus;
use App\Models\User;
use Database\Seeders\PackageStatusSeeder;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('packages.index route uri', function () {
    expect(route('packages.index', absolute: false))->toBe('/');
});

it('requires authentication', function () {
    /** @var User $user */
    $user = User::factory()->create();

    get(route('packages.index'))->assertRedirect(route('login'));

    actingAs($user)->get(route('packages.index'))
        ->assertStatus(200)
        ->assertSeeLivewire(ListPackages::class);
});

it('shows pending packages first', function () {
    $this->seed(PackageStatusSeeder::class);

    $pendingStatus = PackageStatus::pending()->first();
    $acceptedStatus = PackageStatus::accepted()->first();
    $canceledStatus = PackageStatus::canceled()->first();

    $packages = Package::factory()
        ->count(5)
        ->sequence(
            ['status_id' => $pendingStatus->id, 'created_at' => now()->subHours(2)],
            ['status_id' => $pendingStatus->id, 'created_at' => now()->subDay()],
            ['status_id' => $pendingStatus->id, 'created_at' => now()->subHour()],
            ['status_id' => $acceptedStatus->id, 'created_at' => now()->subDay()],
            ['status_id' => $canceledStatus->id, 'created_at' => now()->subWeek()],
        )
        ->createQuietly();

    Livewire::test(ListPackages::class)
        ->assertViewHas('packages', function ($data) use ($packages) {
            expect($data[0]->id)->toEqual($packages[1]->id);
            expect($data[1]->id)->toEqual($packages[0]->id);
            expect($data[2]->id)->toEqual($packages[2]->id);
            expect($data[3]->id)->toEqual($packages[4]->id);
            expect($data[4]->id)->toEqual($packages[3]->id);

            return count($data) === 5;
        });
});
