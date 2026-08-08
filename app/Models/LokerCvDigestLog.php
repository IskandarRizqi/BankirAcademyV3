<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokerCvDigestLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipient_key',
        'perusahaan_id',
        'email',
        'send_date',
        'status',
        'candidate_ids',
        'application_ids',
        'attempted_at',
        'sent_at',
        'error_message',
    ];

    protected $casts = [
        'send_date' => 'date',
        'candidate_ids' => 'array',
        'application_ids' => 'array',
        'attempted_at' => 'datetime',
        'sent_at' => 'datetime',
    ];
}
