<?php

namespace App\Http\Controllers\MemberNonAnggota;

use App\Http\Controllers\Controller;
use App\Models\BonusAplikasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BonusAplikasiController extends Controller
{
    private const PER_PAGE = 12;

    public function index(Request $request)
    {
        $bonusAplikasi = BonusAplikasiModel::query()
            ->select([
                'id',
                'nama',
                'deskripsi',
                'status',
                'tipe_sumber',
                'url',
                'file_name',
                'thumbnail_path',
                'created_at',
            ])
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('membernonkeanggotaan.components.ui.bonus-aplikasi-card-items', [
                    'bonusAplikasi' => $bonusAplikasi,
                ])->render(),
                'next_page_url' => $bonusAplikasi->nextPageUrl(),
                'has_more_pages' => $bonusAplikasi->hasMorePages(),
            ]);
        }

        return view('membernonkeanggotaan.pages.bonus-aplikasi.index', [
            'bonusAplikasi' => $bonusAplikasi,
        ]);
    }

    public function access(int $id)
    {
        $bonus = BonusAplikasiModel::findOrFail($id);

        abort_if($bonus->status === BonusAplikasiModel::STATUS_UPCOMING, 404);

        if ($bonus->tipe_sumber === BonusAplikasiModel::SOURCE_URL) {
            abort_unless($this->isHttpUrl($bonus->url), 404);

            return redirect()->away($bonus->url);
        }

        abort_unless($bonus->tipe_sumber === BonusAplikasiModel::SOURCE_FILE && filled($bonus->file_path), 404);

        $path = public_path($bonus->file_path);
        $bonusDirectory = realpath(public_path('image/bonus-aplikasi/'.$bonus->id));
        $realPath = realpath($path);

        abort_unless(
            File::exists($path)
                && $realPath !== false
                && $bonusDirectory !== false
                && str_starts_with($realPath, $bonusDirectory.DIRECTORY_SEPARATOR),
            404
        );

        return response()->download($realPath, $this->downloadName($bonus->file_name, $realPath));
    }

    private function isHttpUrl(?string $url): bool
    {
        if (! $url || ! filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }

        $parsedUrl = parse_url($url);

        return in_array(strtolower($parsedUrl['scheme'] ?? ''), ['http', 'https'], true)
            && filled($parsedUrl['host'] ?? null);
    }

    private function downloadName(?string $filename, string $path): string
    {
        $filename = basename((string) $filename);

        return $filename !== '' && $filename !== '.'
            ? $filename
            : basename($path);
    }
}
