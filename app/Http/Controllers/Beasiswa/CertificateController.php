<?php

namespace App\Http\Controllers\Beasiswa;

use App\Http\Controllers\Controller;
use App\Models\CertificateTemplate;
use App\Models\MateriModel;
use App\Models\SubMateriModel;
use App\Models\UserCertificate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image; // Pastikan sudah install intervention/image
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function index()
    {
        // Ambil data untuk dropdown di form view
        $x['materi_non_umum'] = MateriModel::where('nama', '!=', 'Umum')->get();
        $x['sub_materi_umum'] = SubMateriModel::whereHas('materi', function($q) {
            $q->where('nama', 'Umum');
        })->get();

        $x['data'] = CertificateTemplate::with(['materi', 'subMateri'])->get();

        return view('compact.certificate', $x);
    }

    public function store(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'target_type' => 'required|in:materi,sub_materi',
            'materi_id' => 'required_if:target_type,materi',
            'sub_materi_id' => 'required_if:target_type,sub_materi',
            'coordinate_x' => 'required|integer',
            'coordinate_y' => 'required|integer',
            'font_size' => 'required|integer',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->with('info', 'Validasi gagal, mohon periksa kembali form anda.')->withInput();
        }

        $templateLama = CertificateTemplate::find($request->id);
        $namaFileGambar = $templateLama ? $templateLama->background_image : null;

        if ($request->hasFile('background_image')) {
            // Hapus file lama jika update
            if ($templateLama && $templateLama->background_image && Storage::exists('public/certificates/' . $templateLama->background_image)) {
                Storage::delete('public/certificates/' . $templateLama->background_image);
            }

            $file = $request->file('background_image');
            $namaFileGambar = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/certificates', $namaFileGambar);
        }

        CertificateTemplate::updateOrCreate(['id' => $request->id], [
            'target_type' => $request->target_type,
            'materi_id' => $request->target_type == 'materi' ? $request->materi_id : null,
            'sub_materi_id' => $request->target_type == 'sub_materi' ? $request->sub_materi_id : null,
            'coordinate_x' => $request->coordinate_x,
            'coordinate_y' => $request->coordinate_y,
            'font_size' => $request->font_size,
            'background_image' => $namaFileGambar,
        ]);

        return redirect()->back()->with('success', 'Template sertifikat berhasil disimpan');
    }

    public function destroy($id)
    {
        $template = CertificateTemplate::findOrFail($id);
        if ($template->background_image && Storage::exists('public/certificates/' . $template->background_image)) {
            Storage::delete('public/certificates/' . $template->background_image);
        }
        $template->delete();

        return redirect()->back()->with('success', 'Template sertifikat berhasil dihapus');
    }

    /**
     * LOGIKA DOWNLOAD DINAMIS - SKEMA MATERI NON-UMUM
     */
    public function downloadMateriCertificate($materiId)
    {
        $user = auth()->user(); // Ambil data user login saat ini
        $materi = MateriModel::where('id', $materiId)->where('nama', '!=', 'Umum')->firstOrFail();
        
        $template = CertificateTemplate::where('target_type', 'materi')
                                        ->where('materi_id', $materiId)
                                        ->firstOrFail();

        return $this->generatePdfCertificate($user, $template, $materi->nama);
    }

    /**
     * LOGIKA DOWNLOAD DINAMIS - SKEMA SUB-MATERI (KHUSUS MATERI UMUM)
     */
    public function downloadSubMateriCertificate($subMateriId)
    {
        $user = auth()->user();
        $subMateri = SubMateriModel::where('id', $subMateriId)->whereHas('materi', function($q){
            $q->where('nama', 'Umum');
        })->firstOrFail();

        $template = CertificateTemplate::where('target_type', 'sub_materi')
                                        ->where('sub_materi_id', $subMateriId)
                                        ->firstOrFail();

        return $this->generatePdfCertificate($user, $template, $subMateri->nama);
    }

    /**
     * HELPER GENERATOR SERTIFIKAT BERDASARKAN KOORDINAT
     */
   private function generatePdfCertificate($user, $template, $lessonName)
{
    // Pastikan path gambar background benar untuk ditarik di dalam Blade PDF
    // Menggunakan base64 atau path relatif aman untuk DomPDF
    $imagePath = storage_path('app/public/certificates/' . $template->background_image);
    
    if (!file_exists($imagePath)) {
        return redirect()->back()->with('info', 'File template fisik tidak ditemukan.');
    }

    // Ambil data gambar untuk dikonversi ke Base64 agar aman di-render oleh DomPDF
    $imageData = base64_encode(file_get_contents($imagePath));
    $imageSrc = 'data:image/' . pathinfo($imagePath, PATHINFO_EXTENSION) . ';base64,' . $imageData;

    // Catat riwayat download ke database jika belum pernah diklaim sebelumnya
    $certificateCode = 'CERT/' . date('Ymd') . '/' . $user->id . '/' . $template->id;
    UserCertificate::firstOrCreate(
        ['user_id' => $user->id, 'certificate_template_id' => $template->id],
        ['certificate_code' => $certificateCode, 'issued_at' => now()]
    );

    // Kumpulkan data yang akan dikirim ke view PDF
    $data = [
        'namaSiswa'   => strtoupper($user->name),
        'imageSrc'    => $imageSrc,
        'coordinateX' => $template->coordinate_x,
        'coordinateY' => $template->coordinate_y,
        'fontSize'    => $template->font_size,
    ];

    // Render ke view khusus PDF dengan ukuran kertas A4 posisi Landscape
    $pdf = Pdf::loadView('compact.pdf-sertifikat', $data)
              ->setPaper('a4', 'landscape')
              ->setWarnings(false);

    // Langsung download ke browser
    return $pdf->download('Sertifikat-' . Str::slug($lessonName) . '.pdf');
}
}