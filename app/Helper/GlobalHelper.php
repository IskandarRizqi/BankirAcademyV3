<?php

namespace App\Helper;

use App\Jobs\SendUserActivationEmail;
use App\Models\AllowIpAksesModel;
use App\Models\ClassParticipantModel;
use App\Models\HistoryIpAksesModel;
use App\Models\LokerApply;
use App\Models\RefferralModel;
use App\Models\RefferralWithdrawModel;
use App\Models\UserProfileModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class  GlobalHelper
{
    public static function userProfilePictureUrl($profile = null, string $fallback = 'assets/img/90x90.jpg'): string
    {
        $picture = is_string($profile) ? $profile : data_get($profile, 'picture');
        $picture = self::normalizeProfilePicturePath($picture);

        if ($picture === '') {
            return asset($fallback);
        }

        if (filter_var($picture, FILTER_VALIDATE_URL) || str_starts_with($picture, 'data:image/')) {
            return $picture;
        }

        $picture = ltrim($picture, '/');

        return asset(str_starts_with($picture, 'Image/') ? $picture : 'Image/' . $picture);
    }

    private static function normalizeProfilePicturePath($picture): string
    {
        $picture = trim((string) $picture);

        if ($picture === '') {
            return '';
        }

        $decoded = json_decode($picture, true);

        if (is_array($decoded)) {
            $picture = data_get($decoded, 'url') ?: data_get($decoded, 'path') ?: '';
        } elseif (is_string($decoded)) {
            $picture = $decoded;
        }

        return trim((string) $picture, " \t\n\r\0\x0B\"'");
    }

    public static function namabulan($n)
    {
        $bulan = [
            '',
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];
        return $bulan[$n];
    }
    public static function currentSaldoKreditById($i)
    {
        $s = [];
        $amount = 0;
        $cashback = ClassParticipantModel::select()
            ->join('class_pricing', 'class_pricing.class_id', 'class_participant.class_id')
            ->where('class_participant.user_id', $i)
            ->get();
        foreach ($cashback as $key => $value) {
            if ($value->gratis == 1) {
                $amount += $value->cashback_nominal;
            }
        }
        $r = RefferralModel::where('user_aplicator', $i)->where('available', 1)->sum('total');
        if ($r) {
            $amount += $r;
        }
        $s['amount'] = $amount;
        return $s;
    }
    public static function currentSaldoById($i)
    {
        // return $i;
        if ($i) {
            $r = RefferralModel::where('user_id', $i)->where('available', 1)->sum('total');
            $rw = RefferralWithdrawModel::where('user_id', $i)->where('status', 3)->sum('acc_amount');
            // return [$r, $rw];
            return $r - $rw;
        }
        return 0;
    }
    public static function currentSaldoPenarikanById($i)
    {
        if ($i) {
            $rw = RefferralWithdrawModel::where('user_id', $i)->where('status', 3)->sum('acc_amount');
            return $rw;
        }
        return 0;
    }
    public static function countSaldoProsesById($i)
    {
        if ($i) {
            $hl = Carbon::now()->subDays(3);
            $r = RefferralModel::where('user_id', $i)->where('available', 1)->where('updated_at', '>', $hl)->sum('total');
            return $r;
        }
        return 0;
    }
    public static function countReferralDeAvailableById($i)
    {
        if ($i) {
            $r = RefferralModel::where('user_id', $i)->where('available', 1)->sum('total');
            return $r;
        }
        return 0;
    }
    public static function countApplyByUserId($i)
    {
        $auth = Auth::user()->id;
        if ($i) {
            $auth = $i;
        }
        $r = LokerApply::where('user_id', $auth)->get();
        return [
            'jumlah' => count($r),
            'data' => $r,
        ];
    }
    public static function getaksesmembership()
    {
        $auth = Auth::user();
        $next = 0;
        if ($auth) {
            $next = 1;
            if ($auth->corporate == null || $auth->corporate == 'perorangan') {
                $next = 0;
                if ($auth->profile) {
                    $next = $auth->profile['status_membership'];
                }
            }
            if ($auth->role == 0) {
                $next = 1;
            }
        }
        // return 1;
        return $next;
    }
    public static function isperusahaan()
    {
        $p = true;
        if (Auth::user()->corporate == null || Auth::user()->corporate == 'perorangan') {
            $p = false;
        }
        return $p;
    }
    public static function getlimitlokermember()
    {
        $limit = 0;
        $message = 'Profile Belum Lengkap';
        $status = false;
        $p = UserProfileModel::where('user_id', Auth::user()->id)->first();
        if ($p) {
            $status = false;
            $message = 'Belum menjadi member';
            if ($p->membership) {
                $limit = $p->membership->limit;
                $message = '';
                $status = true;
            }
        }
        return [
            'limit' => $limit,
            'message' => $message,
            'status' => $status,
        ];
    }
    public static function checkipaddress()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    public static function getipaddress()
    {
        $a = new GlobalHelper;
        $ipaddress = $a->checkipaddress();
        $akses = AllowIpAksesModel::where('ip', $ipaddress)->first();
        return $akses ? $akses->id : false;
    }
    public static function sethistoryip($model, $desk)
    {
        $a = new GlobalHelper;
        $i = $a->getipaddress();
        return HistoryIpAksesModel::create([
            'ip_id' => $i,
            'model' => $model,
            'deskripsi' => $desk,
        ]);
    }
    public static function sendEmailActivation($userId, $scope = 'default')
    {
        Log::info('sendEmailActivation', $userId);
        $userIds = collect($userId)->unique()->values();
        /*
        * Single user
        */
        if ($userIds->count() === 1) {
            $activationId = (string) Str::uuid();

            SendUserActivationEmail::dispatch(
                activationId: $activationId,
                userId: (int) $userIds->first(),
                scope: $scope,
            );

            return [
                'success' => true,
                'message' => 'Email aktivasi masuk ke antrean.',
                'mode' => 'single',
                'activation_id' => $activationId,
                'batch_id' => null,
                'total' => 1,
            ];
        }

        /*
         * Multi-user
         */
        $jobs = $userIds
            ->values()
            ->map(function ($userId, $index) use ($scope) {
                return (new SendUserActivationEmail(
                    activationId: (string) Str::uuid(),
                    userId: (int) $userId,
                    scope: $scope,
                ))->delay(now()->addMinutes($index));
            })
            ->all();

        $batch = Bus::batch($jobs)
            ->name('Kirim email aktivasi user')
            ->allowFailures()
            ->onQueue('activation-mails')
            ->dispatch();

        return [
            'success' => true,
            'message' => 'Batch email aktivasi masuk ke antrean.',
            'mode' => 'batch',
            'activation_id' => null,
            'batch_id' => $batch->id,
            'total' => $userIds->count(),
        ];
    }

    public static function sendWhatsappNotification($user)
    {
        // Bersihkan format nomor telepon
        $target = preg_replace('/^0/', '62', $user->siswa->no_telp);

        // Auto generate logic sesuai request
        $nisn = $user->siswa->nisn;
        $generatedEmail = $nisn . '@gmail.com';
        $generatedPassword = $nisn . 'Bankir!';

        $message = "Pesan Otomatis Bankir\n" .
            "__________________\n" .
            "Informasi Akun Siswa\n" .
            now()->format('d M Y') . "\n\n" .
            "Salam sehat\n" .
            "Yth *" . $user->name . "*,\n\n" .
            "Berikut adalah detail akun Anda:\n" .
            "Email: *" . $generatedEmail . "*\n" .
            "Password: *" . $generatedPassword . "*\n" .
            "----------------------------------------------\n" .
            "Silakan cek bankiracademy.co.id untuk detail lebih lanjut.\n" .
            "------------------------------------------\n" .
            "Copyright\n" .
            "bankiracademy.co.id | " . date('Y');

        try {
            $response = Http::withHeaders(['Authorization' => env('FONNTE_API_TOKEN')])
                ->post(env('FONNTE_BASE_URL'), [
                    'target' => $target,
                    'message' => $message,
                ]);

            return $response->successful();
        } catch (\Exception $e) {
            // Log error jika dibutuhkan: Log::error($e->getMessage());
            return false;
        }
    }
}
