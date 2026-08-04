@extends('layouts.appfrontend')

@section('page-title')
    Headhunting Perbankan — Bankir Academy
@endsection

@section('page-description')
    Layanan headhunting Bankir Academy untuk membantu Bank, BPR, BPRS, dan perusahaan jasa keuangan menemukan kandidat yang
    relevan melalui proses pencarian, pemetaan, evaluasi awal, dan koordinasi seleksi yang terstruktur.
@endsection

@section('content')
    <section class="hero solution-hero talent-hero" id="beranda">
        <div class="container hero-grid">
            <div>
                <span class="eyebrow">Talent Solutions · Headhunting</span>
                <h1>Menemukan Kandidat yang <span class="gradient-text">Tepat, Relevan, dan Siap Berkontribusi</span></h1>
                <p class="hero-lead">Layanan pencarian kandidat profesional untuk membantu Bank, BPR, BPRS, dan perusahaan
                    jasa keuangan memenuhi kebutuhan posisi strategis maupun spesialis melalui proses yang terarah, rahasia,
                    dan terdokumentasi.</p>
                <div class="hero-actions"><a class="btn btn-primary" href="#layanan">Pelajari Proses <span
                            class="icon-arrow">→</span></a><a class="btn btn-outline" href="#konsultasi">Ajukan Kebutuhan
                        Kandidat</a></div>
                <div class="hero-proof"><span class="proof-item"><span class="proof-icon">✓</span>Pencarian berbasis profil
                        jabatan</span><span class="proof-item"><span class="proof-icon">✓</span>Proses terstruktur dan
                        rahasia</span><span class="proof-item"><span class="proof-icon">✓</span>Keputusan akhir tetap pada
                        klien</span></div>
            </div>
            <div aria-label="Ilustrasi dashboard proses headhunting" class="hero-visual">
                <div class="visual-main">
                    <div class="talent-board">
                        <div class="talent-board-head">Executive Search Dashboard <span>Confidential Process</span></div>
                        <div class="talent-profile">
                            <div class="talent-avatar">⌕</div>
                            <div>
                                <h3>Branch Manager Candidate</h3>
                                <p>Role profile · market mapping · shortlist readiness</p>
                            </div>
                        </div>
                        <div class="competency-grid">
                            <div class="competency-card"><strong>Industry Fit <em>88%</em></strong><small>Pengalaman sektor
                                    dan relevansi peran</small>
                                <div class="board-meter"><i class="width-88"></i></div>
                            </div>
                            <div class="competency-card"><strong>Role Match <em>82%</em></strong><small>Kesesuaian dengan
                                    kebutuhan jabatan</small>
                                <div class="board-meter"><i class="width-82"></i></div>
                            </div>
                            <div class="competency-card"><strong>Leadership <em>79%</em></strong><small>Pengalaman memimpin
                                    dan mengelola target</small>
                                <div class="board-meter"><i class="width-79"></i></div>
                            </div>
                            <div class="competency-card"><strong>Availability <em>Ready</em></strong><small>Status minat dan
                                    kesiapan proses</small>
                                <div class="board-meter"><i class="width-72"></i></div>
                            </div>
                        </div>
                        <div class="talent-path"><i>✓</i><span><strong>Shortlist Recommendation</strong>Profile summary ·
                                interview note · verification status</span></div>
                    </div>
                </div>
                <div class="float-card one"><span class="float-icon">⌕</span><span><strong>Talent
                            Mapping</strong><small>Pasar kandidat yang relevan</small></span></div>
                <div class="float-card two"><span class="float-icon">▤</span><span><strong>Shortlist
                            Report</strong><small>Profil kandidat terpilih</small></span></div>
            </div>
        </div>
    </section>
    <div class="quick-nav">
        <div class="container">
            <nav aria-label="Navigasi layanan headhunting" class="quick-nav-inner">
                <a href="#kebutuhan"><i>◇</i><span><strong>Kapan Digunakan</strong><span>Kebutuhan posisi
                            prioritas</span></span></a>
                <a href="#layanan"><i>⌕</i><span><strong>Ruang Lingkup</strong><span>Pencarian hingga
                            koordinasi</span></span></a>
                <a href="#proses"><i>↗</i><span><strong>Proses Kerja</strong><span>Tahapan yang transparan</span></span></a>
                <a href="#hasil"><i>✓</i><span><strong>Output Layanan</strong><span>Shortlist dan
                            dokumentasi</span></span></a>
            </nav>
        </div>
    </div>
    <section class="section" id="kebutuhan">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Kebutuhan Organisasi',
                'title' => 'Ketika Posisi Penting Membutuhkan Pendekatan Pencarian yang Lebih Terarah',
                'description' =>
                    'Headhunting relevan ketika kandidat yang dibutuhkan tidak cukup dijangkau melalui publikasi lowongan biasa atau ketika proses membutuhkan kerahasiaan dan pemetaan pasar secara aktif.',
            ])
            <div class="audience-grid">
                <article class="audience-card"><i>1</i>
                    <h3>Posisi Strategis</h3>
                    <p>Pimpinan cabang, kepala divisi, direktur, komisaris, atau jabatan lain yang berdampak langsung pada
                        arah dan kinerja organisasi.</p>
                </article>
                <article class="audience-card"><i>2</i>
                    <h3>Posisi Spesialis</h3>
                    <p>Peran yang membutuhkan pengalaman khusus seperti risiko, kepatuhan, audit, treasury, teknologi
                        informasi, digital, kredit, atau human capital.</p>
                </article>
                <article class="audience-card"><i>3</i>
                    <h3>Kandidat Terbatas</h3>
                    <p>Kebutuhan pada wilayah, jenjang pengalaman, lisensi, sertifikasi, atau kombinasi kompetensi yang
                        memiliki pasokan kandidat terbatas.</p>
                </article>
                <article class="audience-card"><i>4</i>
                    <h3>Proses Rahasia</h3>
                    <p>Pencarian yang memerlukan pengelolaan informasi secara terbatas sebelum organisasi mengumumkan
                        perubahan atau pengisian jabatan.</p>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-soft" id="layanan">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Ruang Lingkup Layanan',
                'title' => 'Pencarian Kandidat dari Pemahaman Jabatan hingga Shortlist',
                'description' =>
                    'Ruang lingkup ditetapkan berdasarkan kompleksitas posisi, wilayah pencarian, ketersediaan kandidat, kebutuhan verifikasi, serta metode seleksi klien.',
            ])
            <div class="solution-grid">
                <article class="solution-card">
                    <div class="card-icon">▤</div>
                    <h3>Role Intake &amp; Position Profiling</h3>
                    <p>Menerjemahkan kebutuhan organisasi menjadi profil pencarian yang jelas dan dapat digunakan sebagai
                        dasar pemetaan kandidat.</p>
                    <ul>
                        <li>Tujuan dan tanggung jawab jabatan</li>
                        <li>Kompetensi serta pengalaman wajib</li>
                        <li>Kriteria utama dan kriteria tambahan</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">⌕</div>
                    <h3>Market &amp; Talent Mapping</h3>
                    <p>Memetakan sumber kandidat potensial dari jaringan profesional, basis data, referensi, dan kanal
                        pencarian yang relevan.</p>
                    <ul>
                        <li>Target sektor dan organisasi</li>
                        <li>Longlist kandidat potensial</li>
                        <li>Analisis ketersediaan pasar</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">⇄</div>
                    <h3>Candidate Approach</h3>
                    <p>Melakukan pendekatan profesional kepada kandidat untuk menjelaskan peluang secara proporsional dan
                        menilai minat awal.</p>
                    <ul>
                        <li>Pendekatan yang menjaga reputasi</li>
                        <li>Konfirmasi minat dan kesiapan</li>
                        <li>Pengelolaan komunikasi kandidat</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">✓</div>
                    <h3>Initial Screening</h3>
                    <p>Melakukan penelaahan awal terhadap pengalaman, kesesuaian peran, motivasi, ekspektasi, dan faktor
                        administrasi yang relevan.</p>
                    <ul>
                        <li>Review profil dan riwayat kerja</li>
                        <li>Wawancara penyaringan awal</li>
                        <li>Catatan kesesuaian dan risiko</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">▦</div>
                    <h3>Shortlist Presentation</h3>
                    <p>Menyusun kandidat terpilih beserta ringkasan profil untuk membantu klien menentukan tahapan seleksi
                        berikutnya.</p>
                    <ul>
                        <li>Candidate profile summary</li>
                        <li>Comparison note</li>
                        <li>Rekomendasi proses lanjutan</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">◎</div>
                    <h3>Selection Coordination</h3>
                    <p>Mendukung koordinasi wawancara, komunikasi proses, pengumpulan dokumen, referensi, hingga pembaruan
                        status kandidat.</p>
                    <ul>
                        <li>Penjadwalan dan komunikasi</li>
                        <li>Reference check bila disepakati</li>
                        <li>Offer coordination secara terbatas</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>
    <section class="section" id="proses">
        <div class="container split">
            <div aria-label="Ilustrasi tahapan proses headhunting" class="feature-visual">
                <div class="feature-screen">
                    <div class="screen-nav"><span class="screen-title">Search Progress</span><span
                            class="screen-pill">Structured Workflow</span></div>
                    <div class="chart-area">
                        <div class="bar height-92"></div>
                        <div class="bar height-78"></div>
                        <div class="bar height-63"></div>
                        <div class="bar height-45"></div>
                        <div class="bar height-31"></div>
                        <div class="bar height-18"></div>
                    </div>
                    <div class="screen-bottom">
                        <div class="screen-box"><strong>Longlist</strong><span>Kandidat potensial hasil pemetaan</span>
                        </div>
                        <div class="screen-box"><strong>Shortlist</strong><span>Kandidat yang direkomendasikan</span></div>
                    </div>
                </div>
                <div class="feature-chip one"><i>⌕</i><span><strong>Active Search</strong><span>Pendekatan
                            kandidat</span></span></div>
                <div class="feature-chip two"><i>✓</i><span><strong>Client Review</strong><span>Keputusan tetap pada
                            klien</span></span></div>
            </div>
            <div class="feature-copy"><span class="eyebrow">Tahapan Pelaksanaan</span>
                <h2>Proses yang Jelas, Terkendali, dan Dapat Dipantau</h2>
                <p>Detail waktu dan jumlah kandidat tidak dapat disamaratakan karena dipengaruhi tingkat kesulitan posisi,
                    respons pasar, lokasi, serta kecepatan keputusan para pihak.</p>
                <div class="feature-points">
                    <div class="feature-point"><span class="point-icon">1</span><span><strong>Briefing &amp; Search
                                Agreement</strong><span>Menyepakati kebutuhan posisi, kriteria, ruang lingkup, kerahasiaan,
                                jadwal, biaya, dan mekanisme komunikasi.</span></span></div>
                    <div class="feature-point"><span class="point-icon">2</span><span><strong>Research &amp; Candidate
                                Mapping</strong><span>Mengembangkan search strategy, memetakan target market, dan menyusun
                                longlist kandidat.</span></span></div>
                    <div class="feature-point"><span class="point-icon">3</span><span><strong>Approach &amp; Preliminary
                                Assessment</strong><span>Menghubungi kandidat, mengonfirmasi minat, dan menilai kesesuaian
                                awal berdasarkan informasi yang tersedia.</span></span></div>
                    <div class="feature-point"><span class="point-icon">4</span><span><strong>Shortlist &amp; Client
                                Selection</strong><span>Menyampaikan kandidat terpilih, mengoordinasikan tahapan klien, dan
                                memperbarui status sampai proses ditutup.</span></span></div>
                </div><a class="btn btn-primary" href="#konsultasi">Diskusikan Posisi yang Dicari</a>
            </div>
        </div>
    </section>
    <section class="section section-soft" id="posisi">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Cakupan Posisi',
                'title' => 'Dapat Disesuaikan dengan Struktur dan Prioritas Institusi',
                'description' =>
                    'Daftar berikut merupakan contoh. Kelayakan setiap pencarian tetap dinilai berdasarkan profil, lokasi, tingkat jabatan, dan ketersediaan pasar kandidat.',
            ])
            <div class="package-grid">
                <article class="package-card">
                    <div class="card-icon">◇</div>
                    <h3>Executive &amp; Leadership</h3>
                    <p>Pencarian untuk posisi dengan tanggung jawab strategis dan pengambilan keputusan organisasi.</p>
                    <ul>
                        <li>Direksi dan komisaris</li>
                        <li>General manager atau kepala divisi</li>
                        <li>Branch manager dan area leader</li>
                        <li>Senior leadership role</li>
                    </ul>
                </article>
                <article class="package-card featured">
                    <div class="card-icon card-icon-light">▦</div>
                    <h3>Banking Specialist</h3>
                    <p>Pencarian profesional dengan kompetensi teknis, regulasi, atau pengalaman fungsi yang spesifik.</p>
                    <ul>
                        <li>Kredit, risiko, dan remedial</li>
                        <li>Kepatuhan, APU-PPT, audit</li>
                        <li>Finance, treasury, dan accounting</li>
                        <li>IT, cybersecurity, dan digital banking</li>
                    </ul>
                </article>
                <article class="package-card">
                    <div class="card-icon">↗</div>
                    <h3>Business &amp; Support Function</h3>
                    <p>Pencarian peran yang mendukung pertumbuhan bisnis, layanan, dan efektivitas organisasi.</p>
                    <ul>
                        <li>Marketing dan business development</li>
                        <li>Human capital dan learning</li>
                        <li>Operations dan service quality</li>
                        <li>Legal, corporate secretary, dan support</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-dark" id="hasil">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Output Layanan',
                'title' => 'Informasi yang Membantu Klien Mengambil Keputusan',
                'description' =>
                    'Format dan kedalaman output bergantung pada ruang lingkup yang disepakati dan informasi yang dapat diperoleh secara sah.',
            ])
            <div class="deliverable-grid">
                <article class="deliverable"><i>▤</i>
                    <h3>Search Profile</h3>
                    <p>Dokumen kebutuhan jabatan, kriteria kandidat, target pencarian, dan parameter penyaringan.</p>
                </article>
                <article class="deliverable"><i>⌕</i>
                    <h3>Market Mapping</h3>
                    <p>Gambaran sumber kandidat, kondisi pasar, tantangan pencarian, dan penyesuaian strategi.</p>
                </article>
                <article class="deliverable"><i>◇</i>
                    <h3>Candidate Shortlist</h3>
                    <p>Daftar kandidat yang memenuhi parameter awal dan bersedia mengikuti proses lebih lanjut.</p>
                </article>
                <article class="deliverable"><i>▦</i>
                    <h3>Profile Summary</h3>
                    <p>Ringkasan pengalaman, relevansi, motivasi, ekspektasi, ketersediaan, dan catatan awal.</p>
                </article>
                <article class="deliverable"><i>⇄</i>
                    <h3>Process Update</h3>
                    <p>Pembaruan aktivitas pencarian, respons kandidat, hambatan, dan tahapan seleksi.</p>
                </article>
                <article class="deliverable"><i>✓</i>
                    <h3>Closure Summary</h3>
                    <p>Ringkasan hasil proses, kandidat akhir, status penawaran, atau alasan penutupan pencarian.</p>
                </article>
            </div>
        </div>
    </section>
    <section class="section" id="ketentuan">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Prinsip &amp; Ketentuan',
                'title' => 'Proses Rekrutmen yang Profesional dan Bertanggung Jawab',
                'description' =>
                    'Ketentuan komersial, masa pencarian, replacement clause, eksklusivitas, biaya, serta tanggung jawab para pihak dituangkan dalam proposal atau perjanjian.',
            ])
            <div class="principle-grid">
                <article class="principle">
                    <span>01</span>
                    <div><strong>Kerahasiaan</strong>
                        <p>Informasi posisi, organisasi, dan kandidat dibatasi sesuai kebutuhan proses serta tidak digunakan
                            di
                            luar tujuan yang disepakati.</p>
                    </div>
                </article>
                <article class="principle">
                    <span>02</span>
                    <div><strong>Persetujuan Kandidat</strong>
                        <p>Profil kandidat hanya disampaika
                    </div>
                </article>
                <article class="principle"> <span>03</span>
                    <div><strong>Verifikasi Berlapis</strong>
                        <p>Informasi kandidat perlu ditinjau kembali melalui dokumen, wawancara, referensi, atau pemeriksaan
                            lain sesuai kebijakan klien.</p>
                    </div>
                </article>
                <article class="principle"> <span>04</span>
                    <div><strong>Keputusan Klien</strong>
                        <p>Keputusan wawancara, kelulusan, penawaran, penempatan, remunerasi, dan hubungan kerja sepenuhnya
                            berada pada kewenangan klien.</p>
                    </div>
                </article>
            </div>
            <div class="notice-box"><strong>Catatan penting:</strong> layanan headhunting tidak menjamin tersedianya
                kandidat, penerimaan kandidat, kesediaan kandidat menerima penawaran, atau keberhasilan kerja setelah
                penempatan. Hasil dipengaruhi kondisi pasar, persyaratan posisi, kecepatan proses, daya tarik penawaran, dan
                keputusan para pihak.</div>
        </div>
    </section>
    <section class="section section-soft" id="faq">
        <div class="container">@include('frontend.components.section-head', [
            'eyebrow' => 'Pertanyaan Umum',
            'title' => 'Informasi Awal Layanan Headhunting',
            'description' => 'Hal-hal yang umumnya perlu dipahami sebelum proses pencarian kandidat dimulai.',
        ])<div class="faq-wrap">
                <article class="faq-item open"><button class="faq-q" type="button">Apa perbedaan headhunting dan
                        pemasangan lowongan?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Pemasangan lowongan mengandalkan kandidat yang melamar. Headhunting menggunakan
                        pencarian aktif, pemetaan pasar, serta pendekatan langsung kepada kandidat potensial yang mungkin
                        tidak sedang mencari pekerjaan.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Apakah Bankir Academy menjamin kandidat
                        diterima?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Tidak. Bankir Academy membantu pencarian, penyaringan awal, penyampaian shortlist,
                        dan koordinasi. Keputusan akhir tetap berada pada klien dan kandidat.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Berapa lama proses pencarian
                        kandidat?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Durasi dipengaruhi tingkat jabatan, lokasi, spesialisasi, ekspektasi kompensasi,
                        respons pasar, dan kecepatan seleksi. Estimasi awal ditetapkan setelah posisi dipelajari.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Apakah layanan dapat dilakukan secara
                        rahasia?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Dapat, dengan pengaturan disclosure, pihak yang boleh mengetahui posisi, cara
                        menyampaikan identitas klien, dan kewajiban kerahasiaan yang disepakati.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Apakah reference check termasuk
                        layanan?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Dapat dimasukkan bila disepakati, kandidat memberikan persetujuan, dan sumber
                        referensi memungkinkan. Reference check tetap tidak menggantikan verifikasi resmi dari klien.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Data apa yang perlu diberikan oleh
                        klien?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Minimal meliputi nama posisi, tujuan jabatan, tanggung jawab, lokasi, struktur
                        pelaporan, kriteria wajib, kisaran remunerasi, tahapan seleksi, target waktu, serta kondisi khusus
                        yang perlu dijaga kerahasiaannya.</div>
                </article>
            </div>
        </div>
    </section>
    <section class="final-cta" id="konsultasi">
        <div class="container">
            <div class="cta-box">
                <div>
                    <h2>Sampaikan Posisi yang Sedang Anda Cari</h2>
                    <p>Informasikan nama jabatan, lokasi, kebutuhan pengalaman, kompetensi utama, target waktu, kisaran
                        remunerasi, dan tahapan seleksi. Tim Bankir Academy akan membantu menilai kelayakan serta ruang
                        lingkup pencarian awal.</p>
                </div>
                <div class="cta-actions"><a class="btn btn-light"
                        href="mailto:info@bankiracademy.co.id?subject=Konsultasi%20Layanan%20Headhunting">Email Kebutuhan
                        Kandidat</a><a class="btn btn-secondary" href="#layanan">Lihat Ruang Lingkup</a></div>
            </div>
        </div>
    </section>
@endsection
