@extends('layouts.compact')
@section('content')

<div class="row" id="cancel-row">
    <div class="col-12 layout-top-spacing layout-spacing">

        {{-- HERO BANNER ACE --}}
        <div class="profile-banner p-5 text-center text-md-left mb-4 shadow-sm">
            <div class="row align-items-center">
                <div class="col-md-8 text-white">
                    <span class="badge badge-pill mb-2" style="background: rgba(255,255,255,0.2); color: #fff;">
                        ⚡ {{ $user->role_name }} Account
                    </span>
                    <h2 class="display-5 font-weight-bold mb-1" style="letter-spacing: -1px;">My Profile Circle 💫</h2>
                    <p class="mb-0 text-white-50" style="font-size: 1rem;">Atur identitasmu, pantau saldo, dan cek keaktifan akun dalam satu tempat.</p>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- KIRI: AVATAR & RINGKASAN AKUN --}}
            <div class="col-lg-4 mb-4">
                <div class="card glass-card text-center p-4 h-100">
                    <div class="profile-avatar-wrapper mb-3">
                        @if($user->role_name == 'Siswa' && $user->siswa && $user->siswa->jenis_kelamin == 'Perempuan')
                            <img src="https://api.dicebear.com/7.x/adventurer/svg?seed=Harley" class="profile-avatar bg-warning" alt="Avatar">
                        @else
                            <img src="https://api.dicebear.com/7.x/adventurer/svg?seed=Felix" class="profile-avatar bg-info" alt="Avatar">
                        @endif
                    </div>

                    <h4 class="font-weight-bold text-dark mb-1">{{ $user->name }}</h4>
                    <p class="text-muted small mb-3">{{ $user->email }}</p>

                    <hr class="w-100" style="border-color: #F1F5F9;">

                    {{-- STATUS MEMBER --}}
                    <div class="p-3 mb-3 rounded-lg text-left" style="background: #FAF5FF; border: 1px solid #E9D5FF;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Status Membership</span>
                            <span class="badge {{ $user->masa_aktif_member && \Carbon\Carbon::parse($user->masa_aktif_member)->isFuture() ? 'badge-success' : 'badge-danger' }} p-2" style="border-radius: 8px;">
                                {{ $user->masa_aktif_member && \Carbon\Carbon::parse($user->masa_aktif_member)->isFuture() ? 'Aktif 🔥' : 'Expired 🔒' }}
                            </span>
                        </div>
                        @if($user->masa_aktif_member)
                            <p class="mb-0 mt-2 text-purple small font-weight-bold">
                                📅 Valid s/d: {{ \Carbon\Carbon::parse($user->masa_aktif_member)->translatedFormat('d F Y') }}
                            </p>
                        @endif
                    </div>

                    {{-- FITUR SALDO / WALLET (Hanya Tampil Jika Punya Data Saldo / Role Siswa) --}}
                    @if($user->role_name == 'Siswa' && $user->siswa)
                    <div class="card wallet-card text-left p-3 shadow-sm border-0">
                        <span class="text-white-50 small">Kantong Pintar 🪙</span>
                        <h3 class="font-weight-bold my-1 text-white">
                            Rp {{ number_format($user->siswa->saldo ?? 0, 0, ',', '.') }}
                        </h3>
                        <div class="d-flex justify-content-between align-items-center mt-2 pt-2" style="border-top: 1px solid rgba(255,255,255,0.1);">
                            <span class="small opacity-75">Beasiswa:</span>
                            <span class="badge badge-warning font-weight-bold">
                                {{ $user->siswa->beasiswa ? 'Dapat 🎉' : 'Reguler' }}
                            </span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- KANAN: DETAIL DATA PROFILE SESUAI ROLE --}}
            <div class="col-lg-8 mb-4">
                <div class="card glass-card p-4 h-100">
                    <h5 class="font-weight-bold text-dark mb-4 d-flex align-items-center">
                        <span class="mr-2" style="font-size: 1.5rem;">📋</span> Detail Informasi Akun
                    </h5>

                    <div class="row">
                        {{-- Data Umum --}}
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small font-weight-bold mb-1">Nama Lengkap</label>
                            <div class="info-badge w-100">{{ $user->name }}</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="text-muted small font-weight-bold mb-1">Email Terdaftar</label>
                            <div class="info-badge w-100">{{ $user->email }}</div>
                        </div>

                        {{-- DATA KHUSUS SISWA (SMA/SMK) --}}
                        @if($user->role_name == 'Siswa' && $user->siswa)
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small font-weight-bold mb-1">NISN (Nomor Induk Siswa Nasional)</label>
                                <div class="info-badge w-100">🆔 {{ $user->siswa->nisn ?? '-' }}</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small font-weight-bold mb-1">Kelas</label>
                                <div class="info-badge w-100">🏫 {{ $user->siswa->kelas ?? '-' }}</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small font-weight-bold mb-1">Nomor Telepon / WhatsApp</label>
                                <div class="info-badge w-100">📱 {{ $user->siswa->no_telp ?? '-' }}</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="text-muted small font-weight-bold mb-1">Jenis Kelamin</label>
                                <div class="info-badge w-100">
                                    {{ $user->siswa->jenis_kelamin == 'Laki-laki' ? '🙋‍♂️ Laki-laki' : ($user->siswa->jenis_kelamin == 'Perempuan' ? '🙋‍♀️ Perempuan' : '✨ ' . ($user->siswa->jenis_kelamin ?? '-')) }}
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="text-muted small font-weight-bold mb-1">Alamat Rumah</label>
                                <div class="info-badge w-100 text-wrap" style="height: auto; min-height: 40px;">
                                    📍 {{ $user->siswa->alamat ?? '-' }}
                                </div>
                            </div>
                        
                        {{-- DATA KHUSUS ROLE LAIN (Root, Sekolah, Bank, dll) --}}
                        @else
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small font-weight-bold mb-1">Role Akses</label>
                                <div class="info-badge w-100 text-primary">⚙️ {{ $user->role_name }}</div>
                            </div>
                            
                            @if($user->sekolah)
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small font-weight-bold mb-1">Afiliasi Sekolah</label>
                                <div class="info-badge w-100">🏢 {{ $user->sekolah->name }}</div>
                            </div>
                            @endif

                            @if($user->bank)
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small font-weight-bold mb-1">Mitra Bank</label>
                                <div class="info-badge w-100">🏦 {{ $user->bank->name }}</div>
                            </div>
                            @endif
                        @endif
                    </div>

                    {{-- FOOTER KARTU --}}
                    <div class="mt-4 pt-3 border-top text-right" style="border-color: #F1F5F9 !important;">
                        <small class="text-muted font-italic">
                            💡 Data kamu aman dilindungi enkripsi sistem & terlog otomatis.
                        </small>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection