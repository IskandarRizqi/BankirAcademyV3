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
use Illuminate\Support\Str;
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
                'nomor_handphone_pendaftar' => ['required', 'string', 'max:30'],
            ], [
                'email_pendaftar.unique' => 'Email ini sudah terdaftar. Silakan masuk terlebih dahulu untuk melanjutkan.',
            ]);

            $user = DB::transaction(function () use ($account) {
                $user = User::create([
                    'name' => $account['nama_pendaftar'],
                    'email' => $account['email_pendaftar'],
                    'role' => 2,
                    // Akun tetap dapat dipakai oleh alur autentikasi, tetapi password
                    // tidak perlu diminta dari peserta saat checkout.
                    'password' => Hash::make(Str::random(40)),
                ]);

                UserProfileModel::create([
                    'user_id' => $user->id,
                    'name' => $account['nama_pendaftar'],
                    'phone_region' => '+62',
                    'phone' => UserProfileModel::normalizePhone($account['nomor_handphone_pendaftar']),
                    'gender' => 1,
                ]);

                return $user;
            });

            Auth::login($user);
        }

        $user = Auth::user();
        $phone = $request->validate([
            'nomor_handphone_pendaftar' => ['required', 'string', 'max:30'],
        ])['nomor_handphone_pendaftar'];

        UserProfileModel::updateOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $user->name,
                'phone_region' => '+62',
                'phone' => UserProfileModel::normalizePhone($phone),
                'gender' => 1,
            ]
        );

        $request->merge([
            'class_id' => $class->id,
            'jml_peserta' => 1,
            'nama' => [$user->name],
            'email' => [$user->email],
            'nomor_handphone' => [$phone],
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
