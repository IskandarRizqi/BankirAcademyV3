<?php

namespace App\Http\Controllers\API;

use App\Exports\SiswaTemplateExport;
use App\Http\Controllers\Controller;
use App\Imports\SiswaImport;
use App\Models\SiswaModulAktif;
use App\Models\SiswaProfile;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class OrganizationController extends Controller
{
    public function profile(Request $request): JsonResponse
    {
        $user = $request->user()->load(['bank', 'sekolah', 'membership', 'userProfile']);

        return response()->json([
            'success' => true,
            'message' => 'Profil organisasi berhasil diambil.',
            'data' => ['user' => $this->userData($user, true)],
        ]);
    }

    public function dashboard(Request $request): JsonResponse
    {
        $user = $request->user();
        $students = $this->studentsQuery($user);

        if ((int) $user->role === 4) {
            $schools = User::query()
                ->where('role', 5)
                ->where('bank_id', $user->id)
                ->orderBy('name')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Dashboard Bank berhasil diambil.',
                'data' => [
                    'type' => 'bank',
                    'organization' => $this->userData($user),
                    'stats' => [
                        'total_schools' => $schools->count(),
                        'total_students' => (clone $students)->count(),
                        'active_students' => (clone $students)->where('is_active', 1)->count(),
                        'scholarship_students' => $this->studentProfiles($students)->where('beasiswa', 1)->count(),
                        'pending_scholarships' => $this->studentProfiles($students)->where('beasiswa', 2)->count(),
                    ],
                    'schools' => $schools->map(fn (User $school) => [
                        'id' => $school->id,
                        'name' => $school->name,
                        'email' => $school->email,
                        'student_count' => User::where('role', 6)->where('sekolah_id', $school->id)->count(),
                    ])->values(),
                ],
            ]);
        }

        $profiles = $this->studentProfiles($students);

        return response()->json([
            'success' => true,
            'message' => 'Dashboard Sekolah berhasil diambil.',
            'data' => [
                'type' => 'sekolah',
                'organization' => $this->userData($user),
                'stats' => [
                    'total_students' => $students->count(),
                    'active_students' => (clone $students)->where('is_active', 1)->count(),
                    'scholarship_students' => $profiles->where('beasiswa', 1)->count(),
                    'pending_scholarships' => $profiles->where('beasiswa', 2)->count(),
                    'total_balance' => (int) $profiles->sum('saldo'),
                ],
                'students' => $students->with('siswa')->latest()->get()->map(fn (User $student) => $this->userData($student, true))->values(),
            ],
        ]);
    }

    public function users(Request $request): JsonResponse
    {
        $query = $this->managedUsersQuery($request->user());

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', (int) $request->input('role'));
        }

        $users = $query->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar pengguna berhasil diambil.',
            'data' => [
                'users' => $users->map(fn (User $user) => $this->userData($user, true))->values(),
                'total' => $users->count(),
            ],
        ]);
    }

    public function showUser(Request $request, int $id): JsonResponse
    {
        $user = $this->managedUsersQuery($request->user())->whereKey($id)->first();
        if (! $user) {
            return $this->error('Pengguna tidak ditemukan.', Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail pengguna berhasil diambil.',
            'data' => ['user' => $this->userData($user, true)],
        ]);
    }

    public function storeUser(Request $request): JsonResponse
    {
        $actor = $request->user();
        $role = (int) $request->input('role');
        $this->ensureCanManageRole($actor, $role);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'integer'],
            'beasiswa' => ['nullable', 'integer', 'in:0,1'],
        ];

        if ($role === 6) {
            $rules += [
                'nisn' => ['required', 'string', 'max:20'],
                'kelas' => ['nullable', 'string', 'max:50'],
                'angkatan' => ['nullable', 'integer'],
                'jenis_kelamin' => ['nullable', 'in:L,P'],
                'no_telp' => ['nullable', 'string', 'max:20'],
                'alamat' => ['nullable', 'string'],
                'email_pribadi' => ['nullable', 'email', 'max:255'],
            ];
        } else {
            $rules += [
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8'],
            ];
        }

        $validated = $request->validate($rules);
        $schoolId = $this->schoolIdFor($actor, $role, $request->input('sekolah_id'));
        $bankId = $role === 5 ? $actor->id : ($actor->bank_id ?: $actor->id);

        if ($role === 5) {
            $bankId = $actor->id;
        }

        $studentProfile = null;
        if ($role === 6) {
            $nisn = trim((string) $validated['nisn']);
            $email = $nisn.'@gmail.com';
            if (User::where('email', $email)->exists()) {
                return $this->error('NISN sudah terdaftar di sistem.', Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $beasiswa = (int) ($validated['beasiswa'] ?? 0);
            if ((int) $actor->role === 5 && $beasiswa === 1) {
                $beasiswa = 2;
            }
            $this->ensureStudentQuota($actor, $schoolId, $beasiswa);
        } else {
            $email = $validated['email'];
            $nisn = null;
            $beasiswa = 0;
        }

        $user = DB::transaction(function () use ($validated, $role, $email, $bankId, $schoolId, $nisn, $beasiswa, &$studentProfile) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $email,
                'role' => $role,
                'password' => Hash::make($role === 6 ? $nisn.'Bankir!' : $validated['password']),
                'bank_id' => $bankId,
                'sekolah_id' => $schoolId,
            ]);

            if ($role === 6) {
                $studentProfile = SiswaProfile::create([
                    'user_id' => $user->id,
                    'nisn' => $nisn,
                    'kelas' => $validated['kelas'] ?? null,
                    'angkatan' => $validated['angkatan'] ?? null,
                    'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
                    'no_telp' => $validated['no_telp'] ?? null,
                    'alamat' => $validated['alamat'] ?? null,
                    'email' => $validated['email_pribadi'] ?? null,
                    'beasiswa' => $beasiswa,
                    'saldo' => $beasiswa === 1 ? $this->initialStudentBalance($bankId) : 0,
                ]);
            }

            return $user;
        });

        $user->load(['siswa', 'bank', 'sekolah', 'membership']);

        return response()->json([
            'success' => true,
            'message' => 'Pengguna berhasil ditambahkan.',
            'data' => ['user' => $this->userData($user, true)],
        ], Response::HTTP_CREATED);
    }

    public function updateUser(Request $request, int $id): JsonResponse
    {
        $actor = $request->user();
        $user = $this->managedUsersQuery($actor)->whereKey($id)->first();
        if (! $user) {
            return $this->error('Pengguna tidak ditemukan.', Response::HTTP_NOT_FOUND);
        }

        $role = (int) $user->role;
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8'],
        ];
        if ($role === 6) {
            $rules += [
                'nisn' => ['required', 'string', 'max:20'],
                'kelas' => ['nullable', 'string', 'max:50'],
                'angkatan' => ['nullable', 'integer'],
                'jenis_kelamin' => ['nullable', 'in:L,P'],
                'no_telp' => ['nullable', 'string', 'max:20'],
                'alamat' => ['nullable', 'string'],
                'email_pribadi' => ['nullable', 'email', 'max:255'],
                'beasiswa' => ['nullable', 'integer', 'in:0,1,2'],
            ];
        } else {
            $rules['email'] = ['required', 'email', 'max:255', 'unique:users,email,'.$user->id];
        }

        $validated = $request->validate($rules);
        $data = ['name' => $validated['name']];
        if ($role !== 6) {
            $data['email'] = $validated['email'];
        } else {
            $nisn = trim((string) $validated['nisn']);
            $email = $nisn.'@gmail.com';
            if (User::where('email', $email)->where('id', '!=', $user->id)->exists()) {
                return $this->error('NISN sudah terdaftar di sistem.', Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $data['email'] = $email;
        }
        if (! empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        } elseif ($role === 6) {
            $data['password'] = Hash::make(trim((string) $validated['nisn']).'Bankir!');
        }

        $beasiswa = null;
        if ($role === 6) {
            $beasiswa = array_key_exists('beasiswa', $validated)
                ? (int) $validated['beasiswa']
                : (int) ($user->siswa?->beasiswa ?? 0);
            if ((int) $actor->role === 5 && $beasiswa === 1) {
                $beasiswa = 2;
            }
            if ($beasiswa === 1) {
                $this->ensureStudentQuota($actor, $user->sekolah_id, 1, $user->id);
            }
        }

        DB::transaction(function () use ($user, $data, $role, $validated, $beasiswa) {
            $user->update($data);
            if ($role === 6) {
                SiswaProfile::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nisn' => trim((string) $validated['nisn']),
                        'kelas' => $validated['kelas'] ?? null,
                        'angkatan' => $validated['angkatan'] ?? null,
                        'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
                        'no_telp' => $validated['no_telp'] ?? null,
                        'alamat' => $validated['alamat'] ?? null,
                        'email' => $validated['email_pribadi'] ?? null,
                        'beasiswa' => $beasiswa,
                    ]
                );
            }
        });

        $user->load(['siswa', 'bank', 'sekolah', 'membership']);

        return response()->json([
            'success' => true,
            'message' => 'Pengguna berhasil diperbarui.',
            'data' => ['user' => $this->userData($user, true)],
        ]);
    }

    public function destroyUser(Request $request, int $id): JsonResponse
    {
        $user = $this->managedUsersQuery($request->user())->whereKey($id)->first();
        if (! $user) {
            return $this->error('Pengguna tidak ditemukan.', Response::HTTP_NOT_FOUND);
        }

        DB::transaction(function () use ($user) {
            $user->siswa()->delete();
            $user->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'Pengguna berhasil dihapus.',
        ]);
    }

    public function monitoring(Request $request): JsonResponse
    {
        $items = SiswaModulAktif::query()
            ->with(['user.siswa', 'user.bank', 'user.sekolah', 'materi'])
            ->whereHas('user', fn ($query) => $this->applyStudentScope($query, $request->user()))
            ->latest()
            ->get();

        $students = $items->pluck('user_id')->unique()->count();
        $profiles = $items->map(fn (SiswaModulAktif $item) => $item->user?->siswa)->filter();

        return response()->json([
            'success' => true,
            'message' => 'Monitoring peserta berhasil diambil.',
            'data' => [
                'stats' => [
                    'total_students' => $students,
                    'total_modules' => $items->pluck('class_id')->unique()->count(),
                    'scholarship_students' => $profiles->where('beasiswa', 1)->pluck('user_id')->unique()->count(),
                    'regular_students' => $profiles->where('beasiswa', 0)->pluck('user_id')->unique()->count(),
                ],
                'items' => $items->map(fn (SiswaModulAktif $item) => [
                    'id' => $item->id,
                    'student_id' => $item->user_id,
                    'student_name' => $item->user?->name,
                    'student_email' => $item->user?->email,
                    'school_name' => $item->user?->sekolah?->name,
                    'material_id' => $item->class_id,
                    'material_name' => $item->materi?->nama,
                    'scholarship' => (int) ($item->user?->siswa?->beasiswa ?? 0) === 1,
                    'created_at' => optional($item->created_at)->toISOString(),
                ])->values(),
            ],
        ]);
    }

    public function scholarships(Request $request): JsonResponse
    {
        $query = SiswaProfile::query()
            ->with(['user.sekolah', 'user.bank'])
            ->where('beasiswa', 2);
        $query->whereHas('user', fn ($builder) => $this->applyStudentScope($builder, $request->user()));
        $profiles = $query->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Pengajuan beasiswa berhasil diambil.',
            'data' => $profiles->map(fn (SiswaProfile $profile) => [
                'id' => $profile->id,
                'student_id' => $profile->user_id,
                'student_name' => $profile->user?->name,
                'student_email' => $profile->user?->email,
                'school_name' => $profile->user?->sekolah?->name,
                'nisn' => $profile->nisn,
                'class' => $profile->kelas,
                'status' => (int) $profile->beasiswa,
            ])->values(),
        ]);
    }

    public function scholarshipAction(Request $request, int $id, string $action): JsonResponse
    {
        if ((int) $request->user()->role !== 4 || ! in_array($action, ['approve', 'reject'], true)) {
            return $this->error('Aksi beasiswa tidak diizinkan.', Response::HTTP_FORBIDDEN);
        }

        $profile = SiswaProfile::with('user')->whereKey($id)->first();
        if (! $profile || ! $profile->user || (int) $profile->user->bank_id !== (int) $request->user()->id || (int) $profile->beasiswa !== 2) {
            return $this->error('Pengajuan beasiswa tidak ditemukan.', Response::HTTP_NOT_FOUND);
        }

        if ($action === 'approve') {
            $this->ensureStudentQuota($request->user(), $profile->user->sekolah_id, 1, $profile->user_id);
            $profile->update(['beasiswa' => 1]);
        } else {
            $profile->update(['beasiswa' => 0]);
        }

        return response()->json([
            'success' => true,
            'message' => $action === 'approve' ? 'Beasiswa berhasil disetujui.' : 'Pengajuan beasiswa ditolak.',
            'data' => ['id' => $profile->id, 'status' => (int) $profile->beasiswa],
        ]);
    }

    public function downloadTemplate(): BinaryFileResponse
    {
        return Excel::download(new SiswaTemplateExport, 'template_import_siswa.xlsx');
    }

    public function importStudents(Request $request): JsonResponse
    {
        $actor = $request->user();
        $request->validate(['file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240']]);
        $schoolId = $this->schoolIdFor($actor, 6, $request->input('sekolah_id'));
        $bankId = (int) $actor->role === 4 ? $actor->id : $actor->bank_id;

        DB::beginTransaction();
        try {
            $import = new SiswaImport($bankId, $schoolId);
            Excel::import($import, $request->file('file'));
            $successCount = 0;
            $errors = [];
            foreach ($import->sheetInstances as $sheet) {
                $successCount += $sheet->successCount;
                $errors = array_merge($errors, $sheet->errors);
            }
            if ($errors !== []) {
                DB::rollBack();

                return $this->error(implode(' ', $errors), Response::HTTP_UNPROCESSABLE_ENTITY, ['errors' => $errors]);
            }
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "{$successCount} peserta berhasil diimport.",
                'data' => ['imported' => $successCount],
            ], Response::HTTP_CREATED);
        } catch (\Throwable $exception) {
            DB::rollBack();
            report($exception);

            return $this->error('Import peserta gagal diproses.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    private function managedUsersQuery(User $actor)
    {
        $roles = (int) $actor->role === 4 ? [5, 6] : [6];

        return User::query()
            ->whereIn('role', $roles)
            ->when((int) $actor->role === 4, fn ($query) => $query->where('bank_id', $actor->id))
            ->when((int) $actor->role === 5, fn ($query) => $query->where('sekolah_id', $actor->id))
            ->with(['siswa', 'bank', 'sekolah', 'membership']);
    }

    private function studentsQuery(User $actor)
    {
        return User::query()
            ->where('role', 6)
            ->when((int) $actor->role === 4, fn ($query) => $query->where('bank_id', $actor->id))
            ->when((int) $actor->role === 5, fn ($query) => $query->where('sekolah_id', $actor->id));
    }

    private function applyStudentScope($query, User $actor)
    {
        return $query
            ->where('role', 6)
            ->when((int) $actor->role === 4, fn ($builder) => $builder->where('bank_id', $actor->id))
            ->when((int) $actor->role === 5, fn ($builder) => $builder->where('sekolah_id', $actor->id));
    }

    private function studentProfiles($students)
    {
        return SiswaProfile::query()->whereIn('user_id', (clone $students)->pluck('id'))->get();
    }

    private function ensureCanManageRole(User $actor, int $role): void
    {
        $allowed = (int) $actor->role === 4 ? [5, 6] : [6];
        if (! in_array($role, $allowed, true)) {
            abort(Response::HTTP_FORBIDDEN, 'Role akun tidak dapat membuat pengguna ini.');
        }
    }

    private function schoolIdFor(User $actor, int $role, mixed $requestedSchoolId): ?int
    {
        if ($role !== 6) {
            return null;
        }
        $schoolId = (int) ((int) $actor->role === 5 ? $actor->id : $requestedSchoolId);
        $school = User::query()->where('id', $schoolId)->where('role', 5)->first();
        if (! $school || ((int) $actor->role === 4 && (int) $school->bank_id !== (int) $actor->id)) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, 'Sekolah tujuan tidak valid untuk akun ini.');
        }

        return $schoolId;
    }

    private function ensureStudentQuota(User $actor, ?int $schoolId, int $beasiswa, ?int $ignoreUserId = null): void
    {
        $bank = (int) $actor->role === 4 ? $actor : $actor->bank;
        $membership = $bank?->membership;
        if (! $membership || ! $schoolId) {
            return;
        }

        $studentCount = User::where('role', 6)->where('sekolah_id', $schoolId)
            ->when($ignoreUserId, fn ($query) => $query->where('id', '!=', $ignoreUserId))->count();
        if (! is_null($membership->limit_siswa) && $studentCount >= (int) $membership->limit_siswa) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, 'Kuota siswa untuk sekolah ini sudah penuh.');
        }

        if ($beasiswa === 1 && ! is_null($membership->limit_beasiswa)) {
            $scholarshipCount = SiswaProfile::where('beasiswa', 1)
                ->whereHas('user', fn ($query) => $query->where('sekolah_id', $schoolId)
                    ->when($ignoreUserId, fn ($builder) => $builder->where('id', '!=', $ignoreUserId)))
                ->count();
            if ($scholarshipCount >= (int) $membership->limit_beasiswa) {
                abort(Response::HTTP_UNPROCESSABLE_ENTITY, 'Kuota beasiswa untuk sekolah ini sudah penuh.');
            }
        }
    }

    private function initialStudentBalance(?int $bankId): int
    {
        return (int) (User::find($bankId)?->membership?->saldo_siswa ?? 0);
    }

    private function userData(User $user, bool $includeRelations = false): array
    {
        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => (int) $user->role,
            'role_name' => $user->role_name,
            'is_active' => (bool) $user->is_active,
            'bank_id' => $user->bank_id,
            'sekolah_id' => $user->sekolah_id,
            'created_at' => optional($user->created_at)->toISOString(),
        ];

        if ($includeRelations) {
            $data['student'] = $user->siswa?->only([
                'id', 'nisn', 'kelas', 'angkatan', 'jenis_kelamin', 'no_telp', 'alamat', 'email', 'saldo', 'beasiswa',
            ]);
            $data['bank'] = $user->bank ? ['id' => $user->bank->id, 'name' => $user->bank->name, 'email' => $user->bank->email] : null;
            $data['school'] = $user->sekolah ? ['id' => $user->sekolah->id, 'name' => $user->sekolah->name, 'email' => $user->sekolah->email] : null;
            $data['membership'] = $user->membership?->only(['id', 'nama', 'limit_siswa', 'limit_beasiswa', 'saldo_siswa']);
        }

        return $data;
    }

    private function error(string $message, int $status, array $data = []): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}
