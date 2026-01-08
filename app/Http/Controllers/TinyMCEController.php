<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TinyMCEController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:5120', // max 5MB
        ]);

        $path = $request->file('file')->store('uploads', options: 'public');

        // Return JSON with location for TinyMCE
        return response()->json(['location' => Storage::url($path)]);
    }
  public function images(Request $request)
{
    // Configuration
    $perPage = 16; // Number of images per page
    $currentPage = $request->get('page', 1);
    
    // 1. Get ALL files from the folder
    $allFiles = Storage::disk('public')->files('uploads');

    // Filter to only include images (optional, but good practice)
    $imageFiles = array_filter($allFiles, function($file) {
        $mime = Storage::disk('public')->mimeType($file);
        return str_starts_with($mime, 'image/');
    });
    
    // Sort files (e.g., by last modified, or simply reverse for newest first)
    $imageFiles = array_reverse($imageFiles);
    
    $total = count($imageFiles);
    $lastPage = ceil($total / $perPage);
    
    // Ensure current page is valid
    $currentPage = max(1, min($currentPage, $lastPage > 0 ? $lastPage : 1));

    // 2. Calculate the slice (offset and limit)
    $offset = ($currentPage - 1) * $perPage;
    
    // 3. Get the files for the current page
    $currentFiles = array_slice($imageFiles, $offset, $perPage);

    // 4. Map the files to the expected structure
    $images = array_map(fn($file) => [
        'url' => Storage::url($file)
    ], $currentFiles);

    // 5. Return the JSON response with pagination metadata
    $baseUrl = route('tinymce.images'); // Get the base URL for navigation

    return response()->json([
        'data' => $images,
        'current_page' => (int)$currentPage,
        'per_page' => $perPage,
        'total' => $total,
        'last_page' => (int)$lastPage,
        // Manual links for simplicity (required by the JS below)
        'next_page_url' => $currentPage < $lastPage ? "{$baseUrl}?page=" . ($currentPage + 1) : null,
        'prev_page_url' => $currentPage > 1 ? "{$baseUrl}?page=" . ($currentPage - 1) : null,
    ]);
}
    
}
