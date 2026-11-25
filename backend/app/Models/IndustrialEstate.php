<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IndustrialEstate extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'manager_name', 'address', 'city', 'province',
        'area_hectares', 'established_year', 'established_date',
        'ownership_pemprov_pct', 'ownership_danareksa_pct',
        'website', 'phone', 'phone_secondary', 'email',
        'latitude', 'longitude',
        'verification_status', 'data_source', 'source_url', 'last_verified_at',
    ];

    protected $casts = [
        'area_hectares' => 'decimal:2',
        'ownership_pemprov_pct' => 'decimal:2',
        'ownership_danareksa_pct' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'established_date' => 'date',
        'last_verified_at' => 'datetime',
    ];

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }

    public function facilities(): HasMany
    {
        return $this->hasMany(Facility::class);
    }

    public function accessPoints(): HasMany
    {
        return $this->hasMany(AccessPoint::class);
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }
}
