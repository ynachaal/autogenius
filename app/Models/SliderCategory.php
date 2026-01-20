<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SliderCategory extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'slider_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Scope a query to only include active categories.
     * * Usage: SliderCategory::active()->get();
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Relationship: A category can have many sliders
     * (Uncomment this once you create the Slider model)
     */
    /*
    public function sliders()
    {
        return $this->hasMany(Slider::class, 'category_id');
    }
    */
}