<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodePromoModel extends Model
{
    use HasFactory;
    protected $table = 'kode_promo';
    protected $fillable = [
        'kode',
        'tgl_mulai',
        'tgl_selesai',
        'nominal',
        'class_title',
    ];
}
