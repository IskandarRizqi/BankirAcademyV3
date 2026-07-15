<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Mencatat progress Sub Materi
        Schema::create('user_sub_materi_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('id_sub_materi')->constrained('sub_materi')->onDelete('cascade');
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'id_sub_materi']); // Mencegah duplikasi data
        });

        // Mencatat progress Sub Materi Item
        Schema::create('user_sub_materi_item_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('id_sub_materi_item')->constrained('sub_materi_items')->onDelete('cascade');
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'id_sub_materi_item']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_sub_materi_item_progress');
        Schema::dropIfExists('user_sub_materi_progress');
    }
};
