<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Complaint extends Model
{
    protected $fillable = [
        'complaint_number', 'title', 'category', 'description',
        'location', 'reporter_name', 'status', 'is_demo',
    ];

    protected $casts = [
        'is_demo' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($complaint) {
            if (empty($complaint->complaint_number)) {
                $complaint->complaint_number = self::generateNumber();
            }
        });
    }

    public static function generateNumber(): string
    {
        $date = now()->format('Ymd');
        $count = self::whereDate('created_at', today())->count() + 1;
        return 'IND-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(ComplaintStatusHistory::class)->orderBy('created_at', 'asc');
    }
}
