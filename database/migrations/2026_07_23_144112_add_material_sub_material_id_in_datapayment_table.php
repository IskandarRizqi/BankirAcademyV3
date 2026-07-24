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
        Schema::table('datapayment', function (Blueprint $table) {
            $table->bigInteger('materi_id')->nullable();
            $table->bigInteger('submateri_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('datapayment', function (Blueprint $table) {
            $table->dropColumn('materi_id');
            $table->dropColumn('submateri_id');
        });
    }
};
