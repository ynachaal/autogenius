<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'external_link',
        'page_id',
        'post_id',
        'parent_id',
        'category_id',
        'order',
        'is_active',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function post()
    {
        return $this->belongsTo(Blog::class);
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }
     public function category()
    {
        return $this->belongsTo(MenuCategory::class, 'category_id');
    }
}