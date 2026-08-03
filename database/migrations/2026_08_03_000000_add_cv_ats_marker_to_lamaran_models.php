<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasColumn('lamaran_models', 'is_cv_ats')) {
            Schema::table('lamaran_models', function (Blueprint $table) {
                // Nullable keeps existing job applications outside of the CV ATS flow.
                $table->boolean('is_cv_ats')->nullable()->after('user_id');
            });
        }

        Schema::table('lamaran_models', function (Blueprint $table) {
            $table->unique(['user_id', 'is_cv_ats'], 'lamaran_models_user_cv_ats_unique');
        });
    }

    public function down()
    {
        if (Schema::hasColumn('lamaran_models', 'is_cv_ats')) {
            Schema::table('lamaran_models', function (Blueprint $table) {
                $table->dropUnique('lamaran_models_user_cv_ats_unique');
                $table->dropColumn('is_cv_ats');
            });
        }
    }
};
