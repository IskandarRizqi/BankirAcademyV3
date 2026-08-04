@extends('layouts.appfrontend')

@section('page-title')
    Tanya Jawab (FAQ) — Bankir Academy
@endsection

@section('page-description')
    Pusat Tanya Jawab Bankir Academy mengenai kelas, pelatihan, LMS, solusi perbankan, talent solutions, CSR, Bakti
    Pendidikan, Bakti UMKM, akun, pembayaran, sertifikat, dan dukungan pengguna.
@endsection

@section('content')
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span class="eyebrow">Pusat Bantuan Bankir Academy</span>
                <h1>Temukan Jawaban untuk <span class="gradient-text">Setiap Layanan dan Program</span></h1>
                <p class="hero-lead">Pusat Tanya Jawab ini membantu peserta, kandidat, institusi, sekolah, kampus, bank,
                    BPR/BPRS, UMKM, komunitas, dan mitra memahami program, proses, hak, kewajiban, serta batasan layanan
                    Bankir Academy.</p>
                <div class="hero-actions"><a class="btn btn-primary" href="#daftar-faq">Cari Jawaban →</a><a
                        class="btn btn-outline" href="{{ route('frontend.support.contact') }}">Hubungi Tim Kami</a></div>
                <div class="hero-proof"><span class="proof-item"><span class="proof-icon">✓</span>Jawaban
                        dikelompokkan</span><span class="proof-item"><span class="proof-icon">✓</span>Mencakup seluruh
                        layanan</span><span class="proof-item"><span class="proof-icon">✓</span>Dilengkapi batasan
                        layanan</span></div>
            </div>
            <div class="hero-visual">
                <div class="visual-main">
                    <div class="faq-board">
                        <div class="board-top"><span>HELP &amp; KNOWLEDGE CENTER</span><span
                                class="board-status">Available</span></div>
                        <div class="board-search"><small>Pertanyaan populer</small><strong>Bagaimana memilih program yang
                                sesuai?</strong></div>
                        <div class="board-categories">
                            <div class="board-card"><i>🎓</i><strong>Pembelajaran</strong><span>Kelas, pelatihan, LMS</span>
                            </div>
                            <div class="board-card"><i>◇</i><strong>Talenta</strong><span>Talent, karier, rekrutmen</span>
                            </div>
                            <div class="board-card"><i>▦</i><strong>Institusi</strong><span>Banking solution dan
                                    inovasi</span></div>
                            <div class="board-card"><i>♡</i><strong>Dampak Sosial</strong><span>CSR dan foundations</span>
                            </div>
                        </div>
                        <div class="board-answer"><strong>Mulai dari kebutuhan dan hasil yang ingin dicapai.</strong>
                            <p>Tim akan membantu memetakan sasaran, peserta, metode, durasi, indikator, dan output program.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="float-card one"><i>?</i><span><strong>Pertanyaan Terstruktur</strong><span>Mudah dicari per
                            kategori</span></span></div>
                <div class="float-card two"><i>✓</i><span><strong>Jawaban Transparan</strong><span>Termasuk batasan
                            layanan</span></span></div>
            </div>
        </div>
    </section>
    <div class="quick-categories">
        <div class="container category-grid">
            <a class="category-link" href="#umum"><i>◎</i><span><strong>Umum</strong><span>Profil dan pemilihan
                        layanan</span></span></a>
            <a class="category-link" href="#pembelajaran"><i>▶</i><span><strong>Pembelajaran</strong><span>Kelas, pelatihan,
                        LMS</span></span></a>
            <a class="category-link" href="#institusi"><i>▦</i><span><strong>Institusi</strong><span>Solusi, inovasi,
                        CSR</span></span></a>
            <a class="category-link" href="#talenta"><i>◇</i><span><strong>Talenta</strong><span>Rekrutmen dan
                        karier</span></span></a>
            <a class="category-link" href="#administrasi"><i>✓</i><span><strong>Administrasi</strong><span>Akun, pembayaran,
                        sertifikat</span></span></a>
        </div>
    </div>
    <section class="section" id="daftar-faq">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Tanya Jawab Terintegrasi',
                'title' => 'Cari Berdasarkan Pertanyaan atau Kategori',
                'description' =>
                    'Ketik kata kunci seperti “sertifikat”, “LMS”, “headhunting”, “CSR”, “pembayaran”, atau nama layanan yang ingin dipahami.',
            ])
            <div class="help-tools">
                <div class="search-box"><span>⌕</span><label class="sr-only" for="faqSearch">Cari pertanyaan</label><input
                        id="faqSearch" placeholder="Cari pertanyaan atau layanan..." type="search" /><button
                        id="clearSearch" type="button">Bersihkan</button></div>
                <div class="filter-row">
                    <button class="filter-btn active" data-filter="all">Semua</button><button class="filter-btn"
                        data-filter="umum">Umum</button><button class="filter-btn"
                        data-filter="pembelajaran">Pembelajaran</button><button class="filter-btn"
                        data-filter="institusi">Institusi</button><button class="filter-btn"
                        data-filter="talenta">Talenta</button><button class="filter-btn" data-filter="foundation">CSR &amp;
                        Foundations</button><button class="filter-btn" data-filter="administrasi">Administrasi</button>
                </div>
            </div>
            <div class="faq-layout">
                <aside class="faq-sidebar">
                    <h3>Kategori FAQ</h3>
                    <div class="side-links">
                        <button class="active" data-scroll="umum">Umum</button><button
                            data-scroll="pembelajaran">Pembelajaran</button><button
                            data-scroll="institusi">Institusi</button><button data-scroll="talenta">Talent
                            Solutions</button><button data-scroll="foundation">CSR &amp; Foundations</button><button
                            data-scroll="administrasi">Akun &amp; Administrasi</button>
                    </div>
                    <div class="side-note">Informasi khusus pada halaman program, penawaran resmi, kontrak, atau perjanjian
                        kerja sama berlaku sebagai acuan untuk layanan yang bersangkutan.</div>
                </aside>
                <div class="faq-content">
                    <section class="faq-group" data-category="umum" id="umum">
                        <div class="group-head"><span class="group-icon">◎</span>
                            <div>
                                <h2>Informasi Umum</h2>
                                <p>Profil, sasaran, metode, dan pemilihan layanan.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="umum"><button class="faq-q">Apa itu Bankir Academy?<span
                                    class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Bankir Academy adalah platform pembelajaran dan pengembangan ekosistem perbankan yang
                                    menghubungkan peningkatan kompetensi, solusi institusi, pengembangan talenta,
                                    pembelajaran digital, riset terapan, serta program pemberdayaan bagi bank, BPR/BPRS,
                                    profesional, calon bankir, sekolah, kampus, UMKM, dan komunitas.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="umum"><button class="faq-q">Siapa yang dapat menggunakan
                                layanan Bankir Academy?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Layanan dapat digunakan oleh peserta individu, calon bankir, pegawai dan pimpinan bank,
                                    institusi keuangan, perusahaan, sekolah, kampus, pemerintah, asosiasi, komunitas, serta
                                    pelaku UMKM. Kelayakan peserta tetap mengikuti persyaratan masing-masing program.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="umum"><button class="faq-q">Bagaimana memilih layanan yang
                                paling sesuai?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Pilih berdasarkan masalah dan hasil yang ingin dicapai. Capacity Building berfokus pada
                                    kompetensi; Banking Solution pada proses dan tata kelola; Banking Talent Solution pada
                                    pemetaan dan pengembangan talenta; LMS pada pembelajaran digital; Inovasi Program pada
                                    riset, prototipe, automasi, dan AI; Talent Solutions pada pencarian atau penyediaan
                                    tenaga kerja; sedangkan CSR dan Foundations pada dampak sosial serta pemberdayaan.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="umum"><button class="faq-q">Apakah program dapat
                                disesuaikan?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Ya. Ruang lingkup, peserta, metode, durasi, fasilitator, materi, asesmen, output, jadwal,
                                    dan indikator dapat disesuaikan berdasarkan kebutuhan serta kesepakatan. Penyesuaian
                                    dituangkan pada proposal, penawaran, atau dokumen kerja sama.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="umum"><button class="faq-q">Apakah program tersedia secara
                                daring dan tatap muka?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Program dapat diselenggarakan secara daring, tatap muka, mandiri, atau blended. Format
                                    final menyesuaikan tujuan pembelajaran, karakter peserta, akses teknologi, lokasi, dan
                                    kesepakatan program.</p>
                            </div>
                        </div>
                    </section>
                    <section class="faq-group" data-category="pembelajaran" id="pembelajaran">
                        <div class="group-head"><span class="group-icon">▶</span>
                            <div>
                                <h2>Pembelajaran, Pelatihan, dan LMS</h2>
                                <p>Capacity Building, kelas online, materi, asesmen, dan sistem pembelajaran.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="pembelajaran"><button class="faq-q">Apa perbedaan public
                                class dan in-house training?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Public class dibuka untuk peserta dari berbagai institusi dengan jadwal dan kurikulum
                                    yang ditetapkan penyelenggara. In-house training disusun khusus untuk satu institusi dan
                                    dapat menyesuaikan kebutuhan, kasus, kebijakan internal, waktu, serta profil peserta.
                                </p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="pembelajaran"><button class="faq-q">Bagaimana kebutuhan
                                pelatihan dianalisis?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Analisis dapat dilakukan melalui diskusi kebutuhan, telaah jabatan, gap kompetensi,
                                    sasaran organisasi, data asesmen, kuesioner, atau dokumen yang diberikan secara sah.
                                    Kedalaman analisis disesuaikan dengan ruang lingkup program.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="pembelajaran"><button class="faq-q">Metode belajar apa saja
                                yang tersedia?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Metode dapat meliputi paparan, diskusi, studi kasus, simulasi, praktik, kuis, pre-test,
                                    post-test, tugas, coaching, mentoring, video, e-book, kelas langsung, dan pembelajaran
                                    mandiri melalui LMS.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="pembelajaran"><button class="faq-q">Apakah hasil pelatihan
                                menjamin peningkatan kinerja?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Tidak ada jaminan hasil kinerja tertentu. Program membantu meningkatkan pengetahuan,
                                    keterampilan, dan kesiapan penerapan. Hasil akhir juga dipengaruhi dukungan atasan,
                                    lingkungan kerja, kesempatan praktik, kebijakan organisasi, dan konsistensi peserta.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="pembelajaran"><button class="faq-q">Apa saja fitur Learning
                                Management System?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>LMS dapat mencakup pengelolaan kelas dan konten, pengguna dan kelompok, hak akses, video,
                                    e-book, kuis, tugas, pre-test, post-test, progres belajar, sertifikat, notifikasi,
                                    dashboard, serta laporan. Fitur final mengikuti paket dan konfigurasi yang disepakati.
                                </p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="pembelajaran"><button class="faq-q">Apakah LMS dapat
                                menggunakan materi milik institusi?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Dapat, sepanjang institusi memiliki hak penggunaan dan materi memenuhi format yang
                                    diperlukan. Proses kurasi, konversi, migrasi, pengamanan, serta pembaruan konten
                                    mengikuti ruang lingkup implementasi.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="pembelajaran"><button class="faq-q">Apakah LMS dapat
                                diintegrasikan dengan sistem lain?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Integrasi dapat dikaji berdasarkan kebutuhan, ketersediaan API, keamanan, struktur data,
                                    hak akses, dan kompatibilitas sistem. Integrasi tidak otomatis tersedia pada setiap
                                    paket dan perlu pengujian teknis terpisah.</p>
                            </div>
                        </div>
                    </section>
                    <section class="faq-group" data-category="institusi" id="institusi">
                        <div class="group-head"><span class="group-icon">▦</span>
                            <div>
                                <h2>Solusi Institusi dan Inovasi</h2>
                                <p>Banking Solution, transformasi proses, riset, prototipe, data, dan AI.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="institusi"><button class="faq-q">Apa yang dimaksud dengan
                                Banking Solution?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Banking Solution adalah layanan konsultatif dan pendampingan terapan untuk membantu
                                    institusi memetakan kebutuhan, memperbaiki proses, menyusun panduan atau perangkat
                                    kerja, memperkuat tata kelola, layanan, pengembangan bisnis, dan transformasi
                                    operasional.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="institusi"><button class="faq-q">Apa output yang dapat
                                dihasilkan dari Banking Solution?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Output dapat berupa laporan kebutuhan, gap analysis, rekomendasi, SOP atau panduan,
                                    template kerja, dashboard, roadmap, prototipe, materi sosialisasi, rencana implementasi,
                                    dan laporan evaluasi sesuai ruang lingkup.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="institusi"><button class="faq-q">Apakah Bankir Academy
                                mengambil keputusan operasional institusi?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Tidak. Bankir Academy menyediakan analisis, fasilitasi, rekomendasi, perangkat, dan
                                    pendampingan. Persetujuan, keputusan, penerapan, pengawasan, serta tanggung jawab
                                    operasional tetap berada pada pejabat atau institusi yang berwenang.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="institusi"><button class="faq-q">Bagaimana proses Inovasi
                                Program dijalankan?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Proses umumnya mencakup discover, define, design, prototype, pilot, review, dan scale.
                                    Tahapannya dapat meliputi riset kebutuhan, desain produk atau proses, pembuatan
                                    prototipe, pengujian terbatas, evaluasi, dokumentasi, serta roadmap implementasi.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="institusi"><button class="faq-q">Apakah penggunaan AI
                                selalu otomatis tanpa pemeriksaan manusia?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Tidak. Keluaran AI diposisikan sebagai alat bantu dan tetap memerlukan verifikasi,
                                    pengujian, kontrol akses, peninjauan manusia, serta keputusan dari personel yang
                                    berwenang. Data rahasia tidak boleh digunakan tanpa dasar, kewenangan, dan pengamanan
                                    yang memadai.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="institusi"><button class="faq-q">Bagaimana kerahasiaan data
                                institusi dijaga?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Penggunaan data dibatasi pada tujuan dan ruang lingkup yang disepakati. Akses dapat
                                    dibatasi berdasarkan peran, dan kewajiban kerahasiaan dapat dituangkan dalam perjanjian.
                                    Institusi tetap perlu memastikan data yang diberikan sah, relevan, dan telah memperoleh
                                    persetujuan atau dasar pemrosesan yang diperlukan.</p>
                            </div>
                        </div>
                    </section>
                    <section class="faq-group" data-category="talenta" id="talenta">
                        <div class="group-head"><span class="group-icon">◇</span>
                            <div>
                                <h2>Talent Solutions dan Karier</h2>
                                <p>Banking Talent Solution, Headhunting, Outsourcing, dan Job Connect.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="talenta"><button class="faq-q">Apa perbedaan Banking Talent
                                Solution dan Headhunting?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Banking Talent Solution berfokus pada competency mapping, talent pool, career path,
                                    learning path, individual development plan, leadership development, dan succession
                                    readiness. Headhunting berfokus pada pencarian serta penyaringan kandidat untuk posisi
                                    yang ditentukan klien.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="talenta"><button class="faq-q">Apakah hasil assessment
                                menentukan promosi atau mutasi?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Hasil assessment merupakan salah satu bahan pertimbangan. Keputusan promosi, mutasi,
                                    penempatan, pengembangan, atau suksesi tetap menjadi kewenangan institusi dan sebaiknya
                                    mempertimbangkan data lain yang relevan.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="talenta"><button class="faq-q">Apakah Headhunting menjamin
                                kandidat menerima penawaran?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Tidak. Layanan membantu profiling posisi, market mapping, pendekatan kandidat,
                                    penyaringan awal, shortlist, dan koordinasi proses. Keputusan akhir klien dan keputusan
                                    kandidat untuk menerima penawaran berada di luar jaminan Bankir Academy.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="talenta"><button class="faq-q">Bagaimana informasi kandidat
                                diverifikasi?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Verifikasi dapat dilakukan melalui dokumen, wawancara, referensi, atau metode lain yang
                                    disepakati dan diizinkan. Kandidat bertanggung jawab atas kebenaran informasi, sedangkan
                                    keputusan verifikasi lanjutan tetap mengikuti kebijakan klien.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="talenta"><button class="faq-q">Apa yang termasuk layanan
                                Outsourcing?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Layanan dapat mencakup workforce planning, rekrutmen awal, penempatan, onboarding,
                                    administrasi, pemantauan layanan, evaluasi, pelaporan, eskalasi, dan dukungan pergantian
                                    tenaga kerja sesuai kontrak dan ketentuan yang berlaku.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="talenta"><button class="faq-q">Apakah outsourcing
                                mengalihkan tanggung jawab utama institusi?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Tidak. Pembagian tanggung jawab ditetapkan dalam perjanjian. Institusi tetap bertanggung
                                    jawab atas kewenangan, kebijakan, akses, pengawasan, keamanan, serta fungsi utama yang
                                    tidak dapat dialihkan.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="talenta"><button class="faq-q">Apakah Job Connect menjamin
                                kandidat diterima kerja?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Tidak. Job Connect menyediakan publikasi peluang, profil kandidat, pencocokan awal,
                                    aplikasi, dan dukungan persiapan karier. Pemanggilan, seleksi, penawaran, dan penerimaan
                                    sepenuhnya mengikuti proses perusahaan.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="talenta"><button class="faq-q">Apakah kandidat dikenakan
                                biaya untuk memperoleh pekerjaan?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Setiap biaya program persiapan karier atau layanan lain harus diinformasikan secara
                                    transparan. Kandidat tidak boleh menganggap pembayaran sebagai jaminan penerimaan kerja.
                                    Hindari pembayaran kepada rekening atau pihak yang tidak diumumkan melalui kanal resmi.
                                </p>
                            </div>
                        </div>
                    </section>
                    <section class="faq-group" data-category="foundation" id="foundation">
                        <div class="group-head"><span class="group-icon">♡</span>
                            <div>
                                <h2>Program CSR dan Foundations</h2>
                                <p>Bakti Pendidikan, Bakti UMKM, penerima manfaat, dampak, dan pelaporan.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="foundation"><button class="faq-q">Apa perbedaan Program CSR
                                dan Foundations?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Program CSR merupakan kerangka kolaborasi sosial yang dapat dikembangkan bersama mitra
                                    berdasarkan tujuan, penerima manfaat, indikator, dokumentasi, dan laporan. Foundations
                                    adalah fokus program Bankir Academy melalui Bakti Pendidikan dan Bakti UMKM.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="foundation"><button class="faq-q">Apa saja program Bakti
                                Pendidikan?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Program dapat mencakup literasi keuangan, Inside the Bank, Career Ready, keterampilan
                                    digital, dukungan guru atau mentor, serta beasiswa pembelajaran bagi siswa, mahasiswa,
                                    fresh graduate, dan pendamping.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="foundation"><button class="faq-q">Bagaimana penerima
                                beasiswa pembelajaran ditentukan?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Kriteria penerima ditetapkan secara jelas bersama mitra, misalnya berdasarkan sasaran
                                    wilayah, kebutuhan, prestasi, kondisi sosial, atau kriteria program lain. Proses
                                    seleksi, kuota, verifikasi, dan bentuk manfaat harus diinformasikan kepada pihak
                                    terkait.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="foundation"><button class="faq-q">Apa saja program Bakti
                                UMKM?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Program dapat meliputi pencatatan dan keuangan usaha, HPP dan margin, arus kas, pemasaran
                                    dan penjualan, kesiapan pembiayaan, digitalisasi, operasional, layanan pelanggan,
                                    mentoring, dan klinik bisnis.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="foundation"><button class="faq-q">Apakah Bakti UMKM
                                menjamin pembiayaan atau peningkatan omzet?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Tidak. Program membantu meningkatkan pengetahuan, kerapian administrasi, kesiapan usaha,
                                    dan kemampuan menyusun rencana tindakan. Persetujuan pembiayaan, penjualan, omzet, laba,
                                    dan keberhasilan bisnis dipengaruhi banyak faktor dan tidak dijamin.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="foundation"><button class="faq-q">Bagaimana dampak program
                                CSR diukur?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Pengukuran dapat mencakup input, jumlah peserta, aktivitas, kehadiran, penyelesaian
                                    tugas, peningkatan pengetahuan, umpan balik, penerapan praktik, dokumentasi,
                                    rekomendasi, dan tindak lanjut. Indikator dipilih sesuai tujuan dan kapasitas program.
                                </p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="foundation"><button class="faq-q">Apakah mitra memperoleh
                                laporan program?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Dapat. Laporan dapat memuat tujuan, profil peserta, aktivitas, dokumentasi, hasil
                                    evaluasi, capaian indikator, kendala, dan rekomendasi. Bentuk dan kedalaman laporan
                                    mengikuti ruang lingkup kerja sama.</p>
                            </div>
                        </div>
                    </section>
                    <section class="faq-group" data-category="administrasi" id="administrasi">
                        <div class="group-head"><span class="group-icon">✓</span>
                            <div>
                                <h2>Akun, Pendaftaran, Pembayaran, dan Sertifikat</h2>
                                <p>Administrasi peserta dan ketentuan penggunaan layanan.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="administrasi"><button class="faq-q">Kapan pendaftaran
                                dinyatakan berhasil?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Pendaftaran dinyatakan berhasil setelah data yang dipersyaratkan diterima dan, untuk
                                    program berbayar, pembayaran telah diverifikasi. Pengisian formulir tanpa verifikasi
                                    belum selalu menjamin tempat jika kuota terbatas.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="administrasi"><button class="faq-q">Apakah akun dapat
                                digunakan bersama?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Tidak. Akun bersifat pribadi dan tidak boleh dipindahtangankan, dijual, disewakan, atau
                                    dibagikan tanpa izin tertulis. Pengguna bertanggung jawab menjaga kata sandi, OTP, dan
                                    akses akun.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="administrasi"><button class="faq-q">Metode pembayaran apa
                                yang digunakan?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Pembayaran harus dilakukan melalui metode dan rekening resmi yang diinformasikan pada
                                    halaman program, invoice, atau penawaran. Biaya administrasi dan pajak dapat berlaku
                                    sesuai informasi transaksi.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="administrasi"><button class="faq-q">Bagaimana kebijakan
                                pembatalan dan pengembalian dana?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Kebijakan mengikuti jenis program dan informasi saat pendaftaran. Produk digital yang
                                    telah diakses atau dikirim pada umumnya tidak dapat dikembalikan. Permintaan pembatalan
                                    kelas terjadwal harus diajukan melalui kanal resmi dan dapat dikenakan biaya
                                    administrasi. Rujuk halaman <a href="{{ route('frontend.support.terms') }}">Syarat
                                        &amp; Ketentuan</a>.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="administrasi"><button class="faq-q">Apakah semua program
                                memperoleh sertifikat?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Sertifikat mengikuti ketentuan program dan dapat mensyaratkan kehadiran, penyelesaian
                                    materi, tugas, asesmen, atau pembayaran. Tidak semua kegiatan otomatis menerbitkan
                                    sertifikat.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="administrasi"><button class="faq-q">Apakah sertifikat
                                Bankir Academy merupakan lisensi profesi?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Tidak otomatis. Sertifikat dapat menunjukkan keikutsertaan atau penyelesaian program,
                                    tetapi bukan gelar akademik, lisensi profesi, atau jaminan pengakuan regulator maupun
                                    perusahaan kecuali dinyatakan secara khusus.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="administrasi"><button class="faq-q">Bagaimana data pribadi
                                peserta digunakan?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Data dapat digunakan untuk pendaftaran, pelaksanaan, pembayaran, sertifikat, dukungan,
                                    keamanan, evaluasi, komunikasi, dan peningkatan layanan. Informasi lebih lengkap
                                    tersedia pada halaman <a href="{{ route('frontend.support.privacy') }}">Kebijakan
                                        Privasi</a>.</p>
                            </div>
                        </div>
                        <div class="faq-item" data-category="administrasi"><button class="faq-q">Bagaimana menghubungi
                                Bankir Academy jika jawaban belum tersedia?<span class="faq-plus">＋</span></button>
                            <div class="faq-a">
                                <p>Sampaikan nama, email atau nomor telepon terdaftar, nama program atau layanan, kronologi,
                                    serta bukti pendukung melalui halaman <a
                                        href="{{ route('frontend.support.contact') }}">Kontak Kami</a> atau email
                                    info@bankiracademy.co.id agar permintaan dapat diarahkan ke tim yang sesuai.</p>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
    <section class="section section-soft">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Jelajahi Layanan',
                'title' => 'Masih Membutuhkan Informasi Lebih Spesifik?',
                'description' =>
                    'Buka halaman layanan untuk melihat ruang lingkup, proses, output, ketentuan, dan FAQ yang lebih rinci.',
            ])
            <div class="service-hub">
                <article class="hub-card"><i>▦</i>
                    <h3>Solusi &amp; Pembelajaran</h3>
                    <p>Banking Solution, Capacity Building, LMS, dan Inovasi Program.</p><a
                        href="{{ route('frontend.home') }}#layanan">Jelajahi layanan →</a>
                </article>
                <article class="hub-card"><i>◇</i>
                    <h3>Talent Solutions</h3>
                    <p>Banking Talent Solution, Headhunting, Outsourcing, dan Job Connect.</p><a
                        href="{{ route('frontend.home') }}#talent-solutions">Jelajahi talenta →</a>
                </article>
                <article class="hub-card"><i>♡</i>
                    <h3>CSR &amp; Foundations</h3>
                    <p>Program CSR, Bakti Pendidikan, dan Bakti UMKM.</p><a
                        href="{{ route('frontend.home') }}#foundations">Jelajahi program →</a>
                </article>
                <article class="hub-card"><i>?</i>
                    <h3>Dukungan Pengguna</h3>
                    <p>Syarat, privasi, bantuan akun, transaksi, dan pertanyaan lainnya.</p><a
                        href="{{ route('frontend.support.contact') }}">Hubungi kami →</a>
                </article>
            </div>
        </div>
    </section>
    <section class="final-cta">
        <div class="container">
            <div class="cta-box">
                <div>
                    <h2>Belum Menemukan Jawaban yang Dibutuhkan?</h2>
                    <p>Kirimkan pertanyaan dengan nama layanan, tujuan, jumlah peserta atau pengguna, jadwal, dan informasi
                        pendukung agar tim kami dapat memberikan arahan yang lebih tepat.</p>
                </div>
                <div class="cta-actions"><a class="btn btn-light" href="{{ route('frontend.support.contact') }}">Buka
                        Kontak Kami</a><a class="btn btn-secondary"
                        href="mailto:info@bankiracademy.co.id?subject=Pertanyaan%20Bankir%20Academy">Kirim Email</a></div>
            </div>
        </div>
    </section>
    <script>
        const faqSearch = document.getElementById('faqSearch');
        const clearFaqSearch = document.getElementById('clearSearch');
        const faqGroups = [...document.querySelectorAll('.faq-group')];
        const faqFilters = [...document.querySelectorAll('.filter-btn')];
        let currentFaqFilter = 'all';

        function applyFaqFilters() {
            const query = (faqSearch?.value || '').toLowerCase().trim();
            faqGroups.forEach(group => {
                let visible = 0;
                group.querySelectorAll('.faq-item').forEach(item => {
                    const matchesFilter = currentFaqFilter === 'all' || item.dataset.category ===
                        currentFaqFilter;
                    const matchesSearch = !query || item.textContent.toLowerCase().includes(query);
                    item.classList.toggle('hidden', !(matchesFilter && matchesSearch));
                    if (matchesFilter && matchesSearch) visible++;
                });
                group.classList.toggle('hidden', visible === 0);
            });
        }
        faqSearch?.addEventListener('input', applyFaqFilters);
        clearFaqSearch?.addEventListener('click', () => {
            faqSearch.value = '';
            currentFaqFilter = 'all';
            faqFilters.forEach((button, index) => button.classList.toggle('active', index === 0));
            applyFaqFilters();
            faqSearch.focus();
        });
        faqFilters.forEach(button => button.addEventListener('click', () => {
            currentFaqFilter = button.dataset.filter;
            faqFilters.forEach(item => item.classList.remove('active'));
            button.classList.add('active');
            applyFaqFilters();
        }));
    </script>
@endsection
