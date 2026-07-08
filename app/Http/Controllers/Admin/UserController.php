<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SiswaTemplateExport;
use App\Http\Controllers\Controller;
use App\Imports\SiswaImport;
use App\Models\Membership;
use App\Models\SiswaProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

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

        $users = $query->get();
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

    public function store(Request $request)
{
    $authUser = auth()->user();
    $authRole = (int) $authUser->role;
    $authEmail = $authUser->email;

    // 1. Validasi Dasar (Email & Password dikondisikan jika BUKAN siswa)
    $rules = [
        'name' => 'required|string|max:255',
        'role' => 'required|integer',
        'membership_id' => 'nullable|exists:memberships,id',
        'masa_aktif_member' => 'required_if:role,4|nullable|date',
        
        // Field tambahan khusus Siswa (Diharuskan jika role = 6)
        'nisn' => 'required_if:role,6|nullable|string|max:20',
        'kelas' => 'nullable|string|max:50',
        'jenis_kelamin' => 'nullable|in:L,P',
        'no_telp' => 'nullable|string|max:20',
        'beasiswa' => 'nullable|integer|in:0,1,2',
        'alamat' => 'nullable|string',
    ];

    // Jika BUKAN siswa (Role 4 atau 5), email dan password wajib diisi manual
    if ((int)$request->role !== 6) {
        $rules['email'] = 'required|string|email|max:255|unique:users|not_in:cb@bankir.academy';
        $rules['password'] = 'required|string|min:8';
    }

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
        'nisn.required_if' => 'Siswa wajib mengisi NISN.',
    ]);

    // 2. Mapping Bank & Sekolah ID
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

    // 3. Logic Khusus Generate Data Siswa (Sama seperti Import)
    $emailSiswa = $request->email;
    $passwordSiswa = $request->password;
    $beasiswaStatus = (int) $request->beasiswa ?? 0;
    $saldoAwalSiswa = 0;


    if ((int)$request->role === 6) {
        $nisn = trim($request->nisn);
        $emailSiswa = $nisn . '@gmail.com';
        $passwordSiswa = $nisn . 'Bankir!';

        // Cek duplikat email/NISN manual sebelum insert
        $existingUser = User::where('email', $emailSiswa)->first();
        if ($existingUser) {
            return redirect()->back()->withInput()->withErrors(['nisn' => 'NISN sudah terdaftar di sistem (' . $emailSiswa . ').']);
        }

        // Tentukan status beasiswa otomatis berdasarkan yang menginput
        if ($beasiswaStatus === 1) { // Jika di form dipilih beasiswa
            if ($authEmail === 'cb@bankir.academy' || $authRole === 4) {
                $beasiswaStatus = 1; // Langsung aktif
            } else if ($authRole === 5) {
                $beasiswaStatus = 2; // Pending jika sekolah yang input
            }
        }

        // --- PROTEKSI LIMIT KUOTA SISWA & BEASISWA ---
        $targetBank = User::find($bankId);
        if ($targetBank && $targetBank->membership_id) {
            $membership = $targetBank->membership;
            if ($membership) {
                // Cek kuota umum
                 $saldoAwalSiswa = $membership->saldo_siswa ?? 0;
                if (!is_null($membership->limit_siswa)) {
                    $currentSiswaCount = User::where('role', 6)->where('sekolah_id', $sekolahId)->count();
                    if ($currentSiswaCount >= (int)$membership->limit_siswa) {
                        return redirect()->back()->withInput()->withErrors(['role' => 'Kuota maksimal siswa untuk sekolah ini (' . $membership->limit_siswa . ' siswa) sudah penuh.']);
                    }
                }
                // Cek kuota beasiswa (hanya jika statusnya langsung aktif / 1)
                if ($beasiswaStatus === 1 && !is_null($membership->limit_beasiswa)) {
                    $currentBeasiswaCount = \App\Models\SiswaProfile::where('beasiswa', 1)
                        ->whereHas('user', function($query) use ($sekolahId) {
                            $query->where('sekolah_id', $sekolahId);
                        })->count();
                    if ($currentBeasiswaCount >= (int)$membership->limit_beasiswa) {
                        return redirect()->back()->withInput()->withErrors(['role' => 'Kuota beasiswa untuk sekolah ini (' . $membership->limit_beasiswa . ' siswa) sudah penuh.']);
                    }
                }
            }
        }
    }

    // 4. Mulai Transaksi Database agar aman
    DB::beginTransaction();
    try {
        $user = User::create([
            'name' => $request->name,
            'email' => $emailSiswa,
            'role' => $request->role,
            'password' => Hash::make($passwordSiswa),
            'membership_id' => $request->role == 4 ? $request->membership_id : null,
            'masa_aktif_member' => $request->role == 4 ? $request->masa_aktif_member : null,
            'bank_id' => $bankId,
            'sekolah_id' => $sekolahId,
        ]);

        // Simpan ke tabel siswa_profiles jika role-nya Siswa
        if ((int)$request->role === 6) {
            \App\Models\SiswaProfile::create([
                'user_id' => $user->id,
                'no_telp' => $request->no_telp,
                'jenis_kelamin' => $request->jenis_kelamin,
                'nisn' => trim($request->nisn),
                'kelas' => $request->kelas,
                'beasiswa' => $beasiswaStatus,
                'alamat' => $request->alamat,
                'email' => $request->email_pribadi, // simpan email asli jika diinput
                'saldo' => $saldoAwalSiswa,
            ]);
        }

        DB::commit();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withInput()->withErrors(['role' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
    }
}
    public function downloadTemplate()
    {
        return Excel::download(new SiswaTemplateExport, 'template_import_siswa.xlsx');
    }

    public function import(Request $request)
    {
        $authUser = auth()->user();
        $authRole = (int) $authUser->role;
        $authEmail = $authUser->email;

        $rules = [
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:10240',
        ];

        if ($authEmail === 'cb@bankir.academy') {
            $rules['import_bank_id'] = 'required|exists:users,id';
            $rules['import_sekolah_id'] = 'required|exists:users,id';
        } else if ($authRole === 4) {
            $rules['import_sekolah_id'] = 'required|exists:users,id';
        }

        $request->validate($rules, [
            'import_bank_id.required' => 'Wajib memilih Bank tujuan import.',
            'import_sekolah_id.required' => 'Wajib memilih Sekolah tujuan import.',
        ]);

        // 1. Mulai Transaksi Database
        DB::beginTransaction();

        try {
            $siswaImport = new SiswaImport($request->import_bank_id, $request->import_sekolah_id);

            // Proses pembacaan file excel
            Excel::import($siswaImport, $request->file('file_excel'));

            $totalSuccess = 0;
            $allErrors = [];

            foreach ($siswaImport->sheetInstances as $sheet) {
                $totalSuccess += $sheet->successCount;
                if (!empty($sheet->errors)) {
                    $allErrors = array_merge($allErrors, $sheet->errors);
                }
            }

            // 2. JIKA ADA ERROR (Kouta Penuh / NISN Duplikat), BATALKAN SEMUA DATA
            if (count($allErrors) > 0) {
                DB::rollBack(); // Menghapus kembali semua data yang sempat ter-insert selama proses import ini
                return redirect()->back()->withErrors($allErrors);
            }

            // 3. JIKA SUKSES TOTAL TANPA ERROR, SIMPAN PERMANEN
            DB::commit();
            return redirect()->back()->with('success', "Semua data siswa ({$totalSuccess} siswa) berhasil diimport.");
        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan jika ada crash program
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
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
        'role' => 'required|integer',
        'membership_id' => 'nullable|exists:memberships,id',
        'masa_aktif_member' => 'required_if:role,4|nullable|date',

        // Validasi field profil siswa
        'no_telp' => 'nullable|string|max:20',
        'jenis_kelamin' => 'nullable|in:L,P',
        'nisn' => 'required_if:role,6|nullable|string|max:20',
        'kelas' => 'nullable|string|max:50',
        'beasiswa' => 'nullable|integer|in:0,1,2',
        'alamat' => 'nullable|string',
    ];

    // Jika bukan siswa, validasi email biasa
    if ((int)$request->role !== 6) {
        $rules['email'] = 'required|string|email|max:255|not_in:cb@bankir.academy|unique:users,email,' . $user->id;
        $rules['password'] = 'nullable|string|min:8';
    }

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

    // Logic penentuan email & password siswa saat update
    $emailSiswa = $request->email;
    $beasiswaStatus = (int) $request->beasiswa ?? 0;

    if ((int)$request->role === 6) {
        $nisn = trim($request->nisn);
        $emailSiswa = $nisn . '@gmail.com';

        // Cek duplikat email/NISN dengan mengabaikan ID user ini sendiri
        $existingUser = User::where('email', $emailSiswa)->where('id', '!=', $user->id)->first();
        if ($existingUser) {
            return redirect()->back()->withInput()->withErrors(['nisn' => 'NISN sudah terdaftar di sistem.']);
        }

        if ($beasiswaStatus === 1) {
            if ($authEmail === 'cb@bankir.academy' || $authRole === 4) {
                $beasiswaStatus = 1;
            } else if ($authRole === 5) {
                $beasiswaStatus = 2;
            }
        }

        // --- PROTEKSI LIMIT KUOTA ---
        $targetBank = User::find($bankId);
        if ($targetBank && $targetBank->membership_id) {
            $membership = $targetBank->membership;
            if ($membership) {
                if (!is_null($membership->limit_siswa)) {
                    $currentSiswaCount = User::where('role', 6)->where('sekolah_id', $sekolahId)->where('id', '!=', $user->id)->count();
                    if ($currentSiswaCount >= (int)$membership->limit_siswa) {
                        return redirect()->back()->withInput()->withErrors(['role' => 'Kuota siswa untuk sekolah ini telah penuh.']);
                    }
                }
            }
        }
    }

    $data = [
        'name' => $request->name,
        'email' => $emailSiswa,
        'role' => $request->role,
        'membership_id' => $request->role == 4 ? $request->membership_id : null,
        'masa_aktif_member' => $request->role == 4 ? $request->masa_aktif_member : null,
        'bank_id' => $bankId,
        'sekolah_id' => $sekolahId,
    ];

    // Jika password diisi manual (untuk non-siswa), atau generate ulang password siswa jika NISN berubah
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    } elseif ((int)$request->role === 6) {
        // Jika siswa diupdate, password disesuaikan ulang dengan NISN barunya
        $data['password'] = Hash::make(trim($request->nisn) . 'Bankir!');
    }

    DB::beginTransaction();
    try {
        $user->update($data);

        if ((int)$request->role === 6) {
            \App\Models\SiswaProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'no_telp'       => $request->no_telp,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'nisn'          => trim($request->nisn),
                    'kelas'         => $request->kelas,
                    'beasiswa'      => $beasiswaStatus,
                    'alamat'        => $request->alamat,
                ]
            );
        } else {
            \App\Models\SiswaProfile::where('user_id', $user->id)->delete();
        }

        DB::commit();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withInput()->withErrors(['role' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
    }
}

    public function destroy(User $user)
    {
        // Cek apakah user memiliki profile siswa, jika ada hapus terlebih dahulu
        if ($user->siswa) {
            $user->siswa()->delete();
        }

        // Hapus data user utama
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna dan data profil berhasil dihapus.');
    }
    public function beasiswaApprovalList()
{
    $authUser = auth()->user();
    $authRole = (int) $authUser->role;
    $authEmail = $authUser->email;

    // Hanya Root (email tertentu) dan Bank (role 4) yang boleh mengakses menu ini
    if ($authEmail !== 'cb@bankir.academy' && $authRole !== 4) {
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }

    // Query profil siswa yang status beasiswanya Pending (2)
    $query = SiswaProfile::with(['user.sekolah', 'user.bank'])->where('beasiswa', 2);

    // Jika yang login adalah Bank, filter hanya sekolah di bawah naungannya
    if ($authRole === 4) {
        $query->whereHas('user', function ($q) use ($authUser) {
            $q->where('bank_id', $authUser->id);
        });
    }

    $pendingSiswa = $query->latest()->get();

    return view('compact.beasiswa_approval', compact('pendingSiswa'));
}

public function beasiswaApprovalProcess($id, $action)
{
    $authUser = auth()->user();
    $authRole = (int) $authUser->role;
    $authEmail = $authUser->email;

    if ($authEmail !== 'cb@bankir.academy' && $authRole !== 4) {
        abort(403);
    }

    $profile = SiswaProfile::findOrFail($id);
    $userSiswa = $profile->user;

    if ($action === 'approve') {
        // Cek Kuota Beasiswa Bank terlebih dahulu sebelum approve
        $targetBank = User::find($userSiswa->bank_id);
        if ($targetBank && $targetBank->membership_id) {
            $membership = $targetBank->membership;
            if ($membership && !is_null($membership->limit_beasiswa)) {
                
                // Hitung kuota beasiswa aktif saat ini di sekolah terkait
                $currentBeasiswaCount = SiswaProfile::where('beasiswa', 1)
                    ->whereHas('user', function($q) use ($userSiswa) {
                        $q->where('sekolah_id', $userSiswa->sekolah_id);
                    })->count();

                if ($currentBeasiswaCount >= (int)$membership->limit_beasiswa) {
                    return redirect()->back()->with('error', "Gagal Approve! Kuota beasiswa untuk sekolah {$userSiswa->sekolah->name} sudah penuh ({$membership->limit_beasiswa} siswa).");
                }
            }
        }

        // Ubah status menjadi 1 (Aktif Beasiswa)
        $profile->update(['beasiswa' => 1]);
        return redirect()->back()->with('success', "Beasiswa untuk siswa {$userSiswa->name} berhasil disetujui.");

    } elseif ($action === 'reject') {
        // Ubah status menjadi 0 (Kembali ke Non-Beasiswa / Ditolak)
        $profile->update(['beasiswa' => 0]);
        return redirect()->back()->with('success', "Pengajuan beasiswa untuk siswa {$userSiswa->name} telah ditolak.");
    }

    return redirect()->back()->with('error', 'Aksi tidak valid.');
}
}