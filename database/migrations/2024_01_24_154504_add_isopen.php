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
        if (!Schema::hasColumn('classes', 'is_open')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->integer('is_open')->default(1);
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
        if (Schema::hasColumn('classes', 'is_open')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->dropColumn('is_open');
            });
        }
    }
};
