<?php

namespace App\Helper;

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
            if ($auth->profile) {
                // if ($auth->profile['status_membership'] == 1) {
                //     $next = true;
                // }
                $next = $auth->profile['status_membership'];
            }
        }
        return $next;
    }
}
