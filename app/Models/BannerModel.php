<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BannerModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "banner_slide";
    protected $fillable = [
        'nama',
        'jenis',
        'mulai',
        'selesai',
        'image',
        'nominal',
        'kode',
    ];
}
