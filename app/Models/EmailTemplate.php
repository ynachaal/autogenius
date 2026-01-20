<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    // Only keep fillable fields that exist in the database
    protected $fillable = ['title', 'subject', 'content', 'is_published'];
}
