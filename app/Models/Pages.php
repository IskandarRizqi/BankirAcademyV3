<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
	use HasFactory;
	protected $table = 'pages';
	protected $fillable = [
		'type',
		'title',
		'thumbnail',
		'content',
		'description',
		'date_start',
		'date_end',
		'og',
		'meta',
	];
}
