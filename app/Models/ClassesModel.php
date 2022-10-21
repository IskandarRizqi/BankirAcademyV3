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
		'content',
		'unique_id',
		'participant_limit',
		'date_start',
		'date_end',
	];

	protected $appends = ['instructor_list','pricing','content_list'];

	public function getInstructorListAttribute()
	{
		if(array_key_exists('instructor',$this->attributes)) {
			return DB::table('instructor')->whereIn('id',json_decode($this->attributes['instructor']))->get();
		}
	}

	public function getPricingAttribute()
	{
		if(array_key_exists('id',$this->attributes)) {
			return DB::table('class_pricing')->where('class_id',$this->attributes['id'])->first();
		}
	}

	public function getContentListAttribute()
	{
		if(array_key_exists('id',$this->attributes)) {
			return DB::table('class_content')->where('class_id',$this->attributes['id'])->get();
		}
	}
}
