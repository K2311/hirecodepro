<?php
// database/factories/OrderFactory.php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_number' => 'ORD-' . now()->format('Ymd') . '-' . str_pad(fake()->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT),
            'client_id' => Client::factory(),
            'client_email' => fake()->safeEmail(),
            'client_name' => fake()->name(),
            'subtotal' => fake()->randomFloat(2, 50, 1000),
            'tax_amount' => fake()->randomFloat(2, 0, 100),
            'total_amount' => fn(array $attributes) => $attributes['subtotal'] + $attributes['tax_amount'],
            'payment_status' => fake()->randomElement(['pending', 'paid', 'failed']),
            'status' => fake()->randomElement(['pending', 'processing', 'completed']),
            'currency' => 'USD',
        ];
    }

    public function paid(): static
    {
        return $this->state(fn(array $attributes) => [
            'payment_status' => 'paid',
            'paid_at' => now(),
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'completed',
        ]);
    }
}