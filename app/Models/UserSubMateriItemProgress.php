<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class UserSubMateriItemProgress extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'user_sub_materi_item_progress';

    protected $fillable = [
        'user_id',
        'id_sub_materi_item',
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
     * Relasi ke Item Sub Materi yang dipelajari
     */
    public function subMateriItem(): BelongsTo
    {
        return $this->belongsTo(SubMateriItemModel::class, 'id_sub_materi_item', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['user_id', 'id_sub_materi_item', 'is_completed', 'completed_at'])
            ->logOnlyDirty();
    }
}