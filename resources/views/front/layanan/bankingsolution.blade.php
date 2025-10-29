@include('front.layout.head')
@include('front.layout.topbar')
@include(env('CUSTOM_HEADER', 'front.layout.headerv3'))

<section style="padding:70px 0; background-color:#fff;">
  <div class="container" style="max-width:1100px; margin:auto;">
    <div class="row align-items-center">

      <!-- KIRI: GAMBAR (4 kolom) -->
      <div class="col-lg-4 col-md-4 col-12" style="position:relative; padding-right:0;margin-bottom:25px;">
        <img src="{{asset('FE/beranda/Rec.png')}}" 
             alt="finance" 
             style="width:100%; border-radius:8px; background:#ddd; display:block;">
          {{-- <div style="position:absolute; bottom:-20px; left:20px; background:white; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1); padding:15px 25px; display:flex; align-items:center;">
            <span style="font-size:36px; font-weight:700; color:#000; margin-right:10px;">85</span>
            <span style="color:#555; font-weight:500;">Project<br>completed</span>
          </div> --}}
        
      </div>

      <!-- KANAN: TEKS (8 kolom) -->
      <div class="col-lg-8 col-md-8 col-12" style="padding-left:10px;">
        <h3 style="font-size:28px; font-weight:700; margin-bottom:8px;">Banking Solution</h3>
        <h5 style="font-size:18px; font-weight:600; margin-bottom:15px;">Wujudkan Transformasi SDM Perbankan di Era Digital</h5>
        <p style="color:#555; line-height:1.6; margin-bottom:0; text-align:justify;">
          Dunia perbankan tengah menghadapi perubahan besar akibat disrupsi teknologi dan dinamika pasar keuangan yang terus berevolusi. Kami hadir untuk membantu lembaga keuangan beradaptasi dengan cepat — melalui solusi pembelajaran inovatif, sistem pengembangan talenta, serta pendekatan berbasis data dan teknologi imersif.
        </p>
      </div>

    </div>
  </div>
</section>


 <section style="padding:60px 0; background-color:#fff;">
  <div class="container" style="max-width:1100px; margin:auto;">
    <div class="row" style="display:flex; flex-wrap:wrap; align-items:flex-start;">

      <!-- Kolom Kiri (col-lg-4) -->
      <div class="col-lg-4 col-md-12" style="padding:15px;">
        <h2 style="font-size:22px; font-weight:700; line-height:1.4; margin-bottom:10px;">
          Apa saja yang ditawarkan?
        </h2>
        <p style="color:#555; margin-bottom:25px;">
          Kami menawarkan berbagai solusi inovatif untuk mendukung transformasi sektor perbankan dengan 4 pilar utama.
        </p>
        <a href="#" style="display:inline-block; background-color:#1a73e8; color:#fff; padding:12px 30px; border-radius:30px; text-decoration:none; font-weight:600; font-size:14px;">
          Mulai Sekarang
        </a>
      </div>

      <!-- Kolom Tengah (col-lg-4) -->
      <div class="col-lg-4 col-md-6" style="padding:15px;">
        <div style="display:flex; align-items:flex-start; gap:12px; ">
         <div>
          <img src="{{ asset('FE/beranda/Vector.png') }}" style="width:80px; height:auto;">
        </div>

          <div>
            <h5 style="font-size:16px; font-weight:700; margin:0;">Transformasi Pembelajaran Berbasis Teknologi Immersif</h5>
            <p style="color:#666; font-size:14px; margin-top:6px;">
              Bangun kompetensi perbankan lewat pengalaman belajar interaktif dan realistis: Virtual Bank Simulator, Gamified Learning, & VR Soft Skill Training.
            </p>
          </div>
        </div>

        <div style="display:flex; align-items:flex-start; gap:12px;">
           <div>
          <img src="{{ asset('FE/beranda/rocket.png') }}" style="width:80px; height:auto;">
          </div>
          <div>
            <h5 style="font-size:16px; font-weight:700; margin:0;">Solusi Pengembangan Talenta & Competency Mapping</h5>
            <p style="color:#666; font-size:14px; margin-top:6px;">
              Tingkatkan performa tim dengan pelatihan berbasis AI: AI-Powered Competency Assessment, Digital Leadership Academy.
            </p>
          </div>
        </div>
      </div>

      <!-- Kolom Kanan (col-lg-4) -->
      <div class="col-lg-4 col-md-6" style="padding:15px;">
        <div style="display:flex; align-items:flex-start; gap:12px; ">
          <div>
          <img src="{{ asset('FE/beranda/repeat.png') }}" style="width:80px; height:auto;">
          </div>
          <div>
            <h5 style="font-size:16px; font-weight:700; margin:0;">Konsultasi Transformasi Digital & Change Management</h5>
            <p style="color:#666; font-size:14px; margin-top:6px;">
              Dukung transformasi budaya & operasional bank menuju era digital: Digital Literacy Acceleration, Agile Workflow, & Change Champion Development.
            </p>
          </div>
        </div>

        <div style="display:flex; align-items:flex-start; gap:12px;">
           <div>
          <img src="{{ asset('FE/beranda/chart-column-big.png') }}" style="width:80px; height:auto;">
          </div>
          <div>
            <h5 style="font-size:16px; font-weight:700; margin:0;">Data Analytics & Performance Tracking</h5>
            <p style="color:#666; font-size:14px; margin-top:6px;">
              Ukur, pantau, & prediksi kinerja SDM secara real-time: Learning Analytics Dashboard, Performance Correlation Analysis, & Predictive Talent Analytics.
            </p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>


<<!-- SECTION KELEBIHAN PRODUK -->
<section style="background:linear-gradient(180deg, #3b82f6, #1e3a8a); padding:70px 20px; display:flex; flex-wrap:wrap; align-items:center; justify-content:center; color:white; text-align:left;">

  <!-- Kiri: Gambar ilustrasi -->
  <div style="flex:1 1 300px; max-width:500px; display:flex; justify-content:center; padding:10px; width:100%;">
    <img src="{{asset('FE/beranda/bs.png')}}" alt="Ilustrasi Produk" style="width:100%; max-width:300px; height:auto;">
  </div>

  <!-- Kanan: Teks -->
  <div style="flex:1 1 400px; max-width:600px; padding:10px 20px; width:100%;">
    <h2 style="font-size:28px; font-weight:700; margin-bottom:5px; color:white; text-align:left;">Kelebihan dari Produk Kami</h2>
    <p style="font-size:16px; color:white; margin-bottom:25px; text-align:left;">Mengapa memilih Banking Solution?</p>

    <ul style="list-style:none; padding:0; margin:0;">
      <li style="display:flex; align-items:flex-start; margin-bottom:15px;">
        <span style="color:white; background:#2563eb; border-radius:50%; width:22px; height:22px; display:flex; align-items:center; justify-content:center; font-size:13px; margin-right:12px; flex-shrink:0;">✔</span>
        <span style="display:block;">Pendekatan End-to-End: Mulai dari asesmen kompetensi hingga pengembangan karier, semua terintegrasi dalam satu ekosistem.</span>
      </li>

      <li style="display:flex; align-items:flex-start; margin-bottom:15px;">
        <span style="color:white; background:#2563eb; border-radius:50%; width:22px; height:22px; display:flex; align-items:center; justify-content:center; font-size:13px; margin-right:12px; flex-shrink:0;">✔</span>
        <span style="display:block;">Teknologi Canggih: Memanfaatkan AI, VR, dan gamifikasi untuk menciptakan pengalaman belajar yang menarik dan efektif.</span>
      </li>

      <li style="display:flex; align-items:flex-start; margin-bottom:15px;">
        <span style="color:white; background:#2563eb; border-radius:50%; width:22px; height:22px; display:flex; align-items:center; justify-content:center; font-size:13px; margin-right:12px; flex-shrink:0;">✔</span>
        <span style="display:block;">Hasil Terukur: Setiap program dilengkapi sistem monitoring dan analisis berbasis data untuk evaluasi kinerja yang nyata.</span>
      </li>

      <li style="display:flex; align-items:flex-start;">
        <span style="color:white; background:#2563eb; border-radius:50%; width:22px; height:22px; display:flex; align-items:center; justify-content:center; font-size:13px; margin-right:12px; flex-shrink:0;">✔</span>
        <span style="display:block;">Fleksibel & Skalabel: Dapat disesuaikan dengan kebutuhan institusi keuangan dari berbagai skala.</span>
      </li>
    </ul>
  </div>
</section>





<!-- SECTION BAWAH (RESPONSIVE INLINE CSS) -->
<section style="padding:60px 15px; background:#ffffff; display:flex; justify-content:center; align-items:center; flex-wrap:wrap;">
  <div style="max-width:1150px; width:100%; display:flex; flex-wrap:wrap; justify-content:space-between; align-items:stretch; gap:30px; padding:30px; box-sizing:border-box;">

    <!-- Form -->
    <div style="flex:1 1 450px; min-width:300px; background:#ffffff; color:#000; border-radius:8px; padding:30px; border:1px solid #1e90ff; box-sizing:border-box;">
      <h3 style="font-size:26px; font-weight:700; margin-bottom:30px; text-align:center; color:#005CFF;">
        Daftar Layanan <br> Banking Solution
      </h3>

      <form>
        <input type="text" placeholder="Masukkan nama anda*" style="width:100%; padding:12px 15px; margin-bottom:15px; border:1px solid #d1d5db; border-radius:30px; font-size:14px; box-sizing:border-box;">
        <input type="email" placeholder="Masukkan email anda*" style="width:100%; padding:12px 15px; margin-bottom:15px; border:1px solid #d1d5db; border-radius:30px; font-size:14px; box-sizing:border-box;">
        <textarea placeholder="Masukkan pesan anda*" style="width:100%; padding:12px 15px; margin-bottom:20px; border:1px solid #d1d5db; border-radius:20px; height:110px; font-size:14px; box-sizing:border-box;"></textarea>
        <button type="submit" style="width:100%; padding:12px; background:#1e90ff; color:#fff; font-weight:700; border:none; border-radius:30px; cursor:pointer; font-size:16px;">Kirim</button>
        <p style="font-size:12px; color:#666; margin-top:10px; text-align:center;">
          Saya memahami bahwa data saya akan disimpan dengan aman sesuai dengan kebijakan privasi.
        </p>
      </form>
    </div>

    <!-- Testimonial -->
  <div style="flex:1 1 450px; min-width:300px; color:#000; display:flex; flex-direction:column; justify-content:center; align-items:flex-start; text-align:left; padding:40px 30px; box-sizing:border-box;">
    <p style="color:#005CFF; font-weight:600; margin-bottom:10px; font-size:14px;">Alasan bergabung pelayanan kami</p>
    <h3 style="font-size:25px; font-weight:700; line-height:1.4; margin-bottom:20px;">Review dari alumni dan klien kami</h3>
    <p style="color:#444; line-height:1.6; font-size:16px; max-width:500px; margin-bottom:20px;">
      Program Banking Solution membantu tim kami memahami cara kerja digital banking dengan cara yang interaktif dan menyenangkan.
      Simulator dan gamifikasinya benar-benar efektif!
    </p>
    <p style="font-weight:700; margin-bottom:5px;">Julia Rahmadany</p>
    <p style="color:#f59e0b; font-size:22px; letter-spacing:2px; margin-bottom:15px;">★★★★★</p>

    <!-- Navigation Arrows -->
    <div style="display:flex; gap:10px; justify-content:flex-start;">
      <button style="border:none; background:#125ef7; width:35px; height:35px; border-radius:50%; cursor:pointer; font-size:18px; color:white;">←</button>
      <button style="border:none; background:#125ef7; width:35px; height:35px; border-radius:50%; cursor:pointer; font-size:18px; color:white;">→</button>
    </div>
  </div>


  </div>
</section>



@include(env('CUSTOM_FOOTER', 'front.layout.footer'))

<script>
function toggleAccordion(element) {
  var content = element.querySelector('.accordion-content');
  var isVisible = content.style.display === 'block';
  document.querySelectorAll('.accordion-content').forEach(el => el.style.display = 'none');
  content.style.display = isVisible ? 'none' : 'block';
}
</script>

