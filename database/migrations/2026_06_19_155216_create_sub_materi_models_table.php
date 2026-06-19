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
        Schema::create('sub_materi', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->text('link')->nullable();
            $table->text('keterangan')->nullable();
            $table->tinyInteger('id_materi');
            $table->tinyInteger('urutan');
            $table->tinyInteger('tipe_link')->comment('0: video, 1: pdf');
            $table->tinyInteger('tipe_beasiswa')->comment('0: semua, 1: beasiswa, 2: non beasiswa');
            $table->timestamp('masa_aktif')->nullable();
            $table->double('harga')->default(0);
            $table->double('diskon')->default(0);
            $table->double('harga_final')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_materi');
    }
};
