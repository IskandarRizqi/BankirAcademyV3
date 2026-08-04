@extends('layouts.appfrontend')

@section('page-title')
    Banking Talent Solution — Bankir Academy
@endsection

@section('page-description')
    Banking Talent Solution Bankir Academy membantu Bank, BPR, dan BPRS memetakan kompetensi, membangun talent pool,
    menyiapkan kader pimpinan, dan menyusun pengembangan talenta yang terarah.
@endsection

@section('content')
    <section class="hero solution-hero talent-hero" id="beranda">
        <div class="container hero-grid">
            <div>
                <span class="eyebrow">Banking Talent Solution</span>
                <h1>Membangun Talenta Perbankan yang <span class="gradient-text">Siap Berkinerja dan Bertumbuh</span></h1>
                <p class="hero-lead">Solusi pemetaan dan pengembangan talenta bagi Bank, BPR, dan BPRS untuk menyelaraskan
                    kompetensi pegawai, kebutuhan jabatan, arah bisnis, serta kesiapan kader secara terstruktur dan dapat
                    ditindaklanjuti.</p>
                <div class="hero-actions"><a class="btn btn-primary" href="#layanan">Jelajahi Solusi <span
                            class="icon-arrow">→</span></a><a class="btn btn-outline" href="#konsultasi">Konsultasikan
                        Kebutuhan</a></div>
                <div class="hero-proof"><span class="proof-item"><span class="proof-icon">✓</span>Berbasis
                        kompetensi</span><span class="proof-item"><span class="proof-icon">✓</span>Disesuaikan dengan
                        jabatan</span><span class="proof-item"><span class="proof-icon">✓</span>Berorientasi tindak
                        lanjut</span></div>
            </div>
            <div aria-label="Ilustrasi dashboard Banking Talent Solution" class="hero-visual">
                <div class="visual-main">
                    <div class="talent-board">
                        <div class="talent-board-head">Talent Development Dashboard <span>Development Ready</span></div>
                        <div class="talent-profile">
                            <div class="talent-avatar">◇</div>
                            <div>
                                <h3>Future Banking Leader</h3>
                                <p>Competency profile · readiness · development plan</p>
                            </div>
                        </div>
                        <div class="competency-grid">
                            <div class="competency-card"><strong>Business Acumen <em>82%</em></strong><small>Memahami bisnis
                                    dan prioritas bank</small>
                                <div class="board-meter"><i class="width-82"></i></div>
                            </div>
                            <div class="competency-card"><strong>Risk Awareness <em>76%</em></strong><small>Kepekaan risiko
                                    dan kontrol</small>
                                <div class="board-meter"><i class="width-76"></i></div>
                            </div>
                            <div class="competency-card"><strong>Leadership <em>68%</em></strong><small>Memimpin tim dan
                                    keputusan</small>
                                <div class="board-meter"><i class="width-68"></i></div>
                            </div>
                            <div class="competency-card"><strong>Digital Agility <em>73%</em></strong><small>Adaptasi
                                    teknologi dan proses</small>
                                <div class="board-meter"><i class="width-73"></i></div>
                            </div>
                        </div>
                        <div class="talent-path"><i>↗</i><span><strong>Recommended Development Path</strong>Coaching ·
                                stretch assignment · targeted learning</span></div>
                    </div>
                </div>
                <div class="float-card one"><span class="float-icon">⌕</span><span><strong>Competency
                            Mapping</strong><small>Profil kekuatan dan gap</small></span></div>
                <div class="float-card two"><span class="float-icon">◎</span><span><strong>Talent
                            Pool</strong><small>Kesiapan kader jabatan</small></span></div>
            </div>
        </div>
    </section>
    <div class="quick-nav">
        <div class="container">
            <nav aria-label="Navigasi Banking Talent Solution" class="quick-nav-inner">
                <a href="#sasaran"><i>◇</i><span><strong>Sasaran Program</strong><span>Siapa yang
                            dikembangkan</span></span></a>
                <a href="#layanan"><i>▦</i><span><strong>Ruang Lingkup</strong><span>Pemetaan hingga
                            pengembangan</span></span></a>
                <a href="#metode"><i>↗</i><span><strong>Metode Kerja</strong><span>Proses yang terstruktur</span></span></a>
                <a href="#hasil"><i>✓</i><span><strong>Output Program</strong><span>Hasil yang dapat
                            digunakan</span></span></a>
            </nav>
        </div>
    </div>
    <section class="section" id="sasaran">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Sasaran Pengembangan',
                'title' => 'Talenta yang Tepat untuk Setiap Tahap Organisasi',
                'description' =>
                    'Program dapat diarahkan pada satu kelompok tertentu atau dirancang sebagai arsitektur pengembangan talenta lintas jenjang.',
            ])
            <div class="audience-grid">
                <article class="audience-card"><i>1</i>
                    <h3>Entry-Level Talent</h3>
                    <p>Calon pegawai dan pegawai baru yang membutuhkan kesiapan dasar, orientasi industri, budaya kerja,
                        serta fondasi kompetensi jabatan.</p>
                </article>
                <article class="audience-card"><i>2</i>
                    <h3>Professional &amp; Specialist</h3>
                    <p>Pegawai pelaksana dan spesialis yang perlu memperkuat kompetensi teknis, perilaku, kolaborasi, dan
                        kesiapan menerima tanggung jawab lebih besar.</p>
                </article>
                <article class="audience-card"><i>3</i>
                    <h3>Supervisor &amp; Manager</h3>
                    <p>Talenta pimpinan lini yang membutuhkan kemampuan memimpin tim, mengelola kinerja, risiko, perubahan,
                        dan pengambilan keputusan.</p>
                </article>
                <article class="audience-card"><i>4</i>
                    <h3>Future Leader</h3>
                    <p>Kandidat pemimpin yang dipersiapkan melalui pemetaan kesiapan, exposure strategis, coaching,
                        assignment, serta rencana suksesi.</p>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-soft" id="layanan">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Ruang Lingkup Solusi',
                'title' => 'Pengelolaan Talenta dari Pemetaan hingga Kesiapan Jabatan',
                'description' =>
                    'Setiap komponen dapat digunakan secara mandiri atau digabungkan menjadi program talent development yang terpadu.',
            ])
            <div class="solution-grid">
                <article class="solution-card">
                    <div class="card-icon">⌕</div>
                    <h3>Competency Framework</h3>
                    <p>Penyusunan atau penyelarasan kompetensi inti, manajerial, dan teknis berdasarkan nilai organisasi
                        serta kebutuhan jabatan.</p>
                    <ul>
                        <li>Definisi dan indikator perilaku</li>
                        <li>Level profisiensi per jabatan</li>
                        <li>Kamus kompetensi dan panduan</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">▦</div>
                    <h3>Competency Mapping</h3>
                    <p>Pemetaan profil kompetensi individu atau kelompok untuk mengenali kekuatan, gap, potensi, dan
                        prioritas pengembangan.</p>
                    <ul>
                        <li>Assessment berbasis metode terpilih</li>
                        <li>Individual dan group profile</li>
                        <li>Gap serta development priority</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">◎</div>
                    <h3>Talent Pool Management</h3>
                    <p>Pengelompokan talenta berdasarkan kinerja, potensi, kesiapan, pengalaman, serta kebutuhan organisasi
                        yang disepakati.</p>
                    <ul>
                        <li>Kriteria dan mekanisme nominasi</li>
                        <li>Talent calibration session</li>
                        <li>Database dan review berkala</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">↗</div>
                    <h3>Career &amp; Learning Path</h3>
                    <p>Perancangan jalur karier dan pengembangan yang menunjukkan pengalaman, kompetensi, pembelajaran, dan
                        kesiapan yang dibutuhkan.</p>
                    <ul>
                        <li>Career architecture</li>
                        <li>Learning journey per role</li>
                        <li>Milestone dan readiness criteria</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">◇</div>
                    <h3>Individual Development Plan</h3>
                    <p>Penyusunan rencana pengembangan individual yang realistis melalui pembelajaran, coaching, mentoring,
                        dan pengalaman kerja.</p>
                    <ul>
                        <li>Target kompetensi prioritas</li>
                        <li>Metode 70-20-10 yang adaptif</li>
                        <li>Review progres dan evidence</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">✦</div>
                    <h3>Succession Readiness</h3>
                    <p>Dukungan penyiapan kandidat untuk jabatan kritis melalui pemetaan risiko suksesi, kesiapan, dan
                        rencana akselerasi.</p>
                    <ul>
                        <li>Critical role identification</li>
                        <li>Successor slate dan readiness</li>
                        <li>Development acceleration plan</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>
    <section class="section" id="kerangka">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Talent Development Framework',
                'title' => 'Alur yang Konsisten dan Mudah Dipantau',
                'description' =>
                    'Kerangka berikut membantu memastikan pengembangan tidak berhenti pada hasil asesmen, tetapi berlanjut menjadi tindakan dan evaluasi.',
            ])
            <div class="framework-grid">
                <article class="framework-item"><b>1</b>
                    <h3>Define</h3>
                    <p>Menetapkan sasaran, kelompok talenta, jabatan kritis, dan kompetensi yang dibutuhkan.</p>
                </article>
                <article class="framework-item"><b>2</b>
                    <h3>Assess</h3>
                    <p>Mengumpulkan evidence dan memetakan profil sesuai metode yang disepakati.</p>
                </article>
                <article class="framework-item"><b>3</b>
                    <h3>Calibrate</h3>
                    <p>Menyelaraskan hasil bersama pihak berwenang agar keputusan lebih objektif dan konsisten.</p>
                </article>
                <article class="framework-item"><b>4</b>
                    <h3>Develop</h3>
                    <p>Menjalankan pembelajaran, coaching, mentoring, assignment, atau rotasi yang relevan.</p>
                </article>
                <article class="framework-item"><b>5</b>
                    <h3>Review</h3>
                    <p>Menilai progres, evidence, readiness, risiko, dan tindak lanjut berikutnya secara berkala.</p>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-soft" id="metode">
        <div class="container matrix-wrap">
            <div class="matrix-card"><span class="eyebrow">Talent Calibration</span>
                <h3>Membaca Kinerja, Potensi, dan Kesiapan secara Seimbang</h3>
                <p>Matriks talenta dapat digunakan sebagai alat bantu diskusi. Penempatan individu tetap memerlukan data
                    yang memadai, kalibrasi, kebijakan organisasi, dan keputusan pihak yang berwenang.</p>
                <div class="matrix-grid">
                    <div class="matrix-cell"><strong>Emerging</strong><span>Perlu penguatan fondasi</span></div>
                    <div class="matrix-cell"><strong>Core Contributor</strong><span>Kinerja stabil dan bernilai</span></div>
                    <div class="matrix-cell"><strong>High Professional</strong><span>Keahlian kuat dan konsisten</span>
                    </div>
                    <div class="matrix-cell"><strong>Developing Talent</strong><span>Potensi dengan gap tertentu</span>
                    </div>
                    <div class="matrix-cell highlight"><strong>Growth Talent</strong><span>Siap dipercepat bertahap</span>
                    </div>
                    <div class="matrix-cell highlight"><strong>Future Leader</strong><span>Kandidat prioritas
                            strategis</span></div>
                    <div class="matrix-cell"><strong>Role Review</strong><span>Perlu telaah kecocokan peran</span></div>
                    <div class="matrix-cell"><strong>Performance Focus</strong><span>Penguatan target dan dukungan</span>
                    </div>
                    <div class="matrix-cell"><strong>Special Assignment</strong><span>Uji kesiapan melalui exposure</span>
                    </div>
                </div>
            </div>
            <div>
                <div class="section-head left section-head-compact-25"><span class="eyebrow">Prinsip Pelaksanaan</span>
                    <h2>Objektif, Kontekstual, dan Berorientasi Pengembangan</h2>
                </div>
                <div class="benefit-list">
                    <article class="benefit-item"><i>✓</i>
                        <div>
                            <h3>Multiple Evidence</h3>
                            <p>Keputusan tidak hanya bergantung pada satu skor, tetapi mempertimbangkan data, observasi,
                                rekam kinerja, dan konteks jabatan.</p>
                        </div>
                    </article>
                    <article class="benefit-item"><i>◇</i>
                        <div>
                            <h3>Fair &amp; Role-Relevant</h3>
                            <p>Kriteria dan metode perlu relevan dengan pekerjaan, diterapkan secara konsisten, dan
                                dijelaskan kepada pihak terkait.</p>
                        </div>
                    </article>
                    <article class="benefit-item"><i>↗</i>
                        <div>
                            <h3>Development First</h3>
                            <p>Hasil digunakan untuk merancang tindak lanjut, bukan sekadar memberi label atau peringkat
                                kepada pegawai.</p>
                        </div>
                    </article>
                    <article class="benefit-item"><i>◎</i>
                        <div>
                            <h3>Periodic Review</h3>
                            <p>Profil dan kesiapan talenta perlu diperbarui karena kinerja, pengalaman, kompetensi, dan
                                kebutuhan organisasi dapat berubah.</p>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>
    <section class="section" id="program">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Pilihan Program',
                'title' => 'Format Implementasi yang Fleksibel',
                'description' =>
                    'Nama, durasi, cakupan peserta, metode, dan deliverables ditetapkan setelah kebutuhan awal dipahami.',
            ])
            <div class="package-grid">
                <article class="package-card">
                    <div class="card-icon">⌕</div>
                    <h3>Talent Diagnostic</h3>
                    <p>Untuk organisasi yang membutuhkan gambaran awal kondisi, gap, risiko, dan prioritas pengelolaan
                        talenta.</p>
                    <ul>
                        <li>Needs assessment</li>
                        <li>Review sistem dan dokumen</li>
                        <li>Diagnostic report</li>
                        <li>Prioritized recommendation</li>
                    </ul>
                </article>
                <article class="package-card featured">
                    <div class="card-icon card-icon-light">◇</div>
                    <h3>Integrated Talent Program</h3>
                    <p>Program terpadu dari framework, assessment, calibration, talent pool, hingga rencana pengembangan dan
                        review.</p>
                    <ul>
                        <li>Customized competency model</li>
                        <li>Assessment dan calibration</li>
                        <li>Talent profile serta IDP</li>
                        <li>Governance dan monitoring</li>
                    </ul>
                </article>
                <article class="package-card">
                    <div class="card-icon">↗</div>
                    <h3>Leadership Acceleration</h3>
                    <p>Untuk mempercepat kesiapan supervisor, manajer, atau kandidat pemimpin melalui pengalaman dan
                        pembelajaran terarah.</p>
                    <ul>
                        <li>Leadership readiness mapping</li>
                        <li>Workshop dan coaching</li>
                        <li>Action learning project</li>
                        <li>Progress review</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-dark" id="hasil">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Output Program',
                'title' => 'Hasil yang Mendukung Keputusan dan Pengembangan',
                'description' =>
                    'Jenis output menyesuaikan ruang lingkup, metode, ketersediaan data, dan kewenangan institusi.',
            ])
            <div class="deliverable-grid">
                <article class="deliverable"><i>▤</i>
                    <h3>Competency Dictionary</h3>
                    <p>Definisi kompetensi, indikator perilaku, level profisiensi, dan keterkaitan dengan jabatan.</p>
                </article>
                <article class="deliverable"><i>⌕</i>
                    <h3>Talent Profile</h3>
                    <p>Ringkasan kekuatan, gap, potensi, readiness, dan area pengembangan individu atau kelompok.</p>
                </article>
                <article class="deliverable"><i>▦</i>
                    <h3>Talent Dashboard</h3>
                    <p>Rekap talent pool, posisi kritis, kesiapan kandidat, risiko, dan status tindak lanjut.</p>
                </article>
                <article class="deliverable"><i>◇</i>
                    <h3>Development Plan</h3>
                    <p>Rencana pembelajaran, coaching, mentoring, assignment, target, jadwal, dan evidence.</p>
                </article>
                <article class="deliverable"><i>↗</i>
                    <h3>Succession Map</h3>
                    <p>Daftar kandidat, tingkat kesiapan, gap utama, dan program akselerasi untuk peran tertentu.</p>
                </article>
                <article class="deliverable"><i>✓</i>
                    <h3>Review Summary</h3>
                    <p>Catatan progres, hasil kalibrasi, perubahan readiness, risiko, dan rekomendasi berikutnya.</p>
                </article>
            </div>
        </div>
    </section>
    <section class="section" id="ketentuan">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Prinsip &amp; Ketentuan',
                'title' => 'Pengelolaan Data Talenta yang Bertanggung Jawab',
                'description' =>
                    'Ketentuan rinci dituangkan dalam proposal atau perjanjian yang disepakati oleh para pihak.',
            ])
            <div class="principle-grid">
                <article class="principle"> <span>01</span>
                    <div><strong>Kerahasiaan Data</strong>
                        <p>Data individu dan organisasi diproses sesuai tujuan, akses, kewenangan, persetujuan, serta
                            pengaturan
                            kerahasiaan yang disepakati.</p>
                    </div>
                </article>
                <article class="principle"> <span>02</span>
                    <div><strong>Bukan Keputusan Tunggal</strong>
                        <p>Hasil assessment atau matriks menjadi alat bantu dan tidak seharusnya digunakan sebagai
                            satu-satunya
                            dasar keputusan karier atau kepegawaian.</p>
                    </div>
                </article>
                <article class="principle"> <span>03</span>
                    <div><strong>Validasi Institusi</strong>
                        <p>Kriteria jabatan, profil kompetensi, hasil kalibrasi, dan rekomendasi perlu ditinjau serta
                            disetujui
                            pihak yang berwenang.</p>
                    </div>
                </article>
                <article class="principle"> <span>04</span>
                    <div><strong>Kesetaraan Kesempatan</strong>
                        <p>Pelaksanaan perlu menghindari diskriminasi, bias yang tidak relevan, serta penggunaan data di
                            luar
                            tujuan yang telah ditetapkan.</p>
                    </div>
                </article>
            </div>
            <div class="notice-box"><strong>Catatan:</strong> Bankir Academy tidak menjamin promosi, penempatan, kelulusan
                assessment, atau hasil karier tertentu. Keputusan kepegawaian tetap menjadi kewenangan institusi berdasarkan
                kebijakan dan ketentuan yang berlaku.</div>
        </div>
    </section>
    <section class="section section-soft" id="faq">
        <div class="container">@include('frontend.components.section-head', [
            'eyebrow' => 'Pertanyaan Umum',
            'title' => 'Informasi Awal Banking Talent Solution',
            'description' => 'Beberapa hal penting sebelum institusi memulai program pengembangan talenta.',
        ])<div class="faq-wrap">
                <article class="faq-item open"><button class="faq-q" type="button">Apa perbedaan Banking Talent
                        Solution dan layanan rekrutmen?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Banking Talent Solution berfokus pada pemetaan dan pengembangan talenta yang
                        dimiliki atau dipersiapkan organisasi. Layanan rekrutmen berfokus pada pencarian dan pemenuhan
                        kandidat untuk kebutuhan posisi tertentu.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Apakah program hanya untuk calon
                        pimpinan?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Tidak. Program dapat digunakan untuk pegawai baru, pelaksana, spesialis,
                        supervisor, manajer, talent pool, hingga kandidat suksesi sesuai sasaran institusi.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Apakah assessment dapat disesuaikan?<span
                            class="faq-plus">＋</span></button>
                    <div class="faq-a">Ya. Metode dipilih berdasarkan tujuan, jabatan, jumlah peserta, waktu, data yang
                        tersedia, serta kelayakan. Tidak semua kebutuhan harus menggunakan metode yang sama.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Berapa lama program berlangsung?<span
                            class="faq-plus">＋</span></button>
                    <div class="faq-a">Durasi bergantung pada cakupan peserta dan tahapan. Diagnostic dapat dilakukan
                        lebih ringkas, sedangkan program pengembangan terpadu dapat berlangsung dalam beberapa fase dan
                        review berkala.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Apakah hasil dapat digunakan untuk
                        promosi?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Hasil dapat menjadi salah satu bahan pertimbangan, tetapi keputusan promosi perlu
                        menggunakan multiple evidence, kebijakan internal, kebutuhan jabatan, dan persetujuan pejabat yang
                        berwenang.</div>
                </article>
            </div>
        </div>
    </section>
    <section class="final-cta" id="konsultasi">
        <div class="container">
            <div class="cta-box">
                <div>
                    <h2>Bangun Sistem Talenta yang Lebih Terarah</h2>
                    <p>Sampaikan kelompok sasaran, jumlah peserta, jabatan, tantangan, sistem yang sudah tersedia, serta
                        hasil yang ingin dicapai. Tim Bankir Academy akan membantu menyusun opsi ruang lingkup awal.</p>
                </div>
                <div class="cta-actions"><a class="btn btn-light"
                        href="mailto:info@bankiracademy.co.id?subject=Konsultasi%20Banking%20Talent%20Solution">Email
                        Konsultasi</a><a class="btn btn-secondary" href="#layanan">Pelajari Solusi</a></div>
            </div>
        </div>
    </section>
@endsection
