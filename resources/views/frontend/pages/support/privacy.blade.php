@extends('layouts.appfrontend')

@section('page-title')
Kebijakan Privasi | Bankir Academy
@endsection

@section('page-description')
Kebijakan Privasi Bankir Academy mengenai pengumpulan, penggunaan, penyimpanan, pengungkapan, keamanan, dan hak pengguna atas data pribadi.
@endsection

@section('content')
<section class="legal-hero">
<div class="container hero-grid">
<div>
<span class="eyebrow">Pusat Bantuan</span>
<h1>Kebijakan Privasi</h1>
<p class="hero-copy">
          Kebijakan ini menjelaskan cara Bankir Academy mengumpulkan, menggunakan,
          menyimpan, membagikan, melindungi, dan menghapus data pribadi ketika Anda
          mengakses situs, membuat akun, mengikuti program, melakukan transaksi,
          atau berinteraksi melalui kanal resmi kami.
        </p>
<div class="meta-row">
<span class="meta-pill">Berlaku sejak 3 Agustus 2026</span>
<span class="meta-pill">Versi 1.0</span>
<span class="meta-pill">Mengacu pada hukum Indonesia</span>
</div>
</div>
<div aria-label="Ilustrasi pelindungan data pribadi" class="illustration-card">
<svg aria-labelledby="privacyTitle privacyDesc" role="img" viewbox="0 0 620 500">
<title id="privacyTitle">Pelindungan Data Pribadi Bankir Academy</title>
<desc id="privacyDesc">Ilustrasi perisai, dokumen, profil pengguna, dan sistem keamanan digital.</desc>
<defs>
<lineargradient id="privacyBg" x1="0" x2="1" y1="0" y2="1">
<stop offset="0%" stop-color="#6757D9"></stop>
<stop offset="100%" stop-color="#342A78"></stop>
</lineargradient>
<lineargradient id="privacyShield" x1="0" x2="1">
<stop offset="0%" stop-color="#00B7A8"></stop>
<stop offset="100%" stop-color="#53DDD1"></stop>
</lineargradient>
<filter height="140%" id="privacyShadow" width="140%" x="-20%" y="-20%">
<fedropshadow dx="0" dy="16" flood-color="#211C58" flood-opacity=".16" stddeviation="16"></fedropshadow>
</filter>
</defs>
<rect fill="url(#privacyBg)" height="420" opacity=".10" rx="45" width="570" x="25" y="38"></rect>
<circle cx="530" cy="92" fill="#FFC95C" opacity=".9" r="31"></circle>
<circle cx="90" cy="398" fill="#00B7A8" opacity=".16" r="45"></circle>
<path d="M42 140C132 61 224 68 294 119S463 196 580 111" fill="none" opacity=".65" stroke="#8D82EC" stroke-dasharray="8 11" stroke-width="3"></path>
<g filter="url(#privacyShadow)">
<rect fill="#fff" height="340" rx="27" width="350" x="116" y="82"></rect>
<rect fill="url(#privacyBg)" height="76" rx="27" width="350" x="116" y="82"></rect>
<rect fill="url(#privacyBg)" height="28" width="350" x="116" y="130"></rect>
<circle cx="157" cy="119" fill="#fff" opacity=".18" r="19"></circle>
<text fill="#fff" font-family="Arial" font-size="14" font-weight="700" text-anchor="middle" x="157" y="125">BA</text>
<text fill="#fff" font-family="Arial" font-size="15" font-weight="700" x="190" y="114">BANKIR ACADEMY</text>
<text fill="#DDD9FF" font-family="Arial" font-size="9" x="190" y="134">PRIVACY &amp; DATA CONTROL</text>
<circle cx="195" cy="216" fill="#F1EFFF" r="34"></circle>
<circle cx="195" cy="207" fill="#6757D9" r="11"></circle>
<path d="M170 237c7-19 42-19 50 0" fill="#6757D9"></path>
<rect fill="#29235C" height="11" rx="5.5" width="160" x="250" y="191"></rect>
<rect fill="#DEDCEA" height="7" rx="3.5" width="130" x="250" y="215"></rect>
<rect fill="#E9E8F1" height="7" rx="3.5" width="150" x="250" y="234"></rect>
<rect fill="#F1EFFF" height="17" rx="8.5" width="276" x="153" y="282"></rect>
<rect fill="#E6E4F0" height="9" rx="4.5" width="215" x="153" y="315"></rect>
<rect fill="#E6E4F0" height="9" rx="4.5" width="246" x="153" y="338"></rect>
<rect fill="#E6E4F0" height="9" rx="4.5" width="188" x="153" y="361"></rect>
</g>
<g filter="url(#privacyShadow)" transform="translate(398 273)">
<path d="M64 0C91 21 109 25 128 28v62c0 43-28 74-64 92C28 164 0 133 0 90V28C19 25 37 21 64 0Z" fill="url(#privacyShield)"></path>
<rect fill="#fff" height="43" rx="10" width="48" x="40" y="73"></rect>
<path d="M49 75V61c0-20 30-20 30 0v14" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="10"></path>
<circle cx="64" cy="92" fill="#087E76" r="5"></circle>
<rect fill="#087E76" height="12" rx="3" width="6" x="61" y="95"></rect>
</g>
<g filter="url(#privacyShadow)" transform="translate(58 254)">
<rect fill="#fff" height="92" rx="18" width="125"></rect>
<circle cx="38" cy="37" fill="#FFC95C" r="18"></circle>
<path d="M31 37l6 6 11-14" fill="none" stroke="#554A9C" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"></path>
<rect fill="#6757D9" height="7" rx="3.5" width="36" x="68" y="27"></rect>
<rect fill="#D7D4E8" height="6" rx="3" width="28" x="68" y="43"></rect>
<rect fill="#ECEAF4" height="5" rx="2.5" width="82" x="22" y="70"></rect>
</g>
</svg>
</div>
</div>
</section>
<section class="legal-section">
<div class="container legal-layout">
<aside aria-label="Daftar isi Kebijakan Privasi" class="legal-sidebar">
<h2>Daftar Isi</h2>
<nav class="toc">
<a href="#pendahuluan">1. Pendahuluan</a>
<a href="#cakupan">2. Cakupan Kebijakan</a>
<a href="#data-dikumpulkan">3. Data yang Dikumpulkan</a>
<a href="#sumber-data">4. Sumber Data</a>
<a href="#tujuan">5. Tujuan Pemrosesan</a>
<a href="#dasar">6. Dasar Pemrosesan</a>
<a href="#cookie">7. Cookie dan Teknologi</a>
<a href="#pengungkapan">8. Pengungkapan Data</a>
<a href="#transfer">9. Transfer Data</a>
<a href="#penyimpanan">10. Retensi dan Penghapusan</a>
<a href="#keamanan">11. Keamanan Data</a>
<a href="#hak">12. Hak Subjek Data</a>
<a href="#anak">13. Data Anak</a>
<a href="#komunikasi">14. Komunikasi</a>
<a href="#pihak-ketiga">15. Tautan Pihak Ketiga</a>
<a href="#insiden">16. Insiden Data</a>
<a href="#perubahan">17. Perubahan Kebijakan</a>
<a href="#kontak">18. Kontak dan Pengaduan</a>
</nav>
</aside>
<article class="legal-content">
<div class="notice">
<strong>Ringkasan penting:</strong> Bankir Academy memproses data pribadi secara terbatas
          untuk menyediakan layanan, mengelola program, memproses transaksi, menerbitkan sertifikat,
          menjaga keamanan, memenuhi kewajiban hukum, serta meningkatkan pengalaman pengguna.
        </div>
<section class="legal-article" id="pendahuluan">
<h2><span class="article-no">01</span>Pendahuluan</h2>
<p><strong>Bankir Academy</strong> menghormati privasi dan berkomitmen melindungi data pribadi pengguna, peserta, instruktur, mitra, calon kandidat, pelanggan institusi, pengunjung situs, serta pihak lain yang berinteraksi dengan layanan kami.</p>
<p>Kebijakan ini perlu dibaca bersama Syarat dan Ketentuan, informasi program, formulir persetujuan, perjanjian kerja sama, serta pemberitahuan privasi khusus yang mungkin diberikan untuk kegiatan tertentu.</p>
</section>
<section class="legal-article" id="cakupan">
<h2><span class="article-no">02</span>Cakupan Kebijakan</h2>
<p>Kebijakan ini berlaku terhadap pemrosesan data melalui:</p>
<ul>
<li>situs <strong>bankiracademy.co.id</strong>, halaman, subdomain, formulir, dan akun pengguna;</li>
<li>Learning Management System, kelas daring, webinar, pelatihan tatap muka, asesmen, sertifikat, dan materi digital;</li>
<li>layanan Banking Solution, Capacity Building, Talent Solutions, Job Connect, CSR, Bakti Pendidikan, dan Bakti UMKM;</li>
<li>email, telepon, WhatsApp, media sosial, formulir pendaftaran, survei, dan kanal dukungan resmi;</li>
<li>kegiatan kolaborasi bersama bank, BPR/BPRS, perusahaan, sekolah, kampus, komunitas, atau mitra lainnya.</li>
</ul>
</section>
<section class="legal-article" id="data-dikumpulkan">
<h2><span class="article-no">03</span>Jenis Data yang Dapat Dikumpulkan</h2>
<p>Data yang dikumpulkan bergantung pada layanan yang digunakan dan dapat meliputi:</p>
<ol>
<li><strong>Data identitas:</strong> nama, tempat dan tanggal lahir, jenis identitas, nomor identitas apabila benar-benar diperlukan, serta foto profil.</li>
<li><strong>Data kontak:</strong> email, nomor telepon, alamat korespondensi, dan akun media sosial.</li>
<li><strong>Data akun:</strong> nama pengguna, kata sandi terenkripsi, preferensi, status keanggotaan, dan riwayat akses.</li>
<li><strong>Data pendidikan dan pekerjaan:</strong> sekolah, perguruan tinggi, jurusan, perusahaan, jabatan, pengalaman, CV, portofolio, dan kompetensi.</li>
<li><strong>Data program:</strong> kehadiran, hasil kuis atau asesmen, tugas, progres belajar, sertifikat, umpan balik, dan komunikasi dengan fasilitator.</li>
<li><strong>Data transaksi:</strong> program yang dibeli, nilai transaksi, waktu pembayaran, status verifikasi, dan informasi penagihan. Informasi kartu atau rekening tertentu dapat diproses langsung oleh penyedia pembayaran.</li>
<li><strong>Data teknis:</strong> alamat IP, jenis perangkat, browser, log aktivitas, identifikasi sesi, cookie, halaman yang dikunjungi, dan data keamanan.</li>
<li><strong>Dokumentasi:</strong> foto, video, rekaman suara, testimoni, dan materi kegiatan berdasarkan pemberitahuan atau persetujuan yang relevan.</li>
</ol>
<div class="highlight-box"><strong>Prinsip minimalisasi:</strong> kami berupaya hanya meminta data yang relevan dan diperlukan untuk tujuan yang telah dijelaskan.</div>
</section>
<section class="legal-article" id="sumber-data">
<h2><span class="article-no">04</span>Sumber Perolehan Data</h2>
<p>Data dapat diperoleh langsung dari pengguna, dari institusi yang mendaftarkan peserta, dari mitra program, dari penggunaan sistem, dari penyedia pembayaran, atau dari sumber yang secara sah tersedia untuk publik.</p>
<p>Pihak yang memberikan data orang lain wajib memastikan bahwa pemberian data tersebut memiliki kewenangan atau dasar yang sah dan bahwa pemilik data telah memperoleh informasi yang memadai.</p>
</section>
<section class="legal-article" id="tujuan">
<h2><span class="article-no">05</span>Tujuan Pemrosesan Data</h2>
<p>Bankir Academy dapat memproses data untuk:</p>
<ul>
<li>membuat dan mengelola akun;</li>
<li>memverifikasi pendaftaran, transaksi, kehadiran, dan identitas peserta;</li>
<li>menyediakan kelas, LMS, materi, asesmen, sertifikat, konsultasi, dan dukungan;</li>
<li>menghubungkan kandidat dengan peluang kerja berdasarkan persetujuan dan ketentuan layanan;</li>
<li>menyusun laporan program, analisis pembelajaran, evaluasi, dan tindak lanjut;</li>
<li>mengirim pemberitahuan operasional, perubahan jadwal, pengingat, dan informasi layanan;</li>
<li>mencegah penipuan, penyalahgunaan akun, perjokian, gangguan sistem, dan pelanggaran keamanan;</li>
<li>memenuhi kewajiban hukum, perpajakan, pembukuan, audit, dan penyelesaian sengketa;</li>
<li>meningkatkan kualitas konten, fitur, layanan, keamanan, serta pengalaman pengguna;</li>
<li>menyampaikan promosi atau rekomendasi program sesuai persetujuan atau dasar yang sah.</li>
</ul>
</section>
<section class="legal-article" id="dasar">
<h2><span class="article-no">06</span>Dasar Pemrosesan</h2>
<p>Pemrosesan dilakukan berdasarkan satu atau lebih dasar yang sesuai, antara lain persetujuan yang sah, pelaksanaan perjanjian, pemenuhan kewajiban hukum, pelindungan kepentingan vital, pelaksanaan tugas untuk kepentingan umum apabila relevan, atau kepentingan sah dengan tetap memperhatikan hak pengguna.</p>
<p>Apabila pemrosesan bergantung pada persetujuan, pengguna dapat menarik persetujuan melalui kanal resmi. Penarikan tidak memengaruhi keabsahan pemrosesan yang telah dilakukan sebelum persetujuan ditarik.</p>
</section>
<section class="legal-article" id="cookie">
<h2><span class="article-no">07</span>Cookie dan Teknologi Serupa</h2>
<p>Situs dapat menggunakan cookie wajib, fungsional, analitik, dan pemasaran untuk menjaga sesi, mengingat preferensi, mengukur penggunaan, meningkatkan keamanan, dan memahami efektivitas layanan.</p>
<p>Pengguna dapat mengatur cookie melalui browser atau pusat preferensi cookie apabila tersedia. Menonaktifkan cookie tertentu dapat menyebabkan beberapa fungsi situs tidak berjalan secara optimal.</p>
</section>
<section class="legal-article" id="pengungkapan">
<h2><span class="article-no">08</span>Pengungkapan kepada Pihak Lain</h2>
<p>Data dapat dibagikan secara terbatas kepada:</p>
<ul>
<li>penyedia hosting, LMS, cloud, konferensi video, email, WhatsApp, analitik, pembayaran, dan dukungan teknologi;</li>
<li>instruktur, mentor, asesor, panitia, dan mitra pelaksana sesuai kebutuhan program;</li>
<li>institusi pendaftar atau pemberi program untuk pelaporan yang telah disepakati;</li>
<li>perusahaan perekrut atau mitra Job Connect hanya untuk kandidat yang mengikuti proses terkait;</li>
<li>auditor, penasihat profesional, regulator, aparat, atau pengadilan apabila diwajibkan hukum;</li>
<li>pihak dalam restrukturisasi, penggabungan, pengalihan usaha, atau transaksi korporasi yang sah.</li>
</ul>
<p>Kami tidak menjual data pribadi kepada pengiklan.</p>
</section>
<section class="legal-article" id="transfer">
<h2><span class="article-no">09</span>Transfer dan Penyimpanan Lintas Wilayah</h2>
<p>Beberapa penyedia teknologi dapat menyimpan atau memproses data pada pusat data di luar wilayah Indonesia. Dalam kondisi tersebut, Bankir Academy akan menerapkan langkah yang wajar dan sesuai hukum untuk memastikan tingkat pelindungan data yang memadai, termasuk pengaturan kontraktual dan penilaian terhadap penyedia.</p>
</section>
<section class="legal-article" id="penyimpanan">
<h2><span class="article-no">10</span>Retensi dan Penghapusan Data</h2>
<p>Data disimpan selama diperlukan untuk tujuan pemrosesan, masa layanan, kewajiban administrasi, pembukuan, perpajakan, audit, keamanan, penanganan keluhan, dan jangka waktu yang diwajibkan peraturan.</p>
<p>Setelah tidak diperlukan, data akan dihapus, dimusnahkan, dianonimkan, atau dibatasi penggunaannya sesuai kemampuan sistem dan kewajiban hukum yang berlaku.</p>
</section>
<section class="legal-article" id="keamanan">
<h2><span class="article-no">11</span>Keamanan Data</h2>
<p>Bankir Academy menerapkan langkah administratif, teknis, dan organisasional yang proporsional, seperti pembatasan akses, autentikasi, pencatatan aktivitas, enkripsi pada kondisi tertentu, pencadangan, pembaruan sistem, pengelolaan vendor, dan edukasi personel.</p>
<p>Tidak ada sistem yang sepenuhnya bebas risiko. Pengguna juga bertanggung jawab menjaga kata sandi, OTP, perangkat, tautan kelas, dan kredensial aksesnya.</p>
</section>
<section class="legal-article" id="hak">
<h2><span class="article-no">12</span>Hak Subjek Data Pribadi</h2>
<p>Sesuai ketentuan yang berlaku, pengguna dapat mengajukan permintaan untuk:</p>
<ul>
<li>memperoleh informasi mengenai identitas pihak yang meminta data, dasar kepentingan, tujuan permintaan, dan akuntabilitas pihak terkait;</li>
<li>mengakses atau memperoleh salinan data pribadi;</li>
<li>melengkapi, memperbarui, atau memperbaiki data yang tidak akurat;</li>
<li>mengakhiri pemrosesan, menghapus, atau memusnahkan data dalam kondisi yang diperbolehkan hukum;</li>
<li>menarik persetujuan;</li>
<li>mengajukan keberatan terhadap keputusan yang hanya didasarkan pada pemrosesan otomatis apabila relevan;</li>
<li>membatasi pemrosesan secara proporsional;</li>
<li>mengajukan pengaduan dan menuntut ganti rugi sesuai mekanisme hukum;</li>
<li>memperoleh dan menggunakan data dalam format yang lazim serta dapat dibaca sistem apabila persyaratannya terpenuhi.</li>
</ul>
<p>Kami dapat meminta verifikasi identitas dan menolak atau membatasi permintaan yang tidak sah, berlebihan, mengganggu hak pihak lain, atau dikecualikan oleh peraturan.</p>
</section>
<section class="legal-article" id="anak">
<h2><span class="article-no">13</span>Data Anak dan Peserta di Bawah Umur</h2>
<p>Program untuk peserta di bawah umur dilaksanakan dengan perhatian khusus. Pendaftaran, dokumentasi, komunikasi, dan pemrosesan data dapat memerlukan persetujuan orang tua, wali, sekolah, atau pihak yang berwenang sesuai karakter program dan ketentuan hukum.</p>
<p>Kami berupaya membatasi data anak, menghindari publikasi berlebihan, dan menerapkan pengaturan akses yang lebih ketat.</p>
</section>
<section class="legal-article" id="komunikasi">
<h2><span class="article-no">14</span>Komunikasi Transaksional dan Pemasaran</h2>
<p>Kami dapat mengirim pesan operasional mengenai akun, transaksi, jadwal, keamanan, sertifikat, atau perubahan layanan. Pesan tersebut merupakan bagian dari pelaksanaan layanan.</p>
<p>Komunikasi promosi dapat dihentikan melalui tautan berhenti berlangganan, pengaturan akun, atau permintaan kepada kontak resmi. Penghentian promosi tidak otomatis menghentikan pesan transaksional.</p>
</section>
<section class="legal-article" id="pihak-ketiga">
<h2><span class="article-no">15</span>Tautan dan Layanan Pihak Ketiga</h2>
<p>Situs dapat memuat tautan atau integrasi pihak ketiga. Kebijakan privasi pihak tersebut berlaku terhadap layanan yang mereka kelola. Pengguna disarankan membaca kebijakan mereka sebelum menyerahkan data.</p>
</section>
<section class="legal-article" id="insiden">
<h2><span class="article-no">16</span>Insiden Pelindungan Data</h2>
<p>Apabila terjadi insiden yang berdampak pada data pribadi, Bankir Academy akan melakukan penilaian, pengendalian, pemulihan, dokumentasi, dan pemberitahuan kepada pihak yang relevan sesuai tingkat risiko serta kewajiban hukum yang berlaku.</p>
</section>
<section class="legal-article" id="perubahan">
<h2><span class="article-no">17</span>Perubahan Kebijakan Privasi</h2>
<p>Kebijakan ini dapat diperbarui untuk menyesuaikan layanan, teknologi, praktik operasional, kebutuhan keamanan, atau perubahan hukum. Tanggal versi terbaru akan dicantumkan pada halaman ini dan perubahan material akan diinformasikan secara wajar.</p>
</section>
<section class="legal-article" id="kontak">
<h2><span class="article-no">18</span>Kontak, Permintaan Hak, dan Pengaduan</h2>
<p>Permintaan terkait data pribadi dapat diajukan melalui:</p>
<div class="highlight-box">
<strong>Bankir Academy</strong><br/>
            Situs: bankiracademy.co.id<br/>
            Email: info@bankiracademy.co.id<br/>
            Alamat: Permata Puri, Ngaliyan, Semarang, Jawa Tengah<br/>
            Jam layanan: Senin–Jumat, 08.00–17.00 WIB
          </div>
<p>Sertakan nama, kontak terdaftar, hubungan dengan Bankir Academy, jenis permintaan, serta informasi pendukung. Kami dapat meminta verifikasi tambahan untuk mencegah pengungkapan data kepada pihak yang tidak berwenang.</p>
</section>
<div class="help-card">
<div>
<h2>Memiliki pertanyaan tentang data Anda?</h2>
<p>Tim Bankir Academy siap menerima permintaan akses, koreksi, penghapusan, atau pengaduan privasi.</p>
</div>
<a class="btn" href="mailto:info@bankiracademy.co.id">Hubungi Kami</a>
</div>
</article>
</div>
</section>

@endsection
