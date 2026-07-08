@extends('layouts.compact')

@section('content')
<div class="container pt-5">
    <div class="row justify-content-center pt-5">
        <div class="col-xl-10 col-lg-11">
            
            <div class="mb-4">
                <a href="{{ route('siswa.materi.belajar', [$materi->id]) }}" class="text-muted text-decoration-none font-weight-bold small">
                    <i class="fas fa-chevron-left mr-2"></i> Kembali ke Pratinjau Modul
                </a>
            </div>

            {{-- Alert Flash Message dari Controller --}}
            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius:12px;">
                    <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                </div>
            @endif

            <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 24px; background: #ffffff;">
                <div class="row no-gutters">
                    
                    {{-- SISI KIRI: DETAIL HARGA & PROGRAM --}}
                    <div class="col-md-6 p-4 p-lg-5 text-white d-flex flex-column justify-content-between" style="background: linear-gradient(135deg, #1E1B4B 0%, #312E81 100%);">
                        <div>
                            <span class="badge badge-pill px-3 py-2 mb-4" style="background: rgba(255, 255, 255, 0.15); color: #F3F4F6;">
                                <i class="fas fa-wallet mr-2 text-warning"></i> Checkout Pelatihan
                            </span>
                            <h4 class="text-muted small uppercase font-weight-bold mb-1" style="letter-spacing: 1px;">MODUL PROGRAM</h4>
                            <h2 class="font-weight-bold mb-3" style="line-height: 1.3; font-size: 1.75rem;">{{ $materi->nama }}</h2>
                            <p class="small text-light" style="opacity: 0.85; line-height: 1.6;">
                                {{ $materi->keterangan ?? 'Akses penuh kelas keahlian terstruktur berstandar industri khusus siswa reguler.' }}
                            </p>
                        </div>

                        <div class="mt-5 pt-4 border-top" style="border-color: rgba(255,255,255,0.1) !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted small d-block">TOTAL INVESTASI BELAJAR</span>
                                    <h3 class="font-weight-bold mb-0 text-warning" style="font-size: 2rem;">
                                        Rp {{ number_format($materi->harga, 0, ',', '.') }}
                                    </h3>
                                </div>
                                <div class="bg-warning text-dark p-3 rounded-circle d-none d-sm-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                                    <i class="fas fa-shopping-bag fa-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SISI KANAN: KONFIRMASI DATA & VALIDASI SALDO --}}
                    <div class="col-md-6 p-4 p-lg-5 bg-white d-flex flex-column justify-content-center">
                        <h4 class="font-weight-bold text-dark mb-1">Konfirmasi Data Siswa</h4>
                        <p class="text-muted small mb-4">Mohon periksa data diri Anda sebelum melanjutkan pemrosesan modul.</p>
                        
                        <div class="bg-light p-3 rounded-lg mb-4 border" style="border-radius: 12px;">
                            <div class="row mb-2">
                                <div class="col-4 text-muted small">Nama Lengkap</div>
                                <div class="col-8 font-weight-bold text-dark small">: {{ $user->name }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 text-muted small">Email Aktif</div>
                                <div class="col-8 font-weight-bold text-dark small">: {{ $user->email }}</div>
                            </div>
                            <div class="row">
                                <div class="col-4 text-muted small">Status Siswa</div>
                                <div class="col-8 font-weight-bold text-dark small">: 
                                    @if($statusBeasiswaSiswa == 1)
                                        <span class="text-success">Penerima Beasiswa</span>
                                    @else
                                        <span class="text-primary">Reguler (Non-Beasiswa)</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- KONDISI JIKA USER ADALAH SISWA BEASISWA --}}
                        @if($statusBeasiswaSiswa == 1)
                            @php
                                $saldoCukup = ($siswaProfile->saldo ?? 0) >= ($materi->harga ?? 0);
                            @endphp

                            <div class="p-3 rounded mb-4 text-center {{ $saldoCukup ? 'bg-light-success text-success border border-success' : 'bg-light-danger text-danger border border-danger' }}" style="border-radius: 12px; background-color: {{ $saldoCukup ? '#f0fdf4' : '#fef2f2' }};">
                                <span class="small d-block text-muted mb-1">SALDO BEASISWA ANDA</span>
                                <h4 class="font-weight-bold mb-1">Rp {{ number_format($siswaProfile->saldo ?? 0, 0, ',', '.') }}</h4>
                                
                                @if(!$saldoCukup)
                                    <small class="font-weight-bold d-block mt-2">
                                        <i class="fas fa-times-circle mr-1"></i> Maaf, Saldo Beasiswa Anda Tidak Mencukupi untuk modul ini.
                                    </small>
                                @else
                                    <small class="d-block text-muted mt-1">Saldo mencukupi untuk melakukan pemotongan otomatis.</small>
                                @endif
                            </div>

                            @if($saldoCukup)
                                <form action="{{ route('siswa.materi.bayar_beasiswa', $materi->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-block btn-lg py-3 font-weight-bold shadow-md" style="border-radius: 14px; border: none; font-size: 1.05rem;">
                                        <i class="fas fa-check-circle mr-2"></i> Potong Saldo & Ikuti Kelas
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-secondary btn-block btn-lg py-3 font-weight-bold text-white shadow-sm" disabled style="border-radius: 14px; cursor: not-allowed; font-size: 1.05rem;">
                                    <i class="fas fa-ban mr-2"></i> Saldo Tidak Cukup
                                </button>
                            @endif

                        {{-- KONDISI JIKA USER ADALAH SISWA REGULER --}}
                        @else
                            <h5 class="font-weight-bold text-dark mb-3" style="font-size: 0.95rem;">Metode Pembelajaran Yang Didapatkan:</h5>
                            <ul class="list-unstyled text-secondary small mb-5">
                                <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i> Akses Selamanya Video Pelajaran</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i> Unduh Modul Pendukung Materi (PDF)</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success mr-2"></i> Sertifikat Kelulusan Resmi Elektronik</li>
                            </ul>

                            <button class="btn btn-primary btn-block btn-lg py-3 font-weight-bold shadow-md" id="btn-proses-bayar" style="border-radius: 14px; background: #4F46E5; border: none; font-size: 1.05rem;">
                                <i class="fas fa-credit-card mr-2"></i> Selesaikan Pembayaran
                            </button>
                        @endif
                    </div>

                </div>
            </div>
            
        </div>
    </div>
</div>

@if($statusBeasiswaSiswa == 0)
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('btn-proses-bayar').addEventListener('click', function() {
        Swal.fire({
            title: 'Sistem Pembayaran Terpanggil',
            text: 'Coming Soon untuk Siswa Reguler',
            icon: 'info',
            confirmButtonColor: '#4F46E5',
            confirmButtonText: 'Selesai'
        });
    });
</script>
@endif
@endsection