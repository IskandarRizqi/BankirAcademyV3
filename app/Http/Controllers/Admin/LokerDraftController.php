<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LokerDraft;
use App\Exports\LokerDraftTemplateExport;
use App\Imports\LokerDraftImport;
use App\Imports\LokerDraftJobPlatformImport;
use App\Imports\LokerDraftSocialMediaImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LokerDraftController extends Controller
{
    public function index()
    {
        $drafts = LokerDraft::pending()->latest()->get();
        return view('loker-draft.index', compact('drafts'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'source_type' => 'required|in:social_media,job_platform',
            'file_excel'  => 'required|mimes:xlsx,xls,csv'
        ]);

        if ($request->source_type === 'social_media') {
            Excel::import(new LokerDraftSocialMediaImport, $request->file('file_excel'));
        } else {
            Excel::import(new LokerDraftJobPlatformImport, $request->file('file_excel'));
        }

        return redirect()->back()->with('success', 'Data draft loker berhasil diimport!');
    }
    public function downloadTemplate()
    {
        return Excel::download(new LokerDraftTemplateExport, 'template_import_loker_draft.xlsx');
    }
}
