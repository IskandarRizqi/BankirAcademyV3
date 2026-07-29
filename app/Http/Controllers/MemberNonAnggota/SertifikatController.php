<?php

namespace App\Http\Controllers\MemberNonAnggota;

use App\Http\Controllers\Controller;
use App\Models\ClassCertificateTemplate;
use App\Models\ClassEventModel;
use App\Models\ClassParticipantModel;
use App\Models\ClassesModel;
use App\Models\DataPayment;
use App\Models\SertifikatPesertaModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use RuntimeException;
use ZipArchive;

class SertifikatController extends Controller
{
    private const STATUS_AVAILABLE = 'available';

    public function index(Request $request)
    {
        $filters = $request->validate([
            'class_name' => ['nullable', 'string', 'max:255'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);

        $filters = array_merge([
            'class_name' => '',
            'date_from' => '',
            'date_to' => '',
        ], $filters);

        $classes = $this->applyCertificateFilters(
            $this->ownedClassesQuery($request->user()->id),
            $filters
        )
            ->orderByDesc('date_end')
            ->paginate(6, ['*'], 'certificate_page');

        $certificateClasses = $this->buildCertificateClasses(
            $classes->getCollection(),
            $request->user()->id
        );

        return view('membernonkeanggotaan.pages.sertifikat.index', [
            'certificateClasses' => $certificateClasses,
            'classes' => $classes,
            'filters' => $filters,
        ]);
    }

    public function show(Request $request, int $classId)
    {
        $entry = $this->findCertificateClass($request->user()->id, $classId);
        $this->ensureCertificateIsAvailable($entry);

        $participantIndex = filter_var(
            $request->query('participant_index'),
            FILTER_VALIDATE_INT
        );

        abort_if(
            $participantIndex === false || $participantIndex < 0,
            422,
            'Pilih nama peserta terlebih dahulu.'
        );

        $participant = $entry['participants'][$participantIndex] ?? null;
        abort_if(! $participant, 404, 'Peserta sertifikat tidak ditemukan.');
        abort_unless(
            $participant['can_print'] ?? false,
            403,
            'Kelas ini tidak menyertakan sertifikat untuk peserta pada order tersebut.'
        );

        $pdf = $this->makeCertificatePdf($entry, $participant, $participantIndex);

        return $pdf->stream($this->certificateFilename($entry, $participant, $participantIndex));
    }

    public function downloadZip(Request $request, int $classId)
    {
        $entry = $this->findCertificateClass($request->user()->id, $classId);
        $this->ensureCertificateIsAvailable($entry);

        $certificateParticipants = array_filter(
            $entry['participants'],
            fn (array $participant) => $participant['can_print'] ?? false
        );
        abort_if($certificateParticipants === [], 403, 'Tidak ada peserta dengan sertifikat pada order ini.');

        if (! class_exists(ZipArchive::class)) {
            abort(500, 'Fitur unduh ZIP belum tersedia di server.');
        }

        $zipPath = tempnam(storage_path('app'), 'sertifikat-');
        abort_unless($zipPath !== false, 500, 'File ZIP tidak dapat dibuat.');

        $zip = new ZipArchive;

        try {
            $zipStatus = $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
            if ($zipStatus !== true) {
                throw new RuntimeException('File ZIP tidak dapat dibuka.');
            }

            foreach ($certificateParticipants as $participantIndex => $participant) {
                $pdf = $this->makeCertificatePdf($entry, $participant, $participantIndex);
                $filename = $this->certificateFilename($entry, $participant, $participantIndex);

                if (! $zip->addFromString($filename, $pdf->output())) {
                    throw new RuntimeException('Sertifikat peserta gagal dimasukkan ke ZIP.');
                }
            }

            $zip->close();
        } catch (\Throwable $exception) {
            $zip->close();
            @unlink($zipPath);
            report($exception);

            abort(500, 'ZIP sertifikat tidak dapat dibuat.');
        }

        return response()
            ->download(
                $zipPath,
                'Sertifikat-' . Str::slug($entry['class']->title) . '.zip',
                ['Content-Type' => 'application/zip']
            )
            ->deleteFileAfterSend(true);
    }

    private function ownedClassesQuery(int $userId)
    {
        return ClassesModel::query()
            ->where('status', 1)
            ->whereIn('id', DataPayment::query()
                ->select('class_id')
                ->where('user_id', $userId)
                ->where('status', DataPayment::STATUS_PAID)
                ->whereNotNull('class_id'));
    }

    private function applyCertificateFilters($query, array $filters)
    {
        $className = trim((string) ($filters['class_name'] ?? ''));
        if ($className !== '') {
            $query->where('title', 'like', '%'.$className.'%');
        }

        $dateFrom = filled($filters['date_from'] ?? null)
            ? Carbon::parse($filters['date_from'])->startOfDay()
            : null;
        $dateTo = filled($filters['date_to'] ?? null)
            ? Carbon::parse($filters['date_to'])->endOfDay()
            : null;

        if ($dateFrom || $dateTo) {
            $query->whereHas('classEvents', function ($eventQuery) use ($dateFrom, $dateTo) {
                if ($dateFrom) {
                    $eventQuery->where(function ($eventQuery) use ($dateFrom) {
                        $eventQuery->where('time_end', '>=', $dateFrom)
                            ->orWhereNull('time_end');
                    });
                }

                if ($dateTo) {
                    $eventQuery->where('time_start', '<=', $dateTo);
                }
            });
        }

        return $query;
    }

    private function buildCertificateClasses(Collection $classes, int $userId): Collection
    {
        if ($classes->isEmpty()) {
            return collect();
        }

        $classIds = $classes->pluck('id')->values();
        $payments = DataPayment::query()
            ->where('user_id', $userId)
            ->where('status', DataPayment::STATUS_PAID)
            ->whereIn('class_id', $classIds)
            ->with('classPayment')
            ->latest('id')
            ->get()
            ->groupBy('class_id');

        $paymentClassIds = $payments
            ->flatten(1)
            ->pluck('classPayment.id')
            ->filter()
            ->values();
        $classParticipants = ClassParticipantModel::query()
            ->whereIn('payment_id', $paymentClassIds)
            ->get()
            ->keyBy('payment_id');
        $classParticipantsByClass = ClassParticipantModel::query()
            ->where('user_id', $userId)
            ->whereIn('class_id', $classIds)
            ->get()
            ->groupBy('class_id');
        $participantDetails = SertifikatPesertaModel::query()
            ->where('user_id', $userId)
            ->whereIn('payment_class_id', $paymentClassIds)
            ->latest('id')
            ->get()
            ->unique('payment_class_id')
            ->keyBy('payment_class_id');
        $participantDetailsByClass = SertifikatPesertaModel::query()
            ->where('user_id', $userId)
            ->whereIn('class_id', $classIds)
            ->latest('id')
            ->get()
            ->unique('class_id')
            ->keyBy('class_id');
        $events = ClassEventModel::query()
            ->whereIn('class_id', $classIds)
            ->orderBy('time_end')
            ->get()
            ->groupBy('class_id');
        $templates = ClassCertificateTemplate::query()
            ->whereIn('class_id', $classIds)
            ->get()
            ->keyBy('class_id');

        return $classes->map(function (ClassesModel $class) use (
            $payments,
            $classParticipants,
            $classParticipantsByClass,
            $participantDetails,
            $participantDetailsByClass,
            $events,
            $templates
        ) {
            $paymentCandidates = $payments->get($class->id, collect());
            $certificateParticipant = $paymentCandidates
                ->map(fn (DataPayment $payment) => $classParticipants->get($payment->classPayment?->id))
                ->filter(fn ($participant) => (int) ($participant->certificate ?? 0) === 1)
                ->first();
            $certificateParticipant ??= $classParticipantsByClass
                ->get($class->id, collect())
                ->first(fn ($participant) => (int) $participant->certificate === 1);

            $classPayment = $certificateParticipant
                ? $paymentCandidates
                    ->first(fn (DataPayment $payment) => (int) ($payment->classPayment?->id) === (int) $certificateParticipant->payment_id)
                    ?->classPayment
                : null;
            $classPayment ??= $paymentCandidates
                ->map(fn (DataPayment $payment) => $payment->classPayment)
                ->filter()
                ->first();

            $participants = $this->buildParticipantsForPayments(
                $paymentCandidates,
                $classParticipants,
                $participantDetails,
                $participantDetailsByClass->get($class->id),
                $certificateParticipant !== null
            );
            $hasCertificateParticipant = collect($participants)
                ->contains(fn (array $participant) => $participant['can_print']);

            return $this->makeCertificateClassEntry(
                $class,
                $classPayment,
                $participants,
                $events->get($class->id, collect()),
                $templates->get($class->id),
                $hasCertificateParticipant
            );
        });
    }

    private function findCertificateClass(int $userId, int $classId): array
    {
        $class = $this->ownedClassesQuery($userId)
            ->whereKey($classId)
            ->firstOrFail();

        $entry = $this->buildCertificateClasses(collect([$class]), $userId)->first();

        abort_unless($entry, 404, 'Data sertifikat tidak ditemukan.');

        return $entry;
    }

    private function makeCertificateClassEntry(
        ClassesModel $class,
        $classPayment,
        array $participants,
        Collection $events,
        ?ClassCertificateTemplate $template,
        bool $certificateRequested
    ): array {
        $completionAt = $this->lastEventEnd($events);
        [$status, $statusLabel, $statusMessage] = $this->resolveStatus(
            $certificateRequested,
            $events,
            $template,
            $completionAt,
            $participants
        );

        return [
            'class' => $class,
            'class_payment' => $classPayment,
            'template' => $template,
            'participants' => $participants,
            'participant_count' => count($participants),
            'completion_at' => $completionAt,
            'status' => $status,
            'status_label' => $statusLabel,
            'status_message' => $statusMessage,
        ];
    }

    private function buildParticipantsForPayments(
        Collection $payments,
        Collection $classParticipants,
        Collection $participantDetails,
        ?SertifikatPesertaModel $fallbackDetail,
        bool $fallbackCanPrint
    ): array {
        $participants = [];

        foreach ($payments as $payment) {
            $classPayment = $payment->classPayment;
            $classParticipant = $classPayment
                ? $classParticipants->get($classPayment->id)
                : null;
            $participantDetail = $classPayment
                ? $participantDetails->get($classPayment->id)
                : null;

            if (! $participantDetail) {
                continue;
            }

            $canPrint = (int) ($classParticipant->certificate ?? 0) === 1;
            foreach ($this->decodeParticipants($participantDetail) as $participant) {
                $participants[] = [
                    'index' => count($participants),
                    'nama' => $participant['nama'],
                    'email' => $participant['email'],
                    'nohp' => $participant['nohp'],
                    'can_print' => $canPrint,
                ];
            }
        }

        if ($participants === [] && $fallbackDetail) {
            foreach ($this->decodeParticipants($fallbackDetail) as $participant) {
                $participants[] = [
                    'index' => count($participants),
                    'nama' => $participant['nama'],
                    'email' => $participant['email'],
                    'nohp' => $participant['nohp'],
                    'can_print' => $fallbackCanPrint,
                ];
            }
        }

        return $participants;
    }

    private function resolveStatus(
        bool $certificateRequested,
        Collection $events,
        ?ClassCertificateTemplate $template,
        ?Carbon $completionAt,
        array $participants
    ): array {
        if (! $certificateRequested) {
            return [
                'not_requested',
                'Tidak termasuk order',
                'Kelas ini tidak menyertakan sertifikat ketika pembelian kelas.',
            ];
        }

        if ($events->isEmpty()) {
            return [
                'event_not_configured',
                'Jadwal belum disetting',
                'Data kegiatan kelas belum tersedia. Sertifikat belum dapat diakses.',
            ];
        }

        if (! $this->isTemplateConfigured($template)) {
            return [
                'template_not_configured',
                'Template belum tersedia',
                'Template sertifikat kelas belum tersedia atau belum lengkap.',
            ];
        }

        if (! $completionAt) {
            return [
                'event_not_completed',
                'Waktu selesai belum disetting',
                'Waktu selesai kegiatan kelas belum disetting oleh pengelola.',
            ];
        }

        if (now()->lt($completionAt)) {
            return [
                'event_not_completed',
                'Kelas belum selesai',
                'Sertifikat dapat diakses setelah kegiatan selesai pada ' . $completionAt->format('d/m/Y H:i') . ' WIB.',
            ];
        }

        if ($participants === []) {
            return [
                'participants_missing',
                'Data peserta belum tersedia',
                'Data nama peserta belum tersedia untuk dibuatkan sertifikat.',
            ];
        }

        return [
            self::STATUS_AVAILABLE,
            'Siap dicetak',
            'Pilih nama peserta untuk menampilkan sertifikat.',
        ];
    }

    private function lastEventEnd(Collection $events): ?Carbon
    {
        $eventEnds = $events
            ->pluck('time_end')
            ->filter()
            ->map(fn($time) => Carbon::parse($time))
            ->sortBy(fn(Carbon $time) => $time->timestamp);

        return $eventEnds->last();
    }

    private function isTemplateConfigured(?ClassCertificateTemplate $template): bool
    {
        if (! $template || blank($template->background) || blank($template->page_size)) {
            return false;
        }

        return is_file(public_path(ltrim($template->background, '/\\')));
    }

    private function decodeParticipants(?SertifikatPesertaModel $detail): array
    {
        if (! $detail) {
            return [];
        }

        $decodedNames = json_decode((string) $detail->nama, true);
        $decodedEmails = json_decode((string) $detail->email, true) ?: [];
        $decodedPhones = json_decode((string) $detail->nohp, true) ?: [];
        if (! is_array($decodedNames)) {
            return [];
        }

        return collect($decodedNames)
            ->map(fn($name) => trim((string) $name))
            ->filter()
            ->values()
            ->map(fn(string $name, int $index) => [
                'index' => $index,
                'nama' => $name,
                'email' => $decodedEmails[$index] ?? '',
                'nohp' => $decodedPhones[$index] ?? '',
            ])
            ->all();
    }

    private function ensureCertificateIsAvailable(array $entry): void
    {
        abort_unless(
            $entry['status'] === self::STATUS_AVAILABLE,
            403,
            $entry['status_message']
        );
    }

    private function makeCertificatePdf(array $entry, array $participant, int $participantIndex)
    {
        $template = $entry['template'];
        $class = $entry['class'];
        $contents = str_replace(
            ['[[date_expired]]', '[[date_active]]', '[[class]]', '[[name]]'],
            [
                $template->certificate_expired ?: '-',
                $template->certificate_created ?: '-',
                $class->title,
                $participant['nama'],
            ],
            (string) $template->content
        );

        return Pdf::loadView('backend/certificate/certificate', [
            'class' => $class,
            'certs' => $template,
            'name' => $participant['nama'],
            'contents' => $contents,
            'certificate_code' => $this->certificateCode($class, $participantIndex),
        ])->setPaper(
            $template->page_size,
            (int) $template->layout === 1 ? 'portrait' : 'landscape'
        );
    }

    private function certificateCode(ClassesModel $class, int $participantIndex): string
    {
        return sprintf(
            'BAI-%s-%d-%03d',
            now()->format('dmy'),
            $class->id,
            $participantIndex + 1
        );
    }

    private function certificateFilename(array $entry, array $participant, int $participantIndex): string
    {
        return sprintf(
            '%02d-%s.pdf',
            $participantIndex + 1,
            Str::slug($participant['nama']) ?: 'peserta'
        );
    }
}
