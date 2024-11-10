<?php

use App\Models\User;

use function Pest\Laravel\get;
use function Pest\Laravel\post;

test('login route uri', function () {
    expect(route('login', absolute: false))->toBe('/auth/login');
});

it('returns a successful response', function () {
    get(route('login'))->assertStatus(200);
});

it('signs in the user', function () {
    User::factory()->create([
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    post(route('login.store'), [
        'email' => 'unknow@example.com',
        'password' => '123465',
    ])
        ->assertSessionHasErrors('email');

    post(route('login.store'), [
        'email' => 'test@example.com',
        'password' => 'password',
    ])
        ->assertRedirect(route('packages.index'));
});
