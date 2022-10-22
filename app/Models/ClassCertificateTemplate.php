<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassCertificateTemplate extends Model
{
    use HasFactory;
	protected $table = 'class_certificate_template';
	protected $fillable = [
		'class_id',
		'background',
		'content',
		'page_size',
		'layout',
		'certificate_created',
		'certificate_expired',
	];
}
