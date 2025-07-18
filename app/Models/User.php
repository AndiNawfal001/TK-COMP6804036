<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'group_id',
        'name',
        'email',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
//    protected $hidden = [
//        'password',
//        'remember_token',
//    ];

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

    public function staff_request(): HasMany
    {
        return $this->hasMany (StaffRequest::class, 'user_id', 'id');
    }

    public function app_staff_request(): HasMany
    {
        return $this->hasMany (StaffRequest::class, 'app_by', 'id');
    }

    public function selection(): HasMany
    {
        return $this->hasMany (Selections::class, 'applicant_id', 'id');
    }

    public function app_selections(): HasMany
    {
        return $this->hasMany (Selections::class, 'app_by', 'id');
    }
}
