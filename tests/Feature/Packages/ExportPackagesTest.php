<?php

use App\Livewire\ListPackages;
use App\Models\Package;
use App\Models\User;
use App\Notifications\ExportReadyNotification;
use Database\Seeders\PackageStatusSeeder;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\travelTo;

$csvPath = 'packages 2024-11-12 1200-test123.csv';

it('exports packages', function () use ($csvPath) {
    $this->seed(PackageStatusSeeder::class);

    Notification::fake();

    /** @var User $user */
    $user = User::factory()->create();

    actingAs($user);

    travelTo(now()->setDateTimeFrom('2024-11-12 12:00'));

    Package::factory(2)->create();

    Str::createRandomStringsUsing(fn () => 'test123');

    Livewire::test(ListPackages::class)
        ->call('export')
        ->assertHasNoErrors();

    Notification::assertSentTo($user, ExportReadyNotification::class);

    expect(Storage::exists("exports/$csvPath"))->toBeTrue();

    $csv = Storage::readStream("exports/$csvPath");

    expect(fgetcsv($csv))->toEqual([
        'Tracking Code', 'Store', 'Package name', 'Status',
        'Client', 'Phone', 'Wilaya', 'Commune', 'Delivery Type',
    ]);

    fclose($csv);
});

afterAll(function () use ($csvPath) {
    Storage::disk('local')->delete("/exports/$csvPath");
    Str::createRandomStringsNormally();
});
