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
        Schema::table('classes', function (Blueprint $table) {
            $table->integer('kategori')->default(0)->comment('0 Online 1 Offline')->nullable();
            $table->time('jam_acara')->nullable();
            $table->text('lokasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->dropColumn('jenis');
            $table->dropColumn('jam_acara');
            $table->dropColumn('lokasi');
        });
    }
};
