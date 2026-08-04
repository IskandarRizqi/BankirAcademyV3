@extends('layouts.appfrontend')

@section('page-title')
    Bakti Pendidikan — Bankir Academy
@endsection

@section('page-description')
    Bakti Pendidikan Bankir Academy merupakan program kolaborasi pendidikan untuk meningkatkan literasi keuangan, pemahaman
    industri perbankan, kesiapan karier, dan akses pembelajaran bagi pelajar, mahasiswa, serta calon bankir.
@endsection

@section('content')
    <section class="hero solution-hero" id="ringkasan">
        <div class="container hero-grid">
            <div>
                <span class="eyebrow">Bankir Academy Foundations</span>
                <h1>Membuka Akses Pendidikan untuk <span class="gradient-text">Generasi yang Lebih Siap</span></h1>
                <p class="hero-lead">Bakti Pendidikan adalah program kolaborasi Bankir Academy bersama bank, BPR/BPRS,
                    perusahaan, sekolah, kampus, yayasan, dan komunitas untuk memperluas akses pembelajaran. Program
                    difokuskan pada literasi keuangan, pengenalan industri perbankan, kesiapan karier, keterampilan digital,
                    serta pembentukan kebiasaan belajar yang bertanggung jawab.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="#program">Jelajahi Program <span class="icon-arrow">→</span></a>
                    <a class="btn btn-outline" href="#konsultasi">Ajukan Kolaborasi</a>
                </div>
                <div class="hero-proof">
                    <span class="proof-item"><span class="proof-icon">✓</span>Sasaran peserta terdefinisi</span>
                    <span class="proof-item"><span class="proof-icon">✓</span>Materi sesuai jenjang</span>
                    <span class="proof-item"><span class="proof-icon">✓</span>Evaluasi dan laporan tersedia</span>
                </div>
            </div>
            <div aria-label="Ilustrasi Bakti Pendidikan Bankir Academy" class="hero-visual">
                <div class="visual-main">
                    <div class="dashboard">
                        <div class="dash-top">
                            <div class="dash-brand"><svg aria-hidden="true" height="31" width="31">
                                    <use href="#logo-ba"></use>
                                </svg>EDUCATION IMPACT HUB</div>
                            <div class="dash-dots"><span></span><span></span><span></span></div>
                        </div>
                        <div class="dash-hero">
                            <div class="dash-label">Inclusive Learning Program</div>
                            <h3>Learn. Prepare. Grow. Contribute.</h3>
                            <p>Satu kerangka kolaborasi untuk memberi akses belajar, membangun kesiapan, dan
                                mendokumentasikan hasil program pendidikan.</p>
                            <div class="dash-stats">
                                <div class="dash-stat"><strong>Inclusive</strong><span>Akses belajar lebih luas</span></div>
                                <div class="dash-stat"><strong>Practical</strong><span>Materi dekat dengan kebutuhan</span>
                                </div>
                                <div class="dash-stat"><strong>Measurable</strong><span>Capaian dapat ditinjau</span></div>
                            </div>
                        </div>
                        <div class="dash-grid">
                            <div class="dash-card">
                                <h4>Learning Journey</h4>
                                <div class="progress"><span class="width-82"></span></div>
                                <div class="mini-list mini-list-spaced">
                                    <div class="mini-row"><i></i><span>Pemetaan peserta</span></div>
                                    <div class="mini-row"><i class="dot-accent"></i><span>Pembelajaran dan praktik</span>
                                    </div>
                                    <div class="mini-row"><i class="dot-primary"></i><span>Evaluasi dan tindak lanjut</span>
                                    </div>
                                </div>
                            </div>
                            <div class="dash-card">
                                <h4>Program Area</h4>
                                <div class="mini-list">
                                    <div class="mini-row"><i></i><span>Literasi keuangan</span></div>
                                    <div class="mini-row"><i class="dot-primary"></i><span>Karier perbankan</span></div>
                                    <div class="mini-row"><i class="dot-accent"></i><span>Keterampilan digital</span></div>
                                    <div class="mini-row"><i class="dot-danger"></i><span>Beasiswa belajar</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="float-card one"><span class="float-icon">🎓</span><span><strong>Career
                            Ready</strong><small>Persiapan studi dan kerja</small></span></div>
                <div class="float-card two"><span class="float-icon">◎</span><span><strong>Financial
                            Literacy</strong><small>Kebiasaan finansial sehat</small></span></div>
                <div class="float-card three"><span class="float-icon">▦</span><span><strong>Education
                            Report</strong><small>Data, evaluasi, dokumentasi</small></span></div>
            </div>
        </div>
    </section>
    <div class="trust-strip">
        <div class="container trust-inner">
            <div class="trust-copy"><strong>Program pendidikan untuk berbagai jenjang dan kebutuhan</strong><span>Ruang
                    lingkup dapat disesuaikan berdasarkan usia, latar belakang, lokasi, akses teknologi, tujuan mitra, dan
                    kesiapan lembaga pendidikan.</span></div>
            <div class="trust-item"><span class="trust-mark">S</span>SMA/SMK</div>
            <div class="trust-item"><span class="trust-mark">M</span>Mahasiswa</div>
            <div class="trust-item"><span class="trust-mark">F</span>Fresh Graduate</div>
            <div class="trust-item"><span class="trust-mark">G</span>Guru &amp; Pendamping</div>
        </div>
    </div>
    <section class="section" id="kebutuhan">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Mengapa Bakti Pendidikan',
                'title' => 'Akses Belajar Perlu Diikuti Materi yang Relevan dan Pendampingan yang Tepat',
                'description' =>
                    'Program pendidikan yang baik tidak berhenti pada pembagian materi. Peserta perlu memahami manfaat pembelajaran, memperoleh pengalaman yang sesuai jenjang, serta memiliki arah tindak lanjut setelah kegiatan selesai.',
            ])
            <div class="challenge-grid">
                <article class="challenge-card"><span class="challenge-no">01</span>
                    <h3>Literasi Industri Terbatas</h3>
                    <p>Pelajar dan mahasiswa sering mengenal bank hanya dari produk, tanpa memahami profesi, proses kerja,
                        risiko, etika, dan kontribusinya bagi masyarakat.</p>
                </article>
                <article class="challenge-card"><span class="challenge-no">02</span>
                    <h3>Kesiapan Karier Belum Merata</h3>
                    <p>Peserta membutuhkan panduan praktis terkait CV, wawancara, komunikasi, sikap kerja, keterampilan
                        digital, dan ekspektasi dunia profesional.</p>
                </article>
                <article class="challenge-card"><span class="challenge-no">03</span>
                    <h3>Akses Materi Berkualitas</h3>
                    <p>Tidak semua sekolah, kampus, atau komunitas memiliki akses yang sama terhadap fasilitator, materi
                        terkini, media digital, dan praktik pembelajaran.</p>
                </article>
                <article class="challenge-card"><span class="challenge-no">04</span>
                    <h3>Dampak Sulit Dibuktikan</h3>
                    <p>Kegiatan sering hanya mencatat jumlah peserta tanpa asesmen, umpan balik, dokumentasi, atau
                        rekomendasi untuk pengembangan berikutnya.</p>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-soft" id="program">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Ruang Lingkup Program',
                'title' => 'Pilihan Program yang Dapat Disesuaikan dengan Profil Peserta',
                'description' =>
                    'Topik dapat diberikan sebagai satu kelas, seri pembelajaran, program semester, bootcamp, atau kegiatan kolaboratif dengan kurikulum dan indikator yang disepakati.',
            ])
            <div class="service-grid">
                <article class="solution-card">
                    <div class="solution-icon">◎</div>
                    <h3>Literasi Keuangan</h3>
                    <p>Pengenalan pengelolaan uang, tabungan, kredit, risiko penipuan, produk keuangan, dan pengambilan
                        keputusan finansial yang bertanggung jawab.</p>
                    <ul>
                        <li>Anggaran dan tujuan keuangan</li>
                        <li>Pengenalan produk serta layanan</li>
                        <li>Keamanan transaksi digital</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="solution-icon">▦</div>
                    <h3>Inside the Bank</h3>
                    <p>Pengenalan industri perbankan, fungsi bank, struktur organisasi, profesi, proses layanan, risiko,
                        kepatuhan, dan etika dasar.</p>
                    <ul>
                        <li>Gambaran operasional bank</li>
                        <li>Profesi dan jalur karier</li>
                        <li>Simulasi proses sederhana</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="solution-icon">↗</div>
                    <h3>Career Ready</h3>
                    <p>Pembekalan kesiapan studi dan kerja bagi siswa, mahasiswa, serta fresh graduate agar mampu
                        mempersiapkan diri secara lebih terarah.</p>
                    <ul>
                        <li>CV dan surat lamaran</li>
                        <li>Wawancara dan komunikasi</li>
                        <li>Etika serta 90 hari pertama</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="solution-icon">✦</div>
                    <h3>Digital Learning Skills</h3>
                    <p>Penguatan kemampuan belajar mandiri, komunikasi digital, pemanfaatan teknologi, pengelolaan
                        informasi, dan penggunaan AI secara bertanggung jawab.</p>
                    <ul>
                        <li>Produktivitas digital</li>
                        <li>Literasi data dan informasi</li>
                        <li>Responsible use of AI</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="solution-icon">◇</div>
                    <h3>Teacher &amp; Mentor Support</h3>
                    <p>Program bagi guru, dosen, wali kelas, pembina, dan mentor untuk mendukung proses pembelajaran,
                        pendampingan karier, serta pemantauan peserta.</p>
                    <ul>
                        <li>Facilitator toolkit</li>
                        <li>Panduan mentoring</li>
                        <li>Monitoring perkembangan</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="solution-icon">♡</div>
                    <h3>Scholarship Learning Program</h3>
                    <p>Akses kelas, e-book, video, asesmen, mentoring, atau sertifikasi bagi peserta yang ditetapkan
                        berdasarkan kriteria dan dukungan mitra.</p>
                    <ul>
                        <li>Kriteria penerima jelas</li>
                        <li>Akses pembelajaran terukur</li>
                        <li>Laporan partisipasi peserta</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>
    <section class="section" id="model-kolaborasi">
        <div class="container method-wrap">
            <div class="method-copy"><span class="eyebrow">Model Kolaborasi</span>
                <h2>Peran Mitra dan Bankir Academy Ditetapkan Sejak Awal</h2>
                <p>Kolaborasi yang tertata membantu memastikan peserta yang tepat, materi yang relevan, jadwal yang
                    realistis, dokumentasi yang sah, dan pelaporan yang dapat dipertanggungjawabkan.</p>
                <div class="feature-points">
                    <div class="feature-point"><span class="point-icon">1</span><span><strong>Mitra
                                Program</strong><span>Menetapkan tujuan, dukungan pendanaan, sasaran wilayah, kebijakan
                                merek, dan kebutuhan laporan.</span></span></div>
                    <div class="feature-point"><span class="point-icon">2</span><span><strong>Bankir
                                Academy</strong><span>Menyusun desain program, materi, fasilitator, sistem pembelajaran,
                                evaluasi, dokumentasi, dan laporan.</span></span></div>
                    <div class="feature-point"><span class="point-icon">3</span><span><strong>Sekolah atau
                                Kampus</strong><span>Menetapkan peserta, mendukung jadwal, menyediakan pendamping, sarana,
                                dan komunikasi kepada orang tua bila diperlukan.</span></span></div>
                    <div class="feature-point"><span
                            class="point-icon">4</span><span><strong>Peserta</strong><span>Mengikuti kegiatan,
                                menyelesaikan tugas atau asesmen, menjaga etika, dan memberikan umpan balik secara
                                jujur.</span></span></div>
                </div>
            </div>
            <div class="method-panel">
                <div class="method-title"><span>Education Partnership</span><strong>Shared Responsibility</strong></div>
                <div class="method-flow">
                    <div class="method-step"><b>01</b><span><strong>Purpose</strong><small>Tujuan sosial dan
                                pendidikan</small></span></div>
                    <div class="method-step"><b>02</b><span><strong>Participants</strong><small>Sasaran dan kriteria
                                peserta</small></span></div>
                    <div class="method-step"><b>03</b><span><strong>Learning</strong><small>Materi, metode,
                                fasilitator</small></span></div>
                    <div class="method-step"><b>04</b><span><strong>Evidence</strong><small>Evaluasi dan
                                dokumentasi</small></span></div>
                </div>
                <div class="method-note">Rincian peran, biaya, fasilitas, penggunaan logo, pengelolaan data, dokumentasi,
                    dan publikasi dituangkan dalam proposal atau perjanjian.</div>
            </div>
        </div>
    </section>
    <section class="section section-soft" id="tahapan">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Tahapan Pelaksanaan',
                'title' => 'Dari Pemetaan Kebutuhan hingga Rekomendasi Lanjutan',
                'description' =>
                    'Tahapan dapat disederhanakan untuk kelas tunggal atau diperluas untuk program multi-sesi, multi-sekolah, beasiswa pembelajaran, dan program lintas wilayah.',
            ])
            <div class="process-grid">
                <article class="process-card"><span>01</span>
                    <h3>Need Assessment</h3>
                    <p>Memahami tujuan mitra, profil peserta, jenjang, lokasi, tantangan, akses teknologi, serta kebutuhan
                        sekolah atau kampus.</p>
                </article>
                <article class="process-card"><span>02</span>
                    <h3>Program Design</h3>
                    <p>Menetapkan topik, hasil belajar, metode, jadwal, fasilitator, media, indikator, dokumentasi, dan
                        pembagian peran.</p>
                </article>
                <article class="process-card"><span>03</span>
                    <h3>Participant Preparation</h3>
                    <p>Registrasi, validasi peserta, komunikasi teknis, persetujuan data, asesmen awal, serta kesiapan
                        sarana pembelajaran.</p>
                </article>
                <article class="process-card"><span>04</span>
                    <h3>Learning Delivery</h3>
                    <p>Pelaksanaan kelas, simulasi, studi kasus, tugas, mentoring, kunjungan, atau pembelajaran digital
                        sesuai desain program.</p>
                </article>
                <article class="process-card"><span>05</span>
                    <h3>Evaluation</h3>
                    <p>Pengukuran kehadiran, keterlibatan, pemahaman, penyelesaian tugas, umpan balik, dan capaian yang
                        relevan.</p>
                </article>
                <article class="process-card"><span>06</span>
                    <h3>Report &amp; Follow-up</h3>
                    <p>Penyusunan dokumentasi, laporan hasil, pembelajaran program, rekomendasi, dan opsi pengembangan
                        berikutnya.</p>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-dark" id="pengukuran">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Education Impact',
                'title' => 'Keberhasilan Program Dilihat dari Proses dan Perubahan yang Relevan',
                'description' =>
                    'Indikator dipilih secara proporsional berdasarkan durasi, usia peserta, tujuan program, instrumen yang tersedia, dan kemampuan pengumpulan data.',
            ])
            <div class="impact-grid">
                <article class="impact-card"><span>01</span>
                    <div><strong>Reach</strong>
                        <p>Jumlah peserta, sekolah, kampus, wilayah, kelompok sasaran, dan tingkat kehadiran.</p>
                    </div>
                </article>
                <article class="impact-card"><span>02</span>
                    <div><strong>Engagement</strong>
                        <p>Partisipasi, penyelesaian aktivitas, keterlibatan diskusi, tugas, dan penggunaan materi.</p>
                    </div>
                </article>
                <article class="impact-card"><span>03</span>
                    <div><strong>Learning Gain</strong>
                        <p>Perubahan pemahaman berdasarkan pre-test, post-test, kuis, tugas, atau observasi fasilitator.</p>
                    </div>
                </article>
                <article class="impact-card"><span>04</span>
                    <div><strong>Readiness</strong>
                        <p>Peningkatan kesiapan menyusun rencana belajar, karier, pengelolaan keuangan, atau tindakan
                            praktis.</p>
                    </div>
                </article>
                <article class="impact-card"><span>05</span>
                    <div><strong>Experience</strong>
                        <p>Umpan balik peserta, guru, pendamping, mitra, fasilitator, serta catatan kendala pelaksanaan.</p>
                    </div>
                </article>
                <article class="impact-card"><span>06</span>
                    <div><strong>Continuation</strong>
                        <p>Rekomendasi penguatan, pembelajaran lanjutan, mentoring, komunitas alumni, atau pengembangan
                            program.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>
    <section class="section" id="model-program">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Format Program',
                'title' => 'Pilih Skala Program Sesuai Tujuan dan Jangkauan',
                'description' =>
                    'Format berikut merupakan gambaran awal. Nama, durasi, jumlah peserta, lokasi, media, pendanaan, dan output dapat disesuaikan dalam proposal.',
            ])
            <div class="cards-3">
                <article class="service-card">
                    <div class="card-icon">◎</div><span class="tag tag-spaced">Single Activity</span>
                    <h3>Education Class</h3>
                    <p>Kelas, seminar, webinar, atau kunjungan edukatif untuk satu topik dan kelompok peserta tertentu.</p>
                    <ul class="card-list">
                        <li>Materi sesuai jenjang</li>
                        <li>Fasilitator dan media belajar</li>
                        <li>Dokumentasi dasar</li>
                    </ul>
                </article>
                <article class="service-card">
                    <div class="card-icon">↗</div><span class="tag tag-spaced">Learning Series</span>
                    <h3>Career &amp; Financial Bootcamp</h3>
                    <p>Rangkaian pembelajaran, praktik, tugas, dan mentoring untuk membangun kesiapan peserta secara
                        bertahap.</p>
                    <ul class="card-list">
                        <li>Kurikulum beberapa sesi</li>
                        <li>Asesmen dan action plan</li>
                        <li>Laporan perkembangan</li>
                    </ul>
                </article>
                <article class="service-card">
                    <div class="card-icon">♡</div><span class="tag tag-spaced">Access Program</span>
                    <h3>Education Scholarship</h3>
                    <p>Dukungan akses belajar bagi peserta terpilih melalui kelas, LMS, e-book, video, mentoring, atau
                        sertifikasi.</p>
                    <ul class="card-list">
                        <li>Kriteria peserta transparan</li>
                        <li>Akses dan progres tercatat</li>
                        <li>Laporan pemanfaatan program</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-soft" id="output">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Output Program',
                'title' => 'Dokumen, Materi, dan Bukti Pelaksanaan yang Lebih Tertata',
                'description' =>
                    'Output aktual mengikuti ruang lingkup, durasi, model pembelajaran, persetujuan dokumentasi, dan kebutuhan laporan mitra.',
            ])
            <div class="principle-grid">
                <article class="principle"><span>01</span>
                    <div><strong>Program Framework</strong>
                        <p>Tujuan, sasaran, hasil belajar, topik, metode, jadwal, indikator, peran, dan kebutuhan sumber
                            daya.</p>
                    </div>
                </article>
                <article class="principle"><span>02</span>
                    <div><strong>Learning Materials</strong>
                        <p>Presentasi, modul, e-book, video, lembar kerja, kuis, studi kasus, dan panduan pendamping.</p>
                    </div>
                </article>
                <article class="principle"><span>03</span>
                    <div><strong>Participant Records</strong>
                        <p>Data peserta, registrasi, kehadiran, status pembelajaran, hasil tugas, dan penyelesaian program.
                        </p>
                    </div>
                </article>
                <article class="principle"><span>04</span>
                    <div><strong>Activity Documentation</strong>
                        <p>Foto, video, catatan kegiatan, testimoni, dan bukti lain sesuai izin serta kebijakan publikasi.
                        </p>
                    </div>
                </article>
                <article class="principle"><span>05</span>
                    <div><strong>Evaluation Summary</strong>
                        <p>Ringkasan asesmen, keterlibatan, capaian, umpan balik, kendala, dan pembelajaran program.</p>
                    </div>
                </article>
                <article class="principle"><span>06</span>
                    <div><strong>Education Impact Report</strong>
                        <p>Laporan pelaksanaan, kesimpulan, penggunaan dukungan, dan rekomendasi tindak lanjut.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>
    <section class="section" id="ketentuan">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Prinsip &amp; Ketentuan',
                'title' => 'Perlindungan Peserta dan Tata Kelola Program Menjadi Prioritas',
                'description' =>
                    'Program yang melibatkan peserta usia sekolah memerlukan perhatian khusus pada persetujuan, keamanan, data pribadi, dokumentasi, komunikasi, dan pendampingan.',
            ])
            <div class="principle-grid">
                <article class="principle"><span>✓</span>
                    <div><strong>Kriteria Peserta Transparan</strong>
                        <p>Jenjang, wilayah, kebutuhan, prestasi, kondisi ekonomi, atau kriteria lain ditetapkan oleh pihak
                            yang berwenang.</p>
                    </div>
                </article>
                <article class="principle"><span>✓</span>
                    <div><strong>Perlindungan Anak dan Peserta</strong>
                        <p>Kegiatan, komunikasi, pendampingan, lokasi, dan interaksi digital harus memperhatikan keamanan
                            serta kebijakan lembaga pendidikan.</p>
                    </div>
                </article>
                <article class="principle"><span>✓</span>
                    <div><strong>Persetujuan Data dan Dokumentasi</strong>
                        <p>Pengumpulan serta penggunaan data, foto, video, karya, dan testimoni mengikuti persetujuan yang
                            sesuai.</p>
                    </div>
                </article>
                <article class="principle"><span>✓</span>
                    <div><strong>Materi Edukatif dan Proporsional</strong>
                        <p>Materi disesuaikan dengan usia dan tidak digunakan untuk menjanjikan pekerjaan, pembiayaan,
                            keuntungan, atau hasil individu tertentu.</p>
                    </div>
                </article>
                <article class="principle"><span>✓</span>
                    <div><strong>Branding Tidak Mendominasi</strong>
                        <p>Identitas mitra dapat digunakan sesuai kesepakatan, tetapi tujuan pendidikan dan kepentingan
                            peserta tetap menjadi fokus utama.</p>
                    </div>
                </article>
                <article class="principle"><span>✓</span>
                    <div><strong>Pelaporan Berdasarkan Bukti</strong>
                        <p>Kesimpulan disusun dari data kehadiran, asesmen, aktivitas, dokumentasi, dan umpan balik yang
                            berhasil dikumpulkan.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-soft" id="faq">
        <div class="container">@include('frontend.components.section-head', [
            'eyebrow' => 'Pertanyaan Umum',
            'title' => 'Informasi Awal Bakti Pendidikan',
            'description' =>
                'Ruang lingkup final ditentukan setelah tujuan, sasaran, lokasi, jumlah peserta, jadwal, anggaran, fasilitas, dan kebutuhan laporan dibahas bersama.',
        ])<div class="faq-wrap">
                <article class="faq-item"><button class="faq-q" type="button">Siapa yang dapat menjadi mitra Bakti
                        Pendidikan?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Bank, BPR/BPRS, perusahaan, yayasan, asosiasi, sekolah, kampus, pemerintah daerah,
                        komunitas, dan lembaga lain dapat berkolaborasi sesuai tujuan serta kebijakan masing-masing.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Siapa yang dapat menjadi peserta?<span
                            class="faq-plus">＋</span></button>
                    <div class="faq-a">Peserta dapat berupa siswa SMA/SMK, mahasiswa, fresh graduate, calon bankir, guru,
                        dosen, pendamping, atau kelompok lain yang ditetapkan dalam desain program.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Apakah program dapat dilaksanakan gratis
                        bagi peserta?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Dapat. Biaya program dapat didukung penuh atau sebagian oleh mitra. Mekanisme,
                        kuota, kriteria peserta, fasilitas, dan batas dukungan harus dijelaskan secara terbuka.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Apakah tersedia kelas daring dan
                        LMS?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Ya. Program dapat dijalankan secara luring, daring, atau blended, serta dapat
                        menggunakan LMS, video, e-book, kuis, tugas, dan dashboard pembelajaran sesuai kebutuhan.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Apakah peserta memperoleh
                        sertifikat?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Sertifikat dapat diberikan bila termasuk dalam ruang lingkup dan peserta memenuhi
                        ketentuan, seperti kehadiran, penyelesaian tugas, asesmen, atau standar kelulusan yang ditetapkan.
                    </div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Informasi apa yang diperlukan untuk
                        menyusun proposal?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Sampaikan tujuan program, profil peserta, lokasi, jumlah, topik, durasi, jadwal,
                        model pembelajaran, anggaran, kebutuhan branding, dokumentasi, fasilitas, dan format laporan.</div>
                </article>
            </div>
        </div>
    </section>
    <section class="final-cta" id="konsultasi">
        <div class="container">
            <div class="cta-box">
                <div>
                    <h2>Bangun Akses Pendidikan yang Relevan dan Berkelanjutan</h2>
                    <p>Sampaikan tujuan, sasaran peserta, wilayah, topik, jumlah peserta, jadwal, anggaran, dan bentuk
                        dukungan. Tim Bankir Academy akan membantu menyusun rancangan program awal.</p>
                </div>
                <div class="cta-actions"><a class="btn btn-light"
                        href="mailto:info@bankiracademy.co.id?subject=Konsultasi%20Bakti%20Pendidikan">Email
                        Konsultasi</a><a class="btn btn-secondary" href="#program">Lihat Program</a></div>
            </div>
        </div>
    </section>
@endsection
