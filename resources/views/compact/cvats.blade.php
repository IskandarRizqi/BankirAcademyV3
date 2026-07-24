@extends('layouts.compact')
@section('content')

<div class="row" id="cv-ats-row">
    <div class="col-12 layout-top-spacing layout-spacing">
        @if(!$lamaran)
            <div class="alert alert-warning text-center my-5 p-4" style="border-radius: 12px;">
                <h5>Data Lamaran Belum Ditemukan</h5>
                <p class="mb-3">Anda belum mengisi informasi riwayat hidup / CV Anda.</p>
                <a href="{{ route('lamaran.create') }}" class="btn btn-primary font-weight-bold">
                    Isi Form Lamaran Sekarang
                </a>
            </div>
        @else

        {{-- HERO BANNER / HEADER CV --}}
        <div class="profile-banner p-4 p-md-5 text-center text-md-left mb-4 shadow-sm ats-header" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); border-radius: 15px;">
            <div class="row align-items-center">
                <div class="col-md-8 text-white">
                    <span class="badge badge-pill mb-2 d-print-none" style="background: rgba(255,255,255,0.2); color: #fff;">
                        💼 Curriculum Vitae
                    </span>
                    <h1 class="display-5 font-weight-bold mb-1 ats-fullname" style="letter-spacing: -1px;">
                        {{ $lamaran->nama_lengkap ?? $user->name ?? 'Nama Lengkap' }}
                    </h1>

                    @php
                        $jabatanUtama = 'Pelamar Kerja';
                        if (!empty($lamaran->pekerjaanjabatan)) {
                            $arrJabatan = is_array($lamaran->pekerjaanjabatan) 
                                ? $lamaran->pekerjaanjabatan 
                                : explode(',', $lamaran->pekerjaanjabatan);
                            $jabatanUtama = trim($arrJabatan[0]) ?: 'Pelamar Kerja';
                        }
                    @endphp

                    <h2 class="h5 mb-2 text-white-50 font-weight-normal ats-jobtitle">
                        {{ $jabatanUtama }}
                    </h2>

                    <p class="mb-0 small text-white-50 ats-contacts">
                        📍 {{ $lamaran->alamatdomisili ?? 'Alamat Domisili' }} 
                        @if(!empty($lamaran->telpdomisili)) | 📞 {{ $lamaran->telpdomisili }} @endif
                        | ✉️ {{ $user->email }}
                    </p>
                </div>

                <div class="col-md-4 text-md-right mt-3 mt-md-0 d-print-none">
                    <a href="{{ route('lamaran.edit', $lamaran->id) }}" class="btn btn-warning btn-sm font-weight-bold mr-1 shadow-sm">
                        ✏️ Edit Data
                    </a>
                    <form action="{{ route('lamaran.destroy', $lamaran->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data CV ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm font-weight-bold mr-1 shadow-sm">
                            🗑️ Hapus
                        </button>
                    </form>
                  <a href="{{ route('cvats.pdf') }}" target="_blank" class="btn btn-light btn-sm px-3 my-2 font-weight-bold shadow-sm" style="border-radius: 8px; color: #4f46e5;">
    📄 Download PDF (ATS Friendly)
</a>
                </div>
            </div>
        </div>

        <div class="row ats-body">
            {{-- KOLOM KIRI: INFO PERSONAL & PENDIDIKAN --}}
            <div class="col-lg-4 mb-4 ats-left-col">
                <div class="card p-4 h-100 border-0 shadow-sm ats-card" style="border-radius: 12px; background: #fff;">
                    
                    {{-- BIODATA --}}
                    <div class="mb-4 ats-section">
                        <h3 class="h5 font-weight-bold text-dark mb-3 ats-section-title" style="border-bottom: 2px solid #4f46e5; padding-bottom: 5px;">
                            Data Pribadi
                        </h3>
                        <ul class="list-unstyled text-muted small mb-0 ats-list">
                            <li class="mb-2"><strong>Tempat, Tgl Lahir:</strong><br>{{ $lamaran->tmpttgllahir ?? '-' }}</li>
                            <li class="mb-2"><strong>Agama:</strong><br>{{ $lamaran->namaagama ?? $lamaran->agama ?? '-' }}</li>
                            <li class="mb-2"><strong>Status Perkawinan:</strong><br>{{ $lamaran->statusperkawinan ?? '-' }}</li>
                            <li class="mb-2"><strong>Kode Pos:</strong><br>{{ $lamaran->kodepos ?? '-' }}</li>
                        </ul>
                    </div>

                    <hr class="d-print-none" style="border-color: #F1F5F9;">

                    {{-- RINGKASAN PROFIL --}}
                    @if(!empty($lamaran->pengalamanspesifik))
                    <div class="mb-4 ats-section">
                        <h3 class="h5 font-weight-bold text-dark mb-2 ats-section-title" style="border-bottom: 2px solid #4f46e5; padding-bottom: 5px;">
                            Ringkasan Profil
                        </h3>
                        <p class="text-muted small text-justify mb-0">
                            {{ $lamaran->pengalamanspesifik }}
                        </p>
                    </div>
                    <hr class="d-print-none" style="border-color: #F1F5F9;">
                    @endif

                    {{-- RIWAYAT PENDIDIKAN --}}
                    <div class="ats-section">
                        <h3 class="h5 font-weight-bold text-dark mb-3 ats-section-title" style="border-bottom: 2px solid #4f46e5; padding-bottom: 5px;">
                            Pendidikan
                        </h3>

                        {{-- Pascasarjana --}}
                        @if(!empty($lamaran->pascasarjananama))
                        <div class="mb-3 ats-item">
                            <strong class="text-dark small d-block">{{ $lamaran->pascasarjananama }}</strong>
                            <span class="text-muted small d-block">{{ $lamaran->pascasarjanafakultas }} ({{ $lamaran->pascasarjanagelar }})</span>
                            <small class="badge badge-light border text-muted mt-1 ats-year">{{ $lamaran->pascasarjanatahun }}</small>
                        </div>
                        @endif

                        {{-- Perguruan Tinggi (S1/D4) --}}
                        @if(!empty($lamaran->perguruannama))
                        <div class="mb-3 ats-item">
                            <strong class="text-dark small d-block">{{ $lamaran->perguruannama }}</strong>
                            <span class="text-muted small d-block">{{ $lamaran->perguruanfakultas }} ({{ $lamaran->perguruangelar }})</span>
                            <small class="badge badge-light border text-muted mt-1 ats-year">{{ $lamaran->perguruantahun }}</small>
                        </div>
                        @endif

                        {{-- Akademi/Diploma --}}
                        @if(!empty($lamaran->akademinama))
                        <div class="mb-3 ats-item">
                            <strong class="text-dark small d-block">{{ $lamaran->akademinama }}</strong>
                            <span class="text-muted small d-block">{{ $lamaran->akademifakultas }} ({{ $lamaran->akademigelar }})</span>
                            <small class="badge badge-light border text-muted mt-1 ats-year">{{ $lamaran->akademitahun }}</small>
                        </div>
                        @endif

                        {{-- SMA/SMK --}}
                        @if(!empty($lamaran->smanama))
                        <div class="mb-3 ats-item">
                            <strong class="text-dark small d-block">{{ $lamaran->smanama }}</strong>
                            <span class="text-muted small d-block">{{ $lamaran->smafakultas ?? 'SMA/SMK' }}</span>
                            <small class="badge badge-light border text-muted mt-1 ats-year">{{ $lamaran->smatahun }}</small>
                        </div>
                        @endif
                    </div>

                </div>
            </div>

            {{-- KOLOM KANAN: PENGALAMAN KERJA & SERTIFIKASI --}}
            <div class="col-lg-8 mb-4 ats-right-col">
                <div class="card p-4 h-100 border-0 shadow-sm ats-card" style="border-radius: 12px; background: #fff;">
                    
                    {{-- PENGALAMAN KERJA --}}
                    <div class="mb-4 ats-section">
                        <h3 class="h5 font-weight-bold text-dark mb-3 d-flex align-items-center ats-section-title">
                            <span class="mr-2 d-print-none" style="color: #4f46e5;">👔</span> Pengalaman Kerja
                        </h3>

                        @php
                            $perusahaanList = is_array($lamaran->pekerjaanperusahaan ?? null) 
                                ? $lamaran->pekerjaanperusahaan 
                                : array_filter(explode(',', $lamaran->pekerjaanperusahaan ?? ''));
                            
                            $jabatanList = is_array($lamaran->pekerjaanjabatan ?? null) 
                                ? $lamaran->pekerjaanjabatan 
                                : explode(',', $lamaran->pekerjaanjabatan ?? '');
                            
                            $tahunList = is_array($lamaran->pekerjaantahun ?? null) 
                                ? $lamaran->pekerjaantahun 
                                : explode(',', $lamaran->pekerjaantahun ?? '');
                                
                            $tanggungJawabList = is_array($lamaran->pekerjaantanggungjawab ?? null) 
                                ? $lamaran->pekerjaantanggungjawab 
                                : explode(';', $lamaran->pekerjaantanggungjawab ?? '');
                        @endphp

                        @forelse($perusahaanList as $index => $perusahaan)
                            <div class="work-item mb-3 pb-3 ats-item" style="border-bottom: 1px dashed #E2E8F0;">
                                <div class="d-flex justify-content-between align-items-start flex-wrap ats-item-header">
                                    <div>
                                        <h4 class="h6 font-weight-bold text-dark mb-0 ats-item-title">
                                            {{ $jabatanList[$index] ?? 'Posisi Pekerjaan' }}
                                        </h4>
                                        <span class="font-weight-bold small ats-company" style="color: #7c3aed;">
                                            {{ $perusahaan }}
                                        </span>
                                    </div>
                                    <span class="badge badge-light text-muted border ats-year">
                                        {{ $tahunList[$index] ?? '-' }}
                                    </span>
                                </div>
                                @if(!empty($tanggungJawabList[$index]))
                                    <p class="text-muted small mt-2 mb-0 ats-item-desc">
                                        {{ $tanggungJawabList[$index] }}
                                    </p>
                                @endif
                            </div>
                        @empty
                            <p class="text-muted small font-italic">Belum ada riwayat pengalaman kerja yang diisi.</p>
                        @endforelse
                    </div>

                    {{-- PELATIHAN / SERTIFIKASI --}}
                    <div class="mb-4 pt-2 ats-section">
                        <h3 class="h5 font-weight-bold text-dark mb-3 d-flex align-items-center ats-section-title">
                            <span class="mr-2 d-print-none" style="color: #4f46e5;">📜</span> Pelatihan & Sertifikasi
                        </h3>

                        @php
                            $pelatihanList = is_array($lamaran->pelatihannama ?? null) 
                                ? $lamaran->pelatihannama 
                                : array_filter(explode(',', $lamaran->pelatihannama ?? ''));
                            
                            $penyelenggaraList = is_array($lamaran->pelatihanpenyelanggara ?? null) 
                                ? $lamaran->pelatihanpenyelanggara 
                                : explode(',', $lamaran->pelatihanpenyelanggara ?? '');
                            
                            $tahunPelatihanList = is_array($lamaran->pelatihantahun ?? null) 
                                ? $lamaran->pelatihantahun 
                                : explode(',', $lamaran->pelatihantahun ?? '');
                        @endphp

                        <div class="row">
                            @forelse($pelatihanList as $idx => $namaPelatihan)
                                <div class="col-12 mb-2 ats-item">
                                    <div class="p-2 rounded bg-light border d-flex justify-content-between align-items-center flex-wrap ats-cert-box" style="border-color: #E2E8F0 !important;">
                                        <div class="small">
                                            <strong class="text-dark">{{ $namaPelatihan }}</strong>
                                            @if(!empty($penyelenggaraList[$idx]))
                                                <span class="text-muted"> | {{ $penyelenggaraList[$idx] }}</span>
                                            @endif
                                        </div>
                                        <small class="text-muted font-italic ats-year">
                                            Tahun: {{ $tahunPelatihanList[$idx] ?? '-' }}
                                        </small>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-muted small font-italic">Belum ada data pelatihan/sertifikasi.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- FOOTER KARTU --}}
                    <div class="mt-auto pt-3 border-top text-right d-print-none" style="border-color: #F1F5F9 !important;">
                        <small class="text-muted font-italic">
                            💡 Data ditarik secara otomatis berdasarkan informasi lamaran Anda di sistem.
                        </small>
                    </div>

                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection