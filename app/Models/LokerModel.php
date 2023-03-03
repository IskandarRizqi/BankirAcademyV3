<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokerModel extends Model
{
    use HasFactory;
    protected $table = 'loker';
    protected $fillable = [
        'user_id',
        'title',
        'gaji_min',
        'gaji_max',
        'deskripsi',
        'jobdesk',
        'image',
        'tanggal_awal',
        'tanggal_akhir',
        'skill',
        'type',
        'status',
    ];
}
