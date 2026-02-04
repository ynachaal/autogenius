<?php

namespace App\Services;

use App\Models\ContentMeta;
use Illuminate\Support\Facades\Cache;

class ContentMetaService
{
    protected $ttl = 86400; // 24 hours in seconds

    /**
     * Retrieve a specific meta value for a section.
     */
    public function getValue(string $section, string $key, $default = null)
    {
        $cacheKey = "content_meta.{$section}.{$key}";

        return Cache::remember($cacheKey, $this->ttl, function () use ($section, $key, $default) {
            $meta = ContentMeta::where('meta_key', "{$section}_{$key}")->first();
            return $meta ? $meta->meta_value : $default;
        });
    }

    /**
     * Get all values for a section as a simple key-value array.
     */
    public function getAllValues(string $section): array
    {
        $cacheKey = "content_meta_all.{$section}";

        return Cache::remember($cacheKey, $this->ttl, function () use ($section) {
            return ContentMeta::where('meta_key', 'like', $section . '_%')
                ->get()
                ->mapWithKeys(function ($item) use ($section) {
                    $cleanKey = str_replace($section . '_', '', $item->meta_key);
                    return [$cleanKey => $item->meta_value];
                })->toArray();
        });
    }
}