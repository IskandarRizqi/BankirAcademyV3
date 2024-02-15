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
        if (!Schema::hasColumn('lamaran_models', 'is_approved')) {
            Schema::table('lamaran_models', function (Blueprint $table) {
                $table->integer('is_approved')->default(0)->comment('0:tidak, 1:ya');
            });
        }
        if (!Schema::hasColumn('lamaran_models', 'is_approved_message')) {
            Schema::table('lamaran_models', function (Blueprint $table) {
                $table->text('is_approved_message')->nullable();
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
        if (Schema::hasColumn('lamaran_models', 'is_approved')) {
            Schema::table('lamaran_models', function (Blueprint $table) {
                $table->dropColumn('is_approved');
            });
        }
        if (Schema::hasColumn('lamaran_models', 'is_approved_message')) {
            Schema::table('lamaran_models', function (Blueprint $table) {
                $table->dropColumn('is_approved_message');
            });
        }
    }
};
