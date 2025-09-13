<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Sanctum for API auth

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'type', // 'seek' or 'provider'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // A user (provider) has one profile
    public function providerProfile()
    {
        return $this->hasOne(ProviderProfile::class);
    }

    // A user (any type) can leave many reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
