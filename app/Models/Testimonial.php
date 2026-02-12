<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

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