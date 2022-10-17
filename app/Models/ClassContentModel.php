<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassContentModel extends Model
{
    use HasFactory;
	protected $table = 'class_content';
	protected $fillable = [
		'class_id',
		'type',
		'url',
		'title',
		'description',
		'custom_attribute',
	];
}
