<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LokerModel extends Model
{
    use HasFactory;
    protected $table = 'loker';
    protected $fillable = [
        'user_id',
        'title',
        'gaji_min',
        'gaji_max',
        'deskripsi',
        'jobdesk',
        'image',
        'tanggal_awal',
        'tanggal_akhir',
        'skill',
        'type',
        'status',
        'nama',
        'email',
        'alamat',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'perusahaan_id',
        'perusahaan_user',
    ];

    protected $hidden = [
        'user_id',
    ];

    protected $appends = [
        'provinsi_name',
        'kabupaten_name',
        'kecamatan_name',
        'kelurahan_name',
        'perusahaan',
        'perusahaan_users',
        'tanggal_custom',
    ];

    public function getKelurahanNameAttribute()
    {
        $a = '';
        if (array_key_exists('kelurahan', $this->attributes)) {
            $d = DB::table('kelurahan')->where('id', $this->attributes['kelurahan'])->first();
            if ($d) {
                $a = $d->name;
            }
        }
        return $a;
    }

    public function getKecamatanNameAttribute()
    {
        $a = '';
        if (array_key_exists('kecamatan', $this->attributes)) {
            $d = DB::table('kecamatan')->where('id', $this->attributes['kecamatan'])->first();
            if ($d) {
                $a = $d->name;
            }
        }
        return $a;
    }

    public function getKabupatenNameAttribute()
    {
        $a = '';
        if (array_key_exists('kabupaten', $this->attributes)) {
            $d = DB::table('kota')->where('id', $this->attributes['kabupaten'])->first();
            if ($d) {
                $a = $d->name;
            }
        }
        return $a;
    }

    public function getProvinsiNameAttribute()
    {
        $a = '';
        if (array_key_exists('provinsi', $this->attributes)) {
            $d = DB::table('provinsi')->where('id', $this->attributes['provinsi'])->first();
            if ($d) {
                $a = $d->name;
            }
        }
        return $a;
    }
    public function getTanggalCustomAttribute()
    {
        $a = null;
        $b = null;
        if (array_key_exists('tanggal_awal', $this->attributes)) {
            $a = $this->attributes['tanggal_awal'];
        }
        if (array_key_exists('tanggal_akhir', $this->attributes)) {
            $b = $this->attributes['tanggal_akhir'];
        }
        if ($a == $b) {
            return $a;
        }
        return $a . ' - ' . $b;
    }
    public function getPerusahaanAttribute()
    {
        $a = null;
        if (array_key_exists('perusahaan_id', $this->attributes)) {
            $a = PerusahaanModel::select()->where('id', $this->attributes['perusahaan_id'])->first();
        }
        return $a;
    }
    public function getPerusahaanUsersAttribute()
    {
        $a = null;
        if (array_key_exists('perusahaan_user', $this->attributes)) {
            $a = CorporateModel::select()->where('id', $this->attributes['perusahaan_user'])->first();
        }
        return $a;
    }
}
