<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $settings = [
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
        ];

        foreach ($settings as $setting) {
            DB::table('site_settings')->insertOrIgnore($setting);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('site_settings')
            ->where('category', 'appearance')
            ->delete();
    }
};
