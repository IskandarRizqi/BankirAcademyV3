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
        Schema::create('class_certificate_template', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('class_id');
            $table->longText('background');
            $table->longText('content');
            $table->string('page_size');
            $table->integer('layout')->default(0);
            $table->date('certificate_created');
            $table->date('certificate_expired')->nullable();
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
        Schema::dropIfExists('class_certificate_template');
    }
};
