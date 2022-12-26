<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterRefferralModel extends Model
{
    use HasFactory;
    protected $table = 'master_referral';
    protected $fillable = [
        'nominal',
        'min',
        'max',
        'date_start',
        'date_end',
        'potongan_harga',
    ];
}
