<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
class TicketFactory extends Factory
{

    public function definition(): array
    {
        $faker = Faker::create();
        return [
            'title' => $faker->sentence(4),
            'content' => $faker->paragraphs(3, true),
            'user_id' => User::factory(),
        ];
    }

}
