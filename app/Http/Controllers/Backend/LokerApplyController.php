<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\ApplicationSubmittedMail;
use App\Models\LamaranModel;
use App\Models\LokerApply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Throwable;

class LokerApplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = [];
        // Eager load relasi lamaran, user, serta data wilayah pendukung
        $data['data'] = LokerApply::with([
            'lamaran.perusahaan',
            'user',
        ])->latest()->get();

        $cvIds = LamaranModel::query()
            ->whereIn('user_id', $data['data']->pluck('user_id')->unique())
            ->whereIn('job_id', $data['data']->pluck('loker_id')->unique())
            ->whereNull('is_cv_ats')
            ->get()
            ->groupBy(fn (LamaranModel $cv) => $cv->user_id.'_'.$cv->job_id)
            ->map(fn ($cvs) => $cvs->sortByDesc('id')->first()->id);

        $data['data']->each(function (LokerApply $application) use ($cvIds) {
            $application->setAttribute(
                'application_cv_id',
                $cvIds->get($application->user_id.'_'.$application->loker_id),
            );
        });

        return view('backend.loker.list', $data);
    }

    public function sendApplication(Request $request, int $id)
    {
        $application = LokerApply::with(['loker.perusahaan', 'user'])->findOrFail($id);

        if ((int) $application->status === 1) {
            return Redirect::back()->with('info', 'Lamaran ini sudah dikirim ke perusahaan.');
        }

        if ($application->review_status === LokerApply::REVIEW_REJECTED) {
            return Redirect::back()->with('error', 'Lamaran yang sudah ditolak tidak dapat dikirim.');
        }

        $loker = $application->loker;
        $company = $loker?->perusahaan;
        $recipient = trim((string) ($company?->email ?: $loker?->email));

        if (! filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            return Redirect::back()->with('error', 'Email perusahaan belum tersedia atau tidak valid.');
        }

        $cv = LamaranModel::query()
            ->where('user_id', $application->user_id)
            ->where('job_id', $application->loker_id)
            ->whereNull('is_cv_ats')
            ->latest('id')
            ->first();

        if (! $cv) {
            return Redirect::back()->with('error', 'CV khusus lamaran tidak ditemukan.');
        }

        try {
            Mail::to($recipient)->send(new ApplicationSubmittedMail($cv, $loker));
        } catch (Throwable $exception) {
            report($exception);

            try {
                $application->update(['send_error' => $exception->getMessage()]);
            } catch (Throwable $loggingException) {
                report($loggingException);
            }

            return Redirect::back()->with('error', 'Email gagal dikirim. Periksa konfigurasi email lalu coba lagi.');
        }

        Log::info('Lamaran diterima server SMTP', [
            'application_id' => $application->id,
            'recipient' => $recipient,
            'mailer' => config('mail.default'),
        ]);

        $application->update([
            'status' => 1,
            'review_status' => LokerApply::REVIEW_APPROVED,
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
            'sent_at' => now(),
            'send_error' => null,
        ]);
        $cv->update(['status' => 1]);

        return Redirect::back()->with(
            'success',
            "Lamaran diterima server email untuk {$recipient}. Jika belum terlihat, periksa folder Spam/Promosi.",
        );
    }

    public function rejectApplication(Request $request, int $id)
    {
        $application = LokerApply::findOrFail($id);

        if ((int) $application->status === 1) {
            return Redirect::back()->with('error', 'Lamaran yang sudah terkirim tidak dapat ditolak.');
        }

        $application->update([
            'review_status' => LokerApply::REVIEW_REJECTED,
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
            'send_error' => null,
        ]);

        return Redirect::back()->with('success', 'Lamaran ditandai sebagai ditolak.');
    }

    public function getdatacvpelamar()
    {
        $data['data'] = LamaranModel::select(
            'lamaran_models.*',
            'users.email',
            'users.name',
        )
            ->join('users', 'users.id', 'lamaran_models.user_id')
            ->get();

        return view('backend.loker.cvpelamar', $data);
    }

    public function approvecvpelamar(Request $r)
    {
        $u = LamaranModel::where('id', $r->id)
            ->update([
                'is_approved' => $r->approved,
                'is_approved_message' => $r->approved_message,
            ]);
        if ($u) {
            return Redirect::back()->with('success', 'Data CV Tersimpan');
        }

        return Redirect::back()->with('error', 'Data Tidak CV Tersimpan');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
