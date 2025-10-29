<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\InstructorModel;
use App\Models\User;
use App\Models\UserProfileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider, Request $request)
    {
        $ins = $request->has('ins');
        session(['ins' => $ins]);
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            if (app()->environment('local')) {
                $socialUser = Socialite::driver($provider)->stateless()->user();
            } else {
                $socialUser = Socialite::driver($provider)->user();
            }
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Login Google gagal. Silakan coba lagi.');
        }

        $ins = Session::pull('ins', false);
        $user = $this->findOrCreateUser($socialUser, $provider, $ins);
        Auth::login($user, true);

        return redirect('/profile');
    }

    protected function findOrCreateUser($socialUser, $provider, $ins)
    {
        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'google_id' => $socialUser->getId(),
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'role' => $ins ? 3 : 2,
            ]);

            UserProfileModel::create([
                'user_id' => $user->id,
                'name' => $socialUser->getName(),
                'phone_region' => 62,
                'phone' => 62,
                'picture' => $socialUser->getAvatar(),
                'tanggal_lahir' => now(),
                'gender' => 1,
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

        return $user;
    }
}
