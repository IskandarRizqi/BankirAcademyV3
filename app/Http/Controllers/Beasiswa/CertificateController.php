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
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function index()
    {
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
            'target_type'       => 'required|in:materi,sub_materi',
            'materi_id'         => 'required_if:target_type,materi',
            'sub_materi_id'     => 'required_if:target_type,sub_materi',
            'coordinate_x'     => 'required|integer',
            'coordinate_y'     => 'required|integer',
            'font_size'        => 'required|integer',
            'serial_y'         => 'nullable|integer',
            'serial_font_size' => 'nullable|integer',
            'label_y'          => 'nullable|integer',
            'label_font_size'  => 'nullable|integer',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->with('info', 'Validasi gagal, mohon periksa kembali form anda.')->withInput();
        }

        $templateLama = CertificateTemplate::find($request->id);
        $namaFileGambar = $templateLama ? $templateLama->background_image : null;

        if ($request->hasFile('background_image')) {
            if ($templateLama && $templateLama->background_image && Storage::exists('public/certificates/' . $templateLama->background_image)) {
                Storage::delete('public/certificates/' . $templateLama->background_image);
            }

            $file = $request->file('background_image');
            $namaFileGambar = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/certificates', $namaFileGambar);
        }

        CertificateTemplate::updateOrCreate(['id' => $request->id], [
            'target_type'      => $request->target_type,
            'materi_id'        => $request->target_type == 'materi' ? $request->materi_id : null,
            'sub_materi_id'    => $request->target_type == 'sub_materi' ? $request->sub_materi_id : null,
            'coordinate_x'    => $request->coordinate_x,
            'coordinate_y'    => $request->coordinate_y,
            'font_size'       => $request->font_size,
            'serial_y'         => $request->serial_y ?? 330,
            'serial_font_size' => $request->serial_font_size ?? 18,
            'label_y'          => $request->label_y ?? 390,
            'label_font_size'  => $request->label_font_size ?? 16,
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

    public function downloadMateriCertificate($materiId)
    {
        $user = auth()->user();
        $materi = MateriModel::where('id', $materiId)->where('nama', '!=', 'Umum')->firstOrFail();
        
        $template = CertificateTemplate::where('target_type', 'materi')
                                        ->where('materi_id', $materiId)
                                        ->firstOrFail();

        return $this->generatePdfCertificate($user, $template, $materi->nama);
    }

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

    private function generatePdfCertificate($user, $template, $lessonName)
    {
        $imagePath = storage_path('app/public/certificates/' . $template->background_image);
        
        if (!file_exists($imagePath)) {
            return redirect()->back()->with('info', 'File template fisik tidak ditemukan.');
        }

        $imageData = base64_encode(file_get_contents($imagePath));
        $imageSrc = 'data:image/' . pathinfo($imagePath, PATHINFO_EXTENSION) . ';base64,' . $imageData;

        // Ambil atau buat nomor sertifikat unik
        $certificateCode = 'CERT/' . date('Ymd') . '/' . $user->id . '/' . $template->id;
        $userCert = UserCertificate::firstOrCreate(
            ['user_id' => $user->id, 'certificate_template_id' => $template->id],
            ['certificate_code' => $certificateCode, 'issued_at' => now()]
        );

        // KUNCI PERBAIKAN: Kirim $noSertifikat dan atribut koordinat tambahan ke Blade
        $data = [
            'noSertifikat'   => $userCert->certificate_code ?? $certificateCode,
            'namaSiswa'      => strtoupper($user->name),
            'imageSrc'       => $imageSrc,
            'coordinateX'    => $template->coordinate_x,
            'coordinateY'    => $template->coordinate_y,
            'fontSize'       => $template->font_size,
            'serialY'        => $template->serial_y ?? 330,
            'serialFontSize' => $template->serial_font_size ?? 18,
            'labelY'         => $template->label_y ?? 390,
            'labelFontSize'  => $template->label_font_size ?? 16,
        ];

        $pdf = Pdf::loadView('compact.pdf-sertifikat', $data)
                  ->setPaper('a4', 'landscape')
                  ->setWarnings(false);

        return $pdf->download('Sertifikat-' . Str::slug($lessonName) . '.pdf');
    }
}