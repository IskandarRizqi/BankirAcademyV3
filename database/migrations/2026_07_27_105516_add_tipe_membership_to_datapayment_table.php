<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('datapayment', function (Blueprint $table) {
            $table->unsignedTinyInteger('tipe_membership')
                ->nullable()
                ->after('tipe_pembelian')
                ->comment('1 membership perusahaan, 2 membership perorangan');
        });
    }

    public function down(): void
    {
        Schema::table('datapayment', function (Blueprint $table) {
            $table->dropColumn('tipe_membership');
        });
    }
};
