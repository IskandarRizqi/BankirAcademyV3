<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('datapayment', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('link_payment');
            $table->text('rejection_reason')->nullable()->after('payment_method');
        });
    }

    public function down(): void
    {
        Schema::table('datapayment', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'rejection_reason']);
        });
    }
};
