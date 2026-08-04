@extends('layouts.appfrontend')

@section('page-title')
    Learning Management System — Bankir Academy
@endsection

@section('page-description')
    Learning Management System Bankir Academy mendukung pengelolaan pembelajaran digital, kelas, materi, asesmen,
    sertifikat, pengguna, dan pelaporan dalam satu platform yang terstruktur.
@endsection

@section('content')
    <section class="hero solution-hero" id="ringkasan">
        <div class="container hero-grid">
            <div>
                <span class="eyebrow">Digital Learning Infrastructure</span>
                <h1>Kelola Pembelajaran dalam <span class="gradient-text">Satu Platform Terintegrasi</span></h1>
                <p class="hero-lead">Learning Management System Bankir Academy membantu institusi mengelola kelas, peserta,
                    materi, asesmen, sertifikat, aktivitas belajar, dan laporan secara lebih terstruktur. Platform dapat
                    digunakan untuk pelatihan internal, kelas publik, onboarding, pengembangan kompetensi, maupun program
                    pembelajaran berkelanjutan.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="#fitur">Jelajahi Fitur <span class="icon-arrow">→</span></a>
                    <a class="btn btn-outline" href="#konsultasi">Diskusikan Implementasi</a>
                </div>
                <div class="hero-proof">
                    <span class="proof-item"><span class="proof-icon">✓</span>Manajemen belajar terpusat</span>
                    <span class="proof-item"><span class="proof-icon">✓</span>Asesmen dan pelaporan</span>
                    <span class="proof-item"><span class="proof-icon">✓</span>Dapat disesuaikan bertahap</span>
                </div>
            </div>
            <div aria-label="Ilustrasi Learning Management System Bankir Academy" class="hero-visual">
                <div class="visual-main">
                    <div class="dashboard">
                        <div class="dash-top">
                            <div class="dash-brand"><svg aria-hidden="true" height="31" width="31">
                                    <use href="#logo-ba"></use>
                                </svg>LEARNING MANAGEMENT SYSTEM</div>
                            <div class="dash-dots"><span></span><span></span><span></span></div>
                        </div>
                        <div class="dash-hero">
                            <div class="dash-label">Integrated Learning Workspace</div>
                            <h3>Learn. Assess. Track. Improve.</h3>
                            <p>Satu ruang kerja digital untuk mengatur perjalanan belajar, memantau progres, dan
                                menindaklanjuti hasil pembelajaran.</p>
                            <div class="dash-stats">
                                <div class="dash-stat"><strong>24/7</strong><span>Akses pembelajaran</span></div>
                                <div class="dash-stat"><strong>Centralized</strong><span>Data dan materi terpusat</span>
                                </div>
                                <div class="dash-stat"><strong>Trackable</strong><span>Progres dapat dipantau</span></div>
                            </div>
                        </div>
                        <div class="dash-grid">
                            <div class="dash-card">
                                <h4>Course Completion</h4>
                                <div class="progress"><span class="width-78"></span></div>
                                <div class="mini-list mini-list-spaced">
                                    <div class="mini-row"><i></i><span>Video dan e-book</span></div>
                                    <div class="mini-row"><i class="dot-accent"></i><span>Kuis dan tugas</span></div>
                                    <div class="mini-row"><i class="dot-primary"></i><span>Sertifikat penyelesaian</span>
                                    </div>
                                </div>
                            </div>
                            <div class="dash-card">
                                <h4>Admin Insight</h4>
                                <div class="mini-list">
                                    <div class="mini-row"><i></i><span>Aktivitas peserta</span></div>
                                    <div class="mini-row"><i class="dot-primary"></i><span>Nilai asesmen</span></div>
                                    <div class="mini-row"><i class="dot-accent"></i><span>Status kelas</span></div>
                                    <div class="mini-row"><i class="dot-danger"></i><span>Laporan program</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="float-card one"><span class="float-icon">▶</span><span><strong>Digital
                            Course</strong><small>Materi belajar terstruktur</small></span></div>
                <div class="float-card two"><span class="float-icon">✓</span><span><strong>Assessment</strong><small>Kuis,
                            tugas, dan evaluasi</small></span></div>
                <div class="float-card three"><span class="float-icon">▦</span><span><strong>Learning
                            Report</strong><small>Insight untuk administrator</small></span></div>
            </div>
        </div>
    </section>
    <div class="trust-strip">
        <div class="container trust-inner">
            <div class="trust-copy"><strong>Dapat digunakan untuk berbagai skenario pembelajaran</strong><span>Konfigurasi
                    platform mengikuti kebutuhan pengguna, struktur program, materi, dan proses administrasi
                    institusi.</span></div>
            <div class="trust-item"><span class="trust-mark">O</span>Onboarding</div>
            <div class="trust-item"><span class="trust-mark">C</span>Compliance</div>
            <div class="trust-item"><span class="trust-mark">S</span>Skill Development</div>
            <div class="trust-item"><span class="trust-mark">P</span>Public Class</div>
        </div>
    </div>
    <section class="section" id="kebutuhan">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Mengapa LMS Dibutuhkan',
                'title' => 'Pembelajaran Digital Memerlukan Sistem, Bukan Hanya Kumpulan Materi',
                'description' =>
                    'LMS membantu institusi memastikan peserta menerima materi yang tepat, mengikuti alur belajar yang jelas, menyelesaikan asesmen, dan menghasilkan data yang dapat digunakan untuk evaluasi program.',
            ])
            <div class="challenge-grid">
                <article class="challenge-card"><span class="challenge-no">01</span>
                    <h3>Materi Tersebar</h3>
                    <p>Video, dokumen, tautan, dan tugas berada di berbagai kanal sehingga sulit dikelola dan diperbarui
                        secara konsisten.</p>
                </article>
                <article class="challenge-card"><span class="challenge-no">02</span>
                    <h3>Progres Sulit Dipantau</h3>
                    <p>Administrator tidak memiliki gambaran yang jelas mengenai kehadiran, penyelesaian materi, nilai, dan
                        aktivitas peserta.</p>
                </article>
                <article class="challenge-card"><span class="challenge-no">03</span>
                    <h3>Administrasi Manual</h3>
                    <p>Pendaftaran, pembagian kelas, pengiriman materi, rekap nilai, sertifikat, dan pelaporan memerlukan
                        banyak pekerjaan berulang.</p>
                </article>
                <article class="challenge-card"><span class="challenge-no">04</span>
                    <h3>Tindak Lanjut Terbatas</h3>
                    <p>Data pembelajaran belum terhubung dengan rekomendasi pengembangan, pengulangan materi, atau program
                        lanjutan.</p>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-soft" id="fitur">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Fitur Utama',
                'title' => 'Komponen Inti untuk Mengelola Siklus Pembelajaran',
                'description' =>
                    'Fitur dapat diterapkan secara bertahap sesuai skala program, jumlah pengguna, struktur organisasi, dan integrasi yang diperlukan.',
            ])
            <div class="solution-grid">
                <article class="solution-card">
                    <div class="card-icon">▶</div>
                    <h3>Course Management</h3>
                    <p>Mengelola kelas, modul, video, e-book, dokumen, tautan, agenda, dan learning path dalam struktur yang
                        mudah dipahami.</p>
                    <ul>
                        <li>Kategori dan level pembelajaran</li>
                        <li>Prasyarat dan urutan modul</li>
                        <li>Jadwal serta masa akses</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">◎</div>
                    <h3>User &amp; Role Management</h3>
                    <p>Mengatur peserta, instruktur, reviewer, administrator, kelompok, unit kerja, dan hak akses
                        berdasarkan peran.</p>
                    <ul>
                        <li>Registrasi dan enrollment</li>
                        <li>Kelompok atau batch peserta</li>
                        <li>Akses berbasis kewenangan</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">✓</div>
                    <h3>Assessment &amp; Assignment</h3>
                    <p>Mendukung kuis, pre-test, post-test, tugas, studi kasus, pengumpulan jawaban, penilaian, dan umpan
                        balik.</p>
                    <ul>
                        <li>Bank soal dan pengacakan</li>
                        <li>Nilai otomatis atau manual</li>
                        <li>Batas waktu dan percobaan</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">▦</div>
                    <h3>Dashboard &amp; Reporting</h3>
                    <p>Menyajikan data aktivitas, progres, hasil asesmen, tingkat penyelesaian, dan status program untuk
                        kebutuhan pemantauan.</p>
                    <ul>
                        <li>Ringkasan peserta dan kelas</li>
                        <li>Ekspor data sesuai kebutuhan</li>
                        <li>Insight untuk tindak lanjut</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">🎓</div>
                    <h3>Certificate Management</h3>
                    <p>Menerbitkan sertifikat berdasarkan persyaratan program seperti kehadiran, penyelesaian materi, nilai,
                        atau persetujuan administrator.</p>
                    <ul>
                        <li>Template sertifikat</li>
                        <li>Nomor atau kode verifikasi</li>
                        <li>Riwayat penerbitan</li>
                    </ul>
                </article>
                <article class="solution-card">
                    <div class="card-icon">✦</div>
                    <h3>Engagement &amp; Notification</h3>
                    <p>Mendukung pengumuman, pengingat, forum, komentar, notifikasi, dan komunikasi program agar peserta
                        tetap terarah.</p>
                    <ul>
                        <li>Reminder aktivitas belajar</li>
                        <li>Pengumuman kelas</li>
                        <li>Interaksi peserta dan fasilitator</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>
    <section class="section" id="pengalaman">
        <div class="container method-wrap">
            <div class="method-panel"><span class="eyebrow">Learning Experience</span>
                <h3>Pengalaman Belajar yang Sederhana bagi Peserta</h3>
                <p>Peserta dapat melihat kelas yang diikuti, melanjutkan modul terakhir, mengakses materi, mengikuti
                    evaluasi, mengirim tugas, melihat hasil yang tersedia, dan mengunduh sertifikat sesuai ketentuan.</p>
                <div class="method-stat-grid">
                    <div class="method-stat"><strong>Responsive</strong><span>Nyaman digunakan melalui desktop, tablet, dan
                            perangkat mobile.</span></div>
                    <div class="method-stat"><strong>Structured</strong><span>Alur belajar, prasyarat, dan target
                            penyelesaian lebih jelas.</span></div>
                    <div class="method-stat"><strong>Accessible</strong><span>Konten disusun agar mudah ditemukan dan
                            digunakan sesuai hak akses.</span></div>
                    <div class="method-stat"><strong>Consistent</strong><span>Tampilan dan navigasi dibuat seragam di
                            seluruh program.</span></div>
                </div>
            </div>
            <div class="method-panel"><span class="eyebrow">Administrator Experience</span>
                <h3>Kontrol Program yang Lebih Terpusat</h3>
                <p>Administrator dapat membuat kelas, mengatur peserta, mempublikasikan materi, memantau progres, meninjau
                    hasil, menerbitkan sertifikat, dan menyusun laporan tanpa bergantung pada banyak kanal terpisah.</p>
                <div class="method-stat-grid">
                    <div class="method-stat"><strong>Enrollment</strong><span>Atur peserta individu, kelompok, batch, atau
                            unit kerja.</span></div>
                    <div class="method-stat"><strong>Monitoring</strong><span>Tinjau aktivitas, progres, nilai, dan status
                            penyelesaian.</span></div>
                    <div class="method-stat"><strong>Content Control</strong><span>Kelola versi, publikasi, dan masa
                            berlaku materi.</span></div>
                    <div class="method-stat"><strong>Reporting</strong><span>Gunakan data program untuk evaluasi dan tindak
                            lanjut.</span></div>
                </div>
            </div>
        </div>
    </section>
    <section class="section section-soft" id="implementasi">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Tahapan Implementasi',
                'title' => 'Penerapan Dilakukan Bertahap agar Sistem Sesuai dengan Proses Kerja',
                'description' =>
                    'Ruang lingkup setiap tahap disesuaikan dengan kebutuhan bisnis, kesiapan pengguna, data, konten, infrastruktur, serta integrasi yang disepakati.',
            ])
            <div class="steps">
                <article class="step"><span class="step-no">1</span>
                    <h3>Discovery</h3>
                    <p>Memetakan tujuan, jenis pengguna, skenario belajar, konten, alur administrasi, kebutuhan laporan, dan
                        kendala saat ini.</p>
                </article>
                <article class="step"><span class="step-no">2</span>
                    <h3>Configuration</h3>
                    <p>Mengatur struktur kelas, peran, hak akses, kategori, identitas visual, sertifikat, dan parameter
                        program.</p>
                </article>
                <article class="step"><span class="step-no">3</span>
                    <h3>Content &amp; Data Setup</h3>
                    <p>Menyiapkan akun pengguna, materi, soal, tugas, learning path, jadwal, dan data awal sesuai ruang
                        lingkup.</p>
                </article>
                <article class="step"><span class="step-no">4</span>
                    <h3>Testing &amp; Launch</h3>
                    <p>Melakukan uji fungsi, pelatihan administrator, pilot, perbaikan, peluncuran, dan pemantauan awal.</p>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-dark" id="keamanan">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Security &amp; Governance',
                'title' => 'Data, Akses, dan Operasional Dikelola secara Bertanggung Jawab',
                'description' =>
                    'Ketentuan teknis dan pengamanan mengikuti ruang lingkup implementasi, arsitektur, penyedia infrastruktur, klasifikasi data, serta kesepakatan para pihak.',
            ])
            <div class="deliverable-grid">
                <article class="deliverable"><i>⌁</i>
                    <h3>Access Control</h3>
                    <p>Hak akses ditetapkan berdasarkan peran agar pengguna hanya dapat melihat dan mengelola informasi yang
                        relevan.</p>
                </article>
                <article class="deliverable"><i>▤</i>
                    <h3>Data Management</h3>
                    <p>Jenis data, tujuan penggunaan, masa penyimpanan, ekspor, koreksi, dan penghapusan perlu ditetapkan
                        secara jelas.</p>
                </article>
                <article class="deliverable"><i>✓</i>
                    <h3>Audit Activity</h3>
                    <p>Aktivitas penting dapat dicatat sesuai kemampuan sistem untuk membantu penelusuran dan pengawasan
                        operasional.</p>
                </article>
                <article class="deliverable"><i>↻</i>
                    <h3>Backup &amp; Recovery</h3>
                    <p>Mekanisme pencadangan dan pemulihan disesuaikan dengan infrastruktur, layanan, dan tingkat kebutuhan
                        yang dipilih.</p>
                </article>
                <article class="deliverable"><i>◎</i>
                    <h3>Privacy Principle</h3>
                    <p>Pengelolaan data pribadi memperhatikan dasar pemrosesan, transparansi, akses terbatas, dan ketentuan
                        yang berlaku.</p>
                </article>
                <article class="deliverable"><i>⚙</i>
                    <h3>Operational Support</h3>
                    <p>Prosedur dukungan, pemeliharaan, perubahan, insiden, dan eskalasi dijelaskan dalam ruang lingkup
                        layanan.</p>
                </article>
            </div>
        </div>
    </section>
    <section class="section" id="paket">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Model Penggunaan',
                'title' => 'Pilih Konfigurasi Berdasarkan Kebutuhan Program',
                'description' =>
                    'Nama dan cakupan berikut merupakan gambaran layanan. Penawaran final ditentukan setelah kebutuhan, jumlah pengguna, fitur, konten, integrasi, dan dukungan dianalisis.',
            ])
            <div class="cards-3">
                <article class="service-card">
                    <div class="card-icon">▶</div><span class="tag tag-spaced">Program-Based</span>
                    <h3>LMS untuk Satu Program</h3>
                    <p>Cocok untuk seminar berseri, bootcamp, onboarding, sertifikasi internal, atau pelatihan dengan
                        periode tertentu.</p>
                    <ul class="card-list">
                        <li>Setup kelas dan peserta</li>
                        <li>Materi, asesmen, dan sertifikat</li>
                        <li>Laporan penyelesaian program</li>
                    </ul>
                </article>
                <article class="service-card">
                    <div class="card-icon">▦</div><span class="tag tag-spaced">Institutional</span>
                    <h3>LMS Institusi</h3>
                    <p>Digunakan untuk mengelola beberapa program, unit, kelompok pengguna, kurikulum, dan laporan dalam
                        satu lingkungan.</p>
                    <ul class="card-list">
                        <li>Struktur admin dan unit</li>
                        <li>Katalog serta learning path</li>
                        <li>Dashboard institusi</li>
                    </ul>
                </article>
                <article class="service-card">
                    <div class="card-icon">✦</div><span class="tag tag-spaced">Custom Development</span>
                    <h3>Pengembangan Khusus</h3>
                    <p>Untuk kebutuhan fitur, tampilan, workflow, integrasi, atau laporan tertentu yang memerlukan analisis
                        dan pengembangan tambahan.</p>
                    <ul class="card-list">
                        <li>Requirement dan prototype</li>
                        <li>Pengembangan serta pengujian</li>
                        <li>Dokumentasi dan handover</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-soft" id="output">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Output Implementasi',
                'title' => 'Dokumen dan Konfigurasi yang Mendukung Penggunaan Sistem',
                'description' =>
                    'Output aktual mengikuti paket, ruang lingkup, tahap implementasi, model layanan, dan tanggung jawab yang disepakati.',
            ])
            <div class="principle-grid">
                <article class="principle"><span>01</span>
                    <div><strong>Requirement Summary</strong>
                        <p>Ringkasan pengguna, proses, fitur, data, laporan, integrasi, dan batasan implementasi.</p>
                    </div>
                </article>
                <article class="principle"><span>02</span>
                    <div><strong>Configured Learning Portal</strong>
                        <p>Portal yang telah dikonfigurasi berdasarkan struktur program, identitas, peran, dan hak akses.
                        </p>
                    </div>
                </article>
                <article class="principle"><span>03</span>
                    <div><strong>Initial Content Setup</strong>
                        <p>Penataan materi, kelas, soal, tugas, atau data awal sesuai batas yang disepakati.</p>
                    </div>
                </article>
                <article class="principle"><span>04</span>
                    <div><strong>Administrator Guidance</strong>
                        <p>Panduan penggunaan dan pelatihan untuk administrator atau pengelola program.</p>
                    </div>
                </article>
                <article class="principle"><span>05</span>
                    <div><strong>Testing Record</strong>
                        <p>Catatan pengujian fungsi, isu, perbaikan, dan penerimaan berdasarkan skenario yang ditetapkan.
                        </p>
                    </div>
                </article>
                <article class="principle"><span>06</span>
                    <div><strong>Support Arrangement</strong>
                        <p>Ketentuan bantuan operasional, pemeliharaan, perubahan, dan eskalasi setelah peluncuran.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>
    <section class="section" id="ketentuan">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Prinsip &amp; Ketentuan',
                'title' => 'Ruang Lingkup Sistem Harus Jelas Sejak Awal',
                'description' =>
                    'Spesifikasi final, biaya, kapasitas, jadwal, layanan pihak ketiga, kepemilikan, dan tanggung jawab dituangkan dalam proposal atau perjanjian.',
            ])
            <div class="principle-grid">
                <article class="principle"><span>✓</span>
                    <div><strong>Fitur Berdasarkan Kesepakatan</strong>
                        <p>Tidak seluruh fitur, integrasi, kapasitas, dan layanan otomatis termasuk dalam setiap paket.</p>
                    </div>
                </article>
                <article class="principle"><span>✓</span>
                    <div><strong>Konten Menjadi Tanggung Jawab Bersama</strong>
                        <p>Materi, data, gambar, soal, dan dokumen yang disediakan harus sah digunakan dan telah melalui
                            persetujuan pihak berwenang.</p>
                    </div>
                </article>
                <article class="principle"><span>✓</span>
                    <div><strong>Data Pengguna Terbatas</strong>
                        <p>Pengumpulan data dibatasi pada kebutuhan program dan dikelola sesuai akses, tujuan, serta
                            ketentuan yang berlaku.</p>
                    </div>
                </article>
                <article class="principle"><span>✓</span>
                    <div><strong>Integrasi Memerlukan Analisis</strong>
                        <p>Integrasi dengan HRIS, SSO, pembayaran, video conference, atau sistem lain bergantung pada API,
                            keamanan, dan kesiapan pihak terkait.</p>
                    </div>
                </article>
                <article class="principle"><span>✓</span>
                    <div><strong>Ketersediaan Layanan</strong>
                        <p>Target ketersediaan, pemeliharaan, dukungan, dan penanganan gangguan mengikuti model hosting
                            serta service level yang disepakati.</p>
                    </div>
                </article>
                <article class="principle"><span>✓</span>
                    <div><strong>Tidak Menggantikan Keputusan Institusi</strong>
                        <p>Nilai, sertifikat, rekomendasi, dan data LMS menjadi alat bantu; keputusan kelulusan, promosi,
                            atau kompetensi tetap berada pada pihak berwenang.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>
    <section class="section section-soft" id="faq">
        <div class="container">@include('frontend.components.section-head', [
            'eyebrow' => 'Pertanyaan Umum',
            'title' => 'Informasi Awal Learning Management System',
            'description' =>
                'Jawaban berikut memberikan gambaran umum sebelum kebutuhan teknis dan komersial dianalisis lebih lanjut.',
        ])<div class="faq-wrap">
                <article class="faq-item"><button class="faq-q" type="button">Apakah LMS dapat menggunakan identitas
                        institusi?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Dapat, sesuai ruang lingkup. Penyesuaian dapat meliputi logo, warna, nama portal,
                        banner, domain atau subdomain, dan elemen visual lainnya.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Apakah LMS dapat digunakan melalui
                        ponsel?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Tampilan web dirancang responsif untuk desktop, tablet, dan ponsel. Ketersediaan
                        aplikasi khusus bergantung pada paket dan kebutuhan pengembangan.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Apakah materi lama dapat dipindahkan ke
                        LMS?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Dapat dianalisis. Proses migrasi bergantung pada format, jumlah, kualitas,
                        struktur, hak penggunaan, dan kesiapan data sumber.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Apakah tersedia sertifikat otomatis?<span
                            class="faq-plus">＋</span></button>
                    <div class="faq-a">Dapat disediakan dengan aturan tertentu, misalnya penyelesaian seluruh modul, nilai
                        minimum, kehadiran, atau persetujuan administrator.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Apakah LMS dapat diintegrasikan dengan
                        sistem lain?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Integrasi dapat dipertimbangkan setelah meninjau kebutuhan, keamanan, dokumentasi
                        API, hak akses, data yang dipertukarkan, biaya, dan tanggung jawab masing-masing pihak.</div>
                </article>
                <article class="faq-item"><button class="faq-q" type="button">Informasi apa yang diperlukan untuk
                        mendapatkan penawaran?<span class="faq-plus">＋</span></button>
                    <div class="faq-a">Sampaikan tujuan penggunaan, jumlah pengguna, jenis kelas, jumlah materi, kebutuhan
                        asesmen, sertifikat, laporan, identitas visual, integrasi, model hosting, jadwal, dan dukungan yang
                        diharapkan.</div>
                </article>
            </div>
        </div>
    </section>
    <section class="final-cta" id="konsultasi">
        <div class="container">
            <div class="cta-box">
                <div>
                    <h2>Bangun Ekosistem Pembelajaran Digital yang Lebih Terstruktur</h2>
                    <p>Sampaikan tujuan, jumlah pengguna, jenis program, kebutuhan fitur, konten, laporan, integrasi, dan
                        jadwal. Tim Bankir Academy akan membantu menyusun gambaran implementasi awal.</p>
                </div>
                <div class="cta-actions"><a class="btn btn-light"
                        href="mailto:info@bankiracademy.co.id?subject=Konsultasi%20Learning%20Management%20System">Email
                        Konsultasi</a><a class="btn btn-secondary" href="#fitur">Lihat Fitur LMS</a></div>
            </div>
        </div>
    </section>
@endsection
