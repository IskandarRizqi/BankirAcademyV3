<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('scraper_ingestion_controls', function (Blueprint $table) {
            $table->id();
            $table->string('source_type')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('scraper_ingestion_controls')->insert([
            'source_type' => 'job_platform',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('scraper_ingestion_controls');
    }
};
