<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassParticipantModel extends Model
{
	use HasFactory;
	protected $table = 'class_participant';
	protected $fillable = [
		'class_id',
		'user_id',
		'payment_id',
		'certificate',
		'review',
		'review_point',
		'review_time',
		'jumlah',
	];
}
