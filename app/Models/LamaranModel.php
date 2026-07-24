<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LamaranModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lamaran_models';

    protected $fillable = [
        'job_id',
        'status',
        'user_id',
        'nama_lengkap',
        'nama_panggilan',
        'tmpttgllahir',
        'agama',
        'alamatdomisili',
        'telpdomisili',
        'kodepos',
        'namaorangtua',
        'jmlsaudara',
        'statusperkawinan',
        'namapasangan',
        'namaorangtuasuamiistri',
        'namaanak',
        'namakakeknenek',
        'namacucu',
        'namasuamiistri',
        'namamertua',
        'namabesan',
        'namasuamiistrianak',
        'namakakeksuami',
        'namasuamiistricucu',
        'namasuamiistrisaudara',
        'sdtahun',
        'sdnama',
        'sdfakultas',
        'sdgelar',
        'smptahun',
        'smpnama',
        'smpfakultas',
        'smpgelar',
        'smatahun',
        'smanama',
        'smafakultas',
        'smagelar',
        'akademitahun',
        'akademinama',
        'akademifakultas',
        'akademigelar',
        'perguruantahun',
        'perguruannama',
        'perguruanfakultas',
        'perguruangelar',
        'pascasarjanatahun',
        'pascasarjananama',
        'pascasarjanafakultas',
        'pascasarjanagelar',
        'pelatihannama',
        'pelatihantahun',
        'pelatihanpenyelanggara',
        'pelatihanlokasi',
        'pekerjaantahun',
        'pekerjaanperusahaan',
        'pekerjaanjabatan',
        'pekerjaantanggungjawab',
        'pekerjaanprestasi',
        'pekerjaanpenghargaan',
        'pekerjaantotalaset',
        'pengalamanspesifik',
        'is_approved',
        'is_approved_message',
    ];

    protected $appends = ['namaagama'];

    // Mutator & Accessor untuk konversi Agama
    public function getNamaAgamaAttribute()
    {
        $map = [
            0 => 'Islam',
            1 => 'Katholik',
            2 => 'Protestan',
            3 => 'Hindu',
            4 => 'Budha',
            5 => 'Tuhan Yang Maha Esa',
        ];

        return $map[$this->attributes['agama'] ?? 0] ?? 'Islam';
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}