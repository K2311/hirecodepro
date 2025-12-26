<?php
// database/seeders/ServiceSeeder.php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServicePackage;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Custom web applications built with modern technologies',
                'icon' => 'code',
                'pricing_model' => 'fixed',
                'base_rate' => 5000,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'API Development',
                'slug' => 'api-development',
                'description' => 'RESTful and GraphQL API design and implementation',
                'icon' => 'cloud',
                'pricing_model' => 'hourly',
                'base_rate' => 100,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'SaaS Development',
                'slug' => 'saas-development',
                'description' => 'End-to-end SaaS platform development',
                'icon' => 'rocket',
                'pricing_model' => 'monthly',
                'base_rate' => 3000,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'AI Integrations',
                'slug' => 'ai-integrations',
                'description' => 'Integrate AI capabilities into your applications',
                'icon' => 'robot',
                'pricing_model' => 'hourly',
                'base_rate' => 150,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'WordPress Development',
                'slug' => 'wordpress-development',
                'description' => 'Custom WordPress themes and plugins',
                'icon' => 'wordpress',
                'pricing_model' => 'fixed',
                'base_rate' => 2500,
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Automation',
                'slug' => 'automation',
                'description' => 'Workflow automation and process optimization',
                'icon' => 'cogs',
                'pricing_model' => 'hourly',
                'base_rate' => 80,
                'is_featured' => false,
                'is_active' => true,
            ],
        ];

        foreach ($services as $serviceData) {
            $service = Service::create($serviceData);

            // Add packages for Web Development
            if ($service->slug === 'web-development') {
                $packages = [
                    [
                        'name' => 'Basic Website',
                        'description' => 'Simple responsive website with up to 5 pages',
                        'price' => 2000,
                        'features' => [
                            'Responsive design',
                            'SEO optimization',
                            'Contact form',
                            'Basic analytics',
                            '1 revision'
                        ],
                        'delivery_days' => 14,
                        'is_popular' => false,
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Business Website',
                        'description' => 'Professional website with CMS and advanced features',
                        'price' => 5000,
                        'features' => [
                            'Custom design',
                            'Content management system',
                            'Blog integration',
                            'Advanced forms',
                            '3 revisions',
                            'SEO setup',
                            'Performance optimization'
                        ],
                        'delivery_days' => 30,
                        'is_popular' => true,
                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'E-commerce Platform',
                        'description' => 'Complete online store with payment integration',
                        'price' => 10000,
                        'features' => [
                            'Product catalog',
                            'Shopping cart',
                            'Payment gateway',
                            'User accounts',
                            'Order management',
                            'Inventory tracking',
                            'Shipping integration',
                            '5 revisions'
                        ],
                        'delivery_days' => 60,
                        'is_popular' => false,
                        'sort_order' => 3,
                    ],
                ];

                foreach ($packages as $packageData) {
                    $service->packages()->create($packageData);
                }
            }
        }
    }
}