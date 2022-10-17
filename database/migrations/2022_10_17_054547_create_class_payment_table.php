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
        Schema::create('class_payment', function (Blueprint $table) {
            $table->id();
			$table->integer('status')->default(0)->comment('0:unpaid;1:paid;');
            $table->bigInteger('user_id');
            $table->bigInteger('class_id');
            $table->integer('unique_code');
            $table->double('price');
            $table->double('price_final');
            $table->dateTime('expired')->nullable();
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
        Schema::dropIfExists('class_payment');
    }
};
