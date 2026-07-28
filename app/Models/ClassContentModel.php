<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassContentModel extends Model
{
    use HasFactory;

	public const TYPE_DOCUMENT = 1;

	public const TYPE_IMAGE = 2;

	public const TYPE_VIDEO = 3;

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
