@extends('layouts.compact')
@section('content')

<div class="row" id="cv-ats-row">
    <div class="col-12 layout-top-spacing layout-spacing">

        {{-- HERO BANNER / HEADER CV --}}
        <div class="profile-banner p-5 text-center text-md-left mb-4 shadow-sm" style="background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); border-radius: 15px;">
            <div class="row align-items-center">
                <div class="col-md-8 text-white">
                    <span class="badge badge-pill mb-2" style="background: rgba(255,255,255,0.2); color: #fff;">
                        💼 Curriculum Vitae
                    </span>
                    <h1 class="display-5 font-weight-bold mb-1" style="letter-spacing: -1px;">{{ $user->name ?? 'Nama Lengkap Anda' }}</h1>
                    <h2 class="h5 mb-2 text-white-50 font-weight-normal">Full Stack Web Developer / Professional Title</h2>
                    <p class="mb-0 small text-white-50">
                        📍 Jakarta, Indonesia | ✉️ {{ $user->email ?? 'email@domain.com' }} | 📞 +62 812-3456-7890 | 🔗 linkedin.com/in/username
                    </p>
                </div>
                <div class="col-md-4 text-md-right mt-3 mt-md-0">
                    <button onclick="window.print()" class="btn btn-light btn-sm px-3 font-weight-bold shadow-sm" style="border-radius: 8px; color: #6366f1;">
                        🖨️ Cetak / Simpan PDF
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- KIRI: PROFIL RINGKAS & SKILLS (Struktur ATS Kolom Tunggal/Sidebar Ramah Scan) --}}
            <div class="col-lg-4 mb-4">
                <div class="card glass-card p-4 h-100 border-0 shadow-sm" style="border-radius: 12px; background: #fff;">
                    
                    {{-- RINGKASAN PROFESIONAL --}}
                    <div class="mb-4">
                        <h3 class="h5 font-weight-bold text-dark mb-2" style="border-bottom: 2px solid #6366f1; padding-bottom: 5px;">
                            Ringkasan Profil
                        </h3>
                        <p class="text-muted small text-justify">
                            Pengembang perangkat lunak yang berdedikasi dengan pengalaman lebih dari 3 tahun dalam membangun aplikasi web yang efisien dan terukur. Memiliki keahlian mendalam dalam ekosistem Laravel, Vue.js, dan optimasi basis data. Fokus pada penulisan kode yang bersih dan solusi yang berorientasi pada bisnis.
                        </p>
                    </div>

                    <hr style="border-color: #F1F5F9;">

                    {{-- KEAHLIAN / SKILLS (Berformat teks/kata kunci agar terbaca ATS) --}}
                    <div class="mb-4">
                        <h3 class="h5 font-weight-bold text-dark mb-2" style="border-bottom: 2px solid #6366f1; padding-bottom: 5px;">
                            Keahlian Inti
                        </h3>
                        <div class="d-flex flex-wrap gap-2 pt-1">
                            <span class="badge badge-light text-dark p-2 mb-2 mr-1" style="border: 1px solid #E2E8F0; font-size: 0.85rem;">PHP & Laravel</span>
                            <span class="badge badge-light text-dark p-2 mb-2 mr-1" style="border: 1px solid #E2E8F0; font-size: 0.85rem;">JavaScript (ES6+)</span>
                            <span class="badge badge-light text-dark p-2 mb-2 mr-1" style="border: 1px solid #E2E8F0; font-size: 0.85rem;">MySQL & PostgreSQL</span>
                            <span class="badge badge-light text-dark p-2 mb-2 mr-1" style="border: 1px solid #E2E8F0; font-size: 0.85rem;">RESTful API Development</span>
                            <span class="badge badge-light text-dark p-2 mb-2 mr-1" style="border: 1px solid #E2E8F0; font-size: 0.85rem;">Git & GitHub</span>
                            <span class="badge badge-light text-dark p-2 mb-2 mr-1" style="border: 1px solid #E2E8F0; font-size: 0.85rem;">HTML5 & CSS3 (Bootstrap)</span>
                        </div>
                    </div>

                    <hr style="border-color: #F1F5F9;">

                    {{-- BAHASA --}}
                    <div>
                        <h3 class="h5 font-weight-bold text-dark mb-2" style="border-bottom: 2px solid #6366f1; padding-bottom: 5px;">
                            Bahasa
                        </h3>
                        <p class="text-muted small mb-1"><strong>Bahasa Indonesia</strong> - Native / Penutur Asli</p>
                        <p class="text-muted small mb-0"><strong>Bahasa Inggris</strong> - Professional Working Proficiency</p>
                    </div>

                </div>
            </div>

            {{-- KANAN: PENGALAMAN KERJA & PENDIDIKAN --}}
            <div class="col-lg-8 mb-4">
                <div class="card glass-card p-4 h-100 border-0 shadow-sm" style="border-radius: 12px; background: #fff;">
                    
                    {{-- PENGALAMAN KERJA --}}
                    <div class="mb-4">
                        <h3 class="h5 font-weight-bold text-dark mb-3 d-flex align-items-center">
                            <span class="mr-2" style="color: #6366f1;">👔</span> Pengalaman Kerja
                        </h3>

                        {{-- Item Pengalaman 1 --}}
                        <div class="work-item mb-3 pb-3" style="border-bottom: 1px dashed #E2E8F0;">
                            <div class="d-flex justify-content-between align-items-start flex-wrap">
                                <div>
                                    <h4 class="h6 font-weight-bold text-dark mb-0">Software Engineer (Full-Stack)</h4>
                                    <span class="text-purple font-weight-bold small" style="color: #a855f7;">PT. Teknologi Utama Indonesia</span>
                                </div>
                                <span class="badge badge-light text-muted" style="border: 1px solid #CBD5E1;">Januari 2024 - Sekarang</span>
                            </div>
                            <ul class="text-muted small mt-2 pl-3">
                                <li>Mengembangkan dan memelihara aplikasi web internal berbasis Laravel 10 dan Vue.js, meningkatkan efisiensi operasional sebesar 25%.</li>
                                <li>Merancang dan mengoptimalkan database MySQL yang menangani lebih dari 50.000 transaksi harian aktif.</li>
                                <li>Berkolaborasi dalam tim Agile (Scrum) yang terdiri dari 5 developer untuk merilis fitur produk tepat waktu setiap sprint.</li>
                            </ul>
                        </div>

                        {{-- Item Pengalaman 2 --}}
                        <div class="work-item mb-2">
                            <div class="d-flex justify-content-between align-items-start flex-wrap">
                                <div>
                                    <h4 class="h6 font-weight-bold text-dark mb-0">Junior Web Developer</h4>
                                    <span class="text-purple font-weight-bold small" style="color: #a855f7;">Solusi Digital Studio</span>
                                </div>
                                <span class="badge badge-light text-muted" style="border: 1px solid #CBD5E1;">Maret 2022 - Desember 2023</span>
                            </div>
                            <ul class="text-muted small mt-2 pl-3">
                                <li>Membangun landing page dan sistem kustom e-commerce untuk klien UMKM lokal menggunakan Bootstrap dan CodeIgniter.</li>
                                <li>Mengintegrasikan payment gateway pihak ketiga (Midtrans) ke dalam sistem pembayaran web.</li>
                                <li>Melakukan bug fixing dan pemeliharaan rutin pada kode aplikasi eksisting untuk menjamin performa yang stabil.</li>
                            </ul>
                        </div>
                    </div>

                    {{-- PENDIDIKAN --}}
                    <div class="mb-4 pt-2">
                        <h3 class="h5 font-weight-bold text-dark mb-3 d-flex align-items-center">
                            <span class="mr-2" style="color: #6366f1;">🎓</span> Pendidikan
                        </h3>
                        
                        <div class="education-item">
                            <div class="d-flex justify-content-between align-items-start flex-wrap">
                                <div>
                                    <h4 class="h6 font-weight-bold text-dark mb-0">S1 Teknik Informatika</h4>
                                    <span class="text-muted small">Universitas Dian Nuswantoro</span>
                                </div>
                                <span class="badge badge-light text-muted" style="border: 1px solid #CBD5E1;">2018 - 2022</span>
                            </div>
                            <p class="text-muted small mt-1 mb-0">IPK: 3.75 / 4.00 | Fokus studi pada Rekayasa Perangkat Lunak.</p>
                        </div>
                    </div>

                    {{-- SERTIFIKASI & KELULUSAN (Menampilkan Data Dinamis Seperti Contoh Anda) --}}
                    <div>
                        <h3 class="h5 font-weight-bold text-dark mb-3 d-flex align-items-center">
                            <span class="mr-2" style="color: #6366f1;">📜</span> Sertifikasi & Pelatihan
                        </h3>

                        <div class="row">
                           
                                <div class="col-12 mb-2">
                                    <div class="p-2 rounded bg-light border d-flex justify-content-between align-items-center flex-wrap" style="border-color: #E2E8F0 !important;">
                                        <div class="small">
                                            <strong class="text-dark">Sertifikat Kompetensi</strong>
                                            <span class="text-muted"> | Skor: 100</span>
                                        </div>
                                        <small class="text-muted font-italic">
                                            Lulus: 11 July 2026
                                        </small>
                                    </div>
                                </div>
                        
                        </div>
                    </div>

                    {{-- FOOTER KARTU --}}
                    <div class="mt-4 pt-3 border-top text-right" style="border-color: #F1F5F9 !important;">
                        <small class="text-muted font-italic">
                            💡 Data di atas ditarik secara otomatis dan sah melalui sistem portofolio internal perusahaan.
                        </small>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection