<?php

namespace App\Jobs;

use App\Mail\LokerDailyCvDigestMail;
use App\Models\LamaranModel;
use App\Models\LokerApply;
use App\Models\LokerCvDigestLog;
use App\Services\CvAtsPdfService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class SendCompanyLokerCvDigest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;
    public int $timeout = 300;

    public function __construct(
        public readonly string $recipientKey,
        public readonly string $recipientEmail,
        public readonly ?int $perusahaanId,
        public readonly string $companyName,
        public readonly string $sendDate,
    ) {
        $this->onConnection('database');
        $this->onQueue('loker-cv');
    }

    public function backoff(): array
    {
        return [60, 120, 300, 600];
    }

    public function middleware(): array
    {
        return [
            new RateLimited('loker-daily-cv-email'),
            (new WithoutOverlapping('loker-daily-cv-email:'.$this->recipientKey.':'.$this->sendDate))
                ->expireAfter(3600),
        ];
    }

    public function handle(CvAtsPdfService $pdfService): void
    {
        if (! $this->createDailyLog()) {
            return;
        }

        $applications = $this->pendingApplications();
        
        // Ambil data CV ATS spesifik berdasarkan user_id dan job_id (loker_id)
        $userIds = $applications->pluck('user_id')->unique();
        $lokerIds = $applications->pluck('loker_id')->unique();

        $cvs = LamaranModel::query()
            ->whereIn('user_id', $userIds)
            ->whereIn('job_id', $lokerIds)
            ->whereIn('status', [0])
            ->with('user')
            ->get()
            // Key by "user_id_job_id" untuk pencarian presisi per lamaran
            ->keyBy(fn ($item) => $item->user_id . '_' . $item->job_id);

        $selected = [];
        $attachments = [];
        $candidateDisplayList = [];
        $processedApplicationIds = [];
        $processedLamaranIds = [];
        $candidateIds = [];

        foreach ($applications as $application) {
            $userId = (int) $application->user_id;
            $lokerId = (int) $application->loker_id;
            $cvKey = $userId . '_' . $lokerId;

            // Cari CV spesifik untuk pasangan user dan posisi ini
            $cv = $cvs->get($cvKey);

            if (! $cv) {
                continue;
            }

            $jobTitle = $application->loker?->title ?: 'Lowongan tersedia';
            $candidateName = $cv->nama_lengkap ?: ($cv->user?->name ?: 'Pelamar');
            
            // Format nama file spesifik per posisi agar penerima email tidak bingung
            $safeJobTitle = Str::slug($jobTitle);
            $safeCandidateName = Str::slug($candidateName);
            $filename = "CV_{$safeCandidateName}_{$safeJobTitle}.pdf";

            // Generate PDF untuk posisi spesifik ini
            $attachments[] = [
                'data' => $pdfService->make($cv, $cv->user)->output(),
                'filename' => $filename,
            ];

            // List metadata kandidat per lamaran posisi
            $candidateDisplayList[] = [
                'name' => $candidateName,
                'email' => $cv->user?->email ?: '',
                'jobs' => $jobTitle,
                'applied_at' => $this->formatDate($application->created_at),
            ];

            $processedApplicationIds[] = $application->id;
            $processedLamaranIds[] = $cv->id;
            $candidateIds[] = $userId;

            // Batasi maksimal 5 item/CV terkirim per batch digest email
            if (count($attachments) >= 5) {
                break;
            }
        }

        if (empty($attachments)) {
            $this->updateDailyLog([
                'status' => 'skipped',
                'attempted_at' => now(),
                'error_message' => 'Tidak ada pelamar dengan CV ATS yang tersedia.',
            ]);

            return;
        }

        $applicationIds = array_unique($processedApplicationIds);
        $lamaranIds = array_unique($processedLamaranIds);
        $candidateIds = array_unique($candidateIds);

        $this->updateDailyLog([
            'candidate_ids' => array_values($candidateIds),
            'application_ids' => array_values($applicationIds),
            'attempted_at' => now(),
        ]);

        Mail::to($this->recipientEmail)->send(new LokerDailyCvDigestMail(
            companyName: $this->companyName,
            candidates: $candidateDisplayList,
            pdfAttachments: $attachments,
            sendDate: Carbon::parse($this->sendDate)->format('d M Y'),
        ));

        // Update status di LokerApply
        LokerApply::query()
            ->whereIn('id', $applicationIds)
            ->where('status', 0)
            ->update([
                'status' => 1,
                'updated_at' => now(),
            ]);

        // Update status di LamaranModel
        LamaranModel::query()
            ->whereIn('id', $lamaranIds)
            ->update([
                'status' => 1,
                'updated_at' => now(),
            ]);

        $this->updateDailyLog([
            'status' => 'sent',
            'sent_at' => now(),
            'error_message' => null,
        ]);
    }

    public function failed(Throwable $exception): void
    {
        $this->updateDailyLog([
            'status' => 'failed',
            'error_message' => Str::limit($exception->getMessage(), 1000),
        ]);
    }

    private function createDailyLog(): bool
    {
        $existing = LokerCvDigestLog::query()
            ->where('recipient_key', $this->recipientKey)
            ->whereDate('send_date', $this->sendDate)
            ->first();

        if ($existing) {
            if ($existing->status === 'processing' && $this->attempts() > 1) {
                $existing->update([
                    'status' => 'failed',
                    'error_message' => 'Pengiriman sebelumnya gagal sebelum status email diperbarui.',
                ]);
            }

            return false;
        }

        try {
            LokerCvDigestLog::create([
                'recipient_key' => $this->recipientKey,
                'perusahaan_id' => $this->perusahaanId,
                'email' => $this->recipientEmail,
                'send_date' => $this->sendDate,
                'status' => 'processing',
                'attempted_at' => now(),
            ]);
        } catch (Throwable $exception) {
            if (LokerCvDigestLog::query()
                ->where('recipient_key', $this->recipientKey)
                ->whereDate('send_date', $this->sendDate)
                ->exists()) {
                return false;
            }

            throw $exception;
        }

        return true;
    }

    private function pendingApplications()
    {
        return LokerApply::query()
            ->with(['loker', 'user'])
            ->where('status', 0)
            ->where(function ($query) {
                $query->whereHas('loker', function ($lokerQuery) {
                    if ($this->perusahaanId) {
                        $lokerQuery->where('perusahaan_id', $this->perusahaanId);
                    } else {
                        $lokerQuery
                            ->whereNull('perusahaan_id')
                            ->whereRaw('LOWER(TRIM(email)) = ?', [strtolower(trim($this->recipientEmail))]);
                    }
                });
            })
            ->orderBy('created_at')
            ->orderBy('id')
            ->get();
    }

    private function updateDailyLog(array $attributes): void
    {
        LokerCvDigestLog::query()
            ->where('recipient_key', $this->recipientKey)
            ->whereDate('send_date', $this->sendDate)
            ->update($attributes);
    }

    private function formatDate($date): string
    {
        return $date
            ? Carbon::parse($date)->locale('id')->isoFormat('D MMM YYYY, HH:mm')
            : '-';
    }
}