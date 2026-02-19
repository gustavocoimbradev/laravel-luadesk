<?php

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated user can create a ticket', function(){

    $user = User::factory()->create();

    $payload = [
        'title' => fake()->sentence(4),
        'content' => fake()->paragraphs(3, true),
    ];

    $this->actingAs($user)
        ->followingRedirects()
        ->post(route('tickets.store'), $payload)
        ->assertStatus(200)
        ->assertSee($payload['title']);

});

test('unauthenticated user cannot create a ticket', function(){

    $payload = [
        'title' => fake()->sentence(4),
        'content' => fake()->paragraphs(3, true),
    ];

    $this->followingRedirects()
        ->post(route('tickets.store'), $payload)
        ->assertStatus(403);

});

test('user can delete their own ticket', function() {

    $user = User::factory()->create();
    $ticket = Ticket::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->followingRedirects()
        ->delete(route('tickets.destroy', $ticket))
        ->assertStatus(200)
        ->assertDontSee($ticket->title);

    $this->assertSoftDeleted($ticket);

});

test('user cannot delete another user\'s ticket', function(){

    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $ticket = Ticket::factory()->create(['user_id' => $user1->id]);

    $this->actingAs($user2)
        ->followingRedirects()
        ->delete(route('tickets.destroy', $ticket))
        ->assertStatus(403);

    $this->assertDatabaseHas('tickets', ['id' => $ticket->id]);

});

test('user can edit their own ticket', function(){

    $user = User::factory()->create();
    $ticket = Ticket::factory()->create(['user_id' => $user->id]);

    $payload = [
        'title' => 'New title',
        'content' => 'New content'
    ];

    $this->actingAs($user)
        ->followingRedirects()
        ->put(route('tickets.update', $ticket), $payload)
        ->assertStatus(200);

    $ticket->refresh();

    $this->expect($ticket->title)->toBe($payload['title']);
    $this->expect($ticket->content)->toBe($payload['content']);

});

test('user cannot edit another user\'s ticket', function() {

    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $ticket = Ticket::factory()->create(['user_id' => $user1->id]);

    $payload = [
        'title' => 'New title',
        'content' => 'New content'
    ];

    $this->actingAs($user2)
        ->followingRedirects()
        ->put(route('tickets.update', $ticket), $payload)
        ->assertStatus(403);

        $ticket->refresh();

    $this->expect($ticket->title)->not()->toBe($payload['title']);
    $this->expect($ticket->content)->not()->toBe($payload['content']);

});

test('tickets page can be rendered', function() {

    $this->get(route('tickets.index'))
        ->assertStatus(200);

});

test('ticket page can be rendered', function() {

    $user = User::factory()->create();
    $ticket = Ticket::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->get(route('tickets.show', $ticket))
        ->assertStatus(200);

});

test('ticket page cannot be rendered for unauthorized user', function() {

    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $ticket = Ticket::factory()->create(['user_id' => $user1->id]);

    $this->actingAs($user2)
        ->get(route('tickets.show', $ticket))
        ->assertStatus(403);
    
});

test('ticket editing form can be rendered', function() {

    $user = User::factory()->create();
    $ticket = Ticket::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->get(route('tickets.edit', $ticket))
        ->assertStatus(200);

});

test('ticket editing form cannot be rendered for unauthorized user', function() {

    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $ticket = Ticket::factory()->create(['user_id' => $user1->id]);

    $this->actingAs($user2)
        ->get(route('tickets.edit', $ticket))
        ->assertStatus(403);
    
});