@extends('layouts.appfrontend')

@section('page-title')
    Job Connect — Bankir Academy
@endsection

@section('page-description')
    Job Connect Bankir Academy menghubungkan kandidat dengan peluang kerja yang relevan melalui publikasi lowongan, profil
    kandidat, pencocokan awal, edukasi karier, dan proses komunikasi yang transparan tanpa menjanjikan hasil penerimaan.
@endsection

@section('content')
    <section class="hero solution-hero talent-hero" id="beranda">
        <div class="container hero-grid">
            <div>
                <span class="eyebrow">Talent Solutions · Job Connect</span>
                <h1>Menghubungkan Talenta dengan <span class="gradient-text">Peluang Kerja yang Relevan</span></h1>
                <p class="hero-lead">Job Connect adalah kanal penghubung antara kandidat dan organisasi yang memiliki
                    kebutuhan tenaga kerja. Layanan ini membantu publikasi peluang, pengelolaan profil, pencocokan awal,
                    serta komunikasi proses secara lebih terstruktur—tanpa menggantikan kewenangan seleksi dan keputusan
                    akhir perusahaan.</p>
                <div class="hero-actions"><a class="btn btn-primary" href="#alur">Pelajari Cara Kerja <span
                            class="icon-arrow">→</span></a><a class="btn btn-outline" href="#konsultasi">Publikasikan
                        Lowongan</a></div>
                <div class="hero-proof"><span class="proof-item"><span class="proof-icon">✓</span>Lowongan dan kriteria
                        terverifikasi</span><span class="proof-item"><span class="proof-icon">✓</span>Proses transparan bagi
                        kandidat</span><span class="proof-item"><span class="proof-icon">✓</span>Keputusan tetap pada
                        perusahaan</span></div>
            </div>
            <div aria-label="Ilustrasi platform Job Connect" class="hero-visual">
                <div class="visual-main">
                    <div class="talent-board">
                        <div class="talent-top">
                            <div class="dash-brand"><svg aria-hidden="true" height="31" width="31">
                                    <use href="#logo-ba"></use>
                                </svg> JOB CONNECT</div><span class="screen-pill">Opportunity Matching</span>
                        </div>
                        <div class="talent-profile">
                            <div class="talent-avatar">⇄</div>
                            <div>
                                <h3>Career Opportunity Hub</h3>
                                <p>Vacancy · profile · matching · application status</p>
                            </div>
                        </div>
                        <div class="score-grid">
                            <div class="score-card"><strong>Role Fit</strong><span>Kesesuaian dasar profil</span>
                                <div class="score-line"><i class="width-84"></i></div>
                            </div>
                            <div class="score-card"><strong>Verified Vacancy</strong><span>Informasi kebutuhan
                                    terstruktur</span>
                                <div class="score-line"><i class="width-92"></i></div>
                            </div>
                        </div>
                        <div class="talent-list">
                            <div class="talent-row"><span class="talent-dot">1</span>
                                <div><strong>Discover</strong><small>Temukan peluang sesuai minat</small></div><b>Open</b>
                            </div>
                            <div class="talent-row"><span class="talent-dot">2</span>
                                <div><strong>Apply</strong><small>Kirim profil dan dokumen</small></div><b>Simple</b>
                            </div>
                            <div class="talent-row"><span class="talent-dot">3</span>
                                <div><strong>Connect</strong><small>Ikuti proses perusahaan</small></div><b>Direct</b>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="float-card one"><span class="float-icon">⌕</span><span><strong>Opportunity
                            Discovery</strong><small>Peluang berdasarkan kategori</small></span></div>
                <div class="float-card two"><span class="float-icon">✓</span><span><strong>Transparent
                            Process</strong><small>Status dan informasi jelas</small></span></div>
            </div>
        </div>
    </section>
    <div class="trust-strip">
        <div class="container trust-inner">
            <div class="trust-copy"><strong>Untuk kandidat dan organisasi</strong><span>Mempermudah akses peluang tanpa
                    menjanjikan penerimaan atau penempatan.</span></div>
            <div class="trust-item"><span class="trust-mark">F</span>Fresh Graduate</div>
            <div class="trust-item"><span class="trust-mark">P</span>Profesional</div>
            <div class="trust-item"><span class="trust-mark">B</span>Bank &amp; BPR/BPRS</div>
            <div class="trust-item"><span class="trust-mark">H</span>Human Capital</div>
        </div>
    </div>
    <section class="section" id="kebutuhan">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Mengapa Job Connect',
                'title' => 'Akses Peluang yang Lebih Terarah dan Proses yang Lebih Jelas',
                'description' =>
                    'Kandidat sering kesulitan menemukan lowongan yang relevan dan memahami kebutuhan industri. Di sisi lain, perusahaan memerlukan kanal untuk menjangkau kandidat yang sesuai serta menyampaikan informasi proses secara bertanggung jawab.',
            ])
            <div class="audience-grid">
                <article class="audience-card"><i>1</i>
                    <h3>Informasi Tersebar</h3>
                    <p>Peluang kerja tersebar di berbagai kanal sehingga kandidat sulit membandingkan posisi, persyaratan,
                        lokasi, dan tahapan proses.</p>
                </article>
                <article class="audience-card"><i>2</i>
                    <h3>Profil Belum Terarah</h3>
                    <p>Kandidat memerlukan panduan untuk menyusun profil, CV, dokumen, dan preferensi karier yang relevan
                        dengan posisi.</p>
                </article>
                <article class="audience-card"><i>3</i>
                    <h3>Jangkauan Kandidat Terbatas</h3>
                    <p>Perusahaan membutuhkan kanal tambahan untuk menjangkau mahasiswa, fresh graduate, profesional, dan
                        talent pool sektoral.</p>
                </article>
                <article class="audience-card"><i>4</i>
                    <h3>Ekspektasi Tidak Selaras</h3>
                    <p>Deskripsi posisi, kriteria, proses, dan batas layanan perlu disampaikan secara jelas agar tidak
                        menimbulkan janji yang keliru.</p>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-soft" id="layanan">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Ruang Lingkup Job Connect',
                'title' => 'Kanal Peluang Kerja dengan Dukungan Informasi dan Pencocokan Awal',
                'description' =>
                    'Setiap komponen dapat disesuaikan berdasarkan jenis posisi, target kandidat, tingkat pengalaman, lokasi, jadwal, dan mekanisme seleksi perusahaan.',
            ])
            <div class="solution-grid">
                <article class="solution-card">
                    <div class="card-icon">▤</div>
                    <h3>Vacancy Publication</h3>
                    <p>Menyajikan informasi lowongan secara terstruktur, mudah dipahami, dan sesuai data resmi dari
                        perusahaan.</p>
                    <ul>
                        <li>Nama dan ringkasan posisi</li>
                        <li>Kriteria, lokasi, dan batas waktu</li>
                        <li>Tahapan serta kanal aplikasi</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">◇</div>
                    <h3>Candidate Profile</h3>
                    <p>Membantu kandidat menyiapkan profil dasar yang dapat digunakan untuk menelusuri dan melamar peluang
                        relevan.</p>
                    <ul>
                        <li>Data pendidikan dan pengalaman</li>
                        <li>Kompetensi serta minat karier</li>
                        <li>CV dan dokumen pendukung</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">⇄</div>
                    <h3>Initial Matching</h3>
                    <p>Mencocokkan parameter dasar kandidat dengan kriteria lowongan sebagai alat bantu penyaringan awal.
                    </p>
                    <ul>
                        <li>Level pendidikan dan pengalaman</li>
                        <li>Lokasi serta preferensi kerja</li>
                        <li>Kesesuaian kompetensi dasar</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">⌕</div>
                    <h3>Application Routing</h3>
                    <p>Mengarahkan aplikasi dan dokumen kandidat melalui mekanisme yang disetujui perusahaan.</p>
                    <ul>
                        <li>Formulir atau tautan aplikasi</li>
                        <li>Daftar kandidat yang mendaftar</li>
                        <li>Koordinasi administrasi awal</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">↗</div>
                    <h3>Career Readiness</h3>
                    <p>Menyediakan materi persiapan karier agar kandidat memahami etika, dokumen, dan proses seleksi.</p>
                    <ul>
                        <li>CV dan profil profesional</li>
                        <li>Persiapan wawancara</li>
                        <li>Etika komunikasi rekrutmen</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">◎</div>
                    <h3>Employer Connection</h3>
                    <p>Mendukung kegiatan pengenalan perusahaan, talent day, career talk, atau sesi informasi posisi.</p>
                    <ul>
                        <li>Employer branding yang proporsional</li>
                        <li>Career webinar dan talent day</li>
                        <li>Talent pool engagement</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>
    <section class="section" id="alur">
        <div class="container method-wrap">
            <div class="method-panel"><span class="eyebrow">Structured Connection</span>
                <h3>Dua Jalur Layanan dalam Satu Ekosistem</h3>
                <p>Kandidat memperoleh akses informasi dan jalur aplikasi, sedangkan perusahaan memperoleh kanal publikasi
                    serta kandidat yang telah menyampaikan profil dasar. Seluruh tahapan seleksi lanjutan tetap mengikuti
                    kebijakan perusahaan.</p>
                <div class="method-stat-grid">
                    <div class="method-stat"><strong>For Candidates</strong><span>Discover, prepare, apply</span></div>
                    <div class="method-stat"><strong>For Employers</strong><span>Publish, review, connect</span></div>
                    <div class="method-stat"><strong>Verified Info</strong><span>Data lowongan terstruktur</span></div>
                    <div class="method-stat"><strong>No Guarantee</strong><span>Tanpa janji penerimaan</span></div>
                </div>
            </div>
            <div class="process-list">
                <article class="process-item"><span class="process-number">1</span>
                    <div>
                        <h3>Vacancy Intake</h3>
                        <p>Perusahaan menyampaikan profil posisi, kriteria, lokasi, jadwal, proses, PIC, dan ketentuan
                            publikasi.</p>
                    </div>
                </article>
                <article class="process-item"><span class="process-number">2</span>
                    <div>
                        <h3>Review &amp; Publication</h3>
                        <p>Informasi ditelaah dari sisi kelengkapan, kejelasan, dan konsistensi sebelum dipublikasikan.</p>
                    </div>
                </article>
                <article class="process-item"><span class="process-number">3</span>
                    <div>
                        <h3>Candidate Registration</h3>
                        <p>Kandidat membaca persyaratan, menyetujui ketentuan, lalu mengirim profil dan dokumen secara
                            mandiri.</p>
                    </div>
                </article>
                <article class="process-item"><span class="process-number">4</span>
                    <div>
                        <h3>Initial Screening or Routing</h3>
                        <p>Aplikasi diteruskan langsung atau disaring berdasarkan parameter awal sesuai kesepakatan layanan.
                        </p>
                    </div>
                </article>
                <article class="process-item"><span class="process-number">5</span>
                    <div>
                        <h3>Company Selection Process</h3>
                        <p>Perusahaan menjalankan tes, wawancara, verifikasi, keputusan, dan penawaran berdasarkan kebijakan
                            internal.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-soft" id="fitur">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Pengalaman Pengguna',
                'title' => 'Informasi yang Dibutuhkan Kandidat dan Perusahaan',
                'description' =>
                    'Tampilan dan fitur dapat dikembangkan bertahap sesuai kebutuhan operasional, integrasi, volume lowongan, serta kebijakan pengelolaan data.',
            ])
            <div class="package-grid">
                <article class="package-card">
                    <div class="card-icon">⌕</div>
                    <h3>Candidate Experience</h3>
                    <p>Alur sederhana untuk menemukan, memahami, dan melamar peluang.</p>
                    <ul>
                        <li>Pencarian berdasarkan kategori</li>
                        <li>Detail posisi yang jelas</li>
                        <li>Profil dan dokumen kandidat</li>
                        <li>Notifikasi atau status dasar</li>
                    </ul>
                </article>
                <article class="package-card featured">
                    <div class="card-icon card-icon-light">⇄</div>
                    <h3>Connected Hiring</h3>
                    <p>Penghubung antara kebutuhan perusahaan dan minat kandidat melalui data yang relevan.</p>
                    <ul>
                        <li>Form kebutuhan perusahaan</li>
                        <li>Daftar aplikasi terstruktur</li>
                        <li>Initial matching opsional</li>
                        <li>Koordinasi proses awal</li>
                    </ul>
                </article>
                <article class="package-card">
                    <div class="card-icon">▦</div>
                    <h3>Employer Support</h3>
                    <p>Dukungan publikasi dan keterlibatan kandidat sesuai ruang lingkup.</p>
                    <ul>
                        <li>Vacancy page dan campaign</li>
                        <li>Career event atau webinar</li>
                        <li>Talent pool outreach</li>
                        <li>Ringkasan aktivitas publikasi</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-dark" id="hasil">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Output Layanan',
                'title' => 'Informasi dan Rekap untuk Mendukung Proses Rekrutmen',
                'description' =>
                    'Output aktual mengikuti paket layanan, izin penggunaan data, jumlah lowongan, periode publikasi, dan mekanisme seleksi perusahaan.',
            ])
            <div class="deliverable-grid">
                <article class="deliverable"><i>▤</i>
                    <h3>Vacancy Profile</h3>
                    <p>Informasi posisi, persyaratan, lokasi, jadwal, tahapan, dan kanal aplikasi.</p>
                </article>
                <article class="deliverable"><i>◇</i>
                    <h3>Candidate Profile</h3>
                    <p>Data kandidat yang disampaikan secara sukarela sesuai formulir dan persetujuan.</p>
                </article>
                <article class="deliverable"><i>⇄</i>
                    <h3>Application List</h3>
                    <p>Daftar aplikasi dan status administrasi dasar sesuai ruang lingkup layanan.</p>
                </article>
                <article class="deliverable"><i>⌕</i>
                    <h3>Initial Match Summary</h3>
                    <p>Ringkasan kesesuaian parameter awal bila layanan penyaringan disepakati.</p>
                </article>
                <article class="deliverable"><i>↗</i>
                    <h3>Publication Report</h3>
                    <p>Rekap periode tayang, kanal, jangkauan, dan respons kandidat yang tersedia.</p>
                </article>
                <article class="deliverable"><i>✓</i>
                    <h3>Process Closure</h3>
                    <p>Penutupan publikasi, pengarsipan, pembaruan status, atau tindak lanjut talent pool.</p>
                </article>
            </div>
        </div>
    </section>
    <section class="section" id="ketentuan">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Prinsip &amp; Ketentuan',
                'title' => 'Transparansi, Privasi, dan Kesetaraan dalam Akses Peluang',
                'description' =>
                    'Job Connect berfungsi sebagai kanal informasi dan penghubung. Kandidat maupun perusahaan perlu memahami peran, penggunaan data, batas layanan, serta kewenangan keputusan masing-masing pihak.',
            ])
            <div class="principle-grid">
                <article class="principle"><span>01</span>
                    <div><strong>Informasi Resmi</strong>
                        <p>Lowongan dipublikasikan berdasarkan informasi yang diberikan atau disetujui perusahaan.</p>
                    </div>
                </article>
                <article class="principle"><span>02</span>
                    <div><strong>Tanpa Biaya Rekrutmen Tersembunyi</strong>
                        <p>Biaya kepada kandidat, bila ada untuk layanan terpisah, harus dijelaskan secara transparan dan
                            bukan syarat penerimaan.</p>
                    </div>
                </article>
                <article class="principle"><span>03</span>
                    <div><strong>Persetujuan Data</strong>
                        <p>Profil dan dokumen kandidat diproses sesuai persetujuan, tujuan, periode, dan akses yang
                            diinformasikan.</p>
                    </div>
                </article>
                <article class="principle"><span>04</span>
                    <div><strong>Kesetaraan Kesempatan</strong>
                        <p>Kriteria harus relevan dengan pekerjaan dan tidak boleh digunakan untuk diskriminasi yang
                            bertentangan dengan ketentuan.</p>
                    </div>
                </article>
                <article class="principle"><span>05</span>
                    <div><strong>Verifikasi oleh Perusahaan</strong>
                        <p>Keaslian dokumen, referensi, latar belakang, dan kelayakan kandidat tetap perlu diverifikasi
                            perusahaan.</p>
                    </div>
                </article>
                <article class="principle"><span>06</span>
                    <div><strong>Tidak Menjamin Penerimaan</strong>
                        <p>Publikasi, pencocokan, atau pengiriman aplikasi tidak menjamin kandidat dipanggil, diterima, atau
                            memperoleh penawaran.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-soft" id="faq">
        <div class="container">@include('frontend.components.section-head', [
            'eyebrow' => 'Pertanyaan Umum',
            'title' => 'Informasi Awal Job Connect',
            'description' => 'Penjelasan dasar bagi kandidat dan perusahaan sebelum menggunakan layanan.',
        ])<div class="faq-wrap">
                <article class="faq-item"><button class="faq-q" type="button">Apakah Job Connect menjamin saya diterima
                        bekerja?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Tidak. Job Connect membantu akses informasi, pengiriman profil, atau pencocokan
                        awal. Keputusan pemanggilan, seleksi, penawaran, dan penerimaan sepenuhnya berada pada perusahaan.
                    </div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Apakah semua lowongan telah
                        diverifikasi?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Informasi lowongan ditelaah berdasarkan data dan konfirmasi yang tersedia. Kandidat
                        tetap perlu berhati-hati, membaca detail, dan hanya mengikuti kanal resmi yang dicantumkan.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Apakah kandidat harus membayar untuk
                        melamar?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Pada prinsipnya aplikasi pekerjaan tidak dipungut biaya. Program pelatihan atau
                        layanan karier terpisah, bila tersedia, harus dijelaskan sebagai pilihan dan tidak boleh dijadikan
                        jaminan penerimaan.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Bagaimana perusahaan memasang
                        lowongan?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Perusahaan dapat menyampaikan profil posisi, kriteria, lokasi, jadwal, PIC, dan
                        mekanisme aplikasi. Tim akan menelaah kelengkapan serta menyusun ruang lingkup publikasi.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Apakah Bankir Academy melakukan screening
                        kandidat?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Screening awal dapat dilakukan bila termasuk dalam ruang lingkup. Hasilnya bersifat
                        informasi pendukung dan tidak menggantikan asesmen atau keputusan perusahaan.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Berapa lama lowongan ditayangkan?<span
                            class="faq-plus">＋</span></button>
                    <div class="faq-a">Periode tayang mengikuti tanggal penutupan atau durasi yang disepakati. Publikasi
                        dapat ditutup lebih awal atas permintaan perusahaan atau bila posisi telah terpenuhi.</div>
                </article>
            </div>
        </div>
    </section>
    <section class="final-cta" id="konsultasi">
        <div class="container">
            <div class="cta-box">
                <div>
                    <h2>Hubungkan Peluang Kerja dengan Talenta yang Relevan</h2>
                    <p>Sampaikan nama perusahaan, profil posisi, jumlah kebutuhan, lokasi, kriteria, jadwal, proses seleksi,
                        dan target publikasi. Tim Bankir Academy akan membantu menelaah kebutuhan serta menyusun opsi
                        layanan Job Connect.</p>
                </div>
                <div class="cta-actions"><a class="btn btn-light"
                        href="mailto:info@bankiracademy.co.id?subject=Publikasi%20Lowongan%20Job%20Connect">Publikasikan
                        Lowongan</a><a class="btn btn-secondary" href="#layanan">Lihat Ruang Lingkup</a></div>
            </div>
        </div>
    </section>
@endsection
