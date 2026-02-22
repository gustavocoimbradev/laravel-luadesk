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

        User::factory()->create(['email' => 'admin@admin.com', 'is_admin' => true]);

        User::factory(5)
            ->has(Ticket::factory(15)->has(
                    Answer::factory(10)->state(function(array $attributes, Ticket $ticket){
                        return ['user_id' => $ticket->user_id];
                    })
                )
            )
            ->create();
    }
}
