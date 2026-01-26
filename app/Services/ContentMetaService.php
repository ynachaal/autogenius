<?php

namespace App\Services;

use App\Models\ContentMeta;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;

class ContentMetaService
{
    /**
     * Retrieve a specific meta value for a section.
     */
    public function getValue(string $section, string $key, $default = null)
    {
        $meta = ContentMeta::where('meta_key', "{$section}_{$key}")->first();
        return $meta ? $meta->meta_value : $default;
    }

    /**
     * Get all values for a section as a simple key-value array.
     */
    public function getAllValues(string $section): array
    {
        return ContentMeta::where('meta_key', 'like', $section . '_%')
            ->get()
            ->mapWithKeys(function ($item) use ($section) {
                // Remove the "section_" prefix from the key for cleaner frontend use
                $cleanKey = str_replace($section . '_', '', $item->meta_key);
                return [$cleanKey => $item->meta_value];
            })->toArray();
    }
}