<?php

namespace App\Http\Controllers\API;

use App\Exceptions\GoogleAccountLinkingException;
use App\Exceptions\GoogleEmailNotVerifiedException;
use App\Exceptions\GoogleProviderException;
use App\Exceptions\GoogleTokenException;
use App\Http\Controllers\Controller;
use App\Models\SiswaProfile;
use App\Models\User;
use App\Models\UserProfileModel;
use App\Services\GoogleIdTokenVerifier;
use App\Support\MobileAccess;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private const ROLE_NAMES = [
        0 => 'Root',
        1 => 'Admin',
        2 => 'Peserta',
        3 => 'Instructor',
        4 => 'Bank',
        5 => 'Sekolah',
        6 => 'Siswa',
    ];

    public function __construct(private GoogleIdTokenVerifier $googleIdTokenVerifier) {}

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:100'],
        ]);

        $user = User::query()
            ->with([
                'userProfile.membership',
                'siswa',
                'membership',
                'perusahaan',
                'rekeningData',
                'bank',
                'sekolah',
            ])
            ->where('email', $credentials['email'])
            ->first();

        // Mobile access follows the website and does not require email verification.
        if (! $user || ! $user->password || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password tidak sesuai.',
            ], 401);
        }

        if (MobileAccess::isBlocked($user)) {
            return $this->websiteOnlyAccountResponse();
        }

        $this->ensureMembershipProfile($user);
        $user->load('userProfile.membership');
        $accessToken = $this->issueToken($user, $credentials['device_name'] ?? 'mobile-app');
        $this->auditLogin($request, $user, 'password');

        return $this->tokenResponse($user, $accessToken);
    }

    /**
     * Legacy endpoint kept for older mobile clients.
     */
    public function sendVerificationNotification(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        return response()->json([
            'success' => true,
            'code' => 'email_verification_disabled',
            'message' => 'Verifikasi email sedang dinonaktifkan sementara untuk aplikasi.',
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Verify an account from an existing signed link.
     */
    public function verifyEmail(Request $request, int $id, string $hash): JsonResponse
    {
        if (! $request->hasValidSignature()) {
            return $this->invalidVerificationResponse('Link verifikasi tidak valid atau telah kedaluwarsa.');
        }

        $profile = SiswaProfile::query()->with('user')->find($id);
        $user = $profile?->user;

        if (! $profile?->email || ! $user || ! hash_equals(sha1($profile->email), $hash)) {
            return $this->invalidVerificationResponse('Token verifikasi tidak sesuai dengan akun.');
        }

        if ($user->email_verified_at !== null) {
            return response()->json([
                'success' => true,
                'message' => 'Email sudah diverifikasi sebelumnya.',
                'data' => [
                    'profile_id' => $profile->id,
                    'user_id' => $user->id,
                    'verified' => true,
                    'email_verified_at' => $user->email_verified_at->toISOString(),
                ],
            ]);
        }

        $user->forceFill([
            'email_verified_at' => now(),
            'is_active' => 1,
        ])->save();

        return response()->json([
            'success' => true,
            'message' => 'Email berhasil diverifikasi. Silakan login kembali di aplikasi.',
            'data' => [
                'profile_id' => $profile->id,
                'user_id' => $user->id,
                'verified' => true,
                'email_verified_at' => $user->email_verified_at->toISOString(),
            ],
        ]);
    }

    public function google(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'id_token' => ['required', 'string', 'max:10000'],
            'device_name' => ['nullable', 'string', 'max:100'],
        ]);

        try {
            $identity = $this->googleIdTokenVerifier->verify($credentials['id_token']);
        } catch (GoogleEmailNotVerifiedException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], Response::HTTP_FORBIDDEN);
        } catch (GoogleTokenException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], Response::HTTP_UNAUTHORIZED);
        } catch (GoogleProviderException $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Login Google sedang tidak tersedia. Silakan coba lagi nanti.',
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }

        if (MobileAccess::isBlockedEmail($identity['email'])) {
            return $this->websiteOnlyAccountResponse();
        }

        $existingGoogleUser = User::query()
            ->where('google_id', $identity['sub'])
            ->first();
        $existingEmailUser = User::query()
            ->whereRaw('LOWER(email) = ?', [strtolower($identity['email'])])
            ->first();

        if (MobileAccess::isBlocked($existingGoogleUser) || MobileAccess::isBlocked($existingEmailUser)) {
            return $this->websiteOnlyAccountResponse();
        }

        try {
            $user = DB::transaction(function () use ($identity): User {
                return $this->findOrCreateGoogleUser($identity);
            });
        } catch (GoogleAccountLinkingException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], Response::HTTP_CONFLICT);
        } catch (QueryException $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Akun Google tidak dapat diproses saat ini. Silakan coba lagi.',
            ], Response::HTTP_CONFLICT);
        }

        if (MobileAccess::isBlocked($user)) {
            return $this->websiteOnlyAccountResponse();
        }

        $this->ensureMembershipProfile($user);
        $user->load('userProfile.membership');
        $accessToken = $this->issueToken($user, $credentials['device_name'] ?? 'bankir-app');
        $this->auditLogin($request, $user, 'google');

        return $this->tokenResponse($user, $accessToken);
    }

    private function findOrCreateGoogleUser(array $identity): User
    {
        $user = User::query()
            ->where('google_id', $identity['sub'])
            ->lockForUpdate()
            ->first();

        if ($user) {
            return $this->loadApiUser($user);
        }

        $userByEmail = User::query()
            ->whereRaw('LOWER(email) = ?', [strtolower($identity['email'])])
            ->lockForUpdate()
            ->first();

        if ($userByEmail) {
            if ($userByEmail->google_id && ! hash_equals((string) $userByEmail->google_id, $identity['sub'])) {
                throw new GoogleAccountLinkingException('Email Google sudah terhubung ke akun Google lain.');
            }

            $userByEmail->forceFill(['google_id' => $identity['sub']])->save();

            return $this->loadApiUser($userByEmail);
        }

        $user = User::create([
            'name' => $identity['name'],
            'email' => $identity['email'],
            'google_id' => $identity['sub'],
            'email_verified_at' => now(),
            'role' => 2,
            'is_active' => 1,
        ]);

        return $this->loadApiUser($user);
    }

    private function loadApiUser(User $user): User
    {
        return $user->load([
            'userProfile.membership',
            'siswa',
            'membership',
            'perusahaan',
            'rekeningData',
            'bank',
            'sekolah',
        ]);
    }

    private function ensureMembershipProfile(User $user): UserProfileModel
    {
        return UserProfileModel::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $user->name ?: 'Pengguna Bankir Academy',
                'phone' => '0',
                'gender' => 0,
                'existing_user' => 0,
            ]
        );
    }

    private function issueToken(User $user, string $deviceName)
    {
        return $user->createToken($deviceName, ['mobile']);
    }

    private function tokenResponse(User $user, $accessToken): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'data' => [
                'token' => $accessToken->plainTextToken,
                'token_type' => 'Bearer',
                'expires_at' => optional($accessToken->accessToken->expires_at)->toISOString(),
                'user' => $this->userData($user),
            ],
        ]);
    }

    private function websiteOnlyAccountResponse(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'code' => 'website_only_account',
            'message' => 'Akun ini hanya dapat digunakan melalui website.',
        ], Response::HTTP_FORBIDDEN);
    }

    private function invalidVerificationResponse(string $message): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'code' => 'invalid_verification_link',
        ], Response::HTTP_FORBIDDEN);
    }

    private function auditLogin(Request $request, User $user, string $provider): void
    {
        activity()
            ->causedBy($user)
            ->performedOn($user)
            ->event('login')
            ->withProperties([
                'channel' => 'api',
                'provider' => $provider,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ])
            ->log('Login API berhasil.');
    }

    public function me(Request $request): JsonResponse
    {
        $user = $request->user()->load([
            'userProfile.membership',
            'siswa',
            'membership',
            'perusahaan',
            'rekeningData',
            'bank',
            'sekolah',
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $this->userData($user),
            ],
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.',
        ]);
    }

    private function userData(User $user): array
    {
        $roleId = (int) $user->role;
        $roleKey = $this->roleKey($roleId);

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => $roleId,
            'role_key' => $roleKey,
            'role_name' => self::ROLE_NAMES[$roleId] ?? 'User',
            'account_type' => $roleId === 5 ? 'merchant' : $roleKey,
            'parent_id' => $user->parent_id,
            'bank_id' => $user->bank_id,
            'sekolah_id' => $user->sekolah_id,
            'membership_id' => $user->membership_id,
            'masa_aktif_member' => $user->masa_aktif_member,
            'corporate' => $user->corporate,
            'corporates' => $this->decodeCorporate($user->corporate),
            'is_active' => (bool) $user->is_active,
            'email_verified_at' => optional($user->email_verified_at)->toISOString(),
            'activated_at' => optional($user->activated_at)->toISOString(),
            'created_at' => optional($user->created_at)->toISOString(),
            'updated_at' => optional($user->updated_at)->toISOString(),
            'requires_verification' => false,
            'profile' => $this->profileData($user->userProfile),
            'student_profile' => $user->siswa?->only([
                'id',
                'user_id',
                'no_telp',
                'jenis_kelamin',
                'nisn',
                'kelas',
                'angkatan',
                'saldo',
                'beasiswa',
                'alamat',
                'email',
                'created_at',
                'updated_at',
            ]),
            'company' => $user->perusahaan?->toArray(),
            'membership' => $user->membership?->toArray(),
            'bank_account' => $user->rekeningData?->only([
                'id',
                'user_id',
                'nama_bank',
                'no_rekening',
            ]),
            'organization' => [
                'bank' => $this->relatedUserData($user->bank),
                'sekolah' => $this->relatedUserData($user->sekolah),
            ],
        ];
    }

    private function profileData($profile): ?array
    {
        if (! $profile) {
            return null;
        }

        return [
            'id' => $profile->id,
            'user_id' => $profile->user_id,
            'name' => $profile->name,
            'phone_region' => $profile->phone_region,
            'phone' => $profile->phone,
            'status_nomor' => (bool) $profile->status_nomor,
            'alamat' => $profile->alamat,
            'provinsi_id' => $profile->provinsi_id,
            'kota_id' => $profile->kota_id,
            'kecamatan_id' => $profile->kecamatan_id,
            'kelurahan_id' => $profile->kelurahan_id,
            'picture' => $profile->picture,
            'tanggal_lahir' => $profile->tanggal_lahir,
            'gender' => $profile->gender,
            'description' => $profile->description,
            'instansi' => $profile->instansi,
            'nama_bank' => $profile->nama_bank,
            'rekening' => $profile->rekening,
            'existing_user' => (bool) $profile->existing_user,
            'image_bukti_pembayaran' => $profile->image_bukti_pembayaran,
            'status_membership' => $profile->status_membership,
            'masa_aktif_membership' => $profile->masa_aktif_membership,
            'id_member' => $profile->id_member,
            'tanggal_bergabung_membership' => $profile->tanggal_bergabung_membership,
            'tipe_membership' => $profile->tipe_membership,
            'membership' => $profile->membership?->toArray(),
        ];
    }

    private function relatedUserData(?User $user): ?array
    {
        if (! $user) {
            return null;
        }

        $roleId = (int) $user->role;

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => $roleId,
            'role_key' => $this->roleKey($roleId),
            'role_name' => self::ROLE_NAMES[$roleId] ?? 'User',
        ];
    }

    private function roleKey(int $roleId): string
    {
        return match ($roleId) {
            0 => 'root',
            1 => 'admin',
            2 => 'peserta',
            3 => 'instructor',
            4 => 'bank',
            5 => 'sekolah',
            6 => 'siswa',
            default => 'user',
        };
    }

    private function decodeCorporate($corporate)
    {
        if ($corporate === null || $corporate === '') {
            return null;
        }

        $decoded = json_decode((string) $corporate, true);

        return json_last_error() === JSON_ERROR_NONE ? $decoded : $corporate;
    }
}
