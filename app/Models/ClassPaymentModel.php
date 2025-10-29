<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassPaymentModel extends Model
{
	use HasFactory;
	protected $table = 'class_payment';
	protected $fillable = [
		'status',
		'user_id',
		'class_id',
		'unique_code',
		'price',
		'price_final',
		'expired',
		'no_invoice',
		'file',
		'jumlah',
		'kode_promo',
		'biaya_sertifikat',
		'sudah_cetak',
	];
	protected $appends = ['promo'];
	public function getPromoAttribute()
	{
		if (array_key_exists('kode_promo', $this->attributes)) {
			$class = ClassesModel::where('id', $this->attributes['class_id'])->first();
			if (!$class) {
				return 0;
			}
			$bp = BannerModel::where('jenis', 2)->where('kode', $this->attributes['kode_promo'])->where('mulai', '<', Carbon::now())->where('selesai', '>=', Carbon::now())->first();
			$kp = KodePromoModel::where('kode', $this->attributes['kode_promo'])->where('class_title', 'like', '%"' . $class->title . '"%')->where('tgl_selesai', '>=', Carbon::now())->first();
			// $kp = KodePromoModel::where('kode', $kode_promo)->where('class_title', 'like', '%"' . $title_kelas . '"%')->where('tgl_selesai', '>=', Carbon::now())->get();
			if ($bp) {
				return ($bp->nominal * $this->attributes['price_final']) / 100;
			}
			if ($kp) {
				return ($kp->nominal * $this->attributes['price_final']) / 100;
			}
			return 0;
		}
		return 0;
	}
}
