<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PerusahaanModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'nama',
        'email',
        'alamat',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'image',
    ];
    protected $appends = [
        'provinsi_name',
        'kabupaten_name',
        'kecamatan_name',
        'kelurahan_name',
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
}
