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
            // Added MP4 only validation with 4MB (4096KB) limit
            'home_page_video' => 'nullable|mimes:mp4|max:10096',
        ], [
            'settings.phone.regex' => 'The phone number may only contain numbers, spaces, and the + symbol.',
            'home_page_video.mimes' => 'The home page video must be an MP4 file.',
            'home_page_video.max' => 'The video may not be greater than 10MB.',
        ]);

        // Handle Site Logo upload
        if ($request->hasFile('site_logo')) {
            $this->uploadAndOverwrite($request->file('site_logo'), 'site_logo');
        }

        // Handle Site CEO Image upload
        if ($request->hasFile('site_ceo_image')) {
            $this->uploadAndOverwrite($request->file('site_ceo_image'), 'site_ceo_image');
        }

        // Handle Home Page Video upload (Overwrite logic)
        if ($request->hasFile('home_page_video')) {
            $oldVideo = Setting::where('key', 'home_page_video')->first();

            // Delete old video if it exists
            if ($oldVideo && !empty($oldVideo->value)) {
                $oldPath = public_path($oldVideo->value);
                if (file_exists($oldPath) && is_file($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Store new video
            $video = $request->file('home_page_video');
            $videoName = 'home_video_' . time() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('uploads/'), $videoName);

            // Save path in database
            Setting::updateOrCreate(
                ['key' => 'home_page_video'],
                ['value' => 'uploads/' . $videoName]
            );
        }

        // Handle Smart Car Requirement Image
        if ($request->hasFile('smart_car_requirement_image')) {
            // Note: This uses storage/app/public pattern per your previous code
            $carImagePath = $request->file('smart_car_requirement_image')->store('uploads/settings', 'public');
            
            Setting::updateOrCreate(
                ['key' => 'smart_car_requirement_image'], 
                ['value' => 'storage/' . $carImagePath]
            );
        }

        // Loop through the submitted 'settings' array and update each one
        foreach ($request->input('settings', []) as $key => $value) {
            if ($key === 'phone' && !empty($value)) {
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

    /**
     * Private helper to handle image upload and overwrite existing files
     */
    private function uploadAndOverwrite($file, $key)
    {
        $oldRecord = Setting::where('key', $key)->first();

        if ($oldRecord && !empty($oldRecord->value)) {
            $oldFilePath = public_path($oldRecord->value);
            if (file_exists($oldFilePath) && is_file($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/'), $fileName);

        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => 'uploads/' . $fileName]
        );
    }
}