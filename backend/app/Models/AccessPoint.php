<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccessPoint extends Model
{
    protected $fillable = [
        'industrial_estate_id', 'name', 'road_name', 'description',
        'latitude', 'longitude',
        'verification_status', 'data_source', 'source_url', 'last_verified_at',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'last_verified_at' => 'datetime',
    ];

    public function industrialEstate(): BelongsTo
    {
        return $this->belongsTo(IndustrialEstate::class);
    }
}
