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
        Schema::create('preposttest', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('id_materi')->nullable();
            $table->tinyInteger('id_submateri')->nullable();
            $table->jsonb('soal');
            $table->string('judul');
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
        Schema::dropIfExists('preposttest');
    }
};
