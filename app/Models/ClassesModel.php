<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
	];
}
