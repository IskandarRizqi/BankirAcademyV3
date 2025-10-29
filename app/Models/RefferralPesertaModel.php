<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefferralPesertaModel extends Model
{
    use HasFactory;
    protected $table = 'refferral_peserta';
    protected $fillable = [
        'user_id',
        'user_aplicator',
        'code',
        'url',
    ];
}
