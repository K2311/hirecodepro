<?php
// database/factories/ClientFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'full_name' => fake()->name(),
            'company' => fake()->company(),
            'position' => fake()->jobTitle(),
            'phone' => fake()->phoneNumber(),
            'country' => fake()->country(),
            'status' => fake()->randomElement(['lead', 'client', 'past_client']),
            'tags' => [fake()->word(), fake()->word()],
            'is_subscribed' => fake()->boolean(),
        ];
    }
}