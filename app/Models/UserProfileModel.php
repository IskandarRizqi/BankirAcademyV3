<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfileModel extends Model
{
    use HasFactory;
	protected $table = 'user_profile';
	protected $fillable = [
		'name',
		'phone_region',
		'phone',
		'picture',
		'tanggal_lahir',
		'gender',
		'description',
		'instansi',
	];
}
