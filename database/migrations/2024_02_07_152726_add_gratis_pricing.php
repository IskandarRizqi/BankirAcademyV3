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
        if (!Schema::hasColumn('class_pricing', 'gratis')) {
            Schema::table('class_pricing', function (Blueprint $table) {
                $table->integer('gratis')->default(0)->comment('0:tidak, 1:ya');
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
        if (Schema::hasColumn('class_pricing', 'gratis')) {
            Schema::table('class_pricing', function (Blueprint $table) {
                $table->dropColumn('gratis');
            });
        }
    }
};
