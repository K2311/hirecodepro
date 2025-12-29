<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()->groupBy('category');
        $keyedSettings = SiteSetting::all()->keyBy('setting_key');
        return view('admin.settings.index', compact('settings', 'keyedSettings'));
    }

    public function update(Request $request)
    {
        // Handle File Uploads
        $files = ['site_logo_light', 'site_logo_dark', 'site_favicon'];
        foreach ($files as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                $path = $file->store('settings', 'public');

                // Update or Create the setting for the file
                SiteSetting::updateOrCreate(
                    ['setting_key' => $fileKey],
                    [
                        'setting_value' => Storage::disk('public')->url($path),
                        'category' => 'general',
                        'setting_type' => 'image',
                        'description' => $fileKey === 'site_favicon' ? 'Browser favicon' : 'Site Logo'
                    ]
                );
            }
        }

        // List of keys that should be treated as boolean if we need to create them
        $boolKeys = [
            'show_hero_section',
            'show_services_section',
            'show_products_section',
            'show_portfolio_section',
            'show_about_section',
            'show_testimonials_section',
            'show_blog_section',
            'show_contact_section',
            'stripe_enabled',
            'paypal_enabled',
            'paypal_sandbox',
            'bank_transfer_enabled',
            'notify_new_orders',
            'notify_new_messages',
            'enable_registrations',
            'enable_shopping_cart',
            'maintenance_mode'
        ];

        // Process all request data
        $data = $request->except(['_token', 'site_logo_light', 'site_logo_dark', 'site_favicon']);

        // 1. Handle explicit booleans from request (checked ones)
        foreach ($boolKeys as $key) {
            $value = $request->has($key) ? '1' : '0';
            SiteSetting::updateOrCreate(
                ['setting_key' => $key],
                [
                    'setting_value' => $value,
                    'setting_type' => 'boolean',
                    'category' => $this->inferCategory($key)
                ]
            );
        }

        // 2. Handle everything else
        foreach ($data as $key => $value) {
            // Already handled in booleans
            if (in_array($key, $boolKeys)) {
                continue;
            }

            SiteSetting::updateOrCreate(
                ['setting_key' => $key],
                [
                    'setting_value' => $value ?? '',
                    'category' => $this->inferCategory($key),
                    'setting_type' => $this->inferType($key, $value)
                ]
            );
        }

        return back()->with('success', 'Settings updated successfully.');
    }

    private function inferCategory($key)
    {
        if (str_starts_with($key, 'show_'))
            return 'home_page';
        if (str_contains($key, 'stripe') || str_contains($key, 'paypal') || str_contains($key, 'bank'))
            return 'payment';
        if (str_contains($key, 'social_'))
            return 'social';
        if (str_contains($key, 'color') || str_contains($key, 'hover'))
            return 'appearance';
        return 'general';
    }

    private function inferType($key, $value)
    {
        if (str_contains($key, 'color') || str_contains($key, 'hover'))
            return 'color';
        if (str_contains($key, 'email'))
            return 'string';
        if (is_numeric($value))
            return 'integer';
        return 'string';
    }

    public function resetColors()
    {
        $defaults = [
            'primary_color' => '#6366f1',
            'primary_hover' => '#4f46e5',
            'secondary_color' => '#10b981',
            'accent_color' => '#8b5cf6',
        ];

        foreach ($defaults as $key => $value) {
            SiteSetting::where('setting_key', $key)->update(['setting_value' => $value]);
        }

        return redirect()->back()->with('success', 'Website colors have been reset to default.');
    }

    public function removeImage(Request $request)
    {
        $request->validate([
            'setting_key' => 'required|string|in:site_logo_light,site_logo_dark,site_favicon'
        ]);

        SiteSetting::where('setting_key', $request->setting_key)->update(['setting_value' => '']);

        return redirect()->back()->with('success', 'Image removed successfully.');
    }
}
