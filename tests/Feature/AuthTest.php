<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can authenticate', function(){

    $user = User::factory()->create(['password' => 'password123']);

    $payload = [
        'email'     => $user->email,
        'password'  => 'password123'
    ];

    $response = $this->followingRedirects()->post(route('auth.store'), $payload);
    $response->assertStatus(200);

    $this->assertAuthenticatedAs($user);

});

test('user cannot authenticate with wrong password', function(){

    $user = User::factory()->create(['password' => 'correctpassword']);

    $payload = [
        'email'     => $user->email,
        'password'  => 'wrongpassword'
    ];

    $response = $this->followingRedirects()->post(route('auth.store'), $payload);
    $response->assertStatus(200);

    $this->assertGuest();

});

