<?php

namespace App\Http\Controllers\MemberNonAnggota;

use App\Http\Controllers\Controller;
use App\Models\DokumenFileSopModel;
use Illuminate\Support\Str;
use App\Models\SopModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SopController extends Controller
{
    private const PER_PAGE = 9;

    private const GOOGLE_DRIVE_HOSTS = [
        'drive.google.com',
        'docs.google.com',
        'drive.usercontent.google.com',
    ];

    public function index(Request $request)
    {
        $search = trim((string) $request->query('q'));
        $sops = $this->sopQuery($search)
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('membernonkeanggotaan.components.ui.sop-card-items', [
                    'sops' => $sops,
                ])->render(),
                'next_page_url' => $sops->nextPageUrl(),
                'has_more_pages' => $sops->hasMorePages(),
            ]);
        }

        return view('membernonkeanggotaan.pages.sop.index', [
            'sops' => $sops,
            'search' => $search,
        ]);
    }

    public function show(int $id)
    {
        $sop = SopModel::with('dokumenFiles')->findOrFail($id);

        return view('membernonkeanggotaan.pages.sop.detail', [
            'sop' => $sop,
        ]);
    }

    public function downloadDocument(int $id)
    {
        $document = DokumenFileSopModel::with('sop')->findOrFail($id);

        // 1. Cek status SOP
        abort_if($document->sop?->status === SopModel::STATUS_UPCOMING, 404);

        // 2. Handling Google Drive
        if (filled($document->link_google_drive)) {
            abort_unless($this->isGoogleDriveLink($document->link_google_drive), 404);

            return redirect()->away($document->link_google_drive);
        }

        // 3. Sanitisasi & Normalisasi Path
        $relativePath = ltrim(str_replace('\\', '/', (string) $document->path), '/');
        abort_if($relativePath === '' || str_contains($relativePath, "\0"), 404);

        // 4. Resolusi Real Path & Keamanan Directory Traversal
        $publicDirectory = rtrim(realpath(public_path()), DIRECTORY_SEPARATOR);
        $realPath = realpath(public_path($relativePath));

        // Pastikan file ada DAN path-nya benar-benar di dalam folder public
        abort_unless(
            $realPath !== false
                && File::exists($realPath)
                && str_starts_with($realPath, $publicDirectory . DIRECTORY_SEPARATOR),
            404
        );

        // 5. Autokoreksi Ekstensi File pada Parameter Nama Download
        $extension = File::extension($realPath);
        $downloadName = $document->nama_file;

        if ($extension && ! Str::endsWith(strtolower($downloadName), '.' . strtolower($extension))) {
            $downloadName .= '.' . $extension;
        }

        // 6. Return response download
        return response()->download($realPath, $downloadName);
    }

    private function sopQuery(string $search = '')
    {
        return SopModel::query()
            ->select(['id', 'judul', 'deskripsi', 'status', 'updated_at'])
            ->withCount('dokumenFiles')
            ->when($search !== '', fn($query) => $query->where('judul', 'like', "%{$search}%"))
            ->orderByDesc('updated_at')
            ->orderByDesc('id');
    }

    private function isGoogleDriveLink(string $link): bool
    {
        $parsedUrl = parse_url($link);

        return ($parsedUrl['scheme'] ?? null) === 'https'
            && in_array(strtolower($parsedUrl['host'] ?? ''), self::GOOGLE_DRIVE_HOSTS, true);
    }
}
