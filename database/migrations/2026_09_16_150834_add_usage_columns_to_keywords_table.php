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
    public function up(): void
    {
        Schema::table('keywords', function (Blueprint $table) {
            $table->integer('articles_count')->default(0)->after('status');
            $table->timestamp('last_used_at')->nullable()->after('articles_count');
        });
    }

    public function down(): void
    {
        Schema::table('keywords', function (Blueprint $table) {
            $table->dropColumn(['articles_count', 'last_used_at']);
        });
    }
};
