<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SopModel extends Model
{
    use HasFactory;

    public const STATUS_UPCOMING = 'upcoming';

    public const STATUS_NON_UPCOMING = 'non_upcoming';

    protected $table = 'sop';

    protected $fillable = [
        'judul',
        'deskripsi',
        'status',
    ];

    public static function statuses(): array
    {
        return [
            self::STATUS_UPCOMING,
            self::STATUS_NON_UPCOMING,
        ];
    }

    public function dokumenFiles(): HasMany
    {
        return $this->hasMany(DokumenFileSopModel::class, 'sop_id');
    }
}
