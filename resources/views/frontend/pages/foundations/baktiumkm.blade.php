@extends('layouts.appfrontend')

@section('page-title')
Bakti UMKM — Bankir Academy
@endsection

@section('page-description')
Bakti UMKM Bankir Academy merupakan program kolaborasi pemberdayaan untuk membantu pelaku usaha menata keuangan, pemasaran, operasional, digitalisasi, dan kesiapan pembiayaan secara bertahap.
@endsection

@section('content')
<section class="hero solution-hero" id="ringkasan">
<div class="container hero-grid">
<div>
<span class="eyebrow">Bankir Academy Foundations</span>
<h1>Menguatkan Kapasitas UMKM agar <span class="gradient-text">Lebih Tertata, Tangguh, dan Bertumbuh</span></h1>
<p class="hero-lead">Bakti UMKM adalah program kolaborasi Bankir Academy bersama bank, BPR/BPRS, perusahaan, pemerintah daerah, kampus, asosiasi, dan komunitas untuk membantu pelaku usaha memperkuat dasar pengelolaan bisnis. Program berfokus pada pencatatan keuangan, arus kas, pemasaran, layanan pelanggan, kesiapan pembiayaan, penggunaan teknologi, serta rencana tindak lanjut yang realistis.</p>
<div class="hero-actions">
<a class="btn btn-primary" href="#program">Jelajahi Program <span class="icon-arrow">→</span></a>
<a class="btn btn-outline" href="#konsultasi">Ajukan Kolaborasi</a>
</div>
<div class="hero-proof">
<span class="proof-item"><span class="proof-icon">✓</span>Berbasis kebutuhan usaha</span>
<span class="proof-item"><span class="proof-icon">✓</span>Materi praktis dan bertahap</span>
<span class="proof-item"><span class="proof-icon">✓</span>Evaluasi serta laporan tersedia</span>
</div>
</div>
<div aria-label="Ilustrasi Bakti UMKM Bankir Academy" class="hero-visual">
<div class="visual-main"><div class="dashboard">
<div class="dash-top"><div class="dash-brand"><svg aria-hidden="true" height="31" width="31"><use href="#logo-ba"></use></svg>UMKM GROWTH HUB</div><div class="dash-dots"><span></span><span></span><span></span></div></div>
<div class="dash-hero"><div class="dash-label">Practical Business Empowerment</div><h3>Organize. Improve. Access. Grow.</h3><p>Satu kerangka pendampingan untuk menata usaha, memperkuat keputusan, meningkatkan kesiapan, dan mendokumentasikan perkembangan UMKM.</p>
<div class="dash-stats"><div class="dash-stat"><strong>Practical</strong><span>Langsung dapat diterapkan</span></div><div class="dash-stat"><strong>Inclusive</strong><span>Sesuai tingkat kematangan usaha</span></div><div class="dash-stat"><strong>Measurable</strong><span>Perkembangan dapat ditinjau</span></div></div>
</div>
<div class="dash-grid"><div class="dash-card"><h4>Business Progress</h4><div class="progress"><span class="width-79"></span></div><div class="mini-list mini-list-spaced"><div class="mini-row"><i></i><span>Pemetaan kondisi usaha</span></div><div class="mini-row"><i class="dot-accent"></i><span>Pelatihan dan praktik</span></div><div class="mini-row"><i class="dot-primary"></i><span>Pendampingan dan evaluasi</span></div></div></div><div class="dash-card"><h4>Program Area</h4><div class="mini-list"><div class="mini-row"><i></i><span>Keuangan usaha</span></div><div class="mini-row"><i class="dot-primary"></i><span>Pemasaran digital</span></div><div class="mini-row"><i class="dot-accent"></i><span>Kesiapan pembiayaan</span></div><div class="mini-row"><i class="dot-danger"></i><span>Produktivitas usaha</span></div></div></div></div>
</div></div>
<div class="float-card one"><span class="float-icon">▦</span><span><strong>Business Records</strong><small>Pencatatan lebih tertata</small></span></div>
<div class="float-card two"><span class="float-icon">↗</span><span><strong>Market Access</strong><small>Pemasaran dan pelanggan</small></span></div>
<div class="float-card three"><span class="float-icon">◎</span><span><strong>Readiness Report</strong><small>Data, evaluasi, tindak lanjut</small></span></div>
</div>
</div>
</section>
<div class="trust-strip"><div class="container trust-inner"><div class="trust-copy"><strong>Program pemberdayaan untuk berbagai tahap perkembangan UMKM</strong><span>Ruang lingkup dapat disesuaikan berdasarkan sektor usaha, skala, lokasi, akses teknologi, kondisi administrasi, tujuan mitra, dan kesiapan peserta.</span></div><div class="trust-item"><span class="trust-mark">M</span>Usaha Mikro</div><div class="trust-item"><span class="trust-mark">K</span>Usaha Kecil</div><div class="trust-item"><span class="trust-mark">P</span>Pelaku Pemula</div><div class="trust-item"><span class="trust-mark">C</span>Komunitas Usaha</div></div></div>
<section class="section" id="kebutuhan"><div class="container">
@include('frontend.components.section-head', [
    'eyebrow' => 'Mengapa Bakti UMKM',
    'title' => 'Pemberdayaan UMKM Perlu Menjawab Masalah Nyata dalam Pengelolaan Usaha',
    'description' => 'Pelatihan yang efektif tidak hanya menyampaikan teori. Peserta perlu memahami posisi usahanya, mempraktikkan alat sederhana, memperoleh umpan balik, serta memiliki langkah lanjutan yang dapat dijalankan setelah program selesai.',
])
<div class="challenge-grid">
<article class="challenge-card"><span class="challenge-no">01</span><h3>Keuangan Usaha Belum Tertata</h3><p>Pemasukan, pengeluaran, stok, utang, dan uang pribadi sering tercampur sehingga pelaku usaha sulit mengetahui kondisi bisnis yang sebenarnya.</p></article>
<article class="challenge-card"><span class="challenge-no">02</span><h3>Pemasaran Belum Konsisten</h3><p>Produk dapat memiliki potensi, tetapi belum didukung target pelanggan, pesan promosi, kanal penjualan, pelayanan, dan tindak lanjut yang terstruktur.</p></article>
<article class="challenge-card"><span class="challenge-no">03</span><h3>Dokumen Usaha Terbatas</h3><p>Legalitas, catatan transaksi, profil usaha, laporan sederhana, dan dokumen pendukung belum selalu tersedia saat dibutuhkan untuk kerja sama atau pembiayaan.</p></article>
<article class="challenge-card"><span class="challenge-no">04</span><h3>Dampak Program Sulit Diukur</h3><p>Kegiatan sering berhenti pada jumlah peserta tanpa data kondisi awal, praktik yang diselesaikan, perubahan perilaku, atau rekomendasi pendampingan berikutnya.</p></article>
</div>
</div></section>
<section class="section section-soft" id="program"><div class="container">
@include('frontend.components.section-head', [
    'eyebrow' => 'Ruang Lingkup Program',
    'title' => 'Materi Praktis yang Dapat Disesuaikan dengan Kebutuhan Usaha',
    'description' => 'Topik dapat diberikan sebagai satu kelas, seri pembelajaran, klinik bisnis, bootcamp, mentoring, atau program pendampingan dengan target dan indikator yang disepakati.',
])
<div class="service-grid">
<article class="solution-card"><div class="solution-icon">▦</div><h3>Keuangan &amp; Pencatatan Usaha</h3><p>Pembelajaran dasar untuk memisahkan uang pribadi dan usaha, mencatat transaksi, memahami biaya, margin, arus kas, serta posisi keuangan sederhana.</p><ul><li>Buku kas dan transaksi</li><li>HPP, harga, dan margin</li><li>Arus kas serta kontrol sederhana</li></ul></article>
<article class="solution-card"><div class="solution-icon">↗</div><h3>Pemasaran &amp; Penjualan</h3><p>Penguatan kemampuan mengenali pelanggan, menyusun nilai jual, memilih kanal, membuat promosi, dan membangun proses penjualan yang lebih konsisten.</p><ul><li>Segmentasi pelanggan</li><li>Konten dan kanal digital</li><li>Follow-up serta loyalitas</li></ul></article>
<article class="solution-card"><div class="solution-icon">◎</div><h3>Kesiapan Pembiayaan</h3><p>Pendampingan untuk memahami kebutuhan modal, kemampuan bayar, dokumen dasar, tujuan penggunaan dana, dan risiko sebelum mengajukan pembiayaan.</p><ul><li>Profil serta kebutuhan usaha</li><li>Dokumen dan catatan pendukung</li><li>Simulasi kesiapan pembiayaan</li></ul></article>
<article class="solution-card"><div class="solution-icon">✦</div><h3>Digitalisasi Usaha</h3><p>Penggunaan teknologi sederhana untuk produktivitas, pencatatan, komunikasi pelanggan, katalog, pembayaran, penyimpanan dokumen, dan analisis dasar.</p><ul><li>Alat kerja digital</li><li>Katalog dan transaksi online</li><li>Keamanan serta data usaha</li></ul></article>
<article class="solution-card"><div class="solution-icon">◇</div><h3>Operasional &amp; Layanan</h3><p>Penataan proses kerja, stok, kualitas produk, pelayanan pelanggan, pembagian tugas, dan standar sederhana agar usaha lebih konsisten.</p><ul><li>Alur kerja dan kontrol</li><li>Pengelolaan stok</li><li>Standar layanan pelanggan</li></ul></article>
<article class="solution-card"><div class="solution-icon">♡</div><h3>Mentoring &amp; Klinik Bisnis</h3><p>Diskusi kasus, peninjauan praktik, pemecahan masalah, dan penyusunan rencana perbaikan berdasarkan kondisi nyata masing-masing peserta.</p><ul><li>Review kondisi usaha</li><li>Action plan prioritas</li><li>Monitoring perkembangan</li></ul></article>
</div>
</div></section>
<section class="section" id="model-kolaborasi"><div class="container method-wrap">
<div class="method-copy"><span class="eyebrow">Model Kolaborasi</span><h2>Peran Mitra, Pendamping, dan Peserta Ditetapkan Sejak Awal</h2><p>Pembagian peran yang jelas membantu memastikan peserta yang tepat, materi yang relevan, jadwal realistis, pendampingan yang cukup, dokumentasi yang sah, dan laporan yang dapat digunakan untuk tindak lanjut.</p><div class="feature-points"><div class="feature-point"><span class="point-icon">1</span><span><strong>Mitra Program</strong><span>Menetapkan tujuan, wilayah, sektor prioritas, dukungan pendanaan, kebijakan merek, dan kebutuhan laporan.</span></span></div><div class="feature-point"><span class="point-icon">2</span><span><strong>Bankir Academy</strong><span>Menyusun desain program, materi, fasilitator, alat praktik, evaluasi, dokumentasi, dan laporan.</span></span></div><div class="feature-point"><span class="point-icon">3</span><span><strong>Komunitas atau Pendamping Lokal</strong><span>Membantu validasi peserta, komunikasi, sarana, kehadiran, konteks lokal, dan tindak lanjut lapangan.</span></span></div><div class="feature-point"><span class="point-icon">4</span><span><strong>Peserta UMKM</strong><span>Menyampaikan kondisi usaha secara jujur, mengikuti kegiatan, menyelesaikan praktik, dan menjalankan rencana perbaikan.</span></span></div></div></div>
<div class="method-panel"><div class="method-title"><span>UMKM Partnership</span><strong>Shared Growth Framework</strong></div><div class="method-flow"><div class="method-step"><b>01</b><span><strong>Assess</strong><small>Profil, kondisi, dan kebutuhan usaha</small></span></div><div class="method-step"><b>02</b><span><strong>Learn</strong><small>Materi, alat praktik, dan fasilitator</small></span></div><div class="method-step"><b>03</b><span><strong>Apply</strong><small>Rencana perbaikan yang realistis</small></span></div><div class="method-step"><b>04</b><span><strong>Review</strong><small>Evaluasi, bukti, dan tindak lanjut</small></span></div></div><div class="method-note">Rincian peran, biaya, fasilitas, penggunaan logo, pengelolaan data usaha, dokumentasi, publikasi, serta batas tanggung jawab dituangkan dalam proposal atau perjanjian.</div></div>
</div></section>
<section class="section section-soft" id="tahapan"><div class="container">
@include('frontend.components.section-head', [
    'eyebrow' => 'Tahapan Pelaksanaan',
    'title' => 'Dari Pemetaan Usaha hingga Rekomendasi Pengembangan',
    'description' => 'Tahapan dapat disederhanakan untuk kelas tunggal atau diperluas untuk program multi-sesi, multi-komunitas, mentoring, inkubasi, dan pendampingan lintas wilayah.',
])
<div class="process-grid">
<article class="process-card"><span>01</span><h3>Need Assessment</h3><p>Memahami tujuan mitra, profil peserta, sektor usaha, skala, lokasi, tantangan, akses teknologi, dan kebutuhan pendampingan.</p></article>
<article class="process-card"><span>02</span><h3>Program Design</h3><p>Menetapkan topik, target perubahan, metode, jadwal, fasilitator, alat praktik, indikator, dokumentasi, dan pembagian peran.</p></article>
<article class="process-card"><span>03</span><h3>Participant Preparation</h3><p>Registrasi, validasi usaha, komunikasi teknis, persetujuan data, asesmen awal, dan kesiapan dokumen atau sarana belajar.</p></article>
<article class="process-card"><span>04</span><h3>Learning &amp; Practice</h3><p>Pelaksanaan kelas, simulasi, klinik, tugas, kunjungan, mentoring, atau praktik menggunakan data usaha yang relevan.</p></article>
<article class="process-card"><span>05</span><h3>Monitoring &amp; Evaluation</h3><p>Pengukuran kehadiran, keterlibatan, penyelesaian praktik, perubahan pemahaman, penerapan, dan kendala peserta.</p></article>
<article class="process-card"><span>06</span><h3>Report &amp; Follow-up</h3><p>Penyusunan dokumentasi, laporan hasil, pembelajaran program, rekomendasi, serta opsi penguatan atau pendampingan lanjutan.</p></article>
</div>
</div></section>
<section class="section section-dark" id="pengukuran"><div class="container">
@include('frontend.components.section-head', [
    'eyebrow' => 'UMKM Impact',
    'title' => 'Keberhasilan Program Dilihat dari Penerapan yang Relevan bagi Usaha',
    'description' => 'Indikator dipilih secara proporsional berdasarkan durasi, tingkat kematangan peserta, tujuan program, instrumen yang tersedia, dan kemampuan pengumpulan data.',
])
<div class="impact-grid">
<article class="impact-card"><span>01</span><div><strong>Reach</strong><p>Jumlah peserta, sektor, wilayah, komunitas, tingkat kehadiran, dan keterwakilan kelompok sasaran.</p></div></article>
<article class="impact-card"><span>02</span><div><strong>Engagement</strong><p>Partisipasi, penyelesaian latihan, diskusi, mentoring, penggunaan alat, dan keterlibatan dalam tindak lanjut.</p></div></article>
<article class="impact-card"><span>03</span><div><strong>Business Knowledge</strong><p>Perubahan pemahaman melalui asesmen, kuis, studi kasus, lembar kerja, atau observasi fasilitator.</p></div></article>
<article class="impact-card"><span>04</span><div><strong>Business Practice</strong><p>Penerapan pencatatan, pemisahan uang, perhitungan harga, promosi, pelayanan, stok, atau praktik lain yang disepakati.</p></div></article>
<article class="impact-card"><span>05</span><div><strong>Readiness</strong><p>Kesiapan dokumen, rencana usaha, penggunaan teknologi, pemasaran, atau pembiayaan sesuai tujuan program.</p></div></article>
<article class="impact-card"><span>06</span><div><strong>Continuation</strong><p>Rekomendasi mentoring, rujukan layanan, penguatan komunitas, pembelajaran lanjutan, atau pengembangan program.</p></div></article>
</div>
</div></section>
<section class="section" id="model-program"><div class="container">
@include('frontend.components.section-head', [
    'eyebrow' => 'Format Program',
    'title' => 'Pilih Skala Program Sesuai Tujuan dan Kedalaman Pendampingan',
    'description' => 'Format berikut merupakan gambaran awal. Nama, durasi, jumlah peserta, sektor, lokasi, media, pendanaan, dan output dapat disesuaikan dalam proposal.',
])
<div class="cards-3">
<article class="service-card"><div class="card-icon">◎</div><span class="tag tag-spaced">Single Activity</span><h3>UMKM Class</h3><p>Kelas, seminar, webinar, atau klinik singkat untuk satu topik dan kelompok usaha tertentu.</p><ul class="card-list"><li>Materi sesuai profil peserta</li><li>Fasilitator dan lembar praktik</li><li>Dokumentasi dasar</li></ul></article>
<article class="service-card"><div class="card-icon">↗</div><span class="tag tag-spaced">Learning Series</span><h3>Business Growth Bootcamp</h3><p>Rangkaian pembelajaran, praktik, tugas, dan mentoring untuk memperbaiki aspek usaha secara bertahap.</p><ul class="card-list"><li>Kurikulum beberapa sesi</li><li>Review praktik usaha</li><li>Laporan perkembangan</li></ul></article>
<article class="service-card"><div class="card-icon">♡</div><span class="tag tag-spaced">Development Program</span><h3>UMKM Mentoring Program</h3><p>Pendampingan lebih mendalam bagi peserta terpilih melalui asesmen, klinik, action plan, monitoring, dan evaluasi.</p><ul class="card-list"><li>Kriteria peserta transparan</li><li>Target perbaikan terukur</li><li>Laporan tindak lanjut</li></ul></article>
</div>
</div></section>
<section class="section section-soft" id="output"><div class="container">
@include('frontend.components.section-head', [
    'eyebrow' => 'Output Program',
    'title' => 'Materi, Alat Praktik, dan Bukti Pelaksanaan yang Lebih Tertata',
    'description' => 'Output aktual mengikuti ruang lingkup, durasi, model pembelajaran, ketersediaan data, persetujuan dokumentasi, dan kebutuhan laporan mitra.',
])
<div class="principle-grid">
<article class="principle"><span>01</span><div><strong>Program Framework</strong><p>Tujuan, sasaran, profil usaha, topik, metode, jadwal, indikator, peran, dan kebutuhan sumber daya.</p></div></article>
<article class="principle"><span>02</span><div><strong>Learning &amp; Business Tools</strong><p>Presentasi, modul, e-book, video, buku kas, lembar HPP, template promosi, checklist, dan panduan praktik.</p></div></article>
<article class="principle"><span>03</span><div><strong>Participant Records</strong><p>Data peserta, profil usaha, registrasi, kehadiran, status pembelajaran, hasil tugas, dan penyelesaian program.</p></div></article>
<article class="principle"><span>04</span><div><strong>Activity Documentation</strong><p>Foto, video, catatan kegiatan, karya peserta, testimoni, dan bukti lain sesuai izin serta kebijakan publikasi.</p></div></article>
<article class="principle"><span>05</span><div><strong>Evaluation Summary</strong><p>Ringkasan asesmen, praktik yang diselesaikan, capaian, umpan balik, kendala, dan pembelajaran program.</p></div></article>
<article class="principle"><span>06</span><div><strong>UMKM Impact Report</strong><p>Laporan pelaksanaan, hasil, penggunaan dukungan, kesimpulan, dan rekomendasi tindak lanjut.</p></div></article>
</div>
</div></section>
<section class="section" id="ketentuan"><div class="container">
@include('frontend.components.section-head', [
    'eyebrow' => 'Prinsip &amp; Ketentuan',
    'title' => 'Tata Kelola, Transparansi, dan Kepentingan Peserta Menjadi Prioritas',
    'description' => 'Program perlu mengatur penggunaan data, kriteria peserta, dokumentasi, penggunaan merek, komunikasi, batas layanan, dan tindak lanjut secara proporsional.',
])
<div class="principle-grid">
<article class="principle"><span>✓</span><div><strong>Kriteria Peserta Transparan</strong><p>Sektor, wilayah, skala usaha, kebutuhan, lama usaha, atau kriteria lain ditetapkan oleh pihak yang berwenang dan dikomunikasikan dengan jelas.</p></div></article>
<article class="principle"><span>✓</span><div><strong>Data Usaha Dijaga</strong><p>Data transaksi, omzet, biaya, identitas, dokumen, dan informasi usaha hanya digunakan sesuai tujuan serta persetujuan program.</p></div></article>
<article class="principle"><span>✓</span><div><strong>Materi Bersifat Edukatif</strong><p>Program tidak menjanjikan pembiayaan, peningkatan omzet, keuntungan, pasar, sertifikasi, atau hasil bisnis tertentu.</p></div></article>
<article class="principle"><span>✓</span><div><strong>Keputusan Pembiayaan Independen</strong><p>Keputusan pembiayaan tetap menjadi kewenangan lembaga keuangan berdasarkan kebijakan, analisis, dan ketentuan yang berlaku.</p></div></article>
<article class="principle"><span>✓</span><div><strong>Branding Tidak Mendominasi</strong><p>Identitas mitra dapat digunakan sesuai kesepakatan, tetapi manfaat program dan kepentingan peserta tetap menjadi fokus utama.</p></div></article>
<article class="principle"><span>✓</span><div><strong>Pelaporan Berdasarkan Bukti</strong><p>Kesimpulan disusun dari data kehadiran, asesmen, praktik, dokumentasi, umpan balik, dan informasi yang berhasil dikumpulkan.</p></div></article>
</div>
</div></section>
<section class="section section-soft" id="faq"><div class="container">@include('frontend.components.section-head', [
    'eyebrow' => 'Pertanyaan Umum',
    'title' => 'Informasi Awal Bakti UMKM',
    'description' => 'Ruang lingkup final ditentukan setelah tujuan, sasaran, wilayah, sektor usaha, jumlah peserta, jadwal, anggaran, fasilitas, dan kebutuhan laporan dibahas bersama.',
])<div class="faq-wrap">
<article class="faq-item"><button class="faq-q" type="button">Siapa yang dapat menjadi mitra Bakti UMKM?<span class="faq-plus">＋</span></button><div class="faq-a">Bank, BPR/BPRS, perusahaan, pemerintah daerah, kampus, yayasan, asosiasi, komunitas, koperasi, dan lembaga lain dapat berkolaborasi sesuai tujuan serta kebijakan masing-masing.</div></article>
<article class="faq-item"><button class="faq-q" type="button">Siapa yang dapat menjadi peserta?<span class="faq-plus">＋</span></button><div class="faq-a">Peserta dapat berupa pelaku usaha mikro dan kecil, wirausaha pemula, kelompok perempuan, pemuda, komunitas usaha, nasabah binaan, atau kelompok lain yang ditetapkan dalam desain program.</div></article>
<article class="faq-item"><button class="faq-q" type="button">Apakah program dapat dilaksanakan gratis bagi peserta?<span class="faq-plus">＋</span></button><div class="faq-a">Dapat. Biaya program dapat didukung penuh atau sebagian oleh mitra. Mekanisme, kuota, kriteria peserta, fasilitas, dan batas dukungan perlu dijelaskan secara terbuka.</div></article>
<article class="faq-item"><button class="faq-q" type="button">Apakah program menjamin peserta memperoleh pembiayaan?<span class="faq-plus">＋</span></button><div class="faq-a">Tidak. Program dapat membantu meningkatkan pemahaman dan kesiapan dokumen, tetapi keputusan pembiayaan sepenuhnya menjadi kewenangan lembaga keuangan berdasarkan analisis serta ketentuan yang berlaku.</div></article>
<article class="faq-item"><button class="faq-q" type="button">Apakah tersedia kelas daring dan pendampingan?<span class="faq-plus">＋</span></button><div class="faq-a">Ya. Program dapat dijalankan secara luring, daring, atau blended, serta dapat menggunakan LMS, video, e-book, lembar kerja, grup pendampingan, klinik bisnis, dan mentoring sesuai kebutuhan.</div></article>
<article class="faq-item"><button class="faq-q" type="button">Informasi apa yang diperlukan untuk menyusun proposal?<span class="faq-plus">＋</span></button><div class="faq-a">Sampaikan tujuan program, profil peserta, sektor usaha, wilayah, jumlah, topik, durasi, jadwal, model pembelajaran, anggaran, kebutuhan branding, dokumentasi, fasilitas, dan format laporan.</div></article>
</div></div></section>
<section class="final-cta" id="konsultasi"><div class="container"><div class="cta-box"><div><h2>Bangun Program Pemberdayaan UMKM yang Praktis dan Terukur</h2><p>Sampaikan tujuan, profil peserta, sektor usaha, wilayah, jumlah peserta, jadwal, anggaran, dan bentuk dukungan. Tim Bankir Academy akan membantu menyusun rancangan program awal.</p></div><div class="cta-actions"><a class="btn btn-light" href="mailto:info@bankiracademy.co.id?subject=Konsultasi%20Bakti%20UMKM">Email Konsultasi</a><a class="btn btn-secondary" href="#program">Lihat Program</a></div></div></div></section>

@endsection
