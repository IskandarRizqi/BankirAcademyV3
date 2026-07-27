<?php

namespace App\Http\Controllers\MemberNonAnggota;

use App\Http\Controllers\Controller;
use App\Models\MateriModel;
use App\Models\SubMateriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EbookController extends Controller
{
    // ==========================================
    // 1. KATALOG & BELAJAR EBOOK / PDF (tipe_link_item = 1)
    // ==========================================

    public function indexPdf()
    {
        $user = Auth::user();
        $materiUmum = MateriModel::where('nama', 'Umum')->first();

        if ($materiUmum) {
            $subMateriUmum = SubMateriModel::where('id_materi', $materiUmum->id)
                ->whereHas('items', function ($query) {
                    $query->where('tipe_link_item', 1); // Filter khusus PDF
                })
                ->with(['items' => function ($query) {
                    $query->where('tipe_link_item', 1);
                }])
                ->orderBy('urutan', 'asc')
                ->get();
        } else {
            $subMateriUmum = collect();
        }

        return view('membernonkeanggotaan.pages.ebook.index', compact('subMateriUmum', 'materiUmum', 'user'));
    }

    public function belajarPdf(Request $request, $sub_materi_id)
    {
        return $this->renderBelajarPage($request, $sub_materi_id, 1, 'membernonkeanggotaan.pages.ebook.belajar');
    }

    // ==========================================
    // 2. KATALOG & BELAJAR VIDEO (tipe_link_item = 0)
    // ==========================================

    public function indexVideo()
    {
        $user = Auth::user();
        $materiUmum = MateriModel::where('nama', 'Umum')->first();

        if ($materiUmum) {
            $subMateriUmum = SubMateriModel::where('id_materi', $materiUmum->id)
                ->whereHas('items', function ($query) {
                    $query->where('tipe_link_item', 0); // Filter khusus Video
                })
                ->with(['items' => function ($query) {
                    $query->where('tipe_link_item', 0);
                }])
                ->orderBy('urutan', 'asc')
                ->get();
        } else {
            $subMateriUmum = collect();
        }

        return view('membernonkeanggotaan.pages.video.index', compact('subMateriUmum', 'materiUmum', 'user'));
    }

    public function belajarVideo(Request $request, $sub_materi_id)
    {
        return $this->renderBelajarPage($request, $sub_materi_id, 0, 'membernonkeanggotaan.pages.video.belajar');
    }

    // ==========================================
    // HELPER METHODS (Private Reusable Logic)
    // ==========================================

    private function renderBelajarPage(Request $request, $sub_materi_id, $tipeLinkItem, $viewName)
    {
        $user = Auth::user();
        $userId = $user->id;

        // 1. Ambil SubMateri & filter items sesuai tipe_link_item
        $subMateriAktif = SubMateriModel::whereIn('tipe_beasiswa', [0, 1, 2])
            ->with(['items' => function ($q) use ($tipeLinkItem) {
                $q->where('tipe_link_item', $tipeLinkItem);
            }, 'materi'])
            ->findOrFail($sub_materi_id);

        // 2. Cek Akses / History Pelatihan
        $sudahIkuti = DB::table('history_pelatihan')
            ->where('user_id', $userId)
            ->where('sub_materi_id', $sub_materi_id)
            ->exists();

        // 3. Pengecekan Pembayaran
        $hargaFinal = $subMateriAktif->harga_final ?? $subMateriAktif->harga ?? 0;

        if (!$sudahIkuti && $hargaFinal > 0) {
            $paymentView = ($tipeLinkItem == 1) 
            ? 'compact.auto-submit-payment' 
            : 'compact.payment-video';
            return view($paymentView, [
                'subMateri' => $subMateriAktif,
                'hargaFinal' => $hargaFinal,
                'user' => $user
            ]);
        }

        // 4. Pengaturan Item & URL Player/Viewer
        $materiAktif = $subMateriAktif->materi;
        $itemIdAktif = $request->query('item_id');
        $itemAktif = null;
        $embedUrl = null;

        if ($subMateriAktif->items->count() > 0) {
            if ($itemIdAktif) {
                $itemAktif = $subMateriAktif->items->where('id', $itemIdAktif)->first();
            }
            if (!$itemAktif) {
                $itemAktif = $subMateriAktif->items->first();
            }

            if ($itemAktif) {
                if ($tipeLinkItem == 0) {
                    $embedUrl = $this->parseYoutubeCode($itemAktif->link_item);
                } else {
                    $embedUrl = $this->parseGoogleDriveLink($itemAktif->link_item);
                }
            }
        }

        return view($viewName, compact(
            'materiAktif', 
            'subMateriAktif', 
            'itemAktif', 
            'embedUrl', 
            'sudahIkuti'
        ));
    }

    private function parseYoutubeCode($url)
    {
        $shortUrlRegex = "/(?:https?:\\/\\/)?(?:www\\.)?(?:youtu\\.be\\/|v\\/|u\\/\\w\\/|embed\\/|watch\\?v=|&v=)([^#\\&\\?]*).*/";
        preg_match($shortUrlRegex, $url, $matches);
        if (isset($matches[1]) && strlen($matches[1]) == 11) {
            return "https://www.youtube.com/embed/" . $matches[1] . "?modestbranding=1&rel=0&showinfo=0";
        }
        return $url;
    }

    private function parseGoogleDriveLink($url)
    {
        if (strpos($url, 'drive.google.com') === false) {
            return $url;
        }

        preg_match('/\/d\/([a-zA-Z0-9-_]+)/', $url, $matches);
        
        if (isset($matches[1])) {
            $fileId = $matches[1];
            return "https://docs.google.com/viewer?url=" . urlencode("https://drive.google.com/uc?id=" . $fileId . "&export=download") . "&embedded=true";
        }

        return $url;
    }
}