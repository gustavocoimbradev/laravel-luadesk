<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Ticket;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create(['email' => 'admin1@example.com', 'is_admin' => true]);
        User::factory()->create(['email' => 'admin2@example.com', 'is_admin' => true]);
        User::factory()->create(['email' => 'admin3@example.com', 'is_admin' => true]);

        User::factory()
            ->has(Ticket::factory(5))
            ->create(['email' => 'user1@example.com']);

        User::factory()
            ->has(Ticket::factory(5))
            ->create(['email' => 'user2@example.com']);
        
        User::factory()
            ->has(Ticket::factory(5))
            ->create(['email' => 'user3@example.com']);

    }
}
