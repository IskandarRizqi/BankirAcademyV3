<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructorModel extends Model
{
	use HasFactory;
	protected $table = 'instructor';
	protected $fillable = [
		'name',
		'title',
		'picture',
		'desc',
		'user_id',
	];
	// protected $appends = ['picture'];
	// public function getPictureAttribute()
	// {
	// 	if (array_key_exists('picture', $this->attributes)) {
	// 		return $this->attributes['picture'];
	// 	}
	// }
}
