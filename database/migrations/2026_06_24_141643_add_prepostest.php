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
        if (!Schema::hasColumn('preposttest', 'tipe_prepost')) {
            Schema::table('preposttest', function (Blueprint $table) {
                $table->tinyInteger('tipe_prepost')->default(0)->nullable();
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
        if (Schema::hasColumn('preposttest', 'tipe_prepost')) {
            Schema::table('preposttest', function (Blueprint $table) {
                $table->dropColumn('tipe_prepost');
            });
        }
    }
};
