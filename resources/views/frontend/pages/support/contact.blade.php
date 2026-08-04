@extends('layouts.appfrontend')

@section('page-title')
Kontak Kami | Bankir Academy
@endsection

@section('page-description')
Hubungi Bankir Academy untuk konsultasi pelatihan, layanan perbankan, pengembangan talenta, LMS, program CSR, kerja sama pendidikan, dan dukungan pengguna.
@endsection

@section('content')
<section class="contact-hero" id="kontak">
<div class="container contact-hero-grid">
<div>
<span class="eyebrow">Pusat Bantuan &amp; Kolaborasi</span>
<h1>Mari Diskusikan Kebutuhan Anda Bersama <span class="gradient-text">Bankir Academy</span></h1>
<p class="contact-lead">Hubungi kami untuk konsultasi pelatihan, solusi perbankan, pengembangan talenta, LMS, program CSR, kerja sama sekolah atau kampus, pemberdayaan UMKM, serta dukungan penggunaan layanan.</p>
<div class="contact-actions">
<a class="btn btn-primary" href="#form-kontak">Kirim Pesan <span>→</span></a>
<a class="btn btn-outline" href="mailto:info@bankiracademy.co.id">Kirim Email</a>
</div>
<div class="contact-proof">
<span><i>✓</i>Respons terarah sesuai kebutuhan</span>
<span><i>✓</i>Konsultasi awal tanpa komitmen</span>
<span><i>✓</i>Dukungan institusi dan individu</span>
</div>
</div>
<div aria-label="Ilustrasi pusat komunikasi Bankir Academy" class="contact-visual">
<div class="contact-dashboard">
<div class="contact-dashboard-top"><span>CONTACT &amp; COLLABORATION HUB</span><span>Ready to Help</span></div>
<div class="contact-dashboard-main"><small>Integrated Support</small><h3>Connect. Discuss. Design. Deliver.</h3><p>Satu pintu untuk konsultasi program, pertanyaan layanan, kerja sama, dan dukungan pengguna.</p></div>
<div class="contact-mini-grid">
<div class="contact-mini-card"><strong>Program Consultation</strong><span>Pemetaan kebutuhan dan pilihan solusi</span></div>
<div class="contact-mini-card"><strong>Client Support</strong><span>Bantuan akun, program, dan transaksi</span></div>
<div class="contact-mini-card"><strong>Partnership</strong><span>Kolaborasi bank, sekolah, kampus, dan komunitas</span></div>
<div class="contact-mini-card"><strong>Talent &amp; Career</strong><span>Headhunting, outsourcing, dan Job Connect</span></div>
</div>
</div>
<div class="contact-float one"><i>✉</i><span><strong>Email Support</strong><span>info@bankiracademy.co.id</span></span></div>
<div class="contact-float two"><i>⌂</i><span><strong>Semarang, Indonesia</strong><span>Senin–Jumat, 08.00–17.00 WIB</span></span></div>
</div>
</div>
</section>
<div class="contact-strip"><div class="container contact-strip-grid">
<div class="contact-strip-copy"><strong>Satu kanal untuk berbagai kebutuhan</strong><span>Pilih topik yang paling relevan agar pesan Anda diteruskan kepada tim yang tepat.</span></div>
<div class="strip-item"><i>▦</i>Program &amp; Pelatihan</div><div class="strip-item"><i>◇</i>Talent Solutions</div><div class="strip-item"><i>♡</i>Kolaborasi Sosial</div>
</div></div>
<section class="contact-section" id="kanal">
<div class="container">
@include('frontend.components.section-head', [
    'eyebrow' => 'Kanal Komunikasi',
    'title' => 'Pilih Cara Menghubungi Kami yang Paling Nyaman',
    'description' => 'Gunakan kanal resmi Bankir Academy agar pertanyaan, permintaan, atau keluhan dapat tercatat dan ditindaklanjuti dengan tepat.',
])
<div class="contact-channel-grid">
<article class="channel-card"><i>✉</i><h3>Email</h3><p>Untuk proposal, dokumen resmi, pertanyaan layanan, dan korespondensi yang memerlukan lampiran.</p><a href="mailto:info@bankiracademy.co.id">info@bankiracademy.co.id →</a></article>
<article class="channel-card"><i>☎</i><h3>WhatsApp</h3><p>Untuk konsultasi awal, konfirmasi program, serta dukungan cepat pada jam layanan.</p><a href="#form-kontak">Minta dihubungi →</a></article>
<article class="channel-card"><i>⌂</i><h3>Kunjungan &amp; Pertemuan</h3><p>Pertemuan tatap muka dilakukan berdasarkan penjadwalan dan konfirmasi terlebih dahulu.</p><a href="#form-kontak">Jadwalkan melalui formulir →</a></article>
<article class="channel-card"><i>◎</i><h3>Dukungan Pengguna</h3><p>Untuk kendala akun, pembayaran, kelas, materi, sertifikat, dan penggunaan platform.</p><a href="#form-kontak">Ajukan bantuan →</a></article>
</div>
</div>
</section>
<section class="contact-section section-soft" id="form-kontak">
<div class="container contact-layout">
<div class="contact-form-card">
<span class="eyebrow">Form Kontak</span><h2>Ceritakan Kebutuhan Anda</h2><p>Lengkapi informasi berikut agar tim kami dapat memahami konteks dan menyiapkan respons yang relevan.</p>
<form action="#" method="post">
<div class="form-grid">
<div class="form-group"><label for="nama">Nama lengkap *</label><input id="nama" name="nama" placeholder="Masukkan nama lengkap" required="" type="text"/></div>
<div class="form-group"><label for="institusi">Institusi / perusahaan</label><input id="institusi" name="institusi" placeholder="Nama bank, sekolah, perusahaan, atau usaha" type="text"/></div>
<div class="form-group"><label for="email">Email *</label><input id="email" name="email" placeholder="nama@institusi.co.id" required="" type="email"/></div>
<div class="form-group"><label for="telepon">Nomor WhatsApp *</label><input id="telepon" name="telepon" placeholder="08xxxxxxxxxx" required="" type="tel"/></div>
<div class="form-group full"><label for="kategori">Kategori kebutuhan *</label><select id="kategori" name="kategori" required=""><option value="">Pilih kategori</option><option>Capacity Building / Pelatihan</option><option>Banking Solution</option><option>Banking Talent Solution</option><option>Learning Management System</option><option>Inovasi Program</option><option>Headhunting / Outsourcing / Job Connect</option><option>Program CSR / Bakti Pendidikan / Bakti UMKM</option><option>Dukungan akun, kelas, pembayaran, atau sertifikat</option><option>Media, kemitraan, atau kebutuhan lainnya</option></select></div>
<div class="form-group full"><label for="subjek">Subjek *</label><input id="subjek" name="subjek" placeholder="Tuliskan ringkasan kebutuhan" required="" type="text"/></div>
<div class="form-group full"><label for="pesan">Pesan *</label><textarea id="pesan" name="pesan" placeholder="Jelaskan tujuan, jumlah peserta, waktu pelaksanaan, lokasi, kendala, atau hasil yang diharapkan." required=""></textarea><span class="form-help">Jangan mengirim kata sandi, kode OTP, nomor kartu, atau data sensitif lain melalui formulir ini.</span></div>
</div>
<label class="form-consent"><input required="" type="checkbox"/><span>Saya menyetujui pemrosesan data yang saya kirimkan untuk menanggapi pertanyaan ini sesuai Kebijakan Privasi Bankir Academy.</span></label>
<button class="btn btn-primary form-submit" type="submit">Kirim Pesan</button>
</form>
</div>
<aside class="contact-info-card">
<span class="eyebrow">Informasi Resmi</span><h2>Kontak Bankir Academy</h2><p>Pastikan Anda menggunakan kanal resmi berikut untuk menghindari informasi atau pembayaran yang tidak sah.</p>
<div class="info-list">
<div class="info-row"><i>✉</i><span><strong>Email</strong><a href="mailto:info@bankiracademy.co.id">info@bankiracademy.co.id</a></span></div>
<div class="info-row"><i>⌂</i><span><strong>Alamat</strong><span>Permata Puri, Ngaliyan, Semarang, Jawa Tengah</span></span></div>
<div class="info-row"><i>◷</i><span><strong>Jam layanan</strong><span>Senin–Jumat, 08.00–17.00 WIB<br/>Selain hari libur nasional</span></span></div>
<div class="info-row"><i>◎</i><span><strong>Website</strong><a href="https://www.bankiracademy.co.id/">www.bankiracademy.co.id</a></span></div>
</div>
<div class="response-box"><h3>Bagaimana pesan ditangani?</h3><p>Pesan akan ditinjau, dikategorikan, kemudian diteruskan kepada tim yang relevan.</p><div class="response-steps"><div class="response-step"><strong>1. Review</strong><span>Pemeriksaan awal</span></div><div class="response-step"><strong>2. Routing</strong><span>Diteruskan ke tim</span></div><div class="response-step"><strong>3. Response</strong><span>Tindak lanjut</span></div></div></div>
</aside>
</div>
</section>
<section class="contact-section" id="kebutuhan">
<div class="container">@include('frontend.components.section-head', [
    'eyebrow' => 'Kami Dapat Membantu',
    'title' => 'Berbagai Kebutuhan dalam Satu Ekosistem',
    'description' => 'Tim kami dapat membantu mengarahkan kebutuhan Anda ke layanan dan bentuk kerja sama yang paling sesuai.',
])
<div class="needs-grid">
<article class="need-card"><i>↗</i><h3>Pelatihan &amp; Capacity Building</h3><p>Public class, in-house training, workshop, coaching, blended learning, serta program pengembangan pimpinan.</p></article>
<article class="need-card"><i>▦</i><h3>Solusi Institusi</h3><p>Konsultasi, SOP, perangkat kerja, pendampingan proses, dashboard, digitalisasi, dan inovasi program.</p></article>
<article class="need-card"><i>◇</i><h3>Talent Solutions</h3><p>Pemetaan kompetensi, headhunting, outsourcing, Job Connect, talent pool, dan pengembangan karier.</p></article>
<article class="need-card"><i>▶</i><h3>LMS &amp; Pembelajaran Digital</h3><p>Implementasi LMS, kelas online, materi digital, asesmen, sertifikat, serta pelaporan pembelajaran.</p></article>
<article class="need-card"><i>♡</i><h3>Program CSR &amp; Foundations</h3><p>Bakti Pendidikan, literasi keuangan, persiapan karier, beasiswa belajar, dan pemberdayaan UMKM.</p></article>
<article class="need-card"><i>◎</i><h3>Dukungan Pengguna</h3><p>Bantuan akun, pendaftaran, pembayaran, akses materi, perubahan data, sertifikat, dan pengaduan.</p></article>
</div>
</div>
</section>
<section class="contact-section" id="faq"><div class="container">@include('frontend.components.section-head', [
    'eyebrow' => 'Pertanyaan Umum',
    'title' => 'Sebelum Menghubungi Kami',
    'description' => 'Beberapa informasi berikut dapat membantu Anda menyiapkan pertanyaan yang lebih lengkap.',
])<div class="faq-wrap">
<div class="faq-item"><button class="faq-q" type="button">Informasi apa yang perlu disampaikan untuk meminta proposal?<span class="faq-plus">＋</span></button><div class="faq-a">Sampaikan nama institusi, tujuan program, profil peserta, perkiraan jumlah peserta, waktu dan lokasi, format pelaksanaan, serta hasil yang diharapkan. Informasi tersebut membantu kami menyiapkan ruang lingkup awal.</div></div>
<div class="faq-item"><button class="faq-q" type="button">Apakah konsultasi awal dikenakan biaya?<span class="faq-plus">＋</span></button><div class="faq-a">Diskusi awal untuk memahami kebutuhan umumnya tidak dikenakan biaya. Biaya hanya berlaku apabila terdapat pekerjaan analisis, desain, asesmen, atau layanan lain yang disepakati.</div></div>
<div class="faq-item"><button class="faq-q" type="button">Apakah Bankir Academy melayani program di luar Semarang?<span class="faq-plus">＋</span></button><div class="faq-a">Ya. Program dapat diselenggarakan secara daring, tatap muka di lokasi mitra, maupun blended, dengan pengaturan transportasi, akomodasi, sarana, dan jadwal sesuai kesepakatan.</div></div>
<div class="faq-item"><button class="faq-q" type="button">Bagaimana melaporkan kendala akun atau pembayaran?<span class="faq-plus">＋</span></button><div class="faq-a">Cantumkan nama, email atau nomor telepon terdaftar, nama program, nomor transaksi bila tersedia, kronologi, dan bukti pendukung. Jangan pernah mengirim kata sandi atau kode OTP.</div></div>
<div class="faq-item"><button class="faq-q" type="button">Apakah saya dapat mengirim dokumen melalui formulir ini?<span class="faq-plus">＋</span></button><div class="faq-a">Form contoh ini belum menyediakan unggahan dokumen. Proposal, TOR, atau lampiran dapat dikirim melalui email resmi setelah memastikan alamat tujuan yang benar.</div></div>
</div></div></section>
<section class="contact-cta"><div class="container"><div class="contact-cta-box"><div><h2>Siap Memulai Diskusi?</h2><p>Sampaikan kebutuhan Anda dan tim Bankir Academy akan membantu mengarahkan langkah berikutnya.</p></div><div class="contact-cta-actions"><a class="btn btn-light" href="#form-kontak">Isi Form Kontak</a><a class="btn btn-secondary" href="mailto:info@bankiracademy.co.id">Kirim Email</a></div></div></div></section>
<script>
    document.querySelector('.contact-form-card form')?.addEventListener('submit', event => {
        event.preventDefault();
        alert('Form ini merupakan tampilan contoh. Hubungkan action form ke sistem backend sebelum dipublikasikan.');
    });
</script>
@endsection
