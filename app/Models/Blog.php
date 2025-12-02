<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'content', 'author_id', 'is_published','category_id'];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    protected static function booted()
    {
        static::creating(fn($blog) => $blog->slug = Str::slug($blog->title));
        static::updating(fn($blog) => $blog->slug = Str::slug($blog->title));
    }
}
