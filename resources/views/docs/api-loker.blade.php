<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumentasi API & Management Key - Scraper Ingestion Loker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 font-sans antialiased">

    <div class="min-h-screen flex flex-col md:flex-row">

        <!-- Sidebar Navigation -->
        <aside class="w-full md:w-64 bg-slate-900 text-slate-300 flex-shrink-0 p-6">
            <div class="flex items-center space-x-2 mb-8">
                <span class="bg-blue-600 text-white font-bold p-2 rounded text-xs">API</span>
                <h1 class="text-lg font-bold text-white tracking-wide">Dokumentasi Loker</h1>
            </div>

            <nav class="space-y-6">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Admin Panel</p>
                    <ul class="space-y-1">
                        <li>
                            <a href="#manage-keys"
                                class="flex items-center text-sm font-medium text-amber-400 bg-slate-800 px-3 py-2 rounded-lg">
                                <span
                                    class="bg-amber-500/20 text-amber-400 font-bold text-[10px] px-1.5 py-0.5 rounded mr-2">ADMIN</span>
                                Kelola API Keys
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Endpoint Ingestion</p>
                    <ul class="space-y-1">
                        <li>
                            <a href="#post-loker-draft"
                                class="flex items-center text-sm font-medium text-slate-300 hover:text-white px-3 py-2 rounded-lg">
                                <span
                                    class="bg-green-500/20 text-green-400 font-bold text-[10px] px-1.5 py-0.5 rounded mr-2">POST</span>
                                Save Loker Draft
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Navigasi Cepat</p>
                    <ul class="space-y-1 text-sm text-slate-400">
                        <li><a href="#headers" class="block hover:text-white px-3 py-1">Header & Autentikasi</a></li>
                        <li><a href="#parameters" class="block hover:text-white px-3 py-1">Parameter Body</a></li>
                        <li><a href="#payload-examples" class="block hover:text-white px-3 py-1">Contoh Payload</a></li>
                        <li><a href="#client-integration" class="block hover:text-white px-3 py-1">Integrasi Klien</a>
                        </li>
                        <li><a href="#response-codes" class="block hover:text-white px-3 py-1">Respon API</a></li>
                    </ul>
                </div>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 p-6 md:p-12 max-w-5xl mx-auto space-y-12">

            <!-- SECTION: Kelola API Keys (Panel Admin) -->
            <section id="manage-keys" class="space-y-6">
                <div class="border-b border-slate-200 pb-4">
                    <h1 class="text-2xl font-extrabold text-slate-900">Manajemen Scraper API Key</h1>
                    <p class="text-slate-600 text-sm mt-1">Generate dan atur akses API Key untuk bot/scraper ingestion.
                    </p>
                </div>

                <!-- Flash Alert Error/Validation -->
                @if ($errors->any())
                    <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Flash Alert Success Notification -->
                @if (session('success') && !session('new_api_key'))
                    <div
                        class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Alert Khusus: Tampil Saat Key Baru Berhasil Di-generate -->
                @if (session('new_api_key'))
                    <div class="bg-amber-50 border-2 border-amber-300 rounded-xl p-5 shadow-sm space-y-3"
                        x-data="{ copied: false }">
                        <div class="flex items-center space-x-2 text-amber-900 font-bold">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <span>API Key Baru Berhasil Dibuat!</span>
                        </div>
                        <p class="text-xs text-amber-800">
                            Harap salin dan simpan API Key ini sekarang. Demi alasan keamanan, <strong>key ini tidak
                                akan pernah ditampilkan lagi</strong> setelah halaman direfresh.
                        </p>
                        <div class="flex items-center space-x-2">
                            <input type="text" id="plainApiKey" readonly value="{{ session('new_api_key') }}"
                                class="w-full bg-slate-900 text-green-400 font-mono text-sm px-4 py-2.5 rounded-lg border border-slate-700 focus:outline-none">
                            <button
                                @click="navigator.clipboard.writeText('{{ session('new_api_key') }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                class="bg-slate-900 hover:bg-slate-800 text-white font-medium text-xs px-4 py-3 rounded-lg transition-colors flex-shrink-0">
                                <span x-text="copied ? 'Tersalin!' : 'Salin Key'"></span>
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Form Generate New Key -->
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-4">
                    <h2 class="text-base font-bold text-slate-900">Generate Key Baru</h2>
                    <form action="{{ route('scraper-keys.store') }}" method="POST"
                        class="flex flex-col sm:flex-row gap-3">
                        @csrf
                        <input type="text" name="name"
                            placeholder="Nama Klien / Bot Scraper (contoh: Scraper Instagram V1)" required
                            class="flex-1 border border-slate-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-5 py-2 rounded-lg transition-colors shadow-sm">
                            Generate API Key
                        </button>
                    </form>
                </div>

                <!-- Key List Table -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="text-sm font-bold text-slate-800">Daftar API Key Terdaftar</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-slate-100 text-slate-600 uppercase text-[11px] font-semibold">
                                <tr>
                                    <th class="p-4">Nama Agent</th>
                                    <th class="p-4">Prefix (Identifier)</th>
                                    <th class="p-4">Status</th>
                                    <th class="p-4">Terakhir Digunakan</th>
                                    <th class="p-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs">
                                @forelse($apiKeys as $key)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="p-4 font-bold text-slate-800">{{ $key->name }}</td>
                                        <td class="p-4 font-mono text-slate-600">{{ $key->key_prefix }}</td>
                                        <td class="p-4">
                                            @if ($key->is_active)
                                                <span
                                                    class="bg-emerald-100 text-emerald-800 font-bold text-[10px] px-2 py-0.5 rounded-full">Aktif</span>
                                            @else
                                                <span
                                                    class="bg-slate-200 text-slate-600 font-bold text-[10px] px-2 py-0.5 rounded-full">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td class="p-4 text-slate-500">
                                            {{ $key->last_used_at ? $key->last_used_at->diffForHumans() : 'Belum pernah' }}
                                        </td>
                                        <td class="p-4 text-right space-x-2">
                                            <form action="{{ route('scraper-keys.toggle', $key->id) }}" method="POST"
                                                class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="text-xs font-semibold px-2.5 py-1 rounded border {{ $key->is_active ? 'border-amber-300 bg-amber-50 text-amber-700 hover:bg-amber-100' : 'border-emerald-300 bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                                                    {{ $key->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                </button>
                                            </form>
                                            <form action="{{ route('scraper-keys.destroy', $key->id) }}" method="POST"
                                                class="inline-block"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus key ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-xs font-semibold px-2.5 py-1 rounded border border-red-200 bg-red-50 text-red-600 hover:bg-red-100">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-6 text-center text-slate-400">Belum ada API Key
                                            yang dibuat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if (method_exists($apiKeys, 'links'))
                        <div class="p-4 border-t border-slate-100">
                            {{ $apiKeys->links() }}
                        </div>
                    @endif
                </div>
            </section>

            <hr class="border-slate-200">

            <!-- SECTION: Header Title Dokumentasi -->
            <div class="border-b border-slate-200 pb-6">
                <h1 class="text-3xl font-extrabold text-slate-900">Scraper Ingestion API</h1>
                <p class="text-slate-600 mt-2">API internal untuk menerima data lowongan kerja hasil scraping (Social
                    Media & Job Platform) ke dalam draft database.</p>
            </div>

            <!-- Endpoint Detail Section -->
            <section id="post-loker-draft" class="space-y-8">

                <!-- Endpoint Badge & Route -->
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                    <div class="flex items-center space-x-3">
                        <span class="bg-green-600 text-white font-extrabold text-xs px-2.5 py-1 rounded">POST</span>
                        <code
                            class="text-slate-800 font-mono text-base font-semibold">/api/v1/scraper/loker-draft</code>
                    </div>
                    <p class="text-sm text-slate-600 mt-3">Menyimpan draf lowongan kerja baru dari berbagai platform
                        scraping dengan enkripsi kunci API.</p>
                </div>

                <!-- Headers Section -->
                <div id="headers">
                    <h2 class="text-xl font-bold text-slate-900 mb-4">Request Headers & Otentikasi</h2>
                    <div class="overflow-x-auto bg-white rounded-xl border border-slate-200 shadow-sm">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-slate-100 text-slate-700 uppercase text-xs">
                                <tr>
                                    <th class="p-4">Header</th>
                                    <th class="p-4">Value</th>
                                    <th class="p-4">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-mono text-xs">
                                <tr class="bg-amber-50/40">
                                    <td class="p-4 font-bold text-slate-900">X-Scraper-Api-Key</td>
                                    <td class="p-4 text-amber-600">your_generated_api_key</td>
                                    <td class="p-4 font-sans text-slate-600"><span
                                            class="bg-amber-100 text-amber-800 font-bold text-[10px] px-1.5 py-0.5 rounded mr-1">Required</span>
                                        Kunci rahasia API untuk otentikasi bot/scraper (dibuat pada panel di atas).</td>
                                </tr>
                                <tr>
                                    <td class="p-4 font-bold text-slate-800">Content-Type</td>
                                    <td class="p-4 text-blue-600">application/json</td>
                                    <td class="p-4 font-sans text-slate-600">Format data yang dikirimkan.</td>
                                </tr>
                                <tr>
                                    <td class="p-4 font-bold text-slate-800">Accept</td>
                                    <td class="p-4 text-blue-600">application/json</td>
                                    <td class="p-4 font-sans text-slate-600">Format respon yang diharapkan.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Body Parameters Section -->
                <div id="parameters">
                    <h2 class="text-xl font-bold text-slate-900 mb-2">Parameter Body (JSON)</h2>
                    <p class="text-sm text-slate-600 mb-4">Payload dikirimkan dalam bentuk <strong>Array of
                            Objects</strong>. Hanya 3 field berikut yang <strong>wajib diisi (Required)</strong>,
                        selebihnya bersifat <strong>opsional (Nullable)</strong>.</p>
                    <div class="overflow-x-auto bg-white rounded-xl border border-slate-200 shadow-sm">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-slate-100 text-slate-700 uppercase text-xs">
                                <tr>
                                    <th class="p-4">Field</th>
                                    <th class="p-4">Tipe Data</th>
                                    <th class="p-4">Status</th>
                                    <th class="p-4">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-mono text-xs">
                                <tr class="bg-red-50/30">
                                    <td class="p-4 font-bold text-slate-900">source_type</td>
                                    <td class="p-4 text-purple-600">string</td>
                                    <td class="p-4 font-sans"><span
                                            class="bg-red-100 text-red-800 font-bold text-[10px] px-2 py-0.5 rounded">Required</span>
                                    </td>
                                    <td class="p-4 font-sans text-slate-600">Jenis sumber scraping (contoh:
                                        <code>social_media</code>, <code>job_platform</code>).
                                    </td>
                                </tr>
                                <tr class="bg-red-50/30">
                                    <td class="p-4 font-bold text-slate-900">nama_perusahaan</td>
                                    <td class="p-4 text-purple-600">string</td>
                                    <td class="p-4 font-sans"><span
                                            class="bg-red-100 text-red-800 font-bold text-[10px] px-2 py-0.5 rounded">Required</span>
                                    </td>
                                    <td class="p-4 font-sans text-slate-600">Nama entitas perusahaan / pemberi kerja.
                                    </td>
                                </tr>
                                <tr class="bg-red-50/30">
                                    <td class="p-4 font-bold text-slate-900">posisi</td>
                                    <td class="p-4 text-purple-600">string</td>
                                    <td class="p-4 font-sans"><span
                                            class="bg-red-100 text-red-800 font-bold text-[10px] px-2 py-0.5 rounded">Required</span>
                                    </td>
                                    <td class="p-4 font-sans text-slate-600">Nama jabatan / posisi pekerjaan yang
                                        ditawarkan.</td>
                                </tr>
                                <tr>
                                    <td class="p-4 font-bold text-slate-800">platform, logo_url, gaji_raw, gaji_min,
                                        gaji_max, ringkasan_ai, jobdesk, kualifikasi_jobspek, keahlian_skill,
                                        tipe_pekerjaan, tanggal_posting, batas_pendaftaran, no_hp, website_form_url,
                                        instagram_dm, cara_melamar, kategori_bidang, sumber_url, dll.</td>
                                    <td class="p-4 text-purple-600">mixed</td>
                                    <td class="p-4 font-sans"><span
                                            class="bg-slate-100 text-slate-600 font-bold text-[10px] px-2 py-0.5 rounded">Optional
                                            (Nullable)</span></td>
                                    <td class="p-4 font-sans text-slate-600">Semua atribut tambahan lainnya bersifat
                                        opsional dan boleh bernilai <code>null</code> atau dikosongkan.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Payload Examples Section -->
                <div id="payload-examples" x-data="{ tab: 'sosmed' }">
                    <h2 class="text-xl font-bold text-slate-900 mb-4">Contoh Request Payload</h2>

                    <div class="bg-slate-900 rounded-xl overflow-hidden shadow-lg">
                        <div class="flex border-b border-slate-800 bg-slate-950 px-4">
                            <button @click="tab = 'sosmed'"
                                :class="tab === 'sosmed' ? 'border-blue-500 text-white' :
                                    'border-transparent text-slate-400 hover:text-slate-200'"
                                class="py-3 px-4 border-b-2 font-medium text-sm transition">Social Media</button>
                            <button @click="tab = 'platform'"
                                :class="tab === 'platform' ? 'border-blue-500 text-white' :
                                    'border-transparent text-slate-400 hover:text-slate-200'"
                                class="py-3 px-4 border-b-2 font-medium text-sm transition">Job Platform</button>
                        </div>

                        <!-- Tab Content: Sosmed -->
                        <div x-show="tab === 'sosmed'" class="p-4">
                            <pre class="text-green-400 text-xs font-mono overflow-x-auto">
[{
  "source_type": "social_media",
  "platform": "Instagram",
  "logo_url": "https://s3.bucket.com/logo.jpg",
  "nama_perusahaan": "PT Teknologi Nusantara",
  "email_perusahaan": "hrd@teknologi.com",
  "alamat_raw": "Jl. Sudirman No 12",
  "provinsi_raw": "DKI Jakarta",
  "gaji_raw": "Rp 5.000.000 - Rp 8.000.000",
  "gaji_min": 5000000,
  "gaji_max": 8000000,
  "posisi": "Backend Developer",
  "ringkasan_ai": "Dibutuhkan laravel dev pengalaman 2 tahun...",
  "jobdesk": "Membuat API, Maintenance database",
  "kualifikasi_jobspek": "Minimal S1 Informatika",
  "keahlian_skill": "Laravel, PostgreSQL, REST API",
  "tipe_pekerjaan": "Fulltime",
  "tanggal_posting": "2026-08-20 10:00:00",
  "batas_pendaftaran": "2026-09-01",
  "no_hp": "081234567890",
  "website_form_url": "https://teknologi.com/career",
  "instagram_dm": "@teknologi_official",
  "cara_melamar": "Kirim email ke hrd@teknologi.com dengan subjek [BE Dev]",
  "kategori_bidang": "IT & Software",
  "sumber_url": "https://instagram.com/p/Cxxxxxxx"
}]</pre>
                        </div>

                        <!-- Tab Content: Job Platform -->
                        <div x-show="tab === 'platform'" class="p-4" x-cloak>
                            <pre class="text-green-400 text-xs font-mono overflow-x-auto">
[{
  "source_type": "job_platform",
  "platform": "JobStreet",
  "posisi": "Frontend Engineer",
  "nama_perusahaan": "PT Kreatif Digital",
  "provinsi_raw": "Jawa Barat",
  "gaji_raw": "Gaji Kompetitif",
  "tanggal_posting": "2 days ago",
  "tipe_pekerjaan": "Contract",
  "kualifikasi_jobspek": "Menguasai Vue.js / React",
  "deskripsi_pekerjaan": "Bertanggung jawab atas UI/UX platform web...",
  "fasilitas": "BPJS, Tunjangan makan",
  "sumber_url": "https://jobstreet.co.id/job/123456"
}]</pre>
                        </div>
                    </div>
                </div>

                <!-- Client Integration Examples -->
                <div id="client-integration" x-data="{ lang: 'curl' }">
                    <h2 class="text-xl font-bold text-slate-900 mb-4">Contoh Integrasi Kode Client</h2>

                    <div class="bg-slate-900 rounded-xl overflow-hidden shadow-lg">
                        <div class="flex border-b border-slate-800 bg-slate-950 px-4 overflow-x-auto">
                            <button @click="lang = 'curl'"
                                :class="lang === 'curl' ? 'border-blue-500 text-white' :
                                    'border-transparent text-slate-400 hover:text-slate-200'"
                                class="py-3 px-4 border-b-2 font-medium text-sm transition">cURL</button>
                            <button @click="lang = 'fetch'"
                                :class="lang === 'fetch' ? 'border-blue-500 text-white' :
                                    'border-transparent text-slate-400 hover:text-slate-200'"
                                class="py-3 px-4 border-b-2 font-medium text-sm transition">Fetch API (JS)</button>
                            <button @click="lang = 'axios'"
                                :class="lang === 'axios' ? 'border-blue-500 text-white' :
                                    'border-transparent text-slate-400 hover:text-slate-200'"
                                class="py-3 px-4 border-b-2 font-medium text-sm transition">Axios (Node.js/JS)</button>
                            <button @click="lang = 'laravel'"
                                :class="lang === 'laravel' ? 'border-blue-500 text-white' :
                                    'border-transparent text-slate-400 hover:text-slate-200'"
                                class="py-3 px-4 border-b-2 font-medium text-sm transition">Laravel HTTP
                                Client</button>
                        </div>

                        <!-- cURL -->
                        <div x-show="lang === 'curl'" class="p-4">
                            <pre class="text-sky-300 text-xs font-mono overflow-x-auto">
curl -X POST "http://domain-anda.com/api/v1/scraper/loker-draft" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "X-Scraper-Api-Key: your_api_key" \
  -d '[{
    "source_type": "social_media",
    "platform": "Instagram",
    "logo_url": "https://s3.bucket.com/logo.jpg",
    "nama_perusahaan": "PT Teknologi Nusantara",
    "email_perusahaan": "hrd@teknologi.com",
    "alamat_raw": "Jl. Sudirman No 12",
    "provinsi_raw": "DKI Jakarta",
    "gaji_raw": "Rp 5.000.000 - Rp 8.000.000",
    "gaji_min": 5000000,
    "gaji_max": 8000000,
    "posisi": "Backend Developer",
    "ringkasan_ai": "Dibutuhkan laravel dev pengalaman 2 tahun...",
    "jobdesk": "Membuat API, Maintenance database",
    "kualifikasi_jobspek": "Minimal S1 Informatika",
    "keahlian_skill": "Laravel, PostgreSQL, REST API",
    "tipe_pekerjaan": "Fulltime",
    "tanggal_posting": "2026-08-20 10:00:00",
    "batas_pendaftaran": "2026-09-01",
    "no_hp": "081234567890",
    "website_form_url": "https://teknologi.com/career",
    "instagram_dm": "@teknologi_official",
    "cara_melamar": "Kirim email ke hrd@teknologi.com dengan subjek [BE Dev]",
    "kategori_bidang": "IT & Software",
    "sumber_url": "https://instagram.com/p/Cxxxxxxx"
  }]'</pre>
                        </div>

                        <!-- Fetch API -->
                        <div x-show="lang === 'fetch'" class="p-4" x-cloak>
                            <pre class="text-sky-300 text-xs font-mono overflow-x-auto">
const payload = [{
  source_type: "social_media",
  platform: "Instagram",
  logo_url: "https://s3.bucket.com/logo.jpg",
  nama_perusahaan: "PT Teknologi Nusantara",
  email_perusahaan: "hrd@teknologi.com",
  alamat_raw: "Jl. Sudirman No 12",
  provinsi_raw: "DKI Jakarta",
  gaji_raw: "Rp 5.000.000 - Rp 8.000.000",
  gaji_min: 5000000,
  gaji_max: 8000000,
  posisi: "Backend Developer",
  ringkasan_ai: "Dibutuhkan laravel dev pengalaman 2 tahun...",
  jobdesk: "Membuat API, Maintenance database",
  kualifikasi_jobspek: "Minimal S1 Informatika",
  keahlian_skill: "Laravel, PostgreSQL, REST API",
  tipe_pekerjaan: "Fulltime",
  tanggal_posting: "2026-08-20 10:00:00",
  batas_pendaftaran: "2026-09-01",
  no_hp: "081234567890",
  website_form_url: "https://teknologi.com/career",
  instagram_dm: "@teknologi_official",
  cara_melamar: "Kirim email ke hrd@teknologi.com dengan subjek [BE Dev]",
  kategori_bidang: "IT & Software",
  sumber_url: "https://instagram.com/p/Cxxxxxxx"
}];

fetch("http://domain-anda.com/api/v1/scraper/loker-draft", {
  method: "POST",
  headers: {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Scraper-Api-Key": "your_api_key"
  },
  body: JSON.stringify(payload)
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error("Error:", error));</pre>
                        </div>

                        <!-- Axios -->
                        <div x-show="lang === 'axios'" class="p-4" x-cloak>
                            <pre class="text-sky-300 text-xs font-mono overflow-x-auto">
const axios = require('axios');

const payload = [{
  source_type: "social_media",
  platform: "Instagram",
  logo_url: "https://s3.bucket.com/logo.jpg",
  nama_perusahaan: "PT Teknologi Nusantara",
  email_perusahaan: "hrd@teknologi.com",
  alamat_raw: "Jl. Sudirman No 12",
  provinsi_raw: "DKI Jakarta",
  gaji_raw: "Rp 5.000.000 - Rp 8.000.000",
  gaji_min: 5000000,
  gaji_max: 8000000,
  posisi: "Backend Developer",
  ringkasan_ai: "Dibutuhkan laravel dev pengalaman 2 tahun...",
  jobdesk: "Membuat API, Maintenance database",
  kualifikasi_jobspek: "Minimal S1 Informatika",
  keahlian_skill: "Laravel, PostgreSQL, REST API",
  tipe_pekerjaan: "Fulltime",
  tanggal_posting: "2026-08-20 10:00:00",
  batas_pendaftaran: "2026-09-01",
  no_hp: "081234567890",
  website_form_url: "https://teknologi.com/career",
  instagram_dm: "@teknologi_official",
  cara_melamar: "Kirim email ke hrd@teknologi.com dengan subjek [BE Dev]",
  kategori_bidang: "IT & Software",
  sumber_url: "https://instagram.com/p/Cxxxxxxx"
}];

axios.post('http://domain-anda.com/api/v1/scraper/loker-draft', payload, {
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'X-Scraper-Api-Key': 'your_api_key'
  }
})
.then(response => {
  console.log(response.data);
})
.catch(error => {
  console.error('Error:', error.response ? error.response.data : error.message);
});</pre>
                        </div>

                        <!-- Laravel Http Client -->
                        <div x-show="lang === 'laravel'" class="p-4" x-cloak>
                            <pre class="text-sky-300 text-xs font-mono overflow-x-auto">
use Illuminate\Support\Facades\Http;

$response = Http::withHeaders([
    'X-Scraper-Api-Key' => 'your_api_key',
    'Accept' => 'application/json',
])->post('http://domain-anda.com/api/v1/scraper/loker-draft', [[
    'source_type' => 'social_media',
    'platform' => 'Instagram',
    'logo_url' => 'https://s3.bucket.com/logo.jpg',
    'nama_perusahaan' => 'PT Teknologi Nusantara',
    'email_perusahaan' => 'hrd@teknologi.com',
    'alamat_raw' => 'Jl. Sudirman No 12',
    'provinsi_raw' => 'DKI Jakarta',
    'gaji_raw' => 'Rp 5.000.000 - Rp 8.000.000',
    'gaji_min' => 5000000,
    'gaji_max' => 8000000,
    'posisi' => 'Backend Developer',
    'ringkasan_ai' => 'Dibutuhkan laravel dev pengalaman 2 tahun...',
    'jobdesk' => 'Membuat API, Maintenance database',
    'kualifikasi_jobspek' => 'Minimal S1 Informatika',
    'keahlian_skill' => 'Laravel, PostgreSQL, REST API',
    'tipe_pekerjaan' => 'Fulltime',
    'tanggal_posting' => '2026-08-20 10:00:00',
    'batas_pendaftaran' => '2026-09-01',
    'no_hp' => '081234567890',
    'website_form_url' => 'https://teknologi.com/career',
    'instagram_dm' => '@teknologi_official',
    'cara_melamar' => 'Kirim email ke hrd@teknologi.com dengan subjek [BE Dev]',
    'kategori_bidang' => 'IT & Software',
    'sumber_url' => 'https://instagram.com/p/Cxxxxxxx',
]]);

if ($response->successful()) {
    $data = $response->json();
    // $data['draft_ids']
}</pre>
                        </div>
                    </div>
                </div>

                <!-- API Response Examples -->
                <div id="response-codes" class="space-y-4">
                    <h2 class="text-xl font-bold text-slate-900">Respon API</h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- 201 Created -->
                        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
                            <div class="flex items-center space-x-2 mb-3">
                                <span class="bg-green-100 text-green-700 font-bold text-xs px-2 py-0.5 rounded">201
                                    Created</span>
                                <span class="text-xs text-slate-500 font-medium">Berhasil disimpan</span>
                            </div>
                            <pre class="bg-slate-900 text-slate-200 p-3 rounded-lg text-xs font-mono overflow-x-auto">
{
  "success": true,
  "message": "1 data draft loker berhasil disimpan.",
  "draft_ids": [1]
}</pre>
                        </div>

                        <!-- 401 Unauthorized -->
                        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
                            <div class="flex items-center space-x-2 mb-3">
                                <span class="bg-amber-100 text-amber-800 font-bold text-xs px-2 py-0.5 rounded">401
                                    Unauthorized</span>
                                <span class="text-xs text-slate-500 font-medium">API Key Salah/Hilang</span>
                            </div>
                            <pre class="bg-slate-900 text-slate-200 p-3 rounded-lg text-xs font-mono overflow-x-auto">
{
  "success": false,
  "message": "Unauthorized. Invalid or missing API Key."
}</pre>
                        </div>

                        <!-- 422 Unprocessable Entity -->
                        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
                            <div class="flex items-center space-x-2 mb-3">
                                <span class="bg-red-100 text-red-700 font-bold text-xs px-2 py-0.5 rounded">422
                                    Validation Error</span>
                                <span class="text-xs text-slate-500 font-medium">Gagal validasi data</span>
                            </div>
                            <pre class="bg-slate-900 text-slate-200 p-3 rounded-lg text-xs font-mono overflow-x-auto">
{
  "success": false,
  "errors": {
    "0.source_type": [
      "The selected source_type is invalid."
    ],
    "0.posisi": [
      "The posisi field is required."
    ]
  }
}</pre>
                        </div>
                    </div>
                </div>

            </section>
        </main>
    </div>

</body>

</html>
