<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembershipModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'harga',
        'limit',
        'nama',
        'gambar',
        'keterangan',
        'jenis_kelas',
        'cvats',
        'cvbankir',
        'lamaran_online',
        'lamara_offline',
        'pelatihan_gratis',
        'is_active',
        'urutan',
        'video_kursus',
    ];
}
