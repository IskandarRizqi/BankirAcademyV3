<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Tampilkan semua pengguna
    public function index()
    {
        $currentUser = auth()->user();
        $currentRole = (int) $currentUser->role;
        $currentEmail = $currentUser->email;

        // Sematkan proteksi: Sembunyikan akun root utama dari list tabel apa pun
        $query = User::where('email', '!=', 'cb@bankir.academy')->latest();

        if ($currentRole === 4 && $currentEmail === 'cb@bankir.academy') {
            // Khusus root: Bisa melihat semua role dari tingkatan 4 sampai 6
            $query->where('role', '>=', 4);
        } else {
            // Aturan umum: Hanya bisa melihat role yang ANGKA-nya LEBIH BESAR
            $query->where('role', '>', $currentRole);
            
            // Tambahan Kondisi: Jika yang login Bank biasa, batasi hanya melihat Sekolah/Siswa milik Bank tersebut
            if ($currentRole === 4) {
                $query->where('bank_id', $currentUser->id);
            }
            // Tambahan Kondisi: Jika yang login Sekolah, batasi hanya melihat Siswa milik Sekolah tersebut
            if ($currentRole === 5) {
                $query->where('sekolah_id', $currentUser->id);
            }
        }

        $users = $query->paginate(10);
        $memberships = Membership::orderBy('nama', 'asc')->get();
        
        // Proteksi Dropdown: Pastikan akun root tidak ikut terambil di list pendaftaran Bank
        $listBank = User::where('role', 4)
                        ->where('email', '!=', 'cb@bankir.academy')
                        ->orderBy('name', 'asc')
                        ->get();
                        
        // Query Sekolah disesuaikan dengan siapa yang login
        $sekolahQuery = User::where('role', 5)->orderBy('name', 'asc');
        if ($currentRole === 4 && $currentEmail !== 'cb@bankir.academy') {
            // Jika Bank biasa, hanya ambil sekolah yang terikat dengan Bank ini
            $sekolahQuery->where('bank_id', $currentUser->id);
        }
        $listSekolah = $sekolahQuery->get();

        return view('compact.pengguna', compact('users', 'memberships', 'listBank', 'listSekolah'));
    }

    public function create()
    {
        return view('users.create');
    }

    // Simpan pengguna baru
    public function store(Request $request)
    {
        $authUser = auth()->user();
        $authRole = (int) $authUser->role;
        $authEmail = $authUser->email;

        // Validasi Dinamis Berdasarkan Kondisi Login
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users|not_in:cb@bankir.academy',
            'role' => 'required|integer',
            'password' => 'required|string|min:8',
            'membership_id' => 'nullable|exists:memberships,id',
        ];

        // Rules conditional untuk Bank/Sekolah pendonor relasi
        if ($authEmail === 'cb@bankir.academy') {
            $rules['bank_id'] = 'required_if:role,5,6|nullable|exists:users,id';
            $rules['sekolah_id'] = 'required_if:role,6|nullable|exists:users,id';
        } else if ($authRole === 4) {
            // Jika Bank biasa login, dia wajib memilih sekolah jika ingin membuat siswa (role 6)
            $rules['sekolah_id'] = 'required_if:role,6|nullable|exists:users,id';
        }

        $request->validate($rules, [
            'email.not_in' => 'Email ini dilindungi sistem dan tidak dapat digunakan.',
            'bank_id.required_if' => 'Akun Sekolah dan Siswa wajib memilih Bank terlebih dahulu.',
            'sekolah_id.required_if' => 'Akun Siswa wajib memilih Sekolah terlebih dahulu.',
        ]);

        // Mapping Data Otomatis berdasarkan Siapa yang Login
        $bankId = null;
        $sekolahId = null;

        if ($authEmail === 'cb@bankir.academy') {
            $bankId = in_array($request->role, [5, 6]) ? $request->bank_id : null;
            $sekolahId = $request->role == 6 ? $request->sekolah_id : null;
        } else if ($authRole === 4) {
            // Jika Bank biasa login, otomatis set bank_id ke dirinya sendiri
            $bankId = in_array($request->role, [5, 6]) ? $authUser->id : null;
            $sekolahId = $request->role == 6 ? $request->sekolah_id : null;
        } else if ($authRole === 5) {
            // Jika Sekolah login, otomatis set bank_id dan sekolah_id dari instansi sekolah tersebut
            $bankId = $authUser->bank_id;
            $sekolahId = $authUser->id;
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'membership_id' => $request->role == 4 ? $request->membership_id : null,
            'bank_id' => $bankId,
            'sekolah_id' => $sekolahId,
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Perbarui data pengguna
    public function update(Request $request, User $user)
    {
        if ($user->email === 'cb@bankir.academy' && auth()->user()->email !== 'cb@bankir.academy') {
            abort(403, 'Aksi ini tidak diizinkan.');
        }

        $authUser = auth()->user();
        $authRole = (int) $authUser->role;
        $authEmail = $authUser->email;

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|not_in:cb@bankir.academy|unique:users,email,' . $user->id,
            'role' => 'required|integer',
            'password' => 'nullable|string|min:8',
            'membership_id' => 'nullable|exists:memberships,id',
        ];

        if ($authEmail === 'cb@bankir.academy') {
            $rules['bank_id'] = 'required_if:role,5,6|nullable|exists:users,id';
            $rules['sekolah_id'] = 'required_if:role,6|nullable|exists:users,id';
        } else if ($authRole === 4) {
            $rules['sekolah_id'] = 'required_if:role,6|nullable|exists:users,id';
        }

        $request->validate($rules, [
            'email.not_in' => 'Email ini dilindungi sistem dan tidak dapat digunakan.',
            'bank_id.required_if' => 'Akun Sekolah dan Siswa wajib memilih Bank terlebih dahulu.',
            'sekolah_id.required_if' => 'Akun Siswa wajib memilih Sekolah terlebih dahulu.',
        ]);

        $bankId = null;
        $sekolahId = null;

        if ($authEmail === 'cb@bankir.academy') {
            $bankId = in_array($request->role, [5, 6]) ? $request->bank_id : null;
            $sekolahId = $request->role == 6 ? $request->sekolah_id : null;
        } else if ($authRole === 4) {
            $bankId = in_array($request->role, [5, 6]) ? $authUser->id : null;
            $sekolahId = $request->role == 6 ? $request->sekolah_id : null;
        } else if ($authRole === 5) {
            $bankId = $authUser->bank_id;
            $sekolahId = $authUser->id;
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'membership_id' => $request->role == 4 ? $request->membership_id : null,
            'bank_id' => $bankId,
            'sekolah_id' => $sekolahId,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}