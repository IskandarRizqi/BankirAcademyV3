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
        Schema::create('prepotes_user', function (Blueprint $table) {
            $table->id();
            $table->integer('class_id');
            $table->integer('user_id');
            $table->json('jawaban');
            $table->double('nilai_awal')->default(0);
            $table->double('nilai_akhir')->default(0);
            $table->integer('jml_jawaban')->default(0);
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
        Schema::dropIfExists('prepotes_user');
    }
};
