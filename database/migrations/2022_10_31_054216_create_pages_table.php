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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->default(0)->comment('0:Blog;1:About;2:Kontak;3:Syarat dan Ketentuan;4:Calon Bankir;5:Bankir;6:Bootcamp Bankir;7:Bantuan');
            $table->string('title');
            $table->longText('thumbnail')->nullable();
            $table->longText('content');
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
        Schema::dropIfExists('pages');
    }
};
