<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CertificateTemplate;
use App\Models\MateriModel;
use App\Models\PrepotesUserModel;
use App\Models\PreposttestModel;
use App\Models\SiswaModulAktif;
use App\Models\SubMateriModel;
use App\Models\UserCertificate;
use App\Models\UserSubMateriItemProgress;
use App\Models\UserSubMateriProgress;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class LearningController extends Controller
{
    public function catalog(Request $request): JsonResponse
    {
        $user = $request->user()->load('siswa', 'bank.membership');

        if (! $this->hasActiveBankMembership($user)) {
            return response()->json([
                'success' => true,
                'message' => 'Belum ada materi yang dapat diakses.',
                'data' => [
                    'active_membership' => false,
                    'materials' => [],
                ],
            ]);
        }

        $allowedTypes = $this->allowedScholarshipTypes($user);
        $materials = MateriModel::query()
            ->with([
                'kategori',
                'subMateri' => function ($query) use ($allowedTypes) {
                    $query->whereIn('tipe_beasiswa', $allowedTypes)
                        ->with('items')
                        ->orderBy('urutan');
                },
            ])
            ->where('nama', '!=', 'Umum')
            ->orderBy('urutan')
            ->get()
            ->filter(fn (MateriModel $material) => $material->subMateri->isNotEmpty())
            ->values();

        return response()->json([
            'success' => true,
            'message' => 'Daftar materi berhasil diambil.',
            'data' => [
                'active_membership' => true,
                'materials' => $materials->map(fn (MateriModel $material) =>
                    $this->materialData($material, $user, false))->values(),
            ],
        ]);
    }

    public function material(Request $request, int $materiId): JsonResponse
    {
        $user = $request->user()->load('siswa', 'bank.membership');
        $material = $this->findMaterialForUser($materiId, $user);

        if (! $material) {
            return $this->notFound('Materi tidak ditemukan.');
        }

        $material->load([
            'kategori',
            'subMateri' => function ($query) use ($user) {
                $query->whereIn('tipe_beasiswa', $this->allowedScholarshipTypes($user))
                    ->with('items')
                    ->orderBy('urutan');
            },
            'preposttest',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Detail materi berhasil diambil.',
            'data' => $this->materialData($material, $user, true),
        ]);
    }

    public function completeItem(Request $request, int $materiId, int $subMateriId, int $itemId): JsonResponse
    {
        $user = $request->user()->load('siswa', 'bank.membership');
        $material = $this->findMaterialForUser($materiId, $user);

        if (! $material) {
            return $this->notFound('Materi tidak ditemukan.');
        }

        if (! $this->isEnrolled($user->id, $materiId)) {
            return $this->forbidden('Anda belum terdaftar pada materi ini.');
        }

        $subMateri = SubMateriModel::query()
            ->where('id', $subMateriId)
            ->where('id_materi', $materiId)
            ->whereIn('tipe_beasiswa', $this->allowedScholarshipTypes($user))
            ->with('items')
            ->first();

        $item = $subMateri?->items->firstWhere('id', $itemId);
        if (! $subMateri || ! $item) {
            return $this->notFound('Submateri atau item tidak ditemukan.');
        }

        DB::transaction(function () use ($user, $subMateri, $item) {
            UserSubMateriItemProgress::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'id_sub_materi_item' => $item->id,
                ],
                [
                    'is_completed' => true,
                    'completed_at' => now(),
                ]
            );

            $completedItemIds = UserSubMateriItemProgress::query()
                ->where('user_id', $user->id)
                ->whereIn('id_sub_materi_item', $subMateri->items->pluck('id'))
                ->where('is_completed', true)
                ->pluck('id_sub_materi_item');

            if ($completedItemIds->count() === $subMateri->items->count()) {
                UserSubMateriProgress::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'id_sub_materi' => $subMateri->id,
                    ],
                    [
                        'is_completed' => true,
                        'completed_at' => now(),
                    ]
                );
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Progress item berhasil disimpan.',
            'data' => $this->progressData($user->id, $materiId),
        ]);
    }

    public function test(Request $request, int $materiId, string $type): JsonResponse
    {
        $user = $request->user()->load('siswa', 'bank.membership');
        $validation = $this->validateTestAccess($user, $materiId, $type);
        if ($validation instanceof JsonResponse) {
            return $validation;
        }

        $quiz = $this->materialQuiz($materiId, $type);
        if (! $quiz) {
            return $this->notFound('Test untuk materi ini tidak ditemukan.');
        }

        $attempts = PrepotesUserModel::query()
            ->where('class_id', $materiId)
            ->where('user_id', $user->id)
            ->whereNull('submateri_id')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Test berhasil diambil.',
            'data' => [
                'id' => $quiz->id,
                'title' => $quiz->judul,
                'type' => $type,
                'question_count' => count($this->questionsWithoutAnswers($quiz->soal)),
                'questions' => $this->questionsWithoutAnswers($quiz->soal),
                'attempts' => $attempts->map(fn (PrepotesUserModel $attempt) => $this->attemptData($attempt, false, $type))->values(),
                'can_submit' => $type === 'pre'
                    ? $attempts->isEmpty()
                    : ! $attempts->contains(fn (PrepotesUserModel $attempt) => (float) $attempt->nilai_akhir >= 70),
            ],
        ]);
    }

    public function submitTest(Request $request, int $materiId, string $type): JsonResponse
    {
        $user = $request->user()->load('siswa', 'bank.membership');
        $validation = $this->validateTestAccess($user, $materiId, $type);
        if ($validation instanceof JsonResponse) {
            return $validation;
        }

        $answers = $request->input('answers', $request->input('jawaban'));
        if (! is_array($answers)) {
            return response()->json([
                'success' => false,
                'message' => 'Jawaban test harus berupa array.',
                'errors' => ['answers' => ['Jawaban test wajib diisi.']],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $quiz = $this->materialQuiz($materiId, $type);
        if (! $quiz) {
            return $this->notFound('Test untuk materi ini tidak ditemukan.');
        }

        $attempts = PrepotesUserModel::query()
            ->where('class_id', $materiId)
            ->where('user_id', $user->id)
            ->whereNull('submateri_id');

        if ($type === 'pre' && $attempts->exists()) {
            return $this->conflict('Pre-test hanya dapat diikuti satu kali.');
        }

        if ($type === 'post' && (clone $attempts)->where('nilai_akhir', '>=', 70)->exists()) {
            return $this->conflict('Anda sudah lulus post-test materi ini.');
        }

        $questions = $this->questions($quiz->soal);
        $correct = 0;
        foreach ($questions as $index => $question) {
            $expected = $question['jawaban'] ?? $question['Jawaban'] ?? null;
            $actual = $answers[$index] ?? null;

            if ($expected !== null && $actual !== null
                && strtoupper(trim((string) $expected)) === strtoupper(trim((string) $actual))) {
                $correct++;
            }
        }

        $score = count($questions) > 0 ? ($correct / count($questions)) * 100 : 0;
        $attempt = PrepotesUserModel::create([
            'class_id' => $materiId,
            'user_id' => $user->id,
            'jawaban' => json_encode($answers),
            'nilai_awal' => $type === 'pre' ? $score : 0,
            'nilai_akhir' => $type === 'post' ? $score : 0,
            'jml_jawaban' => (clone $attempts)->count() + 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => $score >= 70 || $type === 'pre'
                ? 'Test berhasil disimpan.'
                : 'Post-test belum lulus. Silakan pelajari materi dan coba lagi.',
            'data' => $this->attemptData($attempt, false, $type) + [
                'passed' => $type === 'post' && $score >= 70,
                'correct_answers' => $correct,
                'total_questions' => count($questions),
            ],
        ], Response::HTTP_CREATED);
    }

    public function attempts(Request $request, int $materiId): JsonResponse
    {
        $material = MateriModel::query()->where('id', $materiId)->where('nama', '!=', 'Umum')->first();
        if (! $material) {
            return $this->notFound('Materi tidak ditemukan.');
        }

        $attempts = PrepotesUserModel::query()
            ->where('class_id', $materiId)
            ->where('user_id', $request->user()->id)
            ->whereNull('submateri_id')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Riwayat test berhasil diambil.',
            'data' => $attempts->map(fn (PrepotesUserModel $attempt) => $this->attemptData($attempt, true))->values(),
        ]);
    }

    public function attempt(Request $request, int $materiId, int $attemptId): JsonResponse
    {
        $attempt = PrepotesUserModel::query()
            ->where('id', $attemptId)
            ->where('class_id', $materiId)
            ->where('user_id', $request->user()->id)
            ->whereNull('submateri_id')
            ->first();

        if (! $attempt) {
            return $this->notFound('Riwayat test tidak ditemukan.');
        }

        $type = (float) $attempt->nilai_akhir > 0 ? 'post' : 'pre';
        $quiz = $this->materialQuiz($materiId, $type);
        $answers = is_array($attempt->jawaban)
            ? $attempt->jawaban
            : json_decode((string) $attempt->jawaban, true);
        $answers = is_array($answers) ? $answers : [];
        $questions = $quiz ? $this->questions($quiz->soal) : [];

        return response()->json([
            'success' => true,
            'message' => 'Detail hasil test berhasil diambil.',
            'data' => $this->attemptData($attempt, true, $type) + [
                'results' => collect($questions)->values()->map(function (array $question, int $index) use ($answers) {
                    $correctAnswer = $question['jawaban'] ?? $question['Jawaban'] ?? null;
                    $submittedAnswer = $answers[$index] ?? null;

                    return [
                        'question' => $question['pertanyaan'] ?? null,
                        'submitted_answer' => $submittedAnswer,
                        'correct_answer' => $correctAnswer,
                        'is_correct' => $correctAnswer !== null && $submittedAnswer !== null
                            && strtoupper(trim((string) $correctAnswer)) === strtoupper(trim((string) $submittedAnswer)),
                    ];
                })->values(),
            ],
        ]);
    }

    public function certificates(Request $request): JsonResponse
    {
        $attempts = PrepotesUserModel::query()
            ->with('materi')
            ->where('user_id', $request->user()->id)
            ->whereNull('submateri_id')
            ->where('nilai_akhir', '>=', 70)
            ->latest('updated_at')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar sertifikat berhasil diambil.',
            'data' => $attempts->map(function (PrepotesUserModel $attempt) use ($request) {
                $template = CertificateTemplate::query()
                    ->where('target_type', 'materi')
                    ->where('materi_id', $attempt->class_id)
                    ->first();

                return [
                    'material_id' => $attempt->class_id,
                    'material_name' => $attempt->materi?->nama,
                    'score' => (float) $attempt->nilai_akhir,
                    'certificate_available' => (bool) $template,
                    'download_url' => $template
                        ? route('api.v1.learning.materials.certificate.download', $attempt->class_id)
                        : null,
                ];
            })->unique('material_id')->values(),
        ]);
    }

    public function certificate(Request $request, int $materiId): JsonResponse
    {
        [$attempt, $template, $material] = $this->certificateData($request->user()->id, $materiId);
        if (! $attempt || ! $template || ! $material
            || ! $this->isEnrolled($request->user()->id, $materiId)) {
            return $this->forbidden('Sertifikat belum tersedia untuk materi ini.');
        }

        $certificate = $this->issueCertificate($request->user()->id, $template);

        return response()->json([
            'success' => true,
            'message' => 'Sertifikat tersedia.',
            'data' => [
                'certificate_code' => $certificate->certificate_code,
                'material_id' => $material->id,
                'material_name' => $material->nama,
                'issued_at' => optional($certificate->issued_at)->toISOString(),
                'download_url' => route('api.v1.learning.materials.certificate.download', $material->id),
            ],
        ]);
    }

    public function certificateDownload(Request $request, int $materiId)
    {
        [$attempt, $template, $material] = $this->certificateData($request->user()->id, $materiId);
        if (! $attempt || ! $template || ! $material
            || ! $this->isEnrolled($request->user()->id, $materiId)) {
            return $this->forbidden('Sertifikat belum tersedia untuk materi ini.');
        }

        $imagePath = storage_path('app/public/certificates/'.$template->background_image);
        if (! is_file($imagePath)) {
            return response()->json([
                'success' => false,
                'message' => 'Template sertifikat belum tersedia.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $certificate = $this->issueCertificate($request->user()->id, $template);
        $imageData = base64_encode(file_get_contents($imagePath));
        $imageSrc = 'data:image/'.pathinfo($imagePath, PATHINFO_EXTENSION).';base64,'.$imageData;

        return Pdf::loadView('compact.pdf-sertifikat', [
            'noSertifikat' => $certificate->certificate_code,
            'namaSiswa' => strtoupper($request->user()->name),
            'imageSrc' => $imageSrc,
            'coordinateX' => $template->coordinate_x,
            'coordinateY' => $template->coordinate_y,
            'fontSize' => $template->font_size,
            'serialY' => $template->serial_y ?? 330,
            'serialFontSize' => $template->serial_font_size ?? 18,
            'labelY' => $template->label_y ?? 390,
            'labelFontSize' => $template->label_font_size ?? 16,
        ])->setPaper('a4', 'landscape')->setWarnings(false)->download(
            'Sertifikat-'.Str::slug($material->nama).'.pdf'
        );
    }

    private function findMaterialForUser(int $materiId, $user): ?MateriModel
    {
        if (! $this->hasActiveBankMembership($user)) {
            return null;
        }

        return MateriModel::query()
            ->where('id', $materiId)
            ->where('nama', '!=', 'Umum')
            ->first();
    }

    private function validateTestAccess($user, int $materiId, string $type): ?JsonResponse
    {
        if (! in_array($type, ['pre', 'post'], true)) {
            return response()->json([
                'success' => false,
                'message' => 'Tipe test harus pre atau post.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (! $user->siswa || (int) $user->siswa->beasiswa !== 1) {
            return $this->forbidden('Akses test hanya tersedia untuk siswa beasiswa.');
        }

        if (! $this->isEnrolled($user->id, $materiId)) {
            return $this->forbidden('Anda belum terdaftar pada materi ini.');
        }

        if ($type === 'post' && ! $this->isMaterialComplete($user->id, $materiId)) {
            return $this->forbidden('Selesaikan seluruh materi sebelum mengikuti post-test.');
        }

        return null;
    }

    private function materialQuiz(int $materiId, string $type): ?PreposttestModel
    {
        return PreposttestModel::query()
            ->where('id_materi', $materiId)
            ->whereNull('id_submateri')
            ->where('tipe_prepost', $type === 'pre' ? 0 : 1)
            ->first();
    }

    private function materialData(MateriModel $material, $user, bool $includeItems): array
    {
        $enrolled = $this->isEnrolled($user->id, $material->id);
        $subMaterials = $material->subMateri ?? collect();
        $itemIds = $subMaterials->flatMap(fn ($sub) => $sub->items ?? collect())->pluck('id');
        $completedItems = UserSubMateriItemProgress::query()
            ->where('user_id', $user->id)
            ->whereIn('id_sub_materi_item', $itemIds)
            ->where('is_completed', true)
            ->pluck('id_sub_materi_item');
        $completedSubMaterials = UserSubMateriProgress::query()
            ->where('user_id', $user->id)
            ->whereIn('id_sub_materi', $subMaterials->pluck('id'))
            ->where('is_completed', true)
            ->pluck('id_sub_materi');

        $totalItems = $itemIds->count();
        $completedCount = $completedItems->count();

        return [
            'id' => $material->id,
            'name' => $material->nama,
            'description' => $material->keterangan,
            'banner' => $this->assetUrl($material->banner),
            'icon' => $material->icon,
            'category' => $material->kategori?->nama,
            'enrolled' => $enrolled,
            'can_access' => $enrolled,
            'progress_percent' => $totalItems > 0 ? round(($completedCount / $totalItems) * 100, 2) : 0,
            'sub_materials' => $subMaterials->map(function ($sub) use ($includeItems, $completedItems, $completedSubMaterials) {
                $items = $sub->items ?? collect();

                return [
                    'id' => $sub->id,
                    'name' => $sub->nama,
                    'description' => $sub->keterangan,
                    'thumbnail' => $this->assetUrl($sub->thumbnail),
                    'order' => $sub->urutan,
                    'completed' => $completedSubMaterials->contains($sub->id),
                    'items' => $includeItems ? $items->map(fn ($item) => [
                        'id' => $item->id,
                        'title' => $item->judul_item,
                        'url' => $item->link_item,
                        'type' => (int) $item->tipe_link_item === 1 ? 'pdf' : 'video',
                        'completed' => $completedItems->contains($item->id),
                    ])->values() : [],
                ];
            })->values(),
        ];
    }

    private function progressData(int $userId, int $materiId): array
    {
        $subMaterialIds = SubMateriModel::query()->where('id_materi', $materiId)->pluck('id');
        $itemIds = DB::table('sub_materi_items')->whereIn('id_sub_materi', $subMaterialIds)->pluck('id');
        $completedItems = UserSubMateriItemProgress::query()
            ->where('user_id', $userId)
            ->whereIn('id_sub_materi_item', $itemIds)
            ->where('is_completed', true)
            ->count();

        return [
            'material_id' => $materiId,
            'completed_items' => $completedItems,
            'total_items' => $itemIds->count(),
            'progress_percent' => $itemIds->count() > 0
                ? round(($completedItems / $itemIds->count()) * 100, 2)
                : 0,
        ];
    }

    private function isMaterialComplete(int $userId, int $materiId): bool
    {
        $subMaterialIds = SubMateriModel::query()->where('id_materi', $materiId)->pluck('id');
        if ($subMaterialIds->isEmpty()) {
            return false;
        }

        return UserSubMateriProgress::query()
            ->where('user_id', $userId)
            ->whereIn('id_sub_materi', $subMaterialIds)
            ->where('is_completed', true)
            ->distinct('id_sub_materi')
            ->count('id_sub_materi') === $subMaterialIds->count();
    }

    private function isEnrolled(int $userId, int $materiId): bool
    {
        return SiswaModulAktif::query()
            ->where('user_id', $userId)
            ->where('class_id', $materiId)
            ->exists();
    }

    private function hasActiveBankMembership($user): bool
    {
        return $user->bank
            && $user->bank->masa_aktif_member
            && now()->parse($user->bank->masa_aktif_member)->isFuture()
            && $user->bank->membership;
    }

    private function allowedScholarshipTypes($user): array
    {
        return (int) ($user->siswa?->beasiswa ?? 0) === 1 ? [0, 1] : [0, 2];
    }

    private function questions($questions): array
    {
        if (is_string($questions)) {
            $questions = json_decode($questions, true);
        }

        return is_array($questions) ? array_values($questions) : [];
    }

    private function questionsWithoutAnswers($questions): array
    {
        return array_map(fn (array $question) => Arr::except($question, [
            'jawaban',
            'Jawaban',
            'answer',
            'correct_answer',
        ]), $this->questions($questions));
    }

    private function attemptData(
        PrepotesUserModel $attempt,
        bool $includeAnswers = false,
        ?string $type = null
    ): array
    {
        $data = [
            'id' => $attempt->id,
            'material_id' => $attempt->class_id,
            'type' => $type ?? ((float) $attempt->nilai_akhir > 0
                ? 'post'
                : ((float) $attempt->nilai_awal > 0 ? 'pre' : 'unknown')),
            'pre_score' => (float) $attempt->nilai_awal,
            'post_score' => (float) $attempt->nilai_akhir,
            'passed' => (float) $attempt->nilai_akhir >= 70,
            'created_at' => optional($attempt->created_at)->toISOString(),
        ];

        if ($includeAnswers) {
            $data['answers'] = is_array($attempt->jawaban)
                ? $attempt->jawaban
                : json_decode((string) $attempt->jawaban, true);
        }

        return $data;
    }

    private function certificateData(int $userId, int $materiId): array
    {
        $material = MateriModel::query()
            ->where('id', $materiId)
            ->where('nama', '!=', 'Umum')
            ->first();
        $attempt = PrepotesUserModel::query()
            ->where('user_id', $userId)
            ->where('class_id', $materiId)
            ->whereNull('submateri_id')
            ->where('nilai_akhir', '>=', 70)
            ->latest('id')
            ->first();
        $template = CertificateTemplate::query()
            ->where('target_type', 'materi')
            ->where('materi_id', $materiId)
            ->first();

        return [$attempt, $template, $material];
    }

    private function issueCertificate(int $userId, CertificateTemplate $template): UserCertificate
    {
        return UserCertificate::firstOrCreate(
            [
                'user_id' => $userId,
                'certificate_template_id' => $template->id,
            ],
            [
                'certificate_code' => 'CERT/'.now()->format('Ymd').'/'.$userId.'/'.$template->id,
                'issued_at' => now(),
            ]
        );
    }

    private function assetUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        return Str::startsWith($path, ['http://', 'https://', 'data:'])
            ? $path
            : asset(ltrim($path, '/'));
    }

    private function notFound(string $message): JsonResponse
    {
        return response()->json(['success' => false, 'message' => $message], Response::HTTP_NOT_FOUND);
    }

    private function forbidden(string $message): JsonResponse
    {
        return response()->json(['success' => false, 'message' => $message], Response::HTTP_FORBIDDEN);
    }

    private function conflict(string $message): JsonResponse
    {
        return response()->json(['success' => false, 'message' => $message], Response::HTTP_CONFLICT);
    }
}
