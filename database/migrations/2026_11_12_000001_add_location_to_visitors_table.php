<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->string('country_code', 2)->nullable()->after('ip_address');
            $table->string('country', 100)->nullable()->after('country_code');
            $table->string('province', 150)->nullable()->after('country');
            $table->string('city', 150)->nullable()->after('province');
            $table->index(['province', 'city']);
        });
    }

    public function down(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->dropIndex(['province', 'city']);
            $table->dropColumn(['country_code', 'country', 'province', 'city']);
        });
    }
};
