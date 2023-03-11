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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->json('instructor');
            $table->text('category');
            $table->text('sub_category')->nullable();
            $table->json('tags')->nullable();
            $table->longText('image');
            $table->longText('content');
            $table->longText('unique_id');
            $table->integer('participant_limit');
            $table->date('date_start');
            $table->date('date_end');
            $table->longText('image_mobile')->nullable();
            $table->json('tipe');
            $table->integer('level')->comment('1:Pemula, 2:Menengah, 3:Lanjutan')->default(1);
            $table->json('jenis')->nullable();
            $table->json('og')->nullable();
            $table->json('meta')->nullable();
            $table->integer('status')->default(0);
            $table->integer('poin')->default(0);
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
        Schema::dropIfExists('classes');
    }
};
