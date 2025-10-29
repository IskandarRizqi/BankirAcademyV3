@include('front.layout.head')
@include('front.layout.topbar')
@include(env('CUSTOM_HEADER', 'front.layout.headerv3'))

<section style="padding:70px 0; background-color:#fff;">
  <div class="container" style="max-width:1100px; margin:auto;">
    <div class="row align-items-center" style="display:flex; flex-wrap:wrap;">

      <!-- KIRI: GAMBAR (4 kolom) -->
      <div class="col-lg-4 col-md-5 col-12" style="position:relative; padding-right:0; flex:1 1 300px; min-width:280px; margin-bottom:25px;">
        <img src="{{asset('FE/beranda/Rec.png')}}" 
             alt="finance" 
             style="width:100%; border-radius:8px; background:#ddd; display:block;">
      </div>

      <!-- KANAN: TEKS (8 kolom) -->
      <div class="col-lg-8 col-md-7 col-12" style="padding-left:10px; flex:1 1 500px; min-width:280px;">
        <h3 style="font-size:28px; font-weight:700; margin-bottom:8px;">Capacity Building</h3>
        <h5 style="font-size:18px; font-weight:600; margin-bottom:15px;">Bangun Fondasi Kompetensi yang Kuat untuk Masa Depan Perbankan</h5>
        <p style="color:#555; line-height:1.6; margin-bottom:0; text-align:justify;">
          Industri keuangan terus berevolusi — menuntut tenaga kerja yang adaptif, inovatif, dan berorientasi masa depan.
          Capacity Building hadir sebagai solusi strategis untuk membangun fondasi kompetensi berkelanjutan (long-term skill development)
          melalui pelatihan, pendampingan, dan sistem pembelajaran yang terukur.
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
        <h2 style="font-size:22px; font-weight:700; line-height:1.4; ">
          Apa saja yang ditawarkan?
        </h2>
        <p style="color:#555; ">
          Kami menawarkan berbagai program pengembangan berkelanjutan untuk membangun fondasi kompetensi yang kuat dan adaptif di sektor keuangan melalui 5 pilar utama.
        </p>
        <a href="#" style="display:inline-block; background-color:#1a73e8; color:#fff; padding:12px 30px; border-radius:30px; text-decoration:none; font-weight:600; font-size:14px;">
          Mulai Sekarang
        </a>
      </div>

      <!-- Kolom Tengah (col-lg-4) -->
      <div class="col-lg-4 col-md-6" style="padding:15px;">
        <div style="display:flex; align-items:flex-start; gap:12px;">
         <div>
          <img src="{{ asset('FE/beranda/rocket.png') }}" style="width:150px; height:auto;">
        </div>

          <div>
            <h5 style="font-size:16px; font-weight:700; margin:0;"> Kompetensi Masa Depan</h5>
            <p style="color:#666; font-size:14px; margin-top:6px;">
             Siapkan tenaga kerja tangguh untuk transformasi keuangan digital & berkelanjutan: Digital Banking Mastery, Data Literacy Program, Cyber Security Awareness, & Green Banking Competency.
            </p>
          </div>
        </div>

        <div style="display:flex; align-items:flex-start; gap:12px;">
           <div>
          <img src="{{ asset('FE/beranda/user.png') }}" style="width:150px; height:auto;">
          </div>
          <div>
            <h5 style="font-size:16px; font-weight:700; margin:0;">Leadership Pipeline Development</h5>
            <p style="color:#666; font-size:14px; margin-top:6px;">
              Leadership Pipeline Development Bangun generasi pemimpin inovatif untuk mendorong transformasi perbankan: Strategic Leadership Training, Mentorship Ecosystem, Action Learning Project.
            </p>
          </div>
        </div>

        <div style="display:flex; align-items:flex-start; gap:12px;">
           <div>
          <img src="{{ asset('FE/beranda/V.png') }}" style="width:25px; height:auto; margin-right: 35px;">
          </div>
          <div>
            <h5 style="font-size:16px; font-weight:700; margin:0;">Impact Measurement & Sustainable Growth</h5>
            <p style="color:#666; font-size:14px; margin-top:6px;">
               Memastikan setiap program Capacity Building memberikan dampak terukur dan berkelanjutan.
            </p>
          </div>
        </div>
      </div>

      <!-- Kolom Kanan (col-lg-4) -->
      <div class="col-lg-4 col-md-6" style="padding:15px;">
        <div style="display:flex; align-items:flex-start; gap:12px; ">
          <div>
          <img src="{{ asset('FE/beranda/fast.png') }}" style="width:150px; height:auto;">
          </div>
          <div>
            <h5 style="font-size:16px; font-weight:700; margin:0;">Adaptive Learning Infrastructure</h5>
            <p style="color:#666; font-size:14px; margin-top:6px;">
             Bangun sistem pembelajaran yang lincah, adaptif, & responsif terhadap perubahan industri: Personalized Learning Platform, Microlearning Ecosystem, Mobile Learning, & Continuous Evaluation.
            </p>
          </div>
        </div>

        <div style="display:flex; align-items:flex-start; gap:12px;">
           <div>
          <img src="{{ asset('FE/beranda/stream.png') }}" style="width:150px; height:auto;">
          </div>
          <div>
            <h5 style="font-size:16px; font-weight:700; margin:0;">Collaborative Knowledge Ecosystem</h5>
            <p style="color:#666; font-size:14px; margin-top:6px;">
             Bangun budaya kolaborasi & berbagi pengetahuan untuk inovasi berkelanjutan: Professional Forum, Knowledge Platform, Innovation Labs, & Industry-Academia Partnership.
            </p>
          </div>
        </div>
      </div>

     
      </div>

    </div>
  </div>
</section>


<!-- SECTION KELEBIHAN PRODUK -->
<section style="background:linear-gradient(180deg, #3b82f6, #1e3a8a); padding:70px 20px; display:flex; flex-wrap:wrap; align-items:center; justify-content:center; color:white; text-align:left;">

  <!-- Kiri: Gambar ilustrasi -->
  <div style="flex:1 1 300px; max-width:500px; display:flex; justify-content:center; padding:10px; width:100%;">
    <img src="{{asset('FE/beranda/bs.png')}}" alt="Ilustrasi Produk" style="width:100%; max-width:300px; height:auto;">
  </div>

  <!-- Kanan: Teks -->
  <div style="flex:1 1 400px; max-width:600px; padding:10px 20px; width:100%;">
    <h2 style="font-size:28px; font-weight:700; margin-bottom:5px; color:white; text-align:left;">Kelebihan dari Produk Kami</h2>
    <p style="font-size:16px; color:white; margin-bottom:25px; text-align:left;">Mengapa memilih Capacity Building?</p>

    <ul style="list-style:none; padding:0; margin:0;">
      <li style="display:flex; align-items:flex-start; margin-bottom:15px;">
        <span style="color:white; background:#2563eb; border-radius:50%; width:22px; height:22px; display:flex; align-items:center; justify-content:center; font-size:13px; margin-right:12px; flex-shrink:0;">✔</span>
        <span style="display:block;">Pendekatan Berbasis Dampak: Setiap pelatihan dirancang untuk menghasilkan perubahan nyata dalam kompetensi SDM.</span>
      </li>

      <li style="display:flex; align-items:flex-start; margin-bottom:15px;">
        <span style="color:white; background:#2563eb; border-radius:50%; width:22px; height:22px; display:flex; align-items:center; justify-content:center; font-size:13px; margin-right:12px; flex-shrink:0;">✔</span>
        <span style="display:block;">Fokus Jangka Panjang: Kami tidak hanya melatih, tetapi juga membangun sistem pembelajaran berkelanjutan.</span>
      </li>

      <li style="display:flex; align-items:flex-start; margin-bottom:15px;">
        <span style="color:white; background:#2563eb; border-radius:50%; width:22px; height:22px; display:flex; align-items:center; justify-content:center; font-size:13px; margin-right:12px; flex-shrink:0;">✔</span>
        <span style="display:block;">Teknologi dan Insight Terkini: Didukung platform pembelajaran adaptif dan modul berbasis tren industri terbaru.</span>
      </li>

      <li style="display:flex; align-items:flex-start;">
        <span style="color:white; background:#2563eb; border-radius:50%; width:22px; height:22px; display:flex; align-items:center; justify-content:center; font-size:13px; margin-right:12px; flex-shrink:0;">✔</span>
        <span style="display:block;">Mentor Profesional: Dipandu oleh praktisi dan pakar berpengalaman dari dunia keuangan dan pendidikan.</span>
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
        Daftar Layanan <br> Capacity Building
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
       Program leadership dan mentorship-nya benar-benar membuka wawasan. Banyak insight baru yang bisa langsung diterapkan di pekerjaan.
    </p>
    <p style="font-weight:700; margin-bottom:5px;">Hartono S - Manager Bank BCP</p>
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

