<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'brands';

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'meta_title',
        'meta_keywords',
        'meta_description',
        'name',
        'slug',
        'image',
        'description',
        'status',
        'is_featured',
        'order',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'is_featured' => 'boolean',
        'order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Default attribute values
     */
    protected $attributes = [
        'status' => 'active',
        'is_featured' => 0,
        'order' => 0,
    ];

    /**
     * Boot method to auto-generate unique slug
     */
    protected static function booted()
    {
        static::creating(function ($brand) {
            $brand->slug = static::generateUniqueSlug($brand->name);
        });

        // Optional: regenerate slug if name changes
        static::updating(function ($brand) {
            if ($brand->isDirty('name')) {
                $brand->slug = static::generateUniqueSlug($brand->name, $brand->id);
            }
        });
    }

    /**
     * Generate a unique slug
     */
    protected static function generateUniqueSlug($name, $ignoreId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }
}
