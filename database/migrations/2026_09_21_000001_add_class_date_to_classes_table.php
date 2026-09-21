<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasColumn('classes', 'class_date')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->date('class_date')->nullable()->after('date_end');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('classes', 'class_date')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->dropColumn('class_date');
            });
        }
    }
};
