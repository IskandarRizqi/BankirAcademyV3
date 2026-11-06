<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class LokerApply extends Model
{
    use HasFactory, SoftDeletes;

    public const REVIEW_PENDING = 'pending';

    public const REVIEW_REJECTED = 'rejected';

    public const REVIEW_APPROVED = 'approved';

    protected $fillable = [
        'loker_id',
        'user_id',
        'status',
        'review_status',
        'reviewed_by',
        'reviewed_at',
        'sent_at',
        'send_error',
    ];

    protected $appends = ['status_name'];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    public function getStatusNameAttribute()
    {
        if ((int) ($this->attributes['status'] ?? 0) === 1) {
            return 'Terkirim ke perusahaan';
        }

        if (($this->attributes['review_status'] ?? self::REVIEW_PENDING) === self::REVIEW_REJECTED) {
            return 'Ditolak admin';
        }

        return 'Menunggu review admin';
    }

    public function lamaran(): HasOne
    {
        return $this->hasOne(LokerModel::class, 'id', 'loker_id');
    }

    public function loker(): BelongsTo
    {
        return $this->belongsTo(LokerModel::class, 'loker_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
