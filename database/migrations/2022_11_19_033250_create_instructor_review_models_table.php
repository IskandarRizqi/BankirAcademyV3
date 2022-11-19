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
        Schema::create('instructor_review', function (Blueprint $table) {
            $table->id();
            $table->integer('instructor_id');
            $table->integer('users_id');
            $table->text('review_msg');
            $table->integer('review_val');
            $table->integer('status')->default(0)->comment('0: Tidak Tampil, 1: Tampil');
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
        Schema::dropIfExists('instructor_review');
    }
};
