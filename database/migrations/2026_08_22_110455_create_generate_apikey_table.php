<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('scraper_api_keys', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // contoh: 'Scraper Python 01'
            $table->string('key_hash')->unique(); // Hash SHA-256 dari key
            $table->string('key_prefix', 16); // 8-16 karakter pertama untuk identifikasi di UI
            $table->timestamp('last_used_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scraper_api_keys');
    }
};
