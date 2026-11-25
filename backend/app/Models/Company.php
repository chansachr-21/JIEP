<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'industrial_estate_id', 'name', 'slug', 'category', 'description',
        'address', 'phone', 'email', 'website',
        'latitude', 'longitude',
        'verification_status', 'data_source', 'source_url', 'last_verified_at',
        'is_featured', 'is_active',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'last_verified_at' => 'datetime',
    ];

    public function industrialEstate(): BelongsTo
    {
        return $this->belongsTo(IndustrialEstate::class);
    }

    public function jobVacancies(): HasMany
    {
        return $this->hasMany(JobVacancy::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('verification_status', 'verified');
    }
}
