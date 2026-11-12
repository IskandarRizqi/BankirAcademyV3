<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->uuid('device_id')->nullable()->after('ip_address');
            $table->index('device_id');
        });

        Schema::table('visitors', function (Blueprint $table) {
            $table->dropUnique('visitors_daily_unique');
            $table->unique(
                ['device_id', 'page_url', 'visitor_type', 'visitor_date'],
                'visitors_daily_device_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->dropUnique('visitors_daily_device_unique');
            $table->unique(
                ['ip_address', 'page_url', 'visitor_type', 'visitor_date'],
                'visitors_daily_unique'
            );
            $table->dropIndex(['device_id']);
            $table->dropColumn('device_id');
        });
    }
};
