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
        Schema::create('referral', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('user_aplicator');
            $table->string('code')->nullable();
            $table->double('nominal_class')->nullable();
            $table->double('nominal_admin')->nullable();
            $table->double('total')->nullable();
            $table->integer('available')->default(0)->comment('0:available; 1:unavailable');
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
        Schema::dropIfExists('referral');
    }
};
