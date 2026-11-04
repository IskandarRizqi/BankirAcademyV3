<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('class_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('questions');
            $table->string('public_token', 64)->unique();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });

        Schema::create('class_exam_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained('class_exams')->cascadeOnDelete();
            $table->string('name');
            $table->string('phone', 30);
            $table->json('answers');
            $table->json('questions_snapshot');
            $table->unsignedInteger('correct_answers')->default(0);
            $table->unsignedInteger('total_questions')->default(0);
            $table->decimal('score', 5, 2)->default(0);
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('class_exam_submissions');
        Schema::dropIfExists('class_exams');
    }
};
