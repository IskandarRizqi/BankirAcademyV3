<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LokerDailyCvDigestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly string $companyName,
        public readonly array $candidates,
        public readonly array $pdfAttachments,
        public readonly string $sendDate,
    ) {}

    public function build(): self
    {
        $mail = $this
            ->subject('Daftar Kandidat Terbaru - '.config('app.name'))
            ->view('mail.loker-daily-cv-digest', [
                'companyName' => $this->companyName,
                'candidates' => $this->candidates,
                'sendDate' => $this->sendDate,
            ]);

        foreach ($this->pdfAttachments as $attachment) {
            $mail->attachData(
                $attachment['data'],
                $attachment['filename'],
                ['mime' => 'application/pdf'],
            );
        }

        return $mail;
    }
}
