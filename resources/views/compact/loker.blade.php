@extends('layouts.compact')
@section('content')

<div class="row" id="cancel-row">
    <div class="col-12 layout-top-spacing layout-spacing">

        {{-- HERO BANNER ACE --}}
        <div class="job-banner p-5 text-center text-md-left mb-4 shadow-sm">
            <div class="row align-items-center">
                <div class="col-md-8 text-white">
                    <span class="badge badge-pill mb-2" style="background: rgba(255,255,255,0.2); color: #fff;">
                        💼 Career Center
                    </span>
                    <h2 class="display-5 font-weight-bold mb-1" style="letter-spacing: -1px;">Bursa Lowongan Kerja 💫</h2>
                    <p class="mb-0 text-white-50" style="font-size: 1rem;">Temukan peluang karir, magang, dan program eksklusif mitra perusahaan dalam satu pintu.</p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- {{-- KIRI: FILTER STATIS & INFO SELEKSI --}}
            <div class="col-lg-4 mb-4">
                <div class="card glass-card p-4">
                    <h5 class="font-weight-bold text-dark mb-3 d-flex align-items-center">
                        <span class="mr-2" style="font-size: 1.3rem;">🎯</span> Cari Peluang
                    </h5>
                    
                    <div class="form-group mb-3">
                        <label class="text-muted small font-weight-bold mb-1">Tipe Pekerjaan</label>
                        <div class="info-badge w-100 mb-2">Full-Time / Magang (Internship)</div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="text-muted small font-weight-bold mb-1">Kategori Pendidikan</label>
                        <div class="info-badge w-100">SMA / SMK / Alumni</div>
                    </div>

                    <hr class="w-100" style="border-color: #F1F5F9;">

                    {{-- STATUS NOTIFIKASI FITUR BARU --}}
                    <div class="p-3 rounded-lg text-left" style="background: #FAF5FF; border: 1px solid #E9D5FF;">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge badge-warning p-2 mr-2" style="border-radius: 8px;">📢 Info Sistem</span>
                        </div>
                        <p class="mb-0 text-purple small font-weight-bold">
                            Modul ini terintegrasi dengan mitra perusahaan nasional. Temukan lowongan resmi Anda di bawah ini!
                        </p>
                    </div>
                </div>
            </div> -->

            {{-- KANAN: LIST LOWONGAN DINAMIS --}}
            <div class="col-lg-12 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="font-weight-bold text-dark mb-0">Lowongan Tersedia</h5>
                    <span class="badge badge-secondary p-2">Total: {{ $totalLoker }} Lowongan</span>
                </div>

                <div class="row">
                    @forelse($lokers as $loker)
                        {{-- CARD LOWONGAN --}}
                        <div class="col-md-4 mb-4">
                            {{-- Catatan: Jika ingin menghilangkan efek buram Coming Soon, hapus class 'coming-soon-overlay' di bawah ini --}}
                            <div class="card glass-card p-4 h-100 shadow-sm">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-primary text-white p-3 rounded-lg mr-3 font-weight-bold" style="font-size: 1rem; width: 50px; height: 50px; display:flex; align-items:center; justify-content:center;">
                                        @if($loker->image)
                                            <img src="{{ asset('storage/' . $loker->image) }}" alt="Logo" class="img-fluid rounded">
                                        @else
                                            {{ substr($loker->nama ?? 'PT', 0, 2) }}
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="font-weight-bold text-dark mb-0">{{ $loker->title }}</h6>
                                        <small class="text-muted">{{ $loker->nama ?? ($loker->perusahaan->nama ?? 'Perusahaan') }}</small>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    {{-- Loop array untuk Type --}}
                                    @if(is_array($loker->type))
                                        @foreach($loker->type as $type)
                                            <span class="badge badge-success mb-2 mr-1">{{ ucfirst($type) }}</span>
                                        @endforeach
                                    @else
                                        <span class="badge badge-success mb-2">{{ $loker->type }}</span>
                                    @endif

                                    {{-- Deskripsi HTML disembunyikan tagnya, dibatasi jika terlalu panjang --}}
                                    <div class="text-muted small mb-2 text-truncate-2">
                                        {!! Str::limit(strip_tags($loker->deskripsi), 120) !!}
                                    </div>

                                    {{-- Loop array untuk Skill --}}
                                    @if(is_array($loker->skill))
                                        <div class="mt-2">
                                            @foreach($loker->skill as $skill)
                                                <span class="badge badge-light border text-secondary mr-1 mb-1" style="font-size: 10px;">#{{ $skill }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center" style="border-color: #F1F5F9 !important;">
                                    <span class="text-muted small">📍 {{ $loker->kabupaten_name ?: 'Lokasi N/A' }}</span>
                                    <a href="{{ route('lowongan.show', $loker->id) }}" class="text-primary font-weight-bold small text-decoration-none">Lihat Detail →</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center my-5">
                            <h5 class="text-muted">Belum ada lowongan yang tersedia saat ini.</h5>
                        </div>
                    @endforelse
                </div>

                {{-- FOOTER INFO --}}
                <div class="card glass-card p-3 text-center">
                    <small class="text-muted font-italic">
                        💡 Kamu akan menerima notifikasi email otomatis saat ada bursa kerja baru yang dibuka oleh admin sekolah.
                    </small>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection