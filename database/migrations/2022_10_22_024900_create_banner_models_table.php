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
        Schema::create('banner_slide', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('jenis')->comment('0 = bannerslide, 1 = banner bawah, 2 = banner promo, 3 = banner mobile, 4 = calon bankir, 5 = bankir,  6 = bootcampt bankir, 7 = all kelas');
            $table->date('mulai')->nullable();
            $table->date('selesai')->nullable();
            $table->text('image');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banner');
    }
};
