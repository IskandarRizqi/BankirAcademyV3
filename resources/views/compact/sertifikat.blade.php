@extends('layouts.compact')
@section('content')

<div class="row" id="sertifikat-row">
    <div class="col-12 layout-top-spacing layout-spacing">

        {{-- HERO BANNER ACE --}}
        <div class="profile-banner p-5 text-center text-md-left mb-4 shadow-sm" style="background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); border-radius: 15px;">
            <div class="row align-items-center">
                <div class="col-md-8 text-white">
                    <span class="badge badge-pill mb-2" style="background: rgba(255,255,255,0.2); color: #fff;">
                        🏆 Pencapaian Belajar
                    </span>
                    <h2 class="display-5 font-weight-bold mb-1" style="letter-spacing: -1px;">Ruang Sertifikat & Kelulusan 🎓</h2>
                    <p class="mb-0 text-white-50" style="font-size: 1rem;">Lihat daftar kelas yang telah kamu selesaikan dan unduh sertifikat resmimu di sini.</p>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- KIRI: RINGKASAN PENCAPAIAN --}}
            <div class="col-lg-4 mb-4">
                <div class="card glass-card text-center p-4 h-100">
                    <div class="profile-avatar-wrapper mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: #FAF5FF; border: 2px solid #E9D5FF; border-radius: 50%;">
                        <span style="font-size: 2.5rem;">🏅</span>
                    </div>

                    <h4 class="font-weight-bold text-dark mb-1">{{ $user->name }}</h4>
                    <p class="text-muted small mb-3">Mari terus tingkatkan keahlianmu!</p>

                    <hr class="w-100" style="border-color: #F1F5F9;">

                    {{-- TOTAL SERTIFIKAT --}}
                    <div class="p-3 mb-3 rounded-lg text-left" style="background: #FAF5FF; border: 1px solid #E9D5FF;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Total Kelas Lulus</span>
                            <span class="badge badge-success p-2 font-weight-bold" style="border-radius: 8px; font-size: 0.9rem;">
                                {{ $sertifikats->count() }} Kelas 🔥
                            </span>
                        </div>
                    </div>

                    {{-- WIDGET INFO TAMBAHAN --}}
                    <div class="card wallet-card text-left p-3 shadow-sm border-0" style="background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%); border-radius: 12px; color: #fff;">
                        <span class="text-white-50 small">Kantong Prestasi 🪙</span>
                        <h3 class="font-weight-bold my-1 text-white">Ready to Print</h3>
                        <div class="d-flex justify-content-between align-items-center mt-2 pt-2" style="border-top: 1px solid rgba(255,255,255,0.1);">
                            <span class="small opacity-75">Status Validasi:</span>
                            <span class="badge badge-warning font-weight-bold">Verified ✅</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KANAN: DAFTAR KELAS & SERTIFIKAT DINAMIS --}}
            <div class="col-lg-8 mb-4">
                <div class="card glass-card p-4 h-100">
                    <h5 class="font-weight-bold text-dark mb-4 d-flex align-items-center">
                        <span class="mr-2" style="font-size: 1.5rem;">📜</span> Riwayat Kelas & Kelulusan
                    </h5>

                    <div class="row">
                        @forelse($sertifikats as $item)
                            <div class="col-12 mb-3">
                                <div class="p-3 rounded-lg border shadow-sm bg-white" style="border-color: #E2E8F0 !important;">
                                    <div class="row align-items-center">
                                        <div class="col-auto pr-0 d-none d-sm-block">
                                            <div class="p-3 rounded-lg bg-light text-center" style="width: 60px; height: 60px;">
                                                <span style="font-size: 1.6rem;">🎓</span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <span class="badge badge-light text-muted small mb-1" style="border: 1px solid #CBD5E1;">
                                                🆔 ID Sertifikat: {{ $item->id }}-{{ $item->class_id }}
                                            </span>
                                            {{-- Mengasumsikan ada relasi 'materi' di dalam model PrepotesUser --}}
                                            <h6 class="font-weight-bold text-dark mb-1">{{ $item->materi->nama ?? 'Modul Pembelajaran' }}</h6>
                                            <p class="mb-0 text-muted small">
                                                📅 Tanggal Lulus: <span class="text-purple font-weight-bold" style="color: #a855f7;">{{ $item->updated_at ? \Carbon\Carbon::parse($item->updated_at)->translatedFormat('d F Y') : '-' }}</span>
                                                | Skor: <span class="badge badge-success font-weight-bold py-0 px-1">{{ round($item->nilai_akhir) }}</span>
                                            </p>
                                        </div>
                                        <div class="col-12 col-md-auto mt-3 mt-md-0 text-right">
                                            {{-- Pemanggilan Route Sesuai Parameter Target dari Template Sertifikat --}}
@if($item->sertifikatMateri)
    @if($item->sertifikatMateri->target_type == 'sub_materi')
        <a href="{{ route('submateri.sertifikat', $item->sertifikatMateri->sub_materi_id) }}" class="btn btn-primary btn-sm px-3 shadow-sm" style="border-radius: 8px; background-color: #6366f1; border-color: #6366f1;">
            📥 Unduh Sertifikat (PDF)
        </a>
    @else
        <a href="{{ route('materi.sertifikat', $item->class_id) }}" class="btn btn-primary btn-sm px-3 shadow-sm" style="border-radius: 8px; background-color: #6366f1; border-color: #6366f1;">
            📥 Unduh Sertifikat (PDF)
        </a>
    @endif
@else
    <button class="btn btn-secondary btn-sm px-3 shadow-sm" style="border-radius: 8px;" disabled>
        ⚠️ Template Tidak Tersedia
    </button>
@endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <span style="font-size: 3rem;">📁</span>
                                <h6 class="font-weight-bold text-muted mt-3">Belum Ada Sertifikat Kelulusan</h6>
                                <p class="text-muted small mb-0">Selesaikan kuis/post-test materi dengan nilai di atas batas kelulusan (70).</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- FOOTER KARTU --}}
                    <div class="mt-4 pt-3 border-top text-right" style="border-color: #F1F5F9 !important;">
                        <small class="text-muted font-italic">
                            💡 Seluruh sertifikat diterbitkan secara resmi dan terintegrasi dengan sistem keamanan internal.
                        </small>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection