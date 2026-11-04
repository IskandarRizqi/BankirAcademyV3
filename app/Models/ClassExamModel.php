<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassExamModel extends Model
{
    use HasFactory;

    protected $table = 'class_exams';

    protected $fillable = [
        'class_id',
        'title',
        'description',
        'questions',
        'public_token',
        'status',
    ];

    protected $casts = [
        'questions' => 'array',
        'status' => 'boolean',
    ];

    public function classData(): BelongsTo
    {
        return $this->belongsTo(ClassesModel::class, 'class_id');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(ClassExamSubmissionModel::class, 'exam_id');
    }
}
