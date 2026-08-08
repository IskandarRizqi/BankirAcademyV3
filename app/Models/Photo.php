<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    use SoftDeletes;
    protected $fillable = ['file_size', 'title', 'path'];

    // Accessor untuk mendapatkan Full URL gambar
    protected $appends = ['url'];

    public function getUrlAttribute()
    {
        return Storage::url($this->path);
    }
}
