<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserProfileModel extends Model
{
    use HasFactory;

    protected $table = 'user_profile';

    protected $fillable = [
        'user_id',
        'name',
        'phone_region',
        'phone',
        'alamat',
        'provinsi_id',
        'kota_id',
        'kecamatan_id',
        'kelurahan_id',
        'picture',
        'tanggal_lahir',
        'gender',
        'description',
        'instansi',
        'nama_bank',
        'rekening',
        'existing_user',
        'image_bukti_pembayaran',
        'status_membership',
        'masa_aktif_membership',
        'id_member',
        'tanggal_bergabung_membership',
        'tipe_membership',
    ];

    protected $casts = [
        'provinsi_id' => 'integer',
        'kota_id' => 'integer',
        'kecamatan_id' => 'integer',
        'kelurahan_id' => 'integer',
        'tipe_membership' => 'integer',
    ];

    public function hasCompleteMembershipProfile(): bool
    {
        $phone = preg_replace('/\D+/', '', (string) $this->phone);

        if (str_starts_with($phone, '62')) {
            $phone = substr($phone, 2);
        } elseif (str_starts_with($phone, '0')) {
            $phone = substr($phone, 1);
        }

        return collect([
            $this->name,
            $this->gender,
            $this->tanggal_lahir,
            $this->alamat,
            $this->provinsi_id,
            $this->kota_id,
            $this->kecamatan_id,
            $this->kelurahan_id,
        ])->every(fn ($value) => filled($value)) && strlen($phone) >= 8;
    }

    public function membership(): HasOne
    {
        return $this->hasOne(MembershipModel::class, 'id', 'id_member');
    }
}
