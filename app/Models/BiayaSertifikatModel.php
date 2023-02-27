<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiayaSertifikatModel extends Model
{
    use HasFactory;
    protected $table = 'biaya_sertifikat';
    protected $fillable = [
        'class_id',
        'type',
        'nominal',
    ];
}
