<?php

namespace App\Http\Controllers\MemberNonAnggota;

use App\Http\Controllers\Controller;
use App\Models\DataPayment;
use App\Models\MateriModel;
use App\Models\RiwayatTransaksi;
use App\Models\SubMateriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EbookController extends Controller
{
    public function indexPdf(Request $request)
    {
        $user = Auth::user();
        $materiUmum = MateriModel::where('nama', 'Umum')->first();
        $subMateriBaruCount = 0;

        if ($materiUmum) {
            $query = SubMateriModel::where('id_materi', $materiUmum->id)
                ->whereHas('items', function ($q) {
                    $q->where('tipe_link_item', 1); // Filter khusus PDF
                })
                ->with(['items' => function ($q) {
                    $q->where('tipe_link_item', 1);
                }])
                ->orderByRaw('COALESCE(upcoming, 0) ASC');
            if ($request->filled('q')) {
                $search = $request->q;
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('nama', 'like', "%{$search}%")
                        ->orWhere('keterangan', 'like', "%{$search}%");
                });
            }
            if ($request->filled('tipe_harga')) {
                if ($request->tipe_harga === 'gratis') {
                    $query->where(function ($q) {
                        $q->whereNull('harga_final')->where(function ($sub) {
                            $sub->whereNull('harga')->orWhere('harga', 0);
                        })->orWhere('harga_final', 0);
                    });
                } elseif ($request->tipe_harga === 'berbayar') {
                    $query->where(function ($q) {
                        $q->where('harga_final', '>', 0)
                            ->orWhere(function ($sub) {
                                $sub->whereNull('harga_final')->where('harga', '>', 0);
                            });
                    });
                }
            }

            $subMateriBaruCount = (clone $query)
                ->where('created_at', '>=', now()->subMonth())
                ->count();

            if ($request->filled('sort_harga')) {
                $sort = $request->sort_harga;
                if (in_array($sort, ['asc', 'desc'])) {
                    $query->orderByRaw('COALESCE(harga_final, harga, 0) ' . strtoupper($sort));
                }
            } else {
                $query->orderBy('urutan', 'asc');
            }

            $subMateriUmum = $query->get();
        } else {
            $subMateriUmum = collect();
        }

        return view('membernonkeanggotaan.pages.ebook.index', compact('subMateriUmum', 'materiUmum', 'user', 'subMateriBaruCount'));
    }

    public function belajarPdf(Request $request, $sub_materi_id)
    {
        return $this->renderBelajarPage($request, $sub_materi_id, 1, 'membernonkeanggotaan.pages.ebook.belajar');
    }
    public function indexVideo(Request $request)
    {
        $user = Auth::user();
        $materiUmum = MateriModel::where('nama', 'Umum')->first();
        $subMateriBaruCount = 0;

        if ($materiUmum) {
            $query = SubMateriModel::where('id_materi', $materiUmum->id)
                ->whereHas('items', function ($q) {
                    $q->where('tipe_link_item', 0);
                })
                ->with(['items' => function ($q) {
                    $q->where('tipe_link_item', 0);
                }])
                ->orderByRaw('COALESCE(upcoming, 0) ASC');
            if ($request->filled('q')) {
                $search = $request->q;
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('nama', 'like', "%{$search}%")
                        ->orWhere('keterangan', 'like', "%{$search}%");
                });
            }
            if ($request->filled('tipe_harga')) {
                if ($request->tipe_harga === 'gratis') {
                    $query->where(function ($q) {
                        $q->whereNull('harga_final')->where(function ($sub) {
                            $sub->whereNull('harga')->orWhere('harga', 0);
                        })->orWhere('harga_final', 0);
                    });
                } elseif ($request->tipe_harga === 'berbayar') {
                    $query->where(function ($q) {
                        $q->where('harga_final', '>', 0)
                            ->orWhere(function ($sub) {
                                $sub->whereNull('harga_final')->where('harga', '>', 0);
                            });
                    });
                }
            }

            $subMateriBaruCount = (clone $query)
                ->where('created_at', '>=', now()->subMonth())
                ->count();

            if ($request->filled('sort_harga')) {
                $sort = $request->sort_harga;
                if (in_array($sort, ['asc', 'desc'])) {
                    $query->orderByRaw('COALESCE(harga_final, harga, 0) ' . strtoupper($sort));
                }
            } else {
                $query->orderBy('urutan', 'asc');
            }

            $subMateriUmum = $query->get();
        } else {
            $subMateriUmum = collect();
        }

        return view('membernonkeanggotaan.pages.video.index', compact('subMateriUmum', 'materiUmum', 'user', 'subMateriBaruCount'));
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

        $subMateriAktif = SubMateriModel::whereIn('tipe_beasiswa', [0, 1, 2])
            ->with(['items' => function ($q) use ($tipeLinkItem) {
                $q->where('tipe_link_item', $tipeLinkItem);
            }, 'materi'])
            ->findOrFail($sub_materi_id);

        $sudahIkuti = DB::table('history_pelatihan')
            ->where('user_id', $userId)
            ->where('sub_materi_id', $sub_materi_id)
            ->exists();

        $hargaFinal = $subMateriAktif->harga_final ?? $subMateriAktif->harga ?? 0;

        if (!$sudahIkuti) {
            $paymentView = ($tipeLinkItem == 1)
                ? 'compact.auto-submit-payment'
                : 'compact.payment-video';
            return view($paymentView, [
                'subMateri' => $subMateriAktif,
                'hargaFinal' => $hargaFinal,
                'user' => $user
            ]);
        }

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
    public function detailPdf(Request $request, $sub_materi_id)
    {
        $user = Auth::user();

        $subMateri = SubMateriModel::with(['items' => function ($q) {
            $q->where('tipe_link_item', 1); // Filter PDF
        }])->findOrFail($sub_materi_id);

        // Cek apakah user sudah membeli / klaim
        $sudahAkses = DB::table('history_pelatihan')
            ->where('user_id', $user->id)
            ->where('sub_materi_id', $sub_materi_id)
            ->exists();
        $transaksiAktif = RiwayatTransaksi::where('user_id', $user->id)
            ->where('class_id', $sub_materi_id)
            ->where('expired', '>', now())
            ->where('status', 'PENDING')
            ->latest()
            ->first();

        $harga = $subMateri->harga ?? 0;
        $hargaFinal = $subMateri->harga_final ?? $harga;
        $diskon = $subMateri->diskon ?? 0;

        // Ambil item pertama untuk preview (Google Drive Embed)
        $previewItem = $subMateri->items->first();
        $previewEmbedUrl = null;
        if ($previewItem) {
            $previewEmbedUrl = $this->parseGoogleDriveLink($previewItem->link_item);
        }

        // Cover Image
        if (!empty($subMateri->thumbnail) && str_contains($subMateri->thumbnail, 'uploads')) {
            $coverImage = asset($subMateri->thumbnail);
        } elseif (!empty($subMateri->thumbnail) && str_contains($subMateri->thumbnail, 'photos')) {
            $coverImage = asset('storage/' . $subMateri->thumbnail);
        } else {
            $coverImage = null;
        }

        return view('membernonkeanggotaan.pages.ebook.detail', compact(
            'subMateri',
            'transaksiAktif',
            'sudahAkses',
            'harga',
            'hargaFinal',
            'diskon',
            'previewEmbedUrl',
            'user',
            'coverImage'
        ));
    }
    public function detailVideo(Request $request, $sub_materi_id)
    {
        $user = Auth::user();

        $subMateri = SubMateriModel::with(['items' => function ($q) {
            $q->where('tipe_link_item', 0); // Filter PDF
        }])->findOrFail($sub_materi_id);

        // Cek apakah user sudah membeli / klaim
        $sudahAkses = DB::table('history_pelatihan')
            ->where('user_id', $user->id)
            ->where('sub_materi_id', $sub_materi_id)
            ->exists();
        $transaksiAktif = RiwayatTransaksi::where('user_id', $user->id)
            ->where('class_id', $sub_materi_id)
            ->where('expired', '>', now())
            ->where('status', 'PENDING')
            ->latest()
            ->first();
        $paymentActive = DataPayment::where('user_id', $user->id)->where('submateri_id', $sub_materi_id)->whereIn('status', [2, 3])->first();

        $hargaFinal = $subMateri->harga_final ?? $subMateri->harga ?? 0;
        $harga = $subMateri->harga ?? 0;
        $hargaFinal = $subMateri->harga_final ?? $harga;
        $diskon = $subMateri->diskon ?? 0;

        // Ambil item pertama untuk preview (Google Drive Embed)
        $previewItem = $subMateri->items->first();
        $previewEmbedUrl = null;
        if ($previewItem) {
            $previewEmbedUrl = $this->parseYoutubeCode($previewItem->link_item);
        }
        if (!empty($subMateri->thumbnail) && str_contains($subMateri->thumbnail, 'uploads')) {
            $coverImage = asset($subMateri->thumbnail);
        } elseif (!empty($subMateri->thumbnail) && str_contains($subMateri->thumbnail, 'photos')) {
            $coverImage = asset('storage/' . $subMateri->thumbnail);
        } else {
            $coverImage = null;
        }

        return view('membernonkeanggotaan.pages.video.detail', compact(
            'subMateri',
            'sudahAkses',
            'transaksiAktif',
            'paymentActive',
            'harga',
            'hargaFinal',
            'hargaFinal',
            'previewEmbedUrl',
            'user',
            'coverImage'
        ));
    }
    public function claimFreePdf($sub_materi_id)
    {
        $user = Auth::user();
        $subMateri = SubMateriModel::findOrFail($sub_materi_id);
        $hargaFinal = $subMateri->harga_final ?? $subMateri->harga ?? 0;

        // Validasi apakah benar-benar gratis
        if ($hargaFinal > 0) {
            return redirect()->back()->with('error', 'Ebook ini berbayar.');
        }

        // Gunakan Transaction agar aman
        DB::transaction(function () use ($user, $subMateri) {
            // 1. Simpan ke DataPayment
            DataPayment::create([
                'no_invoice'      => 'BANKIR-' . now()->format('YmdHisv') . '-' . random_int(1000, 9999),
                'user_id'         => $user->id,
                'materi_id'       => $subMateri->id_materi,
                'submateri_id'    => $subMateri->id,
                'pembelian'       => DataPayment::PURCHASE_EBOOK,
                'nominal'         => 0,
                'qty'             => 1,
                'status'          => DataPayment::STATUS_PAID, // langsung PAID (1)
                'tipe_pembelian'  => DataPayment::PURCHASE_TYPE_EBOOK,
                'keterangan'      => 'Klaim Ebook Gratis: ' . $subMateri->nama,
            ]);

            // 2. Simpan ke History Pelatihan agar user punya akses
            DB::table('history_pelatihan')->updateOrInsert(
                [
                    'user_id'       => $user->id,
                    'sub_materi_id' => $subMateri->id,
                ],
                [
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]
            );
        });

        return redirect()->route('ebook.belajar', $subMateri->id)
            ->with('success', 'Ebook gratis berhasil ditambahkan ke pustaka Anda!');
    }
    public function claimFreeVideo($sub_materi_id)
    {
        $user = Auth::user();
        $subMateri = SubMateriModel::findOrFail($sub_materi_id);
        $hargaFinal = $subMateri->harga_final ?? $subMateri->harga ?? 0;

        // Validasi apakah benar-benar gratis
        if ($hargaFinal > 0) {
            return redirect()->back()->with('error', 'Video ini berbayar.');
        }

        // Gunakan Transaction agar aman
        DB::transaction(function () use ($user, $subMateri) {
            // 1. Simpan ke DataPayment
            DataPayment::create([
                'no_invoice'      => 'BANKIR-' . now()->format('YmdHisv') . '-' . random_int(1000, 9999),
                'user_id'         => $user->id,
                'materi_id'       => $subMateri->id_materi,
                'submateri_id'    => $subMateri->id,
                'pembelian'       => DataPayment::PURCHASE_VIDEO,
                'nominal'         => 0,
                'qty'             => 1,
                'status'          => DataPayment::STATUS_PAID, // langsung PAID (1)
                'tipe_pembelian'  => DataPayment::PURCHASE_TYPE_VIDEO,
                'keterangan'      => 'Klaim Video Gratis: ' . $subMateri->nama,
            ]);

            // 2. Simpan ke History Pelatihan agar user punya akses
            DB::table('history_pelatihan')->updateOrInsert(
                [
                    'user_id'       => $user->id,
                    'sub_materi_id' => $subMateri->id,
                ],
                [
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]
            );
        });

        return redirect()->route('video.belajar', $subMateri->id)
            ->with('success', 'Video gratis berhasil ditambahkan ke pustaka Anda!');
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
