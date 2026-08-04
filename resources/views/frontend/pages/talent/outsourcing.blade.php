@extends('layouts.appfrontend')

@section('page-title')
    Outsourcing Perbankan — Bankir Academy
@endsection

@section('page-description')
    Layanan outsourcing Bankir Academy untuk membantu Bank, BPR, BPRS, dan perusahaan jasa keuangan memperoleh dukungan
    tenaga kerja melalui proses perencanaan kebutuhan, seleksi, penempatan, administrasi, pemantauan, dan evaluasi yang
    terstruktur.
@endsection

@section('content')
    <section class="hero solution-hero talent-hero" id="beranda">
        <div class="container hero-grid">
            <div>
                <span class="eyebrow">Talent Solutions · Outsourcing</span>
                <h1>Dukungan Tenaga Kerja yang <span class="gradient-text">Terencana, Terkelola, dan Terukur</span></h1>
                <p class="hero-lead">Layanan penyediaan dan pengelolaan tenaga kerja untuk membantu Bank, BPR, BPRS, dan
                    organisasi jasa keuangan memenuhi kebutuhan fungsi pendukung maupun operasional berdasarkan ruang
                    lingkup, standar layanan, serta pembagian tanggung jawab yang disepakati.</p>
                <div class="hero-actions"><a class="btn btn-primary" href="#layanan">Pelajari Layanan <span
                            class="icon-arrow">→</span></a><a class="btn btn-outline" href="#konsultasi">Diskusikan Kebutuhan
                        Tenaga Kerja</a></div>
                <div class="solution-kicker"><span>Workforce Planning</span><span>Structured Selection</span><span>Service
                        Monitoring</span><span>Documented Process</span></div>
            </div>
            <div aria-label="Ilustrasi dashboard pengelolaan outsourcing" class="hero-visual">
                <div class="visual-main">
                    <div class="talent-board">
                        <div class="talent-board-head">Workforce Service Dashboard <span>Managed Process</span></div>
                        <div class="talent-profile">
                            <div class="talent-avatar">◎</div>
                            <div>
                                <h3>Operational Support Team</h3>
                                <p>Workforce plan · placement · service review</p>
                            </div>
                        </div>
                        <div class="competency-grid">
                            <div class="competency-card"><strong>Position Readiness <em>88%</em></strong><small>Kesesuaian
                                    profil dan kebutuhan fungsi</small>
                                <div class="board-meter"><i class="width-88"></i></div>
                            </div>
                            <div class="competency-card"><strong>Service Compliance <em>94%</em></strong><small>Dokumen,
                                    kehadiran, dan pelaporan</small>
                                <div class="board-meter"><i class="width-94"></i></div>
                            </div>
                            <div class="competency-card"><strong>Attendance <em>96%</em></strong><small>Pemantauan kehadiran
                                    tenaga kerja</small>
                                <div class="board-meter"><i class="width-96"></i></div>
                            </div>
                            <div class="competency-card"><strong>Review Cycle <em>Monthly</em></strong><small>Evaluasi
                                    layanan secara berkala</small>
                                <div class="board-meter"><i class="width-76"></i></div>
                            </div>
                        </div>
                        <div class="talent-path"><i>1</i><span><strong>Plan &amp; Select</strong>Kebutuhan dan
                                kandidat</span><i>2</i><span><strong>Place &amp; Manage</strong>Penempatan dan
                                administrasi</span><i>3</i><span><strong>Monitor &amp; Review</strong>Kinerja layanan</span>
                        </div>
                    </div>
                </div>
                <div class="float-card one"><span class="float-icon">▤</span><span><strong>Clear Scope</strong><small>Peran
                            dan tanggung jawab</small></span></div>
                <div class="float-card two"><span class="float-icon">✓</span><span><strong>Service
                            Review</strong><small>Evaluasi terjadwal</small></span></div>
            </div>
        </div>
    </section>
    <div class="quick-nav">
        <div class="container">
            <div class="quick-nav-inner">
                <a href="#kebutuhan"><i>01</i><span><strong>Kebutuhan</strong><span>Kapan outsourcing
                            relevan</span></span></a>
                <a href="#layanan"><i>02</i><span><strong>Ruang Lingkup</strong><span>Komponen layanan
                            utama</span></span></a>
                <a href="#proses"><i>03</i><span><strong>Proses</strong><span>Dari perencanaan hingga
                            evaluasi</span></span></a>
                <a href="#ketentuan"><i>04</i><span><strong>Ketentuan</strong><span>Tata kelola dan
                            batasan</span></span></a>
            </div>
        </div>
    </div>
    <section class="section" id="kebutuhan">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Kebutuhan Organisasi',
                'title' => 'Ketika Organisasi Membutuhkan Kapasitas Tambahan dengan Pengelolaan yang Jelas',
                'description' =>
                    'Outsourcing dapat dipertimbangkan untuk fungsi yang ruang lingkupnya terdefinisi, dapat dipantau, dan tidak mengalihkan kewenangan utama organisasi. Kelayakan layanan perlu ditinjau berdasarkan karakter pekerjaan dan ketentuan yang berlaku.',
            ])
            <div class="audience-grid">
                <article class="audience-card"><i>1</i>
                    <h3>Kebutuhan Fleksibel</h3>
                    <p>Dukungan tenaga kerja untuk periode, lokasi, proyek, atau volume pekerjaan tertentu yang dapat
                        berubah sesuai kebutuhan.</p>
                </article>
                <article class="audience-card"><i>2</i>
                    <h3>Fungsi Pendukung</h3>
                    <p>Pekerjaan administratif, layanan, operasional pendukung, atau fungsi lain yang memiliki uraian tugas
                        dan standar proses yang jelas.</p>
                </article>
                <article class="audience-card"><i>3</i>
                    <h3>Perlu Administrasi Terpusat</h3>
                    <p>Organisasi memerlukan dukungan seleksi, kontrak, data tenaga kerja, kehadiran, penggantian, dan
                        pelaporan layanan.</p>
                </article>
                <article class="audience-card"><i>4</i>
                    <h3>Perlu Monitoring Layanan</h3>
                    <p>Kinerja tenaga kerja perlu dipantau melalui indikator, evaluasi, komunikasi berkala, dan mekanisme
                        perbaikan yang terdokumentasi.</p>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-soft" id="layanan">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Ruang Lingkup Layanan',
                'title' => 'Pengelolaan Tenaga Kerja dari Perencanaan hingga Evaluasi',
                'description' =>
                    'Komponen layanan disusun sesuai jabatan, lokasi, jumlah tenaga kerja, pola kerja, durasi, standar kinerja, dan pembagian tanggung jawab yang disepakati bersama.',
            ])
            <div class="solution-grid">
                <article class="solution-card">
                    <div class="card-icon">▤</div>
                    <h3>Workforce Requirement Planning</h3>
                    <p>Menerjemahkan kebutuhan organisasi menjadi profil tenaga kerja, volume, jadwal, lokasi, dan ruang
                        lingkup pekerjaan yang jelas.</p>
                    <ul>
                        <li>Job scope dan kompetensi dasar</li>
                        <li>Jumlah serta lokasi penempatan</li>
                        <li>Jam kerja dan kebutuhan operasional</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">⌕</div>
                    <h3>Recruitment &amp; Screening</h3>
                    <p>Menjalankan pencarian dan penyaringan kandidat berdasarkan parameter yang disepakati tanpa mengurangi
                        kewenangan persetujuan klien.</p>
                    <ul>
                        <li>Sourcing dan administrasi kandidat</li>
                        <li>Screening serta wawancara awal</li>
                        <li>Dokumen dan kesiapan penempatan</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">⇄</div>
                    <h3>Placement &amp; Onboarding</h3>
                    <p>Mengoordinasikan penempatan, orientasi awal, akses kerja, penjelasan tugas, serta komunikasi peran
                        kepada tenaga kerja.</p>
                    <ul>
                        <li>Koordinasi jadwal mulai kerja</li>
                        <li>Briefing ruang lingkup dan aturan</li>
                        <li>Checklist kesiapan penempatan</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">◎</div>
                    <h3>Workforce Administration</h3>
                    <p>Mengelola administrasi tenaga kerja sesuai ruang lingkup kontrak dan dokumen layanan yang telah
                        disepakati para pihak.</p>
                    <ul>
                        <li>Data dan dokumen tenaga kerja</li>
                        <li>Rekap kehadiran dan perubahan status</li>
                        <li>Administrasi layanan berkala</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">▦</div>
                    <h3>Performance Monitoring</h3>
                    <p>Memantau pelaksanaan pekerjaan berdasarkan indikator layanan, catatan supervisor, kedisiplinan, dan
                        umpan balik klien.</p>
                    <ul>
                        <li>Service level indicator</li>
                        <li>Review kinerja dan kedisiplinan</li>
                        <li>Rencana perbaikan bila diperlukan</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">✓</div>
                    <h3>Replacement &amp; Service Support</h3>
                    <p>Mendukung penyelesaian isu, pergantian tenaga kerja, pembaruan kebutuhan, dan tindak lanjut layanan
                        sesuai ketentuan kontrak.</p>
                    <ul>
                        <li>Issue handling dan escalation</li>
                        <li>Replacement sesuai persyaratan</li>
                        <li>Service review dan renewal input</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>
    <section class="section" id="proses">
        <div class="container method-wrap">
            <div class="method-panel"><span class="eyebrow">Managed Workforce</span>
                <h3>Proses yang Terdokumentasi dan Dapat Dikendalikan</h3>
                <p>Setiap penempatan memerlukan kejelasan fungsi, kriteria, otorisasi, standar layanan, administrasi, dan
                    jalur komunikasi. Detail implementasi menyesuaikan kebutuhan serta ketentuan yang berlaku.</p>
                <div class="method-stat-grid">
                    <div class="method-stat"><strong>Defined Scope</strong><span>Tugas dan batas kewenangan</span></div>
                    <div class="method-stat"><strong>Service Level</strong><span>Indikator yang disepakati</span></div>
                    <div class="method-stat"><strong>Single Coordination</strong><span>Jalur komunikasi terstruktur</span>
                    </div>
                    <div class="method-stat"><strong>Periodic Review</strong><span>Evaluasi dan tindak lanjut</span></div>
                </div>
            </div>
            <div class="process-list">
                <article class="process-item"><span class="process-number">1</span>
                    <div>
                        <h3>Requirement &amp; Compliance Review</h3>
                        <p>Menelaah kebutuhan, karakter fungsi, lokasi, periode, pola kerja, risiko, dan kelayakan
                            outsourcing.</p>
                    </div>
                </article>
                <article class="process-item"><span class="process-number">2</span>
                    <div>
                        <h3>Service Design &amp; Agreement</h3>
                        <p>Menetapkan ruang lingkup, pembagian peran, SLA, biaya, pelaporan, eskalasi, dan ketentuan
                            perubahan.</p>
                    </div>
                </article>
                <article class="process-item"><span class="process-number">3</span>
                    <div>
                        <h3>Recruitment &amp; Client Approval</h3>
                        <p>Melaksanakan sourcing dan screening, kemudian mengajukan kandidat sesuai mekanisme persetujuan
                            yang disepakati.</p>
                    </div>
                </article>
                <article class="process-item"><span class="process-number">4</span>
                    <div>
                        <h3>Placement &amp; Operational Setup</h3>
                        <p>Mengoordinasikan onboarding, penempatan, briefing, dokumen, serta kesiapan pelaksanaan pekerjaan.
                        </p>
                    </div>
                </article>
                <article class="process-item"><span class="process-number">5</span>
                    <div>
                        <h3>Monitoring, Reporting &amp; Review</h3>
                        <p>Memantau layanan, menyampaikan laporan, menindaklanjuti isu, dan mengevaluasi kebutuhan perbaikan
                            atau perpanjangan.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-soft" id="cakupan">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Contoh Cakupan Fungsi',
                'title' => 'Dapat Disesuaikan dengan Struktur dan Kebutuhan Institusi',
                'description' =>
                    'Daftar berikut bersifat contoh. Setiap fungsi perlu dinilai dari sisi tugas, risiko, akses informasi, kewenangan, pengawasan, serta kesesuaiannya dengan kebijakan dan regulasi.',
            ])
            <div class="package-grid">
                <article class="package-card">
                    <div class="card-icon">▤</div>
                    <h3>Administrative Support</h3>
                    <p>Dukungan pekerjaan administratif yang memiliki prosedur dan output terdefinisi.</p>
                    <ul>
                        <li>Data entry dan pengarsipan</li>
                        <li>Administrasi dokumen</li>
                        <li>General office support</li>
                        <li>Event dan training support</li>
                    </ul>
                </article>
                <article class="package-card featured">
                    <div class="card-icon card-icon-light">◎</div>
                    <h3>Operational Support</h3>
                    <p>Dukungan operasional non-keputusan dengan pengawasan dan pembatasan akses yang memadai.</p>
                    <ul>
                        <li>Customer service support</li>
                        <li>Call center atau helpdesk</li>
                        <li>Collection administration</li>
                        <li>Operational processing support</li>
                    </ul>
                </article>
                <article class="package-card">
                    <div class="card-icon">↗</div>
                    <h3>Business Support</h3>
                    <p>Dukungan aktivitas bisnis yang parameter, etika, dan kewenangannya telah ditetapkan.</p>
                    <ul>
                        <li>Sales support dan telemarketing</li>
                        <li>Field data collection</li>
                        <li>Survey administration</li>
                        <li>Campaign dan customer outreach</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-dark" id="hasil">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Output Layanan',
                'title' => 'Dokumen dan Informasi untuk Mengendalikan Layanan',
                'description' =>
                    'Output aktual disesuaikan dengan paket, periode, volume tenaga kerja, serta tanggung jawab yang tertuang dalam perjanjian.',
            ])
            <div class="deliverable-grid">
                <article class="deliverable"><i>▤</i>
                    <h3>Workforce Requirement</h3>
                    <p>Profil kebutuhan, jumlah tenaga kerja, lokasi, tugas, jadwal, dan kompetensi dasar.</p>
                </article>
                <article class="deliverable"><i>⌕</i>
                    <h3>Candidate &amp; Placement Record</h3>
                    <p>Data kandidat, hasil penyaringan awal, persetujuan, dan status penempatan.</p>
                </article>
                <article class="deliverable"><i>⇄</i>
                    <h3>Onboarding Checklist</h3>
                    <p>Catatan dokumen, briefing, akses, perlengkapan, dan kesiapan mulai bekerja.</p>
                </article>
                <article class="deliverable"><i>◎</i>
                    <h3>Attendance &amp; Administration</h3>
                    <p>Rekap kehadiran dan administrasi layanan sesuai data serta periode yang disepakati.</p>
                </article>
                <article class="deliverable"><i>▦</i>
                    <h3>Service Performance Report</h3>
                    <p>Ringkasan indikator layanan, umpan balik, isu, tindakan perbaikan, dan status tindak lanjut.</p>
                </article>
                <article class="deliverable"><i>✓</i>
                    <h3>Periodic Review Summary</h3>
                    <p>Evaluasi kebutuhan, efektivitas layanan, perubahan ruang lingkup, dan rekomendasi periode berikutnya.
                    </p>
                </article>
            </div>
        </div>
    </section>
    <section class="section" id="ketentuan">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Prinsip &amp; Ketentuan',
                'title' => 'Tata Kelola yang Jelas bagi Klien, Penyedia, dan Tenaga Kerja',
                'description' =>
                    'Ruang lingkup, hubungan kerja, administrasi, pembiayaan, perlindungan data, SLA, pengawasan, dan mekanisme penyelesaian isu harus dituangkan secara tertulis.',
            ])
            <div class="principle-grid">
                <article class="principle"> <span>01</span>
                    <div><strong>Kepatuhan &amp; Kelayakan Fungsi</strong>
                        <p>Jenis pekerjaan dan model penempatan ditinjau agar sesuai dengan ketentuan, kebijakan, serta
                            pengendalian internal yang berlaku.</p>
                    </div>
                </article>
                <article class="principle"> <span>02</span>
                    <div><strong>Pembagian Tanggung Jawab</strong>
                        <p>Peran klien, Bankir Academy, supervisor, dan tenaga kerja harus jelas, termasuk instruksi kerja
                            dan
                            jalur eskalasi.</p>
                    </div>
                </article>
                <article class="principle"> <span>03</span>
                    <div><strong>Privasi &amp; Akses Informasi</strong>
                        <p>Akses data dibatasi berdasarkan kebutuhan pekerjaan, kewenangan, kerahasiaan, dan kontrol
                            keamanan
                            yang ditetapkan.</p>
                    </div>
                </article>
                <article class="principle"> <span>04</span>
                    <div><strong>Evaluasi Berbasis Bukti</strong>
                        <p>Penilaian layanan menggunakan data, indikator, catatan kejadian, dan umpan balik yang dapat
                            ditelusuri.</p>
                    </div>
                </article>
            </div>
            <div class="notice-box"><strong>Catatan penting:</strong> Outsourcing bukan pengalihan seluruh tanggung jawab
                operasional atau keputusan institusi. Klien tetap bertanggung jawab atas kewenangan, pengawasan fungsi,
                keamanan lingkungan kerja, akses sistem, kebijakan internal, dan keputusan yang hanya dapat dilakukan oleh
                pejabat berwenang. Ketentuan hubungan kerja, upah, manfaat, pajak, jaminan sosial, perlindungan data, dan
                pengakhiran mengikuti perjanjian serta peraturan yang berlaku.</div>
        </div>
    </section>
    <section class="section section-soft" id="faq">
        <div class="container">@include('frontend.components.section-head', [
            'eyebrow' => 'Pertanyaan Umum',
            'title' => 'Informasi Awal Layanan Outsourcing',
            'description' =>
                'Hal-hal yang perlu dipahami sebelum menyusun kebutuhan dan ruang lingkup penempatan tenaga kerja.',
        ])<div class="faq-wrap">
                <article class="faq-item open"><button class="faq-q" type="button">Apa perbedaan outsourcing dan
                        rekrutmen biasa?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Dalam rekrutmen biasa, kandidat yang diterima menjadi tenaga kerja klien sesuai
                        proses internalnya. Dalam outsourcing, penyedia memberikan dukungan tenaga kerja dan pengelolaan
                        layanan berdasarkan ruang lingkup serta pembagian tanggung jawab yang disepakati.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Apakah semua posisi dapat
                        dialihdayakan?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Tidak otomatis. Setiap posisi perlu ditinjau berdasarkan tugas, kewenangan, risiko,
                        akses data, kebijakan internal, serta ketentuan yang berlaku. Fungsi yang tidak layak tidak akan
                        dipaksakan menggunakan model outsourcing.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Siapa yang mengawasi pekerjaan
                        sehari-hari?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Model pengawasan ditetapkan dalam perjanjian. Klien memberikan arahan operasional
                        sesuai ruang lingkup, sedangkan koordinasi administrasi dan layanan dilakukan melalui PIC Bankir
                        Academy tanpa mengaburkan pembagian tanggung jawab.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Bagaimana jika tenaga kerja tidak
                        memenuhi standar?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Kinerja ditinjau berdasarkan indikator dan bukti. Dapat dilakukan coaching,
                        perbaikan, evaluasi, atau penggantian sesuai tingkat masalah dan ketentuan layanan yang disepakati.
                    </div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Apakah biaya layanan sudah termasuk
                        seluruh komponen?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Komponen biaya perlu dirinci dalam proposal, misalnya remunerasi, manfaat,
                        administrasi, rekrutmen, perlengkapan, perjalanan, pajak, atau komponen lain. Tidak ada komponen
                        yang dianggap termasuk tanpa dinyatakan secara tertulis.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Data apa yang perlu disiapkan klien?<span
                            class="faq-plus">＋</span></button>
                    <div class="faq-a">Minimal meliputi nama fungsi, uraian tugas, jumlah tenaga kerja, lokasi, jam kerja,
                        periode, kompetensi, kriteria, supervisor, akses yang diperlukan, indikator kinerja, target mulai,
                        serta kondisi khusus pekerjaan.</div>
                </article>
            </div>
        </div>
    </section>
    <section class="final-cta" id="konsultasi">
        <div class="container">
            <div class="cta-box">
                <div>
                    <h2>Susun Kebutuhan Outsourcing Secara Lebih Terarah</h2>
                    <p>Sampaikan fungsi, jumlah tenaga kerja, lokasi, periode, jam kerja, ruang lingkup, kompetensi, target
                        mulai, serta standar layanan. Tim Bankir Academy akan membantu melakukan penelaahan awal dan
                        menyusun opsi ruang lingkup yang relevan.</p>
                </div>
                <div class="cta-actions"><a class="btn btn-light"
                        href="mailto:info@bankiracademy.co.id?subject=Konsultasi%20Layanan%20Outsourcing">Email Kebutuhan
                        Outsourcing</a><a class="btn btn-secondary" href="#layanan">Lihat Ruang Lingkup</a></div>
            </div>
        </div>
    </section>
@endsection
