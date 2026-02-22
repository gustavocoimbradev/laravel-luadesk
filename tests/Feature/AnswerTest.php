<?php

use App\Models\Ticket;
use App\Models\User; 
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can answer their own ticket', function() { 

    $user = User::factory()->create();
    $ticket = Ticket::factory()->create(['user_id' => $user->id]);

    $payload = [
        'content' => fake()->paragraphs(2, true)
    ]; 

    $this->actingAs($user)
        ->followingRedirects()
        ->post(route('answers.store', $ticket), $payload)
        ->assertStatus(200);

    $this->assertDatabaseHas('answers', ['content' => $payload['content'], 'user_id' => $user->id]);

});

test('user cannot answer their own ticket if it has been closed', function () {

    $user = User::factory()->create();
    $ticket = Ticket::factory()->create(['user_id' => $user->id, 'status' => 2]);

    $payload = [
        'content' => fake()->paragraphs(2, true)
    ]; 

    $this->actingAs($user)
        ->followingRedirects()
        ->post(route('answers.store', $ticket), $payload)
        ->assertStatus(403);

    $this->assertDatabaseMissing('answers', ['content' => $payload['content'], 'user_id' => $user->id]);

});

test('user cannot answer another\'s user ticket', function(){

    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $ticket = Ticket::factory()->create(['user_id' => $user1->id]);

    $payload = [
        'content' => fake()->paragraphs(2, true)
    ]; 

    $this->actingAs($user2)
        ->followingRedirects()
        ->post(route('answers.store', $ticket), $payload)
        ->assertStatus(403);

    $this->assertDatabaseMissing('answers', ['content' => $payload['content'], 'user_id' => $user1->id]);

});

test('admin can answer any ticket', function() {

    $user = User::factory()->create();
    $ticket = Ticket::factory()->create(['user_id' => $user->id]);
    $admin = User::factory()->create(['is_admin' => true]);

    $payload = [
        'content' => fake()->paragraphs(2, true)
    ]; 

    $this->actingAs($admin)
        ->followingRedirects()
        ->post(route('answers.store', $ticket), $payload)
        ->assertStatus(200);

    $this->assertDatabaseHas('answers', ['content' => $payload['content'], 'user_id' => $admin->id]);

});

test('user cannot answer closed tickets', function() {

    $user = User::factory()->create();
    $ticket = Ticket::factory()->create(['user_id' => $user->id, 'status' => 2]);

    $payload = [
        'content' => fake()->paragraphs(2, true)
    ]; 

    $this->actingAs($user)
        ->followingRedirects()
        ->post(route('answers.store', $ticket), $payload)
        ->assertStatus(403);

    $this->assertDatabaseMissing('answers', ['content' => $payload['content'], 'user_id' => $user->id]);

});

test('admin can close a ticket', function() {
    
    $admin = User::factory()->create(['is_admin' => true]);
    $user = User::factory()->create();
    $ticket = Ticket::factory()->create(['user_id' => $user->id]);

    $payload = [
        'content' => 'Closed!',
        'closes_ticket' => true
    ];

    $this->actingAs($admin)
        ->followingRedirects()
        ->post(route('answers.store', $ticket), $payload)
        ->assertStatus(200);

    $this->assertDatabaseHas('answers', ['content' => 'Closed!', 'closes_ticket' => true]);

    $this->assertDatabaseHas('tickets', ['id' => $ticket->id, 'status' => 2]);

});

test('user cannot close a ticket', function() {
    
    $user = User::factory()->create();
    $ticket = Ticket::factory()->create(['user_id' => $user->id]);

    $payload = [
        'content' => 'Closed!',
        'closes_ticket' => true
    ];

    $this->actingAs($user)
        ->followingRedirects()
        ->post(route('answers.store', $ticket), $payload)
        ->assertStatus(403);

    $this->assertDatabaseMissing('answers', ['content' => 'Closed!', 'closes_ticket' => true]);

    $this->assertDatabaseMissing('tickets', ['id' => $ticket->id, 'status' => 2]);

}); 

test('user cannot see the answer form if the ticket has been closed', function(){
    $user = User::factory()->create();
    $ticket = Ticket::factory()->create(['status' => 2, 'user_id' => $user->id]);
    $this->actingAs($user)
        ->get(route('tickets.show', $ticket))
        ->assertStatus(200)
        ->assertDontSee('answer-form');
});

test('user cannot see the close button', function(){

    $user = User::factory()->create();
    $ticket = Ticket::factory()->create(['user_id' => $user->id]);
    $this->actingAs($user)
        ->get(route('tickets.show', $ticket))
        ->assertStatus(200)
        ->assertDontSee('close-button');

});