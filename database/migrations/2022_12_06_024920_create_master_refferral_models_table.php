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
        Schema::create('master_referral', function (Blueprint $table) {
            $table->id();
            $table->double('nominal');
            $table->integer('min')->nullable();
            $table->integer('max')->nullable();
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->double('potongan_harga');
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
        Schema::dropIfExists('master_referral');
    }
};
