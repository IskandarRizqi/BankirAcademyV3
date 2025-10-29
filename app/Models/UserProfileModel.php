<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserProfileModel extends Model
{
	use HasFactory;
	protected $table = 'user_profile';
	protected $fillable = [
		'user_id',
		'name',
		'phone_region',
		'phone',
		'picture',
		'tanggal_lahir',
		'gender',
		'description',
		'instansi',
		'nama_bank',
		'rekening',
		'existing_user',
		'image_bukti_pembayaran',
		'status_membership',
		'masa_aktif_membership',
		'id_member',
	];
	public function membership(): HasOne
	{
		return $this->hasOne(MembershipModel::class, 'id', 'id_member');
	}
}
