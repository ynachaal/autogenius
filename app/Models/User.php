<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'role', // stores role CODE (01, 02)
    ];

    /**
     * Hidden attributes
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Role relationship (joined via role code)
     */
    public function roleData()
    {
        return $this->belongsTo(
            \App\Models\Role::class,
            'role',   // users.role
            'code'    // roles.code
        );
    }

    /**
     * Helpers
     */
    public function isAdmin(): bool
    {
        return $this->role === '01';
    }

    public function isUser(): bool
    {
        return $this->role === '02';
    }
	
	public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_code', 'code');
    }

    /**
     * Accessor: role name
     */
    public function getRoleNameAttribute(): ?string
    {
        return $this->roleData?->name;
    }
}
