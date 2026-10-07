<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LamaranModel;
use App\Models\LokerApply;
use App\Models\LokerModel;
use App\Models\PerusahaanModel;
use App\Models\UserProfileModel;
use App\Models\DataPayment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class MobileJobController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = $this->activeJobs();
        $search = trim((string) $request->query('q', ''));
        $isMember = $this->hasActiveMembership($request->user());

        if ($search !== '') {
            $query->where(function (Builder $query) use ($search) {
                $query->where('loker.title', 'like', "%{$search}%")
                    ->orWhere('loker.skill', 'like', "%{$search}%")
                    ->orWhere('perusahaan_models.nama', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('loker.type', 'like', '%'.(string) $request->query('type').'%');
        }

        if ($request->filled('skill')) {
            $query->where('loker.skill', 'like', '%'.(string) $request->query('skill').'%');
        }

        if ($request->filled('provinsi')) {
            $query->where(function (Builder $query) use ($request) {
                $query->where('loker.provinsi', $request->integer('provinsi'))
                    ->orWhere('perusahaan_models.provinsi', $request->integer('provinsi'));
            });
        }

        $limit = (int) config('app.loker_non_membership_limit', 10);
        $jobs = $isMember
            ? $query->paginate(9)
            : $query->limit(max(0, $limit))->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar lowongan berhasil diambil.',
            'data' => collect($jobs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $jobs->items() : $jobs)
                ->map(fn (LokerModel $job) => $this->jobData($job))
                ->values(),
            'meta' => $jobs instanceof \Illuminate\Pagination\LengthAwarePaginator ? [
                'current_page' => $jobs->currentPage(),
                'last_page' => $jobs->lastPage(),
                'per_page' => $jobs->perPage(),
                'total' => $jobs->total(),
            ] : [
                'limited' => true,
                'total' => $jobs->count(),
            ],
        ]);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $job = $this->activeJobs()->where('loker.id', $id)->first();
        if (! $job) {
            return $this->error('Lowongan tidak ditemukan.', Response::HTTP_NOT_FOUND);
        }

        if (! $this->hasActiveMembership($request->user())) {
            $visibleIds = $this->activeJobs()->limit((int) config('app.loker_non_membership_limit', 10))->pluck('loker.id');
            if (! $visibleIds->contains($id)) {
                return $this->error('Lowongan tidak tersedia untuk akun ini.', Response::HTTP_NOT_FOUND);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail lowongan berhasil diambil.',
            'data' => $this->jobData($job, true),
        ]);
    }

    public function applications(Request $request): JsonResponse
    {
        if (! $this->hasActiveIndividualMembership($request->user())) {
            return $this->error('Riwayat lamaran hanya tersedia untuk member perorangan aktif.', Response::HTTP_FORBIDDEN);
        }

        $applications = LokerApply::query()
            ->with('loker')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Riwayat lamaran berhasil diambil.',
            'data' => collect($applications->items())->map(fn (LokerApply $application) => [
                'id' => $application->id,
                'job_id' => $application->loker_id,
                'status' => (int) $application->status,
                'status_name' => $application->status_name,
                'created_at' => optional($application->created_at)->toISOString(),
                'job' => $application->loker ? $this->jobData($application->loker) : null,
            ])->values(),
            'meta' => [
                'current_page' => $applications->currentPage(),
                'last_page' => $applications->lastPage(),
                'per_page' => $applications->perPage(),
                'total' => $applications->total(),
            ],
        ]);
    }

    public function apply(Request $request, int $id): JsonResponse
    {
        if (! $this->hasActiveIndividualMembership($request->user())) {
            return $this->error('Lamaran hanya tersedia untuk member perorangan aktif.', Response::HTTP_FORBIDDEN);
        }

        $masterCv = LamaranModel::query()
            ->where('user_id', $request->user()->id)
            ->where('is_cv_ats', true)
            ->first();
        if (! $masterCv) {
            return $this->error('Buat CV ATS terlebih dahulu sebelum melamar.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $job = $this->activeJobs()->where('loker.id', $id)->first();
        if (! $job) {
            return $this->error('Lowongan tidak ditemukan atau sudah tidak aktif.', Response::HTTP_NOT_FOUND);
        }

        try {
            $application = DB::transaction(function () use ($request, $masterCv, $job) {
                $lastApply = LokerApply::query()
                    ->where('user_id', $request->user()->id)
                    ->where('loker_id', $job->id)
                    ->latest('created_at')
                    ->lockForUpdate()
                    ->first();

                if ($lastApply && $lastApply->created_at->diffInDays(now()) < 15) {
                    throw new \DomainException('Anda baru dapat melamar kembali setelah 15 hari dari lamaran sebelumnya.');
                }

                $applicationCv = $masterCv->replicate();
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

    public function companyProfile(Request $request): JsonResponse
    {
        $company = PerusahaanModel::where('user_id', $request->user()->id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Profil perusahaan berhasil diambil.',
            'data' => $company ? $this->companyData($company) : null,
        ]);
    }

    public function updateCompanyProfile(Request $request): JsonResponse
    {
        $company = PerusahaanModel::where('user_id', $request->user()->id)->first();
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'alamat' => ['required', 'string', 'max:2000'],
            'provinsi' => ['required', 'integer', 'exists:provinsi,id'],
            'kabupaten' => [
                'required',
                'integer',
                Rule::exists('kota', 'id')->where(fn ($query) => $query->where('provinsi_id', $request->input('provinsi'))),
            ],
            'kecamatan' => [
                'nullable',
                'integer',
                Rule::exists('kecamatan', 'id')->where(fn ($query) => $query->where('kota_id', $request->input('kabupaten'))),
            ],
            'kelurahan' => [
                'nullable',
                'integer',
                Rule::exists('kelurahan', 'id')->where(fn ($query) => $query->where('kecamatan_id', $request->input('kecamatan'))),
            ],
            'image' => [$company && filled($company->image) ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $oldImage = $company?->image;
        $newPath = null;
        try {
            $attributes = collect($validated)->except('image')->all();
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $directory = public_path('image/loker');
                File::ensureDirectoryExists($directory);
                $newPath = 'image/loker/company-'.Str::uuid().'.'.strtolower($file->extension());
                $file->move($directory, basename($newPath));
                $attributes['image'] = json_encode([
                    'url' => basename($newPath),
                    'size' => $file->getSize(),
                ]);
            }

            $company = PerusahaanModel::updateOrCreate(
                ['user_id' => $request->user()->id],
                $attributes
            );
        } catch (Throwable $exception) {
            if ($newPath && File::exists(public_path($newPath))) {
                File::delete(public_path($newPath));
            }
            report($exception);
            return $this->error('Profil perusahaan gagal disimpan.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($oldImage && $newPath) {
            $old = json_decode((string) $oldImage, true)['url'] ?? null;
            if ($old && File::exists(public_path('image/loker/'.basename($old)))) {
                File::delete(public_path('image/loker/'.basename($old)));
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Profil perusahaan berhasil disimpan.',
            'data' => $this->companyData($company),
        ]);
    }

    public function companyJobs(Request $request): JsonResponse
    {
        $company = $this->completeCompany($request->user()->id);
        if ($company instanceof JsonResponse) {
            return $company;
        }

        $jobs = LokerModel::query()
            ->where('user_id', $request->user()->id)
            ->where('perusahaan_id', $company->id)
            ->latest('id')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Daftar lowongan perusahaan berhasil diambil.',
            'data' => collect($jobs->items())->map(fn (LokerModel $job) => $this->jobData($job, true))->values(),
            'meta' => [
                'current_page' => $jobs->currentPage(),
                'last_page' => $jobs->lastPage(),
                'per_page' => $jobs->perPage(),
                'total' => $jobs->total(),
            ],
        ]);
    }

    public function storeCompanyJob(Request $request): JsonResponse
    {
        $company = $this->completeCompany($request->user()->id);
        if ($company instanceof JsonResponse) {
            return $company;
        }

        $validated = $this->validateJob($request);
        $job = LokerModel::create($this->jobAttributes($validated, $request->user()->id, $company->id));

        return response()->json([
            'success' => true,
            'message' => 'Lowongan berhasil dibuat dan menunggu approval.',
            'data' => $this->jobData($job, true),
        ], Response::HTTP_CREATED);
    }

    public function updateCompanyJob(Request $request, int $id): JsonResponse
    {
        $company = $this->completeCompany($request->user()->id);
        if ($company instanceof JsonResponse) {
            return $company;
        }

        $job = LokerModel::query()
            ->where('id', $id)
            ->where('user_id', $request->user()->id)
            ->where('perusahaan_id', $company->id)
            ->first();
        if (! $job) {
            return $this->error('Lowongan tidak ditemukan.', Response::HTTP_NOT_FOUND);
        }

        $job->update($this->jobAttributes($this->validateJob($request), $request->user()->id, $company->id));

        return response()->json([
            'success' => true,
            'message' => 'Lowongan berhasil diperbarui dan menunggu approval ulang.',
            'data' => $this->jobData($job->refresh(), true),
        ]);
    }

    public function deleteCompanyJob(Request $request, int $id): JsonResponse
    {
        $company = $this->completeCompany($request->user()->id);
        if ($company instanceof JsonResponse) {
            return $company;
        }

        $job = LokerModel::query()
            ->where('id', $id)
            ->where('user_id', $request->user()->id)
            ->where('perusahaan_id', $company->id)
            ->first();
        if (! $job) {
            return $this->error('Lowongan tidak ditemukan.', Response::HTTP_NOT_FOUND);
        }
        if ((int) $job->status !== 0) {
            return $this->error('Lowongan yang sudah disetujui tidak dapat dihapus.', Response::HTTP_CONFLICT);
        }

        $job->delete();
        return response()->json(['success' => true, 'message' => 'Lowongan berhasil dihapus.']);
    }

    private function activeJobs(): Builder
    {
        return LokerModel::query()
            ->leftJoin('perusahaan_models', 'perusahaan_models.id', '=', 'loker.perusahaan_id')
            ->select('loker.*')
            ->where('loker.status', 1)
            ->where(function (Builder $query) {
                $query->whereNull('loker.tanggal_awal')->orWhereDate('loker.tanggal_awal', '<=', now());
            })
            ->where(function (Builder $query) {
                $query->whereNull('loker.tanggal_akhir')->orWhereDate('loker.tanggal_akhir', '>=', now());
            })
            ->orderByDesc('loker.created_at');

    }

    private function hasActiveMembership($user): bool
    {
        $profile = UserProfileModel::where('user_id', $user->id)->first();
        return $profile && (int) $profile->status_membership === DataPayment::STATUS_PAID
            && (! $profile->masa_aktif_membership || now()->parse($profile->masa_aktif_membership)->endOfDay()->isFuture());
    }

    private function hasActiveIndividualMembership($user): bool
    {
        $profile = UserProfileModel::where('user_id', $user->id)->first();
        return $this->hasActiveMembership($user) && $profile && (int) $profile->tipe_membership === DataPayment::MEMBERSHIP_TYPE_INDIVIDUAL;
    }

    private function jobData(LokerModel $job, bool $includeDescription = false): array
    {
        $company = $job->perusahaan;
        $data = [
            'id' => $job->id,
            'title' => $job->title,
            'type' => $this->decodeList($job->type),
            'skill' => $this->decodeList($job->skill),
            'salary_min' => $job->gaji_min,
            'salary_max' => $job->gaji_max,
            'start_date' => $job->tanggal_awal,
            'end_date' => $job->tanggal_akhir,
            'status' => (int) $job->status,
            'image_url' => $this->assetUrl($job->image),
            'location' => [
                'address' => $job->alamat,
                'province_id' => $job->provinsi,
                'city_id' => $job->kabupaten,
                'district_id' => $job->kecamatan,
                'village_id' => $job->kelurahan,
            ],
            'company' => $company ? $this->companyData($company) : null,
        ];
        if ($includeDescription) {
            $data['description'] = $job->deskripsi;
            $data['jobdesk'] = $job->jobdesk;
        }
        return $data;
    }

    private function companyData(PerusahaanModel $company): array
    {
        $image = json_decode((string) $company->image, true);
        $imageUrl = is_array($image) ? ($image['url'] ?? null) : null;
        return [
            'id' => $company->id,
            'name' => $company->nama,
            'email' => $company->email,
            'address' => $company->alamat,
            'province_id' => $company->provinsi,
            'city_id' => $company->kabupaten,
            'district_id' => $company->kecamatan,
            'village_id' => $company->kelurahan,
            'image_url' => $imageUrl ? asset('image/loker/'.basename($imageUrl)) : null,
            'complete' => $company->isComplete(),
        ];
    }

    private function validateJob(Request $request): array
    {
        $payload = $request->all();
        $salaryDigits = preg_replace('/[^0-9]/', '', (string) ($request->input('gaji_min') ?? ''));
        $payload['gaji_min'] = $salaryDigits === '' ? null : (int) $salaryDigits;
        $payload['jobdesk'] = trim(strip_tags((string) $request->input('jobdesk'), '<p><br><strong><em><u><ul><ol><li><blockquote>'));
        return validator($payload, [
            'title' => ['required', 'string', 'max:255'],
            'gaji_min' => ['required', 'numeric', 'min:0'],
            'deskripsi' => ['required', 'string', 'max:10000'],
            'jobdesk' => ['required', 'string', 'max:10000'],
            'tanggal_awal' => ['required', 'date'],
            'tanggal_akhir' => ['required', 'date', 'after_or_equal:tanggal_awal'],
            'skill' => ['required', 'array', 'min:1'],
            'skill.*' => ['required', 'string', 'max:100', 'distinct'],
            'type' => ['required', 'array', 'min:1'],
            'type.*' => ['required', 'string', 'max:100', 'distinct'],
        ])->validate();
    }

    private function jobAttributes(array $data, int $userId, int $companyId): array
    {
        return [
            'user_id' => $userId,
            'title' => $data['title'],
            'gaji_min' => $data['gaji_min'],
            'gaji_max' => 0,
            'deskripsi' => $data['deskripsi'],
            'jobdesk' => $data['jobdesk'],
            'tanggal_awal' => $data['tanggal_awal'],
            'tanggal_akhir' => $data['tanggal_akhir'],
            'skill' => json_encode(array_values($data['skill'])),
            'type' => json_encode(array_values($data['type'])),
            'perusahaan_id' => $companyId,
            'status' => 0,
        ];
    }

    private function completeCompany(int $userId): PerusahaanModel|JsonResponse
    {
        $company = PerusahaanModel::where('user_id', $userId)->first();
        return $company && $company->isComplete()
            ? $company
            : $this->error('Lengkapi profil perusahaan terlebih dahulu.', Response::HTTP_CONFLICT);
    }

    private function decodeList($value): array
    {
        $decoded = json_decode((string) $value, true);
        return is_array($decoded) ? array_values($decoded) : (filled($value) ? [(string) $value] : []);
    }

    private function assetUrl(?string $path): ?string
    {
        if (! $path) return null;
        return Str::startsWith($path, ['http://', 'https://', 'data:']) ? $path : asset(ltrim($path, '/'));
    }

    private function error(string $message, int $status): JsonResponse
    {
        return response()->json(['success' => false, 'message' => $message], $status);
    }
}
