<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MenuCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
                $count = 0;
                $originalSlug = $category->slug;
                while (static::where('slug', $category->slug)->exists()) {
                    $count++;
                    $category->slug = $originalSlug . '-' . $count;
                }
            }
        });
    }

    public function menus()
    {
        return $this->hasMany(Menu::class, 'category_id');
    }
}