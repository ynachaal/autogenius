<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Slider extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'slider_category_id',
        'type',
        'file',
        'status',
        'heading',
        'subheading',
        'button1_text',
        'button1_link',
        'button2_text',
        'button2_link',
    ];

    protected $casts = [
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relationship: A slider belongs to a category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(SliderCategory::class, 'slider_category_id');
    }

    /**
     * Scope for active sliders.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}