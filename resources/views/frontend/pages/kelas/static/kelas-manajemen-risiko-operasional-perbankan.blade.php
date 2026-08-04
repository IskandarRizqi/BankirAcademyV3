@extends('layouts.appfrontend')

@section('page-title')
    Manajemen Risiko Operasional Perbankan — Bankir Academy
@endsection

@section('page-description')
    Mengenali kejadian risiko operasional, kontrol, indikator, pencatatan insiden, dan rencana tindak lanjut.
@endsection

@section('content')
    <section class="detail-hero">
        <div class="container detail-grid">
            <div>
                <div class="breadcrumb"><a href="{{ route('frontend.home') }}">Beranda</a><span>›</span><a
                        href="{{ route('frontend.classes.index') }}">Kelas Online</a><span>›</span><span>Manajemen
                        Risiko</span></div>
                <span class="eyebrow">Manajemen Risiko</span>
                <h1>Manajemen Risiko Operasional Perbankan</h1>
                <p class="hero-copy">Mengenali kejadian risiko operasional, kontrol, indikator, pencatatan insiden, dan
                    rencana tindak lanjut.</p>
                <div class="hero-meta"><span>Level Menengah</span><span>Mandiri</span><span>Studi Kasus</span><span>7 modul ·
                        ±5 jam belajar</span></div>
                <div class="hero-actions"><a class="btn btn-primary" href="#pendaftaran">Mulai Belajar →</a><a
                        class="btn btn-outline" href="{{ route('frontend.classes.index') }}">Kembali ke Katalog</a></div>
            </div>
            <div class="preview-card">
                <div class="preview-cover theme-blue"><span class="preview-label">Manajemen Risiko</span>
                    <h2>Manajemen Risiko Operasional Perbankan</h2>
                    <div class="preview-bottom">
                        <div class="preview-stat"><strong>Level Menengah</strong><span>Tingkat pembelajaran</span></div>
                        <div class="preview-stat"><strong>7 Modul</strong><span>Kurikulum terstruktur</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <nav class="sticky-nav">
        <div class="container sticky-links"><a href="#ringkasan">Ringkasan</a><a href="#hasil-belajar">Hasil Belajar</a><a
                href="#kurikulum">Kurikulum</a><a href="#metode">Metode</a><a href="#pendaftaran">Pendaftaran</a><a
                href="#faq">FAQ</a></div>
    </nav>
    <section class="section" id="ringkasan">
        <div class="container overview-grid">
            <article class="content-card"><span class="eyebrow">Tentang Kelas</span>
                <h2>Pembelajaran Praktis dan Terarah</h2>
                <p>Mengenali kejadian risiko operasional, kontrol, indikator, pencatatan insiden, dan rencana tindak lanjut.
                    Materi disusun bertahap agar peserta dapat memahami konsep, melihat contoh penerapan, menguji pemahaman,
                    dan menyusun langkah tindak lanjut yang relevan.</p>
                <div class="outcome-grid" id="hasil-belajar">
                    <article class="outcome-card"><i>✓</i><strong>Identifikasi risiko</strong></article>
                    <article class="outcome-card"><i>✓</i><strong>Kontrol dan KRI</strong></article>
                    <article class="outcome-card"><i>✓</i><strong>Loss event sederhana</strong></article>
                </div>
            </article>
            <aside class="side-info">
                <div class="info-row"><i>👥</i><span><strong>Target Peserta</strong><span>Risk officer, supervisor
                            operasional, kepala unit, audit internal, dan pegawai terkait.</span></span></div>
                <div class="info-row"><i>◷</i><span><strong>Durasi</strong><span>7 modul · ±5 jam belajar</span></span>
                </div>
                <div class="info-row"><i>▶</i><span><strong>Format</strong><span>Mandiri, video, e-book, kuis, dan
                            latihan.</span></span></div>
                <div class="info-row"><i>✓</i><span><strong>Evaluasi</strong><span>Kuis, studi kasus, latihan, atau action
                            plan sesuai kelas.</span></span></div>
            </aside>
        </div>
    </section>
    <section class="section section-soft" id="kurikulum">
        <div class="container">@include('frontend.components.section-head', [
            'eyebrow' => 'Kurikulum Kelas',
            'title' => 'Materi Disusun dari Fondasi hingga Penerapan',
            'description' =>
                'Urutan modul dapat disesuaikan saat kelas dikembangkan menjadi program institusi atau blended learning.',
        ])<div class="module-list">
                <article class="module"><span class="module-no">01</span>
                    <div>
                        <h3>Konsep Risiko Operasional</h3>
                        <p>Sumber risiko, kejadian kerugian, proses, manusia, sistem, dan eksternal.</p>
                    </div><span class="module-time">± 30–45 menit</span>
                </article>
                <article class="module"><span class="module-no">02</span>
                    <div>
                        <h3>Identifikasi Risiko</h3>
                        <p>Pemetaan aktivitas, risiko inheren, kontrol, dan risiko residual.</p>
                    </div><span class="module-time">± 30–45 menit</span>
                </article>
                <article class="module"><span class="module-no">03</span>
                    <div>
                        <h3>Risk and Control Self Assessment</h3>
                        <p>Metode penilaian, skala, bukti, dan dokumentasi.</p>
                    </div><span class="module-time">± 30–45 menit</span>
                </article>
                <article class="module"><span class="module-no">04</span>
                    <div>
                        <h3>Key Risk Indicator</h3>
                        <p>Pemilihan indikator, threshold, monitoring, dan eskalasi.</p>
                    </div><span class="module-time">± 30–45 menit</span>
                </article>
                <article class="module"><span class="module-no">05</span>
                    <div>
                        <h3>Loss Event Management</h3>
                        <p>Pencatatan insiden, penyebab, dampak, dan pembelajaran.</p>
                    </div><span class="module-time">± 30–45 menit</span>
                </article>
                <article class="module"><span class="module-no">06</span>
                    <div>
                        <h3>Business Continuity</h3>
                        <p>Kesiapan gangguan, respon, pemulihan, dan komunikasi.</p>
                    </div><span class="module-time">± 30–45 menit</span>
                </article>
                <article class="module"><span class="module-no">07</span>
                    <div>
                        <h3>Action Plan Risiko</h3>
                        <p>Prioritas perbaikan, PIC, target, bukti, dan monitoring.</p>
                    </div><span class="module-time">± 30–45 menit</span>
                </article>
            </div>
        </div>
    </section>
    <section class="section" id="metode">
        <div class="container">@include('frontend.components.section-head', [
            'eyebrow' => 'Pengalaman Belajar',
            'title' => 'Lebih dari Sekadar Menonton Video',
            'description' =>
                'Setiap komponen dirancang untuk membantu peserta memahami, berlatih, dan menerapkan materi.',
        ])<div class="learning-grid">
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
    <section class="section section-soft" id="pendaftaran">
        <div class="container enroll-wrap">
            <article class="enroll-card featured"><span class="eyebrow">Kelas Individu</span>
                <h2>Belajar Sesuai Ritme Anda</h2>
                <p>Akses pembelajaran mandiri dengan materi terstruktur dan evaluasi sesuai ketentuan kelas.</p>
                <ul class="check-list">
                    <li>Akses modul pembelajaran</li>
                    <li>Video, e-book, kuis, dan latihan</li>
                    <li>Progres belajar terpantau</li>
                    <li>Sertifikat sesuai persyaratan program</li>
                </ul><a class="btn btn-secondary" href="{{ route('frontend.support.contact') }}">Minta Informasi
                    Pendaftaran</a>
            </article>
            <article class="enroll-card"><span class="eyebrow">Program Institusi</span>
                <h2>Kembangkan Menjadi Kelas Khusus</h2>
                <p>Kelas dapat dikembangkan untuk bank, BPR/BPRS, sekolah, kampus, perusahaan, atau komunitas dengan
                    penyesuaian materi, studi kasus, asesmen, dan laporan.</p>
                <ul class="check-list">
                    <li>Penyesuaian kebutuhan peserta</li>
                    <li>Live session dan diskusi</li>
                    <li>Dashboard serta laporan pembelajaran</li>
                    <li>Pendampingan implementasi</li>
                </ul><a class="btn btn-outline" href="{{ route('frontend.service.capacity-building') }}">Lihat Capacity
                    Building</a>
            </article>
        </div>
    </section>
    <section class="section" id="faq">
        <div class="container">@include('frontend.components.section-head', [
            'eyebrow' => 'Tanya Jawab',
            'title' => 'Informasi Penting Sebelum Belajar',
        ])<div class="faq-wrap">
                <div class="faq-item"><button class="faq-q">Apakah kelas ini cocok untuk pemula?<span
                            class="faq-plus">＋</span></button>
                    <div class="faq-a">Kesesuaian mengikuti level yang tercantum. Peserta pemula dapat mengikuti kelas
                        level dasar atau pemula tanpa pengalaman khusus, sedangkan kelas menengah dan lanjutan lebih optimal
                        bagi peserta yang telah memahami fungsi kerja terkait.</div>
                </div>
                <div class="faq-item"><button class="faq-q">Apakah peserta mendapat sertifikat?<span
                            class="faq-plus">＋</span></button>
                    <div class="faq-a">Sertifikat mengikuti ketentuan program dan dapat mensyaratkan penyelesaian materi,
                        kuis, tugas, kehadiran, atau pembayaran. Sertifikat bukan otomatis lisensi profesi.</div>
                </div>
                <div class="faq-item"><button class="faq-q">Berapa lama akses kelas tersedia?<span
                            class="faq-plus">＋</span></button>
                    <div class="faq-a">Masa akses ditentukan pada saat kelas dipublikasikan atau pada dokumen penawaran.
                        Informasi final akan ditampilkan sebelum peserta melakukan pendaftaran.</div>
                </div>
                <div class="faq-item"><button class="faq-q">Apakah materi dapat disesuaikan untuk institusi?<span
                            class="faq-plus">＋</span></button>
                    <div class="faq-a">Ya. Materi, durasi, studi kasus, metode, fasilitator, asesmen, serta output dapat
                        disesuaikan melalui program Capacity Building atau LMS institusi.</div>
                </div>
            </div>
        </div>
    </section>
    <section class="section section-soft">
        <div class="container">@include('frontend.components.section-head', [
            'eyebrow' => 'Kelas Terkait',
            'title' => 'Lanjutkan Jalur Pembelajaran Anda',
            'description' => 'Pilih topik berikut untuk memperluas kompetensi secara bertahap.',
        ])<div class="related-grid">
                <article class="related">
                    <div class="related-cover theme-purple">
                        <h3>Digital Marketing untuk BPR/BPRS</h3>
                    </div>
                    <div class="related-body">
                        <p>Menyusun strategi konten, kanal digital, komunikasi produk, pengelolaan prospek, dan evaluasi
                            kampanye.</p><a
                            href="{{ route('frontend.class.static', ['slug' => 'kelas-digital-marketing-untuk-bpr-bprs']) }}">Lihat
                            kelas →</a>
                    </div>
                </article>
                <article class="related">
                    <div class="related-cover theme-teal">
                        <h3>Service Excellence &amp; Customer Experience</h3>
                    </div>
                    <div class="related-body">
                        <p>Mengembangkan standar layanan, komunikasi empatik, penanganan keluhan, dan pengalaman nasabah
                            yang konsisten.</p><a
                            href="{{ route('frontend.class.static', ['slug' => 'kelas-service-excellence-dan-customer-experience']) }}">Lihat
                            kelas →</a>
                    </div>
                </article>
                <article class="related">
                    <div class="related-cover theme-gold">
                        <h3>First-Time Manager in Banking</h3>
                    </div>
                    <div class="related-body">
                        <p>Pembekalan bagi supervisor dan manajer baru untuk mengelola target, tim, komunikasi, delegasi,
                            dan evaluasi kinerja.</p><a
                            href="{{ route('frontend.class.static', ['slug' => 'kelas-first-time-manager-in-banking']) }}">Lihat
                            kelas →</a>
                    </div>
                </article>
            </div>
        </div>
    </section>
@endsection
