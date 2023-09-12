<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LamaranModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
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
    ];
}
