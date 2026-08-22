<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScraperApiKey extends Model
{
    protected $fillable = [
        'name',
        'key_hash',
        'key_prefix',
        'last_used_at',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_used_at' => 'datetime',
    ];
}
