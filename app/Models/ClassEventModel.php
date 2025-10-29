<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassEventModel extends Model
{
	use HasFactory;
	protected $table = 'class_event';
	protected $fillable = [
		'class_id',
		'type',
		'link',
		'location',
		'description',
		'time_start',
		'time_end',
		'password_link',
	];
}
