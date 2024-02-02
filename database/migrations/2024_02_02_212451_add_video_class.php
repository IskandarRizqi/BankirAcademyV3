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
        if (!Schema::hasColumn('classes', 'is_terpopuler')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->integer('is_terpopuler')->default(0);
            });
        }
        if (!Schema::hasColumn('classes', 'is_sebelumnya')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->integer('is_sebelumnya')->default(0);
            });
        }
        if (!Schema::hasColumn('classes', 'video')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->text('video')->nullable();
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
        if (Schema::hasColumn('classes', 'is_terpopuler')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->dropColumn('is_terpopuler');
            });
        }
        if (Schema::hasColumn('classes', 'is_sebelumnya')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->dropColumn('is_sebelumnya');
            });
        }
        if (Schema::hasColumn('classes', 'video')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->dropColumn('video');
            });
        }
    }
};
