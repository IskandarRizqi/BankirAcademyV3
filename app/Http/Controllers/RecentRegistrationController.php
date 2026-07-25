<?php

namespace App\Http\Controllers;

use App\Models\RecentRegistration;
use Illuminate\Http\Request;

class RecentRegistrationController extends Controller
{
    // Tampilan Halaman Admin CRUD
    public function index()
    {
        $registrations = RecentRegistration::orderBy('id', 'desc')->get();
        return view('compact.dummy.index', compact('registrations'));
    }

    // Simpan Data Baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'city'       => 'required|string|max:255',
            'program'    => 'required|string|max:255',
            'avatar_url' => 'nullable|url',
            'is_active'  => 'required|boolean',
        ]);

        RecentRegistration::create($validated);

        return redirect()->back()->with('success', 'Data pendaftar baru berhasil ditambahkan!');
    }

    // Update Data
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'city'       => 'required|string|max:255',
            'program'    => 'required|string|max:255',
            'avatar_url' => 'nullable|url',
            'is_active'  => 'required|boolean',
        ]);

        $item = RecentRegistration::findOrFail($id);
        $item->update($validated);

        return redirect()->back()->with('success', 'Data pendaftar berhasil diperbarui!');
    }

    // Hapus Data
    public function destroy($id)
    {
        $item = RecentRegistration::findOrFail($id);
        $item->delete();

        return redirect()->back()->with('success', 'Data pendaftar berhasil dihapus!');
    }

    // API Endpoint untuk Popup
    public function getRandomCustomer()
    {
        $customer = RecentRegistration::where('is_active', true)
            ->inRandomOrder()
            ->first();

        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'No data found'], 404);
        }

        $avatar = $customer->avatar_url 
            ? $customer->avatar_url 
            : 'https://ui-avatars.com/api/?name=' . urlencode($customer->name) . '&background=random';

        return response()->json([
            'success' => true,
            'data' => [
                'name'    => $customer->name,
                'city'    => $customer->city,
                'program' => $customer->program,
                'avatar'  => $avatar,
                'time'    => $customer->created_at ? $customer->created_at->diffForHumans() : 'Baru saja'
            ]
        ]);
    }
}