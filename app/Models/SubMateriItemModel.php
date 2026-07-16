<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubMateriItemModel extends Model
{
    protected $table = 'sub_materi_items'; // samakan dengan nama tabel di migras
    protected $guarded = [];

    public function subMateri()
    {
        return $this->belongsTo(SubMateriModel::class, 'id_sub_materi');
    }
    public function userProgress()
{
    return $this->hasOne(UserSubMateriItemProgress::class, 'id_sub_materi_item')
                ->where('user_id', auth()->id());
}
}