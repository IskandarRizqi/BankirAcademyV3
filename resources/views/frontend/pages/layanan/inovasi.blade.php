@extends('layouts.appfrontend')

@section('page-title')
    Inovasi Program — Bankir Academy
@endsection

@section('page-description')
    Inovasi Program Bankir Academy membantu institusi merancang riset, prototipe, automasi, dashboard, produk pembelajaran,
    dan AI terapan secara terukur serta bertanggung jawab.
@endsection

@section('content')
    <section class="hero solution-hero innovation-hero" id="beranda">
        <div class="container hero-grid">
            <div>
                <span class="eyebrow">Research · Design · Prototype · Implement</span>
                <h1>Mengubah Tantangan Menjadi <span class="gradient-text">Inovasi yang Terukur dan Dapat Diterapkan</span>
                </h1>
                <p class="hero-lead">Inovasi Program Bankir Academy membantu Bank, BPR/BPRS, lembaga pendidikan, dan mitra
                    organisasi merancang solusi baru melalui riset kebutuhan, desain layanan, pengembangan prototipe,
                    automasi proses, dashboard, serta AI terapan yang tetap memerlukan tata kelola dan validasi manusia.</p>
                <div class="hero-actions"><a class="btn btn-primary" href="#ruang-lingkup">Jelajahi Ruang Lingkup <span
                            class="icon-arrow">→</span></a><a class="btn btn-outline" href="#konsultasi">Diskusikan Ide
                        Program</a></div>
                <div class="solution-kicker"><span>Berbasis kebutuhan nyata</span><span>Prototipe sebelum implementasi
                        luas</span><span>Human review &amp; governance</span></div>
            </div>
            <div aria-label="Ilustrasi proses inovasi program" class="hero-visual">
                <div class="visual-main">
                    <div class="innovation-console">
                        <div class="console-top"><span>Innovation Delivery Workspace</span><span
                                class="console-state">VALIDATED PROCESS</span></div>
                        <div class="console-focus"><small>Current Innovation Sprint</small>
                            <h3>Digital Knowledge &amp; Workflow Assistant</h3>
                            <p>Menyederhanakan akses pengetahuan, proses kerja, dan tindak lanjut melalui desain yang
                                teruji.</p>
                        </div>
                        <div class="console-flow">
                            <div class="console-node"><i>⌕</i><span>Discover</span></div>
                            <div class="console-node"><i>◇</i><span>Define</span></div>
                            <div class="console-node"><i>✦</i><span>Design</span></div>
                            <div class="console-node"><i>▦</i><span>Pilot</span></div>
                            <div class="console-node"><i>✓</i><span>Review</span></div>
                        </div>
                        <div class="console-grid">
                            <div class="console-card"><strong>Evidence Readiness</strong><span>Data, kebutuhan pengguna, dan
                                    risiko</span>
                                <div class="console-meter"><b class="width-82"></b></div>
                            </div>
                            <div class="console-card"><strong>Implementation Readiness</strong><span>Proses, pemilik,
                                    kontrol, dan evaluasi</span>
                                <div class="console-meter"><b class="width-69"></b></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="float-card one"><span class="float-icon">⌕</span><span><strong>Research
                            Insight</strong><small>Masalah dan kebutuhan pengguna</small></span></div>
                <div class="float-card two"><span class="float-icon">✦</span><span><strong>Prototype Lab</strong><small>Uji
                            sebelum skala luas</small></span></div>
            </div>
        </div>
    </section>
    <div class="quick-nav">
        <div class="container">
            <div class="quick-nav-inner">
                <a href="#fokus"><i>01</i><span><strong>Fokus Inovasi</strong><span>Area kebutuhan yang dapat
                            dikembangkan</span></span></a>
                <a href="#ruang-lingkup"><i>02</i><span><strong>Ruang Lingkup</strong><span>Riset, desain, teknologi, dan
                            evaluasi</span></span></a>
                <a href="#tahapan"><i>03</i><span><strong>Tahapan Kerja</strong><span>Dari discovery hingga
                            review</span></span></a>
                <a href="#ketentuan"><i>04</i><span><strong>Tata Kelola</strong><span>Data, risiko, hak, dan
                            keputusan</span></span></a>
            </div>
        </div>
    </div>
    <section class="section" id="fokus">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Fokus Pengembangan',
                'title' => 'Inovasi yang Berangkat dari Masalah dan Tujuan yang Jelas',
                'description' =>
                    'Program tidak dimulai dari teknologi tertentu, tetapi dari kebutuhan pengguna, sasaran organisasi, proses yang perlu diperbaiki, data yang tersedia, serta risiko yang harus dikendalikan.',
            ])
            <div class="focus-grid">
                <article class="focus-card"><i>▦</i>
                    <h3>Efisiensi Proses</h3>
                    <p>Menyederhanakan alur kerja, pengumpulan data, dokumentasi, pelaporan, dan tindak lanjut yang masih
                        manual atau berulang.</p>
                </article>
                <article class="focus-card"><i>◎</i>
                    <h3>Pengalaman Pengguna</h3>
                    <p>Merancang layanan, materi, komunikasi, atau kanal interaksi yang lebih mudah dipahami dan digunakan
                        oleh sasaran program.</p>
                </article>
                <article class="focus-card"><i>⌕</i>
                    <h3>Insight &amp; Keputusan</h3>
                    <p>Mengolah data dan temuan menjadi dashboard, laporan, prioritas, atau rekomendasi yang dapat ditinjau
                        pihak berwenang.</p>
                </article>
                <article class="focus-card"><i>✦</i>
                    <h3>Produk &amp; Model Baru</h3>
                    <p>Menguji konsep produk, layanan, kurikulum, kanal digital, atau model kolaborasi sebelum dikembangkan
                        lebih luas.</p>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-soft" id="ruang-lingkup">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Ruang Lingkup Layanan',
                'title' => 'Kapabilitas Inovasi dari Riset hingga Implementasi',
                'description' =>
                    'Komponen berikut dapat digunakan secara terpisah atau digabungkan menjadi satu program inovasi terintegrasi sesuai tujuan, anggaran, data, waktu, dan kesiapan institusi.',
            ])
            <div class="solution-grid">
                <article class="solution-card">
                    <div class="card-icon">⌕</div>
                    <h3>Research &amp; Needs Discovery</h3>
                    <p>Mengidentifikasi masalah, kebutuhan pengguna, konteks proses, peluang, kendala, dan prioritas melalui
                        metode yang disepakati.</p>
                    <ul>
                        <li>Wawancara, survei, dan observasi</li>
                        <li>Process dan stakeholder mapping</li>
                        <li>Insight serta problem statement</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">◇</div>
                    <h3>Product &amp; Service Design</h3>
                    <p>Merancang konsep produk, layanan, program, pengalaman pengguna, dan alur interaksi berdasarkan
                        evidence serta tujuan organisasi.</p>
                    <ul>
                        <li>Value proposition dan service blueprint</li>
                        <li>User journey dan requirement</li>
                        <li>Konsep fitur serta prioritas</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">✦</div>
                    <h3>Prototype &amp; Pilot Program</h3>
                    <p>Membuat contoh awal yang cukup untuk menguji asumsi, kelayakan, respons pengguna, proses operasional,
                        dan kebutuhan perbaikan.</p>
                    <ul>
                        <li>Low atau high fidelity prototype</li>
                        <li>Pilot terbatas dan test scenario</li>
                        <li>Feedback serta iteration log</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">⇄</div>
                    <h3>Process Automation</h3>
                    <p>Mendesain automasi untuk pekerjaan yang terstruktur dengan tetap menetapkan pemilik proses,
                        pengecualian, kontrol, dan review manusia.</p>
                    <ul>
                        <li>Workflow dan approval mapping</li>
                        <li>Integration requirement</li>
                        <li>Exception dan audit trail</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">▦</div>
                    <h3>Dashboard &amp; Decision Support</h3>
                    <p>Mengembangkan tampilan informasi untuk memantau indikator, progres, risiko, tren, dan tindak lanjut
                        tanpa menggantikan keputusan berwenang.</p>
                    <ul>
                        <li>Metric dan data definition</li>
                        <li>Dashboard prototype</li>
                        <li>Role-based reporting</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">AI</div>
                    <h3>Responsible AI Application</h3>
                    <p>Mengeksplorasi pemanfaatan AI untuk pencarian pengetahuan, penyusunan draft, klasifikasi,
                        pembelajaran, atau insight dengan kontrol yang sesuai.</p>
                    <ul>
                        <li>Use-case dan risk assessment</li>
                        <li>Data serta access governance</li>
                        <li>Human verification protocol</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>
    <section class="section" id="tahapan">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Innovation Delivery Framework',
                'title' => 'Tahapan Kerja yang Transparan dan Bertahap',
                'description' =>
                    'Setiap tahap menghasilkan dasar keputusan sebelum program dilanjutkan, diubah, dibatasi, atau dihentikan.',
            ])
            <div class="stage-grid">
                <article class="stage-card"><b>1</b>
                    <h3>Discover</h3>
                    <p>Memahami pengguna, proses, data, masalah, peluang, dan batasan.</p>
                </article>
                <article class="stage-card"><b>2</b>
                    <h3>Define</h3>
                    <p>Menetapkan sasaran, problem statement, indikator, ruang lingkup, dan risiko.</p>
                </article>
                <article class="stage-card"><b>3</b>
                    <h3>Design</h3>
                    <p>Merancang opsi solusi, alur, requirement, kontrol, dan pengalaman pengguna.</p>
                </article>
                <article class="stage-card"><b>4</b>
                    <h3>Prototype</h3>
                    <p>Membuat bentuk awal untuk menguji fungsi, asumsi, dan kelayakan.</p>
                </article>
                <article class="stage-card"><b>5</b>
                    <h3>Pilot</h3>
                    <p>Menguji terbatas, mendokumentasikan hasil, feedback, isu, dan perbaikan.</p>
                </article>
                <article class="stage-card"><b>6</b>
                    <h3>Review &amp; Scale</h3>
                    <p>Menilai hasil dan menentukan implementasi, iterasi, perluasan, atau penutupan.</p>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-soft" id="contoh">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Contoh Use Case',
                'title' => 'Pengembangan yang Dapat Disesuaikan dengan Konteks Institusi',
                'description' =>
                    'Contoh berikut bersifat ilustratif. Kelayakan, ruang lingkup, dan hasil akhir baru dapat ditetapkan setelah discovery dan penilaian kesiapan.',
            ])
            <div class="usecase-grid">
                <article class="usecase-card">
                    <div class="card-icon">⌕</div>
                    <h3>Internal Knowledge Assistant</h3>
                    <p>Membantu pengguna mencari SOP, materi, panduan, atau jawaban berbasis dokumen yang telah disetujui.
                    </p>
                    <ul>
                        <li>Hak akses berbasis peran</li>
                        <li>Referensi sumber pada jawaban</li>
                        <li>Review dan pembaruan konten</li>
                    </ul>
                </article>
                <article class="usecase-card">
                    <div class="card-icon">▦</div>
                    <h3>Learning &amp; Performance Insight</h3>
                    <p>Menggabungkan data pembelajaran, asesmen, kompetensi, dan tindak lanjut untuk mendukung evaluasi
                        program.</p>
                    <ul>
                        <li>Definisi indikator bersama</li>
                        <li>Dashboard progres dan gap</li>
                        <li>Action plan dan review</li>
                    </ul>
                </article>
                <article class="usecase-card">
                    <div class="card-icon">⇄</div>
                    <h3>Administrative Workflow</h3>
                    <p>Menyederhanakan permohonan, verifikasi, persetujuan, pengingat, pencatatan, dan pelaporan aktivitas
                        tertentu.</p>
                    <ul>
                        <li>Workflow dan SLA</li>
                        <li>Approval serta exception</li>
                        <li>Log aktivitas dan status</li>
                    </ul>
                </article>
                <article class="usecase-card">
                    <div class="card-icon">◎</div>
                    <h3>Product &amp; Customer Research</h3>
                    <p>Mengumpulkan insight segmen, pengalaman pengguna, fitur, hambatan, dan peluang pengembangan produk
                        atau layanan.</p>
                    <ul>
                        <li>Research plan dan sampling</li>
                        <li>Customer insight synthesis</li>
                        <li>Prioritized opportunity</li>
                    </ul>
                </article>
                <article class="usecase-card">
                    <div class="card-icon">🎓</div>
                    <h3>Digital Learning Product</h3>
                    <p>Merancang program belajar digital berupa video, e-book, simulasi, studi kasus, kuis, dan learning
                        journey.</p>
                    <ul>
                        <li>Instructional design</li>
                        <li>Prototype modul</li>
                        <li>Uji pengguna dan evaluasi</li>
                    </ul>
                </article>
                <article class="usecase-card">
                    <div class="card-icon">✦</div>
                    <h3>Innovation Challenge Program</h3>
                    <p>Membantu organisasi mengelola ide dari pegawai atau komunitas melalui tantangan, seleksi, mentoring,
                        dan demo.</p>
                    <ul>
                        <li>Challenge brief dan kriteria</li>
                        <li>Mentoring serta sprint</li>
                        <li>Demo day dan rekomendasi</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>
    <section class="section" id="ketentuan">
        <div class="container governance-wrap">
            <div class="governance-panel"><span class="eyebrow">Responsible Innovation</span>
                <h3>Inovasi Harus Berguna, Layak, Aman, dan Dapat Dipertanggungjawabkan</h3>
                <p>Pengembangan dilakukan dengan mempertimbangkan manfaat, kesiapan proses, kualitas data, akses, privasi,
                    keamanan, dampak pengguna, risiko operasional, serta kewenangan pengambilan keputusan.</p>
                <div class="governance-tags"><span>Purpose Limitation</span><span>Data Minimization</span><span>Access
                        Control</span><span>Human Oversight</span><span>Testing &amp; Monitoring</span><span>Change
                        Management</span></div>
            </div>
            <div>
                <div class="section-head left section-head-compact-24"><span class="eyebrow">Ketentuan Pelaksanaan</span>
                    <h2>Standar Kerja Sebelum Solusi Digunakan</h2>
                </div>
                <div class="benefit-list">
                    <article class="benefit-item"><i>1</i>
                        <div>
                            <h3>Data dan Hak Penggunaan</h3>
                            <p>Data, dokumen, logo, konten, sistem, dan materi yang digunakan harus memiliki dasar
                                penggunaan serta kewenangan yang jelas.</p>
                        </div>
                    </article>
                    <article class="benefit-item"><i>2</i>
                        <div>
                            <h3>Ruang Lingkup dan Acceptance Criteria</h3>
                            <p>Fitur, pengguna, integrasi, deliverables, batasan, jadwal, dan kriteria penerimaan ditetapkan
                                secara tertulis.</p>
                        </div>
                    </article>
                    <article class="benefit-item"><i>3</i>
                        <div>
                            <h3>Testing dan Human Review</h3>
                            <p>Prototipe atau keluaran teknologi perlu diuji dan diverifikasi sebelum digunakan untuk proses
                                atau keputusan penting.</p>
                        </div>
                    </article>
                    <article class="benefit-item"><i>4</i>
                        <div>
                            <h3>Keamanan, Privasi, dan Akses</h3>
                            <p>Kontrol akses, penyimpanan, retensi, kerahasiaan, serta penanganan insiden disesuaikan dengan
                                sifat data dan kebijakan institusi.</p>
                        </div>
                    </article>
                    <article class="benefit-item"><i>5</i>
                        <div>
                            <h3>Perubahan dan Pemeliharaan</h3>
                            <p>Implementasi memerlukan pemilik proses, dokumentasi, pelatihan, monitoring, dukungan, serta
                                mekanisme perubahan yang disepakati.</p>
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
                'title' => 'Hasil Kerja yang Dapat Ditinjau dan Ditindaklanjuti',
                'description' =>
                    'Jenis output disesuaikan dengan ruang lingkup, ketersediaan data, tahapan program, dan kesepakatan para pihak.',
            ])
            <div class="deliverable-grid">
                <article class="deliverable"><i>⌕</i>
                    <h3>Research &amp; Insight Report</h3>
                    <p>Temuan, kebutuhan pengguna, masalah prioritas, peluang, batasan, dan rekomendasi awal.</p>
                </article>
                <article class="deliverable"><i>◇</i>
                    <h3>Concept &amp; Requirement</h3>
                    <p>Konsep solusi, user journey, requirement, prioritas fitur, kontrol, dan acceptance criteria.</p>
                </article>
                <article class="deliverable"><i>✦</i>
                    <h3>Prototype</h3>
                    <p>Contoh awal berupa alur, wireframe, mockup, modul, dashboard, atau sistem terbatas.</p>
                </article>
                <article class="deliverable"><i>▦</i>
                    <h3>Pilot Evaluation</h3>
                    <p>Hasil uji, feedback, isu, metrik, risiko, perubahan, dan keputusan tindak lanjut.</p>
                </article>
                <article class="deliverable"><i>✓</i>
                    <h3>Implementation Roadmap</h3>
                    <p>Tahapan implementasi, pemilik, kebutuhan sumber daya, dependency, kontrol, dan milestone.</p>
                </article>
                <article class="deliverable"><i>▤</i>
                    <h3>Governance Documentation</h3>
                    <p>Panduan penggunaan, peran, akses, review, monitoring, perubahan, dan penanganan risiko.</p>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-soft" id="faq">
        <div class="container">@include('frontend.components.section-head', [
            'eyebrow' => 'Pertanyaan Umum',
            'title' => 'Informasi Awal Inovasi Program',
            'description' => 'Beberapa hal yang perlu dipahami sebelum memulai pengembangan.',
        ])<div class="faq-wrap">
                <article class="faq-item"><button class="faq-q" type="button">Apakah harus menggunakan AI?<span
                            class="faq-plus">＋</span></button>
                    <div class="faq-a">Tidak. Teknologi dipilih setelah masalah, kebutuhan, risiko, data, dan kesiapan
                        dipahami. Solusi dapat berupa perbaikan proses, desain layanan, dashboard, materi pembelajaran,
                        automasi sederhana, atau AI bila memang relevan.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Apakah Bankir Academy langsung membangun
                        sistem penuh?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Ruang lingkup dapat berhenti pada riset, desain, prototipe, atau pilot.
                        Pengembangan sistem penuh hanya dilakukan apabila kebutuhan, teknologi, integrasi, keamanan,
                        anggaran, pemeliharaan, dan tanggung jawab telah disepakati.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Siapa pemilik hasil inovasi?<span
                            class="faq-plus">＋</span></button>
                    <div class="faq-a">Kepemilikan, hak penggunaan, kerahasiaan, komponen pihak ketiga, source material,
                        dan hak publikasi ditetapkan dalam proposal atau perjanjian.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Bagaimana mengukur keberhasilan
                        pilot?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Indikator ditetapkan sejak awal, misalnya tingkat penggunaan, penyelesaian tugas,
                        waktu proses, akurasi, feedback pengguna, penurunan kesalahan, kesiapan operasional, atau kualitas
                        pembelajaran.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Apakah data internal wajib
                        diberikan?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Tidak selalu. Kebutuhan data bergantung pada use case. Data yang digunakan
                        sebaiknya relevan, minimum, sah, aman, dan sesuai kewenangan. Prototipe awal dapat memakai data
                        contoh atau data yang telah disamarkan bila memungkinkan.</div>
                </article>
            </div>
        </div>
    </section>
    <section class="final-cta" id="konsultasi">
        <div class="container">
            <div class="cta-box">
                <div>
                    <h2>Mulai dari Masalah yang Paling Penting</h2>
                    <p>Sampaikan proses yang ingin diperbaiki, pengguna yang terlibat, data atau sistem yang tersedia,
                        kendala utama, serta hasil yang ingin dicapai. Tim Bankir Academy akan membantu menyusun opsi
                        discovery dan ruang lingkup awal.</p>
                </div>
                <div class="cta-actions"><a class="btn btn-light"
                        href="mailto:info@bankiracademy.co.id?subject=Konsultasi%20Inovasi%20Program">Email
                        Konsultasi</a><a class="btn btn-secondary" href="#ruang-lingkup">Pelajari Layanan</a></div>
            </div>
        </div>
    </section>
@endsection
