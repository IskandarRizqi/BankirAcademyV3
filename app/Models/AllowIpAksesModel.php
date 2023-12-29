<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AllowIpAksesModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'allow_ip_akses';
    protected $fillable = [
        'ip',
        'nama',
    ];

    public function history(): HasMany
    {
        return $this->hasMany(HistoryIpAksesModel::class, 'ip_id', 'id');
    }
}
