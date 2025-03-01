<?php

use App\Models\User;
use Tests\TestCase;

test('users can authenticate using the login screen', function () {
    /** @var TestCase $this */
    $user = User::factory()->create([
        'password' => Hash::make('password'),
    ]);

    $this
        ->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

    $this->assertAuthenticated();
});

test('users can not authenticate with invalid password', function () {
    /** @var TestCase $this */
    $user = User::factory()->create();

    $this
        ->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])
        ->assertStatus(422)
        ->assertJsonValidationErrors('email');

    $this->assertGuest();
});

test('users can logout', function () {
    /** @var TestCase $this */
    $user = User::factory()->create();

    $this->actingAs($user)->post('/api/logout');

    $this->assertGuest();
});
