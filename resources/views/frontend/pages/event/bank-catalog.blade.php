@extends('layouts.appfrontend')

@section('page-title')
    Kelas Online — Bankir Academy
@endsection

@section('page-description')
    Jelajahi kelas online Bankir Academy untuk calon bankir, pegawai bank, profesional, pimpinan, dan pelaku UMKM.
@endsection

@section('content')
    <section class="hero classes-hero" id="ringkasan">
        <div class="container hero-grid">
            <div><span class="eyebrow">Katalog Kelas Online</span>
                <h1>Belajar Lebih Terarah untuk <span class="gradient-text">Karier dan Kinerja Perbankan</span></h1>
                <p class="hero-lead">Jelajahi kelas mandiri dan blended learning Bankir Academy untuk calon bankir, pegawai,
                    supervisor, manajer, pimpinan, serta pelaku UMKM. Setiap kelas dirancang dengan tujuan pembelajaran,
                    materi praktis, evaluasi, dan hasil belajar yang jelas.</p>
                <div class="hero-actions"><a class="btn btn-primary" href="#katalog">Lihat Semua Kelas <span
                            class="icon-arrow">→</span></a><a class="btn btn-outline"
                        href="{{ route('frontend.support.contact') }}">Konsultasi Kelas</a></div>
                <div class="hero-proof"><span class="proof-item"><span class="proof-icon">✓</span>Materi
                        terstruktur</span><span class="proof-item"><span class="proof-icon">✓</span>Belajar
                        fleksibel</span><span class="proof-item"><span class="proof-icon">✓</span>Evaluasi
                        pembelajaran</span></div>
                <div class="class-kicker"><span>Video Pembelajaran</span><span>E-book</span><span>Kuis &amp;
                        Latihan</span><span>Sertifikat sesuai ketentuan</span></div>
            </div>
            <div class="hero-visual">
                <div class="visual-main">
                    <div class="catalog-board">
                        <div class="catalog-top"><span>LEARNING CATALOG</span><span class="catalog-status">12 Kelas
                                Pilihan</span></div>
                        <div class="catalog-feature"><small>Featured Learning Path</small>
                            <h3>Banking Professional Journey</h3>
                            <p>Mulai dari fondasi perbankan, kompetensi jabatan, keterampilan digital, hingga kepemimpinan.
                            </p>
                        </div>
                        <div class="catalog-grid">
                            <div class="catalog-mini"><strong>Foundation</strong><span>Dasar industri dan karier</span>
                                <div class="catalog-progress"><i class="width-88"></i></div>
                            </div>
                            <div class="catalog-mini"><strong>Professional</strong><span>Kompetensi fungsi kerja</span>
                                <div class="catalog-progress"><i class="width-74"></i></div>
                            </div>
                            <div class="catalog-mini"><strong>Digital</strong><span>Data, AI, dan teknologi</span>
                                <div class="catalog-progress"><i class="width-68"></i></div>
                            </div>
                            <div class="catalog-mini"><strong>Leadership</strong><span>Supervisor hingga pimpinan</span>
                                <div class="catalog-progress"><i class="width-61"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="float-card one"><span class="float-icon">▶</span><span><strong>Belajar
                            Mandiri</strong><small>Akses sesuai ritme belajar</small></span></div>
                <div class="float-card two"><span class="float-icon">✓</span><span><strong>Learning
                            Progress</strong><small>Materi dan evaluasi terpantau</small></span></div>
            </div>
        </div>
    </section>
    {{-- <div class="class-summary">
        <div class="container summary-grid">
            <div class="summary-item"><span class="summary-icon">12</span><span><strong>Contoh Kelas</strong><span>Berbagai
                        bidang kompetensi</span></span></div>
            <div class="summary-item"><span class="summary-icon">4</span><span><strong>Level Belajar</strong><span>Dasar
                        hingga strategis</span></span></div>
            <div class="summary-item"><span class="summary-icon">∞</span><span><strong>Belajar
                        Fleksibel</strong><span>Mandiri dan blended</span></span></div>
            <div class="summary-item"><span class="summary-icon">✓</span><span><strong>Evaluasi</strong><span>Kuis, praktik,
                        dan action plan</span></span></div>
        </div>
    </div> --}}
    <section class="section" id="katalog">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Katalog Pembelajaran',
                'title' => 'Pilih Kelas Sesuai Kebutuhan Anda',
                'description' =>
                    'Gunakan pencarian dan kategori untuk menemukan topik yang relevan. Contoh kelas dapat dikembangkan menjadi kelas institusi atau learning path khusus.',
            ])
            <form class="catalog-tools" method="GET" action="{{ route('frontend.classes.index') }}">
                <label class="class-search" for="classSearch">
                    <span aria-hidden="true">⌕</span>
                    <input id="classSearch" name="q" value="{{ $data['search'] ?? '' }}"
                        placeholder="Cari judul, topik, atau kompetensi..." type="search" />
                </label>
                <button class="btn btn-primary" type="submit">Cari Kelas</button>
            </form>
            <div class="catalog-cards" id="classGrid">
                @forelse ($data['kelas'] ?? [] as $item)
                    @include('frontend.components.course-card', [
                        'item' => $item,
                    ])
                @empty
                    <div class="col-12 text-center py-4">
                        <p class="text-muted">Belum ada kelas yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
            @if ($data['kelas']->hasPages())
                <div class="article-pagination">
                    {{ $data['kelas']->links() }}
                </div>
            @endif
            <style>
                #classGrid.catalog-cards {
                    gap: 16px;
                }

                #classGrid.catalog-cards .course-card {
                    max-width: none;
                }

                .catalog-pagination {
                    display: flex;
                    justify-content: center;
                    margin-top: 32px;
                }

                .catalog-pagination .pagination {
                    display: flex;
                    gap: 6px;
                    padding: 0;
                    margin: 0;
                    list-style: none;
                }

                .catalog-pagination .page-link {
                    min-width: 38px;
                    padding: 9px 12px;
                    border: 1px solid var(--line);
                    border-radius: 10px;
                    color: var(--primary);
                    background: #fff;
                    text-align: center;
                }

                .catalog-pagination .page-item.active .page-link {
                    border-color: var(--primary);
                    color: #fff;
                    background: var(--primary);
                }

                .catalog-pagination .page-item.disabled .page-link {
                    color: var(--muted);
                    background: #f7f7fb;
                }
            </style>
        </div>
    </section>
    <section class="section section-soft">
        <div class="container">@include('frontend.components.section-head', [
            'eyebrow' => 'Learning Journey',
            'title' => 'Alur Belajar yang Lebih Terstruktur',
            'description' =>
                'Setiap kelas dapat berdiri sendiri atau dirangkai menjadi jalur pembelajaran sesuai profil peserta dan tujuan pengembangan.',
        ])<div class="pathway-grid">
                <article class="pathway-card"><span class="pathway-no">01</span>
                    <h3>Pilih Kelas</h3>
                    <p>Tentukan topik, level, format, dan hasil belajar yang paling relevan.</p>
                </article>
                <article class="pathway-card"><span class="pathway-no">02</span>
                    <h3>Pelajari Materi</h3>
                    <p>Ikuti video, e-book, studi kasus, latihan, atau sesi langsung sesuai program.</p>
                </article>
                <article class="pathway-card"><span class="pathway-no">03</span>
                    <h3>Kerjakan Evaluasi</h3>
                    <p>Ukur pemahaman melalui kuis, tugas, simulasi, atau action plan.</p>
                </article>
                <article class="pathway-card"><span class="pathway-no">04</span>
                    <h3>Terapkan</h3>
                    <p>Gunakan hasil pembelajaran dalam pekerjaan, karier, atau pengembangan usaha.</p>
                </article>
            </div>
            <div class="learning-note"><strong>Catatan:</strong> fitur, masa akses, asesmen, fasilitator, sertifikat, dan
                harga mengikuti ketentuan masing-masing kelas. Kelas institusi dapat disesuaikan melalui layanan Capacity
                Building dan LMS.</div>
        </div>
    </section>
    <section class="final-cta">
        <div class="container">
            <div class="cta-box">
                <div>
                    <h2>Butuh Learning Path Khusus untuk Institusi?</h2>
                    <p>Tim Bankir Academy dapat membantu menyusun kombinasi kelas, asesmen, LMS, dan laporan sesuai
                        kompetensi serta target organisasi.</p>
                </div>
                <div class="cta-actions"><a class="btn btn-light"
                        href="{{ route('frontend.service.capacity-building') }}">Lihat Capacity Building</a><a
                        class="btn btn-secondary" href="{{ route('frontend.support.contact') }}">Diskusikan Kebutuhan</a>
                </div>
            </div>
        </div>
    </section>
@endsection
