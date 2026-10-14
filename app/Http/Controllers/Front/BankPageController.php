<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\PaymentController;
use App\Models\ClassesModel;
use App\Models\User;
use App\Models\UserProfileModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class BankPageController
{
    public function show(Request $request)
    {
        $view = $request->route('frontendView');

        return view($view);
    }

    public function classPage(Request $request, string $slug)
    {
        [$class, $relatedClasses] = $this->classPageData($slug);

        return view('frontend.pages.kelas.detail', compact('class', 'relatedClasses'));
    }

    public function landingPage(Request $request, string $slug)
    {
        [$class, $relatedClasses] = $this->classPageData($slug);

        abort_unless($class->landing_page_enabled, 404);

        return view('frontend.pages.kelas.landing', compact('class', 'relatedClasses'));
    }

    public function checkout(Request $request, string $slug)
    {
        $class = ClassesModel::query()
            ->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        abort_unless($class->landing_page_enabled, 404);

        if (! Auth::check()) {
            $account = $request->validate([
                'nama_pendaftar' => ['required', 'string', 'max:255'],
                'email_pendaftar' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
                'nomor_handphone' => ['required', 'string', 'max:30'],
                'password' => ['required', 'string', 'min:8'],
            ], [
                'email_pendaftar.unique' => 'Email ini sudah terdaftar. Silakan masuk terlebih dahulu untuk melanjutkan.',
                'password.min' => 'Password minimal terdiri dari 8 karakter.',
            ]);

            $user = DB::transaction(function () use ($account) {
                $user = User::create([
                    'name' => $account['nama_pendaftar'],
                    'email' => $account['email_pendaftar'],
                    'role' => 2,
                    'password' => Hash::make($account['password']),
                ]);

                UserProfileModel::create([
                    'user_id' => $user->id,
                    'name' => $account['nama_pendaftar'],
                    'phone_region' => '+62',
                    'phone' => UserProfileModel::normalizePhone($account['nomor_handphone']),
                    'gender' => 1,
                ]);

                return $user;
            });

            Auth::login($user);
        }

        $request->merge([
            'class_id' => $class->id,
            'jml_peserta' => 1,
            'nama' => [$request->input('nama_pendaftar', Auth::user()->name)],
            'email' => [$request->input('email_pendaftar', Auth::user()->email)],
            'nomor_handphone' => [$request->input('nomor_handphone', optional(Auth::user()->userProfile)->phone)],
            'sertifikat_invoice' => $request->input('sertifikat_invoice', '1'),
            'payment_method' => 'gateway',
        ]);

        return app(PaymentController::class)->paymentorderclass($request);
    }

    private function classPageData(string $slug): array
    {
        $now = Carbon::now();
        $class = ClassesModel::query()
            ->where('slug', $slug)
            ->where('status', 1)
            ->with('pricingData')
            ->firstOrFail();
        $relatedClasses = ClassesModel::query()
            ->landingVisible($now)
            ->where('id', '!=', $class->id)
            ->with('pricingData')
            ->orderBy('date_end', 'asc')
            ->take(3)
            ->get();

        return [$class, $relatedClasses];
    }
}
