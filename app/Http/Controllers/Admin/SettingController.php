<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
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
        // Example validation rules for common settings
        $request->validate([
            // Assuming the settings come in as an associative array named 'settings'
            'settings.*' => 'nullable|string|max:2000',
        ]);
        
        // Loop through the submitted 'settings' array and update or create each one
        foreach ($request->input('settings', []) as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // Redirect back with a success message
        return redirect()->route('admin.settings.index')
            ->with('success', 'Application settings updated successfully!');
    }
}
