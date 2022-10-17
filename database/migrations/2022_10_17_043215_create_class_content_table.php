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
        Schema::create('class_content', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('class_id');
            $table->integer('type')->comment('0:Document;1:Image;2:Video;');
			$table->longText('url');
			$table->string('title');
			$table->longText('description');
            $table->json('custom_attribute')->nullable();
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
        Schema::dropIfExists('class_content');
    }
};
