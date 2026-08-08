<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loker_cv_digest_logs', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_key', 150);
            $table->unsignedBigInteger('perusahaan_id')->nullable();
            $table->string('email');
            $table->date('send_date');
            $table->string('status', 20)->default('processing');
            $table->json('candidate_ids')->nullable();
            $table->json('application_ids')->nullable();
            $table->timestamp('attempted_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();

            $table->unique(['recipient_key', 'send_date']);
            $table->index(['send_date', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loker_cv_digest_logs');
    }
};
