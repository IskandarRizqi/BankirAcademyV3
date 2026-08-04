@extends('layouts.appfrontend')

@section('page-title')
    Program CSR — Bankir Academy
@endsection

@section('page-description')
    Program CSR Bankir Academy membantu institusi merancang, melaksanakan, mendokumentasikan, dan mengevaluasi program
    pendidikan, literasi keuangan, kesiapan karier, serta pemberdayaan UMKM secara terarah dan berkelanjutan.
@endsection

@section('content')
    <section class="hero solution-hero" id="ringkasan">
        <div class="container hero-grid">
            <div>
                <span class="eyebrow">Corporate Social Responsibility Program</span>
                <h1>Menghadirkan Program Sosial yang <span class="gradient-text">Terarah, Relevan, dan Terukur</span></h1>
                <p class="hero-lead">Program CSR Bankir Academy membantu bank, BPR/BPRS, perusahaan, dan institusi mitra
                    merancang serta melaksanakan kegiatan pendidikan, literasi keuangan, kesiapan karier, dan pemberdayaan
                    UMKM. Setiap program disusun berdasarkan kebutuhan penerima manfaat, tujuan mitra, ruang lingkup,
                    indikator, dokumentasi, dan evaluasi yang disepakati.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="#fokus-program">Jelajahi Program <span class="icon-arrow">→</span></a>
                    <a class="btn btn-outline" href="#konsultasi">Diskusikan Kolaborasi</a>
                </div>
                <div class="hero-proof">
                    <span class="proof-item"><span class="proof-icon">✓</span>Berbasis kebutuhan penerima manfaat</span>
                    <span class="proof-item"><span class="proof-icon">✓</span>Indikator dan dokumentasi jelas</span>
                    <span class="proof-item"><span class="proof-icon">✓</span>Dapat dijalankan bertahap</span>
                </div>
            </div>
            <div aria-label="Ilustrasi Program CSR Bankir Academy" class="hero-visual">
                <div class="visual-main">
                    <div class="dashboard">
                        <div class="dash-top">
                            <div class="dash-brand"><svg aria-hidden="true" height="31" width="31">
                                    <use href="#logo-ba"></use>
                                </svg>CSR IMPACT WORKSPACE</div>
                            <div class="dash-dots"><span></span><span></span><span></span></div>
                        </div>
                        <div class="dash-hero">
                            <div class="dash-label">Purposeful Community Program</div>
                            <h3>Plan. Empower. Measure. Improve.</h3>
                            <p>Satu kerangka kolaborasi untuk merancang program, menjangkau penerima manfaat, mencatat
                                aktivitas, dan mengevaluasi dampak.</p>
                            <div class="dash-stats">
                                <div class="dash-stat"><strong>Targeted</strong><span>Sasaran program jelas</span></div>
                                <div class="dash-stat"><strong>Collaborative</strong><span>Peran mitra terstruktur</span>
                                </div>
                                <div class="dash-stat"><strong>Measurable</strong><span>Output dapat dilaporkan</span></div>
                            </div>
                        </div>
                        <div class="dash-grid">
                            <div class="dash-card">
                                <h4>Program Progress</h4>
                                <div class="progress"><span class="width-76"></span></div>
                                <div class="mini-list mini-list-spaced">
                                    <div class="mini-row"><i></i><span>Pemetaan kebutuhan</span></div>
                                    <div class="mini-row"><i class="dot-accent"></i><span>Pelaksanaan kegiatan</span></div>
                                    <div class="mini-row"><i class="dot-primary"></i><span>Evaluasi dan laporan</span></div>
                                </div>
                            </div>
                            <div class="dash-card">
                                <h4>Impact Area</h4>
                                <div class="mini-list">
                                    <div class="mini-row"><i></i><span>Literasi keuangan</span></div>
                                    <div class="mini-row"><i class="dot-primary"></i><span>Kesiapan karier</span></div>
                                    <div class="mini-row"><i class="dot-accent"></i><span>Pemberdayaan UMKM</span></div>
                                    <div class="mini-row"><i class="dot-danger"></i><span>Pendidikan digital</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="float-card one"><span class="float-icon">🎓</span><span><strong>Bakti
                            Pendidikan</strong><small>Pelajar dan calon bankir</small></span></div>
                <div class="float-card two"><span class="float-icon">⌂</span><span><strong>Bakti
                            UMKM</strong><small>Penguatan kapasitas usaha</small></span></div>
                <div class="float-card three"><span class="float-icon">▦</span><span><strong>Impact
                            Report</strong><small>Dokumentasi dan evaluasi</small></span></div>
            </div>
        </div>
    </section>
    <div class="trust-strip">
        <div class="container trust-inner">
            <div class="trust-copy"><strong>Kolaborasi CSR untuk berbagai penerima manfaat</strong><span>Program dapat
                    disesuaikan berdasarkan lokasi, profil peserta, tujuan sosial, anggaran, durasi, dan kebijakan
                    mitra.</span></div>
            <div class="trust-item"><span class="trust-mark">S</span>Sekolah</div>
            <div class="trust-item"><span class="trust-mark">K</span>Kampus</div>
            <div class="trust-item"><span class="trust-mark">U</span>UMKM</div>
            <div class="trust-item"><span class="trust-mark">C</span>Komunitas</div>
        </div>
    </div>
    <section class="section" id="kebutuhan">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Mengapa Program Terstruktur',
                'title' => 'CSR yang Baik Memerlukan Tujuan, Sasaran, dan Bukti Pelaksanaan',
                'description' =>
                    'Kegiatan sosial menjadi lebih bermakna ketika kebutuhan penerima manfaat dipahami, peran para pihak jelas, materi sesuai konteks, dan hasil program dapat ditinjau secara objektif.',
            ])
            <div class="challenge-grid">
                <article class="challenge-card"><span class="challenge-no">01</span>
                    <h3>Sasaran Belum Spesifik</h3>
                    <p>Program dijalankan tanpa profil peserta, masalah utama, atau hasil yang ingin dicapai secara jelas.
                    </p>
                </article>
                <article class="challenge-card"><span class="challenge-no">02</span>
                    <h3>Kegiatan Bersifat Seremonial</h3>
                    <p>Aktivitas selesai dalam satu hari tanpa materi lanjutan, penguatan praktik, atau tindak lanjut yang
                        relevan.</p>
                </article>
                <article class="challenge-card"><span class="challenge-no">03</span>
                    <h3>Dokumentasi Terpisah</h3>
                    <p>Data peserta, kehadiran, foto, materi, evaluasi, dan bukti aktivitas tidak tersusun dalam satu
                        laporan yang rapi.</p>
                </article>
                <article class="challenge-card"><span class="challenge-no">04</span>
                    <h3>Dampak Sulit Dijelaskan</h3>
                    <p>Mitra kesulitan menunjukkan hubungan antara kegiatan, output, perubahan pengetahuan, dan manfaat bagi
                        peserta.</p>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-soft" id="fokus-program">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Fokus Program',
                'title' => 'Pilihan Program yang Dapat Dikembangkan Bersama Mitra',
                'description' =>
                    'Setiap fokus dapat digunakan secara mandiri atau digabungkan menjadi rangkaian program sesuai kebutuhan penerima manfaat dan prioritas CSR institusi.',
            ])
            <div class="solution-grid">
                <article class="solution-card">
                    <div class="card-icon">🎓</div>
                    <h3>Literasi Industri Perbankan</h3>
                    <p>Pengenalan fungsi bank, produk dan layanan, profesi perbankan, etika, keamanan transaksi, serta peran
                        lembaga keuangan dalam perekonomian.</p>
                    <ul>
                        <li>Inside the Bank</li>
                        <li>Pengenalan profesi bankir</li>
                        <li>Kunjungan dan kelas industri</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">◎</div>
                    <h3>Literasi Keuangan</h3>
                    <p>Pembelajaran praktis mengenai pengelolaan uang, tabungan, kredit, pembiayaan, perlindungan data, dan
                        penggunaan layanan keuangan secara bertanggung jawab.</p>
                    <ul>
                        <li>Keuangan pribadi dasar</li>
                        <li>Waspada penipuan digital</li>
                        <li>Pengenalan produk keuangan</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">↗</div>
                    <h3>Kesiapan Karier</h3>
                    <p>Membantu siswa, mahasiswa, dan fresh graduate memahami kompetensi kerja, menyiapkan CV, menghadapi
                        wawancara, dan membangun etika profesional.</p>
                    <ul>
                        <li>Career readiness class</li>
                        <li>CV dan simulasi wawancara</li>
                        <li>Workplace preparation</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">⌂</div>
                    <h3>Pemberdayaan UMKM</h3>
                    <p>Penguatan kapasitas pelaku usaha pada pencatatan, arus kas, pemasaran, layanan pelanggan,
                        digitalisasi, dan kesiapan pembiayaan.</p>
                    <ul>
                        <li>Business fundamentals</li>
                        <li>Digital marketing praktis</li>
                        <li>Financial readiness</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">▶</div>
                    <h3>Pendidikan Digital</h3>
                    <p>Penyediaan kelas digital, video pembelajaran, e-book, kuis, dan akses LMS untuk memperluas jangkauan
                        serta keberlanjutan program.</p>
                    <ul>
                        <li>Microlearning dan video</li>
                        <li>E-book dan lembar kerja</li>
                        <li>Kelas daring terstruktur</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">♡</div>
                    <h3>Program Beasiswa Belajar</h3>
                    <p>Dukungan akses pembelajaran bagi peserta yang ditetapkan mitra berdasarkan kriteria, proses seleksi,
                        dan kuota yang telah disepakati.</p>
                    <ul>
                        <li>Penetapan kriteria peserta</li>
                        <li>Paket pembelajaran</li>
                        <li>Monitoring penyelesaian</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>
    <section class="section" id="model-kolaborasi">
        <div class="container method-wrap">
            <div class="method-panel"><span class="eyebrow">Peran Mitra</span>
                <h3>Menentukan Arah, Dukungan, dan Kebijakan Program</h3>
                <p>Mitra menetapkan tujuan CSR, kelompok sasaran, lokasi, anggaran, bentuk dukungan, ketentuan penggunaan
                    identitas, proses persetujuan, serta pihak yang berwenang mengambil keputusan.</p>
                <div class="method-stat-grid">
                    <div class="method-stat"><strong>Purpose</strong><span>Menetapkan tujuan sosial dan hasil yang
                            diharapkan.</span></div>
                    <div class="method-stat"><strong>Beneficiary</strong><span>Menentukan kriteria dan sasaran penerima
                            manfaat.</span></div>
                    <div class="method-stat"><strong>Governance</strong><span>Memberikan persetujuan, akses, dan kebijakan
                            program.</span></div>
                    <div class="method-stat"><strong>Support</strong><span>Menyediakan pendanaan atau sumber daya sesuai
                            kesepakatan.</span></div>
                </div>
            </div>
            <div class="method-panel"><span class="eyebrow">Peran Bankir Academy</span>
                <h3>Merancang dan Menjalankan Program Secara Terstruktur</h3>
                <p>Bankir Academy membantu menyusun konsep, kurikulum, materi, metode, fasilitator, administrasi peserta,
                    pelaksanaan, dokumentasi, evaluasi, dan laporan sesuai ruang lingkup yang disepakati.</p>
                <div class="method-stat-grid">
                    <div class="method-stat"><strong>Design</strong><span>Menyusun program dan materi berdasarkan
                            kebutuhan.</span></div>
                    <div class="method-stat"><strong>Delivery</strong><span>Mengelola pelaksanaan daring, luring, atau
                            blended.</span></div>
                    <div class="method-stat"><strong>Evidence</strong><span>Mengumpulkan data aktivitas dan bukti
                            program.</span></div>
                    <div class="method-stat"><strong>Report</strong><span>Menyusun ringkasan hasil dan rekomendasi tindak
                            lanjut.</span></div>
                </div>
            </div>
        </div>
    </section>
    <section class="section section-soft" id="tahapan">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Tahapan Pelaksanaan',
                'title' => 'Dari Pemetaan Kebutuhan hingga Laporan Dampak',
                'description' =>
                    'Tahapan dapat disederhanakan atau diperluas berdasarkan skala, durasi, jumlah lokasi, kompleksitas peserta, dan kebutuhan pelaporan.',
            ])
            <div class="steps">
                <article class="step"><span class="step-no">1</span>
                    <h3>Need Assessment</h3>
                    <p>Mengidentifikasi tujuan mitra, profil penerima manfaat, kebutuhan, lokasi, sumber daya, serta risiko
                        pelaksanaan.</p>
                </article>
                <article class="step"><span class="step-no">2</span>
                    <h3>Program Design</h3>
                    <p>Menyusun konsep, materi, metode, indikator, jadwal, peran, kebutuhan dokumentasi, dan rencana
                        komunikasi.</p>
                </article>
                <article class="step"><span class="step-no">3</span>
                    <h3>Implementation</h3>
                    <p>Melaksanakan program, mengelola peserta, fasilitator, materi, logistik, kehadiran, serta koordinasi
                        lapangan.</p>
                </article>
                <article class="step"><span class="step-no">4</span>
                    <h3>Evaluation &amp; Report</h3>
                    <p>Mengolah data, mendokumentasikan hasil, mencatat kendala, dan menyusun rekomendasi program
                        berikutnya.</p>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-dark" id="pengukuran">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Impact Measurement',
                'title' => 'Pengukuran Disesuaikan dengan Tujuan dan Skala Program',
                'description' =>
                    'Pengukuran tidak hanya mencatat jumlah kegiatan, tetapi juga memperhatikan kualitas pelaksanaan dan perubahan yang dapat diamati secara proporsional.',
            ])
            <div class="principle-grid">
                <article class="principle"><span>01</span>
                    <div><strong>Input</strong>
                        <p>Sumber daya, fasilitator, materi, lokasi, platform, anggaran, dan dukungan yang digunakan.</p>
                    </div>
                </article>
                <article class="principle"><span>02</span>
                    <div><strong>Activity</strong>
                        <p>Jumlah kelas, sesi, jam belajar, mentoring, kunjungan, atau aktivitas lain yang dilaksanakan.</p>
                    </div>
                </article>
                <article class="principle"><span>03</span>
                    <div><strong>Output</strong>
                        <p>Jumlah peserta, tingkat kehadiran, penyelesaian, materi terdistribusi, tugas, dan sertifikat.</p>
                    </div>
                </article>
                <article class="principle"><span>04</span>
                    <div><strong>Learning Outcome</strong>
                        <p>Perubahan pengetahuan, pemahaman, keterampilan, atau kesiapan yang diukur melalui instrumen yang
                            relevan.</p>
                    </div>
                </article>
                <article class="principle"><span>05</span>
                    <div><strong>Participant Feedback</strong>
                        <p>Pengalaman peserta, relevansi materi, kualitas fasilitasi, kendala, dan saran perbaikan.</p>
                    </div>
                </article>
                <article class="principle"><span>06</span>
                    <div><strong>Follow-up</strong>
                        <p>Rekomendasi, kebutuhan penguatan, rencana lanjutan, dan peluang pengembangan program.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>
    <section class="section" id="model-program">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Model Program',
                'title' => 'Pilih Format Berdasarkan Jangkauan dan Tujuan CSR',
                'description' =>
                    'Nama berikut merupakan gambaran model kolaborasi. Ruang lingkup final mengikuti kebutuhan, anggaran, jumlah peserta, lokasi, durasi, dan tanggung jawab para pihak.',
            ])
            <div class="cards-3">
                <article class="service-card">
                    <div class="card-icon">◎</div><span class="tag tag-spaced">Single Activity</span>
                    <h3>CSR Class</h3>
                    <p>Kegiatan satu kali untuk topik spesifik dengan peserta dan durasi yang telah ditentukan.</p>
                    <ul class="card-list">
                        <li>Kelas atau seminar edukatif</li>
                        <li>Materi dan dokumentasi dasar</li>
                        <li>Ringkasan pelaksanaan</li>
                    </ul>
                </article>
                <article class="service-card">
                    <div class="card-icon">↗</div><span class="tag tag-spaced">Program Series</span>
                    <h3>CSR Development Program</h3>
                    <p>Rangkaian kelas, tugas, mentoring, dan evaluasi untuk membangun kompetensi secara bertahap.</p>
                    <ul class="card-list">
                        <li>Kurikulum beberapa sesi</li>
                        <li>Pre-test dan post-test</li>
                        <li>Laporan perkembangan program</li>
                    </ul>
                </article>
                <article class="service-card">
                    <div class="card-icon">✦</div><span class="tag tag-spaced">Multi-Stakeholder</span>
                    <h3>CSR Partnership Program</h3>
                    <p> melibatkan mitra, sekolah, kampus, komunitas, pemerintah daerah, atau lembaga pendukung.</p>
                    <ul class="card-list">
                        <li>Pembagian peran para pihak</li>
                        <li>Pelaksanaan multi-lokasi</li>
                        <li>Dokumentasi dan laporan terpadu</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-soft" id="output">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Output Program',
                'title' => 'Dokumen dan Bukti Pelaksanaan yang Lebih Tertata',
                'description' =>
                    'Output aktual mengikuti ruang lingkup, metode pengumpulan data, persetujuan dokumentasi, dan format laporan yang disepakati.',
            ])
            <div class="principle-grid">
                <article class="principle"><span>01</span>
                    <div><strong>Program Concept</strong>
                        <p>Tujuan, sasaran, topik, metode, jadwal, indikator, peran, dan kebutuhan sumber daya.</p>
                    </div>
                </article>
                <article class="principle"><span>02</span>
                    <div><strong>Learning Materials</strong>
                        <p>Modul, presentasi, e-book, video, lembar kerja, kuis, atau materi pendukung sesuai program.</p>
                    </div>
                </article>
                <article class="principle"><span>03</span>
                    <div><strong>Participant Administration</strong>
                        <p>Data peserta, undangan, registrasi, kehadiran, kelompok, dan status penyelesaian.</p>
                    </div>
                </article>
                <article class="principle"><span>04</span>
                    <div><strong>Activity Documentation</strong>
                        <p>Foto, video, catatan kegiatan, testimoni, dan bukti lain sesuai izin serta kebijakan dokumentasi.
                        </p>
                    </div>
                </article>
                <article class="principle"><span>05</span>
                    <div><strong>Evaluation Summary</strong>
                        <p>Ringkasan asesmen, umpan balik, tingkat partisipasi, capaian, kendala, dan pembelajaran program.
                        </p>
                    </div>
                </article>
                <article class="principle"><span>06</span>
                    <div><strong>CSR Report</strong>
                        <p>Laporan pelaksanaan dan rekomendasi tindak lanjut dalam format yang disepakati bersama mitra.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>
    <section class="section" id="ketentuan">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Prinsip &amp; Ketentuan',
                'title' => 'Program Dilaksanakan dengan Tata Kelola yang Jelas',
                'description' =>
                    'Hak, kewajiban, pendanaan, penggunaan identitas, data peserta, dokumentasi, jadwal, perubahan ruang lingkup, dan pelaporan dituangkan dalam proposal atau perjanjian.',
            ])
            <div class="principle-grid">
                <article class="principle"><span>✓</span>
                    <div><strong>Penerima Manfaat Ditetapkan</strong>
                        <p>Kriteria, jumlah, lokasi, dan mekanisme pemilihan peserta ditentukan secara transparan oleh pihak
                            yang berwenang.</p>
                    </div>
                </article>
                <article class="principle"><span>✓</span>
                    <div><strong>Tidak Menjanjikan Hasil Individu</strong>
                        <p>Program membantu meningkatkan pengetahuan dan kesiapan, tetapi tidak menjamin pekerjaan,
                            pembiayaan, omzet, atau hasil tertentu.</p>
                    </div>
                </article>
                <article class="principle"><span>✓</span>
                    <div><strong>Persetujuan Data dan Dokumentasi</strong>
                        <p>Penggunaan data, foto, video, testimoni, dan publikasi mengikuti persetujuan serta kebijakan para
                            pihak.</p>
                    </div>
                </article>
                <article class="principle"><span>✓</span>
                    <div><strong>Materi Harus Sah Digunakan</strong>
                        <p>Logo, foto, data, modul, dan aset yang diberikan oleh mitra harus memiliki izin penggunaan yang
                            memadai.</p>
                    </div>
                </article>
                <article class="principle"><span>✓</span>
                    <div><strong>Perubahan Ruang Lingkup Dikendalikan</strong>
                        <p>Perubahan peserta, lokasi, jadwal, materi, output, atau kebutuhan tambahan perlu disepakati
                            sebelum dilaksanakan.</p>
                    </div>
                </article>
                <article class="principle"><span>✓</span>
                    <div><strong>Pelaporan Berdasarkan Data Tersedia</strong>
                        <p>Kesimpulan program disusun berdasarkan instrumen, kehadiran, evaluasi, dan bukti yang berhasil
                            dikumpulkan.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-soft" id="faq">
        <div class="container">@include('frontend.components.section-head', [
            'eyebrow' => 'Pertanyaan Umum',
            'title' => 'Informasi Awal Program CSR',
            'description' =>
                'Jawaban berikut memberikan gambaran umum sebelum sasaran, model kolaborasi, biaya, lokasi, dan ruang lingkup program dianalisis.',
        ])<div class="faq-wrap">
                <article class="faq-item"><button class="faq-q" type="button">Siapa yang dapat menjadi mitra Program
                        CSR?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Bank, BPR/BPRS, perusahaan, yayasan, asosiasi, lembaga pendidikan, pemerintah
                        daerah, dan institusi lain dapat berkolaborasi sesuai tujuan serta kebijakan masing-masing.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Apakah program dapat menggunakan
                        identitas mitra?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Dapat. Penggunaan logo, nama program, pesan, atribut, materi publikasi, dan
                        dokumentasi mengikuti pedoman merek serta persetujuan tertulis para pihak.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Apakah program harus dilaksanakan secara
                        tatap muka?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Tidak. Program dapat dilaksanakan secara luring, daring, atau blended sesuai profil
                        peserta, lokasi, akses teknologi, tujuan, dan anggaran.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Bagaimana penerima manfaat
                        ditentukan?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Kriteria ditetapkan bersama, misalnya wilayah, sekolah, jenjang, status usaha,
                        kebutuhan, prestasi, atau kondisi tertentu. Keputusan akhir berada pada pihak yang berwenang.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Apakah tersedia laporan setelah program
                        selesai?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Ya, sesuai ruang lingkup. Laporan dapat berisi profil program, peserta, aktivitas,
                        dokumentasi, hasil evaluasi, kendala, dan rekomendasi.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Informasi apa yang diperlukan untuk
                        menyusun proposal?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Sampaikan tujuan CSR, sasaran penerima manfaat, lokasi, jumlah peserta, topik,
                        durasi, jadwal, model pelaksanaan, anggaran, kebutuhan branding, dokumentasi, dan format laporan.
                    </div>
                </article>
            </div>
        </div>
    </section>
    <section class="final-cta" id="konsultasi">
        <div class="container">
            <div class="cta-box">
                <div>
                    <h2>Bangun Program CSR yang Relevan bagi Penerima Manfaat</h2>
                    <p>Sampaikan tujuan, sasaran, lokasi, jumlah peserta, topik, jadwal, anggaran, dan kebutuhan pelaporan.
                        Tim Bankir Academy akan membantu menyusun gambaran program awal.</p>
                </div>
                <div class="cta-actions"><a class="btn btn-light"
                        href="mailto:info@bankiracademy.co.id?subject=Konsultasi%20Program%20CSR">Email Konsultasi</a><a
                        class="btn btn-secondary" href="#fokus-program">Lihat Fokus Program</a></div>
            </div>
        </div>
    </section>
@endsection
