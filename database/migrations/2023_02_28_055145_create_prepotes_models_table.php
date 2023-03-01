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
        Schema::create('prepotes', function (Blueprint $table) {
            $table->id();
            $table->integer('class_id');
            $table->json('kelas_id');
            $table->json('pertanyaan');
            $table->json('jawaban');
            $table->integer('status')->comment('dimulai dari 0')->default(0);
            $table->date('tanggal_awal')->nullable();
            $table->date('tanggal_akhir')->nullable();
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
        Schema::dropIfExists('prepotes');
    }
};
