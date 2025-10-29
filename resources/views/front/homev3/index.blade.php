@include('front.layout.head')
@include('front.layout.topbar')
@include(env('CUSTOM_HEADER', 'front.layout.headerv3'))
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
/* Font dan warna konsisten untuk seluruh halaman */
:root {
  --primary-color: #005CFF;
  --secondary-color: #c76b07;
  --text-color: #333333;
  --text-light: #666666;
  --text-muted: #888888;
  --bg-light: #fafafa;
  --bg-white: #ffffff;
  --font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

* {
  font-family: var(--font-family);
}

/* Animasi */
@keyframes floatImage1 {
  0% { transform: translateY(0); }
  50% { transform: translateY(-15px); }
  100% { transform: translateY(0); }
}

@keyframes floatImage2 {
  0% { transform: translateY(10px); }
  50% { transform: translateY(-20px); }
  100% { transform: translateY(10px); }
}

/* Gaya umum untuk judul */
h1, h2, h3, h4, h5, h6 {
  color: var(--text-color);
  font-weight: 700;
  line-height: 1.2;
}

h1 { font-size: 3.2rem; }
h2 { font-size: 2.5rem; }
h3 { font-size: 2rem; }
h4 { font-size: 1.5rem; }
h5 { font-size: 1.25rem; }
h6 { font-size: 1rem; }

p {
  color: var(--text-light);
  font-size: 1rem;
  line-height: 1.6;
}

/* Gaya tombol */
.btn {
  padding: 12px 25px;
  border-radius: 6px;
  font-weight: 600;
  text-decoration: none;
  display: inline-block;
  transition: all 0.3s ease;
  cursor: pointer;
}

.btn-primary {
  background-color: var(--primary-color);
  color: white;
  border: none;
}

.btn-primary:hover {
  background-color: #0047CC;
  transform: translateY(-2px);
  color: white;
  
}


.btn-secondary {
  background-color: #f4f4f4;
  color: var(--text-color);
  border: none;
}

.btn-secondary:hover {
  background-color: #e0e0e0;
}

/* Gaya card */
.card {
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  transition: all 0.4s ease;
  cursor: pointer;
}

.card:hover {
  transform: translateY(-8px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.card img {
  transition: transform 0.6s ease;
}

.card:hover img {
  transform: scale(1.1);
}

/* Responsive */
@media (max-width: 768px) {
  section .container {
    flex-direction: column;
    text-align: center;
  }
  .image-stack img {
    position: relative !important;
    left: 0 !important;
    bottom: 0 !important;
    margin: 10px 0;
  }
  
  section {
    flex-direction: column !important;
    text-align: center;
    gap: 20px !important;
    padding: 25px 15px !important;
  }
  
  h1 { font-size: 2.5rem !important; }
  h2 { font-size: 2rem !important; }
  h3 { font-size: 1.5rem !important; }
  h4 { font-size: 1.25rem !important; }
  h5 { font-size: 1.1rem !important; }
  h6 { font-size: 1rem !important; }
  
  p {
    font-size: 0.9rem !important;
    margin: 0 auto 15px auto !important;
  }
  
  .btn {
    margin: 0 auto !important;
  }
}
</style>

<!-- Banner Section -->
<section class="banner-section position-relative overflow-hidden" style="width:100%;height:100vh;">
    <div class="banner-slider" style="position:relative;width:100%;height:100%;overflow:hidden;">

        <!-- Slide 1 -->
        <div class="banner-slide active d-flex flex-column justify-content-center align-items-center text-center text-white"
            style="position:absolute;width:100%;height:100%;background:url('FE/beranda/44.jpg') center/cover no-repeat;
                   opacity:1;transform:translateY(0);transition:all 1.2s ease-in-out;">
            <div class="banner-content">
                <h1 class="fw-bold" style="color: white">Professional Consulting</h1>
                <p style="color: white">Bersama kami wujudkan potensi terbaik Anda di dunia perbankan.</p>
                <a href="#layanan" class="btn btn-primary mt-2">Mari Bekerja Sama</a>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="banner-slide d-flex flex-column justify-content-center align-items-center text-center text-white"
            style="position:absolute;width:100%;height:100%;background:url('FE/baner/3.png') center/cover no-repeat;
                   opacity:0;transform:translateY(100%);transition:all 1.2s ease-in-out;">
            <div class="banner-content">
                <h1 class="fw-bold" style="color: white">Upgrade Skill Tanpa Batas</h1>
                <p style="color: white">Pelatihan & Sertifikasi Terbaik untuk Bankir Hebat.</p>
                <a href="#program" class="btn btn-primary mt-2">Pelajari Lebih Lanjut</a>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="banner-slide d-flex flex-column justify-content-center align-items-center text-center text-white"
            style="position:absolute;width:100%;height:100%;background:url('FE/baner/22.jpg') center/cover no-repeat;
                   opacity:0;transform:translateY(100%);transition:all 1.2s ease-in-out;">
            <div class="banner-content">
                <h1 class="fw-bold" style="color: white">Bergabunglah Bersama Kami</h1>
                <p style="color: white">Raih karier gemilang di dunia finansial.</p>
                <a href="#kontak" class="btn btn-primary mt-2">Hubungi Kami</a>
            </div>
        </div>

    </div>
</section>

{{-- <section style="padding:60px 0; background:var(--bg-light); text-align:center;">
  <h2>Event</h2>

  <div style="max-width:1200px; margin:0 auto; display:flex; flex-wrap:wrap; justify-content:center; gap:25px;">

    <!-- Card -->
    <div class="card" style="width:250px; height:320px; border-radius:10px; overflow:hidden; box-shadow:0 3px 8px rgba(0,0,0,0.1); background:white;">
      <!-- Gambar atas -->
      <div style="height:60%; overflow:hidden;">
        <img src="FE/images/images-demo-consulting-03.jpg" alt="Audit assurance"
             style="width:100%; height:100%; object-fit:cover;">
      </div>

      <!-- Konten bawah -->
      <div style="padding:15px; text-align:center;">
        <p style="font-size:12px; color:#777; margin-bottom:4px;">2025-10-26</p>
        <h4 style="font-size:12px; margin:0; font-weight:600;">FINANCIAL ADVISORY</h4>
        <p style="font-size:1px; color:#007bff; margin:0 0 8px;">JOHN DOE</p>
        <h5 style="color:#007bff; font-weight:700; margin-bottom:12px; font-size: 14px;;">Rp. 125,000</h5>
        <button style="background:#007bff; color:white; border:none; padding:3px 20px; border-radius:6px; cursor:pointer; font-weight:500;">
          Daftar
        </button>
      </div>
    </div>

    <!-- Ulangi card lain sesuai kebutuhan -->
    <div class="card" style="width:250px; height:320px; border-radius:10px; overflow:hidden; box-shadow:0 3px 8px rgba(0,0,0,0.1); background:white;">
      <div style="height:60%; overflow:hidden;">
        <img src="FE/images/images-demo-consulting-04.jpg" alt="Financial advisory"
             style="width:100%; height:100%; object-fit:cover;">
      </div>
      <div style="padding:15px; text-align:center;">
        <p style="font-size:12px; color:#777; margin-bottom:4px;">2025-10-26</p>
        <h4 style="font-size:12px; margin:0; font-weight:600;">FINANCIAL ADVISORY</h4>
        <p style="font-size:1px; color:#007bff; margin:0 0 8px;">JOHN DOE</p>
        <h5 style="color:#007bff; font-weight:700; margin-bottom:12px; font-size: 14px;;">Rp. 125,000</h5>
        <button style="background:#007bff; color:white; border:none; padding:3px 20px; border-radius:6px; cursor:pointer; font-weight:500;">
          Daftar
        </button>
      </div>
    </div>

     <div class="card" style="width:250px; height:320px; border-radius:10px; overflow:hidden; box-shadow:0 3px 8px rgba(0,0,0,0.1); background:white;">
      <!-- Gambar atas -->
      <div style="height:60%; overflow:hidden;">
        <img src="FE/images/images-demo-consulting-03.jpg" alt="Audit assurance"
             style="width:100%; height:100%; object-fit:cover;">
      </div>

      <!-- Konten bawah -->
      <div style="padding:15px; text-align:center;">
        <p style="font-size:12px; color:#777; margin-bottom:4px;">2025-10-26</p>
        <h4 style="font-size:12px; margin:0; font-weight:600;">FINANCIAL ADVISORY</h4>
        <p style="font-size:1px; color:#007bff; margin:0 0 8px;">JOHN DOE</p>
        <h5 style="color:#007bff; font-weight:700; margin-bottom:12px; font-size: 14px;;">Rp. 125,000</h5>
        <button style="background:#007bff; color:white; border:none; padding:3px 20px; border-radius:6px; cursor:pointer; font-weight:500;">
          Daftar
        </button>
      </div>
    </div>

    <!-- Ulangi card lain sesuai kebutuhan -->
    <div class="card" style="width:250px; height:320px; border-radius:10px; overflow:hidden; box-shadow:0 3px 8px rgba(0,0,0,0.1); background:white;">
      <div style="height:60%; overflow:hidden;">
        <img src="FE/images/images-demo-consulting-04.jpg" alt="Financial advisory"
             style="width:100%; height:100%; object-fit:cover;">
      </div>
      <div style="padding:15px; text-align:center;">
        <p style="font-size:12px; color:#777; margin-bottom:4px;">2025-10-26</p>
        <h4 style="font-size:12px; margin:0; font-weight:600;">FINANCIAL ADVISORY</h4>
        <p style="font-size:1px; color:#007bff; margin:0 0 8px;">JOHN DOE</p>
        <h5 style="color:#007bff; font-weight:700; margin-bottom:12px; font-size: 14px;;">Rp. 125,000</h5>
        <button style="background:#007bff; color:white; border:none; padding:3px 20px; border-radius:6px; cursor:pointer; font-weight:500;">
          Daftar
        </button>
      </div>
    </div>
  </div>
</section> --}}

<section style="padding:60px 0; background:var(--bg-light); text-align:center;">
  <h4 style="font-size:25px; color:#005CFF;">Event</h4>

  <div style="max-width:1200px; margin:0 auto; display:flex; flex-wrap:wrap; justify-content:center; gap:25px;">

    @foreach($kelas as $class)
      <div class="card" 
           style="width:250px; border-radius:10px; overflow:hidden; box-shadow:0 3px 8px rgba(0,0,0,0.1); background:white; display:flex; flex-direction:column;">

        <!-- Gambar -->
        <div style="width:100%; height:300px; oject-fit:fill flex-shrink:0; margin:0; padding:0;">
          <img 
            src="{{ $class->image ? asset($class->image) : asset('FE/images/images-demo-consulting-03.jpg') }}" 
            alt="{{ $class->title }}" 
            style="width:100%; height:100%; object-fit:fill; display:block; margin:0; padding:0; border:none;">
        </div>

        <!-- Konten -->
        <div style="flex:1; display:flex; flex-direction:column; justify-content:space-between; padding:15px; text-align:center;">
          <div>
            <p style="font-size:12px; color:#777; margin-bottom:4px;">
              {{ \Carbon\Carbon::parse($class->date_start)->format('Y-m-d') }}
            </p>
            <h4 style="font-size:12px; margin:0; font-weight:600; font-family:Arial, sans-serif ;">
              {{ strtoupper($class->title) }}
            </h4>


            @php
              $instructor = $class->instructor_list->first()->name ?? 'Instructor';
            @endphp

            <p style="font-size:12px; color:#007bff; margin:4px 0 8px; font-family:Arial, sans-serif ;">
              {{ strtoupper($instructor) }}
            </p>
          </div>

          <!-- Tombol (tetap di bawah) -->
           <button 
            onclick="window.location.href='{{ url('class/' . $class->unique_id . '/' . str_replace('/', '-', $class->title)) }}'" 
            style="background:#007bff; color:white; border:none; padding:4px 20px; border-radius:8px; cursor:pointer; font-weight:500; margin-top:10px; align-self:center;font-family:Arial, sans-serif ;">
            Daftar
          </button>
        </div>
      </div>
    @endforeach
  </div>
      <div style="width:100%; display:flex; justify-content:flex-end; margin-top:20px;">
      <a href="/list-class?jenis=bankir" 
         style="background:#007bff; color:white; text-decoration:none; padding:10px 20px; border-radius:25px; cursor:pointer; display:inline-block; margin-right:140px;">
         Semua Event
      </a>
    </div>
</section>




<!-- Section Keunggulan -->
<section style="padding:60px 0; background:var(--bg-white);">
  <h4 style="font-size: 25px; text-align: center; color: #005CFF;">Tiga Pilar Utama</h4>
  <div class="container" style="max-width:1200px; margin:0 auto;">
    <div class="row text-center">

      <!-- Item 1 -->
      <div class="col-lg-4 col-md-6 col-12 mb-4">
        <div style="padding:20px;">
          <img src="FE/images/images-demo-consulting-icon-01.png" alt="Innovative Ideas" style="width:60px; height:60px; margin-bottom:20px;">
          <h5 style="font-size: 20px;">Personal & Adaptif <br> Berbasis AI</h5>
          <p>Pelatihan dan Program berbasis AI dan Analitik Data disertai rekomendasi konten berdasarkan level pengguna</p>
        </div>
      </div>

      <!-- Item 2 -->
      <div class="col-lg-4 col-md-6 col-12 mb-4">
        <div style="padding:20px;">
          <img src="FE/images/images-demo-consulting-icon-02.png" alt="Expertise Strategy" style="width:60px; height:60px; margin-bottom:20px;">
          <h5 style="font-size: 20px;">Imersif & Praktis <br> Berbasis Simulasi</h5>
          <p>Rasakan simulasi nyata lingkungan kerja perbankan untuk mengasah keterampilan & kesiapan profesional.</p>
        </div>
      </div>

      <!-- Item 3 -->
      <div class="col-lg-4 col-md-6 col-12 mb-4">
        <div style="padding:20px;">
          <img src="FE/images/images-demo-consulting-icon-03.png" alt="Financial Planning" style="width:60px; height:60px; margin-bottom:20px;">
          <h5 style="font-size: 20px;">Jejaring & Pembelajaran <br> Kolaboratif</h5>
          <p>Belajar dengan ahli praktisi & kesempatan kerja di perusahaan bank terkemuka untuk mengembangkan kariermu sejak dini. </p>
        </div>
      </div>

    </div>
  </div>
</section>


<!-- Section Visi Perusahaan -->
<section style="padding:80px 0; background:var(--bg-white);">
  <div class="container" style="max-width:1200px; margin:0 auto; display:flex; flex-wrap:wrap; align-items:center; justify-content:center; gap:50px;">

    <!-- Kolom Gambar -->
    <div class="image-stack" style="position:relative; flex:1 1 45%; min-width:320px; display:flex; justify-content:center;">
      <img src="FE/beranda/Rectangle 10.png" alt="Team Member 1"
           style="width:320px; border-radius:15px; box-shadow:0 8px 20px rgba(0,0,0,0.1);
                  position:relative; top:0; animation:floatImage1 6s ease-in-out infinite;">
      <img src="FE/beranda/Rectangle 11.png" alt="Team Member 2"
           style="width:250px; border-radius:15px; box-shadow:0 8px 20px rgba(0,0,0,0.1);
                  position:absolute; bottom:-100px; left:300px; animation:floatImage2 6s ease-in-out infinite alternate;">
    </div>

    <!-- Kolom Konten -->
    <div class="text-content" style="flex:1 1 45%; min-width:320px;">
      <p style="font-size:14px; color:#005CFF; font-weight:600; margin-bottom:10px;">VISI PERUSAHAAN</p>
      <h2>Terjamin Hubungan & Kemajuan</h2>
      <p>Menjadi Ekosistem Pembelajaran Perbankan Digital Terdepan yang Memberdayakan Setiap Individu dan Lembaga untuk Bertumbuh dalam Era Keuangan Masa Depan.</p>

      <div style="margin-bottom:40px;">
        <a href="#about" class="btn btn-primary" style="margin-right:10px;">
           Tentang Kami
        </a>
        <a href="#work" class="btn btn-secondary">
          Cara Bekerja
        </a>
      </div>

      <div style="display:flex; align-items:center; gap:15px;">
        <h2 style="font-size:48px; margin:0;">4.9</h2>
        <div>
          <div style="color:#f4b400; font-size:20px;">★★★★★</div>
          <p style="color:var(--text-muted); font-size:14px; margin:0;">2,488 Testimoni Rating</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Section Layanan Konsultasi -->
<section style="padding:60px 0; background:var(--bg-light); text-align:center;">
  <p style="text-transform:uppercase; color:#005CFF; font-weight:600; font-size:14px; margin-bottom:5px;">SOLUSI INOVATIF</p>
  <h2 style="font-size: 30px;">Layanan Konsulting</h2>

  <div style="max-width:1200px; margin:0 auto; display:flex; flex-wrap:wrap; justify-content:center; gap:25px;">

    <!-- Card 1 -->
    <div class="card" style="position:relative; width:250px; height:320px;">
      <img src="FE/beranda/ly1.png" alt="Audit assurance"
           style="width:100%; height:100%; object-fit:cover;">
      <div style="position:absolute; inset:0; background:rgba(0,0,0,0.4); color:#fff; display:flex; flex-direction:column; justify-content:flex-end; padding:20px;">
        {{-- <span style="font-size:13px; color:#fbb03b;">Featured</span> --}}
        <h4 style="font-size:18px;  color:#ddd; margin:5px 0;">Banking Solution</h4>
        <p style="font-size:12px; color:#ddd;">Solusi untuk tantangan perbankan modern dengan tenaga kerja kompeten, siap menghadapi disrupsi teknologi & perubahan.</p>
      </div>
    </div>

    <!-- Card 2 -->
    <div class="card" style="position:relative; width:250px; height:320px;">
      <img src="FE/beranda/ly2.png" alt="Financial advisory"
           style="width:100%; height:100%; object-fit:cover;">
      <div style="position:absolute; inset:0; background:rgba(0,0,0,0.4); color:#fff; display:flex; flex-direction:column; justify-content:flex-end; padding:20px;">
        {{-- <span style="font-size:13px; color:#fbb03b;">Featured</span> --}}
        <h4 style="font-size:18px; color:#ddd; margin:5px 0;">Capacity Building</h4>
        <p style="font-size:12px; color:#ddd;">Berbagai pelatihan pembangunan fondasi kompetensi yang berkelanjutan & terukur (jangka panjang)</p>
      </div>
    </div>

    <!-- Card 3 -->
    <div class="card" style="position:relative; width:250px; height:320px;">
      <img src="FE/beranda/ly3.png" alt="Business analysis"
           style="width:100%; height:100%; object-fit:cover;">
      <div style="position:absolute; inset:0; background:rgba(0,0,0,0.4); color:#fff; display:flex; flex-direction:column; justify-content:flex-end; padding:20px;">
        {{-- <span style="font-size:13px; color:#fbb03b;">Featured</span> --}}
        <h4 style="font-size:18px; color:#ddd; margin:5px 0;">Banking Talent Solution</h4>
        <p style="font-size:12px; color:#ddd;">Solusi end-to-end guna membangun, mengembangkan, & mempertahakan talenta unggul yang siap menghadapi distruptif.</p>
      </div>
    </div>

    <!-- Card 4 -->
    <div class="card" style="position:relative; width:250px; height:320px;">
      <img src="FE/beranda/ly4.png" alt="Middle marketing"
           style="width:100%; height:100%; object-fit:cover;">
      <div style="position:absolute; inset:0; background:rgba(0,0,0,0.4); color:#fff; display:flex; flex-direction:column; justify-content:flex-end; padding:20px;">
        {{-- <span style="font-size:13px; color:#fbb03b;">Featured</span> --}}
        <h4 style="font-size:18px; color:#ddd; margin:5px 0;">Event</h4>
        <p style="font-size:12px; color:#ddd;">Temukan dan ikuti berbagai event yang telah kami rancang untuk mendukung perkembangan kompetensi di dunia perbankan.</p>
      </div>
    </div>

  </div>
</section>

<!-- Section Harga -->
<section style="padding:60px 0; background:var(--bg-white);">
  <div style="max-width:1000px; margin:0 auto; display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:40px;">

    <!-- Left content -->
    <div style="flex:1 1 400px;">
      <h2 style="color: #005CFF">Pertanyaan yang Sering <br> Diajukan</h2>
      <p style="color:#333333; font-size:15px; margin-bottom:25px; max-width:400px;">
       Berikut daftar yang sering ditanyakan.
      </p>
      <div style="text-align:left; margin-top:20px;">
  <p style="margin-bottom:8px; font-size:16px; color:#4c4949;">Butuh bantuan?</p>
  <button class="btn btn-primary" style="padding:10px 20px; font-size:14px;">Hubungi Lebih Lanjut</button>
</div>

    </div>

    <!-- Right accordion -->
    <div style="flex:1 1 400px;">
      <div style="border-bottom:1px solid #eee; padding:15px 0;">
        <div onclick="toggleAccordion(this)" style="display:flex; justify-content:space-between; align-items:center; cursor:pointer;">
          <strong>Program yang cocok atau rekomendasi?</strong>
          <span style="font-size:20px;">−</span>
        </div>
        <p style="margin-top:10px; color:var(--text-light); font-size:14px;">
          Bankir Academy menyediakan layanan konsultasi ataupun filter berdasarkan posisi Anda sehingga memudahkan dalam memilih program yang ingin diikuti.
        </p>
      </div>

      <div style="border-bottom:1px solid #eee; padding:15px 0;">
        <div onclick="toggleAccordion(this)" style="display:flex; justify-content:space-between; align-items:center; cursor:pointer;">
          <strong>Siapa saja yang dapat mengikuti program atau pelatihan?</strong>
          <span style="font-size:20px;">+</span>
        </div>
        <p style="margin-top:10px; color:var(--text-light); font-size:14px; display:none;">
          Siapapun dapat mengikuti program atau layanan yang disediakan, mulai dari orang yang baru mau belajar tentang perbankan, fresh graduate, karyawan, hingga HRD.
        </p>
      </div>

      <div style="border-bottom:1px solid #eee; padding:15px 0;">
        <div onclick="toggleAccordion(this)" style="display:flex; justify-content:space-between; align-items:center; cursor:pointer;">
          <strong>Apakah ada sertifikat yang diakui?</strong>
          <span style="font-size:20px;">+</span>
        </div>
        <p style="margin-top:10px; color:var(--text-light); font-size:14px; display:none;">
          Program yang dilaksanakan akan mendapatkan sertifikat dan juga ada layanan sertifikasi bagi yang membutuhkan.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- Section Video -->
<section style="position:relative; width:100%; height:450px; overflow:hidden; margin-top:40px;">
  <div style="position:relative; width:100%; height:100vh; overflow:hidden;">
    <video 
      autoplay 
      muted 
      loop 
      playsinline 
      style="position:absolute; top:0; left:0; width:100%; height:100%; object-fit:cover;"
    >
      <source src="{{ asset('FE/beranda/video.mp4') }}" type="video/mp4">
      Tidak Ada Video
    </video>
  </div>
</section>


  <!-- Optional overlay text -->
  {{-- <div style="position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.3); display:flex; align-items:center; justify-content:center; flex-direction:column; text-align:center; color:#fff; padding:0 15px;">
    <h2 style="color: black">Rasakan Kecanggihan Digital di Pelayanan Kami</h2>
    <p style="color: black">Penceritaan visual mendalam dan interaktif pada pelayanan program</p>
  </div> --}}
</section>

<section class="py-5 text-center">
  <div class="container">
    <p style="text-transform:uppercase; color:#005CFF; font-weight:600; font-size:14px; margin-bottom:5px;">KENALI MENTOR KAMI</p>
    <h2 class="fw-bold mb-5" style="font-size: 30px;">Para Ahli Berpengalaman</h2>

    <div class="row g-4 justify-content-center">
      <!-- Card 1 -->
      <div class="col-12 col-sm-6 col-md-3">
        <div class="position-relative overflow-hidden rounded" 
               style="cursor:pointer;transition:.4s ease;"
          onmouseover="
            this.querySelector('.d-flex.position-absolute').style.opacity='1';
            this.querySelectorAll('h5,p').forEach(e=>{
              e.setAttribute('style','color:white !important;position:relative;z-index:3;transition:color .3s ease;');
            });
          "
          onmouseout="
            this.querySelector('.d-flex.position-absolute').style.opacity='0';
            this.querySelector('h5').setAttribute('style','color:black;');
            this.querySelector('p').setAttribute('style','color:#6c757d;');
          ">
          <div class="d-flex justify-content-center align-items-center position-absolute w-100 h-100" 
               style="top:0; left:0;background-color:#007BFF;; opacity:0; transition:opacity 0.4s ease;">
            <div>
              <a href="#" class="text-white fs-4 mx-2"> <i class="bi bi-facebook"></i></a>
              <a href="#" class="text-white fs-4 mx-2"> <i class="bi bi-twitter"></i></a>
              <a href="#" class="text-white fs-4 mx-2"> <i class="bi bi-dribbble"></i></a>
            </div>
          </div>
          <div style="width:100%; height:320px; overflow:hidden; border-radius:8px;">
            <img src="FE/beranda/wahyu.png" class="img-fluid rounded" 
                 style="width:100%; height:100%; object-fit:cover; transition:transform 0.6s ease;">
          </div>
          <div class="mt-3">
            <h5 class="fw-semibold mb-0">Wahyu Muji Kristianto</h5>
            <p class="text-muted small mb-0">Consultant Professional</p>
          </div>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="col-12 col-sm-6 col-md-3">
        <div class="position-relative overflow-hidden rounded" 
               style="cursor:pointer;transition:.4s ease;"
          onmouseover="
            this.querySelector('.d-flex.position-absolute').style.opacity='1';
            this.querySelectorAll('h5,p').forEach(e=>{
              e.setAttribute('style','color:white !important;position:relative;z-index:3;transition:color .3s ease;');
            });
          "
          onmouseout="
            this.querySelector('.d-flex.position-absolute').style.opacity='0';
            this.querySelector('h5').setAttribute('style','color:black;');
            this.querySelector('p').setAttribute('style','color:#6c757d;');
          ">
          <div class="d-flex justify-content-center align-items-center position-absolute w-100 h-100" 
               style="top:0; left:0;background-color:#007BFF; opacity:0; transition:opacity 0.4s ease;">
            <div>
              <a href="#" class="text-white fs-4 mx-2"> <i class="bi bi-facebook"></i></a>
              <a href="#" class="text-white fs-4 mx-2"> <i class="bi bi-twitter"></i></a>
              <a href="#" class="text-white fs-4 mx-2"> <i class="bi bi-dribbble"></i></a>
            </div>
          </div>
          <div style="width:100%; height:320px; overflow:hidden; border-radius:8px;">
            <img src="FE/beranda/riris.png" class="img-fluid rounded" 
                 style="width:100%; height:100%; object-fit:cover; transition:transform 0.6s ease;">
          </div>
          <div class="mt-3">
            <h5 class="fw-semibold mb-0">Riris Eriska</h5>
            <p class="text-muted small mb-0">Consultant Professional</p>
          </div>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="col-12 col-sm-6 col-md-3">
        <div class="position-relative overflow-hidden rounded" 
              style="cursor:pointer;transition:.4s ease;"
          onmouseover="
            this.querySelector('.d-flex.position-absolute').style.opacity='1';
            this.querySelectorAll('h5,p').forEach(e=>{
              e.setAttribute('style','color:white !important;position:relative;z-index:3;transition:color .3s ease;');
            });
          "
          onmouseout="
            this.querySelector('.d-flex.position-absolute').style.opacity='0';
            this.querySelector('h5').setAttribute('style','color:black;');
            this.querySelector('p').setAttribute('style','color:#6c757d;');
          ">
          <div class="d-flex justify-content-center align-items-center position-absolute w-100 h-100" 
               style="top:0; left:0;background-color:#007BFF; opacity:0; transition:opacity 0.4s ease;">
            <div>
              <a href="#" class="text-white fs-4 mx-2"> <i class="bi bi-facebook"></i></a>
              <a href="#" class="text-white fs-4 mx-2"> <i class="bi bi-twitter"></i></a>
              <a href="#" class="text-white fs-4 mx-2"> <i class="bi bi-dribbble"></i></a>
            </div>
          </div>
          <div style="width:100%; height:320px; overflow:hidden; border-radius:8px;">
            <img src="FE/beranda/barudin.png" class="img-fluid rounded" 
                 style="width:100%; height:100%; object-fit:cover; transition:transform 0.6s ease;">
          </div>
          <div class="mt-3">
            <h5 class="fw-semibold mb-0">Baharudin</h5>
            <p class="text-muted small mb-0">Consultant Professional</p>
          </div>
        </div>
      </div>

      <!-- Card 4 -->
      <div class="col-12 col-sm-6 col-md-3">
      <div class="position-relative overflow-hidden rounded"
          style="cursor:pointer;transition:.4s ease;"
          onmouseover="
            this.querySelector('.d-flex.position-absolute').style.opacity='1';
            this.querySelectorAll('h5,p').forEach(e=>{
              e.setAttribute('style','color:white !important;position:relative;z-index:3;transition:color .3s ease;');
            });
          "
          onmouseout="
            this.querySelector('.d-flex.position-absolute').style.opacity='0';
            this.querySelector('h5').setAttribute('style','color:black;');
            this.querySelector('p').setAttribute('style','color:#6c757d;');
          ">

        <div class="d-flex justify-content-center align-items-center position-absolute w-100 h-100"
            style="top:0;left:0;background-color:#007BFF;opacity:0;transition:opacity .4s ease;">
          <div>
            <a href="#" class="text-white fs-4 mx-2"><i class="bi bi-facebook"></i></a>
            <a href="#" class="text-white fs-4 mx-2"><i class="bi bi-twitter"></i></a>
            <a href="#" class="text-white fs-4 mx-2"><i class="bi bi-dribbble"></i></a>
          </div>
        </div>

        <div style="width:100%;height:320px;overflow:hidden;border-radius:8px;">
          <img src="FE/beranda/haris.png" class="img-fluid rounded"
              style="width:100%;height:100%;object-fit:cover;transition:transform .6s ease;">
        </div>

        <div class="mt-3">
          <h5 class="fw-semibold mb-0">Harizar Widianto</h5>
          <p class="text-muted small mb-0">Consultant Professional</p>
        </div>
      </div>
    </div>

    </div>
  </div>
</section>


<!-- Section Berita -->
<section class="py-5" style="background:#f8fafc; padding:60px 0; text-align:center;">
  <div class="container" style="max-width:1200px; margin:0 auto;">
    <p style="text-transform:uppercase; color:#005CFF; font-weight:600; font-size:14px; margin-bottom:5px;">BERITA BISNIS</p>
    <h2 style="font-weight:700; font-size:30px; margin-bottom:40px;">Berita Terbaru dari Kami</h2>

    <div style="display:flex; flex-wrap:wrap; justify-content:center; gap:25px;">

      <!-- Card 1 -->
      <div style="flex:1 1 300px; max-width:350px;">
        <div style="border:1px solid #e5e7eb; border-radius:16px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.08); background:white; display:flex; flex-direction:column; height:100%;">

          <!-- Bagian teks di atas -->
          <div style="padding:20px; text-align:left;">
            <h6 style="font-weight:600; font-size:17px; margin-bottom:8px; line-height:1.4; color:#111827;">
              Menjalin kerja sama baru dengan 15 Perusahaan Terk...
            </h6>
            <p style="color:#6b7280; font-size:14px; line-height:1.5; margin:0;">
              Pada tanggal 11 Oktober 2025 lalu, Bankir Academy menjalin kerja sama baru dengan 15 perusahaan terkemuka internasional.
            </p>
          </div>

          <!-- Gambar di tengah -->
          <div style="height:180px; overflow:hidden;">
            <img src="FE/images/images-demo-consulting-blog-01.jpg" style="width:100%; height:100%; object-fit:cover;">
          </div>

          <!-- Info redaksi di bawah gambar -->
          <div style="display:flex; align-items:center; justify-content:flex-start; gap:8px; color:#6b7280; font-size:13px; padding:15px 20px 18px 20px; border-top:1px solid #f1f1f1;">
            <i class="bi bi-person" style="font-size:14px;"></i>
            <span>Tim Redaksi</span>
            <i class="bi bi-dot"></i>
            <i class="bi bi-clock"></i>
            <span>6 menit</span>
          </div>

        </div>
      </div>

      <!-- Card 2 -->
      <div style="flex:1 1 300px; max-width:350px;">
        <div style="border:1px solid #e5e7eb; border-radius:16px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.08); background:white; display:flex; flex-direction:column; height:100%;">

          <div style="padding:20px; text-align:left;">
            <h6 style="font-weight:600; font-size:17px; margin-bottom:8px; line-height:1.4; color:#111827;">
              15 Pekerja Kompeten Lulusan Bankir Academy diterima di 
            </h6>
            <p style="color:#6b7280; font-size:14px; line-height:1.5; margin:0;">
              1 November mendatang, 15 alumni program Bankir Academy akan mulai bekerja di perusahaan bank Internasional.
            </p>
          </div>

          <div style="height:180px; overflow:hidden;">
            <img src="FE/images/images-demo-consulting-blog-02.jpg" style="width:100%; height:100%; object-fit:cover;">
          </div>

          <div style="display:flex; align-items:center; justify-content:flex-start; gap:8px; color:#6b7280; font-size:13px; padding:15px 20px 18px 20px; border-top:1px solid #f1f1f1;">
            <i class="bi bi-person" style="font-size:14px;"></i>
            <span>Tim Redaksi</span>
            <i class="bi bi-dot"></i>
            <i class="bi bi-clock"></i>
            <span>8 menit</span>
          </div>

        </div>
      </div>

      <!-- Card 3 -->
      <div style="flex:1 1 300px; max-width:350px;">
        <div style="border:1px solid #e5e7eb; border-radius:16px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.08); background:white; display:flex; flex-direction:column; height:100%;">

          <div style="padding:20px; text-align:left;">
            <h6 style="font-weight:600; font-size:17px; margin-bottom:8px; line-height:1.4; color:#111827;">
             Pelatihan berbasis Virtual <br> Reality
            </h6>
            <p style="color:#6b7280; font-size:14px; line-height:1.5; margin:0;">
             Layanan program terbaru dengan memanfaatkan Virtual Reality sehingga merasakan pelatihan di dunia nyata.
            </p>
          </div>

          <div style="height:180px; overflow:hidden;">
            <img src="FE/images/images-demo-consulting-blog-03.jpg" style="width:100%; height:100%; object-fit:cover;">
          </div>

          <div style="display:flex; align-items:center; justify-content:flex-start; gap:8px; color:#6b7280; font-size:13px; padding:15px 20px 18px 20px; border-top:1px solid #f1f1f1;">
            <i class="bi bi-person" style="font-size:14px;"></i>
            <span>Tim Redaksi</span>
            <i class="bi bi-dot"></i>
            <i class="bi bi-clock"></i>
            <span>10 menit</span>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>

<section style="background:linear-gradient(180deg, #3b82f6 0%, #1e1b4b 100%); color:white; padding:40px 60px;">
  <div style="max-width:1100px; margin:auto; display:flex; align-items:center; justify-content:space-between;">
    
    <!-- Kiri -->
    <div style="flex:1;">
      <h2 style="font-size:20px; font-weight:600; margin:0 0 8px 0; color:white;">
        Ingin <span style="color:#ffcc33;">bekerja sama</span> dengan kami?
      </h2>
      <br>
      <br>
      <br>
      <p style="font-size:15px; margin:0; color:white;">
       Hubungi di 
      <a href="https://wa.me/62895333017060" style="color: #ffcc33; text-decoration:none;">
      0895333017060
      </a>

      </p>
    </div>

    <!-- Kanan -->
    <div style="flex:0 0 auto;">
      <img src="FE/beranda/logo.png" alt="globe" style="width:200px; height:200px; display:block;">
    </div>

  </div>
</section>



@include('front.layout.footer')
<script>
// Script untuk slider banner
document.addEventListener("DOMContentLoaded", function() {
    const slides = document.querySelectorAll(".banner-slide");
    let current = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            if (i === index) {
                slide.style.opacity = "1";
                slide.style.transform = "translateY(0)";
                slide.style.zIndex = "1";
            } else {
                slide.style.opacity = "0";
                slide.style.transform = "translateY(100%)";
                slide.style.zIndex = "0";
            }
        });
    }

    setInterval(() => {
        current = (current + 1) % slides.length;
        showSlide(current);
    }, 5000);
});

// Script untuk accordion
function toggleAccordion(el) {
    const parent = el.parentElement;
    const para = parent.querySelector('p');
    const icon = el.querySelector('span');
    const isOpen = para.style.display === 'block';
    
    // Tutup semua accordion
    document.querySelectorAll('section div[style*="border-bottom"]').forEach(item => {
        item.querySelector('p').style.display = 'none';
        item.querySelector('span').innerText = '+';
    });
    
    // Buka yang diklik
    if (!isOpen) {
        para.style.display = 'block';
        icon.innerText = '−';
    }
}

// Script untuk hover efek pada card tim
document.querySelectorAll('.position-relative').forEach(card => {
    const overlay = card.querySelector('.position-absolute');
    const img = card.querySelector('img');
    card.addEventListener('mouseenter', () => {
        if (overlay) overlay.style.opacity = '1';
        img.style.transform = 'scale(1.1)';
    });
    card.addEventListener('mouseleave', () => {
        if (overlay) overlay.style.opacity = '0';
        img.style.transform = 'scale(1)';
    });
});

// Script untuk hover efek pada card berita
document.querySelectorAll('.card').forEach(card => {
    const img = card.querySelector('img');
    card.addEventListener('mouseenter', () => {
        card.style.transform = 'translateY(-8px)';
        card.style.boxShadow = '0 10px 25px rgba(0,0,0,0.1)';
        img.style.transform = 'scale(1.1)';
    });
    card.addEventListener('mouseleave', () => {
        card.style.transform = 'translateY(0)';
        card.style.boxShadow = '0 5px 15px rgba(0,0,0,0.05)';
        img.style.transform = 'scale(1)';
    });
});
</script>
{{-- @endsection --}}