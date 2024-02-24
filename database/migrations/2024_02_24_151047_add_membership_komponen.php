<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('membership_models', 'is_active')) {
            Schema::table('membership_models', function (Blueprint $table) {
                $table->integer('is_active')->default(0);
            });
        }
        if (!Schema::hasColumn('membership_models', 'urutan')) {
            Schema::table('membership_models', function (Blueprint $table) {
                $table->integer('urutan')->default(0);
            });
        }
        if (!Schema::hasColumn('membership_models', 'video_kursus')) {
            Schema::table('membership_models', function (Blueprint $table) {
                $table->integer('video_kursus')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('membership_models', 'is_active')) {
            Schema::table('membership_models', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }
        if (Schema::hasColumn('membership_models', 'urutan')) {
            Schema::table('membership_models', function (Blueprint $table) {
                $table->dropColumn('urutan');
            });
        }
        if (Schema::hasColumn('membership_models', 'video_kursus')) {
            Schema::table('membership_models', function (Blueprint $table) {
                $table->dropColumn('video_kursus');
            });
        }
    }
};
