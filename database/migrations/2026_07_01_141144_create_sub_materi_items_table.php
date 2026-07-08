<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sub_materi_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_sub_materi')->constrained('sub_materi')->onDelete('cascade');
            $table->string('judul_item');
            $table->string('link_item');
            $table->tinyInteger('tipe_link_item')->comment('0: Video, 1: PDF');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sub_materi_items');
    }
};