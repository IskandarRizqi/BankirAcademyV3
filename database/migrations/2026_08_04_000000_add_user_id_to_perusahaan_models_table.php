<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('perusahaan_models', 'user_id')) {
            Schema::table('perusahaan_models', function (Blueprint $table) {
                $table->foreignId('user_id')
                    ->nullable()
                    ->unique()
                    ->constrained('users')
                    ->nullOnDelete()
                    ->after('id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('perusahaan_models', 'user_id')) {
            Schema::table('perusahaan_models', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropUnique('perusahaan_models_user_id_unique');
                $table->dropColumn('user_id');
            });
        }
    }
};
