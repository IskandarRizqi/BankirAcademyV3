<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Compatibility stub for jobs queued before admin-controlled delivery was enabled.
 */
class SendCompanyLokerCvDigest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly string $recipientKey,
        public readonly string $recipientEmail,
        public readonly ?int $perusahaanId,
        public readonly string $companyName,
        public readonly string $sendDate,
    ) {}

    public function handle(): void
    {
        // Automatic daily delivery has been retired; admins send applications manually.
    }
}
