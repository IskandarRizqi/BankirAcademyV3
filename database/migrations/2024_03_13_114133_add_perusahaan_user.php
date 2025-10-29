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
        if (!Schema::hasColumn('loker', 'perusahaan_user')) {
            Schema::table('loker', function (Blueprint $table) {
                $table->integer('perusahaan_user')->nullable();
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
        if (Schema::hasColumn('loker', 'perusahaan_user')) {
            Schema::table('loker', function (Blueprint $table) {
                $table->dropColumn('perusahaan_user');
            });
        }
    }
};
