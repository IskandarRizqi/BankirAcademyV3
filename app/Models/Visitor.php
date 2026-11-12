<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    public const TYPE_LANDING = 'landing';

    public const TYPE_AUTH = 'auth';

    public const TYPE_TRANSACTION = 'transaction';

    protected $fillable = [
        'ip_address',
        'country_code',
        'country',
        'province',
        'city',
        'user_agent',
        'page_url',
        'page_label',
        'visitor_type',
        'visitor_date',
        'visited_year',
        'visited_at',
    ];

    protected $casts = [
        'visitor_date' => 'date',
        'visited_year' => 'integer',
        'visited_at' => 'datetime',
    ];
}
