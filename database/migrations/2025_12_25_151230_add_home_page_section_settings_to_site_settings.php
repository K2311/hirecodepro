<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Insert home page section settings
        $sections = [
            ['setting_key' => 'show_hero_section', 'setting_value' => '1', 'setting_type' => 'boolean', 'category' => 'home_page', 'description' => 'Show/hide hero section on home page', 'is_public' => true],
            ['setting_key' => 'show_services_section', 'setting_value' => '1', 'setting_type' => 'boolean', 'category' => 'home_page', 'description' => 'Show/hide services section on home page', 'is_public' => true],
            ['setting_key' => 'show_products_section', 'setting_value' => '1', 'setting_type' => 'boolean', 'category' => 'home_page', 'description' => 'Show/hide products section on home page', 'is_public' => true],
            ['setting_key' => 'show_portfolio_section', 'setting_value' => '1', 'setting_type' => 'boolean', 'category' => 'home_page', 'description' => 'Show/hide portfolio section on home page', 'is_public' => true],
            ['setting_key' => 'show_about_section', 'setting_value' => '1', 'setting_type' => 'boolean', 'category' => 'home_page', 'description' => 'Show/hide about section on home page', 'is_public' => true],
            ['setting_key' => 'show_testimonials_section', 'setting_value' => '1', 'setting_type' => 'boolean', 'category' => 'home_page', 'description' => 'Show/hide testimonials section on home page', 'is_public' => true],
            ['setting_key' => 'show_blog_section', 'setting_value' => '1', 'setting_type' => 'boolean', 'category' => 'home_page', 'description' => 'Show/hide blog section on home page', 'is_public' => true],
            ['setting_key' => 'show_contact_section', 'setting_value' => '1', 'setting_type' => 'boolean', 'category' => 'home_page', 'description' => 'Show/hide contact section on home page', 'is_public' => true],
        ];

        foreach ($sections as $section) {
            DB::table('site_settings')->insertOrIgnore($section);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('site_settings')
            ->where('category', 'home_page')
            ->delete();
    }
};
