<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 1. Import the trait
class Testimonial extends Model
{
use HasFactory, SoftDeletes; // 2. Use the trait
    protected $fillable = [
        'title',
        'designation', // Add this here
        'description',
        'image',
        'youtube_url',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'order'  => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true)->orderBy('order', 'asc');
    }
}