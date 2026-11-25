<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobVacancy extends Model
{
    protected $fillable = [
        'company_id', 'company_name', 'title', 'category', 'description',
        'requirements', 'employment_type', 'location', 'is_published', 'is_demo',
        'published_at', 'deadline', 'source_url', 'data_source',
        'verification_status', 'last_verified_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_demo' => 'boolean',
        'published_at' => 'date',
        'deadline' => 'date',
        'last_verified_at' => 'datetime',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('deadline')->orWhere('deadline', '>=', today());
        });
    }
}
