@extends('layouts.compact')
@section('content')

<div class="row layout-top-spacing">
    <div class="col-12 mb-4">
        {{-- Tombol Kembali --}}
        <a href="{{ route('lowongan') }}" class="btn btn-sm btn-outline-primary mb-3">
            ← Kembali ke Bursa Lowongan
        </a>

        <div class="row">
            {{-- KIRI: DETAIL UTAMA LOWONGAN --}}
            <div class="col-lg-8 mb-4">
                <div class="card glass-card p-4 shadow-sm">
                    <div class="d-flex align-items-center pb-4 mb-4 border-bottom" style="border-color: #F1F5F9 !important;">
                        
                        {{-- LOGO DUMMY --}}
                        <div class="bg-primary text-white p-3 rounded-lg mr-3 font-weight-bold" style="font-size: 1.5rem; width: 70px; height: 70px; display:flex; align-items:center; justify-content:center; text-transform: uppercase;">
                            {{ substr($loker->title ?? ($loker->nama ?? 'PT'), 0, 2) }}
                        </div>
                        
                        <div>
                            <h3 class="font-weight-bold text-dark mb-1">{{ $loker->title }}</h3>
                            <h5 class="text-muted mb-2">{{ $loker->nama ?? ($loker->perusahaan->nama ?? 'Perusahaan Mitra') }}</h5>
                        </div>
                    </div>

                    {{-- Deskripsi Loker --}}
                    <div class="mb-4">
                        <h5 class="font-weight-bold text-dark mb-3">Deskripsi Pekerjaan</h5>
                        <div class="text-muted">
                            {!! $loker->deskripsi !!}
                        </div>
                    </div>

                    {{-- Jobdesk Loker --}}
                    @if($loker->jobdesk)
                        <div class="mb-4">
                            <h5 class="font-weight-bold text-dark mb-3">Tanggung Jawab / Tugas</h5>
                            <div class="text-muted">
                                {!! $loker->jobdesk !!}
                            </div>
                        </div>
                    @endif

                    {{-- Skills --}}
                    @if(is_array($loker->skill))
                        <div class="mb-2">
                            <h5 class="font-weight-bold text-dark mb-2">Keahlian yang Dibutuhkan</h5>
                            @foreach($loker->skill as $skill)
                                <span class="badge badge-light border text-secondary p-2 mr-1 mb-2" style="font-size: 12px;">#{{ $skill }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- KANAN: RINGKASAN & INFORMASI PERUSAHAAN --}}
            <div class="col-lg-4 mb-4">
                {{-- Card Ringkasan Info --}}
                <div class="card glass-card p-4 mb-4 shadow-sm">
                    <h5 class="font-weight-bold text-dark mb-3">Ringkasan Informasi</h5>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">📍 Lokasi Penempatan</small>
                        <span class="font-weight-bold text-dark">{{ $loker->kabupaten_name ?: ($loker->perusahaan->kabupaten_name ?? 'Lokasi N/A') }}</span>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">💰 Estimasi Gaji</small>
                        <span class="font-weight-bold text-success">
                            @if($loker->gaji_min)
                                Rp {{ number_format($loker->gaji_min, 0, ',', '.') }}
                            @else
                                Gaji tidak ditampilkan
                            @endif
                        </span>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">📅 Batas Pendaftaran</small>
                        <span class="font-weight-bold text-danger">
                            @if($loker->tanggal_custom)
                                @php
                                    $dates = explode(' - ', $loker->tanggal_custom);
                                @endphp
                                @if(count($dates) == 2)
                                    {{ \Carbon\Carbon::parse($dates[0])->locale('id')->isoFormat('D MMMM YYYY') }} 
                                    s/d 
                                    {{ \Carbon\Carbon::parse($dates[1])->locale('id')->isoFormat('D MMMM YYYY') }}
                                @else
                                    {{ \Carbon\Carbon::parse($loker->tanggal_custom)->locale('id')->isoFormat('D MMMM YYYY') }}
                                @endif
                            @else
                                Selesai kuota
                            @endif
                        </span>
                    </div>

                    {{-- MODIFIKASI: Tombol memicu Modal Statis --}}
                    <button class="btn btn-primary btn-block font-weight-bold" style="border-radius: 12px;" data-toggle="modal" data-target="#modalLamarStatis">
                        Kirim Lamaran Sekarang 🚀
                    </button>
                </div>

                {{-- Card Informasi Detail Perusahaan --}}
                @if($loker->perusahaan)
                    <div class="card glass-card p-4 shadow-sm">
                        <h5 class="font-weight-bold text-dark mb-3">Tentang Perusahaan</h5>
                        <div class="mb-3">
                            <small class="text-muted d-block">Nama Perusahaan</small>
                            <span class="font-weight-bold text-dark">{{ $loker->perusahaan->nama }}</span>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Email Kontak</small>
                            <span class="text-dark">{{ $loker->perusahaan->email ?? '-' }}</span>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Alamat Lengkap Mitra</small>
                            <small class="text-dark d-block">
                                {{ $loker->perusahaan->alamat }}, 
                                {{ $loker->perusahaan->kelurahan_name }}, 
                                {{ $loker->perusahaan->kecamatan_name }}, 
                                {{ $loker->perusahaan->kabupaten_name }}, 
                                {{ $loker->perusahaan->provinsi_name }}
                            </small>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ---------------------------------------------------------------- --}}
{{-- TAMBAHAN BARU: MODAL FORM LAMARAN STATIS (PROTOTYPE) --}}
{{-- ---------------------------------------------------------------- --}}
<div class="modal fade" id="modalLamarStatis" tabindex="-1" role="dialog" aria-labelledby="modalLamarStatisLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header bg-primary text-white" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h5 class="modal-title font-weight-bold text-white" id="modalLamarStatisLabel">Formulir Lamaran Kerja</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                {{-- Info Singkat Lowongan --}}
                <div class="p-3 mb-3 bg-light rounded-lg">
                    <small class="text-muted d-block">Melamar untuk Posisi:</small>
                    <strong class="text-dark">{{ $loker->title }}</strong>
                    <small class="text-muted d-block mt-1">Perusahaan: {{ $loker->nama ?? ($loker->perusahaan->nama ?? 'Mitra') }}</small>
                </div>

                {{-- Form Dummy --}}
                <form id="formLamarDummy" onsubmit="simulasiKirim(event)">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark small mb-1">Unggah CV / Resume (PDF)</label>
                        <input type="file" class="form-control-file" accept=".pdf" required>
                        <small class="text-muted form-text" style="font-size: 11px;">Maksimal ukuran file statis: 2MB.</small>
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark small mb-1">Pesan / Surat Lamaran Singkat</label>
                        <textarea class="form-control" rows="4" placeholder="Jelaskan secara singkat mengapa Anda cocok untuk posisi ini..." required></textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light mr-2 font-weight-bold" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">Kirim Lamaran ✈️</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Script Simulasi Interaksi Tanpa Database --}}
<script>
    function simulasiKirim(event) {
        event.preventDefault(); // Mencegah reload halaman
        
        // Sembunyikan modal
        $('#modalLamarStatis').modal('hide');

        // Tampilkan simulasi alert sukses (bisa diganti SweetAlert jika template Anda mendukung)
        alert('🎉 Simulasi Berhasil!\n\nTerima kasih, lamaran Anda untuk posisi "{{ $loker->title }}" telah disimulasikan terkirim ke sistem.');
    }
</script>

@endsection