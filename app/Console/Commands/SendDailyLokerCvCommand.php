<?php

namespace App\Console\Commands;

use App\Jobs\SendCompanyLokerCvDigest;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendDailyLokerCvCommand extends Command
{
    protected $signature = 'loker:send-daily-cv {--date= : Tanggal pengiriman dalam format Y-m-d}';

    protected $description = 'Kirim digest CV ATS pelamar ke perusahaan setiap hari';

    public function handle(): int
    {
        $sendDate = $this->option('date')
            ? Carbon::createFromFormat('Y-m-d', $this->option('date'))->toDateString()
            : now()->toDateString();

        $recipients = DB::table('loker_applies')
            ->join('loker', 'loker.id', '=', 'loker_applies.loker_id')
            ->leftJoin('perusahaan_models', 'perusahaan_models.id', '=', 'loker.perusahaan_id')
            ->whereNull('loker_applies.deleted_at')
            ->where('loker_applies.status', 0)
            ->where(function ($query) {
                $query->where(function ($companyQuery) {
                    $companyQuery->whereNotNull('perusahaan_models.email')
                        ->where('perusahaan_models.email', '!=', '');
                })->orWhere(function ($lokerQuery) {
                    $lokerQuery->whereNotNull('loker.email')
                        ->where('loker.email', '!=', '');
                });
            })
            ->select([
                'loker.perusahaan_id',
                'perusahaan_models.nama as company_name',
                'perusahaan_models.email as company_email',
                'loker.nama as loker_company_name',
                'loker.email as loker_email',
            ])
            ->get()
            ->map(function ($row) {
                $companyId = $row->perusahaan_id ? (int) $row->perusahaan_id : null;
                $email = trim((string) ($row->company_email ?: $row->loker_email));

                if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return null;
                }

                return [
                    'recipient_key' => $companyId ? 'company:'.$companyId : 'email:'.strtolower($email),
                    'perusahaan_id' => $companyId,
                    'email' => $email,
                    'company_name' => trim((string) ($row->company_name ?: $row->loker_company_name)) ?: 'Perusahaan mitra',
                ];
            })
            ->filter()
            ->unique('recipient_key')
            ->values();

        foreach ($recipients as $recipient) {
            SendCompanyLokerCvDigest::dispatch(
                $recipient['recipient_key'],
                $recipient['email'],
                $recipient['perusahaan_id'],
                $recipient['company_name'],
                $sendDate,
            )->onQueue('loker-cv');
        }

        $this->info("{$recipients->count()} perusahaan dijadwalkan untuk pengiriman CV pada {$sendDate}.");

        return self::SUCCESS;
    }
}
