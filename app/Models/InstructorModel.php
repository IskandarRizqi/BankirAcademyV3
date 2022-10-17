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
}
