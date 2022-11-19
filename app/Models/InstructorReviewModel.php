<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructorReviewModel extends Model
{
    use HasFactory;
    protected $table = 'instructor_review';
    protected $fillable = [
        'instructor_id',
        'users_id',
        'review_msg',
        'review_val',
        'status',
    ];
}
