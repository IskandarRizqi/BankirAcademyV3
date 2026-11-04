<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassExamSubmissionModel extends Model
{
    use HasFactory;

    protected $table = 'class_exam_submissions';

    protected $fillable = [
        'exam_id',
        'name',
        'phone',
        'answers',
        'questions_snapshot',
        'correct_answers',
        'total_questions',
        'score',
        'submitted_at',
    ];

    protected $casts = [
        'answers' => 'array',
        'questions_snapshot' => 'array',
        'submitted_at' => 'datetime',
        'score' => 'float',
    ];

    public function exam(): BelongsTo
    {
        return $this->belongsTo(ClassExamModel::class, 'exam_id');
    }
}
