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
    public function up()
    {
        if (!Schema::hasColumn('lamaran_models', 'namaorangtuakandung')) {
            Schema::table('lamaran_models', function (Blueprint $table) {
                $table->string('namaorangtuakandung')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('lamaran_models', 'namaorangtuakandung')) {
            Schema::table('lamaran_models', function (Blueprint $table) {
                $table->dropColumn('namaorangtuakandung');
            });
        }
    }
};
