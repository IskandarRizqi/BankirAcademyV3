<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 1. Tampilkan semua pengguna (Read - Index)
    public function index()
{
    // 1. Ambil data user yang sedang login
    $currentUser = auth()->user();
    $currentRole = (int) $currentUser->role;
    $currentEmail = $currentUser->email;

    // 2. Inisialisasi query dasar untuk model User
    $query = User::latest();

    // 3. Terapkan filter berdasarkan aturan role
    if ($currentRole === 4 && $currentEmail === 'cb@bankir.academy') {
        // Khusus email ini: Bisa melihat role 3, 4, 5, 6
        $query->where('role', '>=', 4);
    } else {
        // Aturan umum: Hanya bisa melihat role yang ANGKA-nya LEBIH BESAR (di bawah tingkatannya)
        $query->where('role', '>', $currentRole);
    }

    // 4. Ambil data dengan pagination
    $users = $query->paginate(10);

    // 5. Kembalikan ke view
    return view('compact.pengguna', compact('users'));
}

    // 2. Tampilkan form tambah pengguna (Create)
    public function create()
    {
        return view('users.create');
    }

    // 3. Simpan pengguna baru ke database (Store)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password), // Hash password demi keamanan
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    // 4. Tampilkan form edit pengguna (Edit)
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // 5. Perbarui data pengguna (Update)
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string',
            'password' => 'nullable|string|min:8', // Password opsional saat update
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Jika password diisi, hash dan masukkan ke data update
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    // 6. Hapus pengguna (Delete/Destroy)
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}