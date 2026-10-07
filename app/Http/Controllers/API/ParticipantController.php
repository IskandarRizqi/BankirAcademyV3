<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LamaranModel;
use App\Models\LokerApply;
use App\Models\LokerModel;
use App\Models\MateriModel;
use App\Models\RiwayatTransaksi;
use App\Models\SiswaModulAktif;
use App\Models\SubMateriModel;
use App\Models\UserSubMateriItemProgress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ParticipantController extends Controller
{
    public function profile(Request $request): JsonResponse
    {
        $user = $request->user()->load('siswa');
        $student = $user->siswa;

        return response()->json([
            'success' => true,
            'message' => 'Profil peserta berhasil diambil.',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role_name' => 'Siswa',
                    'is_active' => (bool) $user->is_active,
                ],
                'student' => [
                    'id' => $student?->id,
                    'phone' => $student?->no_telp,
                    'gender' => $student?->jenis_kelamin,
                    'nisn' => $student?->nisn,
                    'class' => $student?->kelas,
                    'entry_year' => $student?->angkatan,
                    'balance' => (int) ($student?->saldo ?? 0),
                    'scholarship' => (int) ($student?->beasiswa ?? 0) === 1,
                    'address' => $student?->alamat,
                ],
            ],
        ]);
    }

    public function dashboard(Request $request): JsonResponse
    {
        $user = $request->user()->load('siswa', 'bank.membership');
        $history = $this->learningHistory($user->id);
        $activeModules = SiswaModulAktif::with('materi')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Dashboard peserta berhasil diambil.',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'class' => $user->siswa?->kelas,
                    'balance' => (int) ($user->siswa?->saldo ?? 0),
                    'scholarship' => (int) ($user->siswa?->beasiswa ?? 0) === 1,
                ],
                'stats' => [
                    'total_materials' => $history->unique('name')->count(),
                    'total_chapters' => $history->count(),
                    'active_modules' => $activeModules->count(),
                    'completed_items' => UserSubMateriItemProgress::where('user_id', $user->id)
                        ->where('is_completed', true)
                        ->count(),
                ],
                'active_modules' => $activeModules->map(fn (SiswaModulAktif $module) => [
                    'id' => $module->id,
                    'material_id' => $module->class_id,
                    'name' => $module->materi?->nama,
                    'created_at' => optional($module->created_at)->toISOString(),
                ])->values(),
                'recent_learning' => $history->take(5)->values(),
            ],
        ]);
    }

    public function generalTraining(Request $request): JsonResponse
    {
        $user = $request->user()->load('siswa', 'bank.membership');
        $activeMembership = $this->hasActiveBankMembership($user);
        $materials = $activeMembership
            ? $this->generalSubMaterials($user)
            : collect();

        return response()->json([
            'success' => true,
            'message' => 'Pelatihan umum berhasil diambil.',
            'data' => [
                'active_membership' => $activeMembership,
                'materials' => $materials->map(fn (SubMateriModel $material) => $this->generalMaterialData($material, $user->id))->values(),
            ],
        ]);
    }

    public function generalTrainingDetail(Request $request, int $subMateriId): JsonResponse
    {
        $user = $request->user()->load('siswa', 'bank.membership');
        if (! $this->hasActiveBankMembership($user)) {
            return $this->error('Masa aktif akun tidak mengizinkan akses pelatihan umum.', Response::HTTP_FORBIDDEN);
        }

        $material = $this->generalSubMaterials($user)->firstWhere('id', $subMateriId);
        if (! $material) {
            return $this->error('Materi umum tidak ditemukan.', Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail pelatihan umum berhasil diambil.',
            'data' => $this->generalMaterialData($material, $user->id, true),
        ]);
    }

    public function enrollGeneralTraining(Request $request, int $subMateriId): JsonResponse
    {
        $user = $request->user()->load('siswa', 'bank.membership');
        if (! $this->hasActiveBankMembership($user)) {
            return $this->error('Masa aktif akun tidak mengizinkan akses pelatihan umum.', Response::HTTP_FORBIDDEN);
        }

        $material = $this->generalSubMaterials($user)->firstWhere('id', $subMateriId);
        if (! $material) {
            return $this->error('Materi umum tidak ditemukan.', Response::HTTP_NOT_FOUND);
        }

        $price = (int) ($material->harga_final ?? $material->harga ?? 0);
        if ($price > 0) {
            return response()->json([
                'success' => false,
                'code' => 'payment_required',
                'message' => 'Materi ini memerlukan pembayaran sebelum dapat diikuti.',
                'data' => ['price' => $price],
            ], Response::HTTP_PAYMENT_REQUIRED);
        }

        DB::table('history_pelatihan')->updateOrInsert(
            ['user_id' => $user->id, 'sub_materi_id' => $material->id],
            ['created_at' => now(), 'updated_at' => now()]
        );

        return response()->json([
            'success' => true,
            'message' => 'Pelatihan umum berhasil diikuti.',
            'data' => $this->generalMaterialData($material, $user->id, true),
        ], Response::HTTP_CREATED);
    }

    public function history(Request $request): JsonResponse
    {
        $user = $request->user()->load('siswa');
        $history = $this->learningHistory($user->id);
        $transactions = RiwayatTransaksi::with('materi')
            ->where('user_id', $user->id)
            ->latest()
            ->get();
        $activeModules = SiswaModulAktif::with('materi')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'History pelatihan berhasil diambil.',
            'data' => [
                'stats' => [
                    'total_materials' => $history->unique('name')->count(),
                    'total_chapters' => $history->count(),
                    'balance' => (int) ($user->siswa?->saldo ?? 0),
                    'scholarship' => (int) ($user->siswa?->beasiswa ?? 0) === 1,
                ],
                'learning' => $history,
                'transactions' => $transactions->map(fn (RiwayatTransaksi $transaction) => [
                    'id' => $transaction->id,
                    'material' => $transaction->materi?->nama,
                    'amount' => (int) $transaction->nominal_transaksi,
                    'method' => $transaction->metode_pembayaran,
                    'status' => $transaction->status,
                    'created_at' => optional($transaction->created_at)->toISOString(),
                ])->values(),
                'active_modules' => $activeModules->map(fn (SiswaModulAktif $module) => [
                    'id' => $module->id,
                    'material_id' => $module->class_id,
                    'name' => $module->materi?->nama,
                    'created_at' => optional($module->created_at)->toISOString(),
                ])->values(),
            ],
        ]);
    }

    public function jobs(): JsonResponse
    {
        $jobs = $this->activeJobs()->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar lowongan berhasil diambil.',
            'data' => $jobs->map(fn (LokerModel $job) => $this->jobData($job))->values(),
        ]);
    }

    public function job(Request $request, int $id): JsonResponse
    {
        $job = $this->activeJobs()->where('loker.id', $id)->first();
        if (! $job) {
            return $this->error('Lowongan tidak ditemukan.', Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail lowongan berhasil diambil.',
            'data' => $this->jobData($job, true),
        ]);
    }

    public function applyJob(Request $request, int $id): JsonResponse
    {
        $job = $this->activeJobs()->where('loker.id', $id)->first();
        if (! $job) {
            return $this->error('Lowongan tidak ditemukan atau sudah tidak aktif.', Response::HTTP_NOT_FOUND);
        }

        $cv = LamaranModel::query()
            ->where('user_id', $request->user()->id)
            ->where('is_cv_ats', true)
            ->first();
        if (! $cv) {
            return $this->error('Buat CV ATS terlebih dahulu sebelum melamar.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $application = DB::transaction(function () use ($request, $cv, $job) {
                $lastApply = LokerApply::query()
                    ->where('user_id', $request->user()->id)
                    ->where('loker_id', $job->id)
                    ->latest('created_at')
                    ->lockForUpdate()
                    ->first();

                if ($lastApply && $lastApply->created_at->diffInDays(now()) < 15) {
                    throw new \DomainException('Anda baru dapat melamar kembali setelah 15 hari dari lamaran sebelumnya.');
                }

                $applicationCv = $cv->replicate();
                $applicationCv->job_id = $job->id;
                $applicationCv->is_cv_ats = null;
                $applicationCv->save();

                return LokerApply::create([
                    'loker_id' => $job->id,
                    'user_id' => $request->user()->id,
                    'status' => 0,
                ]);
            });
        } catch (\DomainException $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_CONFLICT);
        } catch (Throwable $exception) {
            report($exception);

            return $this->error('Lamaran gagal dikirim. Silakan coba lagi.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([
            'success' => true,
            'message' => 'Lamaran berhasil dikirim.',
            'data' => [
                'id' => $application->id,
                'job_id' => $application->loker_id,
                'status' => (int) $application->status,
                'status_name' => $application->status_name,
            ],
        ], Response::HTTP_CREATED);
    }

    private function generalSubMaterials($user): Collection
    {
        $materi = MateriModel::where('nama', 'Umum')->first();
        if (! $materi) {
            return new Collection;
        }

        $allowedTypes = (int) ($user->siswa?->beasiswa ?? 0) === 1 ? [0, 1] : [0, 2];

        return SubMateriModel::query()
            ->where('id_materi', $materi->id)
            ->whereIn('tipe_beasiswa', $allowedTypes)
            ->with(['items' => fn ($query) => $query->whereIn('tipe_link_item', [0, 1])])
            ->orderBy('urutan')
            ->get();
    }

    private function generalMaterialData(SubMateriModel $material, int $userId, bool $includeItems = false): array
    {
        return [
            'id' => $material->id,
            'name' => $material->nama,
            'description' => $material->keterangan,
            'thumbnail' => $material->thumbnail,
            'order' => $material->urutan,
            'price' => (int) ($material->harga_final ?? $material->harga ?? 0),
            'enrolled' => DB::table('history_pelatihan')
                ->where('user_id', $userId)
                ->where('sub_materi_id', $material->id)
                ->exists(),
            'media_count' => $material->items->count(),
            'video_count' => $material->items->where('tipe_link_item', 0)->count(),
            'ebook_count' => $material->items->where('tipe_link_item', 1)->count(),
            'items' => $includeItems ? $material->items->map(fn ($item) => [
                'id' => $item->id,
                'title' => $item->judul_item,
                'url' => $item->link_item,
                'type' => (int) $item->tipe_link_item === 1 ? 'ebook' : 'video',
            ])->values() : [],
        ];
    }

    private function learningHistory(int $userId): Collection
    {
        return collect(DB::table('history_pelatihan')
            ->join('sub_materi', 'history_pelatihan.sub_materi_id', '=', 'sub_materi.id')
            ->where('history_pelatihan.user_id', $userId)
            ->select(
                'history_pelatihan.created_at',
                'sub_materi.id as sub_material_id',
                'sub_materi.nama as name',
                'sub_materi.urutan as order'
            )
            ->latest('history_pelatihan.created_at')
            ->get()
            ->map(fn ($item) => [
                'sub_material_id' => $item->sub_material_id,
                'name' => $item->name,
                'order' => $item->order,
                'started_at' => $item->created_at,
            ])
            ->values()
            ->all());
    }

    private function activeJobs()
    {
        return LokerModel::query()
            ->with('perusahaan')
            ->where('status', 1)
            ->where(fn ($query) => $query->whereNull('tanggal_awal')->orWhereDate('tanggal_awal', '<=', now()))
            ->where(fn ($query) => $query->whereNull('tanggal_akhir')->orWhereDate('tanggal_akhir', '>=', now()))
            ->latest('created_at');
    }

    private function jobData(LokerModel $job, bool $includeDescription = false): array
    {
        $data = [
            'id' => $job->id,
            'title' => $job->title,
            'company_name' => $job->nama ?? $job->perusahaan?->nama ?? 'Perusahaan',
            'type' => $this->decodeList($job->type),
            'skill' => $this->decodeList($job->skill),
            'salary_min' => (int) $job->gaji_min,
            'salary_max' => (int) $job->gaji_max,
            'start_date' => $job->tanggal_awal,
            'end_date' => $job->tanggal_akhir,
            'location' => $job->kabupaten_name ?: $job->perusahaan?->kabupaten_name,
            'image_url' => $this->assetUrl($job->image),
        ];

        if ($includeDescription) {
            $data['description'] = $job->deskripsi;
            $data['jobdesk'] = $job->jobdesk;
            $data['address'] = $job->alamat;
            $data['company'] = $job->perusahaan ? [
                'name' => $job->perusahaan->nama,
                'email' => $job->perusahaan->email,
                'address' => $job->perusahaan->alamat,
            ] : null;
        }

        return $data;
    }

    private function decodeList($value): array
    {
        if (is_array($value)) {
            return array_values($value);
        }

        $decoded = json_decode((string) $value, true);

        return is_array($decoded) ? array_values($decoded) : array_filter(array_map('trim', explode(',', (string) $value)));
    }

    private function assetUrl($value): ?string
    {
        if (! $value) {
            return null;
        }

        if (is_array($value)) {
            $value = $value['url'] ?? $value[0] ?? null;
        }

        if (! is_string($value) || trim($value) === '') {
            return null;
        }

        return filter_var($value, FILTER_VALIDATE_URL) ? $value : asset('storage/'.ltrim($value, '/'));
    }

    private function hasActiveBankMembership($user): bool
    {
        return $user->bank
            && $user->bank->masa_aktif_member
            && now()->parse($user->bank->masa_aktif_member)->isFuture()
            && $user->bank->membership;
    }

    private function error(string $message, int $status): JsonResponse
    {
        return response()->json(['success' => false, 'message' => $message], $status);
    }
}
