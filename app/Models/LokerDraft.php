<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LokerDraft extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'loker_drafts';

    /**
     * Kolom yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'source_type',
        'platform',
        'sumber_url',
        'nama_perusahaan',
        'logo_url',
        'email_perusahaan',
        'no_hp',
        'instagram_dm',
        'website_form_url',
        'alamat_raw',
        'provinsi_raw',
        'posisi',
        'deskripsi_pekerjaan',
        'jobdesk',
        'kualifikasi_jobspek',
        'keahlian_skill',
        'tipe_pekerjaan',
        'kategori_bidang',
        'fasilitas',
        'cara_melamar',
        'gaji_raw',
        'gaji_min',
        'gaji_max',
        'ringkasan_ai',
        'tanggal_posting',
        'batas_pendaftaran',
        'status_draft',
        'approved_by',
    ];

    /**
     * Casting tipe data otomatis untuk atribut tertentu.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'gaji_min' => 'decimal:2',
        'gaji_max' => 'decimal:2',
        'tanggal_posting' => 'datetime',
        'batas_pendaftaran' => 'date',
        'approved_by' => 'integer',
    ];

    /**
     * Relasi ke model User (admin yang melakukan approval).
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope untuk menyaring draft berdasarkan status.
     */
    public function scopePending($query)
    {
        return $query->where('status_draft', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status_draft', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status_draft', 'rejected');
    }
}
