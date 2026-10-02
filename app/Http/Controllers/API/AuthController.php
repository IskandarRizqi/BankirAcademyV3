<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

        // Email verification is not required for mobile API login. The app can
        // use requires_verification in the response to guide an unverified student.
        if (! $user || ! $user->password || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password tidak sesuai.',
            ], 401);
        }

        $accessToken = $user->createToken($credentials['device_name'] ?? 'mobile-app', ['mobile']);

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
            'requires_verification' => $roleId === 6 && ! (bool) $user->is_active,
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
