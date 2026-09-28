<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_profile', function (Blueprint $table) {
            $table->string('otp')->nullable()->after('phone');
            $table->boolean('status_nomor')->default(false)->after('otp');
            $table->timestamp('otp_expires_at')->nullable()->after('status_nomor');
        });
    }

    public function down(): void
    {
        Schema::table('user_profile', function (Blueprint $table) {
            $table->dropColumn(['otp', 'status_nomor', 'otp_expires_at']);
        });
    }
};
