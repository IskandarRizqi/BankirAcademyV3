<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeModel extends Model
{
    use HasFactory;
    protected $table = 'fee';
    protected $fillable = [
        'class_id',
        'nominal',
    ];
}
