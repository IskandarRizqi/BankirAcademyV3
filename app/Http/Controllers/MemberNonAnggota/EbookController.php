<?php

namespace App\Http\Controllers\MemberNonAnggota;

use App\Http\Controllers\Controller;
use App\Models\ClassPaymentModel;
use App\Models\DataPayment;
use App\Models\MateriModel;
use App\Models\SubMateriModel;
use App\Models\UserProfileModel;
use App\Services\PaymentExpiryService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EbookController extends Controller
{

  public function index()
{
    $userId = Auth::id();
    $user = Auth::user();
    
        $materiUmum = MateriModel::where('nama', 'Umum')->first();
        

        if ($materiUmum) {
            $subMateriUmum = SubMateriModel::where('id_materi', $materiUmum->id)
                ->with('items')
                ->orderBy('urutan', 'asc')
                ->get();
        } else {
            $subMateriUmum = collect();
        }

    return view('membernonkeanggotaan.pages.ebook.index', compact('subMateriUmum', 'materiUmum', 'user'));
}
public function belajar(Request $request, $sub_materi_id)
{
    $user = Auth::user();
    $userId = $user->id;
    
    

    // 1. Ambil SubMateri/Materi
    $subMateriAktif = SubMateriModel::whereIn('tipe_beasiswa', [0, 1,2])
        ->with(['items', 'materi'])
        ->findOrFail($sub_materi_id);

    // 2. Cek History Pelatihan (Akses yang sudah dibeli/diikuti sebelumnya)
    $sudahIkuti = DB::table('history_pelatihan')
        ->where('user_id', $userId)
        ->where('sub_materi_id', $sub_materi_id) // ganti ke 'class_id' jika nama kolom di DB berupa class_id
        ->exists();

    // 3. Logika Pengecekan Akses Pembayaran
    $hargaFinal = $subMateriAktif->harga_final ?? $subMateriAktif->harga ?? 0;

if (!$sudahIkuti && $hargaFinal > 0) {
    // Kembalikan view perantara yang akan melipat form POST secara otomatis
    return view('compact.auto-submit-payment', [
        'subMateri' => $subMateriAktif,
        'hargaFinal' => $hargaFinal,
        'user' => $user
    ]);
}

    // 4. Jika gratis ATAU sudah ada di history_pelatihan, lanjutkan tampilkan materi
    $materiAktif = $subMateriAktif->materi;

    // Kontrol Media Item Aktif lewat query string item_id
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

        if ($itemAktif->tipe_link_item == 0) {
            $embedUrl = $this->parseYoutubeCode($itemAktif->link_item);
        } else if ($itemAktif->tipe_link_item == 1) {
            $embedUrl = $this->parseGoogleDriveLink($itemAktif->link_item);
        }
    }

    return view('membernonkeanggotaan.pages.ebook.belajar', compact(
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
    // Jika bukan link google drive, kembalikan url aslinya
    if (strpos($url, 'drive.google.com') === false) {
        return $url;
    }

    // Pola untuk mengambil ID file Google Drive
    preg_match('/\/d\/([a-zA-Z0-9-_]+)/', $url, $matches);
    
    if (isset($matches[1])) {
        $fileId = $matches[1];
        // Format link khusus untuk Google Docs Viewer (paling aman dari error "butuh akses")
        return "https://docs.google.com/viewer?url=" . urlencode("https://drive.google.com/uc?id=" . $fileId . "&export=download") . "&embedded=true";
    }

    return $url;
}

}
