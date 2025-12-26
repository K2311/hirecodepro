<?php
// database/seeders/ProductCategorySeeder.php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'SaaS Starter Kits',
                'slug' => 'saas-starter-kits',
                'description' => 'Complete SaaS application templates with authentication, payments, and admin dashboard',
                'icon' => 'rocket',
                'color' => '#3b82f6',
                'sort_order' => 1,
            ],
            [
                'name' => 'APIs',
                'slug' => 'apis',
                'description' => 'RESTful and GraphQL APIs for common functionalities',
                'icon' => 'cloud',
                'color' => '#0f766e',
                'sort_order' => 2,
            ],
            [
                'name' => 'WordPress Plugins',
                'slug' => 'wordpress-plugins',
                'description' => 'Premium WordPress plugins for enhanced functionality',
                'icon' => 'plug',
                'color' => '#7c3aed',
                'sort_order' => 3,
            ],
            [
                'name' => 'UI Components',
                'slug' => 'ui-components',
                'description' => 'Reusable UI components and design systems',
                'icon' => 'puzzle-piece',
                'color' => '#f59e0b',
                'sort_order' => 4,
            ],
            [
                'name' => 'Developer Tools',
                'slug' => 'developer-tools',
                'description' => 'Tools and scripts to boost developer productivity',
                'icon' => 'tools',
                'color' => '#10b981',
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}