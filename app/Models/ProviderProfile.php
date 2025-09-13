<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProviderProfile extends Model
{
    protected $fillable = [
        'user_id',
        'business_name',
        'description',
        'year_established',
        'subscription_tier', // 'free', 'premium'
        'subscription_status', // 'active', 'past_due', 'canceled', 'incomplete'
        'subscription_ends_at', // When the current period ends
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function styles(): BelongsToMany
    {
        return $this->belongsToMany(MartialArtsStyle::class, 'provider_profile_style');
    }

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }
}
