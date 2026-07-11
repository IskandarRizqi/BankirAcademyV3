<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PrepotesUserModel extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'prepotes_user';
    protected $fillable = [
        'class_id',
        'user_id',
        'jawaban',
        'nilai_awal',
        'nilai_akhir',
        'jml_jawaban',
    ];
    public function materi()
    {
        // Sesuaikan 'class_id' dengan nama foreign key di tabel prepotes yang merujuk ke tabel materi
        return $this->belongsTo(MateriModel::class, 'class_id', 'id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([  'class_id',
        'user_id',
        'jawaban',
        'nilai_awal',
        'nilai_akhir',
        'jml_jawaban',]) // Catat jika kolom ini berubah
            ->logOnlyDirty(); // Hanya catat jika ada perubahan nyata
    }
}
