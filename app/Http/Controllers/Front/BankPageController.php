<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\PaymentController;
use App\Models\ClassesModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

        $customer = $request->validate([
            'nama_pendaftar' => ['required', 'string', 'max:255'],
            'email_pendaftar' => ['required', 'email', 'max:255'],
            'nomor_handphone_pendaftar' => ['required', 'string', 'max:30'],
        ]);

        $request->merge([
            'class_id' => $class->id,
            'jml_peserta' => 1,
            'nama' => [$customer['nama_pendaftar']],
            'email' => [$customer['email_pendaftar']],
            'nomor_handphone' => [$customer['nomor_handphone_pendaftar']],
            'sertifikat_invoice' => '0',
            'payment_method' => 'gateway',
            'guest_checkout' => true,
            'customer_name' => $customer['nama_pendaftar'],
            'customer_email' => $customer['email_pendaftar'],
            'customer_phone' => $customer['nomor_handphone_pendaftar'],
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
