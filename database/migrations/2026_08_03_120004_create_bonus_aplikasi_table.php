<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bonus_aplikasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['upcoming', 'non_upcoming'])->default('non_upcoming');
            $table->enum('tipe_sumber', ['url', 'file']);
            $table->string('url', 2048)->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->string('mime_type', 100)->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->timestamps();

            $table->index(['status', 'tipe_sumber']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bonus_aplikasi');
    }
};
