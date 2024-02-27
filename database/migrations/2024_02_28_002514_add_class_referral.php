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
        if (!Schema::hasColumn('referral', 'class_id')) {
            Schema::table('referral', function (Blueprint $table) {
                $table->integer('class_id')->nullable();
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
        if (Schema::hasColumn('referral', 'class_id')) {
            Schema::table('referral', function (Blueprint $table) {
                $table->dropColumn('class_id');
            });
        }
    }
};
