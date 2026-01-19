<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    // Table name (optional if it follows Laravel convention)
    protected $table = 'roles';

    // Mass assignable fields
    protected $fillable = [
        'name',
        'code',
        'status',
    ];

    // Soft delete column
    protected $dates = ['deleted_at'];
}
