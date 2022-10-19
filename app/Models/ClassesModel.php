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

	protected $appends = ['instructor_list'];

	public function getInstructorListAttribute()
	{
		if(array_key_exists('instructor',$this->attributes)) {
			return DB::table('instructor')->whereIn('id',json_decode($this->attributes['instructor']))->get();
		}
	}
}
