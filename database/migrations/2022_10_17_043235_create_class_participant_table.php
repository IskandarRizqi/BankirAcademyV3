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
        Schema::create('class_participant', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('class_id');
            $table->bigInteger('user_id');
            $table->bigInteger('payment_id');
            $table->integer('certificate')->comment('0:Not Available;1:Available')->default(0);
            $table->longText('review')->nullable();
            $table->integer('review_point')->nullable();
            $table->dateTime('review_time')->nullable();
            $table->integer('review_active')->default(0);
            $table->integer('jumlah')->default(1);
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
        Schema::dropIfExists('class_participant');
    }
};
