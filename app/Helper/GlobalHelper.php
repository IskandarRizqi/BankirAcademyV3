<?php

namespace App\Helper;

use App\Models\AllowIpAksesModel;
use App\Models\HistoryIpAksesModel;
use App\Models\RefferralModel;
use App\Models\RefferralWithdrawModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class  GlobalHelper
{
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
            $r = RefferralModel::where('user_id', $i)->where('available', 0)->sum('total');
            return $r;
        }
        return 0;
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
        return 1;
        return $next;
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
}
