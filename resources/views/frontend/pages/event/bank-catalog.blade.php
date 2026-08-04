@extends('layouts.appfrontend')

@section('page-title')
Kelas Online — Bankir Academy
@endsection

@section('page-description')
Jelajahi kelas online Bankir Academy untuk calon bankir, pegawai bank, profesional, pimpinan, dan pelaku UMKM.
@endsection

@section('content')
<section class="hero classes-hero" id="ringkasan">
<div class="container hero-grid">
<div><span class="eyebrow">Katalog Kelas Online</span><h1>Belajar Lebih Terarah untuk <span class="gradient-text">Karier dan Kinerja Perbankan</span></h1>
<p class="hero-lead">Jelajahi kelas mandiri dan blended learning Bankir Academy untuk calon bankir, pegawai, supervisor, manajer, pimpinan, serta pelaku UMKM. Setiap kelas dirancang dengan tujuan pembelajaran, materi praktis, evaluasi, dan hasil belajar yang jelas.</p>
<div class="hero-actions"><a class="btn btn-primary" href="#katalog">Lihat Semua Kelas <span class="icon-arrow">→</span></a><a class="btn btn-outline" href="{{ route('frontend.support.contact') }}">Konsultasi Kelas</a></div>
<div class="hero-proof"><span class="proof-item"><span class="proof-icon">✓</span>Materi terstruktur</span><span class="proof-item"><span class="proof-icon">✓</span>Belajar fleksibel</span><span class="proof-item"><span class="proof-icon">✓</span>Evaluasi pembelajaran</span></div>
<div class="class-kicker"><span>Video Pembelajaran</span><span>E-book</span><span>Kuis &amp; Latihan</span><span>Sertifikat sesuai ketentuan</span></div>
</div>
<div class="hero-visual"><div class="visual-main"><div class="catalog-board">
<div class="catalog-top"><span>LEARNING CATALOG</span><span class="catalog-status">12 Kelas Pilihan</span></div>
<div class="catalog-feature"><small>Featured Learning Path</small><h3>Banking Professional Journey</h3><p>Mulai dari fondasi perbankan, kompetensi jabatan, keterampilan digital, hingga kepemimpinan.</p></div>
<div class="catalog-grid"><div class="catalog-mini"><strong>Foundation</strong><span>Dasar industri dan karier</span><div class="catalog-progress"><i class="width-88"></i></div></div><div class="catalog-mini"><strong>Professional</strong><span>Kompetensi fungsi kerja</span><div class="catalog-progress"><i class="width-74"></i></div></div><div class="catalog-mini"><strong>Digital</strong><span>Data, AI, dan teknologi</span><div class="catalog-progress"><i class="width-68"></i></div></div><div class="catalog-mini"><strong>Leadership</strong><span>Supervisor hingga pimpinan</span><div class="catalog-progress"><i class="width-61"></i></div></div></div>
</div></div><div class="float-card one"><span class="float-icon">▶</span><span><strong>Belajar Mandiri</strong><small>Akses sesuai ritme belajar</small></span></div><div class="float-card two"><span class="float-icon">✓</span><span><strong>Learning Progress</strong><small>Materi dan evaluasi terpantau</small></span></div></div>
</div>
</section>
<div class="class-summary"><div class="container summary-grid"><div class="summary-item"><span class="summary-icon">12</span><span><strong>Contoh Kelas</strong><span>Berbagai bidang kompetensi</span></span></div><div class="summary-item"><span class="summary-icon">4</span><span><strong>Level Belajar</strong><span>Dasar hingga strategis</span></span></div><div class="summary-item"><span class="summary-icon">∞</span><span><strong>Belajar Fleksibel</strong><span>Mandiri dan blended</span></span></div><div class="summary-item"><span class="summary-icon">✓</span><span><strong>Evaluasi</strong><span>Kuis, praktik, dan action plan</span></span></div></div></div>
<section class="section" id="katalog"><div class="container">
@include('frontend.components.section-head', [
    'eyebrow' => 'Katalog Pembelajaran',
    'title' => 'Pilih Kelas Sesuai Kebutuhan Anda',
    'description' => 'Gunakan pencarian dan kategori untuk menemukan topik yang relevan. Contoh kelas dapat dikembangkan menjadi kelas institusi atau learning path khusus.',
])
<div class="catalog-tools"><label class="class-search"><span>⌕</span><input id="classSearch" placeholder="Cari judul, topik, atau kompetensi..." type="search"/></label><select aria-label="Urutkan kelas" class="class-sort" id="classSort"><option value="default">Urutkan: Rekomendasi</option><option value="az">Judul A–Z</option><option value="za">Judul Z–A</option></select></div>
<div class="class-filters"><button class="class-filter active" data-filter="all">Semua Kelas</button><button class="class-filter" data-filter="perbankan">Dasar Perbankan</button><button class="class-filter" data-filter="kredit">Kredit</button><button class="class-filter" data-filter="risiko">Risiko</button><button class="class-filter" data-filter="kepatuhan">Kepatuhan</button><button class="class-filter" data-filter="pemasaran">Pemasaran</button><button class="class-filter" data-filter="digital">Digital &amp; TI</button><button class="class-filter" data-filter="karier">Karier</button><button class="class-filter" data-filter="leadership">Leadership</button><button class="class-filter" data-filter="umkm">UMKM</button></div>
<div class="catalog-cards" id="classGrid"><article class="catalog-card" data-category="perbankan" data-title="general banking fundamentals dasar perbankan memahami fungsi bank, produk dan layanan, struktur organisasi, proses operasional, serta etika dasar calon bankir.">
<div class="catalog-cover cover-purple"><span class="catalog-label">Dasar Perbankan</span><h3>General Banking Fundamentals</h3></div>
<div class="catalog-body"><div class="catalog-meta"><span>Level Dasar</span><span>Mandiri</span><span>Video &amp; Kuis</span></div><p>Memahami fungsi bank, produk dan layanan, struktur organisasi, proses operasional, serta etika dasar calon bankir.</p>
<ul class="catalog-outcomes"><li>Fungsi dan peran bank</li><li>Produk dan layanan utama</li><li>Etika serta budaya kerja</li></ul>
<div class="catalog-footer"><span class="catalog-status-text">Kelas Online</span><a class="catalog-link" href="{{ route('frontend.class.static', ['slug' => 'kelas-general-banking-fundamentals']) }}">Lihat detail →</a></div></div>
</article><article class="catalog-card" data-category="kredit" data-title="dasar analisis kredit perbankan kredit &amp; risiko mengenal proses kredit, analisis sederhana, dokumen pendukung, identifikasi risiko, dan prinsip kehati-hatian.">
<div class="catalog-cover cover-teal"><span class="catalog-label">Kredit &amp; Risiko</span><h3>Dasar Analisis Kredit Perbankan</h3></div>
<div class="catalog-body"><div class="catalog-meta"><span>Level Dasar</span><span>Mandiri</span><span>Studi Kasus</span></div><p>Mengenal proses kredit, analisis sederhana, dokumen pendukung, identifikasi risiko, dan prinsip kehati-hatian.</p>
<ul class="catalog-outcomes"><li>Alur proses kredit</li><li>Analisis 5C sederhana</li><li>Risiko dan mitigasi awal</li></ul>
<div class="catalog-footer"><span class="catalog-status-text">Kelas Online</span><a class="catalog-link" href="{{ route('frontend.class.static', ['slug' => 'kelas-dasar-analisis-kredit-perbankan']) }}">Lihat detail →</a></div></div>
</article><article class="catalog-card" data-category="karier" data-title="persiapan seleksi dan karier perbankan karier bankir membantu peserta menyiapkan cv, memahami tahapan rekrutmen, menghadapi wawancara, dan mengenali etika kerja profesional.">
<div class="catalog-cover cover-gold"><span class="catalog-label">Karier Bankir</span><h3>Persiapan Seleksi dan Karier Perbankan</h3></div>
<div class="catalog-body"><div class="catalog-meta"><span>Level Pemula</span><span>Mandiri</span><span>Latihan</span></div><p>Membantu peserta menyiapkan CV, memahami tahapan rekrutmen, menghadapi wawancara, dan mengenali etika kerja profesional.</p>
<ul class="catalog-outcomes"><li>CV dan profil profesional</li><li>Wawancara dan psikotes</li><li>Kesiapan 90 hari pertama</li></ul>
<div class="catalog-footer"><span class="catalog-status-text">Kelas Online</span><a class="catalog-link" href="{{ route('frontend.class.static', ['slug' => 'kelas-persiapan-seleksi-dan-karier-perbankan']) }}">Lihat detail →</a></div></div>
</article><article class="catalog-card" data-category="digital" data-title="ai literacy for banking professionals digital banking pengenalan penggunaan ai sebagai alat bantu kerja, batas penggunaan, verifikasi manusia, keamanan informasi, dan tata kelola dasar.">
<div class="catalog-cover cover-rose"><span class="catalog-label">Digital Banking</span><h3>AI Literacy for Banking Professionals</h3></div>
<div class="catalog-body"><div class="catalog-meta"><span>Level Menengah</span><span>Mandiri</span><span>Digital Skill</span></div><p>Pengenalan penggunaan AI sebagai alat bantu kerja, batas penggunaan, verifikasi manusia, keamanan informasi, dan tata kelola dasar.</p>
<ul class="catalog-outcomes"><li>Prompt kerja yang efektif</li><li>Verifikasi keluaran AI</li><li>Privasi dan tata kelola</li></ul>
<div class="catalog-footer"><span class="catalog-status-text">Kelas Online</span><a class="catalog-link" href="{{ route('frontend.class.static', ['slug' => 'kelas-ai-literacy-for-banking-professionals']) }}">Lihat detail →</a></div></div>
</article><article class="catalog-card" data-category="kepatuhan" data-title="apu ppt untuk pegawai bpr/bprs kepatuhan memahami prinsip apu ppt, pengenalan nasabah, pemantauan transaksi, pelaporan, dan tanggung jawab pegawai.">
<div class="catalog-cover cover-indigo"><span class="catalog-label">Kepatuhan</span><h3>APU PPT untuk Pegawai BPR/BPRS</h3></div>
<div class="catalog-body"><div class="catalog-meta"><span>Level Menengah</span><span>Blended</span><span>Kuis</span></div><p>Memahami prinsip APU PPT, pengenalan nasabah, pemantauan transaksi, pelaporan, dan tanggung jawab pegawai.</p>
<ul class="catalog-outcomes"><li>Customer due diligence</li><li>Red flags transaksi</li><li>Pelaporan dan dokumentasi</li></ul>
<div class="catalog-footer"><span class="catalog-status-text">Kelas Online</span><a class="catalog-link" href="{{ route('frontend.class.static', ['slug' => 'kelas-apu-ppt-untuk-pegawai-bpr-bprs']) }}">Lihat detail →</a></div></div>
</article><article class="catalog-card" data-category="risiko" data-title="manajemen risiko operasional perbankan manajemen risiko mengenali kejadian risiko operasional, kontrol, indikator, pencatatan insiden, dan rencana tindak lanjut.">
<div class="catalog-cover cover-blue"><span class="catalog-label">Manajemen Risiko</span><h3>Manajemen Risiko Operasional Perbankan</h3></div>
<div class="catalog-body"><div class="catalog-meta"><span>Level Menengah</span><span>Mandiri</span><span>Studi Kasus</span></div><p>Mengenali kejadian risiko operasional, kontrol, indikator, pencatatan insiden, dan rencana tindak lanjut.</p>
<ul class="catalog-outcomes"><li>Identifikasi risiko</li><li>Kontrol dan KRI</li><li>Loss event sederhana</li></ul>
<div class="catalog-footer"><span class="catalog-status-text">Kelas Online</span><a class="catalog-link" href="{{ route('frontend.class.static', ['slug' => 'kelas-manajemen-risiko-operasional-perbankan']) }}">Lihat detail →</a></div></div>
</article><article class="catalog-card" data-category="pemasaran" data-title="digital marketing untuk bpr/bprs pemasaran menyusun strategi konten, kanal digital, komunikasi produk, pengelolaan prospek, dan evaluasi kampanye.">
<div class="catalog-cover cover-purple"><span class="catalog-label">Pemasaran</span><h3>Digital Marketing untuk BPR/BPRS</h3></div>
<div class="catalog-body"><div class="catalog-meta"><span>Level Menengah</span><span>Blended</span><span>Praktik</span></div><p>Menyusun strategi konten, kanal digital, komunikasi produk, pengelolaan prospek, dan evaluasi kampanye.</p>
<ul class="catalog-outcomes"><li>Content planning</li><li>Lead management</li><li>Evaluasi kampanye</li></ul>
<div class="catalog-footer"><span class="catalog-status-text">Kelas Online</span><a class="catalog-link" href="{{ route('frontend.class.static', ['slug' => 'kelas-digital-marketing-untuk-bpr-bprs']) }}">Lihat detail →</a></div></div>
</article><article class="catalog-card" data-category="layanan" data-title="service excellence &amp; customer experience layanan nasabah mengembangkan standar layanan, komunikasi empatik, penanganan keluhan, dan pengalaman nasabah yang konsisten.">
<div class="catalog-cover cover-teal"><span class="catalog-label">Layanan Nasabah</span><h3>Service Excellence &amp; Customer Experience</h3></div>
<div class="catalog-body"><div class="catalog-meta"><span>Level Dasar</span><span>Mandiri</span><span>Simulasi</span></div><p>Mengembangkan standar layanan, komunikasi empatik, penanganan keluhan, dan pengalaman nasabah yang konsisten.</p>
<ul class="catalog-outcomes"><li>Standar layanan</li><li>Handling complaint</li><li>Customer journey</li></ul>
<div class="catalog-footer"><span class="catalog-status-text">Kelas Online</span><a class="catalog-link" href="{{ route('frontend.class.static', ['slug' => 'kelas-service-excellence-dan-customer-experience']) }}">Lihat detail →</a></div></div>
</article><article class="catalog-card" data-category="leadership" data-title="first-time manager in banking kepemimpinan pembekalan bagi supervisor dan manajer baru untuk mengelola target, tim, komunikasi, delegasi, dan evaluasi kinerja.">
<div class="catalog-cover cover-gold"><span class="catalog-label">Kepemimpinan</span><h3>First-Time Manager in Banking</h3></div>
<div class="catalog-body"><div class="catalog-meta"><span>Level Menengah</span><span>Blended</span><span>Action Plan</span></div><p>Pembekalan bagi supervisor dan manajer baru untuk mengelola target, tim, komunikasi, delegasi, dan evaluasi kinerja.</p>
<ul class="catalog-outcomes"><li>Transisi menjadi manajer</li><li>Delegasi dan coaching</li><li>Monitoring kinerja</li></ul>
<div class="catalog-footer"><span class="catalog-status-text">Kelas Online</span><a class="catalog-link" href="{{ route('frontend.class.static', ['slug' => 'kelas-first-time-manager-in-banking']) }}">Lihat detail →</a></div></div>
</article><article class="catalog-card" data-category="human-capital" data-title="kpi dan okr untuk organisasi perbankan human capital menyusun sasaran, indikator, target, bobot, monitoring, dan evaluasi kinerja yang lebih terstruktur.">
<div class="catalog-cover cover-rose"><span class="catalog-label">Human Capital</span><h3>KPI dan OKR untuk Organisasi Perbankan</h3></div>
<div class="catalog-body"><div class="catalog-meta"><span>Level Lanjutan</span><span>Mandiri</span><span>Template</span></div><p>Menyusun sasaran, indikator, target, bobot, monitoring, dan evaluasi kinerja yang lebih terstruktur.</p>
<ul class="catalog-outcomes"><li>Perumusan KPI</li><li>Penyusunan OKR</li><li>Dashboard monitoring</li></ul>
<div class="catalog-footer"><span class="catalog-status-text">Kelas Online</span><a class="catalog-link" href="{{ route('frontend.class.static', ['slug' => 'kelas-kpi-dan-okr-untuk-organisasi-perbankan']) }}">Lihat detail →</a></div></div>
</article><article class="catalog-card" data-category="digital" data-title="dasar tata kelola dan audit ti perbankan teknologi informasi memahami tata kelola ti, kontrol umum, risiko, dokumentasi, audit, dan tindak lanjut perbaikan.">
<div class="catalog-cover cover-blue"><span class="catalog-label">Teknologi Informasi</span><h3>Dasar Tata Kelola dan Audit TI Perbankan</h3></div>
<div class="catalog-body"><div class="catalog-meta"><span>Level Lanjutan</span><span>Blended</span><span>Studi Kasus</span></div><p>Memahami tata kelola TI, kontrol umum, risiko, dokumentasi, audit, dan tindak lanjut perbaikan.</p>
<ul class="catalog-outcomes"><li>IT governance</li><li>Kontrol dan bukti audit</li><li>Temuan dan action plan</li></ul>
<div class="catalog-footer"><span class="catalog-status-text">Kelas Online</span><a class="catalog-link" href="{{ route('frontend.class.static', ['slug' => 'kelas-dasar-tata-kelola-dan-audit-ti-perbankan']) }}">Lihat detail →</a></div></div>
</article><article class="catalog-card" data-category="umkm" data-title="keuangan praktis untuk pelaku umkm umkm membantu pelaku usaha memisahkan uang pribadi, mencatat transaksi, menghitung hpp, margin, dan arus kas.">
<div class="catalog-cover cover-indigo"><span class="catalog-label">UMKM</span><h3>Keuangan Praktis untuk Pelaku UMKM</h3></div>
<div class="catalog-body"><div class="catalog-meta"><span>Level Dasar</span><span>Mandiri</span><span>Worksheet</span></div><p>Membantu pelaku usaha memisahkan uang pribadi, mencatat transaksi, menghitung HPP, margin, dan arus kas.</p>
<ul class="catalog-outcomes"><li>Buku kas sederhana</li><li>HPP dan harga jual</li><li>Arus kas usaha</li></ul>
<div class="catalog-footer"><span class="catalog-status-text">Kelas Online</span><a class="catalog-link" href="{{ route('frontend.class.static', ['slug' => 'kelas-keuangan-praktis-untuk-pelaku-umkm']) }}">Lihat detail →</a></div></div>
</article></div>
<div class="empty-state" id="emptyState"><h3>Kelas belum ditemukan</h3><p>Coba gunakan kata kunci atau kategori lain.</p></div>
</div></section>
<section class="section section-soft"><div class="container">@include('frontend.components.section-head', [
    'eyebrow' => 'Learning Journey',
    'title' => 'Alur Belajar yang Lebih Terstruktur',
    'description' => 'Setiap kelas dapat berdiri sendiri atau dirangkai menjadi jalur pembelajaran sesuai profil peserta dan tujuan pengembangan.',
])<div class="pathway-grid"><article class="pathway-card"><span class="pathway-no">01</span><h3>Pilih Kelas</h3><p>Tentukan topik, level, format, dan hasil belajar yang paling relevan.</p></article><article class="pathway-card"><span class="pathway-no">02</span><h3>Pelajari Materi</h3><p>Ikuti video, e-book, studi kasus, latihan, atau sesi langsung sesuai program.</p></article><article class="pathway-card"><span class="pathway-no">03</span><h3>Kerjakan Evaluasi</h3><p>Ukur pemahaman melalui kuis, tugas, simulasi, atau action plan.</p></article><article class="pathway-card"><span class="pathway-no">04</span><h3>Terapkan</h3><p>Gunakan hasil pembelajaran dalam pekerjaan, karier, atau pengembangan usaha.</p></article></div><div class="learning-note"><strong>Catatan:</strong> fitur, masa akses, asesmen, fasilitator, sertifikat, dan harga mengikuti ketentuan masing-masing kelas. Kelas institusi dapat disesuaikan melalui layanan Capacity Building dan LMS.</div></div></section>
<section class="final-cta"><div class="container"><div class="cta-box"><div><h2>Butuh Learning Path Khusus untuk Institusi?</h2><p>Tim Bankir Academy dapat membantu menyusun kombinasi kelas, asesmen, LMS, dan laporan sesuai kompetensi serta target organisasi.</p></div><div class="cta-actions"><a class="btn btn-light" href="{{ route('frontend.service.capacity-building') }}">Lihat Capacity Building</a><a class="btn btn-secondary" href="{{ route('frontend.support.contact') }}">Diskusikan Kebutuhan</a></div></div></div></section>
<script>
    const classSearch = document.getElementById('classSearch');
    const classSort = document.getElementById('classSort');
    const classGrid = document.getElementById('classGrid');
    const classCards = [...document.querySelectorAll('.catalog-card')];
    const classFilters = [...document.querySelectorAll('.class-filter')];
    const emptyState = document.getElementById('emptyState');
    let activeClassFilter = 'all';
    function updateClasses() {
        const query = (classSearch?.value || '').toLowerCase().trim();
        let visible = 0;
        classCards.forEach(card => {
            const matchesFilter = activeClassFilter === 'all' || card.dataset.category === activeClassFilter;
            const matchesSearch = !query || card.dataset.title.includes(query);
            const show = matchesFilter && matchesSearch;
            card.classList.toggle('hidden', !show);
            if (show) visible++;
        });
        emptyState?.classList.toggle('show', visible === 0);
    }
    classFilters.forEach(button => button.addEventListener('click', () => {
        activeClassFilter = button.dataset.filter;
        classFilters.forEach(item => item.classList.remove('active'));
        button.classList.add('active');
        updateClasses();
    }));
    classSearch?.addEventListener('input', updateClasses);
    classSort?.addEventListener('change', () => {
        const cards = [...classCards];
        if (classSort.value === 'az') cards.sort((a, b) => a.querySelector('h3').textContent.localeCompare(b.querySelector('h3').textContent));
        if (classSort.value === 'za') cards.sort((a, b) => b.querySelector('h3').textContent.localeCompare(a.querySelector('h3').textContent));
        cards.forEach(card => classGrid.appendChild(card));
    });
</script>
@endsection
