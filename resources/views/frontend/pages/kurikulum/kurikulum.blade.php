@extends('layouts.appfrontend')

@section('page-title')
Kurikulum — Bankir Academy
@endsection

@section('page-description')
Kurikulum Bankir Academy adalah sistem pembelajaran terintegrasi untuk kompetensi perbankan, talenta, kepemimpinan, teknologi, inovasi, karier, dan pemberdayaan.
@endsection

@section('content')
<section class="hero curriculum-hero" id="ringkasan">
<div class="container hero-grid">
<div>
<span class="eyebrow">Bankir Academy Curriculum System</span>
<h1>Kurikulum Terintegrasi untuk <span class="gradient-text">Kompetensi, Talenta, dan Transformasi</span></h1>
<p class="hero-lead">Kurikulum Bankir Academy dirancang sebagai sistem pembelajaran berjenjang yang menghubungkan kebutuhan individu dan organisasi dengan kompetensi perbankan, bisnis, kepemimpinan, teknologi, inovasi, serta pemberdayaan. Setiap program dapat dikembangkan menjadi kelas mandiri, pelatihan institusi, learning path, bootcamp, pendampingan, atau program transformasi.</p>
<div class="hero-actions">
<a class="btn btn-primary" href="#rumpun">Jelajahi Kurikulum <span class="icon-arrow">→</span></a>
<a class="btn btn-outline" href="#konsultasi">Susun Program Khusus</a>
</div>
<div class="hero-proof">
<span class="proof-item"><span class="proof-icon">✓</span>Berbasis kebutuhan dan peran</span>
<span class="proof-item"><span class="proof-icon">✓</span>Berjenjang dari dasar hingga strategis</span>
<span class="proof-item"><span class="proof-icon">✓</span>Dapat diukur dan ditindaklanjuti</span>
</div>
</div>
<div aria-label="Ilustrasi sistem kurikulum Bankir Academy" class="hero-visual">
<div class="visual-main"><div class="curriculum-board">
<div class="curriculum-board-head"><span>CURRICULUM ARCHITECTURE</span><span>Integrated System</span></div>
<div class="curriculum-focus"><small>Learning &amp; Capability Framework</small><h3>Learn. Apply. Perform. Lead.</h3><p>Satu arsitektur untuk memetakan level, rumpun kompetensi, pengalaman belajar, asesmen, dan tindak lanjut.</p>
<div class="level-row"><div class="level-mini"><strong>Level 1</strong><span>Foundation</span></div><div class="level-mini"><strong>Level 2</strong><span>Applied</span></div><div class="level-mini"><strong>Level 3</strong><span>Professional</span></div><div class="level-mini"><strong>Level 4</strong><span>Strategic</span></div></div>
</div>
<div class="curriculum-board-grid"><div class="curriculum-board-card"><strong>Competency Coverage</strong><span>Banking, risk, business, people, digital, innovation</span><div class="curriculum-meter"><i class="width-88"></i></div></div><div class="curriculum-board-card"><strong>Learning Evidence</strong><span>Assessment, practice, project, action plan, report</span><div class="curriculum-meter"><i class="width-81"></i></div></div></div>
</div></div>
<div class="float-card one"><span class="float-icon">▦</span><span><strong>Structured Path</strong><small>Level dan kompetensi jelas</small></span></div>
<div class="float-card two"><span class="float-icon">↗</span><span><strong>Applied Learning</strong><small>Praktik dan studi kasus</small></span></div>
<div class="float-card three"><span class="float-icon">◎</span><span><strong>Measurable Output</strong><small>Asesmen dan tindak lanjut</small></span></div>
</div>
</div>
</section>
<div class="quick-nav"><div class="container quick-nav-inner">
<a href="#level"><i>1</i><span><strong>Level Kompetensi</strong><span>Empat tahapan belajar</span></span></a>
<a href="#rumpun"><i>2</i><span><strong>Rumpun Kurikulum</strong><span>Enam area utama</span></span></a>
<a href="#jalur"><i>3</i><span><strong>Jalur Peserta</strong><span>Sesuai peran dan tujuan</span></span></a>
<a href="#arsitektur"><i>4</i><span><strong>Learning Journey</strong><span>Dari analisis hingga tindak lanjut</span></span></a>
<a href="#ekosistem"><i>5</i><span><strong>Ekosistem Program</strong><span>Terhubung seluruh layanan</span></span></a>
</div></div>
<section class="section" id="level"><div class="container">
@include('frontend.components.section-head', [
    'eyebrow' => 'Level Kompetensi',
    'title' => 'Pembelajaran Berjenjang dari Pemahaman Dasar hingga Keputusan Strategis',
    'description' => 'Level digunakan untuk menyesuaikan kedalaman materi, kompleksitas studi kasus, bentuk praktik, metode evaluasi, dan tanggung jawab peserta dalam organisasi.',
])
<div class="level-grid">
<article class="level-card"><div class="level-badge">L1</div><h3>Foundation</h3><p>Membangun pemahaman konsep, istilah, proses, sikap, dan standar kerja dasar.</p><ul class="clean-list"><li>Pelajar, mahasiswa, fresh graduate</li><li>Pegawai baru dan fungsi pendukung</li><li>Kuis serta latihan dasar</li></ul></article>
<article class="level-card"><div class="level-badge">L2</div><h3>Applied</h3><p>Menerapkan pengetahuan dalam tugas rutin, simulasi, dan pemecahan masalah operasional.</p><ul class="clean-list"><li>Officer dan staf berpengalaman</li><li>Studi kasus serta praktik kerja</li><li>Checklist dan action plan</li></ul></article>
<article class="level-card"><div class="level-badge">L3</div><h3>Professional</h3><p>Menganalisis permasalahan, mengelola risiko, dan meningkatkan proses atau kinerja unit.</p><ul class="clean-list"><li>Supervisor dan manajer</li><li>Project, coaching, dan review</li><li>Rekomendasi perbaikan</li></ul></article>
<article class="level-card"><div class="level-badge">L4</div><h3>Strategic</h3><p>Memimpin perubahan, merancang kebijakan, mengambil keputusan, dan memastikan keberlanjutan.</p><ul class="clean-list"><li>Pimpinan dan future leader</li><li>Executive discussion</li><li>Strategic roadmap</li></ul></article>
</div>
</div></section>
<section class="section section-soft" id="rumpun"><div class="container">
@include('frontend.components.section-head', [
    'eyebrow' => 'Rumpun Kurikulum',
    'title' => 'Enam Rumpun yang Mencakup Seluruh Sistem Bankir Academy',
    'description' => 'Setiap rumpun dapat berdiri sendiri atau digabungkan menjadi learning path lintas fungsi sesuai kebutuhan peserta dan institusi.',
])
<div class="domain-grid">
<article class="domain-card"><div class="domain-icon">▦</div><h3>Banking Fundamentals &amp; Operations</h3><p>Dasar industri, produk, proses operasional, layanan, administrasi, fungsi jabatan, dan etika kerja perbankan.</p><div class="domain-topics"><span>General Banking</span><span>Operasional</span><span>Produk</span><span>Layanan</span><span>Etika</span></div></article>
<article class="domain-card"><div class="domain-icon">◎</div><h3>Risk, Compliance &amp; Governance</h3><p>Manajemen risiko, kepatuhan, APU-PPT, anti-fraud, audit, tata kelola, pelindungan data, dan teknologi informasi.</p><div class="domain-topics"><span>Risk</span><span>Compliance</span><span>Audit</span><span>Fraud</span><span>Governance</span></div></article>
<article class="domain-card"><div class="domain-icon">↗</div><h3>Business, Credit &amp; Customer Growth</h3><p>Kredit, pembiayaan, pemasaran, penjualan, CRM, pengembangan produk, UMKM, dan pemulihan kualitas aset.</p><div class="domain-topics"><span>Credit</span><span>Marketing</span><span>CRM</span><span>UMKM</span><span>Growth</span></div></article>
<article class="domain-card"><div class="domain-icon">◇</div><h3>Human Capital &amp; Leadership</h3><p>Rekrutmen, talent management, KPI, OKR, workload analysis, leadership, budaya, dan kesiapan suksesi.</p><div class="domain-topics"><span>Talent</span><span>KPI</span><span>Leadership</span><span>HR Analytics</span><span>Culture</span></div></article>
<article class="domain-card"><div class="domain-icon">✦</div><h3>Digital, Data &amp; Technology</h3><p>Digital banking, sistem informasi, keamanan, data, dashboard, automasi, LMS, AI, dan produktivitas digital.</p><div class="domain-topics"><span>Digital</span><span>Data</span><span>AI</span><span>Automation</span><span>LMS</span></div></article>
<article class="domain-card"><div class="domain-icon">♡</div><h3>Career, Education &amp; Empowerment</h3><p>Persiapan calon bankir, literasi keuangan, pendidikan industri, kewirausahaan, pemberdayaan UMKM, dan program sosial.</p><div class="domain-topics"><span>Career Ready</span><span>Literasi</span><span>Pendidikan</span><span>UMKM</span><span>CSR</span></div></article>
</div>
</div></section>
<section class="section" id="jalur"><div class="container">
@include('frontend.components.section-head', [
    'eyebrow' => 'Jalur Pembelajaran',
    'title' => 'Learning Path Disesuaikan dengan Profil dan Tujuan Peserta',
    'description' => 'Kurikulum tidak menggunakan satu jalur untuk semua. Setiap peserta atau kelompok dapat memperoleh kombinasi materi, praktik, dan tindak lanjut yang berbeda.',
])
<div class="path-grid">
<article class="path-card"><div class="path-head"><span class="path-no">01</span><h3>Calon Bankir</h3></div><p>Dasar perbankan, kesiapan karier, komunikasi, CV, wawancara, etika kerja, dan 90 hari pertama.</p></article>
<article class="path-card"><div class="path-head"><span class="path-no">02</span><h3>Entry-Level Banker</h3></div><p>Produk, layanan, operasional, administrasi, risiko dasar, kepatuhan, dan produktivitas kerja.</p></article>
<article class="path-card"><div class="path-head"><span class="path-no">03</span><h3>Professional &amp; Specialist</h3></div><p>Pendalaman fungsi kredit, risiko, audit, kepatuhan, IT, marketing, HR, keuangan, atau bidang spesialis lain.</p></article>
<article class="path-card"><div class="path-head"><span class="path-no">04</span><h3>Supervisor &amp; Manager</h3></div><p>Pengelolaan tim, KPI, problem solving, coaching, monitoring, pengendalian, dan perbaikan proses.</p></article>
<article class="path-card"><div class="path-head"><span class="path-no">05</span><h3>Leadership &amp; Executive</h3></div><p>Strategi, tata kelola, transformasi, pengambilan keputusan, risiko strategis, budaya, dan kesinambungan bisnis.</p></article>
<article class="path-card"><div class="path-head"><span class="path-no">06</span><h3>UMKM &amp; Community</h3></div><p>Keuangan usaha, pemasaran, digitalisasi, kesiapan pembiayaan, layanan, dan pengembangan usaha bertahap.</p></article>
</div>
</div></section>
<section class="section section-soft" id="arsitektur"><div class="container architecture-wrap">
<div class="architecture-panel"><span class="eyebrow">Learning Architecture</span><h3>Dari Kebutuhan hingga Perubahan yang Dapat Ditinjau</h3><p>Setiap program dapat menggunakan seluruh tahapan atau bagian tertentu sesuai lingkup, durasi, target, data yang tersedia, dan kesiapan organisasi.</p><div class="architecture-stats"><div class="architecture-stat"><strong>Needs-Based</strong><span>Dimulai dari kebutuhan yang jelas</span></div><div class="architecture-stat"><strong>Outcome-Oriented</strong><span>Output dan indikator ditetapkan</span></div><div class="architecture-stat"><strong>Applied</strong><span>Praktik dekat dengan pekerjaan</span></div><div class="architecture-stat"><strong>Reviewable</strong><span>Hasil dapat dievaluasi</span></div></div></div>
<div class="journey-list">
<article class="journey-item"><span class="journey-no">1</span><div><h3>Needs &amp; Competency Analysis</h3><p>Memetakan tujuan, peserta, peran, gap kompetensi, risiko, dan konteks organisasi.</p></div></article>
<article class="journey-item"><span class="journey-no">2</span><div><h3>Curriculum &amp; Learning Design</h3><p>Menetapkan level, topik, metode, durasi, fasilitator, praktik, dan indikator keberhasilan.</p></div></article>
<article class="journey-item"><span class="journey-no">3</span><div><h3>Learning Delivery</h3><p>Melaksanakan kelas, workshop, simulasi, coaching, mentoring, digital learning, atau blended program.</p></div></article>
<article class="journey-item"><span class="journey-no">4</span><div><h3>Assessment &amp; Evidence</h3><p>Mengumpulkan bukti melalui kuis, tugas, studi kasus, proyek, observasi, atau action plan.</p></div></article>
<article class="journey-item"><span class="journey-no">5</span><div><h3>Review &amp; Follow-up</h3><p>Menyusun laporan, rekomendasi, rencana pengembangan, monitoring, dan program lanjutan.</p></div></article>
</div>
</div></section>
<section class="section" id="format"><div class="container">
@include('frontend.components.section-head', [
    'eyebrow' => 'Format Pembelajaran',
    'title' => 'Fleksibel untuk Kebutuhan Individu, Institusi, dan Komunitas',
    'description' => 'Format dipilih berdasarkan tujuan, jumlah peserta, lokasi, kesiapan teknologi, kebutuhan praktik, dan intensitas pendampingan.',
])
<div class="format-grid">
<article class="format-card"><i>▶</i><h3>Self-Paced Learning</h3><p>Video, e-book, kuis, tugas, dan materi digital yang dipelajari mandiri melalui LMS.</p></article>
<article class="format-card"><i>▦</i><h3>Live Class &amp; Webinar</h3><p>Kelas interaktif daring atau tatap muka dengan fasilitator dan sesi diskusi.</p></article>
<article class="format-card"><i>◎</i><h3>Workshop &amp; Simulation</h3><p>Latihan, studi kasus, role play, simulasi proses, serta penyusunan perangkat kerja.</p></article>
<article class="format-card"><i>◇</i><h3>Coaching &amp; Mentoring</h3><p>Pendampingan terarah untuk penerapan, pemecahan masalah, dan monitoring progres.</p></article>
</div>
</div></section>
<section class="section section-dark" id="asesmen"><div class="container">
@include('frontend.components.section-head', [
    'eyebrow' => 'Assessment &amp; Learning Evidence',
    'title' => 'Evaluasi Tidak Hanya Mengukur Kehadiran',
    'description' => 'Jenis evaluasi disesuaikan dengan tujuan program dan tidak otomatis menjadi sertifikasi profesi atau jaminan kompetensi tanpa skema yang relevan.',
])
<div class="assessment-grid">
<article class="assessment-card"><i>01</i><h3>Diagnostic</h3><p>Pre-test, survei, wawancara, atau pemetaan awal untuk memahami kebutuhan peserta.</p></article>
<article class="assessment-card"><i>02</i><h3>Knowledge</h3><p>Kuis, post-test, pertanyaan reflektif, dan pemahaman konsep utama.</p></article>
<article class="assessment-card"><i>03</i><h3>Application</h3><p>Studi kasus, tugas, simulasi, proyek, demonstrasi, dan action plan.</p></article>
<article class="assessment-card"><i>04</i><h3>Follow-up</h3><p>Umpan balik, monitoring penerapan, laporan progres, dan rekomendasi pengembangan.</p></article>
</div>
</div></section>
<section class="section section-soft" id="ekosistem"><div class="container">
@include('frontend.components.section-head', [
    'eyebrow' => 'Ekosistem Kurikulum',
    'title' => 'Terhubung dengan Seluruh Layanan Bankir Academy',
    'description' => 'Kurikulum menjadi fondasi bersama agar layanan konsultasi, pengembangan talenta, teknologi pembelajaran, inovasi, dan pemberdayaan memiliki arah kompetensi yang konsisten.',
])
<div class="ecosystem-grid">
<article class="ecosystem-card"><div class="domain-icon">▦</div><h3>Banking Solution</h3><p>Kurikulum mendukung transfer pengetahuan, implementasi perangkat kerja, dan penguatan kemampuan tim saat solusi diterapkan.</p><a href="{{ route('frontend.service.banking-solution') }}">Lihat Banking Solution →</a></article>
<article class="ecosystem-card"><div class="domain-icon">↗</div><h3>Capacity Building</h3><p>Menjadi dasar penyusunan in-house training, public class, workshop, coaching, dan blended learning.</p><a href="{{ route('frontend.service.capacity-building') }}">Lihat Capacity Building →</a></article>
<article class="ecosystem-card"><div class="domain-icon">◇</div><h3>Banking Talent Solution</h3><p>Menghubungkan competency mapping, learning path, individual development plan, dan succession readiness.</p><a href="{{ route('frontend.service.banking-talent') }}">Lihat Talent Solution →</a></article>
<article class="ecosystem-card"><div class="domain-icon">▶</div><h3>Learning Management System</h3><p>Mendistribusikan materi, mengelola peserta, asesmen, sertifikat, progres, dan pelaporan pembelajaran.</p><a href="{{ route('frontend.service.lms') }}">Lihat LMS →</a></article>
<article class="ecosystem-card"><div class="domain-icon">✦</div><h3>Inovasi Program</h3><p>Menguji format baru, prototipe pembelajaran, automasi, dashboard, dan pemanfaatan AI secara bertanggung jawab.</p><a href="{{ route('frontend.service.innovation') }}">Lihat Inovasi Program →</a></article>
<article class="ecosystem-card"><div class="domain-icon">♡</div><h3>CSR &amp; Foundations</h3><p>Menyesuaikan materi bagi pelajar, calon bankir, komunitas, dan UMKM dengan indikator dampak yang proporsional.</p><a href="{{ route('frontend.service.csr') }}">Lihat Program CSR →</a></article>
</div>
</div></section>
<section class="section" id="standar"><div class="container">
@include('frontend.components.section-head', [
    'eyebrow' => 'Prinsip Kurikulum',
    'title' => 'Standar Penyusunan dan Pengelolaan Program',
    'description' => 'Prinsip berikut digunakan untuk menjaga relevansi, keterukuran, konsistensi, dan tanggung jawab dalam pengembangan program.',
])
<div class="principle-grid">
<article class="principle-card"><strong>Relevan</strong><p>Materi disesuaikan dengan peran, industri, kebutuhan peserta, dan konteks organisasi.</p></article>
<article class="principle-card"><strong>Terstruktur</strong><p>Tujuan, level, urutan, metode, praktik, dan evaluasi dirancang secara jelas.</p></article>
<article class="principle-card"><strong>Terapan</strong><p>Pembelajaran mengutamakan contoh, simulasi, studi kasus, dan alat kerja yang dapat digunakan.</p></article>
<article class="principle-card"><strong>Terukur</strong><p>Indikator, bukti pembelajaran, umpan balik, dan laporan ditetapkan secara proporsional.</p></article>
</div>
</div></section>
<section class="section section-soft" id="faq"><div class="container">
@include('frontend.components.section-head', [
    'eyebrow' => 'Pertanyaan Umum',
    'title' => 'FAQ Kurikulum Bankir Academy',
    'description' => 'Informasi dasar mengenai penyesuaian, level, sertifikat, dan implementasi kurikulum.',
])
<div class="faq-wrap">
<article class="faq-item"><button class="faq-q" type="button">Apakah kurikulum dapat disesuaikan untuk BPR atau BPRS tertentu?<span class="faq-plus">＋</span></button><div class="faq-a">Ya. Penyesuaian dapat dilakukan berdasarkan tujuan, jabatan peserta, kebutuhan kompetensi, kebijakan internal, durasi, dan ruang lingkup yang disepakati.</div></article>
<article class="faq-item"><button class="faq-q" type="button">Apakah satu program harus mengikuti seluruh level?<span class="faq-plus">＋</span></button><div class="faq-a">Tidak. Level dipilih berdasarkan profil peserta dan hasil yang ingin dicapai. Satu program dapat menggunakan satu level atau membentuk jalur bertahap lintas level.</div></article>
<article class="faq-item"><button class="faq-q" type="button">Apakah semua program mendapatkan sertifikat?<span class="faq-plus">＋</span></button><div class="faq-a">Sertifikat mengikuti ketentuan masing-masing program, seperti kehadiran, penyelesaian materi, tugas, atau asesmen. Sertifikat tidak otomatis menjadi lisensi profesi.</div></article>
<article class="faq-item"><button class="faq-q" type="button">Apakah kurikulum dapat dimasukkan ke LMS institusi?<span class="faq-plus">＋</span></button><div class="faq-a">Dapat, dengan memperhatikan format konten, hak penggunaan, struktur platform, migrasi, keamanan, dan ruang lingkup implementasi yang disepakati.</div></article>
<article class="faq-item"><button class="faq-q" type="button">Bagaimana program khusus disusun?<span class="faq-plus">＋</span></button><div class="faq-a">Proses dimulai dari diskusi kebutuhan, pemetaan peserta dan kompetensi, penyusunan desain program, penetapan metode serta evaluasi, lalu finalisasi proposal pelaksanaan.</div></article>
</div>
</div></section>
<section class="final-cta" id="konsultasi"><div class="container"><div class="cta-box"><div><h2>Bangun Kurikulum yang Sesuai dengan Kebutuhan Anda</h2><p>Diskusikan profil peserta, kompetensi prioritas, format pembelajaran, durasi, dan hasil yang ingin dicapai bersama Bankir Academy.</p></div><div class="cta-actions"><a class="btn btn-light" href="{{ route('frontend.support.contact') }}">Konsultasikan Kurikulum</a><a class="btn btn-secondary" href="mailto:info@bankiracademy.co.id">Kirim Email</a></div></div></div></section>

@endsection
