<?php

use App\Livewire\CreatePackage;
use App\Models\Package;
use App\Models\User;
use Database\Seeders\PackageStatusSeeder;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('packages.create route uri', function () {
    expect(route('packages.create', absolute: false))->toBe('/packages/create');
});

test('requires authentication', function () {
    /** @var User $user */
    $user = User::factory()->create();

    get(route('packages.create'))->assertRedirect(route('login'));

    actingAs($user)->get(route('packages.create'))
        ->assertStatus(200)
        ->assertSeeLivewire(CreatePackage::class);
});

it('creates a new package', function () {
    $this->seed(PackageStatusSeeder::class);

    $data = Package::factory()->raw();

    Livewire::test(CreatePackage::class)
        ->assertViewHas(['stores', 'wilayas', 'deliveryTypes'])
        ->set([
            'form' => $data,
        ])
        ->call('store')
        ->assertHasNoErrors();

    $package = Package::latest()->first();

    expect($package->status->name)->toEqual('pending');
});

it('throws errors if validation fails', function () {
    $this->seed(PackageStatusSeeder::class);

    Livewire::test(CreatePackage::class)
        ->set([
            'form' => [],
        ])
        ->call('store')
        ->assertHasErrors([
            'form.store_id', 'form.client_first_name', 'form.client_last_name', 'form.client_phone',
            'form.commune_id', 'form.address', 'form.price', 'form.delivery_price',
            'form.packaging_price', 'form.partner_cod_price', 'form.partner_delivery_price',
            'form.return_price', 'form.partner_return', 'form.cod_to_pay', 'form.commission',
            'form.weight', 'form.extra_weight_price', 'form.delivery_type_id',
            'form.free_delivery', 'form.can_be_opened',
        ]);
});
