<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory
{

    public function definition(): array
    {
        return [
            'content' => fake()->paragraphs(2, true),
            'ticket_id' => Ticket::factory(),
            'user_id' => User::factory()
        ];
    } 

}
