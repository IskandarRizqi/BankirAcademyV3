<?php

namespace App\Http\Controllers\MemberNonAnggota;

use App\Http\Controllers\Controller;
use App\Models\LokerModel;
use App\Models\PerusahaanModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Throwable;

class LokerPostingController extends Controller
{
    private const ALLOWED_JOBDESK_TAGS = '<p><br><strong><em><u><ul><ol><li><blockquote>';

    public function index(Request $request)
    {
        $company = $this->requireCompleteCompany($request);
        $filters = $this->listingFilters($request);
        $lokers = $this->listingQuery($request, $company)
            ->when($filters['q'] !== '', fn (Builder $query) => $query->where('title', 'like', '%'.$filters['q'].'%'))
            ->when($filters['periode_dari'], function (Builder $query, string $date) {
                $query->where(function (Builder $periodQuery) use ($date) {
                    $periodQuery->whereNull('tanggal_akhir')
                        ->orWhereDate('tanggal_akhir', '>=', $date);
                });
            })
            ->when($filters['periode_sampai'], function (Builder $query, string $date) {
                $query->where(function (Builder $periodQuery) use ($date) {
                    $periodQuery->whereNull('tanggal_awal')
                        ->orWhereDate('tanggal_awal', '<=', $date);
                });
            })
            ->when($filters['status'] !== '', fn (Builder $query) => $query->where('status', $filters['status']))
            ->orderByDesc('tanggal_awal')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('membernonkeanggotaan.pages.loker.posting.index', [
            'company' => $company,
            'lokers' => $lokers,
            'filters' => $filters,
        ]);
    }

    private function listingQuery(Request $request, PerusahaanModel $company): Builder
    {
        return LokerModel::query()
            ->where('user_id', $request->user()->id)
            ->where('perusahaan_id', $company->id);
    }

    private function listingFilters(Request $request): array
    {
        $status = (string) $request->query('status', '');

        return [
            'q' => mb_substr(trim((string) $request->query('q', '')), 0, 100),
            'periode_dari' => $this->validDateFilter($request->query('periode_dari')),
            'periode_sampai' => $this->validDateFilter($request->query('periode_sampai')),
            'status' => in_array($status, ['0', '1'], true) ? $status : '',
        ];
    }

    private function validDateFilter($value): ?string
    {
        if (! $value) {
            return null;
        }

        try {
            return Carbon::createFromFormat('Y-m-d', (string) $value)->format('Y-m-d');
        } catch (Throwable) {
            return null;
        }
    }

    public function create(Request $request)
    {
        $company = $this->requireCompleteCompany($request);

        return view('membernonkeanggotaan.pages.loker.posting.form', [
            'company' => $company,
            'loker' => null,
            'skills' => $this->tagOptions('skill'),
            'types' => $this->tagOptions('type'),
        ]);
    }

    public function store(Request $request)
    {
        $company = $this->requireCompleteCompany($request);
        $validated = $this->validateLoker($request);

        LokerModel::create($this->lokerAttributes($request, $company, $validated));

        return redirect()
            ->route('membernonanggota.loker.manage.index')
            ->with('success', 'Lowongan berhasil dikirim dan sedang menunggu approval.');
    }

    public function edit(Request $request, int $id)
    {
        $company = $this->requireCompleteCompany($request);
        $loker = $this->ownedLoker($request, $company, $id);

        return view('membernonkeanggotaan.pages.loker.posting.form', [
            'company' => $company,
            'loker' => $loker,
            'skills' => $this->tagOptions('skill'),
            'types' => $this->tagOptions('type'),
        ]);
    }

    public function update(Request $request, int $id)
    {
        $company = $this->requireCompleteCompany($request);
        $loker = $this->ownedLoker($request, $company, $id);
        $validated = $this->validateLoker($request);

        $loker->update($this->lokerAttributes($request, $company, $validated));

        return redirect()
            ->route('membernonanggota.loker.manage.index')
            ->with('success', 'Lowongan berhasil diperbarui dan dikirim kembali untuk approval.');
    }

    public function destroy(Request $request, int $id)
    {
        $company = $this->requireCompleteCompany($request);
        $loker = $this->ownedLoker($request, $company, $id);

        if ((int) $loker->status !== 0) {
            return back()->with('error', 'Lowongan yang sudah disetujui tidak dapat dihapus.');
        }

        $loker->delete();

        return back()->with('success', 'Lowongan berhasil dihapus.');
    }

    private function requireCompleteCompany(Request $request): PerusahaanModel
    {
        $company = PerusahaanModel::where('user_id', $request->user()->id)->first();

        if (! $company || ! $company->isComplete()) {
            redirect()
                ->route('membernonanggota.loker.manage.company.edit')
                ->with('info', 'Lengkapi data perusahaan terlebih dahulu sebelum mengelola lowongan.')
                ->throwResponse();
        }

        return $company;
    }

    private function ownedLoker(Request $request, PerusahaanModel $company, int $id): LokerModel
    {
        return LokerModel::query()
            ->where('id', $id)
            ->where('user_id', $request->user()->id)
            ->where('perusahaan_id', $company->id)
            ->firstOrFail();
    }

    private function validateLoker(Request $request): array
    {
        $payload = $request->all();
        $payload['gaji_min'] = $this->normalizeRupiah($request->input('gaji_min'));
        $payload['jobdesk'] = $this->sanitizeJobdesk((string) $request->input('jobdesk'));

        $validator = Validator::make($payload, [
            'title' => ['required', 'string', 'max:255'],
            'gaji_min' => ['required', 'numeric', 'min:0'],
            'deskripsi' => ['required', 'string', 'max:10000'],
            'jobdesk' => ['required', 'string', 'max:10000'],
            'tanggal_awal' => ['required', 'date'],
            'tanggal_akhir' => ['required', 'date', 'after_or_equal:tanggal_awal'],
            'skill' => ['required', 'array', 'min:1'],
            'skill.*' => ['required', 'string', 'max:100', 'distinct'],
            'type' => ['required', 'array', 'min:1'],
            'type.*' => ['required', 'string', 'max:100', 'distinct'],
        ]);

        if ($validator->fails()) {
            back()
                ->withInput()
                ->withErrors($validator)
                ->with('error', 'Periksa kembali data lowongan yang Anda masukkan.')
                ->throwResponse();
        }

        return $validator->validated();
    }

    private function lokerAttributes(
        Request $request,
        PerusahaanModel $company,
        array $validated
    ): array {
        return [
            'user_id' => $request->user()->id,
            'title' => $validated['title'],
            'gaji_min' => $validated['gaji_min'],
            'gaji_max' => 0,
            'deskripsi' => $validated['deskripsi'],
            'jobdesk' => $validated['jobdesk'],
            'tanggal_awal' => $validated['tanggal_awal'],
            'tanggal_akhir' => $validated['tanggal_akhir'],
            'skill' => json_encode(array_values($validated['skill'])),
            'type' => json_encode(array_values($validated['type'])),
            'perusahaan_id' => $company->id,
            'status' => 0,
        ];
    }

    private function tagOptions(string $column): array
    {
        return LokerModel::query()
            ->whereNotNull($column)
            ->pluck($column)
            ->flatMap(function ($value) {
                $decoded = json_decode((string) $value, true);

                return is_array($decoded) ? $decoded : Arr::wrap($value);
            })
            ->filter(fn ($value) => filled($value))
            ->map(fn ($value) => (string) $value)
            ->unique()
            ->sort()
            ->values()
            ->all();
    }

    private function normalizeRupiah($value): ?int
    {
        $digits = preg_replace('/[^0-9]/', '', (string) $value);

        return $digits === '' ? null : (int) $digits;
    }

    private function sanitizeJobdesk(string $value): string
    {
        $sanitized = strip_tags($value, self::ALLOWED_JOBDESK_TAGS);

        return trim((string) preg_replace_callback(
            '/<\s*(\/?)\s*(p|br|strong|em|u|ul|ol|li|blockquote)(?:\s+[^>]*)?\s*\/?>/i',
            fn (array $matches) => '<'.($matches[1] === '/' ? '/' : '').strtolower($matches[2]).'>',
            $sanitized
        ));
    }
}
