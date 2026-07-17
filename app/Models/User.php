<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, LogsActivity;

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
        'expires_at',
        'email_sent_at',
        'activated_at',
        'password_sent_at',
        'is_active',
        'last_error',
        'password_ciphertext',
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
        'expires_at' => 'datetime',
        'email_sent_at' => 'datetime',
        'activated_at' => 'datetime',
        'password_sent_at' => 'datetime',
    ];
    protected $appends = ['profile', 'rekening', 'corporates', 'role_name'];
    public function getRoleNameAttribute()
    {
        $role = [
            'Root',
            '',
            'Peserta',
            'Instructor',
            'Bank',
            'Sekolah',
            'Siswa',
        ];

        if ($this->attributes['email'] == 'cb@bankir.academy') {
            return 'Root';
        }
        return $role[$this->attributes['role']];
    }
    public function getProfileAttribute()
    {
        if (array_key_exists('id', $this->attributes)) {
            return UserProfileModel::with('membership')->where('user_id', $this->attributes['id'])->first();
        }
        return null;
    }
    public function bank()
    {
        return $this->belongsTo(User::class, 'bank_id');
    }

    public function sekolah()
    {
        return $this->belongsTo(User::class, 'sekolah_id');
    }
    public function siswa()
    {
        return $this->hasOne(SiswaProfile::class, 'user_id');
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
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'email',
                'bank_id',
                'sekolah_id',
                'membership_id',
                'masa_aktif_member',
                'role',
            ]) // Catat jika kolom ini berubah
            ->logOnlyDirty(); // Hanya catat jika ada perubahan nyata
    }
}
