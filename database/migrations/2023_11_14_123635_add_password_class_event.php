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
        if (!Schema::hasColumn('class_event', 'password_link')) {
            Schema::table('class_event', function (Blueprint $table) {
                $table->string('password_link')->nullable();
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
        if (Schema::hasColumn('class_event', 'password_link')) {
            Schema::table('class_event', function (Blueprint $table) {
                $table->dropColumn('password_link');
            });
        }
    }
};
