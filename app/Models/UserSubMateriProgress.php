<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class UserSubMateriProgress extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'user_sub_materi_progress';

    protected $fillable = [
        'user_id',
        'id_sub_materi',
        'is_completed',
        'completed_at',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    /**
     * Relasi ke User pemilik progress
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relasi ke Sub Materi yang dipelajari
     */
    public function subMateri(): BelongsTo
    {
        return $this->belongsTo(SubMateriModel::class, 'id_sub_materi', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['user_id', 'id_sub_materi', 'is_completed', 'completed_at'])
            ->logOnlyDirty();
    }
}