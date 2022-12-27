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
    protected $appends = ['users', 'aplicator'];
    public function getUsersAttribute()
    {
        if (array_key_exists('user_id', $this->attributes)) {
            return User::where('id', $this->attributes['user_id'])->first();
        }
    }
    public function getAplicatorAttribute()
    {
        if (array_key_exists('user_aplicator', $this->attributes)) {
            return User::where('id', $this->attributes['user_aplicator'])->first();
        }
    }
}
