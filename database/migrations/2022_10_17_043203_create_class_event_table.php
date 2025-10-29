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
        Schema::create('class_event', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('class_id');
            $table->integer('type')->comment('0:Online;1:Offline');
            $table->longText('link')->nullable();
            $table->longText('location')->nullable();
            $table->longText('description');
            $table->dateTimeTz('time_start');
            $table->dateTimeTz('time_end');
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
        Schema::dropIfExists('class_event');
    }
};
