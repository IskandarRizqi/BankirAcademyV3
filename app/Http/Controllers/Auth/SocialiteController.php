<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();
        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect('/');
    }

    public function findOrCreateUser($socialUser, $provider)
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
                'email' => $socialUser->getEmail()
            ]);
        }

        // $user->socialAccounts()->create([
        //     'provider_id'   => $socialUser->getId(),
        //     'provider_name' => $provider
        // ]);

        return $user;
    }
}
