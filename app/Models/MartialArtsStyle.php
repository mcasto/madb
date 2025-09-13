<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MartialArtsStyle extends Model
{
    protected $fillable = ['name', 'description'];

    public function providerProfiles(): BelongsToMany
    {
        return $this->belongsToMany(ProviderProfile::class, 'provider_profile_style');
    }
}
