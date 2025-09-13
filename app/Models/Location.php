<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Location extends Model
{
    protected $fillable = [
        'provider_profile_id',
        'street_address',
        'city',
        'state_province',
        'postal_code',
        'country_code',
        'latitude',
        'longitude',
        'phone',
        'email',
        'website_url',
    ];

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->latitude && $model->longitude) {
                $model->location = DB::raw("POINT({$model->longitude}, {$model->latitude})");
            }
        });
    }

    public function providerProfile(): BelongsTo
    {
        return $this->belongsTo(ProviderProfile::class);
    }
}
