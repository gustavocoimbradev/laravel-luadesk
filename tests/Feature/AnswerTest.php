<?php

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can answer their own ticket', function () {

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
