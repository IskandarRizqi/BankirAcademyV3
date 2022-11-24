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
        Schema::create('class_laman', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->json('meta')->nullable();
            $table->json('og');
            $table->json('banner');
            $table->text('content');
            $table->text('slug');
            $table->text('tag')->nullable();
            $table->date('tgl_tayang')->nullable();
            $table->date('tgl_expired')->nullable();
            $table->integer('type')->comment('1: head, 2: footer');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('class_laman');
    }
};
