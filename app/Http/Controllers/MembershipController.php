<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Http\Requests\MembershipRequest;
use App\Models\LokerModel;
use Illuminate\Support\Facades\Storage;

class MembershipController extends Controller
{
    public function index()
    {
        // Menggunakan paginate sejalan dengan app template links() Anda
        $memberships = Membership::latest()->paginate(10);
        return view('compact.memberships', compact('memberships'));
    }

    public function store(MembershipRequest $request)
    {
        $data = $request->validated();

        // Hitung Otomatis harga_final (Harga dikurangi nilai diskon persentase)
        $data['harga_final'] = $data['harga'] - ($data['harga'] * ($data['diskon'] / 100));

        // Handle upload gambar
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('membership', 'public');
        }

        Membership::create($data);

        return redirect()->back()->with('success', 'Membership berhasil ditambahkan!');
    }

    public function update(MembershipRequest $request, Membership $membership)
    {
        $data = $request->validated();

        // Hitung Ulang harga_final
        $data['harga_final'] = $data['harga'] - ($data['harga'] * ($data['diskon'] / 100));

        // Handle update gambar jika ada gambar baru yang diunggah
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($membership->gambar && Storage::disk('public')->exists($membership->gambar)) {
                Storage::disk('public')->delete($membership->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('membership', 'public');
        } else {
            // Tetap gunakan gambar lama jika tidak diganti
            unset($data['gambar']);
        }

        $membership->update($data);

        return redirect()->back()->with('success', 'Membership berhasil diperbarui!');
    }

    public function destroy(Membership $membership)
    {
        // Hapus file gambar fisik dari storage
        if ($membership->gambar && Storage::disk('public')->exists($membership->gambar)) {
            Storage::disk('public')->delete($membership->gambar);
        }

        $membership->delete();

        return redirect()->back()->with('success', 'Membership berhasil dihapus!');
    }
    public function loker()
    {
        // Mengambil semua data loker yang aktif (sesuaikan status jika diperlukan)
        $lokers = LokerModel::latest()->get();
        
        // Menghitung total lowongan
        $totalLoker = $lokers->count();

        return view('compact.loker', compact('lokers', 'totalLoker'));
    }
    public function detil_loker($id)
    {
        // Mencari loker berdasarkan ID, jika tidak ketemu akan memunculkan error 404
        $loker = LokerModel::findOrFail($id);
        
        return view('compact.loker-detail', compact('loker'));
    }
}