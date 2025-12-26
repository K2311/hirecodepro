<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $adminId = $admin ? $admin->id : null;

        // Categories
        $softwareCat = ProductCategory::updateOrCreate(
            ['slug' => 'enterprise-software'],
            ['name' => 'Enterprise Software', 'description' => 'Robust software solutions for business management.', 'icon' => 'building', 'color' => '#e35b2e', 'is_active' => true]
        );

        $appCat = ProductCategory::updateOrCreate(
            ['slug' => 'mobile-web-apps'],
            ['name' => 'Mobile & Web Apps', 'description' => 'Modern applications for web and mobile platforms.', 'icon' => 'mobile-alt', 'color' => '#3b82f6', 'is_active' => true]
        );

        $scriptCat = ProductCategory::updateOrCreate(
            ['slug' => 'scripts-tools'],
            ['name' => 'Scripts & Tools', 'description' => 'Useful scripts and automation tools.', 'icon' => 'code', 'color' => '#10b981', 'is_active' => true]
        );

        $saasCat = ProductCategory::updateOrCreate(
            ['slug' => 'saas-templates'],
            ['name' => 'SaaS Templates', 'description' => 'Ready-to-use SaaS application foundations.', 'icon' => 'rocket', 'color' => '#8b5cf6', 'is_active' => true]
        );

        $products = [
            [
                'name' => 'Inventory & Billing Software (ERP)',
                'category_id' => $softwareCat->id,
                'short_description' => 'Complete business management solution with advanced inventory tracking and automated billing.',
                'full_description' => '<p>A comprehensive ERP solution designed for modern businesses. Streamline your operations with powerful inventory management, real-time billing, and insightful analytics.</p>',
                'product_type' => 'Software',
                'base_price' => 499.00,
                'sale_price' => 299.00,
                'is_featured' => true,
                'is_on_sale' => true,
                'status' => 'active',
                'tech_stack' => ['Laravel', 'Vue.js', 'MySQL', 'Tailwind CSS'],
                'features' => ['Inventory Management', 'POS Integration', 'Accounts Payable/Receivable', 'Tax Management'],
                'version' => '2.1.0',
                'created_by' => $adminId,
                'published_at' => now(),
            ],
            [
                'name' => 'CRM Web & Mobile APP',
                'category_id' => $appCat->id,
                'short_description' => 'Customer relationship excellence with modern web and mobile applications to track leads and sales.',
                'full_description' => '<p>Master your customer relationships with our intuitive CRM. Available on both web and mobile platforms, it ensures your sales team stays connected and productive anywhere.</p>',
                'product_type' => 'App',
                'base_price' => 350.00,
                'sale_price' => 199.00,
                'is_featured' => true,
                'is_on_sale' => true,
                'status' => 'active',
                'tech_stack' => ['Node.js', 'React Native', 'MongoDB', 'PostgreSQL'],
                'features' => ['Lead Management', 'Live Chat Integration', 'Email Marketing', 'Mobile-First Design'],
                'version' => '1.5.2',
                'created_by' => $adminId,
                'published_at' => now(),
            ],
            [
                'name' => 'Hospital & Clinic Management System (HMS)',
                'category_id' => $softwareCat->id,
                'short_description' => 'Healthcare system solutions for clinics and hospitals to manage patients, doctors, and appointments.',
                'full_description' => '<p>Transform your healthcare facility with our robust HMS. Designed to simplify patient care and administrative tasks.</p>',
                'product_type' => 'Software',
                'base_price' => 899.00,
                'sale_price' => 599.00,
                'is_featured' => false,
                'is_on_sale' => true,
                'status' => 'active',
                'tech_stack' => ['PHP', 'Laravel', 'React', 'PostgreSQL'],
                'features' => ['Patient Records', 'Doctor Management', 'Lab Integration', 'OPD/IPD Management'],
                'version' => '3.0.1',
                'created_by' => $adminId,
                'published_at' => now(),
            ],
            [
                'name' => 'WhatsApp Bulk Messaging Tool',
                'category_id' => $scriptCat->id,
                'short_description' => 'Business messaging platform for bulk WhatsApp communication.',
                'full_description' => '<p>Reach your customers where they are. Our WhatsApp marketing tool allows you to send bulk messages and automate replies.</p>',
                'product_type' => 'Script',
                'base_price' => 120.00,
                'sale_price' => 89.00,
                'is_featured' => true,
                'is_on_sale' => true,
                'status' => 'active',
                'tech_stack' => ['Python', 'Node.js', 'Redis'],
                'features' => ['API Access', 'Broadcasting', 'Chat History', 'Multi-Instance Support'],
                'version' => '4.2.0',
                'created_by' => $adminId,
                'published_at' => now(),
            ],
            [
                'name' => 'Ecommerce Platform Suite',
                'category_id' => $appCat->id,
                'short_description' => 'Online retail power with a full-featured ecommerce platform and mobile shopping apps.',
                'full_description' => '<p>Launch your online store today. Our ecommerce suite includes a powerful admin panel and beautiful storefront.</p>',
                'product_type' => 'App',
                'base_price' => 750.00,
                'sale_price' => 499.00,
                'is_featured' => true,
                'is_on_sale' => true,
                'status' => 'active',
                'tech_stack' => ['Next.js', 'NestJS', 'PostgreSQL', 'Flutter'],
                'features' => ['Payment Integration', 'SEO Optimized', 'Vendor Dashboard', 'Mobile Commerce'],
                'version' => '2.5.0',
                'created_by' => $adminId,
                'published_at' => now(),
            ],
            [
                'name' => 'SaaS Starter Kit Pro',
                'category_id' => $saasCat->id,
                'short_description' => 'The ultimate foundation for your next SaaS project with multi-tenancy and subscriptions.',
                'full_description' => '<p>Save hundreds of hours with our SaaS starter kit. Includes everything from auth to billing.</p>',
                'product_type' => 'Template',
                'base_price' => 249.00,
                'sale_price' => 179.00,
                'is_featured' => true,
                'is_on_sale' => true,
                'status' => 'active',
                'tech_stack' => ['Laravel 11', 'Inertia.js', 'Vue 3', 'Stripe'],
                'features' => ['Multi-tenancy', 'Subscription Billing', 'User Roles', 'Admin Dashboard'],
                'version' => '1.0.0',
                'created_by' => $adminId,
                'published_at' => now(),
            ],
        ];

        foreach ($products as $data) {
            $data['slug'] = Str::slug($data['name']);
            Product::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}