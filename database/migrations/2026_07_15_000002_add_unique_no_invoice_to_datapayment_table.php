<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('datapayment', function (Blueprint $table) {
            $table->unique('no_invoice', 'datapayment_no_invoice_unique');
        });
    }

    public function down(): void
    {
        Schema::table('datapayment', function (Blueprint $table) {
            $table->dropUnique('datapayment_no_invoice_unique');
        });
    }
};
