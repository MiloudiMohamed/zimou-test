<?php

use App\Livewire\ListPackages;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('packages.index route uri', function () {
    expect(route('packages.index', absolute: false))->toBe('/packages');
});

it('requires authentication', function () {
    /** @var User $user */
    $user = User::factory()->create();

    get(route('packages.index'))->assertRedirect(route('login'));

    actingAs($user)->get(route('packages.index'))
        ->assertStatus(200)
        ->assertSeeLivewire(ListPackages::class);

    Livewire::test(ListPackages::class)
        ->assertViewHas('packages');
});
