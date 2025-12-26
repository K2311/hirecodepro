<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // --- GENERAL ---
            [
                'setting_key' => 'site_name',
                'setting_value' => 'HireCadePro',
                'setting_type' => 'string',
                'category' => 'general',
                'description' => 'The name of your website',
                'is_public' => true,
            ],
            [
                'setting_key' => 'site_logo_light',
                'setting_value' => '',
                'setting_type' => 'image',
                'category' => 'general',
                'description' => 'Logo for light theme',
                'is_public' => true,
            ],
            [
                'setting_key' => 'site_logo_dark',
                'setting_value' => '',
                'setting_type' => 'image',
                'category' => 'general',
                'description' => 'Logo for dark theme',
                'is_public' => true,
            ],
            [
                'setting_key' => 'site_favicon',
                'setting_value' => '',
                'setting_type' => 'image',
                'category' => 'general',
                'description' => 'Browser favicon',
                'is_public' => true,
            ],
            [
                'setting_key' => 'site_description',
                'setting_value' => 'HireCadePro delivers elite web architecture, scalable APIs, and high-performance SaaS products.',
                'setting_type' => 'text',
                'category' => 'general',
                'description' => 'Meta description for SEO',
                'is_public' => true,
            ],
            [
                'setting_key' => 'contact_email',
                'setting_value' => 'contact@hirecadepro.com',
                'setting_type' => 'string',
                'category' => 'general',
                'description' => 'Main contact email address',
                'is_public' => true,
            ],
            [
                'setting_key' => 'support_email',
                'setting_value' => 'support@hirecadepro.com',
                'setting_type' => 'string',
                'category' => 'general',
                'description' => 'Public support email',
                'is_public' => true,
            ],
            [
                'setting_key' => 'phone_number',
                'setting_value' => '+1 (555) 000-0000',
                'setting_type' => 'string',
                'category' => 'general',
                'description' => 'Contact phone number',
                'is_public' => true,
            ],
            [
                'setting_key' => 'business_address',
                'setting_value' => 'Tech Park, Digital City',
                'setting_type' => 'text',
                'category' => 'general',
                'description' => 'Physical business address',
                'is_public' => true,
            ],

            // --- APPEARANCE ---
            [
                'setting_key' => 'primary_color',
                'setting_value' => '#6366f1',
                'setting_type' => 'color',
                'category' => 'appearance',
                'description' => 'Main brand color',
                'is_public' => true
            ],
            [
                'setting_key' => 'primary_dark',
                'setting_value' => '#4f46e5',
                'setting_type' => 'color',
                'category' => 'appearance',
                'description' => 'Darker shade of primary color',
                'is_public' => true
            ],
            [
                'setting_key' => 'secondary_color',
                'setting_value' => '#f59e0b',
                'setting_type' => 'color',
                'category' => 'appearance',
                'description' => 'Secondary brand color',
                'is_public' => true
            ],
            [
                'setting_key' => 'accent_color',
                'setting_value' => '#8b5cf6',
                'setting_type' => 'color',
                'category' => 'appearance',
                'description' => 'Accent color for highlights',
                'is_public' => true
            ],
            [
                'setting_key' => 'border_radius',
                'setting_value' => '12px',
                'setting_type' => 'string',
                'category' => 'appearance',
                'description' => 'Global border radius',
                'is_public' => true
            ],

            // --- HOME PAGE SECTIONS ---
            ['setting_key' => 'show_hero_section', 'setting_value' => '1', 'setting_type' => 'boolean', 'category' => 'home_page', 'description' => 'Show hero section', 'is_public' => true],
            ['setting_key' => 'show_services_section', 'setting_value' => '1', 'setting_type' => 'boolean', 'category' => 'home_page', 'description' => 'Show services section', 'is_public' => true],
            ['setting_key' => 'show_products_section', 'setting_value' => '1', 'setting_type' => 'boolean', 'category' => 'home_page', 'description' => 'Show products section', 'is_public' => true],
            ['setting_key' => 'show_portfolio_section', 'setting_value' => '1', 'setting_type' => 'boolean', 'category' => 'home_page', 'description' => 'Show portfolio section', 'is_public' => true],
            ['setting_key' => 'show_about_section', 'setting_value' => '1', 'setting_type' => 'boolean', 'category' => 'home_page', 'description' => 'Show about section', 'is_public' => true],
            ['setting_key' => 'show_testimonials_section', 'setting_value' => '1', 'setting_type' => 'boolean', 'category' => 'home_page', 'description' => 'Show testimonials section', 'is_public' => true],
            ['setting_key' => 'show_blog_section', 'setting_value' => '1', 'setting_type' => 'boolean', 'category' => 'home_page', 'description' => 'Show blog section', 'is_public' => true],
            ['setting_key' => 'show_contact_section', 'setting_value' => '1', 'setting_type' => 'boolean', 'category' => 'home_page', 'description' => 'Show contact section', 'is_public' => true],

            // --- SOCIAL ---
            [
                'setting_key' => 'social_facebook',
                'setting_value' => 'https://facebook.com/',
                'setting_type' => 'string',
                'category' => 'social',
                'description' => 'Facebook page URL',
                'is_public' => true,
            ],
            [
                'setting_key' => 'social_twitter',
                'setting_value' => 'https://twitter.com/',
                'setting_type' => 'string',
                'category' => 'social',
                'description' => 'Twitter profile URL',
                'is_public' => true,
            ],
            [
                'setting_key' => 'social_linkedin',
                'setting_value' => 'https://linkedin.com/',
                'setting_type' => 'string',
                'category' => 'social',
                'description' => 'LinkedIn profile URL',
                'is_public' => true,
            ],
            [
                'setting_key' => 'social_instagram',
                'setting_value' => 'https://instagram.com/',
                'setting_type' => 'string',
                'category' => 'social',
                'description' => 'Instagram profile URL',
                'is_public' => true,
            ],

            // --- FEATURES ---
            [
                'setting_key' => 'enable_registrations',
                'setting_value' => '1',
                'setting_type' => 'boolean',
                'category' => 'features',
                'description' => 'Allow new users to register',
                'is_public' => false,
            ],
            [
                'setting_key' => 'maintenance_mode',
                'setting_value' => '0',
                'setting_type' => 'boolean',
                'category' => 'features',
                'description' => 'Put site in maintenance mode',
                'is_public' => false,
            ],
            [
                'setting_key' => 'enable_shopping_cart',
                'setting_value' => '1',
                'setting_type' => 'boolean',
                'category' => 'features',
                'description' => 'Enable global shopping cart',
                'is_public' => true,
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['setting_key' => $setting['setting_key']],
                $setting
            );
        }
    }
}
