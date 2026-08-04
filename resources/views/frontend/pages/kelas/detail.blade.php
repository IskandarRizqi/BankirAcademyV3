@extends('layouts.appfrontend')

@section('page-title')
    {{ $class->title }} — Bankir Academy
@endsection

@section('page-description')
    {{ $class->contents ?? strip_tags($class->content) }}
@endsection

@section('content')
    <section class="detail-hero">
        <div class="container detail-grid">
            <div>
                <div class="breadcrumb">
                    <a href="{{ route('frontend.home') }}">Beranda</a>
                    <span>›</span>
                    <a href="{{ route('frontend.classes.index') }}">Kelas Online</a>
                    <span>›</span>
                    <span>{{ $class->category ?? 'Umum' }}</span>
                </div>

                <span class="eyebrow">{{ $class->category ?? 'Kelas Online' }}</span>
                <h1>{{ $class->title }}</h1>
                <p class="hero-copy">{{ $class->contents ?? strip_tags($class->content) }}</p>

                <div class="hero-meta">
                    @if ($class->level)
                        <span>Level {{ $class->level }}</span>
                    @endif
                    @if ($class->tipe)
                        <span>{{ $class->tipe }}</span>
                    @endif
                    @if (!empty($class->content_list))
                        <span>{{ count($class->content_list) }} Modul</span>
                    @endif
                </div>

                <div class="hero-actions">
                    <a class="btn btn-primary" href="#pendaftaran">Mulai Belajar →</a>
                    <a class="btn btn-outline" href="{{ route('frontend.classes.index') }}">Kembali ke Katalog</a>
                </div>
            </div>

            <div class="preview-card">
                @php
                    $coverBg = !empty($class->image)
                        ? 'background-image: url(' .
                            asset('storage/' . $class->image) .
                            '); background-size: cover; background-position: center;'
                        : '';
                @endphp
                <div class="preview-cover theme-purple" style="{{ $coverBg }}">
                    <span class="preview-label">{{ $class->category ?? 'Umum' }}</span>
                    <h2>{{ $class->title }}</h2>
                    <div class="preview-bottom">
                        <div class="preview-stat">
                            <strong>{{ $class->level ?? 'Semua Level' }}</strong>
                            <span>Tingkat pembelajaran</span>
                        </div>
                        <div class="preview-stat">
                            <strong>{{ !empty($class->content_list) ? count($class->content_list) : 0 }} Modul</strong>
                            <span>Kurikulum terstruktur</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <nav class="sticky-nav">
        <div class="container sticky-links">
            <a href="#ringkasan">Ringkasan</a>
            <a href="#hasil-belajar">Hasil Belajar</a>
            <a href="#kurikulum">Kurikulum</a>
            <a href="#metode">Metode</a>
            <a href="#pendaftaran">Pendaftaran</a>
            <a href="#faq">FAQ</a>
        </div>
    </nav>

    <!-- Section Ringkasan & Tentang Kelas -->
    <section class="section" id="ringkasan">
        <div class="container overview-grid">
            <article class="content-card">
                <span class="eyebrow">Tentang Kelas</span>
                <h2>Pembelajaran Praktis dan Terarah</h2>

                {{-- Memuat deskripsi lengkap dari database (HTML support) --}}
                <div class="class-description">
                    {!! $class->content !!}
                </div>

                {{-- Menampilkan Tag / Topik Kelas jika ada --}}
                @if (!empty($class->tags))
                    @php $tags = is_array($class->tags) ? $class->tags : json_decode($class->tags, true); @endphp
                    @if ($tags)
                        <div class="outcome-grid" id="hasil-belajar">
                            @foreach ($tags as $tag)
                                <article class="outcome-card"><i>✓</i><strong>{{ $tag }}</strong></article>
                            @endforeach
                        </div>
                    @endif
                @endif
            </article>

            <aside class="side-info">
                <div class="info-row">
                    <i>👥</i>
                    <span>
                        <strong>Target Peserta</strong>
                        <span>Siswa, mahasiswa, fresh graduate, calon pegawai bank, dan pegawai baru.</span>
                    </span>
                </div>
                <div class="info-row">
                    <i>◷</i>
                    <span>
                        <strong>Durasi</strong>
                        <span>{{ !empty($class->content_list) ? count($class->content_list) : 0 }} modul
                            pembelajaran</span>
                    </span>
                </div>
                <div class="info-row">
                    <i>▶</i>
                    <span>
                        <strong>Format</strong>
                        <span>{{ $class->tipe ?? 'Mandiri, video, e-book, kuis' }}</span>
                    </span>
                </div>
                <div class="info-row">
                    <i>✓</i>
                    <span>
                        <strong>Evaluasi</strong>
                        <span>Kuis, studi kasus, latihan, atau action plan.</span>
                    </span>
                </div>
            </aside>
        </div>
    </section>

    <!-- Section Kurikulum (Dinamis dari content_list accessor) -->
    <section class="section section-soft" id="kurikulum">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Kurikulum Kelas',
                'title' => 'Materi Disusun dari Fondasi hingga Penerapan',
                'description' =>
                    'Urutan modul dapat disesuaikan saat kelas dikembangkan menjadi program institusi atau blended learning.',
            ])

            <div class="module-list">
                @forelse($class->content_list ?? [] as $index => $contentItem)
                    <article class="module">
                        <span class="module-no">{{ sprintf('%02d', $index + 1) }}</span>
                        <div>
                            <h3>{{ $contentItem->title ?? 'Modul ' . ($index + 1) }}</h3>
                            <p>{{ $contentItem->description ?? ($contentItem->summary ?? 'Materi modul pembelajaran.') }}
                            </p>
                        </div>
                        <span class="module-time">{{ $contentItem->duration ?? '± 30–45 menit' }}</span>
                    </article>
                @empty
                    <div class="text-center py-4">
                        <p class="text-muted">Materi kurikulum sedang disiapkan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Section Metode Belajar -->
    <section class="section" id="metode">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Pengalaman Belajar',
                'title' => 'Lebih dari Sekadar Menonton Video',
                'description' =>
                    'Setiap komponen dirancang untuk membantu peserta memahami, berlatih, dan menerapkan materi.',
            ])
            <div class="learning-grid">
                <article class="learning-card"><i>▶</i>
                    <h3>Video Pembelajaran</h3>
                    <p>Penjelasan ringkas, visual, dan mudah diikuti berdasarkan urutan modul.</p>
                </article>
                <article class="learning-card"><i>▤</i>
                    <h3>E-book &amp; Ringkasan</h3>
                    <p>Materi pendamping untuk memperkuat konsep dan menjadi referensi belajar.</p>
                </article>
                <article class="learning-card"><i>?</i>
                    <h3>Kuis &amp; Latihan</h3>
                    <p>Evaluasi pemahaman melalui pertanyaan, kasus, atau worksheet.</p>
                </article>
                <article class="learning-card"><i>✓</i>
                    <h3>Action Plan</h3>
                    <p>Rencana sederhana agar pembelajaran dapat diterapkan setelah kelas selesai.</p>
                </article>
            </div>
        </div>
    </section>

    <!-- Section Pendaftaran & Pricing -->
    <section class="section section-soft" id="pendaftaran">
        <div class="container enroll-wrap">
            <article class="enroll-card featured">
                <span class="eyebrow">Kelas Individu</span>
                <h2>Belajar Sesuai Ritme Anda</h2>
                <p>Akses pembelajaran mandiri dengan materi terstruktur dan evaluasi sesuai ketentuan kelas.</p>

                @php
                    $resolved = $class->pricing->resolved ?? null;
                    $finalPrice = 0;
                    if ($resolved) {
                        $finalPrice = is_array($resolved) ? $resolved['final_price'] ?? 0 : $resolved->final_price ?? 0;
                    }
                @endphp

                <div class="my-3">
                    <h3 class="text-primary fw-bold" style="font-size: 1.8rem;">
                        {{ $finalPrice > 0 ? 'Rp ' . number_format($finalPrice, 0, ',', '.') : 'Gratis' }}
                    </h3>
                </div>

                <ul class="check-list">
                    <li>Akses modul pembelajaran</li>
                    <li>Video, e-book, kuis, dan latihan</li>
                    <li>Progres belajar terpantau</li>
                    <li>Sertifikat sesuai persyaratan program</li>
                </ul>

                <a class="btn btn-secondary" href="{{ route('frontend.support.contact') }}">
                    {{ $finalPrice > 0 ? 'Daftar Sekarang' : 'Ikuti Kelas Gratis' }}
                </a>
            </article>

            <article class="enroll-card">
                <span class="eyebrow">Program Institusi</span>
                <h2>Kembangkan Menjadi Kelas Khusus</h2>
                <p>Kelas dapat dikembangkan untuk bank, BPR/BPRS, sekolah, kampus, perusahaan, atau komunitas dengan
                    penyesuaian materi, studi kasus, asesmen, dan laporan.</p>
                <ul class="check-list">
                    <li>Penyesuaian kebutuhan peserta</li>
                    <li>Live session dan diskusi</li>
                    <li>Dashboard serta laporan pembelajaran</li>
                    <li>Pendampingan implementasi</li>
                </ul>
                <a class="btn btn-outline" href="{{ route('frontend.service.capacity-building') }}">Lihat Capacity
                    Building</a>
            </article>
        </div>
    </section>

    <!-- Section FAQ -->
    <section class="section" id="faq">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Tanya Jawab',
                'title' => 'Informasi Penting Sebelum Belajar',
            ])
            <div class="faq-wrap">
                <div class="faq-item">
                    <button class="faq-q">Apakah kelas ini cocok untuk pemula?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Kesesuaian mengikuti level yang tercantum. Peserta pemula dapat mengikuti kelas
                        level dasar atau pemula tanpa pengalaman khusus.</div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Apakah peserta mendapat sertifikat?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Sertifikat mengikuti ketentuan program dan dapat mensyaratkan penyelesaian materi,
                        kuis, tugas, kehadiran, atau pembayaran.</div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Berapa lama akses kelas tersedia?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Masa akses ditentukan pada saat kelas dipublikasikan. Informasi final akan
                        ditampilkan sebelum peserta melakukan pendaftaran.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Kelas Terkait (Dinamis dari $relatedClasses) -->
    <section class="section section-soft">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Kelas Terkait',
                'title' => 'Lanjutkan Jalur Pembelajaran Anda',
                'description' => 'Pilih topik berikut untuk memperluas kompetensi secara bertahap.',
            ])

            <div class="related-grid">
                @foreach ($relatedClasses as $related)
                    <article class="related">
                        @php
                            $relBg = !empty($related->image)
                                ? 'background-image: url(' .
                                    asset('storage/' . $related->image) .
                                    '); background-size: cover;'
                                : '';
                        @endphp
                        <div class="related-cover theme-teal" style="{{ $relBg }}">
                            <h3>{{ $related->title }}</h3>
                        </div>
                        {{-- <div class="related-body">
                            <p>{{ $related->contents ?? strip_tags($related->content) }}</p>
                            <a href="{{ route('frontend.class.static', ['slug' => $related->slug ?? $related->id]) }}">
                                Lihat kelas →
                            </a>
                        </div> --}}
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
