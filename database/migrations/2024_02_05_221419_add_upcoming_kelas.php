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
        if (!Schema::hasColumn('classes', 'custom_jadwal')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->integer('custom_jadwal')->default(0)->comment('0:running, 1: upcoming, 2:reschedule');
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
        if (Schema::hasColumn('classes', 'custom_jadwal')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->dropColumn('custom_jadwal');
            });
        }
    }
};
