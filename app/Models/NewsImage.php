<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class NewsImage extends Model
{
    use HasFactory;

    protected $fillable = ['news_id', 'path', 'sort_order'];

    protected $appends = ['url', 'absolute_url'];

    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }

    public function getUrlAttribute(): string
    {
        if (Str::startsWith($this->path, ['http://', 'https://', 'data:'])) {
            return $this->path;
        }

        return '/storage/'.ltrim($this->path, '/');
    }

    public function getAbsoluteUrlAttribute(): string
    {
        if (Str::startsWith($this->path, ['http://', 'https://', 'data:'])) {
            return $this->path;
        }

        return url(ltrim($this->url, '/'));
    }
}
