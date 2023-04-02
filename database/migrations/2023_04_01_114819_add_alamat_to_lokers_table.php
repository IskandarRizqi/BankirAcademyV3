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
        if (!Schema::hasColumn('loker', 'provinsi')) {
            Schema::table('loker', function (Blueprint $table) {
                $table->text('provinsi')->nullable();
            });
        }
        if (!Schema::hasColumn('loker', 'kabupaten')) {
            Schema::table('loker', function (Blueprint $table) {
                $table->text('kabupaten')->nullable();
            });
        }
        if (!Schema::hasColumn('loker', 'kecamatan')) {
            Schema::table('loker', function (Blueprint $table) {
                $table->text('kecamatan')->nullable();
            });
        }
        if (!Schema::hasColumn('loker', 'kelurahan')) {
            Schema::table('loker', function (Blueprint $table) {
                $table->text('kelurahan')->nullable();
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
        if (Schema::hasColumn('loker', 'provinsi')) {
            Schema::table('loker', function (Blueprint $table) {
                $table->dropColumn('provinsi');
            });
        }
    }
};
