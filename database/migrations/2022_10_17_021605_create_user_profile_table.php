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
        Schema::create('user_profile', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('name');
            $table->string('phone_region')->default('+62');
            $table->integer('phone');
            $table->longText('picture')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->integer('gender')->comment('0=Perempuan;1=Laki-Laki');
            $table->integer('existing_user')->comment('0=false;1=true')->default(0);
            $table->text('description')->nullable();
            $table->text('instansi')->nullable();
            $table->text('rekening')->nullable();
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
        Schema::dropIfExists('user_profile');
    }
};
