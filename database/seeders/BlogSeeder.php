<?php
// database/seeders/BlogSeeder.php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\CodeSnippet;
use App\Models\User;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        // Create blog categories
        $categories = [
            ['name' => 'Tutorials', 'slug' => 'tutorials', 'description' => 'Step-by-step coding tutorials and guides'],
            ['name' => 'Development', 'slug' => 'development', 'description' => 'Software development best practices and insights'],
            ['name' => 'Business', 'slug' => 'business', 'description' => 'Tips for running a successful development business'],
            ['name' => 'AI & ML', 'slug' => 'ai-ml', 'description' => 'Artificial intelligence and machine learning in development'],
        ];

        $categoryIds = [];
        foreach ($categories as $categoryData) {
            $category = BlogCategory::create($categoryData);
            $categoryIds[$category->slug] = $category->id;
        }

        $adminId = User::where('username', 'admin')->first()->id;

        // Create blog posts
        $posts = [
            [
                'title' => 'Building a Scalable SaaS Architecture',
                'slug' => 'building-scalable-saas-architecture',
                'excerpt' => 'Learn how to design and implement a scalable architecture for your SaaS application from the ground up.',
                'content' => 'Full article content here... This is a detailed guide on building scalable SaaS applications...',
                'category_id' => $categoryIds['development'],
                'author_id' => $adminId,
                'status' => 'published',
                'is_featured' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Top 10 React Components Every Developer Should Know',
                'slug' => 'top-react-components',
                'excerpt' => 'Discover the most useful React components that can speed up your development process.',
                'content' => 'Full article content here... This article covers essential React components...',
                'category_id' => $categoryIds['tutorials'],
                'author_id' => $adminId,
                'status' => 'published',
                'is_featured' => false,
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'How I Made $10K Selling Digital Products',
                'slug' => 'made-10k-digital-products',
                'excerpt' => 'My journey from writing code for clients to creating and selling digital products.',
                'content' => 'Full article content here... Learn how to monetize your skills...',
                'category_id' => $categoryIds['business'],
                'author_id' => $adminId,
                'status' => 'published',
                'is_featured' => true,
                'published_at' => now()->subDays(15),
            ],
        ];

        foreach ($posts as $postData) {
            BlogPost::create($postData);
        }

        // Create code snippets
        $snippets = [
            [
                'title' => 'Email Validation Regex',
                'slug' => 'email-validation-regex',
                'description' => 'Comprehensive regex pattern for email validation',
                'code' => 'const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;',
                'language' => 'javascript',
                'tags' => ['regex', 'validation', 'email'],
                'view_count' => 150,
                'is_published' => true,
            ],
            [
                'title' => 'API Rate Limiter Middleware',
                'slug' => 'api-rate-limiter-middleware',
                'description' => 'Express middleware for API rate limiting',
                'code' => "const rateLimit = require('express-rate-limit');

const limiter = rateLimit({
  windowMs: 15 * 60 * 1000, // 15 minutes
  max: 100, // limit each IP to 100 requests per windowMs
  message: 'Too many requests from this IP, please try again later.'
});

app.use('/api/', limiter);",
                'language' => 'javascript',
                'tags' => ['api', 'security', 'express', 'middleware'],
                'view_count' => 89,
                'is_published' => true,
            ],
        ];

        foreach ($snippets as $snippetData) {
            CodeSnippet::create($snippetData);
        }
    }
}