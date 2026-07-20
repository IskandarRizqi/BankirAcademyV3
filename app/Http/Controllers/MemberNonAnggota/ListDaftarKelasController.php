<?php

namespace App\Http\Controllers\MemberNonAnggota;

use App\Exports\IhtParticipantTemplateExport;
use App\Http\Controllers\Controller;
use App\Imports\IhtParticipantImport;
use App\Models\ClassesModel;
use App\Models\ClassParticipantModel;
use App\Models\ClassPaymentModel;
use App\Models\DataPayment;
use App\Models\SertifikatPesertaModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ListDaftarKelasController extends Controller
{
    public function kelasanda(Request $request)
    {
        $user = $request->user();

        $paidClassIds = DataPayment::where('user_id', $user->id)
            ->whereNotNull('class_id')
            ->where('status', DataPayment::STATUS_PAID)
            ->pluck('class_id')
            ->unique()
            ->toArray();

        $classesQuery = ClassesModel::whereIn('id', $paidClassIds)
            ->where('status', 1)
            ->orderBy('date_end', 'desc');

        $now = Carbon::now()->startOfDay();

        $totalClasses = clone $classesQuery;
        $totalCount = $totalClasses->count();

        $activeClassesQuery = clone $classesQuery;
        $activeClassesQuery->where(function ($query) use ($now) {
            $query->whereNull('date_end')
                ->orWhere('date_end', '>=', $now->toDateString());
        });
        $activeCount = $activeClassesQuery->count();
        $activeClasses = $activeClassesQuery->paginate(6, ['*'], 'active_page');

        $completedClassesQuery = clone $classesQuery;
        $completedClassesQuery->where('date_end', '<', $now->format('Y-m-d'));
        $completedCount = $completedClassesQuery->count();
        $completedClasses = $completedClassesQuery->paginate(6, ['*'], 'completed_page');

        $this->attachParticipantData($activeClasses->getCollection(), $paidClassIds, $user->id);
        $this->attachParticipantData($completedClasses->getCollection(), $paidClassIds, $user->id);

        $activeTab = $request->query('tab', 'active');
        $activeTab = in_array($activeTab, ['active', 'completed'], true) ? $activeTab : 'active';

        return view('membernonkeanggotaan.pages.kelas.listkelas', compact(
            'totalCount',
            'activeCount',
            'completedCount',
            'activeClasses',
            'completedClasses',
            'activeTab'
        ));
    }

    public function storeParticipants(Request $request, int $classId)
    {
        $participants = $this->validateParticipants($request);
        $payment = $this->findIhtPayment($request, $classId);

        if (! $payment) {
            abort(403);
        }

        DB::transaction(function () use ($payment, $participants) {
            $this->saveParticipants($payment, $participants);
        });

        return back()->with('success', 'Data peserta berhasil disimpan.');
    }

    public function destroyParticipants(Request $request, int $classId)
    {
        $payment = $this->findIhtPayment($request, $classId);

        if (! $payment) {
            abort(403);
        }

        DB::transaction(function () use ($payment) {
            ClassParticipantModel::where('payment_id', $payment['classPayment']->id)
                ->where('user_id', $payment['dataPayment']->user_id)
                ->delete();

            $payment['dataPayment']->update(['qty' => 0]);
            $payment['classPayment']->update(['jumlah' => 0]);

            SertifikatPesertaModel::where('payment_class_id', $payment['classPayment']->id)
                ->where('user_id', $payment['dataPayment']->user_id)
                ->delete();
        });

        return back()->with('success', 'Data peserta berhasil dihapus.');
    }

    public function downloadParticipantTemplate()
    {
        return Excel::download(
            new IhtParticipantTemplateExport,
            'template-peserta-iht.xlsx'
        );
    }

    public function importParticipants(Request $request, int $classId)
    {
        $payment = $this->findIhtPayment($request, $classId);

        if (! $payment) {
            abort(403);
        }

        $fileValidator = Validator::make($request->all(), [
            'participant_file' => [
                'required',
                'file',
                'max:5120',
                'mimes:xlsx,xls,csv',
            ],
        ], [
            'participant_file.required' => 'File Excel wajib dipilih.',
            'participant_file.file' => 'File import tidak valid.',
            'participant_file.max' => 'Ukuran file maksimal 5 MB.',
            'participant_file.mimes' => 'Format file harus xlsx, xls, atau csv.',
        ]);

        if ($fileValidator->fails()) {
            return back()->with('error', $fileValidator->errors()->first());
        }

        $validatedFile = $fileValidator->validated();

        try {
            $import = new IhtParticipantImport;
            Excel::import($import, $validatedFile['participant_file']);
            $participants = $this->validateImportedParticipants($import->rows ?? collect(), $classId);

            DB::transaction(function () use ($payment, $participants) {
                $this->saveParticipants($payment, $participants);
            });
        } catch (\Throwable $exception) {
            report($exception);

            $message = $exception instanceof \InvalidArgumentException
                ? $exception->getMessage()
                : 'Import gagal. Pastikan template dan isi file sesuai petunjuk.';

            return back()->with('error', $message);
        }

        return back()->with('success', 'Import berhasil. '.count($participants['nama']).' data peserta tersimpan.');
    }

    private function validateParticipants(Request $request): array
    {
        $validated = $request->validate([
            'nama' => ['required', 'array', 'min:1', 'max:100'],
            'nama.*' => ['required', 'string', 'max:255'],
            'email' => ['required', 'array', 'min:1', 'max:100'],
            'email.*' => ['required', 'email', 'max:255'],
            'nomor_handphone' => ['required', 'array', 'min:1', 'max:100'],
            'nomor_handphone.*' => ['required', 'string', 'max:30'],
        ]);

        $names = $validated['nama'] ?? [];
        $emails = $validated['email'] ?? [];
        $phones = $validated['nomor_handphone'] ?? [];

        if (count($names) !== count($emails) || count($names) !== count($phones)) {
            abort(422, 'Data peserta tidak lengkap.');
        }

        return [
            'nama' => array_values($names),
            'email' => array_values($emails),
            'nohp' => array_values($phones),
        ];
    }

    private function validateImportedParticipants($rows, int $classId): array
    {
        $requiredHeaders = ['nama', 'email', 'nomor_handphone'];
        $firstRow = $rows->first();

        if (! $firstRow) {
            throw new \InvalidArgumentException('File tidak memiliki data peserta. Gunakan template dan isi data peserta terlebih dahulu.');
        }

        $headers = $firstRow ? array_keys($firstRow->toArray()) : [];
        $missingHeaders = array_diff($requiredHeaders, $headers);

        if ($missingHeaders) {
            throw new \InvalidArgumentException(
                'Kolom wajib tidak ditemukan: '.implode(', ', $missingHeaders)
            );
        }

        $participants = [];
        $emails = [];
        $errors = [];

        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2;
            $name = trim((string) ($row['nama'] ?? ''));
            $email = trim((string) ($row['email'] ?? ''));
            $phone = trim((string) ($row['nomor_handphone'] ?? ''));

            if ($name === '' && $email === '' && $phone === '') {
                continue;
            }

            if ($name === '' || strlen($name) > 255) {
                $errors[] = "Baris {$rowNumber}: nama wajib diisi dan maksimal 255 karakter.";
            }

            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Baris {$rowNumber}: format email tidak valid.";
            }

            if ($phone === '' || strlen($phone) > 30) {
                $errors[] = "Baris {$rowNumber}: nomor handphone wajib diisi dan maksimal 30 karakter.";
            }

            $emailKey = strtolower($email);
            if (isset($emails[$emailKey])) {
                $errors[] = "Baris {$rowNumber}: email duplikat dengan baris {$emails[$emailKey]}.";
            }
            $emails[$emailKey] = $rowNumber;

            $participants['nama'][] = $name;
            $participants['email'][] = $email;
            $participants['nohp'][] = $phone;
        }

        $class = ClassesModel::query()->select('participant_limit')->find($classId);
        $participantLimit = (int) ($class->participant_limit ?? 0);
        if ($participantLimit > 0 && count($participants['nama'] ?? []) > $participantLimit) {
            $errors[] = "Jumlah peserta melebihi kuota kelas ({$participantLimit} orang).";
        }

        if ($errors) {
            throw new \InvalidArgumentException(implode(' ', array_slice($errors, 0, 10)));
        }

        return $participants;
    }

    private function findIhtPayment(Request $request, int $classId): ?array
    {
        $dataPayment = DataPayment::query()
            ->where('user_id', $request->user()->id)
            ->where('class_id', $classId)
            ->where('status', DataPayment::STATUS_PAID)
            ->where('is_iht', 1)
            ->latest('id')
            ->first();

        if (! $dataPayment) {
            return null;
        }

        $classPayment = ClassPaymentModel::query()
            ->where('user_id', $request->user()->id)
            ->where('class_id', $classId)
            ->where('no_invoice', $dataPayment->no_invoice)
            ->where('status', 1)
            ->first();

        return $classPayment ? compact('dataPayment', 'classPayment') : null;
    }

    private function saveParticipants(array $payment, array $participants): void
    {
        $classPayment = $payment['classPayment'];
        $dataPayment = $payment['dataPayment'];
        $count = count($participants['nama']);

        $dataPayment->update(['qty' => $count]);

        ClassParticipantModel::updateOrCreate(
            [
                'payment_id' => $classPayment->id,
                'user_id' => $dataPayment->user_id,
            ],
            [
                'class_id' => $dataPayment->class_id,
                'jumlah' => $count,
            ]
        );

        SertifikatPesertaModel::updateOrCreate(
            [
                'payment_class_id' => $classPayment->id,
                'user_id' => $dataPayment->user_id,
                'class_id' => $dataPayment->class_id,
            ],
            [
                'nama' => json_encode($participants['nama']),
                'email' => json_encode($participants['email']),
                'nohp' => json_encode($participants['nohp']),
            ]
        );
    }

    private function attachParticipantData($classes, array $classIds, int $userId): void
    {
        $payments = DataPayment::query()
            ->where('user_id', $userId)
            ->whereIn('class_id', $classIds)
            ->where('status', DataPayment::STATUS_PAID)
            ->with('classPayment:id,no_invoice')
            ->latest('id')
            ->get()
            ->unique('class_id');

        $paymentIds = $payments->pluck('classPayment.id')->filter();
        $details = SertifikatPesertaModel::query()
            ->where('user_id', $userId)
            ->whereIn('payment_class_id', $paymentIds)
            ->get()
            ->keyBy('payment_class_id');

        foreach ($classes as $class) {
            $dataPayment = $payments->firstWhere('class_id', $class->id);
            $classPayment = $dataPayment?->classPayment;
            $detail = $classPayment ? $details->get($classPayment->id) : null;
            $participantList = $this->decodeParticipants($detail);
            $isIht = (int) ($dataPayment->is_iht ?? 0) === 1;
            $participantCount = (int) ($dataPayment->qty ?? 0);

            // IHT dibuat dengan qty default, tetapi belum memiliki peserta.
            if ($isIht && count($participantList) === 0) {
                $participantCount = 0;
            }

            $class->setAttribute('participant_count', $participantCount);
            $class->setAttribute('participant_list', $participantList);
            $class->setAttribute('participant_is_iht', $isIht);
        }
    }

    private function decodeParticipants(?SertifikatPesertaModel $detail): array
    {
        if (! $detail) {
            return [];
        }

        $names = json_decode($detail->nama, true) ?: [];
        $emails = json_decode($detail->email, true) ?: [];
        $phones = json_decode($detail->nohp, true) ?: [];
        $participants = [];

        foreach ($names as $index => $name) {
            $participants[] = [
                'nama' => $name,
                'email' => $emails[$index] ?? '',
                'nohp' => $phones[$index] ?? '',
            ];
        }

        return $participants;
    }
}
