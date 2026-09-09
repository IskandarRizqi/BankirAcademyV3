<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScraperIngestionControl extends Model
{
    protected $fillable = [
        'source_type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function isEnabled(string $sourceType): bool
    {
        return static::where('source_type', $sourceType)->value('is_active') ?? true;
    }
}
