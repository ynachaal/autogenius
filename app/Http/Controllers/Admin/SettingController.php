<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SettingController extends Controller
{
    /**
     * Display a listing of the settings.
     */
    public function index()
    {
        // Fetch all settings and pass them to the view as a key-value collection
        $settings = Setting::all()->keyBy('key');

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update the specified resources in storage.
     */
    public function update(Request $request)
    {
        // Validation rules
        $request->validate([
            'settings.*' => 'nullable|string|max:2000',
            'settings.phone' => ['nullable', 'regex:/^[\+0-9 ]*$/'],
            'site_logo'  => 'nullable|mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/svg+xml|max:2048',
            'site_ceo_image'  => 'nullable|mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/svg+xml|max:2048',
        ], [
            'settings.phone.regex' => 'The phone number may only contain numbers, spaces, and the + symbol.'
        ]);

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            $oldLogo = Setting::where('key', 'site_logo')->first();

            // Delete old logo if it exists and is a file
            if ($oldLogo && !empty($oldLogo->value)) {
                $oldFilePath = public_path($oldLogo->value);
                if (file_exists($oldFilePath) && is_file($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            // Store new logo in public/images
            $image = $request->file('site_logo');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/'), $imageName);

            // Save path in database
            Setting::updateOrCreate(
                ['key' => 'site_logo'],
                ['value' => 'uploads/' . $imageName]
            );
        }
        if ($request->hasFile('site_ceo_image')) {
            $oldLogo = Setting::where('key', 'site_ceo_image')->first();

            // Delete old logo if it exists and is a file
            if ($oldLogo && !empty($oldLogo->value)) {
                $oldFilePath = public_path($oldLogo->value);
                if (file_exists($oldFilePath) && is_file($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            // Store new logo in public/images
            $image = $request->file('site_ceo_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/'), $imageName);

            // Save path in database
            Setting::updateOrCreate(
                ['key' => 'site_ceo_image'],
                ['value' => 'uploads/' . $imageName]
            );
        }

        if ($request->hasFile('smart_car_requirement_image')) {
        // Store the file and get the path
        $carImagePath = $request->file('smart_car_requirement_image')->store('uploads/settings', 'public');
        
        // Save the path to the settings table
        Setting::updateOrCreate(
            ['key' => 'smart_car_requirement_image'], 
            ['value' => 'storage/' . $carImagePath]
        );
    }

        // Loop through the submitted 'settings' array and update or create each one
        foreach ($request->input('settings', []) as $key => $value) {
            // Check if the current key is the phone field
            if ($key === 'phone' && !empty($value)) {
                /** * Replace anything that is NOT a digit or a plus sign with a space.
                 * This handles hyphens, dots, or brackets if they somehow bypassed validation.
                 */
                $value = preg_replace('/[^\d+]/', ' ', $value);
            }
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Application settings updated successfully!');
    }
}
