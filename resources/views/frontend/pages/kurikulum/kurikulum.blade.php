@extends('layouts.appfrontend')

@section('content')
<div id="content-area">

	<style>
		.kur-section {
			padding: 80px 120px;
			display: flex;
			align-items: center;
			gap: 60px;
		}

		.kur-section .kur-image {
			flex-shrink: 0;
		}

		.kur-section .kur-image svg {
			width: 281px;
			height: auto;
			display: block;
		}

		.kur-section .kur-content {
			flex: 1;
			min-width: 0;
		}

		.kur-section .kur-title {
			font-size: 30px;
			font-weight: 700;
			color: #1a1a2e;
			margin: 0 0 16px;
			line-height: 1.3;
		}

		.kur-section .kur-subtitle {
			font-size: 20px;
			font-weight: 500;
			color: #4b5563;
			margin: 0;
			line-height: 1.6;
		}

		@media (max-width: 1199.98px) {
			.kur-section {
				padding: 60px 60px;
				gap: 40px;
			}
		}

		@media (max-width: 991.98px) {
			.kur-section {
				padding: 48px 40px;
				flex-direction: column;
				text-align: center;
				gap: 32px;
			}

			.kur-section .kur-title {
				font-size: 26px;
			}

			.kur-section .kur-subtitle {
				font-size: 18px;
			}
		}

		@media (max-width: 575.98px) {
			.kur-section {
				padding: 36px 24px;
				gap: 24px;
			}

			.kur-section .kur-image svg {
				width: 200px;
			}

			.kur-section .kur-title {
				font-size: 22px;
			}

			.kur-section .kur-subtitle {
				font-size: 16px;
			}
		}
	</style>

	<section class="kur-section">
		<div class="kur-image">
			<img src="{{ asset('FE/svgimgkur1.svg') }}" alt="Kurikulum">
		</div>
		<div class="kur-content">
			<h1 class="kur-title">KURIKULUM PENGEMBANGAN SDM (HUMAN CAPITAL DEVELOPMENT PROGRAM)</h1>
			<p class="kur-subtitle">Solusi pengembangan talenta perbankan yang dirancang untuk mencetak profesional unggul, berdaya saing, dan patuh regulasi melalui pemetaan kompetensi yang terukur.</p>
		</div>
	</section>

	<style>
		.kur-grid {
			padding: 10px 120px 80px;
		}

		.kur-grid .kur-grid-inner {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 60px;
		}

		.kur-grid .kur-right {
			border: 1px solid #2B7FFF;
			border-radius: 12px;
			padding: 20px;
		}

		.kur-grid .kur-right-wrap {
			display: flex;
			flex-direction: column;
			gap: 24px;
			max-height: 382px;
			overflow-y: auto;
			scroll-behavior: smooth;
		}

		.kur-grid .kur-right-wrap::-webkit-scrollbar {
			width: 0;
			display: none;
		}

		.kur-grid .kur-right-wrap {
			-ms-overflow-style: none;
			scrollbar-width: none;
		}

		.kur-grid .kur-judul {
			font-size: 28px;
			font-weight: 600;
			color: #2B7FFF;
			margin: 0 0 20px;
			line-height: 2;
		}

		.kur-grid .kur-list {
			list-style: none;
			padding: 0;
			margin: 0;
		}

		.kur-grid .kur-list li {
			font-size: 20px;
			color: #374151;
			padding: -1px 0 18px 0px;
			margin-bottom: 16px;
			line-height: 2.5;
			transition: all 0.3s ease;
		}

		.kur-grid .kur-list li:hover {
			border-left-color: #1a5ccc;
			padding-left: 36px;
		}

		.kur-grid .kur-list li strong {
			font-weight: 700;
			color: #1a1a2e;
		}

		.kur-grid .kur-right-title {
			font-size: 24px;
			font-weight: 500;
			color: #000000;
			margin: 0 0 20px;
			line-height: 1.4;
			display: flex;
			align-items: center;
			gap: 12px;
		}

		.kur-grid .kur-right-title .num-circle {
			width: 36px;
			height: 36px;
			border-radius: 50%;
			background: #2B7FFF;
			color: #fff;
			font-size: 16px;
			font-weight: 700;
			display: flex;
			align-items: center;
			justify-content: center;
			flex-shrink: 0;
		}

		.kur-grid .kur-right-tujuan {
			font-size: 18px;
			color: #374151;
			margin: 0 0 24px;
			line-height: 1.5;
		}

		.kur-grid .kur-right-tujuan strong {
			font-weight: 700;
		}

		.kur-grid .kur-right-subtitle {
			font-size: 18px;
			color: #374151;
			margin: 0 0 12px;
			line-height: 1.1;
		}

		.kur-grid .kur-right-subtitle strong {
			font-weight: 700;
		}

		.kur-grid .kur-right-list {
			list-style: none;
			padding: 0;
			margin: 0 0 24px;
		}

		.kur-grid .kur-right-list li {
			font-size: 18px;
			color: #374151;
			padding: 10px 0 10px 24px;
			position: relative;
			line-height: 1.1;
		}

		.kur-grid .kur-right-list li::before {
			content: '';
			position: absolute;
			left: 0;
			top: 18px;
			width: 8px;
			height: 8px;
			border-radius: 50%;
			/* background: #2B7FFF; */
		}

		@media (max-width: 1199.98px) {
			.kur-grid {
				padding: 48px 60px 60px;
			}

			.kur-grid .kur-grid-inner {
				gap: 40px;
			}
		}

		@media (max-width: 991.98px) {
			.kur-grid {
				padding: 40px 40px 48px;
			}

			.kur-grid .kur-grid-inner {
				grid-template-columns: 1fr;
				gap: 40px;
			}

			.kur-grid .kur-judul {
				font-size: 24px;
			}

			.kur-grid .kur-list li {
				font-size: 18px;
			}

			.kur-grid .kur-right-title {
				font-size: 22px;
			}

			.kur-grid .kur-right-tujuan,
			.kur-grid .kur-right-subtitle,
			.kur-grid .kur-right-list li {
				font-size: 18px;
			}
		}

		@media (max-width: 575.98px) {
			.kur-grid {
				padding: 32px 24px 40px;
			}

			.kur-grid .kur-grid-inner {
				padding: 20px;
			}

			.kur-grid .kur-judul {
				font-size: 20px;
				margin-bottom: 24px;
			}

			.kur-grid .kur-list li {
				font-size: 16px;
				padding: 14px 0 14px 20px;
			}

			.kur-grid .kur-right-title {
				font-size: 18px;
			}

			.kur-grid .kur-right-tujuan,
			.kur-grid .kur-right-subtitle,
			.kur-grid .kur-right-list li {
				font-size: 16px;
			}
		}
	</style>

	<section class="kur-grid">
		<div class="kur-grid-inner">
			<div>
				<h2 class="kur-judul">1. KURIKULUM BERDASARKAN JENJANG KARIER (JALUR LINIER)</h2>
				<ul class="kur-list">
					<li><strong>Tahap 1:</strong> Onboarding &amp; Officer Development Program (ODP / MDP)</li>
					<li><strong>Tahap 2:</strong> Pemantapan Teknis (Staf Senior / Junior Officer)</li>
					<li><strong>Tahap 3:</strong> Kepemimpinan Tingkat Pertama (Supervisor / Team Leader)</li>
					<li><strong>Tahap 4:</strong> Kepemimpinan Strategis (Branch Manager / Division Head / Direksi)</li>
				</ul>
			</div>
			<div class="kur-right-wrap">
				<div class="kur-right">
					<h3 class="kur-right-title"><span class="num-circle">1</span> Tahap 1: Onboarding &amp; Officer Development Program (ODP / MDP)</h3>
					<p class="kur-right-tujuan"><strong>Tujuan:</strong> Membentuk fondasi pemahaman perbankan, budaya kerja, dan kepatuhan dasar bagi karyawan baru.</p>

					<p class="kur-right-subtitle"><strong>Kompetensi Inti (Hard Skills):</strong></p>
					<ul class="kur-right-list">
						<li>1. IInside the Bank: Mengupas Cara Kerja Perusahaan Perbankan dan Struktur Job Desk secara Komprehensif</li>
						<li>2. Mengenali Fungsi Jabatan Dalam Bisnis BPR</li>
						<li>3. Mastering the Banking Industry: Strategi Praktis dan Trik Sukses Membangun Karier Cemerlang Calon Bankir</li>
						<li id="scroll-start">4. Workplace Reality Check: Pahami Fungsi dan Eksekusi Job Desk Perbankan Sebelum Mengirim Lamaran</li>
						<li>5. Banking Career Hacks: Strategi Jitu Persiapan CV, Interview, hingga Tembus Bank Impian</li>
					</ul>

					<p class="kur-right-subtitle"><strong>Kompetensi Perilaku (Soft Skills):</strong></p>
					<ul class="kur-right-list">
						<li>1. The First Line of Defense: Peran Frontliner dalam Mendeteksi dan Mencegah Percobaan Fraud</li>
					</ul>
				</div>
				<div class="kur-right">
					<h3 class="kur-right-title"><span class="num-circle">2</span> Tahap 2: Pemantapan Teknis (Staf Senior / Junior Officer)</h3>
					<p class="kur-right-tujuan"><strong>Tujuan:</strong> Meningkatkan efisiensi kerja, akurasi operasional, dan kemampuan pemecahan masalah secara mandiri.</p>

					<p class="kur-right-subtitle"><strong>Kompetensi Inti (Hard Skills):</strong></p>
					<ul class="kur-right-list">
						<li>1. Smart Reporting: Menguasai Formula Excel untuk Kebutuhan Pelaporan Harian dan Bulanan Bank</li>
						<li>2. Smart Archiving: Mengoptimalkan Alur Kerja Perbankan melalui Sistem Kearsipan Digital</li>
						<li>3. Peningkatan Inovasi Teknologi Sebagai Wujud Nyata Terapan Dalam Efektivitas & Efisiensi Kinerja Bank</li>
					</ul>

					<p class="kur-right-subtitle"><strong>Kompetensi Perilaku (Soft Skills):</strong></p>
					<ul class="kur-right-list">
						<li>1. The Art of Persuasion: Menguasai Public Speaking untuk Mendongkrak Kinerja Perbankan</li>
					</ul>
				</div>
				<div class="kur-right">
					<h3 class="kur-right-title"><span class="num-circle">3</span> Tahap 3: Kepemimpinan Tingkat Pertama (Supervisor / Team Leader)</h3>
					<p class="kur-right-tujuan"><strong>Tujuan:</strong> Mempersiapkan staf teknis untuk mulai memimpin tim kecil dan mengelola performa kerja kelompok.</p>

					<p class="kur-right-subtitle"><strong>Kompetensi Inti (Hard Skills):</strong></p>
					<ul class="kur-right-list">
						<li>1. BPR Performance Excellence: Praktik Integrasi Parameter, KPI, dan OKR secara Komprehensif</li>
						<li>2. Membangun KPI Kualitatif dan Kuantitatif yang Relevan</li>
						<li>3. Workshop Terapan Audit TI: Dari Perencanaan hingga Laporan (Include Kertas Kerja Digital Eksklusif)</li>
					</ul>

					<p class="kur-right-subtitle"><strong>Kompetensi Perilaku (Soft Skills):</strong></p>
					<ul class="kur-right-list">
						<li>1. Human Capital Excellence: Strategi Mengubah Karyawan Biasa Menjadi Penggerak Utama Bisnis Bank</li>
						<li>2. Strategic Talent Acquisition: Seni Menarik, Menilai, dan Mempertahankan SDM Unggul</li>
						<li>3. Dari Regulasi ke Implementasi: Langkah Tepat Merancang Sistem Penggajian Sesuai Aturan Pemerintah</li>
					</ul>
				</div>
				<div class="kur-right">
					<h3 class="kur-right-title"><span class="num-circle">4</span> Tahap 4: Kepemimpinan Strategis (Branch Manager / Division Head / Direksi)</h3>
					<p class="kur-right-tujuan"><strong>Tujuan:</strong> Mengembangkan kemampuan eksekusi strategi bisnis, manajemen portofolio, dan kepemimpinan visioner.</p>

					<p class="kur-right-subtitle"><strong>Kompetensi Inti (Hard Skills):</strong></p>
					<ul class="kur-right-list">
						<li>1. Agile Planning: Menyusun RBB yang Responsif terhadap Dinamika Pasar Digital</li>
						<li>2. Bank Performance Analysis: Membedah Rasio Keuangan (KPMM, NPL, NIM, BOPO, LDR) untuk Menilai Kesehatan Bank</li>
						<li>3. Teropong Industri Perbankan Indonesia 2026–2036: Menavigasi Arah Strategis, Disrupsi Teknologi, dan Model Bisnis Masa Depan</li>
						<li>4. BPR Survival & Growth Strategy 2027–2030: Analisis Komprehensif Perubahan Pola Konsumen dan Solusi Mitigasinya</li>
					</ul>

					<p class="kur-right-subtitle"><strong>Kompetensi Perilaku (Soft Skills):</strong></p>
					<ul class="kur-right-list">
						<li>1. MANAJER DI ERA 4.0</li>
						<li>2. HR Analytics Workshop: Teknik Komprehensif Melakukan Workload Analysis (WLA) yang Efektif</li>
						<li>3. Peran Human Resources Business Partner (HRBP) untuk Kelangsungan Bisnis Perbankan</li>
					</ul>
				</div>
			</div>
		</div>
	</section>
	<section class="kur-grid">
		<div class="kur-grid-inner">
			<div class="kur-right-wrap">
				<div class="kur-right">
					<h3 class="kur-right-title"><span class="num-circle">1</span> Direktorat Bisnis, Pemasaran, & Kredit (Sales, AO, RM, Marketing)</h3>

					<p class="kur-right-subtitle"><strong>Analisis Kredit & Penanganan NPL:</strong></p>
					<ul class="kur-right-list">
						<li>1. Sharp Credit Analysis: Mengintegrasikan Analisis Kualitatif dan Kuantitatif untuk Pengambilan Keputusan Kredit yang Pruden dan Berkualitas</li>
						<li>2. Credit Risk Defense: Strategi Hulu ke Hilir dalam Mencegah dan Menangani Kredit Bermasalah</li>
						<li>3. NPL Recovery Strategy: Analisis Presisi Kelayakan Debitur untuk Program 3R (Restrukturisasi, Rescheduling, Reconditioning)</li>
						<li>4. The Recovery Blueprint: Teknik Akselerasi Penurunan NPL Melalui Penagihan dan Penyelamatan Efektif</li>
						<li>5. Tingkat Kredit dengan 2 layanan baru (dilengkapi dengan S.W.O.T Analisa)</li>
					</ul>

					<p class="kur-right-subtitle"><strong>Strategi Pemasaran & Ekosistem Bisnis:</strong></p>
					<ul class="kur-right-list">
						<li>1. Strategi Pemasaran Terintegrasi: Menjembatani Digital Marketing dan Konvensional untuk Mendominasi Pasar</li>
						<li>2. Marketing & CRM Essentials: Trik Jitu mendekatkan Pelanggan dari Pondasi Dasar hingga Retensi</li>
						<li>3. Winning the Customer's Heart: Panduan Praktis Marketing & CRM di Era Perbankan Modern</li>
						<li>4. Membangun Ekosistem UKM BPR sebagai Fundamental Revolusi 2023</li>
						<li>5. Revolusi Pasar Mikro: Mengamankan Portofolio BPR Melalui Ekosistem UMKM yang Terintegrasi</li>
					</ul>

					<p class="kur-right-subtitle"><strong>Digital Marketing & Prospektif Data:</strong></p>
					<ul class="kur-right-list">
						<li>1. Digital Marketing: Hadirkan Jutaan Visitor Website dan Konversi Menjadi Nasabah BPR</li>
						<li>2. SEO Mastery untuk BPR: Strategi Mendatangkan Trafik Organik Berkualitas Tinggi</li>
						<li>3. Smart Banking Prospecting: Pemanfaatan Komprehensif Web Scraping, Big Data, dan AI untuk Pertumbuhan Nasabah Bank</li>
					</ul>
				</div>
				<div class="kur-right">
					<h3 class="kur-right-title"><span class="num-circle">2</span> Direktorat Operasional, Teknologi Informasi, & Layanan (IT & Operations)</h3>

					<p class="kur-right-subtitle"><strong>Otomasi & Penerapan Teknologi Terkini:</strong></p>
					<ul class="kur-right-list">
						<li>1. Automasi Layanan Perbankan: Memaksimalkan Peran Artificial Intelligence (AI) untuk CS Digital yang Responsif & Efisien</li>
						<li>2. IT-Driven Excellence: Menjadikan Teknologi sebagai Motor Penggerak Pemasaran, Efisiensi Operasi, dan Keamanan Bisnis</li>
						<li>3. Implementasi Sistem Scoring Fintech ke BPR melalui Smart Scoring</li>
					</ul>

					<p class="kur-right-subtitle"><strong>Tata Kelola TI:</strong></p>
					<ul class="kur-right-list">
						<li>1. Tata Kelola & Audit SPTI Perbankan: Implementasi Praktis POJK 75/2016 dan SEOJK 15/2017</li>
					</ul>
				</div>
				<div class="kur-right">
					<h3 class="kur-right-title"><span class="num-circle">3</span> Direktorat Manajemen Risiko, Kepatuhan, Akuntansi, & Audit (Risk, Compliance, Auditor)</h3>

					<p class="kur-right-subtitle"><strong>Kepatuhan Regulasi & Aturan Hukum:</strong></p>
					<ul class="kur-right-list">
						<li>1. Kupas Tuntas UU P2SK No 4/2023: Implikasi Hukum, Mitigasi Risiko, dan Langkah Strategis Perbankan</li>
						<li>2. Sustainable Banking & UMKM Growth: Panduan Komprehensif Kesiapan Industri Keuangan Menghadapi POJK 19/2025</li>
						<li>3. Kepatuhan & Strategi UU PDP di Sektor Perbankan: Panduan Komprehensif Perlindungan Data Nasabah</li>
						<li>4. Sinergi Strategis Regulasi Akuntansi Bank: Mengelola Transparansi & Akurasi Sesuai PP 43/2025 dan POJK 15/2024</li>
						<li>5. Dari Ide Menjadi Realita: Sukses Mengembangkan & Meluncurkan Produk BPR (Kupas Tuntas SEOJK 8/2022)</li>
					</ul>

					<p class="kur-right-subtitle"><strong>Mitigasi Risiko & Anti-Fraud:</strong></p>
					<ul class="kur-right-list">
						<li>1. Management Risiko Fintech bagi BPR</li>
						<li>2. Sinergi Anti-Fraud BPR: Panduan Komprehensif Mitigasi Risiko, Deteksi Dini, dan Penguatan Tata Kelola</li>
						<li>3. Benteng Integritas Perbankan: Strategi Mitigasi Risiko dan Pencegahan Fraud Melalui Implementasi GCG</li>
						<li>4. Risk Governance Excellence: Membangun Budaya Risiko untuk Keberlanjutan Bisnis Bank</li>
						<li>5. Applied Bank Risk Management: Teknik Identifikasi, Pengukuran, dan Pemantauan Risiko secara Praktis</li>
					</ul>
				</div>
			</div>
			<div>
				<h2 class="kur-judul">2. KURIKULUM SPESIFIK BERDASARKAN FUNGSI KERJA (SPESIALISASI)</h2>
				<ul class="kur-list">
					<li><strong>Tahap 1:</strong> Direktorat Bisnis, Pemasaran, & Kredit (Sales, AO, RM, Marketing)</li>
					<li><strong>Tahap 2:</strong> Direktorat Operasional, Teknologi Informasi, & Layanan (IT & Operations)</li>
					<li><strong>Tahap 3:</strong> Direktorat Manajemen Risiko, Kepatuhan, Akuntansi, & Audit (Risk, Compliance, Auditor)</li>
				</ul>
			</div>
		</div>
	</section>

	<style>
		.kur-metode {
			padding: 10px 120px 60px;
		}

		.kur-metode-inner {
			text-align: center;
		}

		.kur-metode-title {
			font-size: 28px;
			font-weight: 700;
			color: #2B7FFF;
			margin: 0 0 16px;
			line-height: 1.3;
		}

		.kur-metode-sub {
			font-size: 18px;
			font-weight: 400;
			color: #4b5563;
			margin: 0 auto;
			line-height: 1.6;
			max-width: 800px;
		}

		@media (max-width: 1199.98px) {
			.kur-metode {
				padding: 10px 60px 48px;
			}
		}

		@media (max-width: 991.98px) {
			.kur-metode {
				padding: 10px 40px 40px;
			}

			.kur-metode-title {
				font-size: 24px;
			}

			.kur-metode-sub {
				font-size: 16px;
			}
		}

		@media (max-width: 575.98px) {
			.kur-metode {
				padding: 10px 24px 32px;
			}

			.kur-metode-title {
				font-size: 20px;
			}

			.kur-metode-sub {
				font-size: 15px;
			}
		}

		.kur-metode-cards {
			display: flex;
			justify-content: space-evenly;
			gap: 40px;
			margin-top: 48px;
			flex-wrap: wrap;
		}

		.kur-metode-card {
			width: 455px;
			height: 412px;
			border-radius: 12px;
			padding: 40px;
			background: #fff;
			box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
			flex-shrink: 0;
			text-align: left;
			display: flex;
			flex-direction: column;
			justify-content: flex-start;
		}

		.kur-metode-card-icon {
			width: 56px;
			height: 56px;
			border-radius: 50%;
			background: #2B7FFF;
			display: flex;
			align-items: center;
			justify-content: center;
			margin-bottom: 20px;
			flex-shrink: 0;
		}

		.kur-metode-card-icon svg {
			width: 28px;
			height: 28px;
		}

		.kur-metode-card-title {
			font-size: 24px;
			font-weight: 500;
			color: #000000;
			margin: 0 0 16px;
			line-height: 1.3;
		}

		.kur-metode-card-desc {
			font-size: 20px;
			font-weight: 400;
			color: #4b5563;
			margin: 0;
			line-height: 1.6;
		}

		@media (max-width: 1199.98px) {
			.kur-metode-cards {
				gap: 24px;
			}
		}

		@media (max-width: 767.98px) {
			.kur-metode-card {
				width: 100%;
				height: auto;
				min-height: 420px;
			}
		}
	</style>

	<section class="kur-metode">
		<div class="kur-metode-inner">
			<h2 class="kur-metode-title">METODE PEMBELAJARAN (LEARNING DELIVERY METHOD)</h2>
			<p class="kur-metode-sub">Untuk memastikan kurikulum berjalan efektif dan efisien dari segi investasi, kami mengadopsi pilar pembelajaran komprehensif 70:20:10</p>

			<div class="kur-metode-cards">
				<div class="kur-metode-card">
					<div class="kur-metode-card-icon">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
							<polyline points="22 4 12 14.01 9 11.01" />
						</svg>
					</div>
					<h3 class="kur-metode-card-title">70% Experiential Learning (Praktik Lapangan)</h3>
					<p class="kur-metode-card-desc">Implementasi langsung program melalui studi kasus operasional perbankan harian, On the Job Training (OJT), dan penugasan proyek khusus.</p>
				</div>
				<div class="kur-metode-card">
					<div class="kur-metode-card-icon">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
							<circle cx="9" cy="7" r="4" />
							<path d="M23 21v-2a4 4 0 0 0-3-3.87" />
							<path d="M16 3.13a4 4 0 0 1 0 7.75" />
						</svg>
					</div>
					<h3 class="kur-metode-card-title">20% Social Learning (Belajar Mandiri & Kolaborasi)</h3>
					<p class="kur-metode-card-desc">Forum berbagi pengetahuan, diskusi peer-to-peer, serta mentoring berbasis pengalaman riil di industri.</p>
				</div>
				<div class="kur-metode-card">
					<div class="kur-metode-card-icon">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
							<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
							<path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
						</svg>
					</div>
					<h3 class="kur-metode-card-title">10% Formal Learning (Kelas Resmi Bankir Academy)</h3>
					<p class="kur-metode-card-desc">Pelatihan terstruktur melalui 3 opsi model pembelajaran fleksibel:
						<br>
						📹 Video Learning
						<br>
						💻 Live Webinar
						<br>
						🏢 In-House Training (IHT)
					</p>
				</div>
			</div>

		</div>

	</section>

	<style>
		.kur-eval {
			padding: 10px 120px 80px;
		}

		.kur-eval-inner {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 60px;
		}

		.kur-eval-title {
			font-size: 28px;
			font-weight: 600;
			color: #000000;
			margin: 0 0 20px;
			line-height: 1.3;
		}

		.kur-eval-sub {
			font-size: 18px;
			font-weight: 400;
			color: #4b5563;
			margin: 0 0 32px;
			line-height: 1.6;
		}

		.kur-eval-list {
			list-style: none;
			padding: 0;
			margin: 0;
		}

		.kur-eval-list li {
			display: flex;
			align-items: flex-start;
			gap: 16px;
			font-size: 18px;
			color: #374151;
			line-height: 1.5;
			margin-bottom: 20px;
		}

		.kur-eval-list li .num {
			width: 36px;
			height: 36px;
			border-radius: 50%;
			background: #2B7FFF;
			color: #fff;
			font-size: 16px;
			font-weight: 700;
			display: flex;
			align-items: center;
			justify-content: center;
			flex-shrink: 0;
			margin-top: 2px;
		}

		.kur-eval-list li .eval-text {
			flex: 1;
			min-width: 0;
		}

		.kur-eval-list li .eval-text strong {
			display: block;
			margin-bottom: 6px;
		}

		.kur-eval-list li .eval-desc {
			display: block;
			font-weight: 400;
			color: #4b5563;
			line-height: 1.6;
		}

		.kur-eval-image {
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.kur-eval-image img {
			max-width: 100%;
			height: auto;
			max-height: 580px;
			width: auto;
		}

		@media (max-width: 1199.98px) {
			.kur-eval {
				padding: 10px 60px 60px;
			}
		}

		@media (max-width: 991.98px) {
			.kur-eval {
				padding: 10px 40px 48px;
			}

			.kur-eval-inner {
				grid-template-columns: 1fr;
				gap: 0;
			}

			.kur-eval-title {
				font-size: 24px;
			}

			.kur-eval-sub {
				font-size: 16px;
			}

			.kur-eval-list li {
				font-size: 16px;
			}
		}

		@media (max-width: 575.98px) {
			.kur-eval {
				padding: 10px 24px 40px;
			}

			.kur-eval-title {
				font-size: 20px;
			}

			.kur-eval-sub {
				font-size: 15px;
			}

			.kur-eval-list li {
				font-size: 15px;
			}
		}
	</style>

	<section class="kur-eval">
		<div class="kur-eval-inner">
			<div>
				<h2 class="kur-eval-title">EVALUASI KEBERHASILAN PELATIHAN (KIRKPATRICK MODEL)</h2>
				<p class="kur-eval-sub">Setiap program pelatihan di Bankir Academy dipantau menggunakan 4 tingkatan evaluasi untuk menjamin hasil yang optimal:</p>

				<ul class="kur-eval-list">
					<li><span class="num">1</span>
						<div class="eval-text"><strong>Reaction</strong><span class="eval-desc">Mengukur kepuasan dan respons peserta terhadap materi, instruktur tersertifikasi BNSP, dan kenyamanan metode pembelajaran.</span></div>
					</li>
					<li><span class="num">2</span>
						<div class="eval-text"><strong>Learning</strong><span class="eval-desc">Mengukur peningkatan pemahaman dan pengetahuan peserta melalui sistem Pre-test dan Post-test.</span></div>
					</li>
					<li><span class="num">3</span>
						<div class="eval-text"><strong>Behavior</strong><span class="eval-desc">Memantau perubahan perilaku dan implementasi keahlian baru peserta saat kembali bertugas di unit kerja masing-masing.</span></div>
					</li>
					<li><span class="num">4</span>
						<div class="eval-text"><strong>Result</strong><span class="eval-desc">Mengukur dampak nyata pelatihan terhadap efisiensi dan target bisnis bank.</span></div>
					</li>
				</ul>
			</div>
			<div class="kur-eval-image">
				<img src="{{ asset('FE/svgkur2.svg') }}" alt="Evaluasi">
			</div>
		</div>
	</section>
</div>