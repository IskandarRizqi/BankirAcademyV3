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
        $cvs = LamaranModel::query()
            ->whereIn('user_id', $applications->pluck('user_id')->unique())
            ->where('is_cv_ats', true)
            ->with('user')
            ->get()
            ->keyBy('user_id');

        $selected = [];
        $selectedUserIds = [];

        foreach ($applications as $application) {
            $userId = (int) $application->user_id;

            if (in_array($userId, $selectedUserIds, true)) {
                continue;
            }

            $cv = $cvs->get($userId);

            if (! $cv) {
                continue;
            }

            $candidateApplications = $applications
                ->where('user_id', $userId)
                ->sortBy('created_at')
                ->values();
            $firstApplication = $candidateApplications->first();
            $jobs = $candidateApplications
                ->map(fn (LokerApply $item) => $item->loker?->title)
                ->filter()
                ->unique()
                ->values()
                ->implode(', ');

            $selectedUserIds[] = $userId;
            $selected[] = [
                'user_id' => $userId,
                'cv' => $cv,
                'user' => $cv->user,
                'candidate' => [
                    'name' => $cv->nama_lengkap ?: ($cv->user?->name ?: 'Pelamar'),
                    'email' => $cv->user?->email ?: '',
                    'jobs' => $jobs ?: 'Lowongan tersedia',
                    'applied_at' => $this->formatDate($firstApplication?->created_at),
                ],
                'application_ids' => $candidateApplications->pluck('id')->all(),
            ];

            if (count($selected) >= 5) {
                break;
            }
        }

        if ($selected === []) {
            $this->updateDailyLog([
                'status' => 'skipped',
                'attempted_at' => now(),
                'error_message' => 'Tidak ada pelamar dengan CV ATS yang tersedia.',
            ]);

            return;
        }

        $attachments = [];
        foreach ($selected as $item) {
            $attachments[] = [
                'data' => $pdfService->make($item['cv'], $item['user'])->output(),
                'filename' => $pdfService->filename($item['cv']),
            ];
        }

        $applicationIds = collect($selected)
            ->flatMap(fn (array $item) => $item['application_ids'])
            ->unique()
            ->values()
            ->all();
        $candidateIds = collect($selected)->pluck('user_id')->values()->all();

        $this->updateDailyLog([
            'candidate_ids' => $candidateIds,
            'application_ids' => $applicationIds,
            'attempted_at' => now(),
        ]);

        Mail::to($this->recipientEmail)->send(new LokerDailyCvDigestMail(
            companyName: $this->companyName,
            candidates: collect($selected)->pluck('candidate')->all(),
            pdfAttachments: $attachments,
            sendDate: Carbon::parse($this->sendDate)->format('d M Y'),
        ));

        LokerApply::query()
            ->whereIn('id', $applicationIds)
            ->where('status', 0)
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
