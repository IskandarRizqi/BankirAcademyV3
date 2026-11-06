<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('loker_applies', function (Blueprint $table) {
            $table->string('review_status', 20)
                ->default('pending')
                ->after('status')
                ->index();
            $table->unsignedBigInteger('reviewed_by')->nullable()->after('review_status');
            $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
            $table->timestamp('sent_at')->nullable()->after('reviewed_at');
            $table->text('send_error')->nullable()->after('sent_at');
        });
    }

    public function down(): void
    {
        Schema::table('loker_applies', function (Blueprint $table) {
            $table->dropIndex(['review_status']);
            $table->dropColumn([
                'review_status',
                'reviewed_by',
                'reviewed_at',
                'sent_at',
                'send_error',
            ]);
        });
    }
};
