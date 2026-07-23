<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CertificateTemplate extends Model
{
    use SoftDeletes;

    protected $table = 'certificate_templates';
    protected $fillable = [
        'target_type',
        'materi_id',
        'sub_materi_id',
        'background_image',
        'coordinate_x',
        'coordinate_y',
        'font_size',
        'serial_y',
        'serial_font_size',
        'label_y',
        'label_font_size'
    ];

    public function materi()
    {
        return $this->belongsTo(MateriModel::class, 'materi_id');
    }

    public function subMateri()
    {
        return $this->belongsTo(SubMateriModel::class, 'sub_materi_id');
    }
}