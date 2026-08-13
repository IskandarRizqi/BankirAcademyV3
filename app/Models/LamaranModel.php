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
        'is_cv_ats',
        'nama_lengkap',
        'nama_panggilan',
        'tmpttgllahir',
        'tempat_lahir',
        'tanggal_lahir',
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

    protected $casts = [
        'is_cv_ats' => 'boolean',
    ];

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

        $agama = $this->attributes['agama'] ?? 0;

        if (is_numeric($agama)) {
            return $map[(int) $agama] ?? 'Islam';
        }

        return [
            'islam' => 'Islam',
            'katholik' => 'Katholik',
            'protestan' => 'Protestan',
            'hindu' => 'Hindu',
            'budha' => 'Budha',
            'tuhan yang maha esa' => 'Tuhan Yang Maha Esa',
        ][strtolower(trim($agama))] ?? ucfirst($agama);
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
