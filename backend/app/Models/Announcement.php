<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    protected $fillable = [
        'industrial_estate_id', 'title', 'category', 'content',
        'is_official', 'is_demo', 'is_published',
        'published_at', 'source_url', 'data_source', 'verification_status',
    ];

    protected $casts = [
        'is_official' => 'boolean',
        'is_demo' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'date',
    ];

    public function industrialEstate(): BelongsTo
    {
        return $this->belongsTo(IndustrialEstate::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
