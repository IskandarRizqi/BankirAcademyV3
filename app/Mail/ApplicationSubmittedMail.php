<?php

namespace App\Mail;

use App\Models\LamaranModel;
use App\Services\CvAtsPdfService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $applicant;
    public $loker;

    public function __construct(LamaranModel $applicant, $loker)
    {
        $this->applicant = $applicant;
        $this->loker = $loker;
    }

    /**
     * Memeriksa apakah konfigurasi SMTP / Mailer di .env sudah lengkap.
     */
    public static function hasValidConfig(): bool
    {
        $mailer = config('mail.default');

        // Jika mailer diset ke 'log' atau 'array', dianggap selalu valid untuk local test
        if (in_array($mailer, ['log', 'array'])) {
            return true;
        }

        // Jika menggunakan SMTP, pastikan host dan port terisi
        if ($mailer === 'smtp') {
            return !empty(config('mail.mailers.smtp.host')) &&
                !empty(config('mail.mailers.smtp.port')) &&
                !empty(config('mail.from.address'));
        }

        // Untuk driver lain (sesuai kebutuhan)
        return !empty(config('mail.from.address'));
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Lamaran Baru: ' . $this->loker->title . ' - ' . $this->applicant->nama_lengkap,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.application-submitted',
        );
    }

    public function attachments(): array
    {
        $pdfService = app(CvAtsPdfService::class);
        $pdf = $pdfService->make($this->applicant, $this->applicant->user);
        $fileName = $pdfService->filename($this->applicant);

        return [
            Attachment::fromData(fn() => $pdf->output(), $fileName)
                ->withMime('application/pdf'),
        ];
    }
}
