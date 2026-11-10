<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $seen = [];
        $duplicateIds = [];

        DB::table('class_exam_submissions')
            ->orderByDesc('id')
            ->get(['id', 'exam_id', 'phone'])
            ->each(function ($submission) use (&$seen, &$duplicateIds) {
                $phone = preg_replace('/\D+/', '', trim((string) $submission->phone));
                $key = $submission->exam_id.'|'.$phone;

                if (isset($seen[$key])) {
                    $duplicateIds[] = $submission->id;

                    return;
                }

                $seen[$key] = true;
                DB::table('class_exam_submissions')
                    ->where('id', $submission->id)
                    ->update(['phone' => $phone]);
            });

        if ($duplicateIds !== []) {
            DB::table('class_exam_submissions')->whereIn('id', $duplicateIds)->delete();
        }

        Schema::table('class_exam_submissions', function (Blueprint $table) {
            $table->unique(['exam_id', 'phone'], 'class_exam_submissions_exam_phone_unique');
        });
    }

    public function down(): void
    {
        Schema::table('class_exam_submissions', function (Blueprint $table) {
            $table->dropUnique('class_exam_submissions_exam_phone_unique');
        });
    }
};
