<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefferralModel extends Model
{
    use HasFactory;
    protected $table = 'referral';
    protected $fillable = [
        'user_id',
        'user_aplicator',
        'code',
        'nominal_class',
        'nominal_admin',
        'total',
        'available',
    ];
}
