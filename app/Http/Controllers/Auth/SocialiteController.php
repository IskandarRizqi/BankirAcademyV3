<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\InstructorModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{

    public function redirectToProvider($provider, Request $request)
    {
        $ins = false;
        if ($request->ins) {
            $ins = true;
        }
        session(['ins' => $ins]);
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $ins = Session::get('ins');
        $user = Socialite::driver($provider)->user();
        $authUser = $this->findOrCreateUser($user, $provider, $ins);
        Auth::login($authUser, true);
        return redirect('/');
    }

    public function findOrCreateUser($socialUser, $provider, $ins)
    {
        // $socialAccount = SocialAccount::where('provider_id', $socialUser->getId())
        //     ->where('provider_name', $provider)
        //     ->first();

        // if ($socialAccount) {

        //     return $socialAccount->user;

        // } else {


        // }
        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'google_id'  => $socialUser->getId(),
                'name'  => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'role' => $ins ? 3 : 2
            ]);

            if ($ins) {
                InstructorModel::create([
                    'name' => $socialUser->getName(),
                    'title' => 0,
                    'picture' => $socialUser->getAvatar(),
                    'desc' => 0,
                    'user_id' => $user->id,
                    'status' => 1,
                    'dokumen' => 0,
                    'alamat' => 0,
                    'nohp' => 0,
                ]);
            }
        }

        // $user->socialAccounts()->create([
        //     'provider_id'   => $socialUser->getId(),
        //     'provider_name' => $provider
        // ]);

        return $user;
    }
}
