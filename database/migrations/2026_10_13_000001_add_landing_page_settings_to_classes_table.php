<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('classes', 'landing_page_enabled')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->boolean('landing_page_enabled')->default(false)->after('iht');
            });
        }

        if (! Schema::hasColumn('classes', 'landing_page_theme')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->string('landing_page_theme', 40)->nullable()->after('landing_page_enabled');
            });
        }

        if (! Schema::hasColumn('classes', 'landing_page_generated_at')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->timestamp('landing_page_generated_at')->nullable()->after('landing_page_theme');
            });
        }
    }

    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            foreach (['landing_page_generated_at', 'landing_page_theme', 'landing_page_enabled'] as $column) {
                if (Schema::hasColumn('classes', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
