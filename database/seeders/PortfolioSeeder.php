<?php
// database/seeders/PortfolioSeeder.php

namespace Database\Seeders;

use App\Models\PortfolioProject;
use App\Models\ProjectTestimonial;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Project Management SaaS',
                'slug' => 'project-management-saas',
                'client_name' => 'TechScale Inc.',
                'project_type' => 'SaaS Development',
                'challenge' => 'The client needed a comprehensive project management tool for their remote teams with real-time collaboration features.',
                'solution' => 'Built a full-stack SaaS application with React frontend, Node.js backend, and real-time updates using WebSockets.',
                'result' => 'Increased team productivity by 40% and reduced project management overhead by 60%.',
                'tech_stack' => ['React', 'Node.js', 'PostgreSQL', 'Redis', 'WebSockets'],
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'E-commerce Platform',
                'slug' => 'ecommerce-platform',
                'client_name' => 'FashionForward',
                'project_type' => 'E-commerce Development',
                'challenge' => 'The client wanted a modern e-commerce platform with AR try-on features and personalized recommendations.',
                'solution' => 'Developed a custom e-commerce solution with Next.js, integrated Shopify API, and implemented AI-powered recommendations.',
                'result' => 'Resulted in 120% revenue growth in the first quarter and improved customer engagement.',
                'tech_stack' => ['Next.js', 'Shopify API', 'Tailwind CSS', 'Stripe'],
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'AI Content Assistant',
                'slug' => 'ai-content-assistant',
                'client_name' => 'Digital Agency Co.',
                'project_type' => 'AI Integration',
                'challenge' => 'The agency needed a tool to help their content team generate marketing copy faster and more effectively.',
                'solution' => 'Created an AI-powered content generation tool with GPT integration and a collaborative workspace for teams.',
                'result' => 'Saved 70% of content creation time and improved content quality across all marketing channels.',
                'tech_stack' => ['Vue.js', 'Python', 'OpenAI API', 'FastAPI', 'PostgreSQL'],
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now(),
            ],
        ];

        foreach ($projects as $projectData) {
            $project = PortfolioProject::create($projectData);

            // Add testimonials for each project
            if ($project->slug === 'project-management-saas') {
                ProjectTestimonial::create([
                    'project_id' => $project->id,
                    'client_name' => 'Sarah Johnson',
                    'client_position' => 'Founder',
                    'client_company' => 'TechScale Inc.',
                    'content' => 'CodeCraft Studio delivered our SaaS platform ahead of schedule and under budget. Their expertise in React and Node.js was evident throughout the project.',
                    'rating' => 5,
                    'is_featured' => true,
                    'is_published' => true,
                ]);
            }

            if ($project->slug === 'ecommerce-platform') {
                ProjectTestimonial::create([
                    'project_id' => $project->id,
                    'client_name' => 'Michael Chen',
                    'client_position' => 'CEO',
                    'client_company' => 'FashionForward',
                    'content' => 'The e-commerce platform they built for us increased our revenue by 120% in the first quarter. Their attention to detail and user experience is exceptional.',
                    'rating' => 5,
                    'is_featured' => true,
                    'is_published' => true,
                ]);
            }

            if ($project->slug === 'ai-content-assistant') {
                ProjectTestimonial::create([
                    'project_id' => $project->id,
                    'client_name' => 'Emily Wilson',
                    'client_position' => 'Project Manager',
                    'client_company' => 'Digital Agency Co.',
                    'content' => 'The AI content assistant has transformed our content creation process. We\'re now producing higher quality content in a fraction of the time.',
                    'rating' => 5,
                    'is_featured' => false,
                    'is_published' => true,
                ]);
            }
        }
    }
}