<?php

namespace App\Http\Controllers;

use App\Mail\VerifikasiEmailSiswaMail;
use App\Models\SiswaProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class SiswaVerificationController extends Controller
{
    public function verify(Request $request, $id, $hash)
    {
        // 1. Validasi keabsahan URL bertanda tangan (Signed URL)
        if (! $request->hasValidSignature()) {
            return response()->view('errors.link_invalid', [
                'message' => 'Link verifikasi tidak valid atau telah kedaluwarsa.'
            ], 403);
        }

        $profile = SiswaProfile::findOrFail($id);

        // 2. Validasi kesesuaian Hash Email
        if (! hash_equals((string) $hash, sha1($profile->email))) {
            return response()->view('errors.link_invalid', [
                'message' => 'Token verifikasi tidak sesuai dengan email target.'
            ], 403);
        }

        $user = User::findOrFail($profile->user_id);

        // 3. Cek jika sudah pernah diverifikasi
        if ($user->email_verified_at !== null) {
            return view('siswa.verified_status', [
                'status' => 'already', 
                'message' => 'Email ini sudah diverifikasi sebelumnya.'
            ]);
        }

        // 4. Update status verifikasi
        $user->update([
            'email_verified_at' => now(),
            'is_active' => 1
        ]);

        // 5. Kirim Notifikasi WhatsApp setelah Verifikasi Berhasil
        $this->sendWhatsappNotification($user, $profile);

        return view('compact.siswa.verified_status', [
            'status' => 'success', 
            'message' => 'Email pribadi Anda berhasil diverifikasi! Detail akun telah dikirimkan ke WhatsApp Anda.'
        ]);
    }

    /**
     * Helper Method Pengiriman WhatsApp
     */
    private function sendWhatsappNotification(User $user, SiswaProfile $profile)
    {
        if (empty($profile->no_telp)) {
            return false;
        }

        // Bersihkan format nomor telepon ke 62
        $target = preg_replace('/^0/', '62', $profile->no_telp);

        $nisn = $profile->nisn;
        $generatedEmail = $user->email; // Mengambil email login dari tabel users
        $generatedPassword = $nisn . 'Bankir!';

        $message = "Pesan Otomatis Bankir\n" .
            "__________________\n" .
            "Informasi Akun Siswa (Terverifikasi)\n" .
            now()->format('d M Y') . "\n\n" .
            "Salam sehat\n" .
            "Yth *" . $user->name . "*,\n\n" .
            "Email Anda telah berhasil diverifikasi. Berikut adalah detail akun Anda:\n" .
            "Email: *" . $generatedEmail . "*\n" .
            "Password: *" . $generatedPassword . "*\n" .
            "----------------------------------------------\n" .
            "Silakan cek bankiracademy.co.id untuk detail lebih lanjut.\n" .
            "------------------------------------------\n" .
            "Copyright\n" .
            "bankiracademy.co.id | " . date('Y');

        try {
            $response = Http::withHeaders([
                'Authorization' => env('FONNTE_API_TOKEN')
            ])->post(env('FONNTE_BASE_URL'), [
                'target'  => $target,
                'message' => $message,
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Gagal mengirim WA verifikasi: ' . $e->getMessage());
            return false;
        }
    }
    public function resend(Request $request)
{
    $user = auth()->user();
    $profile = SiswaProfile::where('user_id', $user->id)->first();

    if (!$profile || empty($profile->email)) {
        return back()->with('error', 'Email pribadi tidak ditemukan pada profil Anda.');
    }

    if ($user->is_active == 1) {
        return back()->with('info', 'Akun Anda sudah aktif dan terverifikasi.');
    }

    // Generate Signed URL aman 24 jam
    $verificationUrl = URL::temporarySignedRoute(
        'siswa.verifikasi.email',
        now()->addHours(24),
        [
            'id'   => $profile->id,
            'hash' => sha1($profile->email)
        ]
    );

    try {
        // Kirim Email Verifikasi
        Mail::to($profile->email)->send(new VerifikasiEmailSiswaMail($user, $verificationUrl));

        return back()->with('success', 'Link verifikasi baru telah berhasil dikirim ke email: ' . $profile->email);
    } catch (\Exception $e) {
        Log::error('Gagal kirim ulang email verifikasi: ' . $e->getMessage());
        return back()->with('error', 'Gagal mengirim email verifikasi. Silakan coba lagi nanti.');
    }
}
}