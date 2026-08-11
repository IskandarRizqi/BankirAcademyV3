<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonusAplikasiModel extends Model
{
    use HasFactory;

    public const SOURCE_URL = 'url';

    public const SOURCE_FILE = 'file';

    public const STATUS_UPCOMING = 'upcoming';

    public const STATUS_NON_UPCOMING = 'non_upcoming';

    protected $table = 'bonus_aplikasi';

    protected $fillable = [
        'nama',
        'deskripsi',
        'status',
        'tipe_sumber',
        'url',
        'file_path',
        'file_name',
        'file_size',
        'mime_type',
        'thumbnail_path',
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    public static function sources(): array
    {
        return [self::SOURCE_URL, self::SOURCE_FILE];
    }

    public static function statuses(): array
    {
        return [self::STATUS_UPCOMING, self::STATUS_NON_UPCOMING];
    }
}
