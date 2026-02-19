<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user list page can be rendered', function() {
    $users = User::all();
    $this->get(route('users.index'))
        ->assertSee($users)
        ->assertStatus(200);
});

test('user creating form page can be rendered', function() {
    $this->get(route('users.create'))->assertStatus(200);
});

test('user can be created', function() {
    
    $data = [
        'name' => fake()->name(),
        'email' => fake()->unique()->safeEmail(),
        'password' => fake()->password()
    ];

    $this->followingRedirects()
        ->post(route('users.store', $data))
        ->assertStatus(200)
        ->assertSee($data['name']);

    $this->assertDatabaseHas('users', ['email' => $data['email']]);

});

test('user page can be rendered', function() {
    $user = User::factory()->create();
    $this->get(route('users.show', $user))
        ->assertStatus(200)
        ->assertSee($user->name);
});

test('user editing form page can be rendered', function(){
    $user = User::factory()->create();
    $this->get(route('users.edit', $user))
        ->assertSee($user->name)
        ->assertStatus(200);
});

test('user can be edited', function() {

    $user = User::factory()->create(['name' => 'Old Name']);

    $payload = [
        'name'      => 'New Name',
        'email'     => fake()->unique()->safeEmail(),
        'password'  => fake()->password()
    ];

    $this->followingRedirects()
        ->put(route('users.update', $user), $payload)
        ->assertStatus(200)
        ->assertSee('New Name');

    $this->assertDatabaseHas('users', [
        'id'    => $user->id,
        'name'  => $payload['name']
    ]);

});

test('user can be deleted', function() {
    $user = User::factory()->create();
    $this->followingRedirects()
        ->delete(route('users.destroy', $user))
        ->assertStatus(200);
    $this->assertSoftDeleted($user);
});