<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'services';

    protected $fillable = [
        'title',
        'sub_heading',
        'slug',
        'description',
        'image',
        'status',
        'featured',
        'youtube_url',
        'amount',

        //  SEO META
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'status' => 'boolean',
        'featured' => 'boolean',
         'amount' => 'integer',
    ];

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeFeatured($query)
    {
        return
            $query->where('featured', true);
    }

    public function getYoutubeEmbedUrlAttribute()
    {
        if (!$this->youtube_url)
            return null;

        return str_replace('watch?v=', 'embed/', $this->youtube_url);
    }

    /**
     * Model events
     */
    protected static function booted()
    {
        static::creating(function (Service $service) {
            // Auto-generate slug if missing
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->title);
            }

            // ✅ SEO FALLBACKS
            if (empty($service->meta_title)) {
                $service->meta_title = Str::limit($service->title, 60, '');
            }

            if (empty($service->meta_description) && !empty($service->description)) {
                $service->meta_description = Str::limit(
                    strip_tags($service->description),
                    160,
                    ''
                );
            }
        });
    }
}
