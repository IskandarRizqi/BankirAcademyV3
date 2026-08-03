@extends('layouts.appfrontend')

@section('content')
      <section class="hero" id="beranda">
        <div class="container hero-grid">
          <div>
              <span class="eyebrow">Learning Innovation for Better Bankers</span>
            <h1>
              Membangun Kompetensi, Talenta, dan
              <span class="gradient-text">Solusi Perbankan</span> yang Relevan
            </h1>
            <p class="hero-lead">
              Bankir Academy adalah platform pembelajaran dan pengembangan
              ekosistem perbankan yang menghubungkan program peningkatan
              kompetensi, solusi talenta, pembelajaran digital, riset terapan,
              dan program pemberdayaan.
            </p>
            <div class="hero-actions">
              <a class="btn btn-primary" href="#layanan"
                >Jelajahi Layanan <span class="icon-arrow">→</span></a
              >
              <a class="btn btn-outline" href="{{ route('frontend.support.contact') }}"
                >Diskusikan Kebutuhan</a
              >
            </div>
            <div class="hero-proof">
              <span class="proof-item"
                ><span class="proof-icon">✓</span>Program dapat
                disesuaikan</span
              >
              <span class="proof-item"
                ><span class="proof-icon">✓</span>Pembelajaran berbasis
                kebutuhan</span
              >
              <span class="proof-item"
                ><span class="proof-icon">✓</span>Daring, luring, dan
                blended</span
              >
            </div>
          </div>
          <div
            aria-label="Ilustrasi platform Bankir Academy"
            class="hero-visual"
          >
            <div class="visual-main">
              <div class="dashboard">
                <div class="dash-top">
                  <div class="dash-brand">
                    <svg aria-hidden="true" height="31" width="31">
                      <use href="#logo-ba"></use>
                    </svg>
                    BANKIR ACADEMY
                  </div>
                  <div class="dash-dots">
                    <span></span><span></span><span></span>
                  </div>
                </div>
                <div class="dash-hero">
                  <div class="dash-label">Integrated Learning Ecosystem</div>
                  <h3>Learn. Grow. Contribute.</h3>
                  <p>
                    Satu ekosistem untuk pembelajaran, pengembangan talenta, dan
                    kolaborasi program.
                  </p>
                  <div class="dash-stats">
                    <div class="dash-stat">
                      <strong>4 Level</strong
                      ><span>Dasar hingga strategis</span>
                    </div>
                    <div class="dash-stat">
                      <strong>Hybrid</strong><span>Daring dan tatap muka</span>
                    </div>
                    <div class="dash-stat">
                      <strong>Custom</strong
                      ><span>Sesuai kebutuhan institusi</span>
                    </div>
                  </div>
                </div>
                <div class="dash-grid">
                  <div class="dash-card">
                    <h4>Learning Progress</h4>
                    <div class="progress"><span style="width: 76%"></span></div>
                    <div class="mini-list" style="margin-top: 13px">
                      <div class="mini-row">
                        <i></i><span>Materi pembelajaran</span>
                      </div>
                      <div class="mini-row">
                        <i style="background: #ffc95c"></i
                        ><span>Asesmen pengetahuan</span>
                      </div>
                      <div class="mini-row">
                        <i style="background: #6757d9"></i
                        ><span>Rencana pengembangan</span>
                      </div>
                    </div>
                  </div>
                  <div class="dash-card">
                    <h4>Program Area</h4>
                    <div class="mini-list">
                      <div class="mini-row">
                        <i></i><span>Banking Solution</span>
                      </div>
                      <div class="mini-row">
                        <i style="background: #6757d9"></i
                        ><span>Talent Solutions</span>
                      </div>
                      <div class="mini-row">
                        <i style="background: #ffc95c"></i
                        ><span>Foundations</span>
                      </div>
                      <div class="mini-row">
                        <i style="background: #c04a67"></i
                        ><span>Innovation Lab</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="float-card one">
              <span class="float-icon">🎓</span>
              <span
                ><strong>Capacity Building</strong
                ><small>Program sesuai kebutuhan</small></span
              >
            </div>
            <div class="float-card two">
              <span class="float-icon">✦</span>
              <span
                ><strong>Innovation Lab</strong
                ><small>Riset, analisis, dan AI</small></span
              >
            </div>
            <div class="float-card three">
              <span class="float-icon">⇄</span>
              <span
                ><strong>Job Connect</strong
                ><small>Talenta dan peluang kerja</small></span
              >
            </div>
          </div>
        </div>
      </section>
      <div class="trust-strip">
        <div class="container trust-inner">
          <div class="trust-copy">
            <strong>Dirancang untuk berbagai kebutuhan ekosistem</strong>
            <span
              >Program dapat dikembangkan berdasarkan ruang lingkup dan target
              yang disepakati.</span
            >
          </div>
          <div class="trust-item">
            <span class="trust-mark">B</span>Bank &amp; BPR/BPRS
          </div>
          <div class="trust-item">
            <span class="trust-mark">H</span>Human Capital
          </div>
          <div class="trust-item">
            <span class="trust-mark">S</span>Sekolah &amp; Kampus
          </div>
          <div class="trust-item">
            <span class="trust-mark">U</span>UMKM &amp; Komunitas
          </div>
        </div>
      </div>
      <section class="section" id="layanan">
        <div class="container">
          <div class="section-head">
            <span class="eyebrow">Layanan Terintegrasi</span>
            <h2>Solusi yang Tumbuh Bersama Kebutuhan Organisasi</h2>
            <p>
              Setiap layanan dapat digunakan secara mandiri atau digabungkan
              menjadi program pengembangan yang lebih menyeluruh, dengan ruang
              lingkup, metode, dan indikator keberhasilan yang disepakati
              bersama.
            </p>
          </div>
          <div class="cards-3">
            <article class="service-card" id="banking-solution">
              <div class="card-icon">▦</div>
              <span class="tag" style="margin-top: 19px"
                >Institutional Solution</span
              >
               <h3><a href="{{ route('frontend.service.banking-solution') }}">Banking Solution</a></h3>
              <p>
                Solusi konsultatif dan pendampingan terapan untuk membantu
                institusi memperkuat proses bisnis, tata kelola, layanan, dan
                transformasi operasional.
              </p>
              <ul class="card-list">
                <li>Pemetaan kebutuhan dan permasalahan</li>
                <li>Penyusunan panduan dan perangkat kerja</li>
                <li>Pendampingan implementasi bertahap</li>
              </ul>
               <a class="text-link" href="{{ route('frontend.service.banking-solution') }}"
                >Lihat selengkapnya →</a
              >
            </article>
            <article class="service-card" id="capacity-building">
              <div class="card-icon">↗</div>
              <span class="tag" style="margin-top: 19px"
                >People Development</span
              >
               <h3><a href="{{ route('frontend.service.capacity-building') }}">Capacity Building</a></h3>
              <p>
                Program pengembangan kompetensi untuk calon bankir, pegawai,
                pimpinan, dan tim melalui pembelajaran yang disesuaikan dengan
                kebutuhan organisasi.
              </p>
              <ul class="card-list">
                <li>Kelas publik dan in-house training</li>
                <li>Workshop, coaching, dan blended learning</li>
                <li>Evaluasi pembelajaran yang proporsional</li>
              </ul>
               <a class="text-link" href="{{ route('frontend.service.capacity-building') }}"
                >Lihat selengkapnya →</a
              >
            </article>
            <article class="service-card" id="banking-talent">
              <div class="card-icon">◇</div>
              <span class="tag" style="margin-top: 19px"
                >Talent Development</span
              >
              <h3>
                 <a href="{{ route('frontend.service.banking-talent') }}"
                  >Banking Talent Solution</a
                >
              </h3>
              <p>
                Solusi pemetaan dan pengembangan talenta melalui competency
                mapping, learning path, persiapan karier, dan penguatan
                kompetensi jabatan.
              </p>
              <ul class="card-list">
                <li>Competency mapping dan gap analysis</li>
                <li>Individual development plan</li>
                <li>Talent pool dan kesiapan karier</li>
              </ul>
               <a class="text-link" href="{{ route('frontend.service.banking-talent') }}"
                >Lihat selengkapnya →</a
              >
            </article>
          </div>
        </div>
      </section>
      <section class="section section-soft" id="talent-solutions">
        <div class="container split">
          <div
            aria-label="Ilustrasi dashboard pengelolaan talenta"
            class="feature-visual"
          >
            <div class="feature-screen">
              <div class="screen-nav">
                <span class="screen-title">Talent Insight Dashboard</span>
                <span class="screen-pill">Structured Process</span>
              </div>
              <div class="chart-area">
                <div class="bar" style="height: 42%"></div>
                <div class="bar" style="height: 63%"></div>
                <div class="bar" style="height: 51%"></div>
                <div class="bar" style="height: 78%"></div>
                <div class="bar" style="height: 68%"></div>
                <div class="bar" style="height: 88%"></div>
              </div>
              <div class="screen-bottom">
                <div class="screen-box">
                  <strong>Role Fit</strong
                  ><span>Pemetaan kriteria dan kebutuhan jabatan</span>
                </div>
                <div class="screen-box">
                  <strong>Talent Pool</strong
                  ><span>Basis kandidat yang dapat dikembangkan</span>
                </div>
              </div>
            </div>
            <div class="feature-chip one">
              <i>⌕</i
              ><span
                ><strong>Candidate Mapping</strong
                ><span>Profil dan kriteria</span></span
              >
            </div>
            <div class="feature-chip two">
              <i>⇄</i
              ><span
                ><strong>Job Connect</strong
                ><span>Matching berbasis kebutuhan</span></span
              >
            </div>
          </div>
          <div class="feature-copy">
            <span class="eyebrow">Talent Solutions</span>
            <h2>
              Menghubungkan Kebutuhan Organisasi dengan Talenta yang Relevan
            </h2>
            <p>
              Layanan talent solution dirancang untuk membantu proses pencarian,
              penyediaan, dan penghubungan talenta. Setiap penempatan tetap
              mengikuti seleksi, kebijakan, dan keputusan masing-masing
              institusi.
            </p>
            <div class="feature-points">
              <div class="feature-point" id="headhunting">
                <span class="point-icon">1</span>
                <span
                  ><strong>Headhunting</strong
                  ><span
                    >Pencarian dan pemetaan kandidat berdasarkan profil jabatan,
                    pengalaman, kompetensi, serta kriteria yang
                    disepakati.</span
                  ></span
                >
              </div>
              <div class="feature-point" id="outsourcing">
                <span class="point-icon">2</span>
                <span
                  ><strong>Outsourcing</strong
                  ><span
                    >Dukungan penyediaan tenaga kerja untuk fungsi tertentu
                    berdasarkan ruang lingkup, tata kelola, dan ketentuan yang
                    berlaku.</span
                  ></span
                >
              </div>
              <div class="feature-point" id="job-connect">
                <span class="point-icon">3</span>
                <span
                  ><strong>Job Connect</strong
                  ><span
                    >Kanal informasi dan penghubung antara kandidat dengan
                    peluang kerja yang relevan, tanpa menjanjikan hasil
                    penerimaan.</span
                  ></span
                >
              </div>
            </div>
            <a class="btn btn-primary" href="#kontak"
              >Diskusikan Kebutuhan Talenta</a
            >
          </div>
        </div>
      </section>
      <section class="section" id="innovation-lab">
        <div class="container">
          <div class="section-head left">
            <span class="eyebrow">Innovation Lab</span>
            <h2>
              Riset, Analisis Produk, dan AI Terapan untuk Mendukung Keputusan
            </h2>
            <p>
              Inovasi dikembangkan sebagai alat bantu kerja dan pembelajaran.
              Hasil analisis, rekomendasi, maupun keluaran AI tetap memerlukan
              verifikasi dan keputusan dari personel yang berwenang.
            </p>
          </div>
          <div class="innovation-grid">
            <article class="innovation-main">
              <span class="eyebrow">Responsible Innovation</span>
              <h3>
                Mengubah Data dan Permasalahan Operasional Menjadi Prototipe
                Solusi
              </h3>
              <p>
                Proses dimulai dari identifikasi kebutuhan, pengumpulan data
                yang sah, analisis, perancangan prototipe, pengujian, hingga
                rekomendasi implementasi dan tata kelola.
              </p>
              <div class="innovation-tags">
                <span>Market Research</span><span>Product Review</span
                ><span>Process Automation</span> <span>AI Assistant</span
                ><span>Dashboard Insight</span
                ><span>Risk &amp; Governance</span>
              </div>
              <div class="ai-orbit">
                <div class="ai-core">AI</div>
                <span class="orbit-dot a">⌁</span>
                <span class="orbit-dot b">▦</span>
                <span class="orbit-dot c">◎</span>
              </div>
            </article>
            <div class="innovation-side">
              <article class="example-card">
                <div class="example-head">
                  <h3>Analisis Produk &amp; Pasar</h3>
                  <span class="tag">Contoh 01</span>
                </div>
                <p>
                  Memetakan kebutuhan segmen, membandingkan fitur, mengolah
                  masukan pengguna, dan menyusun opsi pengembangan produk untuk
                  ditinjau institusi.
                </p>
                <div class="example-meta">
                  <span>Segmentasi</span><span>Benchmark</span
                  ><span>Customer Insight</span>
                </div>
              </article>
              <article class="example-card">
                <div class="example-head">
                  <h3>AI Knowledge Assistant</h3>
                  <span class="tag">Contoh 02</span>
                </div>
                <p>
                  Asisten pencarian dokumen internal untuk membantu pengguna
                  menemukan SOP, materi, atau panduan dengan akses berbasis
                  kewenangan.
                </p>
                <div class="example-meta">
                  <span>Semantic Search</span><span>Access Control</span
                  ><span>Human Review</span>
                </div>
              </article>
              <article class="example-card">
                <div class="example-head">
                  <h3>Learning &amp; Performance Insight</h3>
                  <span class="tag">Contoh 03</span>
                </div>
                <p>
                  Dashboard untuk membaca progres pembelajaran, hasil asesmen,
                  kebutuhan pengembangan, dan tindak lanjut program secara
                  terstruktur.
                </p>
                <div class="example-meta">
                  <span>Dashboard</span><span>Gap Analysis</span
                  ><span>Action Plan</span>
                </div>
              </article>
            </div>
          </div>
        </div>
      </section>
      <section class="section section-soft" id="foundations">
        <div class="container">
          <div class="section-head">
            <span class="eyebrow">Bankir Academy Foundations</span>
            <h2>Kolaborasi Pendidikan dan Pemberdayaan yang Terarah</h2>
            <p>
              Program foundation menghubungkan pembelajaran dengan kebutuhan
              masyarakat, sekolah, kampus, komunitas, UMKM, dan mitra institusi
              melalui kegiatan yang memiliki tujuan, peserta, materi, serta
              evaluasi yang jelas.
            </p>
          </div>
          <div class="cards-2">
            <article class="foundation-card education" id="bakti-pendidikan">
              <div class="card-icon">🎓</div>
              <h3>Bakti Pendidikan</h3>
              <p>
                Program pendidikan bagi pelajar, mahasiswa, fresh graduate, dan
                calon bankir untuk memahami industri perbankan, membangun
                kesiapan karier, dan mengembangkan kebiasaan finansial yang
                bertanggung jawab.
              </p>
              <div class="foundation-programs">
                <div class="program-mini">
                  <strong>Inside the Bank</strong
                  ><span
                    >Pengenalan fungsi, proses, dan profesi perbankan.</span
                  >
                </div>
                <div class="program-mini">
                  <strong>Career Ready</strong
                  ><span>CV, wawancara, etika kerja, dan komunikasi.</span>
                </div>
                <div class="program-mini">
                  <strong>Financial Literacy</strong
                  ><span
                    >Pengelolaan uang, produk keuangan, dan kehati-hatian.</span
                  >
                </div>
                <div class="program-mini">
                  <strong>Scholarship Class</strong
                  ><span
                    >Kelas kolaborasi bagi peserta yang ditetapkan mitra.</span
                  >
                </div>
              </div>
              <a class="btn btn-primary btn-sm" href="#kontak"
                >Kolaborasi Program Pendidikan</a
              >
            </article>
            <article class="foundation-card umkm" id="bakti-umkm">
              <div class="card-icon">⌂</div>
              <h3>Bakti UMKM</h3>
              <p>
                Program pembelajaran praktis untuk membantu pelaku UMKM memahami
                pengelolaan usaha, pencatatan keuangan, pemasaran, layanan
                pelanggan, kesiapan pembiayaan, dan penggunaan teknologi secara
                bertahap.
              </p>
              <div class="foundation-programs">
                <div class="program-mini">
                  <strong>Business Fundamentals</strong
                  ><span>Model usaha, target, biaya, dan arus kas.</span>
                </div>
                <div class="program-mini">
                  <strong>Digital Marketing</strong
                  ><span
                    >Konten, kanal digital, dan pengelolaan pelanggan.</span
                  >
                </div>
                <div class="program-mini">
                  <strong>Financial Readiness</strong
                  ><span>Pencatatan dan persiapan dokumen usaha.</span>
                </div>
                <div class="program-mini">
                  <strong>Mentoring Clinic</strong
                  ><span>Diskusi kasus dan rencana perbaikan usaha.</span>
                </div>
              </div>
              <a class="btn btn-secondary btn-sm" href="#kontak"
                >Kolaborasi Program UMKM</a
              >
            </article>
          </div>
        </div>
      </section>
      <section class="section section-soft" id="kelas-online">
        <div class="container">
          <div class="section-head">
            <span class="eyebrow">Kelas Online Pilihan</span>
            <h2>Mulai Belajar dari Kelas yang Paling Relevan</h2>
            <p>
              Pilihan kelas berikut merupakan contoh tampilan awal. Setiap kelas
              dapat dilengkapi materi video, e-book, kuis, latihan, dan
              sertifikat sesuai ketentuan program.
            </p>
          </div>
          <div class="course-grid">
            <article class="course-card">
              <div class="course-cover one">
                <span class="course-label">Dasar Perbankan</span>
                <h3>General Banking Fundamentals</h3>
              </div>
              <div class="course-body">
                <div class="course-meta">
                  <span>Level Dasar</span>
                  <span>Mandiri</span>
                  <span>Video &amp; Kuis</span>
                </div>
                <p>
                  Memahami fungsi bank, produk dan layanan, struktur organisasi,
                  proses operasional, serta etika dasar calon bankir.
                </p>
                <div class="course-actions">
                  <span class="course-status">Kelas Online</span>
                  <a
                    class="text-link"
                     href="{{ route('frontend.class.static', ['slug' => 'kelas-general-banking-fundamentals']) }}"
                    >Lihat detail →</a
                  >
                </div>
              </div>
            </article>
            <article class="course-card">
              <div class="course-cover two">
                <span class="course-label">Kredit &amp; Risiko</span>
                <h3>Dasar Analisis Kredit Perbankan</h3>
              </div>
              <div class="course-body">
                <div class="course-meta">
                  <span>Level Dasar</span>
                  <span>Mandiri</span>
                  <span>Studi Kasus</span>
                </div>
                <p>
                  Pengenalan proses kredit, analisis sederhana, dokumen
                  pendukung, identifikasi risiko, dan prinsip kehati-hatian.
                </p>
                <div class="course-actions">
                  <span class="course-status">Kelas Online</span>
                  <a
                    class="text-link"
                     href="{{ route('frontend.class.static', ['slug' => 'kelas-dasar-analisis-kredit-perbankan']) }}"
                    >Lihat detail →</a
                  >
                </div>
              </div>
            </article>
            <article class="course-card">
              <div class="course-cover three">
                <span class="course-label">Karier Bankir</span>
                <h3>Persiapan Seleksi dan Karier Perbankan</h3>
              </div>
              <div class="course-body">
                <div class="course-meta">
                  <span>Fresh Graduate</span>
                  <span>Mandiri</span>
                  <span>Latihan</span>
                </div>
                <p>
                  Membantu peserta menyiapkan CV, memahami tahapan rekrutmen,
                  menghadapi wawancara, dan mengenali etika kerja profesional.
                </p>
                <div class="course-actions">
                  <span class="course-status">Kelas Online</span>
                  <a
                    class="text-link"
                     href="{{ route('frontend.class.static', ['slug' => 'kelas-persiapan-seleksi-dan-karier-perbankan']) }}"
                    >Lihat detail →</a
                  >
                </div>
              </div>
            </article>
            <article class="course-card">
              <div class="course-cover four">
                <span class="course-label">Digital Banking</span>
                <h3>AI Literacy for Banking Professionals</h3>
              </div>
              <div class="course-body">
                <div class="course-meta">
                  <span>Level Dasar</span>
                  <span>Mandiri</span>
                  <span>Digital Skill</span>
                </div>
                <p>
                  Pengenalan penggunaan AI sebagai alat bantu kerja, batas
                  penggunaan, verifikasi manusia, keamanan informasi, dan tata
                  kelola dasar.
                </p>
                <div class="course-actions">
                  <span class="course-status">Kelas Online</span>
                  <a
                    class="text-link"
                     href="{{ route('frontend.class.static', ['slug' => 'kelas-ai-literacy-for-banking-professionals']) }}"
                    >Lihat detail →</a
                  >
                </div>
              </div>
            </article>
          </div>
          <div class="course-more">
             <a class="btn btn-primary" href="{{ route('frontend.classes.index') }}">
              Lihat Kelas Selengkapnya <span class="icon-arrow">→</span>
            </a>
          </div>
        </div>
      </section>
      <section class="section" id="faq">
        <div class="container">
          <div class="section-head">
            <span class="eyebrow">Pusat Bantuan</span>
            <h2>Pertanyaan yang Sering Diajukan</h2>
            <p>
              Informasi awal mengenai program, peserta, sertifikat, kerja sama,
              dan akses pembelajaran.
            </p>
          </div>
          <div class="faq-wrap">
            <article class="faq-item open">
              <button class="faq-q" type="button">
                Siapa yang dapat mengikuti program Bankir Academy?<span
                  class="faq-plus"
                  >＋</span
                >
              </button>
              <div class="faq-a">
                Program dapat diikuti oleh pelajar, mahasiswa, fresh graduate,
                calon bankir, pegawai bank, pimpinan, HR, UMKM, dan institusi
                sesuai sasaran serta prasyarat masing-masing program.
              </div>
            </article>
            <article class="faq-item">
              <button class="faq-q" type="button">
                Apakah program dapat disesuaikan untuk institusi?<span
                  class="faq-plus"
                  >＋</span
                >
              </button>
              <div class="faq-a">
                Ya. Topik, metode, durasi, jumlah peserta, evaluasi, dan
                deliverables dapat disusun berdasarkan kebutuhan serta ruang
                lingkup yang disepakati.
              </div>
            </article>
            <article class="faq-item">
              <button class="faq-q" type="button">
                Apakah setiap program mendapatkan sertifikat?<span
                  class="faq-plus"
                  >＋</span
                >
              </button>
              <div class="faq-a">
                Penerbitan sertifikat mengikuti ketentuan masing-masing program,
                seperti kehadiran, penyelesaian materi, asesmen, tugas, dan
                persyaratan administrasi.
              </div>
            </article>
            <article class="faq-item">
              <button class="faq-q" type="button">
                Apakah Bankir Academy menjamin peserta diterima bekerja?<span
                  class="faq-plus"
                  >＋</span
                >
              </button>
              <div class="faq-a">
                Tidak. Program pembelajaran dan Job Connect membantu
                meningkatkan kesiapan serta akses informasi, tetapi proses
                seleksi dan keputusan penerimaan sepenuhnya berada pada
                institusi pemberi kerja.
              </div>
            </article>
            <article class="faq-item">
              <button class="faq-q" type="button">
                Bagaimana cara mengajukan program CSR pendidikan?<span
                  class="faq-plus"
                  >＋</span
                >
              </button>
              <div class="faq-a">
                Mitra dapat menyampaikan sasaran peserta, wilayah, tema, jumlah
                peserta, jadwal, dan hasil yang diharapkan. Tim akan menyusun
                konsep program dan mekanisme evaluasinya.
              </div>
            </article>
            <article class="faq-item">
              <button class="faq-q" type="button">
                Apakah materi regulasi selalu diperbarui?<span class="faq-plus"
                  >＋</span
                >
              </button>
              <div class="faq-a">
                Materi ditinjau secara berkala. Namun, peserta dan institusi
                tetap perlu memeriksa peraturan, surat edaran, serta sumber
                resmi terbaru sebelum mengambil keputusan atau menerapkan
                kebijakan.
              </div>
            </article>
          </div>
        </div>
      </section>
      <section class="final-cta" id="kontak">
        <div class="container">
          <div class="cta-box">
            <div>
              <h2>Mari Rancang Program yang Sesuai Kebutuhan Anda</h2>
              <p>
                Sampaikan tujuan, peserta, tantangan, dan bentuk program yang
                ingin dikembangkan bersama Bankir Academy.
              </p>
            </div>
            <div class="cta-actions">
               <a class="btn btn-light" href="{{ route('frontend.support.contact') }}"
                >Email Bankir Academy</a
              >
              <a class="btn btn-secondary" href="#layanan">Lihat Layanan</a>
            </div>
          </div>
        </div>
      </section>

@endsection
