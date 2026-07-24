<?php

namespace App\Http\Controllers;

use App\Models\LamaranModel;
use App\Models\SiswaProfile;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LamaranController extends Controller
{
    // READ: Menampilkan CV ATS milik User
    public function index()
    {
        $user = Auth::user();
        $lamaran = LamaranModel::where('user_id', $user->id)->latest()->first();

        return view('compact.cvats', compact('user', 'lamaran'));
    }

    // CREATE: Form Tambah Data Baru
    public function create()
    {
        return view('compact.lamaran.form', [
            'lamaran' => new LamaranModel(),
            'action'  => route('lamaran.store'),
            'method'  => 'POST',
            'title'   => 'Buat Data CV / Lamaran'
        ]);
    }

    // STORE: Simpan Data Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'nama_panggilan' => 'required|string|max:100',
            'tmpttgllahir'   => 'required|string|max:255',
            'agama'          => 'required',
            'alamatdomisili' => 'required|string',
            'telpdomisili'   => 'required|string|max:20',
            'kodepos'        => 'required|string|max:10',
            'statusperkawinan'=> 'required|string',
        ]);

        $data = $request->except(['_token', '_method']);
        $data['user_id'] = Auth::id();

        // Format Pengalaman Kerja (Array to Separated String)
        if (is_array($request->pekerjaanperusahaan)) {
            $data['pekerjaanperusahaan']    = implode(',', array_filter($request->pekerjaanperusahaan));
            $data['pekerjaanjabatan']       = implode(',', $request->pekerjaanjabatan ?? []);
            $data['pekerjaantahun']         = implode(',', $request->pekerjaantahun ?? []);
            $data['pekerjaantanggungjawab'] = implode(';', $request->pekerjaantanggungjawab ?? []);
            $data['pekerjaanprestasi']      = implode(';', $request->pekerjaanprestasi ?? []);
        }

        // Format Pelatihan / Sertifikasi (Array to Separated String)
        if (is_array($request->pelatihannama)) {
            $data['pelatihannama']          = implode(',', array_filter($request->pelatihannama));
            $data['pelatihanpenyelanggara'] = implode(',', $request->pelatihanpenyelanggara ?? []);
            $data['pelatihantahun']         = implode(',', $request->pelatihantahun ?? []);
            $data['pelatihanlokasi']        = implode(',', $request->pelatihanlokasi ?? []);
        }

        LamaranModel::create($data);

        return redirect()->route('cvats.index')->with('success', 'Data CV berhasil disimpan!');
    }

    // EDIT: Form Ubah Data
    public function edit($id)
    {
        $lamaran = LamaranModel::where('user_id', Auth::id())->findOrFail($id);

        return view('compact.lamaran.form', [
            'lamaran' => $lamaran,
            'action'  => route('lamaran.update', $lamaran->id),
            'method'  => 'PUT',
            'title'   => 'Edit Data CV / Lamaran'
        ]);
    }

    // UPDATE: Perbarui Data
    public function update(Request $request, $id)
    {
        $lamaran = LamaranModel::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'nama_panggilan' => 'required|string|max:100',
            'tmpttgllahir'   => 'required|string|max:255',
            'alamatdomisili' => 'required|string',
        ]);

        $data = $request->except(['_token', '_method']);

        // Format Pengalaman Kerja
        if (is_array($request->pekerjaanperusahaan)) {
            $data['pekerjaanperusahaan']    = implode(',', array_filter($request->pekerjaanperusahaan));
            $data['pekerjaanjabatan']       = implode(',', $request->pekerjaanjabatan ?? []);
            $data['pekerjaantahun']         = implode(',', $request->pekerjaantahun ?? []);
            $data['pekerjaantanggungjawab'] = implode(';', $request->pekerjaantanggungjawab ?? []);
            $data['pekerjaanprestasi']      = implode(';', $request->pekerjaanprestasi ?? []);
        }

        // Format Pelatihan
        if (is_array($request->pelatihannama)) {
            $data['pelatihannama']          = implode(',', array_filter($request->pelatihannama));
            $data['pelatihanpenyelanggara'] = implode(',', $request->pelatihanpenyelanggara ?? []);
            $data['pelatihantahun']         = implode(',', $request->pelatihantahun ?? []);
            $data['pelatihanlokasi']        = implode(',', $request->pelatihanlokasi ?? []);
        }

        $lamaran->update($data);

        return redirect()->route('cvats.index')->with('success', 'Data CV berhasil diperbarui!');
    }

    // DELETE: Soft Delete
    public function destroy($id)
    {
        $lamaran = LamaranModel::where('user_id', Auth::id())->findOrFail($id);
        $lamaran->delete();

        return redirect()->route('cvats.index')->with('success', 'Data CV berhasil dihapus!');
    }
    public function downloadPdf($id = null)
{
    if ($id) {
        // Jika dipanggil Admin (membawa ID Lamaran)
        $lamaran = LamaranModel::with('user')->find($id);
        if (!$lamaran) {
            return redirect()->back()->with('error', 'Data CV tidak ditemukan.');
        }
        $user = $lamaran->user; // Pastikan relasi 'user' sudah ada di LamaranModel
    } else {
        // Jika dipanggil oleh Pelamar sendiri
        $user = Auth::user();
        $lamaran = LamaranModel::where('user_id', $user->id)->latest()->first();
        if (!$lamaran) {
            return redirect()->back()->with('error', 'Data CV belum ditemukan.');
        }
    }

    // Nama file PDF
    $fileName = 'CV_ATS_' . str_replace(' ', '_', $lamaran->nama_lengkap ?? $user->name) . '.pdf';

    // Render template PDF
    $pdf = Pdf::loadView('compact.cvats_pdf', compact('user', 'lamaran'))
             ->setPaper('a4', 'portrait');

    return $pdf->stream($fileName);
}
}