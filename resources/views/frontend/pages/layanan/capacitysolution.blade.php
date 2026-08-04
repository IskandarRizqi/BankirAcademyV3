@extends('layouts.appfrontend')

@section('page-title')
Capacity Building — Bankir Academy
@endsection

@section('page-description')
Capacity Building Bankir Academy menyediakan program pelatihan, workshop, coaching, asesmen, dan blended learning untuk pengembangan kompetensi sektor perbankan.
@endsection

@section('content')
<section class="hero solution-hero" id="ringkasan">
<div class="container hero-grid">
<div>
<span class="eyebrow">People Development for Banking Excellence</span>
<h1>Mengembangkan Kompetensi untuk <span class="gradient-text">Kinerja yang Lebih Unggul</span></h1>
<p class="hero-lead">Capacity Building Bankir Academy membantu bank, BPR/BPRS, lembaga keuangan, sekolah, kampus, dan organisasi mitra merancang program peningkatan kompetensi yang relevan, terukur, serta sesuai kebutuhan peserta dan sasaran organisasi.</p>
<div class="hero-actions">
<a class="btn btn-primary" href="#program">Jelajahi Program <span class="icon-arrow">→</span></a>
<a class="btn btn-outline" href="#konsultasi">Diskusikan Kebutuhan</a>
</div>
<div class="hero-proof">
<span class="proof-item"><span class="proof-icon">✓</span>Berbasis kebutuhan kompetensi</span>
<span class="proof-item"><span class="proof-icon">✓</span>Daring, luring, dan blended</span>
<span class="proof-item"><span class="proof-icon">✓</span>Evaluasi dan tindak lanjut</span>
</div>
</div>
<div aria-label="Ilustrasi program pengembangan kompetensi" class="hero-visual">
<div class="visual-main"><div class="dashboard">
<div class="dash-top"><div class="dash-brand"><svg aria-hidden="true" height="31" width="31"><use href="#logo-ba"></use></svg>CAPACITY BUILDING</div><div class="dash-dots"><span></span><span></span><span></span></div></div>
<div class="dash-hero"><div class="dash-label">Competency Development Journey</div><h3>Assess. Learn. Apply. Improve.</h3><p>Pengembangan kompetensi yang menghubungkan kebutuhan jabatan, proses belajar, praktik kerja, dan evaluasi hasil.</p>
<div class="dash-stats"><div class="dash-stat"><strong>Custom</strong><span>Kurikulum sesuai kebutuhan</span></div><div class="dash-stat"><strong>Blended</strong><span>Fleksibel dan terintegrasi</span></div><div class="dash-stat"><strong>Measured</strong><span>Evaluasi proporsional</span></div></div>
</div>
<div class="dash-grid"><div class="dash-card"><h4>Learning Progress</h4><div class="progress"><span class="width-82"></span></div><div class="mini-list mini-list-spaced"><div class="mini-row"><i></i><span>Knowledge improvement</span></div><div class="mini-row"><i class="dot-accent"></i><span>Practice assignment</span></div><div class="mini-row"><i class="dot-primary"></i><span>Action plan</span></div></div></div><div class="dash-card"><h4>Learning Modes</h4><div class="mini-list"><div class="mini-row"><i></i><span>In-house training</span></div><div class="mini-row"><i class="dot-primary"></i><span>Public class</span></div><div class="mini-row"><i class="dot-accent"></i><span>Workshop &amp; coaching</span></div><div class="mini-row"><i class="dot-danger"></i><span>Digital learning</span></div></div></div></div>
</div></div>
<div class="float-card one"><span class="float-icon">🎓</span><span><strong>Custom Curriculum</strong><small>Sesuai gap kompetensi</small></span></div>
<div class="float-card two"><span class="float-icon">↗</span><span><strong>Action Learning</strong><small>Belajar melalui praktik</small></span></div>
<div class="float-card three"><span class="float-icon">✓</span><span><strong>Evaluation</strong><small>Hasil dapat ditinjau</small></span></div>
</div>
</div>
</section>
<div class="trust-strip"><div class="container trust-inner"><div class="trust-copy"><strong>Program untuk berbagai level dan kebutuhan</strong><span>Ruang lingkup disusun berdasarkan sasaran, peserta, konteks kerja, dan dukungan organisasi.</span></div><div class="trust-item"><span class="trust-mark">E</span>Entry Level</div><div class="trust-item"><span class="trust-mark">S</span>Staff &amp; Officer</div><div class="trust-item"><span class="trust-mark">M</span>Manager</div><div class="trust-item"><span class="trust-mark">L</span>Leadership</div></div></div>
<section class="section" id="kebutuhan"><div class="container">
@include('frontend.components.section-head', [
    'eyebrow' => 'Kebutuhan Pengembangan',
    'title' => 'Program Dimulai dari Kompetensi yang Benar-Benar Dibutuhkan',
    'description' => 'Materi tidak hanya dipilih karena sedang populer. Program dirancang dengan mempertimbangkan peran peserta, tantangan pekerjaan, target organisasi, tingkat pemahaman awal, dan perubahan perilaku yang diharapkan.',
])
<div class="challenge-grid">
<article class="challenge-card"><span class="challenge-no">01</span><h3>Gap Pengetahuan</h3><p>Peserta belum memahami konsep, regulasi, produk, proses, atau standar kerja yang dibutuhkan dalam perannya.</p></article>
<article class="challenge-card"><span class="challenge-no">02</span><h3>Gap Keterampilan</h3><p>Pengetahuan sudah tersedia, tetapi belum diterapkan secara konsisten dalam analisis, layanan, komunikasi, atau pengambilan keputusan.</p></article>
<article class="challenge-card"><span class="challenge-no">03</span><h3>Perubahan Peran</h3><p>Promosi, rotasi, transformasi proses, atau strategi baru menuntut kompetensi yang berbeda dari kebiasaan sebelumnya.</p></article>
<article class="challenge-card"><span class="challenge-no">04</span><h3>Kinerja Belum Berkelanjutan</h3><p>Pelatihan sebelumnya belum terhubung dengan praktik kerja, dukungan atasan, indikator, dan tindak lanjut yang jelas.</p></article>
</div>
</div></section>
<section class="section section-soft" id="program"><div class="container">
@include('frontend.components.section-head', [
    'eyebrow' => 'Pilihan Program',
    'title' => 'Format Pengembangan yang Fleksibel dan Terarah',
    'description' => 'Program dapat digunakan secara mandiri atau digabungkan menjadi learning journey sesuai tujuan, jumlah peserta, waktu, lokasi, dan kebutuhan organisasi.',
])
<div class="solution-grid">
<article class="solution-card"><div class="card-icon">▦</div><h3>In-House Training</h3><p>Pelatihan khusus bagi satu institusi dengan materi, studi kasus, dan contoh penerapan yang disesuaikan.</p><ul><li>Analisis kebutuhan awal</li><li>Kurikulum dan fasilitator relevan</li><li>Evaluasi serta rekomendasi tindak lanjut</li></ul></article>
<article class="solution-card"><div class="card-icon">◎</div><h3>Public Class</h3><p>Kelas terbuka untuk peserta lintas institusi dengan topik terpilih dan jadwal yang telah ditetapkan.</p><ul><li>Interaksi lintas pengalaman</li><li>Materi terstruktur dan praktis</li><li>Sertifikat sesuai ketentuan program</li></ul></article>
<article class="solution-card"><div class="card-icon">↗</div><h3>Workshop &amp; Simulation</h3><p>Pembelajaran aktif melalui latihan, pembahasan kasus, simulasi, dan penyusunan perangkat kerja.</p><ul><li>Case-based learning</li><li>Role play atau problem solving</li><li>Output kerja peserta</li></ul></article>
<article class="solution-card"><div class="card-icon">◇</div><h3>Coaching &amp; Mentoring</h3><p>Pendampingan individu atau kelompok untuk membantu penerapan pembelajaran dan penyelesaian tantangan kerja.</p><ul><li>Tujuan dan agenda terukur</li><li>Refleksi serta umpan balik</li><li>Action plan per sesi</li></ul></article>
<article class="solution-card"><div class="card-icon">▶</div><h3>Digital &amp; Blended Learning</h3><p>Kombinasi video, e-book, kuis, kelas virtual, forum, tugas, dan sesi tatap muka untuk pembelajaran yang lebih fleksibel.</p><ul><li>Learning path terstruktur</li><li>Progress dan assessment</li><li>Materi dapat dipelajari ulang</li></ul></article>
<article class="solution-card"><div class="card-icon">✦</div><h3>Leadership Development</h3><p>Program bagi supervisor, manajer, dan pimpinan untuk memperkuat kepemimpinan, eksekusi, komunikasi, serta pengambilan keputusan.</p><ul><li>Leadership competency</li><li>Business and people management</li><li>Strategic action project</li></ul></article>
</div>
</div></section>
<section class="section" id="area-kompetensi"><div class="container method-wrap">
<div class="method-panel"><span class="eyebrow">Competency Areas</span><h3>Topik Dapat Dikembangkan Sesuai Konteks Institusi</h3><p>Bankir Academy mengembangkan pembelajaran dari level fundamental hingga strategis, dengan tetap menyesuaikan kewenangan, regulasi, kebijakan, dan kondisi masing-masing organisasi.</p><div class="method-stat-grid"><div class="method-stat"><strong>Banking</strong><span>Operasional, kredit, risiko, kepatuhan</span></div><div class="method-stat"><strong>Business</strong><span>Marketing, layanan, target, UMKM</span></div><div class="method-stat"><strong>People</strong><span>Leadership, komunikasi, kinerja</span></div><div class="method-stat"><strong>Digital</strong><span>Teknologi, data, automasi, AI</span></div></div></div>
<div><div class="section-head left section-head-compact-26"><span class="eyebrow">Area Pembelajaran</span><h2>Kompetensi yang Relevan dengan Dunia Kerja</h2></div><div class="process-list">
<article class="process-item"><span class="process-number">1</span><div><h3>Banking, Risk &amp; Compliance</h3><p>Dasar perbankan, kredit, manajemen risiko, kepatuhan, audit, tata kelola, APU PPT, fraud, dan regulasi terkait.</p></div></article>
<article class="process-item"><span class="process-number">2</span><div><h3>Business, Service &amp; Marketing</h3><p>Penjualan, prospecting, customer experience, CRM, digital marketing, pengembangan produk, dan penguatan UMKM.</p></div></article>
<article class="process-item"><span class="process-number">3</span><div><h3>Human Capital &amp; Leadership</h3><p>KPI, OKR, talent management, komunikasi, public speaking, managerial skill, coaching, dan kepemimpinan.</p></div></article>
<article class="process-item"><span class="process-number">4</span><div><h3>Digital, Data &amp; Innovation</h3><p>Transformasi digital, teknologi informasi, keamanan, data, dashboard, automasi proses, dan penggunaan AI secara bertanggung jawab.</p></div></article>
</div></div>
</div></section>
<section class="section section-soft" id="metode"><div class="container">
@include('frontend.components.section-head', [
    'eyebrow' => 'Learning Journey',
    'title' => 'Proses Pengembangan dari Diagnosis hingga Tindak Lanjut',
    'description' => 'Tahapan dapat disederhanakan atau diperluas sesuai skala program. Setiap tahap membantu memastikan pembelajaran memiliki tujuan, pengalaman, dan hasil yang lebih jelas.',
])
<div class="steps">
<article class="step"><span class="step-no">1</span><h3>Needs Analysis</h3><p>Memahami sasaran organisasi, profil peserta, tantangan, gap kompetensi, dan indikator keberhasilan.</p></article>
<article class="step"><span class="step-no">2</span><h3>Program Design</h3><p>Menyusun tujuan belajar, kurikulum, metode, fasilitator, jadwal, materi, dan bentuk evaluasi.</p></article>
<article class="step"><span class="step-no">3</span><h3>Learning Delivery</h3><p>Pelaksanaan kelas, workshop, diskusi, simulasi, tugas, coaching, atau pembelajaran digital.</p></article>
<article class="step"><span class="step-no">4</span><h3>Evaluation &amp; Follow-up</h3><p>Menilai proses dan hasil belajar serta menyusun action plan, rekomendasi, atau penguatan lanjutan.</p></article>
</div>
</div></section>
<section class="section section-dark" id="evaluasi"><div class="container">
@include('frontend.components.section-head', [
    'eyebrow' => 'Evaluation Framework',
    'title' => 'Evaluasi Disesuaikan dengan Tujuan dan Skala Program',
    'description' => 'Tidak semua program memerlukan instrumen yang sama. Bentuk evaluasi ditentukan secara proporsional dan dijelaskan sejak tahap perancangan.',
])
<div class="deliverable-grid">
<article class="deliverable"><i>☺</i><h3>Reaction</h3><p>Umpan balik peserta terhadap relevansi materi, fasilitator, metode, dan pengalaman belajar.</p></article>
<article class="deliverable"><i>✓</i><h3>Learning</h3><p>Pre-test, post-test, kuis, tugas, studi kasus, atau demonstrasi untuk melihat perkembangan pemahaman.</p></article>
<article class="deliverable"><i>↗</i><h3>Application</h3><p>Action plan, project assignment, observasi, coaching, atau review atasan untuk mendukung penerapan.</p></article>
<article class="deliverable"><i>▦</i><h3>Business Relevance</h3><p>Indikator operasional atau kinerja yang relevan dapat ditinjau apabila data dan periode pengukuran tersedia.</p></article>
<article class="deliverable"><i>▤</i><h3>Program Report</h3><p>Dokumentasi pelaksanaan, kehadiran, hasil evaluasi, catatan fasilitator, dan rekomendasi.</p></article>
<article class="deliverable"><i>🎓</i><h3>Recognition</h3><p>Sertifikat keikutsertaan atau penyelesaian diterbitkan berdasarkan persyaratan program yang ditetapkan.</p></article>
</div>
</div></section>
<section class="section" id="output"><div class="container">
@include('frontend.components.section-head', [
    'eyebrow' => 'Output Program',
    'title' => 'Perangkat Pembelajaran yang Mendukung Implementasi',
    'description' => 'Jenis output mengikuti ruang lingkup, format, hak penggunaan, dan kesepakatan program. Tidak seluruh program menghasilkan semua dokumen berikut.',
])
<div class="principle-grid">
<article class="principle"><span>01</span><div><strong>Training Needs Summary</strong><p>Ringkasan tujuan, peserta, kebutuhan, gap, dan fokus pengembangan.</p></div></article>
<article class="principle"><span>02</span><div><strong>Curriculum &amp; Session Plan</strong><p>Struktur materi, tujuan belajar, durasi, metode, dan agenda pelaksanaan.</p></div></article>
<article class="principle"><span>03</span><div><strong>Learning Materials</strong><p>Modul, slide, worksheet, studi kasus, kuis, atau materi digital sesuai kesepakatan.</p></div></article>
<article class="principle"><span>04</span><div><strong>Assessment Result</strong><p>Rekap hasil evaluasi yang relevan dengan tujuan dan instrumen program.</p></div></article>
<article class="principle"><span>05</span><div><strong>Action Plan</strong><p>Rencana penerapan, penguatan kompetensi, atau tindak lanjut peserta dan institusi.</p></div></article>
<article class="principle"><span>06</span><div><strong>Program Report</strong><p>Laporan pelaksanaan dan rekomendasi untuk pengembangan tahap berikutnya.</p></div></article>
</div>
</div></section>
<section class="section section-soft" id="ketentuan"><div class="container">
@include('frontend.components.section-head', [
    'eyebrow' => 'Prinsip &amp; Ketentuan',
    'title' => 'Pembelajaran yang Profesional, Inklusif, dan Bertanggung Jawab',
    'description' => 'Ketentuan rinci dituangkan dalam proposal, surat penawaran, kerangka acuan, atau perjanjian yang disepakati para pihak.',
])
<div class="principle-grid">
<article class="principle"><span>✓</span><div><strong>Ruang Lingkup Jelas</strong><p>Tujuan, peserta, materi, metode, jadwal, output, biaya, dan tanggung jawab disepakati sebelum pelaksanaan.</p></div></article>
<article class="principle"><span>✓</span><div><strong>Fasilitator Relevan</strong><p>Penugasan fasilitator mempertimbangkan kompetensi, pengalaman, topik, dan kebutuhan program.</p></div></article>
<article class="principle"><span>✓</span><div><strong>Materi Kontekstual</strong><p>Contoh dan studi kasus disesuaikan tanpa membuka informasi rahasia atau melanggar hak pihak lain.</p></div></article>
<article class="principle"><span>✓</span><div><strong>Partisipasi Setara</strong><p>Program dirancang untuk mendukung lingkungan belajar yang profesional, aman, dan menghargai peserta.</p></div></article>
<article class="principle"><span>✓</span><div><strong>Data &amp; Kerahasiaan</strong><p>Data peserta dan institusi digunakan sesuai tujuan, akses, persetujuan, serta ketentuan yang berlaku.</p></div></article>
<article class="principle"><span>✓</span><div><strong>Tanpa Jaminan Otomatis</strong><p>Keikutsertaan pelatihan tidak otomatis menjamin promosi, kelulusan seleksi, sertifikasi profesi, atau hasil bisnis tertentu.</p></div></article>
</div>
</div></section>
<section class="section" id="faq"><div class="container">@include('frontend.components.section-head', [
    'eyebrow' => 'Pertanyaan Umum',
    'title' => 'Informasi Awal Capacity Building',
    'description' => 'Jawaban berikut memberikan gambaran sebelum institusi atau peserta mengajukan program.',
])<div class="faq-wrap">
<article class="faq-item"><button class="faq-q" type="button">Apakah materi dapat disesuaikan dengan kebutuhan institusi?<span class="faq-plus">＋</span></button><div class="faq-a">Ya. Penyesuaian dapat meliputi tujuan, kedalaman materi, studi kasus, durasi, metode, dan output, berdasarkan informasi kebutuhan yang tersedia.</div></article>
<article class="faq-item"><button class="faq-q" type="button">Apakah program tersedia secara online dan tatap muka?<span class="faq-plus">＋</span></button><div class="faq-a">Ya. Program dapat dilaksanakan secara daring, luring, atau blended dengan mempertimbangkan tujuan belajar, lokasi, jumlah peserta, fasilitas, dan efektivitas metode.</div></article>
<article class="faq-item"><button class="faq-q" type="button">Bagaimana menentukan durasi pelatihan?<span class="faq-plus">＋</span></button><div class="faq-a">Durasi ditentukan berdasarkan jumlah tujuan belajar, tingkat kompleksitas, metode, jumlah peserta, kebutuhan praktik, serta bentuk evaluasi dan tindak lanjut.</div></article>
<article class="faq-item"><button class="faq-q" type="button">Apakah peserta mendapatkan sertifikat?<span class="faq-plus">＋</span></button><div class="faq-a">Sertifikat dapat diterbitkan sesuai jenis program dan persyaratan yang ditetapkan, misalnya kehadiran, penyelesaian tugas, atau kelulusan evaluasi tertentu.</div></article>
<article class="faq-item"><button class="faq-q" type="button">Apakah Bankir Academy menyediakan pre-test dan post-test?<span class="faq-plus">＋</span></button><div class="faq-a">Dapat disediakan apabila relevan dengan tujuan program. Evaluasi juga dapat berbentuk kuis, tugas, studi kasus, simulasi, action plan, atau bentuk lain yang disepakati.</div></article>
<article class="faq-item"><button class="faq-q" type="button">Informasi apa yang diperlukan untuk meminta penawaran?<span class="faq-plus">＋</span></button><div class="faq-a">Sampaikan profil institusi, topik atau tantangan, target peserta, jumlah peserta, lokasi atau metode, jadwal, durasi, dan hasil yang diharapkan.</div></article>
</div></div></section>
<section class="final-cta" id="konsultasi"><div class="container"><div class="cta-box"><div><h2>Bangun Program yang Relevan, Bukan Sekadar Agenda Pelatihan</h2><p>Sampaikan kebutuhan kompetensi, profil peserta, target organisasi, jadwal, dan format pelaksanaan. Tim Bankir Academy akan membantu menyusun rancangan program awal.</p></div><div class="cta-actions"><a class="btn btn-light" href="mailto:info@bankiracademy.co.id?subject=Konsultasi%20Capacity%20Building">Email Konsultasi</a><a class="btn btn-secondary" href="#program">Lihat Pilihan Program</a></div></div></div></section>

@endsection
