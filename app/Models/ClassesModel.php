<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClassesModel extends Model
{
	use HasFactory;
	protected $table = 'classes';
	protected $fillable = [
		'title',
		'instructor',
		'category',
		'sub_category',
		'tags',
		'image',
		'image_mobile',
		'content',
		'unique_id',
		'participant_limit',
		'date_start',
		'date_end',
		'tipe',
		'level',
		'jenis',
		'og',
		'meta',
		'status',
	];

	protected $appends = ['instructor_list', 'pricing', 'content_list', 'events_exist', 'certif_exist', 'peserta_list', 'total_peserta', 'event_list'];

	public function getInstructorListAttribute()
	{
		if (array_key_exists('instructor', $this->attributes)) {
			return DB::table('instructor')->whereIn('id', json_decode($this->attributes['instructor']))->get();
		}
	}
	public function getEventListAttribute()
	{
		if (array_key_exists('id', $this->attributes)) {
			return DB::table('class_event')->where('class_id', $this->attributes['id'])->orderBy('time_start')->get();
		}
	}

	public function getPricingAttribute()
	{
		if (array_key_exists('id', $this->attributes)) {
			return DB::table('class_pricing')->where('class_id', $this->attributes['id'])->first();
		}
	}

	public function getEventsExistAttribute()
	{
		if (array_key_exists('id', $this->attributes)) {
			return DB::table('class_event')->where('class_id', $this->attributes['id'])->exists();
		}
	}

	public function getCertifExistAttribute()
	{
		if (array_key_exists('id', $this->attributes)) {
			return DB::table('class_certificate_template')->where('class_id', $this->attributes['id'])->exists();
		}
	}

	public function getContentListAttribute()
	{
		if (array_key_exists('id', $this->attributes)) {
			return DB::table('class_content')->where('class_id', $this->attributes['id'])->get();
		}
	}
	public function getTotalPesertaAttribute()
	{
		if (array_key_exists('id', $this->attributes)) {
			return DB::table('class_payment')
				->where('class_payment.class_id', $this->attributes['id'])
				->sum('jumlah');
		}
	}
	public function getPesertaListAttribute()
	{
		$data = [];
		if (array_key_exists('id', $this->attributes)) {
			$data['all'] = DB::table('class_payment')
				->select('class_payment.*', 'user_profile.name', 'user_profile.phone_region', 'user_profile.phone', 'user_profile.gender', 'user_profile.instansi')
				->leftJoin('user_profile', 'user_profile.user_id', 'class_payment.user_id')
				// ->where('class_payment.status', 1)
				->where('class_payment.class_id', $this->attributes['id'])
				->get();
			$data['lunas'] = DB::table('class_payment')
				->select('class_payment.*', 'user_profile.name', 'user_profile.phone_region', 'user_profile.phone', 'user_profile.gender', 'user_profile.instansi')
				->leftJoin('user_profile', 'user_profile.user_id', 'class_payment.user_id')
				->where('class_payment.status', 1)
				// ->where('class_payment.status', 0)
				->where('class_payment.class_id', $this->attributes['id'])
				->get();
		}
		return $data;
	}
}
