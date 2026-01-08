<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\PropertyInterest;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use SoftDeletes;

    const DAS_ROLES = ['03', '04', '05', '06'];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'passport',
        'emirates_id',
        'role', // ADDED: Critical column from migration
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_code', 'code');
    }


    public function scopeHasPassport($query)
    {
        return $query->whereNotNull('passport');
    }
    public function scopeHasEmiratesId($query)
    {
        return $query->whereNotNull('emirates_id');
    }
    /**
     * Check if the user's profile documents are complete.
     */
    public function isKYCComplete(): bool
    {
        return !empty($this->passport) && !empty($this->emirates_id);
    }

    // -----------------------------------------------------------------
    // | ✅ NEW RELATIONSHIP: Property Interests (Needed for User Filter) |
    // -----------------------------------------------------------------

    /**
     * Get the property interests submitted by the user.
     *
     * @return HasMany
     */
    public function propertyInterests(): HasMany
    {
        // Links the User model to the PropertyInterest model via the 'user_id' foreign key
        return $this->hasMany(PropertyInterest::class);
    }

    // -----------------------------------------------------------------
    // |                      Accessors/Mutators                         |
    // -----------------------------------------------------------------

    /**
     * Check if the user has a specific management role.
     * 
     * @return bool
     */
    public function isDAS(): bool
    {
        return in_array($this->role, self::DAS_ROLES);
    }
    public function isBO(): bool
    {
        return $this->role === '07';
    }
    public function isUser(): bool
    {
        return $this->role === '02';
    }
    public function isAdmin(): bool
    {
        return $this->role === '01';
    }

    public function getDashboardUrlAttribute(): string
{
    return match (true) {
        $this->isAdmin() => route('admin.dashboard'),
        $this->isUser()  => route('user.dashboard'),
        $this->isBO()    => route('user.dashboard'),
        $this->isDAS()   => route('das.dashboard'),
        default          => route('home'),
    };
}
    // get current user role name
    public function getRoleNameAttribute()
    {
        return Role::where('code', $this->role)->value('name');
    }
}
