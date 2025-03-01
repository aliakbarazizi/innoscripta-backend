<?php

test('new users can register', function () {
    /** @var \Tests\TestCase $this */
    $this->postJson('/api/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
});
