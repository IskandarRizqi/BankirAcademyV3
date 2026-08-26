<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LokerDraftTemplateExport;
use App\Http\Controllers\Controller;
use App\Imports\LokerDraftJobPlatformImport;
use App\Imports\LokerDraftSocialMediaImport;
use App\Models\LokerDraft;
use App\Models\PerusahaanModel;
use App\Services\LokerApprovalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class LokerDraftController extends Controller
{
    public function index(Request $request)
    {
        $query = LokerDraft::pending();

        if ($request->ajax()) {
            if ($request->filled('source_type')) {
                $query->where('source_type', $request->source_type);
            }

            if ($request->filled('platform')) {
                $query->where('platform', $request->platform);
            }

            if ($request->filled('gaji_min')) {
                $query->where('gaji_min', '>=', $request->gaji_min);
            }

            return DataTables::eloquent($query)
                ->filter(function ($query) use ($request) {
                    $search = trim((string) $request->input('search.value'));

                    if ($search === '') {
                        return;
                    }

                    $query->where(function ($q) use ($search) {
                        $q->where('posisi', 'like', "%{$search}%")
                            ->orWhere('nama_perusahaan', 'like', "%{$search}%")
                            ->orWhere('platform', 'like', "%{$search}%")
                            ->orWhere('provinsi_raw', 'like', "%{$search}%")
                            ->orWhere('alamat_raw', 'like', "%{$search}%")
                            ->orWhere('gaji_raw', 'like', "%{$search}%");
                    });
                }, true)
                ->addIndexColumn()
                ->addColumn('source_badge', function (LokerDraft $draft) {
                    $class = $draft->source_type === 'social_media'
                        ? 'badge badge-soft-danger'
                        : 'badge badge-soft-primary';
                    $label = $draft->source_type === 'social_media' ? 'Social Media' : 'Job Platform';

                    return '<span class="' . $class . '">' . e($label) . '</span><small class="d-block text-muted mt-1">' . e($draft->platform ?: '-') . '</small>';
                })
                ->addColumn('position_company', function (LokerDraft $draft) {
                    return '<div class="font-weight-bold text-dark">' . e($draft->posisi) . '</div>'
                        . '<small class="text-muted">' . e($draft->nama_perusahaan ?: 'Perusahaan belum diisi') . '</small>';
                })
                ->addColumn('location_display', function (LokerDraft $draft) {
                    return $draft->provinsi_raw ?: $draft->alamat_raw ?: 'Lokasi belum diisi';
                })
                ->addColumn('salary_display', function (LokerDraft $draft) {
                    return '<span class="font-weight-bold text-success">' . e($draft->gaji_raw ?: 'Kompetitif') . '</span>';
                })
                ->addColumn('type_display', function (LokerDraft $draft) {
                    return '<span class="badge badge-light border">' . e($draft->tipe_pekerjaan ?: 'Fulltime') . '</span>';
                })
                ->addColumn('posting_display', function (LokerDraft $draft) {
                    return $draft->tanggal_posting?->format('d/m/Y H:i') ?: '-';
                })
                ->addColumn('actions', function (LokerDraft $draft) {
                    $token = csrf_token();
                    $deleteUrl = route('lokerdraft.destroy', $draft->id);

                    return '<div class="btn-group btn-group-sm" role="group">'
                        . '<button type="button" class="btn btn-outline-info" data-draft-action="detail" data-draft-id="' . $draft->id . '" title="Detail"><i class="bx bx-show"></i></button>'
                        . '<button type="button" class="btn btn-outline-warning" data-draft-action="edit" data-draft-id="' . $draft->id . '" title="Edit"><i class="bx bx-edit"></i></button>'
                        . '<form action="' . $deleteUrl . '" method="POST" class="d-inline" data-delete-draft-form>'
                        . '<input type="hidden" name="_token" value="' . $token . '">'
                        . '<input type="hidden" name="_method" value="DELETE">'
                        . '<button type="button" class="btn btn-outline-danger" data-delete-draft title="Hapus"><i class="bx bx-trash"></i></button>'
                        . '</form></div>';
                })
                ->rawColumns(['source_badge', 'position_company', 'salary_display', 'type_display', 'actions'])
                ->toJson();
        }

        $platforms = LokerDraft::pending()->select('platform')->whereNotNull('platform')->distinct()->orderBy('platform')->pluck('platform');
        $provinces = DB::table('provinsi')->orderBy('name')->get(['id', 'name']);
        $sourceCounts = LokerDraft::pending()->select('source_type', DB::raw('count(*) as total'))
            ->groupBy('source_type')->pluck('total', 'source_type');

        return view('loker-draft.index', compact('platforms', 'provinces', 'sourceCounts'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'source_type' => 'required|in:social_media,job_platform',
            'platform' => 'nullable|required_if:source_type,job_platform|in:JobStreet,Glints',
            'file_excel' => 'required|mimes:xlsx,xls,csv',
        ]);

        if ($request->source_type === 'social_media') {
            Excel::import(new LokerDraftSocialMediaImport, $request->file('file_excel'));
        } else {
            Excel::import(new LokerDraftJobPlatformImport($request->platform), $request->file('file_excel'));
        }

        return redirect()->back()->with('success', 'Data draft loker berhasil diimport!');
    }

    public function downloadTemplate()
    {
        return Excel::download(new LokerDraftTemplateExport, 'template_import_loker_draft.xlsx');
    }

    public function update(Request $request, $id, LokerApprovalService $approvalService)
    {
        $draft = LokerDraft::pending()->findOrFail($id);
        $validated = $request->validate($this->editRules());
        $validated['provinsi_raw'] = filled($validated['provinsi_id'] ?? null)
            ? DB::table('provinsi')->where('id', $validated['provinsi_id'])->value('name')
            : null;
        $draft->update($validated);

        if ($request->boolean('publish_after_save')) {
            return $this->publishDraft($request, $draft, $approvalService);
        }

        return redirect()->back()->with('success', 'Draft loker berhasil diperbarui.');
    }

    public function publish(Request $request, $id, LokerApprovalService $approvalService)
    {
        $draft = LokerDraft::pending()->findOrFail($id);

        return $this->publishDraft($request, $draft, $approvalService);
    }

    private function publishDraft(Request $request, LokerDraft $draft, LokerApprovalService $approvalService)
    {
        $draftData = $draft->toArray();
        $validator = validator($draftData, $this->publishRules($draftData));
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()
                ->with('error', 'Draft belum lengkap. Lengkapi data perusahaan, wilayah, dan tanggal penutupan.');
        }

        $action = $request->input('company_action');
        if ($action !== null && ! in_array($action, ['use_existing', 'create_new'], true)) {
            return redirect()->back()->withInput()->with('error', 'Pilihan perusahaan tidak valid.');
        }

        if (
            filled($draft->tanggal_posting)
            && filled($draft->batas_pendaftaran)
            && $draft->batas_pendaftaran->lt($draft->tanggal_posting->copy()->startOfDay())
        ) {
            return redirect()->back()->withInput()->with('error', 'Batas pendaftaran tidak boleh sebelum tanggal posting.');
        }

        $matches = $this->companiesWithName($draft->nama_perusahaan);

        if (! $action && $matches->isNotEmpty()) {
            return redirect()->back()->withInput()->with('company_conflict', [
                'draft_id' => $draft->id,
                'draft_name' => $draft->nama_perusahaan,
                'companies' => $matches->map(fn($company) => [
                    'id' => $company->id,
                    'nama' => $company->nama,
                    'email' => $company->email,
                    'alamat' => $company->alamat,
                ])->values()->all(),
            ]);
        }

        $payload = [
            'company_action' => $action ?: 'create_new',
            'company_id' => $request->input('company_id'),
            'company_name' => $request->input('company_name', $draft->nama_perusahaan),
        ];

        if ($payload['company_action'] === 'use_existing') {
            if (! $matches->pluck('id')->contains((int) $payload['company_id'])) {
                return redirect()->back()->withInput()->with('error', 'Perusahaan yang dipilih tidak sesuai dengan nama perusahaan draft.');
            }
        }

        if ($payload['company_action'] === 'create_new') {
            $payload['company_name'] = trim((string) $payload['company_name']);
            if ($payload['company_name'] === '') {
                return redirect()->back()->withInput()->with('error', 'Nama perusahaan baru wajib diisi.');
            }

            if ($this->companiesWithName($payload['company_name'])->isNotEmpty()) {
                return redirect()->back()->withInput()->with('error', 'Nama perusahaan baru masih sama dengan perusahaan yang sudah ada.');
            }
        }

        $approvalService->approveAndPublish($draft->id, $payload);

        return redirect()->route('lokerdraft.index')->with('success', 'Draft berhasil dinormalisasi dan dipindahkan ke loker nonaktif.');
    }

    private function editRules(): array
    {
        return [
            'nama_perusahaan' => ['required', 'string', 'max:255'],
            'email_perusahaan' => ['nullable', 'email', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:255'],
            'instagram_dm' => ['nullable', 'string', 'max:255'],
            'website_form_url' => ['nullable', 'url', 'max:2000'],
            'alamat_raw' => ['nullable', 'string'],
            'provinsi_id' => ['nullable', 'integer', Rule::exists('provinsi', 'id')],
            'kabupaten_id' => ['nullable', 'integer', Rule::exists('kota', 'id')->where(fn($query) => $query->where('provinsi_id', request('provinsi_id')))],
            'kecamatan_id' => ['nullable', 'integer', Rule::exists('kecamatan', 'id')->where(fn($query) => $query->where('kota_id', request('kabupaten_id')))],
            'kelurahan_id' => ['nullable', 'integer', Rule::exists('kelurahan', 'id')->where(fn($query) => $query->where('kecamatan_id', request('kecamatan_id')))],
            'posisi' => ['required', 'string', 'max:255'],
            'deskripsi_pekerjaan' => ['nullable'],
            'jobdesk' => ['nullable', 'string'],
            'kualifikasi_jobspek' => ['nullable', 'string'],
            'keahlian_skill' => ['nullable', 'string'],
            'tipe_pekerjaan' => ['nullable', 'string', 'max:255'],
            'kategori_bidang' => ['nullable', 'string', 'max:255'],
            'fasilitas' => ['nullable', 'string'],
            'cara_melamar' => ['nullable', 'string'],
            'gaji_min' => ['nullable', 'numeric', 'min:0'],
            'gaji_max' => ['nullable', 'numeric', 'gte:gaji_min'],
            'tanggal_posting' => ['nullable', 'date'],
            'batas_pendaftaran' => ['nullable', 'date'],
        ];
    }

    private function publishRules(array $data): array
    {
        return array_merge($this->editRules(), [
            'email_perusahaan' => ['required', 'email', 'max:255'],
            'alamat_raw' => ['required', 'string'],
            'provinsi_id' => ['required', 'integer', Rule::exists('provinsi', 'id')],
            'kabupaten_id' => ['required', 'integer', Rule::exists('kota', 'id')->where(fn($query) => $query->where('provinsi_id', $data['provinsi_id'] ?? null))],
            'kecamatan_id' => ['required', 'integer', Rule::exists('kecamatan', 'id')->where(fn($query) => $query->where('kota_id', $data['kabupaten_id'] ?? null))],
            'kelurahan_id' => ['required', 'integer', Rule::exists('kelurahan', 'id')->where(fn($query) => $query->where('kecamatan_id', $data['kecamatan_id'] ?? null))],
            'batas_pendaftaran' => ['required', 'date'],
        ]);
    }

    private function companiesWithName(string $name)
    {
        return PerusahaanModel::query()
            ->whereRaw('LOWER(TRIM(nama)) = ?', [strtolower(trim($name))])
            ->get(['id', 'nama', 'email', 'alamat']);
    }

    public function destroy($id)
    {
        $draft = LokerDraft::findOrFail($id);
        $draft->delete();

        return redirect()->back()->with('success', 'Data draft berhasil dihapus!');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:loker_drafts,id',
        ]);

        LokerDraft::whereIn('id', $request->ids)->delete();

        return redirect()->back()->with('success', count($request->ids) . ' data draft berhasil dihapus!');
    }
}
