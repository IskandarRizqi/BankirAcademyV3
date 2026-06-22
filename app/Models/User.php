<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'google_id',
        'parent_id',
        'bank_id',
        'sekolah_id',
        'membership_id',
        'masa_aktif_member',
        'role',
        'password',
        'corporate',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $appends = ['profile', 'rekening', 'corporates'];
    public function getProfileAttribute()
    {
        if (array_key_exists('id', $this->attributes)) {
            return UserProfileModel::with('membership')->where('user_id', $this->attributes['id'])->first();
        }
    }
    public function bank()
{
    return $this->belongsTo(User::class, 'bank_id');
}

public function sekolah()
{
    return $this->belongsTo(User::class, 'sekolah_id');
}

public function membership()
{
    return $this->belongsTo(Membership::class, 'membership_id');
}
    public function getRekeningAttribute()
    {
        if (array_key_exists('id', $this->attributes)) {
            return DataRekeningModel::where('user_id', $this->attributes['id'])->first();
        }
    }
    public function getCorporatesAttribute()
    {
        if (array_key_exists('corporate', $this->attributes)) {
            return json_decode($this->attributes['corporate']);
        }
    }
}
