<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DokumenFileSopModel extends Model
{
    use HasFactory;

    protected $table = 'dokumen_file_sop';

    protected $fillable = [
        'sop_id',
        'nama_file',
        'path',
        'ukuran',
        'mime_type',
        'link_google_drive',
    ];

    protected $casts = [
        'ukuran' => 'integer',
    ];

    public function sop(): BelongsTo
    {
        return $this->belongsTo(SopModel::class, 'sop_id');
    }
}
