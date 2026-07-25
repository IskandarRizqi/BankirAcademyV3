<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecentRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'program',
        'avatar_url',
        'is_active',
    ];
}