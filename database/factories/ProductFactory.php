<?php
// database/factories/ProductFactory.php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'slug' => fake()->slug(),
            'short_description' => fake()->sentence(),
            'full_description' => fake()->paragraphs(3, true),
            'category_id' => ProductCategory::factory(),
            'product_type' => fake()->randomElement(['code', 'template', 'api', 'plugin', 'tool']),
            'base_price' => fake()->randomFloat(2, 49, 999),
            'status' => fake()->randomElement(['draft', 'active', 'archived']),
            'tech_stack' => ['PHP', 'JavaScript', 'MySQL'],
            'version' => '1.0.0',
            'created_by' => User::factory(),
        ];
    }

    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'active',
            'published_at' => now(),
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_featured' => true,
        ]);
    }
}