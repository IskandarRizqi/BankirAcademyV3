@extends('layouts.appfrontend')

@section('page-title')
    Banking Solution — Bankir Academy
@endsection

@section('page-description')
    Banking Solution Bankir Academy membantu Bank, BPR, dan BPRS memperkuat proses bisnis, tata kelola, layanan,
    digitalisasi, dan kinerja melalui solusi konsultatif yang terukur.
@endsection

@section('content')
    <section class="hero solution-hero" id="ringkasan">
        <div class="container hero-grid">
            <div>
                <span class="eyebrow">Banking Solution</span>
                <h1>Solusi Terapan untuk <span class="gradient-text">Bank yang Lebih Tangguh</span></h1>
                <p class="hero-lead">Bankir Academy membantu Bank, BPR, dan BPRS memetakan kebutuhan, memperbaiki proses,
                    menyiapkan perangkat kerja, serta mendampingi implementasi program secara bertahap dan terukur.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="#konsultasi">Konsultasikan Kebutuhan <span class="icon-arrow">→</span></a>
                    <a class="btn btn-outline" href="#ruang-lingkup">Lihat Ruang Lingkup</a>
                </div>
                <div class="hero-proof">
                    <span class="proof-item"><span class="proof-icon">✓</span>Berbasis kebutuhan institusi</span>
                    <span class="proof-item"><span class="proof-icon">✓</span>Ruang lingkup transparan</span>
                    <span class="proof-item"><span class="proof-icon">✓</span>Dokumentasi dan evaluasi</span>
                </div>
                <div class="solution-kicker"><span>Bank &amp; BPR/BPRS</span><span>Operasional</span><span>Tata
                        Kelola</span><span>Transformasi Digital</span></div>
            </div>
            <div aria-label="Ilustrasi dashboard Banking Solution" class="hero-visual">
                <div class="visual-main">
                    <div class="solution-board">
                        <div class="board-title"><span>Banking Transformation Dashboard</span><span
                                class="board-status">Program Aktif</span></div>
                        <div class="board-focus"><small>Focus Area</small>
                            <h3>Operational Excellence</h3>
                            <p>Pemetaan proses, standardisasi, penguatan kontrol, dan tindak lanjut implementasi.</p>
                        </div>
                        <div class="board-grid">
                            <div class="board-card"><strong>Process Review</strong><span>Analisis kondisi dan gap</span>
                                <div class="board-meter"><i class="width-82"></i></div>
                            </div>
                            <div class="board-card"><strong>Governance</strong><span>Peran, kontrol, dokumentasi</span>
                                <div class="board-meter"><i class="width-73"></i></div>
                            </div>
                            <div class="board-card"><strong>Service Quality</strong><span>Standar dan pengalaman
                                    nasabah</span>
                                <div class="board-meter"><i class="width-88"></i></div>
                            </div>
                            <div class="board-card"><strong>Digital Enablement</strong><span>Automasi dan dashboard</span>
                                <div class="board-meter"><i class="width-66"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="float-card one"><span class="float-icon">⌕</span><span><strong>Needs
                            Assessment</strong><small>Diagnosis terstruktur</small></span></div>
                <div class="float-card two"><span class="float-icon">✓</span><span><strong>Action
                            Plan</strong><small>Prioritas dan indikator</small></span></div>
            </div>
        </div>
    </section>
    <div class="quick-nav">
        <div class="container">
            <nav aria-label="Navigasi Banking Solution" class="quick-nav-inner">
                <a href="#tantangan"><i>!</i><span><strong>Tantangan</strong><span>Kebutuhan yang umum
                            ditemui</span></span></a>
                <a href="#ruang-lingkup"><i>▦</i><span><strong>Ruang Lingkup</strong><span>Pilihan solusi
                            terapan</span></span></a>
                <a href="#metode"><i>↗</i><span><strong>Metode Kerja</strong><span>Tahapan kolaborasi</span></span></a>
                <a href="#konsultasi"><i>✉</i><span><strong>Konsultasi</strong><span>Diskusikan kebutuhan
                            institusi</span></span></a>
            </nav>
        </div>
    </div>
    <section class="section" id="tantangan">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Tantangan Institusi',
                'title' => 'Dari Permasalahan Operasional Menuju Perbaikan yang Terarah',
                'description' =>
                    'Program dimulai dari pemahaman kondisi aktual, bukan dari solusi yang disamaratakan. Fokus, kedalaman, serta hasil kerja ditetapkan berdasarkan kebutuhan dan kewenangan institusi.',
            ])
            <div class="challenge-grid">
                <article class="challenge-card"><span class="challenge-no">01</span>
                    <h3>Proses Belum Seragam</h3>
                    <p>Alur kerja, formulir, kontrol, dan tanggung jawab belum terdokumentasi atau diterapkan secara
                        konsisten.</p>
                </article>
                <article class="challenge-card"><span class="challenge-no">02</span>
                    <h3>Kinerja Sulit Dipantau</h3>
                    <p>Indikator, dashboard, pelaporan, serta mekanisme tindak lanjut belum terhubung dengan sasaran
                        organisasi.</p>
                </article>
                <article class="challenge-card"><span class="challenge-no">03</span>
                    <h3>Layanan Perlu Diperkuat</h3>
                    <p>Standar layanan, komunikasi, penanganan pengaduan, dan pengalaman nasabah memerlukan penyempurnaan.
                    </p>
                </article>
                <article class="challenge-card"><span class="challenge-no">04</span>
                    <h3>Transformasi Belum Terarah</h3>
                    <p>Digitalisasi atau automasi berjalan parsial tanpa prioritas, tata kelola, kesiapan pengguna, dan
                        ukuran keberhasilan yang jelas.</p>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-soft" id="ruang-lingkup">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Ruang Lingkup Solusi',
                'title' => 'Layanan yang Dapat Disesuaikan dengan Prioritas Bank',
                'description' =>
                    'Satu atau beberapa area dapat digabung menjadi program terpadu. Penetapan ruang lingkup dilakukan setelah diskusi awal dan penelaahan kebutuhan.',
            ])
            <div class="solution-grid">
                <article class="solution-card">
                    <div class="card-icon">▦</div>
                    <h3>Business Process Improvement</h3>
                    <p>Peninjauan dan penyempurnaan proses kerja agar lebih jelas, efisien, terdokumentasi, dan mudah
                        dikendalikan.</p>
                    <ul>
                        <li>Process mapping dan gap analysis</li>
                        <li>RACI, alur, formulir, dan checklist</li>
                        <li>Rekomendasi prioritas perbaikan</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">◇</div>
                    <h3>Governance &amp; Compliance Support</h3>
                    <p>Dukungan penyusunan perangkat kerja dan penguatan tata kelola berdasarkan kebutuhan serta regulasi
                        yang relevan.</p>
                    <ul>
                        <li>Review kebijakan dan prosedur</li>
                        <li>Control point dan evidence list</li>
                        <li>Sosialisasi serta rencana implementasi</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">◎</div>
                    <h3>Risk &amp; Control Enhancement</h3>
                    <p>Pemetaan risiko operasional, penguatan kontrol, dan penyusunan tindak lanjut yang dapat dipantau oleh
                        pemilik proses.</p>
                    <ul>
                        <li>Risk identification workshop</li>
                        <li>Control matrix dan risk register</li>
                        <li>Monitoring corrective action</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">♡</div>
                    <h3>Service &amp; Customer Experience</h3>
                    <p>Peningkatan standar layanan, komunikasi, pengelolaan pengaduan, serta pengalaman nasabah di berbagai
                        titik interaksi.</p>
                    <ul>
                        <li>Service standard dan script</li>
                        <li>Customer journey mapping</li>
                        <li>Coaching dan service audit</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">↗</div>
                    <h3>Performance Management</h3>
                    <p>Penyelarasan sasaran organisasi, KPI, monitoring, rapat evaluasi, dan rencana tindak lanjut berbasis
                        data.</p>
                    <ul>
                        <li>KPI dan target cascading</li>
                        <li>Dashboard serta reporting rhythm</li>
                        <li>Review kinerja dan action tracker</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">✦</div>
                    <h3>Digital Process &amp; Automation</h3>
                    <p>Identifikasi proses yang dapat didigitalisasi atau diautomasi secara bertahap dengan memperhatikan
                        akses, keamanan, dan kesiapan pengguna.</p>
                    <ul>
                        <li>Use-case dan feasibility mapping</li>
                        <li>Prototype dashboard atau workflow</li>
                        <li>Uji coba, dokumentasi, dan adopsi</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>
    <section class="section" id="metode">
        <div class="container method-wrap">
            <div class="method-panel"><span class="eyebrow">Consultative Approach</span>
                <h3>Solusi Dibangun Bersama, Bukan Sekadar Diserahkan</h3>
                <p>Tim bekerja dengan penanggung jawab institusi agar rekomendasi sesuai konteks, dapat dipahami pengguna,
                    dan memiliki rencana implementasi yang realistis.</p>
                <div class="method-stat-grid">
                    <div class="method-stat"><strong>Custom Scope</strong><span>Tujuan dan deliverables disepakati</span>
                    </div>
                    <div class="method-stat"><strong>Phased Delivery</strong><span>Dapat dilaksanakan per tahap</span></div>
                    <div class="method-stat"><strong>Human Review</strong><span>Keputusan tetap pada pihak berwenang</span>
                    </div>
                    <div class="method-stat"><strong>Measurable</strong><span>Indikator dan tindak lanjut tersedia</span>
                    </div>
                </div>
            </div>
            <div>
                <div class="section-head left section-head-compact-26"><span class="eyebrow">Tahapan Kerja</span>
                    <h2>Proses Kolaborasi yang Jelas</h2>
                </div>
                <div class="process-list">
                    <article class="process-item"><span class="process-number">1</span>
                        <div>
                            <h3>Discovery &amp; Needs Assessment</h3>
                            <p>Diskusi tujuan, permasalahan, pengguna, data yang tersedia, batasan, dan hasil yang
                                diharapkan.</p>
                        </div>
                    </article>
                    <article class="process-item"><span class="process-number">2</span>
                        <div>
                            <h3>Scope &amp; Solution Design</h3>
                            <p>Penyusunan ruang lingkup, metode, jadwal, peran, deliverables, indikator, dan kebutuhan
                                dukungan institusi.</p>
                        </div>
                    </article>
                    <article class="process-item"><span class="process-number">3</span>
                        <div>
                            <h3>Development &amp; Validation</h3>
                            <p>Analisis, penyusunan perangkat, workshop validasi, penyempurnaan, dan persetujuan oleh pihak
                                yang berwenang.</p>
                        </div>
                    </article>
                    <article class="process-item"><span class="process-number">4</span>
                        <div>
                            <h3>Implementation &amp; Review</h3>
                            <p>Sosialisasi, pendampingan, uji penerapan, evaluasi hasil, dokumentasi, dan rekomendasi tindak
                                lanjut.</p>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>
    <section class="section section-dark" id="hasil">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Output Program',
                'title' => 'Hasil Kerja yang Praktis dan Dapat Digunakan',
                'description' =>
                    'Jenis keluaran disesuaikan dengan ruang lingkup. Tidak seluruh program menghasilkan semua output di bawah ini.',
            ])
            <div class="deliverable-grid">
                <article class="deliverable"><i>⌕</i>
                    <h3>Assessment Report</h3>
                    <p>Ringkasan kondisi, gap, risiko, prioritas, serta rekomendasi perbaikan.</p>
                </article>
                <article class="deliverable"><i>▤</i>
                    <h3>Policy &amp; Working Tools</h3>
                    <p>Draft panduan, SOP, alur, formulir, checklist, matriks, atau template pelaporan.</p>
                </article>
                <article class="deliverable"><i>↗</i>
                    <h3>Implementation Roadmap</h3>
                    <p>Tahapan, pemilik aksi, target waktu, dependensi, indikator, dan mekanisme pemantauan.</p>
                </article>
                <article class="deliverable"><i>🎓</i>
                    <h3>Knowledge Transfer</h3>
                    <p>Workshop, sosialisasi, coaching, atau materi pembelajaran bagi pengguna dan pemilik proses.</p>
                </article>
                <article class="deliverable"><i>▦</i>
                    <h3>Dashboard / Prototype</h3>
                    <p>Contoh dashboard, workflow, atau prototipe sederhana sesuai kebutuhan dan kelayakan.</p>
                </article>
                <article class="deliverable"><i>✓</i>
                    <h3>Evaluation Summary</h3>
                    <p>Catatan pelaksanaan, hasil uji, area tindak lanjut, serta rekomendasi tahap berikutnya.</p>
                </article>
            </div>
        </div>
    </section>
    <section class="section" id="ketentuan">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Prinsip &amp; Ketentuan',
                'title' => 'Kolaborasi yang Profesional dan Bertanggung Jawab',
                'description' =>
                    'Ketentuan rinci dituangkan dalam proposal, surat penawaran, perjanjian kerja sama, atau dokumen lain yang disepakati para pihak.',
            ])
            <div class="principle-grid">
                <article class="principle"> <span>01</span>
                    <div><strong>Kerahasiaan Data</strong>
                        <p>Data dan dokumen diproses sesuai kebutuhan, kewenangan, persetujuan, serta pengaturan kerahasiaan
                            yang disepakati.</p>
                    </div>
                </article>
                <article class="principle"> <span>02</span>
                    <div><strong>Kepatuhan Regulasi</strong>
                        <p>Referensi regulasi perlu diverifikasi terhadap sumber resmi terbaru sebelum digunakan sebagai
                            dasar
                            keputusan.</p>
                    </div>
                </article>
                <article class="principle"> <span>03</span>
                    <div><strong>Persetujuan Institusi</strong>
                        <p>Draft, rekomendasi, prototipe, dan keluaran lain memerlukan review serta persetujuan pihak
                            berwenang
                            sebelum diterapkan.</p>
                    </div>
                </article>
                <article class="principle"> <span>04</span>
                    <div><strong>Batasan Layanan</strong>
                        <p>Bankir Academy tidak menggantikan fungsi hukum, audit independen, regulator, atau pejabat
                            pengambil
                            keputusan institusi.</p>
                    </div>
                </article>
            </div>
            <div class="notice-box"><strong>Catatan:</strong> Durasi, biaya, personel, akses data, lokasi, metode, hak
                penggunaan hasil kerja, dukungan pascaimplementasi, dan kriteria penerimaan deliverables ditetapkan
                berdasarkan ruang lingkup yang disepakati.</div>
        </div>
    </section>
    <section class="section section-soft" id="faq">
        <div class="container">@include('frontend.components.section-head', [
            'eyebrow' => 'Pertanyaan Umum',
            'title' => 'Informasi Awal Banking Solution',
            'description' => 'Jawaban berikut membantu institusi memahami proses sebelum mengajukan konsultasi.',
        ])<div class="faq-wrap">
                <article class="faq-item open"><button class="faq-q" type="button">Siapa yang dapat menggunakan Banking
                        Solution?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Layanan ditujukan bagi Bank, BPR, BPRS, asosiasi, lembaga pendukung, dan institusi
                        lain yang memiliki kebutuhan relevan serta kewenangan untuk menjalankan program.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Apakah solusi dapat disesuaikan?<span
                            class="faq-plus">＋</span></button>
                    <div class="faq-a">Ya. Area, kedalaman analisis, metode, jadwal, peserta, deliverables, dan
                        pendampingan dapat disusun berdasarkan kebutuhan serta sumber daya institusi.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Data apa yang diperlukan?<span
                            class="faq-plus">＋</span></button>
                    <div class="faq-a">Kebutuhan data ditentukan setelah ruang lingkup disepakati. Institusi tetap
                        menentukan data yang dapat diberikan, metode akses, pihak berwenang, dan pengaturan kerahasiaannya.
                    </div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Apakah program harus dilaksanakan secara
                        penuh?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Tidak. Program dapat dimulai dari assessment, pilot project, workshop, atau satu
                        area prioritas sebelum diperluas ke tahap berikutnya.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Apakah Bankir Academy menjamin hasil
                        bisnis tertentu?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Tidak. Hasil dipengaruhi kondisi awal, keputusan manajemen, kualitas data, dukungan
                        pemilik proses, kepatuhan implementasi, dan faktor lain di luar ruang lingkup layanan.</div>
                </article>
            </div>
        </div>
    </section>
    <section class="final-cta" id="konsultasi">
        <div class="container">
            <div class="cta-box">
                <div>
                    <h2>Mulai dari Tantangan yang Paling Prioritas</h2>
                    <p>Sampaikan profil institusi, area yang ingin diperbaiki, kondisi saat ini, target, dan jadwal yang
                        diharapkan. Tim Bankir Academy akan membantu menyusun opsi ruang lingkup awal.</p>
                </div>
                <div class="cta-actions"><a class="btn btn-light"
                        href="mailto:info@bankiracademy.co.id?subject=Konsultasi%20Banking%20Solution">Email
                        Konsultasi</a><a class="btn btn-secondary" href="#ruang-lingkup">Pelajari Solusi</a></div>
            </div>
        </div>
    </section>
@endsection
