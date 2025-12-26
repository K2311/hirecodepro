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

        // FIRST: Handle ALL boolean settings (checkboxes)
        // This ensures unchecked boxes are properly set to '0'
        $booleanSettings = SiteSetting::where('setting_type', 'boolean')->get();

        foreach ($booleanSettings as $boolSetting) {
            $hasKey = $request->has($boolSetting->setting_key);
            $newValue = $hasKey ? '1' : '0';
            $boolSetting->update(['setting_value' => $newValue]);
        }

        // SECOND: Handle non-boolean settings (text, select, etc.)
        $data = $request->except(['_token', 'site_logo_light', 'site_logo_dark', 'site_favicon']);

        foreach ($data as $key => $value) {
            $setting = SiteSetting::where('setting_key', $key)->first();

            // Skip if this is a boolean setting (already handled above)
            if ($setting && $setting->setting_type === 'boolean') {
                continue;
            }

            // Update non-boolean settings
            if ($setting) {
                $setting->update(['setting_value' => $value]);
            }
        }

        return back()->with('success', 'Settings updated successfully.');
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
