<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Facility extends Model
{
    protected $fillable = [
        'industrial_estate_id', 'name', 'category', 'description',
        'address', 'latitude', 'longitude', 'operational_status', 'phone',
        'verification_status', 'data_source', 'source_url', 'last_verified_at',
        'is_active',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_active' => 'boolean',
        'last_verified_at' => 'datetime',
    ];

    public function industrialEstate(): BelongsTo
    {
        return $this->belongsTo(IndustrialEstate::class);
    }
}
