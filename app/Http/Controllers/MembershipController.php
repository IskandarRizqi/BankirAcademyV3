<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Http\Requests\MembershipRequest;
use Illuminate\Support\Facades\Storage;

class MembershipController extends Controller
{
    public function index()
    {
        // Menggunakan paginate sejalan dengan app template links() Anda
        $memberships = Membership::latest()->paginate(10);
        return view('memberships.index', compact('memberships'));
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
}