<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45);
            $table->text('user_agent')->nullable();
            $table->string('page_url', 255);
            $table->string('page_label', 150)->nullable();
            $table->string('visitor_type', 20);
            $table->date('visitor_date');
            $table->unsignedSmallInteger('visited_year');
            $table->timestamp('visited_at');
            $table->timestamps();

            $table->unique(
                ['ip_address', 'page_url', 'visitor_type', 'visitor_date'],
                'visitors_daily_unique'
            );
            $table->index('ip_address');
            $table->index('page_url');
            $table->index('visited_at');
            $table->index(['visitor_type', 'visited_at']);
            $table->index('visited_year');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
