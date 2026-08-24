<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LokerDraft;
use App\Exports\LokerDraftTemplateExport;
use App\Imports\LokerDraftJobPlatformImport;
use App\Imports\LokerDraftSocialMediaImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LokerDraftController extends Controller
{
    public function index(Request $request)
    {
        $query = LokerDraft::pending();

        // Fitur Filter: Kata Kunci
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('posisi', 'like', "%{$search}%")
                    ->orWhere('nama_perusahaan', 'like', "%{$search}%")
                    ->orWhere('provinsi_raw', 'like', "%{$search}%");
            });
        }

        // Fitur Filter: Platform
        if ($request->filled('platform')) {
            $query->where('platform', $request->platform);
        }

        // Fitur Filter: Min Gaji
        if ($request->filled('gaji_min')) {
            $query->where('gaji_min', '>=', $request->gaji_min);
        }

        $drafts = $query->latest()->get();

        // Mengambil daftar platform unik untuk opsi filter dropdown
        $platforms = LokerDraft::select('platform')->distinct()->pluck('platform');

        return view('loker-draft.index', compact('drafts', 'platforms'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'source_type' => 'required|in:social_media,job_platform',
            'platform'    => 'nullable|required_if:source_type,job_platform|in:JobStreet,Glints',
            'file_excel'  => 'required|mimes:xlsx,xls,csv'
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

    public function destroy($id)
    {
        $draft = LokerDraft::findOrFail($id);
        $draft->delete();

        return redirect()->back()->with('success', 'Data draft berhasil dihapus!');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'exists:loker_drafts,id'
        ]);

        LokerDraft::whereIn('id', $request->ids)->delete();

        return redirect()->back()->with('success', count($request->ids) . ' data draft berhasil dihapus!');
    }
}
