<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SertifikatPesertaModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "sertifikat_peserta";
    protected $fillable = [
        'user_id',
        'class_id',
        'payment_class_id',
        'nama',
        'email',
        'nohp'
    ];
}
