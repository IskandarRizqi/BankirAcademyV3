<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class LokerApply extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'loker_id',
        'user_id',
        'status',
    ];

    protected $appends = ['status_name'];

    public function getStatusNameAttribute()
    {
        $s = 'Pending';
        if ($this->attributes['status'] == 1) {
            $s = 'Terkirim';
        }
        return $s;
    }

    public function lamaran(): HasOne
    {
        return $this->hasOne(LokerModel::class, 'id', 'loker_id');
    }
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
