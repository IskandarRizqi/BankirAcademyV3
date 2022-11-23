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
		'status',
		'dokumen',
	];
	protected $appends = ['user'];
	public function getUserAttribute()
	{
		if (array_key_exists('user_id', $this->attributes)) {
			return User::where('id', $this->attributes['user_id'])->first();
		}
	}
}
