@extends('layouts.appfrontend')

@section('page-title')
    General Banking Fundamentals — Bankir Academy
@endsection

@section('page-description')
    Memahami fungsi bank, produk dan layanan, struktur organisasi, proses operasional, serta etika dasar calon bankir.
@endsection

@section('content')
    <section class="detail-hero">
        <div class="container detail-grid">
            <div>
                <div class="breadcrumb"><a href="{{ route('frontend.home') }}">Beranda</a><span>›</span><a
                        href="{{ route('frontend.classes.index') }}">Kelas Online</a><span>›</span><span>Dasar
                        Perbankan</span></div>
                <span class="eyebrow">Dasar Perbankan</span>
                <h1>General Banking Fundamentals</h1>
                <p class="hero-copy">Memahami fungsi bank, produk dan layanan, struktur organisasi, proses operasional, serta
                    etika dasar calon bankir.</p>
                <div class="hero-meta"><span>Level Dasar</span><span>Mandiri</span><span>Video &amp; Kuis</span><span>6 modul
                        · ±4 jam belajar</span></div>
                <div class="hero-actions"><a class="btn btn-primary" href="#pendaftaran">Mulai Belajar →</a><a
                        class="btn btn-outline" href="{{ route('frontend.classes.index') }}">Kembali ke Katalog</a></div>
            </div>
            <div class="preview-card">
                <div class="preview-cover theme-purple"><span class="preview-label">Dasar Perbankan</span>
                    <h2>General Banking Fundamentals</h2>
                    <div class="preview-bottom">
                        <div class="preview-stat"><strong>Level Dasar</strong><span>Tingkat pembelajaran</span></div>
                        <div class="preview-stat"><strong>6 Modul</strong><span>Kurikulum terstruktur</span></div>
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
                <p>Memahami fungsi bank, produk dan layanan, struktur organisasi, proses operasional, serta etika dasar
                    calon bankir. Materi disusun bertahap agar peserta dapat memahami konsep, melihat contoh penerapan,
                    menguji pemahaman, dan menyusun langkah tindak lanjut yang relevan.</p>
                <div class="outcome-grid" id="hasil-belajar">
                    <article class="outcome-card"><i>✓</i><strong>Fungsi dan peran bank</strong></article>
                    <article class="outcome-card"><i>✓</i><strong>Produk dan layanan utama</strong></article>
                    <article class="outcome-card"><i>✓</i><strong>Etika serta budaya kerja</strong></article>
                </div>
            </article>
            <aside class="side-info">
                <div class="info-row"><i>👥</i><span><strong>Target Peserta</strong><span>Siswa, mahasiswa, fresh graduate,
                            calon pegawai bank, dan pegawai baru.</span></span></div>
                <div class="info-row"><i>◷</i><span><strong>Durasi</strong><span>6 modul · ±4 jam belajar</span></span>
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
                        <h3>Mengenal Industri Perbankan</h3>
                        <p>Peran bank dalam perekonomian, jenis bank, fungsi intermediasi, dan kepercayaan publik.</p>
                    </div><span class="module-time">± 30–45 menit</span>
                </article>
                <article class="module"><span class="module-no">02</span>
                    <div>
                        <h3>Produk dan Layanan Bank</h3>
                        <p>Tabungan, deposito, kredit, pembayaran, transfer, serta layanan digital.</p>
                    </div><span class="module-time">± 30–45 menit</span>
                </article>
                <article class="module"><span class="module-no">03</span>
                    <div>
                        <h3>Struktur Organisasi</h3>
                        <p>Fungsi bisnis, operasional, risiko, kepatuhan, audit, teknologi, dan human capital.</p>
                    </div><span class="module-time">± 30–45 menit</span>
                </article>
                <article class="module"><span class="module-no">04</span>
                    <div>
                        <h3>Proses Operasional Dasar</h3>
                        <p>Alur layanan nasabah, transaksi, dokumentasi, dan kontrol dasar.</p>
                    </div><span class="module-time">± 30–45 menit</span>
                </article>
                <article class="module"><span class="module-no">05</span>
                    <div>
                        <h3>Risiko, Kepatuhan, dan Etika</h3>
                        <p>Prinsip kehati-hatian, kerahasiaan data, benturan kepentingan, dan perilaku profesional.</p>
                    </div><span class="module-time">± 30–45 menit</span>
                </article>
                <article class="module"><span class="module-no">06</span>
                    <div>
                        <h3>Studi Kasus Calon Bankir</h3>
                        <p>Latihan memahami kasus layanan dan menyusun action plan awal.</p>
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
                    <div class="related-cover theme-teal">
                        <h3>Dasar Analisis Kredit Perbankan</h3>
                    </div>
                    <div class="related-body">
                        <p>Mengenal proses kredit, analisis sederhana, dokumen pendukung, identifikasi risiko, dan prinsip
                            kehati-hatian.</p><a
                            href="{{ route('frontend.class.static', ['slug' => 'kelas-dasar-analisis-kredit-perbankan']) }}">Lihat
                            kelas →</a>
                    </div>
                </article>
                <article class="related">
                    <div class="related-cover theme-gold">
                        <h3>Persiapan Seleksi dan Karier Perbankan</h3>
                    </div>
                    <div class="related-body">
                        <p>Membantu peserta menyiapkan CV, memahami tahapan rekrutmen, menghadapi wawancara, dan mengenali
                            etika kerja profesional.</p><a
                            href="{{ route('frontend.class.static', ['slug' => 'kelas-persiapan-seleksi-dan-karier-perbankan']) }}">Lihat
                            kelas →</a>
                    </div>
                </article>
                <article class="related">
                    <div class="related-cover theme-red">
                        <h3>AI Literacy for Banking Professionals</h3>
                    </div>
                    <div class="related-body">
                        <p>Pengenalan penggunaan AI sebagai alat bantu kerja, batas penggunaan, verifikasi manusia, keamanan
                            informasi, dan tata kelola dasar.</p><a
                            href="{{ route('frontend.class.static', ['slug' => 'kelas-ai-literacy-for-banking-professionals']) }}">Lihat
                            kelas →</a>
                    </div>
                </article>
            </div>
        </div>
    </section>
@endsection
