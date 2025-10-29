@include('front.layout.head')
@include('front.layout.topbar')
@include(env('CUSTOM_HEADER', 'front.layout.headerv3'))

<section style="padding:70px 0; background-color:#fff;">
  <div class="container" style="max-width:1100px; margin:auto;">
    <div class="row align-items-center">

      <!-- KIRI: GAMBAR (4 kolom) -->
<<<<<<< HEAD
      <div class="col-lg-4 col-md-5 col-12" style="position:relative; padding-right:0;">
=======
      <div class="col-lg-4 col-md-5 col-12" style="position:relative; padding-right:0; margin-bottom: 25px;">
>>>>>>> 6a64ba7d511d7658144f76f58b9770456dae4af7
        <img src="{{asset('FE/beranda/Rec.png')}}" 
             alt="finance" 
             style="width:100%; border-radius:8px; background:#ddd; display:block;">
          {{-- <div style="position:absolute; bottom:-20px; left:20px; background:white; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1); padding:15px 25px; display:flex; align-items:center;">
            <span style="font-size:36px; font-weight:700; color:#000; margin-right:10px;">85</span>
            <span style="color:#555; font-weight:500;">Project<br>completed</span>
          </div> --}}
        
      </div>

      <!-- KANAN: TEKS (8 kolom) -->
<<<<<<< HEAD
      <div class="col-lg-8 col-md-7 col-12" style="padding-left:40px;">
=======
      <div class="col-lg-8 col-md-7 col-12" style="padding-left:10px;">
>>>>>>> 6a64ba7d511d7658144f76f58b9770456dae4af7
        <h3 style="font-size:28px; font-weight:700; margin-bottom:8px;">Banking Talent Solution</h3>
        <h5 style="font-size:18px; font-weight:600; margin-bottom:15px;">Bangun, Kembangkan, dan Pertahankan Talenta Unggul di Dunia Perbankan Modern</h5>
        <p style="color:#555; line-height:1.6; margin-bottom:0; text-align:justify;">
          Dalam era disrupsi digital, keberhasilan industri perbankan tidak hanya bergantung pada teknologi — tetapi juga pada talenta yang adaptif, visioner, dan siap berinovasi. Banking Talent Solution menghadirkan solusi end-to-end untuk mengidentifikasi, mengembangkan, dan mempertahankan talenta terbaik agar institusi keuangan Anda mampu tumbuh secara berkelanjutan.
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
          Kami menawarkan solusi pengembangan talenta perbankan yang dirancang untuk mencetak profesional unggul dan berdaya saing melalui 6 pilar utama yang terintegrasi.
        </p>
        <a href="#" style="display:inline-block; text-align: justify; background-color:#1a73e8; color:#fff; padding:12px 30px; border-radius:30px; text-decoration:none; font-weight:600; font-size:14px;">
          Mulai Sekarang
        </a>
      </div>

      <!-- Kolom Tengah (col-lg-4) -->
      <div class="col-lg-4 col-md-6" style="padding:15px;">
        <div style="display:flex; align-items:flex-start; gap:12px; ">
         <div>
          <img src="{{ asset('FE/beranda/file.png') }}" style="width:110px; height:auto;">
        </div>

          <div>
            <h5 style="font-size:16px; font-weight:700; margin:0;">Talent Assessment & Competency </h5>
            <p style="color:#666; font-size:14px; margin-top:6px; text-align: justify;">
             Petakan potensi & kompetensi talenta secara akurat untuk pengembangan tepat sasaran: AI-Driven Talent Analytics, 360° Competency Mapping, Technical Skill Certification, & Future-Readiness Assessment.
            </p>
          </div>
        </div>

        <div style="display:flex; align-items:flex-start; gap:12px;">
           <div>
          <img src="{{ asset('FE/beranda/V.png') }}" style="width:90px; height:auto;">
          </div>
          <div>
            <h5 style="font-size:16px; font-weight:700; margin:0;">Leadership Acceleration Program</h5>
            <p style="color:#666; font-size:14px; margin-top:6px; text-align: justify;">
              Program membangun pemimpin masa depan yang transformatif untuk masa depan perbankan: Digital Leadership Journey, Strategic Immersion, Executive Mentorship.
            </p>
          </div>
        </div>

         <div style="display:flex; align-items:flex-start; gap:12px;">
           <div>
          <img src="{{ asset('FE/beranda/chart-column-big.png') }}" style="width:110px; height:auto;">
          </div>
          <div>
            <h5 style="font-size:16px; font-weight:700; margin:0;">Performance Excellence Framework</h5>
            <p style="color:#666; font-size:14px; margin-top:6px; text-align: justify;">
              Tingkatkan akuntabilitas & kinerja organisasi dengan pendekatan berbasis data: OKR Implementation, Continuous Feedback, Performance Coaching, & Data-Driven Analytics.
            </p>
          </div>
        </div>
      </div>

      <!-- Kolom Kanan (col-lg-4) -->
      <div class="col-lg-4 col-md-6" style="padding:15px;">
        <div style="display:flex; align-items:flex-start; gap:12px; ">
          <div>
          <img src="{{ asset('FE/beranda/Vector.png') }}" style="width:90px; height:auto;">
          </div>
          <div>
            <h5 style="font-size:16px; font-weight:700; margin:0;">Digital Skill Transformation</h5>
            <p style="color:#666; font-size:14px; margin-top:6px;">
              Program percepatan penguasaan kompetensi digital & teknologi keuangan: Digital literacy bootcamp, specialized tech academy, Agile Methodology Training, dan Fintech Collaboration program.
            </p>
          </div>
        </div>

        <div style="display:flex; align-items:flex-start; gap:12px;">
           <div>
          <img src="{{ asset('FE/beranda/stream.png') }}" style="width:110px; height:auto;">
          </div>
          <div>
            <h5 style="font-size:16px; font-weight:700; margin:0;">Talent Mobility & Succession Planning</h5>
            <p style="color:#666; font-size:14px; margin-top:6px;">
              Kelola talenta untuk suksesi & mobilitas karier berkelanjutan: Succession Dashboard, Rotation Program, Career Path Architecture, & Talent Pool Management.
            </p>
          </div>
        </div>
         <div style="display:flex; align-items:flex-start; gap:12px;">
           <div>
          <img src="{{ asset('FE/beranda/user.png') }}" style="width:110px; height:auto;">
          </div>
          <div>
            <h5 style="font-size:16px; font-weight:700; margin:0;">Young Talent Pipeline</h5>
            <p style="color:#666; font-size:14px; margin-top:6px;">
             Kembangkan talenta muda sebagai fondasi masa depan perbankan: Graduate Program, Campus Talent Development, Millennial Leadership, & Innovative Internship.
            </p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>


<<<<<<< HEAD
<!-- SECTION KELEBIHAN PRODUK -->
<section style="background:linear-gradient(180deg, #3b82f6, #1e3a8a); padding:70px 40px; display:flex; align-items:center; justify-content:center; color:white; flex-wrap:wrap;">
  
  <!-- Kiri: Gambar ilustrasi (col-lg-5) -->
  <div style="flex:0 0 41.666%; max-width:41.666%; display:flex; justify-content:center; padding:10px;">
    <img src="{{asset('FE/beranda/bs.png')}}" alt="Ilustrasi Produk" style="width:100%; max-width:300px; height:auto;">
  </div>

  <!-- Kanan: Teks (col-lg-7) -->
  <div style="flex:0 0 58.333%; max-width:58.333%; padding:10px 20px;">
    <h2 style="font-size:28px; font-weight:700; margin-bottom:5px; color: white;">Kelebihan dari Produk Kami</h2>
    <p style="font-size:16px; color: white; margin-bottom:25px;">Mengapa memilih Banking Talent Solution?</p>

    <ul style="list-style:none; padding:0; margin:0;">
      <li style="display:flex; align-items:flex-start; margin-bottom:15px;">
        <span style="color:white; background:#2563eb; border-radius:50%; width:22px; height:22px; display:flex; align-items:center; justify-content:center; font-size:13px; margin-right:12px;">✔</span>
        <span>Pendekatan End-to-End: Mulai dari asesmen hingga retensi talenta, semua terintegrasi dalam satu sistem komprehensif.</span>
      </li>

      <li style="display:flex; align-items:flex-start; margin-bottom:15px;">
        <span style="color:white; background:#2563eb; border-radius:50%; width:22px; height:22px; display:flex; align-items:center; justify-content:center; font-size:13px; margin-right:12px;">✔</span>
        <span>Berbasis Data & Teknologi: Didukung analitik berbasis AI dan dashboard pemantauan real-time.</span>
      </li>

      <li style="display:flex; align-items:flex-start; margin-bottom:15px;">
        <span style="color:white; background:#2563eb; border-radius:50%; width:22px; height:22px; display:flex; align-items:center; justify-content:center; font-size:13px; margin-right:12px;">✔</span>
        <span>Mentor & Praktisi Ahli: Bekerja sama dengan eksekutif dan profesional berpengalaman di industri keuangan.</span>
      </li>

      <li style="display:flex; align-items:flex-start;">
        <span style="color:white; background:#2563eb; border-radius:50%; width:22px; height:22px; display:flex; align-items:center; justify-content:center; font-size:13px; margin-right:12px;">✔</span>
        <span>Fokus Transformasi Digital: Membentuk SDM yang siap beradaptasi dengan disrupsi teknologi.</span>
=======


<!-- SECTION KELEBIHAN PRODUK -->
<section style="background:linear-gradient(180deg, #3b82f6, #1e3a8a); padding:70px 20px; display:flex; flex-wrap:wrap; align-items:center; justify-content:center; color:white; text-align:left;">

  <!-- Kiri: Gambar ilustrasi -->
  <div style="flex:1 1 300px; max-width:500px; display:flex; justify-content:center; padding:10px; width:100%;">
    <img src="{{asset('FE/beranda/bs.png')}}" alt="Ilustrasi Produk" style="width:100%; max-width:300px; height:auto;">
  </div>

  <!-- Kanan: Teks -->
  <div style="flex:1 1 400px; max-width:600px; padding:10px 20px; width:100%;">
    <h2 style="font-size:28px; font-weight:700; margin-bottom:5px; color:white; text-align:left;">Kelebihan dari Produk Kami</h2>
    <p style="font-size:16px; color:white; margin-bottom:25px; text-align:left;">Mengapa memilih Banking Talent Solution?</p>

    <ul style="list-style:none; padding:0; margin:0;">
      <li style="display:flex; align-items:flex-start; margin-bottom:15px;">
        <span style="color:white; background:#2563eb; border-radius:50%; width:22px; height:22px; display:flex; align-items:center; justify-content:center; font-size:13px; margin-right:12px; flex-shrink:0;">✔</span>
        <span style="display:block;">Pendekatan End-to-End: Mulai dari asesmen hingga retensi talenta, semua terintegrasi dalam satu sistem komprehensif.</span>
      </li>

      <li style="display:flex; align-items:flex-start; margin-bottom:15px;">
        <span style="color:white; background:#2563eb; border-radius:50%; width:22px; height:22px; display:flex; align-items:center; justify-content:center; font-size:13px; margin-right:12px; flex-shrink:0;">✔</span>
        <span style="display:block;">Berbasis Data & Teknologi: Didukung analitik berbasis AI dan dashboard pemantauan real-time.</span>
      </li>

      <li style="display:flex; align-items:flex-start; margin-bottom:15px;">
        <span style="color:white; background:#2563eb; border-radius:50%; width:22px; height:22px; display:flex; align-items:center; justify-content:center; font-size:13px; margin-right:12px; flex-shrink:0;">✔</span>
        <span style="display:block;">Mentor & Praktisi Ahli: Bekerja sama dengan eksekutif dan profesional berpengalaman di industri keuangan.</span>
      </li>

      <li style="display:flex; align-items:flex-start;">
        <span style="color:white; background:#2563eb; border-radius:50%; width:22px; height:22px; display:flex; align-items:center; justify-content:center; font-size:13px; margin-right:12px; flex-shrink:0;">✔</span>
        <span style="display:block;">Fokus Transformasi Digital: Membentuk SDM yang siap beradaptasi dengan disrupsi teknologi.</span>
>>>>>>> 6a64ba7d511d7658144f76f58b9770456dae4af7
      </li>
    </ul>
  </div>
</section>



<<<<<<< HEAD

    <!-- SECTION 3 -->
{{-- <section style="padding:80px 0; display:flex; flex-wrap:wrap; justify-content:center; align-items:flex-start;">
  
  <div style="max-width:1100px; width:100%; display:flex; flex-wrap:wrap; justify-content:space-between; align-items:flex-start;">

    <!-- Left Content -->
    <div style="flex:1 1 480px; max-width:600px; padding:0 30px;">
      <h2 style="font-size:32px; font-weight:700; line-height:1.3; margin-bottom:20px; color:#000;">
        Transform your<br>business now.
      </h2>

      <!-- Accordion Item -->
      <div style="margin-bottom:15px; border-bottom:1px solid #ddd; padding:12px 0;" onclick="toggleAccordion(this)">
        <div style="display:flex; justify-content:space-between; align-items:center; cursor:pointer;">
          <span style="font-size:18px; font-weight:600;">How will my financial planning be done?</span>
          <span>▼</span>
        </div>
        <p class="accordion-content" style="display:none; color:#666; margin-top:10px;">
          Lorem ipsum is simply dummy text of the printing industry typesetting industry lorem.
        </p>
      </div>

      <div style="margin-bottom:15px; border-bottom:1px solid #ddd; padding:12px 0;" onclick="toggleAccordion(this)">
        <div style="display:flex; justify-content:space-between; align-items:center; cursor:pointer;">
          <span style="font-size:18px; font-weight:600;">What is your investment philosophy?</span>
          <span>▶</span>
        </div>
        <p class="accordion-content" style="display:none; color:#666; margin-top:10px;">
          Explanation about investment philosophy goes here.
        </p>
      </div>

      <div style="border-bottom:1px solid #ddd; padding:12px 0;" onclick="toggleAccordion(this)">
        <div style="display:flex; justify-content:space-between; align-items:center; cursor:pointer;">
          <span style="font-size:18px; font-weight:600;">Do we really need a financial planner?</span>
          <span>▶</span>
        </div>
        <p class="accordion-content" style="display:none; color:#666; margin-top:10px;">
          Financial planners help you optimize long-term wealth.
        </p>
      </div>

      <p style="margin-top:40px; color:#444; font-size:16px;">
        Save your precious time and effort spent for finding a solution. 
        <a href="#" style="color:#000; font-weight:bold; text-decoration:underline;">Contact us now</a>
      </p>
    </div>

    <!-- Right Content -->
    <div style="flex:1 1 300px; max-width:380px; display:flex; justify-content:center; align-items:center; padding:20px;">
      <button style="padding:14px 30px; border-radius:50px; border:1px solid #ccc; background:#fff; box-shadow:0 0 8px rgba(0,0,0,0.1); cursor:pointer; font-weight:600; font-size:14px;">
        ▶ HOW IT WORKS
      </button>
    </div>

  </div>
</section> --}}


<!-- SECTION BAWAH (DIREVISI MIRIP GAMBAR) -->
<section style="padding:60px 0; background:#ffffff; display:flex; justify-content:center; align-items:center;">
  <div style="max-width:1150px; width:100%; display:flex; flex-wrap:wrap; justify-content:space-between; align-items:stretch; gap:30px; border:1px  border-radius:10px; padding:30px;">

    <!-- Form -->
    <div style="flex:0 0 48%; background:#ffffff; color:#000; border-radius:8px; padding:30px; border:1px solid #1e90ff;">
      <h3 style="font-size:26px; font-weight:700; margin-bottom:30px; text-align:center; color:#005CFF;">Daftar Layanan Banking Talent Solution</h3>

      <form>
        <input type="text" placeholder="Masukkan nama anda*" style="width:100%; padding:12px 15px; margin-bottom:15px; border:1px solid #d1d5db; border-radius:30px;">
        <input type="email" placeholder="Masukkan email anda*" style="width:100%; padding:12px 15px; margin-bottom:15px; border:1px solid #d1d5db; border-radius:30px;">
        <textarea placeholder="Masukkan pesan anda*" style="width:100%; padding:12px 15px; margin-bottom:20px; border:1px solid #d1d5db; border-radius:20px; height:110px;"></textarea>
=======
<!-- SECTION BAWAH (RESPONSIVE INLINE CSS) -->
<section style="padding:60px 15px; background:#ffffff; display:flex; justify-content:center; align-items:center; flex-wrap:wrap;">
  <div style="max-width:1150px; width:100%; display:flex; flex-wrap:wrap; justify-content:space-between; align-items:stretch; gap:30px; padding:30px; box-sizing:border-box;">

    <!-- Form -->
    <div style="flex:1 1 450px; min-width:300px; background:#ffffff; color:#000; border-radius:8px; padding:30px; border:1px solid #1e90ff; box-sizing:border-box;">
      <h3 style="font-size:26px; font-weight:700; margin-bottom:30px; text-align:center; color:#005CFF;">
        Daftar Layanan <br> Capacity Building
      </h3>

      <form>
        <input type="text" placeholder="Masukkan nama anda*" style="width:100%; padding:12px 15px; margin-bottom:15px; border:1px solid #d1d5db; border-radius:30px; font-size:14px; box-sizing:border-box;">
        <input type="email" placeholder="Masukkan email anda*" style="width:100%; padding:12px 15px; margin-bottom:15px; border:1px solid #d1d5db; border-radius:30px; font-size:14px; box-sizing:border-box;">
        <textarea placeholder="Masukkan pesan anda*" style="width:100%; padding:12px 15px; margin-bottom:20px; border:1px solid #d1d5db; border-radius:20px; height:110px; font-size:14px; box-sizing:border-box;"></textarea>
>>>>>>> 6a64ba7d511d7658144f76f58b9770456dae4af7
        <button type="submit" style="width:100%; padding:12px; background:#1e90ff; color:#fff; font-weight:700; border:none; border-radius:30px; cursor:pointer; font-size:16px;">Kirim</button>
        <p style="font-size:12px; color:#666; margin-top:10px; text-align:center;">
          Saya memahami bahwa data saya akan disimpan dengan aman sesuai dengan kebijakan privasi.
        </p>
      </form>
    </div>

    <!-- Testimonial -->
<<<<<<< HEAD
    <div style="flex:0 0 48%; color:#000; display:flex; flex-direction:column; justify-content:flex-start; padding:50px 50px;">
      <p style="color:#005CFF; font-weight:600; margin-bottom:10px; font-size:14px;">Alasan bergabung pelayanan kami</p>
      <h3 style="font-size:25px; font-weight:700; line-height:1.4; margin-bottom:20px;">Review dari alumni dan klien kami</h3>
      <p style="color:#444; margin-bottom:20px; line-height:1.6; font-size:16px; justify-content: center;">
        Program ini membantu kami membangun sistem suksesi yang jelas dan efektif. Kini kami lebih siap menghadapi rotasi dan promosi jabatan strategis.
      </p>
      <p style="font-weight:700; margin-bottom:5px;">Reyfaldi R - HRBP Bank Semarang</p>
      <p style="color:#f59e0b; font-size:22px; letter-spacing:2px; margin-bottom:5px;">★★★★★</p>

      <!-- Navigation Arrows -->
      <div style="display:flex; gap:10px;">
        <button style="border:none; background:#125ef7; width:35px; height:35px; border-radius:50%; cursor:pointer; font-size:18px;">←</button>
        <button style="border:none; background:#125ef7; width:35px; height:35px; border-radius:50%; cursor:pointer; font-size:18px;">→</button>
      </div>
    </div>
=======
  <div style="flex:1 1 450px; min-width:300px; color:#000; display:flex; flex-direction:column; justify-content:center; align-items:flex-start; text-align:left; padding:40px 30px; box-sizing:border-box;">
    <p style="color:#005CFF; font-weight:600; margin-bottom:10px; font-size:14px;">Alasan bergabung pelayanan kami</p>
    <h3 style="font-size:25px; font-weight:700; line-height:1.4; margin-bottom:20px;">Review dari alumni dan klien kami</h3>
    <p style="color:#444; line-height:1.6; font-size:16px; max-width:500px; margin-bottom:20px;">
       Program ini membantu kami membangun sistem suksesi yang jelas dan efektif. Kini kami lebih siap menghadapi rotasi dan promosi jabatan strategis.
    </p>
    <p style="font-weight:700; margin-bottom:5px;">Reyfaldi R - HRBP Bank Semarang</p>
    <p style="color:#f59e0b; font-size:22px; letter-spacing:2px; margin-bottom:15px;">★★★★★</p>

    <!-- Navigation Arrows -->
    <div style="display:flex; gap:10px; justify-content:flex-start;">
      <button style="border:none; background:#125ef7; width:35px; height:35px; border-radius:50%; cursor:pointer; font-size:18px; color:white;">←</button>
      <button style="border:none; background:#125ef7; width:35px; height:35px; border-radius:50%; cursor:pointer; font-size:18px; color:white;">→</button>
    </div>
  </div>

>>>>>>> 6a64ba7d511d7658144f76f58b9770456dae4af7

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

