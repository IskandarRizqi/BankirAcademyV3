<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\MembershipProfileRequest;
use App\Models\LamaranModel;
use App\Models\UserProfileModel;
use App\Services\CvAtsPdfService;
use App\Services\FonnteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class MobileProfileController extends Controller
{
    private const OTP_TTL_MINUTES = 10;

    private const RELIGIONS = [
        'islam', 'katholik', 'protestan', 'hindu', 'budha', 'tuhan yang maha esa',
    ];

    private const MARITAL_STATUSES = ['Belum Menikah', 'Menikah', 'Duda/Janda'];

    public function __construct(private FonnteService $fonnteService) {}

    public function membership(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Profil membership berhasil diambil.',
            'data' => $this->profileData(UserProfileModel::where('user_id', $request->user()->id)->first()),
        ]);
    }

    public function locations(Request $request, string $level): JsonResponse
    {
        [$table, $parentColumn] = match ($level) {
            'provinces' => ['provinsi', null],
            'cities' => ['kota', 'provinsi_id'],
            'districts' => ['kecamatan', 'kota_id'],
            'villages' => ['kelurahan', 'kecamatan_id'],
            default => [null, null],
        };

        abort_unless($table !== null, 404);
        $query = DB::table($table)->select(['id', 'name'])->orderBy('name');
        if ($parentColumn !== null) {
            $parentId = $request->integer('parent_id');
            abort_if($parentId < 1, 422, 'Parent lokasi wajib dipilih.');
            $query->where($parentColumn, $parentId);
        }

        return response()->json([
            'success' => true,
            'data' => $query->limit(500)->get(),
        ]);
    }

    public function updateMembership(MembershipProfileRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $membershipType = $validated['membership_tipe'] ?? null;
        unset($validated['membership_tipe']);

        $validated['description'] = $validated['alamat'];
        $existing = UserProfileModel::where('user_id', $request->user()->id)->first();
        $validated['phone'] = UserProfileModel::normalizePhone($validated['phone']);
        $phoneChanged = UserProfileModel::normalizePhone($existing?->phone) !== $validated['phone'];

        if ($phoneChanged) {
            $validated['status_nomor'] = false;
            $validated['otp'] = null;
            $validated['otp_expires_at'] = null;
        }

        $profile = UserProfileModel::updateOrCreate(
            ['user_id' => $request->user()->id],
            $validated + ['user_id' => $request->user()->id]
        );

        if ($phoneChanged || ! $profile->isPhoneVerified()) {
            return $this->sendOtpResponse($profile, $membershipType);
        }

        return response()->json([
            'success' => true,
            'message' => 'Profil membership berhasil diperbarui.',
            'data' => $this->profileData($profile) + [
                'membership_type_requested' => $membershipType,
                'verification_required' => false,
            ],
        ]);
    }

    public function sendOtp(Request $request): JsonResponse
    {
        $profile = UserProfileModel::where('user_id', $request->user()->id)->first();
        if (! $profile || ! filled($profile->phone)) {
            return response()->json([
                'success' => false,
                'message' => 'Simpan nomor handphone terlebih dahulu.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->sendOtpResponse($profile);
    }

    public function verifyOtp(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);
        $profile = UserProfileModel::where('user_id', $request->user()->id)->first();

        if (! $profile || ! filled($profile->otp) || ! $profile->otp_expires_at
            || $profile->otp_expires_at->isPast() || ! Hash::check($validated['otp'], $profile->otp)) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP tidak valid atau sudah kedaluwarsa.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $profile->forceFill([
            'status_nomor' => true,
            'otp' => null,
            'otp_expires_at' => null,
        ])->save();

        return response()->json([
            'success' => true,
            'message' => 'Nomor handphone berhasil diverifikasi.',
            'data' => $this->profileData($profile),
        ]);
    }

    public function cv(Request $request): JsonResponse
    {
        $cv = $this->findCv($request->user()->id);

        return response()->json([
            'success' => true,
            'message' => 'CV ATS berhasil diambil.',
            'data' => $cv ? $this->cvData($cv) : null,
        ]);
    }

    public function storeCv(Request $request): JsonResponse
    {
        if ($this->findCv($request->user()->id)) {
            return response()->json([
                'success' => false,
                'message' => 'CV ATS sudah tersedia. Gunakan endpoint update.',
            ], Response::HTTP_CONFLICT);
        }

        $validated = $this->validateCv($request);
        $cv = DB::transaction(fn () => LamaranModel::create($this->cvPayload($validated) + [
            'user_id' => $request->user()->id,
            'is_cv_ats' => true,
            'status' => 0,
            'namaorangtua' => '',
            'jmlsaudara' => '',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'CV ATS berhasil disimpan.',
            'data' => $this->cvData($cv),
        ], Response::HTTP_CREATED);
    }

    public function updateCv(Request $request): JsonResponse
    {
        $cv = $this->findCv($request->user()->id);
        if (! $cv) {
            return response()->json([
                'success' => false,
                'message' => 'CV ATS belum tersedia.',
            ], Response::HTTP_NOT_FOUND);
        }

        $validated = $this->validateCv($request);
        $cv->update($this->cvPayload($validated));

        return response()->json([
            'success' => true,
            'message' => 'CV ATS berhasil diperbarui.',
            'data' => $this->cvData($cv->refresh()),
        ]);
    }

    public function deleteCv(Request $request): JsonResponse
    {
        $cv = $this->findCv($request->user()->id);
        if (! $cv) {
            return response()->json([
                'success' => false,
                'message' => 'CV ATS belum tersedia.',
            ], Response::HTTP_NOT_FOUND);
        }

        $cv->delete();

        return response()->json([
            'success' => true,
            'message' => 'CV ATS berhasil dihapus.',
        ]);
    }

    public function cvPdf(Request $request, CvAtsPdfService $pdfService)
    {
        $cv = $this->findCv($request->user()->id);
        if (! $cv) {
            return response()->json([
                'success' => false,
                'message' => 'CV ATS belum tersedia.',
            ], Response::HTTP_NOT_FOUND);
        }

        return $pdfService->make($cv, $request->user())->stream($pdfService->filename($cv));
    }

    private function sendOtpResponse(UserProfileModel $profile, ?int $membershipType = null): JsonResponse
    {
        $otp = (string) random_int(100000, 999999);

        try {
            $response = $this->fonnteService->sendMessage(
                UserProfileModel::normalizePhone($profile->phone),
                "Kode verifikasi nomor handphone Bankir Academy:\n{$otp}\n\nKode berlaku selama ".self::OTP_TTL_MINUTES.' menit. Jangan berikan kode ini kepada siapa pun.'
            );

            if (! $response->successful() || ! in_array($response->json('status'), [true, 1, 'true', '1'], true)) {
                throw new \RuntimeException('Fonnte menolak pengiriman OTP.');
            }

            $profile->forceFill([
                'otp' => Hash::make($otp),
                'status_nomor' => false,
                'otp_expires_at' => now()->addMinutes(self::OTP_TTL_MINUTES),
            ])->save();
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'OTP gagal dikirim. Periksa nomor handphone dan coba lagi.',
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }

        return response()->json([
            'success' => true,
            'message' => 'OTP telah dikirim ke WhatsApp Anda.',
            'data' => [
                'verification_required' => true,
                'membership_type_requested' => $membershipType,
                'expires_in_seconds' => self::OTP_TTL_MINUTES * 60,
            ],
        ], Response::HTTP_ACCEPTED);
    }

    private function profileData(?UserProfileModel $profile): ?array
    {
        if (! $profile) {
            return null;
        }

        return [
            'id' => $profile->id,
            'user_id' => $profile->user_id,
            'name' => $profile->name,
            'phone' => $profile->phone,
            'phone_verified' => $profile->isPhoneVerified(),
            'address' => $profile->alamat,
            'province_id' => $profile->provinsi_id,
            'city_id' => $profile->kota_id,
            'district_id' => $profile->kecamatan_id,
            'village_id' => $profile->kelurahan_id,
            'picture' => $profile->picture,
            'birth_date' => $profile->tanggal_lahir,
            'gender' => $profile->gender,
            'description' => $profile->description,
            'membership_type' => $profile->tipe_membership,
            'membership_status' => $profile->status_membership,
            'membership_expires_at' => $profile->masa_aktif_membership,
        ];
    }

    private function findCv(int $userId): ?LamaranModel
    {
        return LamaranModel::query()
            ->where('user_id', $userId)
            ->where('is_cv_ats', true)
            ->first();
    }

    private function validateCv(Request $request): array
    {
        return $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nama_panggilan' => ['required', 'string', 'max:100'],
            'tempat_lahir' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date'],
            'agama' => ['required', 'in:'.implode(',', self::RELIGIONS)],
            'telpdomisili' => ['required', 'string', 'max:30', 'regex:/^[0-9]+$/'],
            'statusperkawinan' => ['required', 'in:'.implode(',', self::MARITAL_STATUSES)],
            'kodepos' => ['required', 'digits:5'],
            'alamatdomisili' => ['required', 'string', 'max:1000'],
            'pengalamanspesifik' => ['required', 'string', 'max:2000'],
            'perguruannama' => ['nullable', 'string', 'max:255', 'required_with:perguruanfakultas,perguruangelar,perguruantahun'],
            'perguruanfakultas' => ['nullable', 'string', 'max:255', 'required_with:perguruannama'],
            'perguruangelar' => ['nullable', 'string', 'max:100', 'required_with:perguruannama'],
            'perguruantahun' => ['nullable', 'string', 'max:30', 'required_with:perguruannama'],
            'smanama' => ['nullable', 'string', 'max:255', 'required_with:smafakultas,smatahun'],
            'smafakultas' => ['nullable', 'string', 'max:255', 'required_with:smanama'],
            'smatahun' => ['nullable', 'string', 'max:30', 'required_with:smanama'],
            'experiences' => ['nullable', 'array', 'max:20'],
            'experiences.*.company' => ['required', 'string', 'max:255'],
            'experiences.*.position' => ['required', 'string', 'max:255'],
            'experiences.*.period' => ['required', 'string', 'max:100'],
            'experiences.*.responsibility' => ['required', 'string', 'max:5000'],
            'trainings' => ['nullable', 'array', 'max:20'],
            'trainings.*.name' => ['required', 'string', 'max:255'],
            'trainings.*.organizer' => ['required', 'string', 'max:255'],
            'trainings.*.year' => ['required', 'string', 'max:30'],
        ]);
    }

    private function cvPayload(array $data): array
    {
        $date = Carbon::parse($data['tanggal_lahir']);
        $months = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
        $experiences = $data['experiences'] ?? [];
        $trainings = $data['trainings'] ?? [];

        return [
            'nama_lengkap' => trim($data['nama_lengkap']),
            'nama_panggilan' => trim($data['nama_panggilan']),
            'tempat_lahir' => trim($data['tempat_lahir']),
            'tanggal_lahir' => $data['tanggal_lahir'],
            'tmpttgllahir' => trim($data['tempat_lahir']).', '.$date->day.' '.strtolower($months[$date->month]).' '.$date->year,
            'agama' => $data['agama'],
            'telpdomisili' => trim($data['telpdomisili']),
            'statusperkawinan' => $data['statusperkawinan'],
            'kodepos' => trim($data['kodepos']),
            'alamatdomisili' => trim($data['alamatdomisili']),
            'pengalamanspesifik' => trim($data['pengalamanspesifik']),
            'perguruannama' => $this->nullableTrim($data['perguruannama'] ?? null),
            'perguruanfakultas' => $this->nullableTrim($data['perguruanfakultas'] ?? null),
            'perguruangelar' => $this->nullableTrim($data['perguruangelar'] ?? null),
            'perguruantahun' => $this->nullableTrim($data['perguruantahun'] ?? null),
            'smanama' => $this->nullableTrim($data['smanama'] ?? null),
            'smafakultas' => $this->nullableTrim($data['smafakultas'] ?? null),
            'smatahun' => $this->nullableTrim($data['smatahun'] ?? null),
            'pekerjaanperusahaan' => $this->encodeRows($experiences, 'company'),
            'pekerjaanjabatan' => $this->encodeRows($experiences, 'position'),
            'pekerjaantahun' => $this->encodeRows($experiences, 'period'),
            'pekerjaantanggungjawab' => $this->encodeRows($experiences, 'responsibility'),
            'pelatihannama' => $this->encodeRows($trainings, 'name'),
            'pelatihanpenyelanggara' => $this->encodeRows($trainings, 'organizer'),
            'pelatihantahun' => $this->encodeRows($trainings, 'year'),
        ];
    }

    private function cvData(LamaranModel $cv): array
    {
        return [
            'id' => $cv->id,
            'nama_lengkap' => $cv->nama_lengkap,
            'nama_panggilan' => $cv->nama_panggilan,
            'tempat_lahir' => $cv->tempat_lahir,
            'tanggal_lahir' => $cv->tanggal_lahir,
            'agama' => $cv->agama,
            'telpdomisili' => $cv->telpdomisili,
            'statusperkawinan' => $cv->statusperkawinan,
            'kodepos' => $cv->kodepos,
            'alamatdomisili' => $cv->alamatdomisili,
            'pengalamanspesifik' => $cv->pengalamanspesifik,
            'education' => [
                'university' => Arr::only($cv->toArray(), ['perguruannama', 'perguruanfakultas', 'perguruangelar', 'perguruantahun']),
                'school' => Arr::only($cv->toArray(), ['smanama', 'smafakultas', 'smatahun']),
            ],
            'experiences' => $this->decodeRows($cv->pekerjaanperusahaan, $cv->pekerjaanjabatan, $cv->pekerjaantahun, $cv->pekerjaantanggungjawab),
            'trainings' => $this->decodeRows($cv->pelatihannama, $cv->pelatihanpenyelanggara, $cv->pelatihantahun),
        ];
    }

    private function encodeRows(array $rows, string $key): string
    {
        return json_encode(array_map(fn ($row) => trim((string) ($row[$key] ?? '')), $rows), JSON_UNESCAPED_UNICODE);
    }

    private function decodeRows(...$columns): array
    {
        $decoded = array_map(function ($value) {
            $value = json_decode((string) $value, true);

            return is_array($value) ? array_values($value) : [];
        }, $columns);
        $count = max(array_map('count', $decoded));
        $keys = count($columns) === 4
            ? ['company', 'position', 'period', 'responsibility']
            : ['name', 'organizer', 'year'];

        return array_map(function ($index) use ($decoded, $keys) {
            $row = [];
            foreach ($keys as $keyIndex => $key) {
                $row[$key] = $decoded[$keyIndex][$index] ?? '';
            }

            return $row;
        }, $count ? range(0, $count - 1) : []);
    }

    private function nullableTrim($value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }
}
