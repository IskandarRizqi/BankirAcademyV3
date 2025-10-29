<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoryIpAksesModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'history_ip_akses';
    protected $fillable = [
        'ip_id',
        'model',
        'deskripsi',
        'tambahan',
    ];
}
