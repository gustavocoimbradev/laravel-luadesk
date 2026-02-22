<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
class AnswerFactory extends Factory
{

    public function definition(): array
    {
        $faker = Faker::create();
        return [
            'content' => $faker->paragraphs(2, true),
            'ticket_id' => Ticket::factory(),
            'user_id' => User::factory()
        ];
    } 

}
