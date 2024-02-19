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
        if (!Schema::hasColumn('class_pricing', 'cashback_persen')) {
            Schema::table('class_pricing', function (Blueprint $table) {
                $table->double('cashback_persen')->default(0);
            });
        }
        if (!Schema::hasColumn('class_pricing', 'cashback_nominal')) {
            Schema::table('class_pricing', function (Blueprint $table) {
                $table->double('cashback_nominal')->default(0);
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
        if (Schema::hasColumn('classes', 'cashback_persen')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->dropColumn('cashback_persen');
            });
        }
        if (Schema::hasColumn('classes', 'cashback_nominal')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->dropColumn('cashback_nominal');
            });
        }
    }
};
