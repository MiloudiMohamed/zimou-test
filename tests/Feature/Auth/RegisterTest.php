<?php

use function Pest\Laravel\get;
use function Pest\Laravel\post;

test('register route uri', function () {
    expect(route('register', absolute: false))->toBe('/auth/register');
});

it('returns a successful response', function () {
    get(route('register'))->assertStatus(200);
});

it('registers a new user', function () {
    $data = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    post(route('register.store'), $data)
        ->assertRedirect(route('packages.index'));
});

it('throws validation errors', function () {
    post(route('register.store'), [])
        ->assertSessionHasErrors([
            'name', 'email', 'password',
        ]);
});
