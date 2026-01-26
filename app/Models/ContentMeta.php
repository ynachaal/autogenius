<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentMeta extends Model
{
    protected $table = 'content_meta';

    // timestamps enabled because migration uses created_at / updated_at
    public $timestamps = true;

    protected $fillable = [
        'meta_key',
        'meta_value',
    ];

    /**
     * Get a meta value by key
     */
    public static function getMeta(string $key, $default = null)
    {
        $meta = self::where('meta_key', $key)->first();
        return $meta ? $meta->meta_value : $default;
    }

    /**
     * Set or update a meta value
     */
    public static function setMeta(string $key, $value)
    {
        return self::updateOrCreate(
            ['meta_key' => $key],
            ['meta_value' => $value]
        );
    }

    /**
     * Get all meta as key => value array
     */
    public static function allMeta(): array
    {
        return self::pluck('meta_value', 'meta_key')->toArray();
    }
}
