<?php

namespace App\Http\Controllers\MemberNonAnggota;

use App\Http\Controllers\Controller;
use App\Mail\ApplicationSubmittedMail;
use App\Models\DataPayment;
use App\Models\LamaranModel;
use App\Models\LokerApply;
use App\Models\LokerModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LokerController extends Controller
{
    private const PAGE_SIZE = 9;

    public function index(Request $request)
    {
        $filters = $this->filters($request);
        $query = $this->activeLokerQuery();
        $this->applyFilters($query, $filters);
        $isMember = $this->hasActiveMembership($request->user());
        $limit = (int) config('app.loker_non_membership_limit', 10);

        $this->applyOrdering($query);

        $lokers = $isMember
            ? $query->paginate(self::PAGE_SIZE)->withQueryString()
            : $query->limit(max(0, $limit))->get();
        $lokerSkeletonCount = !$isMember && $limit > 0 && $lokers->count() === $limit
            ? (3 - ($lokers->count() % 3)) % 3
            : 0;

        if ($isMember && $request->ajax()) {
            return response()->json([
                'html' => view('membernonkeanggotaan.components.ui.loker-card-items', [
                    'lokers' => $lokers,
                ])->render(),
                'next_page_url' => $lokers->nextPageUrl(),
                'has_more_pages' => $lokers->hasMorePages(),
            ]);
        }

        return view('membernonkeanggotaan.pages.loker.index', [
            'lokers' => $lokers,
            'filters' => $filters,
            'filterOptions' => $this->filterOptions(),
            'provinces' => $this->provinceOptions(),
            'selectedProvinceName' => $this->provinceName($filters['provinsi']),
            'selectedCityName' => $this->cityName($filters['kabupaten'], $filters['provinsi']),
            'isMember' => $isMember,
            'nonMembershipLimit' => $limit,
            'lokerSkeletonCount' => $lokerSkeletonCount,
        ]);
    }

    public function cities(Request $request)
    {
        $provinceId = (int) $request->query('provinsi_id');
        $search = trim((string) $request->query('q', ''));

        if ($provinceId < 1) {
            return response()->json([
                'results' => [],
                'pagination' => ['more' => false],
            ]);
        }

        $cities = DB::table('kota')
            ->where('provinsi_id', $provinceId)
            ->when($search !== '', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('name')
            ->paginate(20);

        return response()->json([
            'results' => $cities->getCollection()
                ->map(fn($city) => [
                    'id' => $city->id,
                    'text' => $city->name,
                ])
                ->values(),
            'pagination' => [
                'more' => $cities->hasMorePages(),
            ],
        ]);
    }

    public function show(Request $request, int $id)
    {
        $isMember = $this->hasActiveMembership($request->user());
        $nonMemberIds = $isMember ? collect() : $this->nonMemberLokerIds();
        $query = $this->activeLokerQuery()->where('loker.id', $id);

        if (! $isMember) {
            $query->whereIn('loker.id', $nonMemberIds);
        }

        $loker = $query->firstOrFail();
        $relatedQuery = $this->activeLokerQuery()->where('loker.id', '!=', $loker->id);

        if (! $isMember) {
            $relatedQuery->whereIn('loker.id', $nonMemberIds);
        }

        if ($loker->perusahaan_id) {
            $relatedQuery->where('loker.perusahaan_id', $loker->perusahaan_id);
        }

        $relatedLokers = $relatedQuery->limit(3)->get();

        return view('membernonkeanggotaan.pages.loker.detail', [
            'loker' => $loker,
            'relatedLokers' => $relatedLokers,
            'canApply' => $this->hasActiveIndividualMembership($request->user()),
        ]);
    }

    public function applyPreview(Request $request, int $id)
    {
        if (! $this->hasActiveIndividualMembership($request->user())) {
            return redirect()->route('dash-beranda.index')
                ->with('error', 'Fitur lamaran hanya tersedia untuk member perorangan aktif.');
        }

        $loker = $this->activeLokerQuery()
            ->where('loker.id', $id)
            ->firstOrFail();

        $cv = LamaranModel::query()
            ->where('user_id', $request->user()->id)
            ->where('is_cv_ats', true)
            ->first();

        if (! $cv) {
            return redirect()->route('membernonanggota.cv-ats.create')
                ->with('info', 'Silakan buat CV ATS terlebih dahulu sebelum melamar.');
        }

        // Ambil lamaran terakhir user untuk loker ini
        $lastApply = LokerApply::query()
            ->where('user_id', $request->user()->id)
            ->where('loker_id', $loker->id)
            ->latest('created_at')
            ->first();

        $alreadyApplied = false;
        $nextApplyDate = null;

        if ($lastApply) {
            // Hitung selisih hari dari lamaran terakhir
            $daysDiff = $lastApply->created_at->diffInDays(now());

            // Jika belum melewati 15 hari, tandai bahwa user belum bisa melamar lagi
            if ($daysDiff < 15) {
                $alreadyApplied = true;
                // Hitung tanggal kapan user boleh melamar kembali
                $nextApplyDate = $lastApply->created_at->addDays(15);
            }
        }
        // if ($lastApply) {
        //     // Hitung selisih menit dari lamaran terakhir
        //     $minutesDiff = $lastApply->created_at->diffInMinutes(now());

        //     // Jika belum melewati 15 menit, tandai bahwa user belum bisa melamar lagi
        //     if ($minutesDiff < 1) {
        //         $alreadyApplied = true;
        //         // Hitung waktu kapan user boleh melamar kembali
        //         $nextApplyDate = $lastApply->created_at->addMinutes(1);
        //     }
        // }


        return view('membernonkeanggotaan.pages.loker.apply-preview', [
            'loker' => $loker,
            'cv' => $cv,
            'alreadyApplied' => $alreadyApplied,
            'nextApplyDate' => $nextApplyDate, // <-- Variabel baru untuk tanggal bisa apply lagi
        ]);
    }

    public function submitApplication(Request $request, int $id)
    {
        if (! $this->hasActiveIndividualMembership($request->user())) {
            return redirect()->route('dash-beranda.index')
                ->with('error', 'Fitur lamaran hanya tersedia untuk member perorangan aktif.');
        }

        $loker = $this->activeLokerQuery()
            ->where('loker.id', $id)
            ->firstOrFail();

        $masterCv = LamaranModel::query()
            ->where('user_id', $request->user()->id)
            ->where('is_cv_ats', true)
            ->first();

        if (! $masterCv) {
            return redirect()->route('membernonanggota.cv-ats.create')
                ->with('info', 'Silakan buat CV ATS terlebih dahulu sebelum melamar.');
        }

        // Pengecekan Keamanan Backend (Jeda 15 Hari)
        $lastApply = LokerApply::query()
            ->where('user_id', $request->user()->id)
            ->where('loker_id', $loker->id)
            ->latest('created_at')
            ->first();

        if ($lastApply && $lastApply->created_at->diffInDays(now()) < 15) {
            $nextDate = $lastApply->created_at->addDays(15)->translatedFormat('d F Y');
            return redirect()->route('membernonanggota.loker.history')
                ->with('error', "Anda sudah melamar posisi ini. Anda baru dapat melamar kembali pada tanggal {$nextDate}.");
        }
        // if ($lastApply && $lastApply->created_at->diffInMinutes(now()) < 1) {
        //     $nextDate = $lastApply->created_at->addMinutes(1)->translatedFormat('d F Y, H:i');

        //     return redirect()->route('membernonanggota.loker.history')
        //         ->with('error', "Anda sudah melamar posisi ini. Anda baru dapat melamar kembali pada {$nextDate} WIB.");
        // }

        // Simpan Lamaran Baru
        DB::transaction(function () use ($request, $loker, $masterCv) {
            $jobApplicationCv = $masterCv->replicate();
            $jobApplicationCv->job_id = $loker->id;
            $jobApplicationCv->is_cv_ats = null;
            $jobApplicationCv->save();

            LokerApply::create([
                'loker_id' => $loker->id,
                'user_id'  => $request->user()->id,
                'status'   => 0,
            ]);
        });

        return redirect()->route('membernonanggota.loker.history')
            ->with('success', 'Lamaran Anda berhasil dikirim');
    }

    public function history(Request $request)
    {
        if (! $this->hasActiveIndividualMembership($request->user())) {
            return redirect()->route('dash-beranda.index')
                ->with('error', 'Riwayat lamaran hanya tersedia untuk member perorangan aktif.');
        }

        $applications = LokerApply::query()
            ->with('loker')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('membernonkeanggotaan.pages.loker.history', [
            'applications' => $applications,
        ]);
    }

    private function activeLokerQuery(): Builder
    {
        return LokerModel::query()
            ->leftJoin('perusahaan_models', 'perusahaan_models.id', '=', 'loker.perusahaan_id')
            ->select('loker.*')
            ->where('loker.status', 1)
            ->where(function (Builder $query) {
                $query->whereNull('loker.tanggal_awal')
                    ->orWhereDate('loker.tanggal_awal', '<=', now());
            })
            ->where(function (Builder $query) {
                $query->whereNull('loker.tanggal_akhir')
                    ->orWhereDate('loker.tanggal_akhir', '>=', now());
            });
    }

    private function applyFilters(Builder $query, array $filters): void
    {
        if ($filters['q'] !== '') {
            $query->where(function (Builder $searchQuery) use ($filters) {
                $searchQuery->where('loker.title', 'like', '%' . $filters['q'] . '%')
                    ->orWhere('loker.nama', 'like', '%' . $filters['q'] . '%')
                    ->orWhere('perusahaan_models.nama', 'like', '%' . $filters['q'] . '%');
            });
        }

        if ($filters['type'] !== '') {
            $query->whereJsonContains('loker.type', $filters['type']);
        }

        if ($filters['skill'] !== '') {
            $query->whereJsonContains('loker.skill', $filters['skill']);
        }

        if ($filters['provinsi'] !== '') {
            $query->where(function (Builder $locationQuery) use ($filters) {
                $locationQuery->where('loker.provinsi', $filters['provinsi'])
                    ->orWhere('perusahaan_models.provinsi', $filters['provinsi']);
            });
        }

        if ($filters['kabupaten'] !== '') {
            $query->where(function (Builder $locationQuery) use ($filters) {
                $locationQuery->where('loker.kabupaten', $filters['kabupaten'])
                    ->orWhere('perusahaan_models.kabupaten', $filters['kabupaten']);
            });
        }
    }

    private function applyOrdering(Builder $query): void
    {
        $query
            ->orderByRaw('CASE WHEN loker.tanggal_akhir IS NULL THEN 1 ELSE 0 END')
            ->orderBy('loker.tanggal_akhir')
            ->orderByDesc('loker.created_at')
            ->orderByDesc('loker.id');
    }

    private function filters(Request $request): array
    {
        return [
            'q' => trim((string) $request->query('q', '')),
            'type' => $this->filterValue($request->query('type')),
            'skill' => $this->filterValue($request->query('skill')),
            'provinsi' => $this->filterValue($request->query('provinsi')),
            'kabupaten' => $this->filterValue($request->query('kabupaten')),
        ];
    }

    private function filterValue($value): string
    {
        if (is_array($value)) {
            $value = Arr::first($value);
        }

        return trim((string) $value);
    }

    private function filterOptions(): array
    {
        $rows = $this->activeLokerQuery()
            ->select([
                'loker.type',
                'loker.skill',
            ])
            ->get();

        return [
            'type' => $this->jsonOptions($rows->pluck('type')),
            'skill' => $this->jsonOptions($rows->pluck('skill')),
        ];
    }

    private function provinceOptions(): Collection
    {
        return DB::table('provinsi')
            ->select(['id', 'name'])
            ->orderBy('name')
            ->get();
    }

    private function provinceName(string $provinceId): ?string
    {
        if ($provinceId === '') {
            return null;
        }

        return DB::table('provinsi')
            ->where('id', $provinceId)
            ->value('name');
    }

    private function cityName(string $cityId, string $provinceId): ?string
    {
        if ($cityId === '') {
            return null;
        }

        return DB::table('kota')
            ->when($provinceId !== '', fn($query) => $query->where('provinsi_id', $provinceId))
            ->where('id', $cityId)
            ->value('name');
    }

    private function jsonOptions(Collection $values): array
    {
        return $values
            ->flatMap(function ($value) {
                $decoded = json_decode((string) $value, true);

                return is_array($decoded) ? $decoded : Arr::wrap($value);
            })
            ->filter(fn($value) => $value !== null && $value !== '')
            ->map(fn($value) => (string) $value)
            ->unique()
            ->sort()
            ->mapWithKeys(fn($value) => [$value => $this->formatOptionLabel($value)])
            ->all();
    }

    private function formatOptionLabel(string $value): string
    {
        return ucwords(strtolower(str_replace(['_', '-'], ' ', $value)));
    }

    private function hasActiveMembership(User $user): bool
    {
        $profile = $user->profile;

        if (! $profile || (int) $profile->status_membership !== DataPayment::STATUS_PAID) {
            return false;
        }

        return ! $profile->masa_aktif_membership
            || Carbon::parse($profile->masa_aktif_membership)->endOfDay()->isFuture();
    }

    private function hasActiveIndividualMembership(User $user): bool
    {
        $profile = $user->profile;

        return $profile
            && (int) $profile->tipe_membership === DataPayment::MEMBERSHIP_TYPE_INDIVIDUAL
            && $this->hasActiveMembership($user);
    }

    private function nonMemberLokerIds(): Collection
    {
        $limit = max(0, (int) config('app.loker_non_membership_limit', 10));
        $query = $this->activeLokerQuery();

        $this->applyOrdering($query);

        return $query->limit($limit)->pluck('loker.id');
    }
}
