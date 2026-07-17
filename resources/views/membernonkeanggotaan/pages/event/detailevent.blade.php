@extends('layouts.appmembernonanggota')

@section('title', $class->title ?? 'Detail Kelas')

@section('content')
@php
	$levels = [
		1 => 'Pemula',
		2 => 'Menengah',
		3 => 'Lanjutan',
	];

	$title = data_get($class, 'title', 'Detail Kelas');
	$level = $levels[(int) data_get($class, 'level')] ?? 'Semua Level';
	$category = data_get($class, 'category') ?: 'Kelas Bankir';
	$mode = [
		0 => 'Online',
		1 => 'Offline',
	][(int) data_get($class, 'kategori')] ?? 'Kelas';
	$startDate = data_get($class, 'date_start');
	$endDate = data_get($class, 'date_end');
	$isIht = (int) data_get($class, 'iht') === 1;
	$courseTime = data_get($class, 'jam_acara');
	$courseTimeLabel = $courseTime ? \Carbon\Carbon::parse($courseTime)->format('H:i') . ' WIB' : 'Menyesuaikan';
	$location = data_get($class, 'lokasi');
	$participantLimit = data_get($class, 'participant_limit');
	$pricing = data_get($class, 'pricing');
	$isPriceComingSoon = ! $pricing || (int) data_get($pricing, 'gratis', 0) === 1;
	$price = (int) data_get($pricing, 'price', 0);
	$promoPrice = (int) data_get($pricing, 'promo_price', 0);
	$finalPrice = max(0, $price - $promoPrice);
	$priceLabel = $isPriceComingSoon
		? 'Price Coming Soon'
		: ($finalPrice > 0 ? 'Rp ' . number_format($finalPrice, 0, ',', '.') : 'Gratis');
	$image = data_get($class, 'image_mobile') ?: data_get($class, 'image');
	$image = $image ?: asset('assets/img/90x90.jpg');
	$instructors = collect(data_get($class, 'instructor_list', []));
	$events = collect(data_get($class, 'event_list', []));
	$jenis = collect(json_decode((string) data_get($class, 'jenis'), true) ?: [])
		->map(fn($value) => ucwords(strtolower(str_replace(['_', '-'], ' ', $value))))
		->implode(', ');
	$plainDescription = trim(strip_tags((string) data_get($class, 'content', '')));
	$locationLabel = $mode === 'Online' ? 'Online Meeting' : ($location ?: 'Lokasi menyusul');
	$shortMonths = [
		1 => 'Jan',
		2 => 'Feb',
		3 => 'Mar',
		4 => 'Apr',
		5 => 'Mei',
		6 => 'Jun',
		7 => 'Jul',
		8 => 'Agu',
		9 => 'Sept',
		10 => 'Okt',
		11 => 'Nov',
		12 => 'Des',
	];
	$formatCourseDate = function ($date, bool $withYear = true) use ($shortMonths) {
		$date = \Carbon\Carbon::parse($date);

		return $date->format('j') . ' ' . $shortMonths[(int) $date->format('n')] . ($withYear ? ' ' . $date->format('Y') : '');
	};
	$formattedDate = 'Fleksibel';
	$courseStatus = 'Upcoming';
	$courseStatusClass = 'upcoming';
	$today = now()->startOfDay();
	$registrationStart = $startDate ? \Carbon\Carbon::parse($startDate)->startOfDay() : null;
	$registrationEnd = $endDate
		? \Carbon\Carbon::parse($endDate)->endOfDay()
		: ($registrationStart ? $registrationStart->copy()->endOfDay() : null);

	if ($startDate && $endDate) {
		$start = $registrationStart->copy();
		$end = $registrationEnd->copy();
		$formattedDate = $start->isSameMonth($end) && $start->isSameYear($end)
			? $formatCourseDate($start, false) . ' - ' . $formatCourseDate($end)
			: $formatCourseDate($start, ! $start->isSameYear($end)) . ' - ' . $formatCourseDate($end);
	} elseif ($startDate) {
		$formattedDate = $formatCourseDate($startDate);
	}

	if ($registrationEnd && $today->greaterThan($registrationEnd)) {
		$courseStatus = 'Completed';
		$courseStatusClass = 'completed';
	} elseif ($registrationStart && $registrationEnd && $today->betweenIncluded($registrationStart, $registrationEnd)) {
		$courseStatus = 'Running';
		$courseStatusClass = 'running';
	}

	if ($isIht && $courseStatusClass === 'upcoming') {
		$courseStatus = 'IHT';
		$courseStatusClass = 'iht';
		$formattedDate = 'Hubungi Tim Kami';
	}

	$isIhtOrderable = $isIht;
	$canRegister = $courseStatusClass === 'running' && ! $isPriceComingSoon;
	$registrationAlert = [
		'upcoming' => [
			'icon' => 'info',
			'title' => 'Kelas masih upcoming',
			'text' => 'Kelas ini belum dapat diorder karena periode pendaftaran belum berjalan.',
		],
		'completed' => [
			'icon' => 'warning',
			'title' => 'Pendaftaran sudah ditutup',
			'text' => 'Pendaftaran kelas ini sudah ditutup karena periode pendaftaran telah berakhir.',
		],
		'iht' => [
			'icon' => 'info',
			'title' => 'Kelas IHT',
			'text' => 'Silakan hubungi tim Bankir Academy untuk informasi pendaftaran kelas IHT.',
		],
	][$courseStatusClass] ?? null;

	if ($isPriceComingSoon) {
		$registrationAlert = [
			'icon' => 'info',
			'title' => 'Price Coming Soon',
			'text' => 'Harga kelas ini belum tersedia. Silakan cek kembali nanti atau hubungi tim Bankir Academy.',
		];
	}
@endphp

<style>
	.event-detail-v2 {
		display: flex;
		flex-direction: column;
		gap: 24px;
	}

	.event-hero-v2 {
		position: relative;
		overflow: hidden;
		border-radius: 32px;
		background: #0f172a;
		color: #ffffff;
		box-shadow: 0 24px 70px rgba(15, 23, 42, .22);
	}

	.event-hero-v2::before {
		content: "";
		position: absolute;
		inset: 0;
		background:
			radial-gradient(circle at 18% 18%, rgba(79, 70, 229, .52), transparent 30%),
			radial-gradient(circle at 82% 28%, rgba(6, 182, 212, .34), transparent 28%),
			linear-gradient(135deg, rgba(15, 23, 42, .95), rgba(49, 46, 129, .9));
	}

	.event-hero-v2::after {
		content: "";
		position: absolute;
		inset: 0;
		background-image:
			linear-gradient(rgba(255, 255, 255, .055) 1px, transparent 1px),
			linear-gradient(90deg, rgba(255, 255, 255, .055) 1px, transparent 1px);
		background-size: 42px 42px;
		mask-image: linear-gradient(90deg, #000, transparent 92%);
		pointer-events: none;
	}

	.event-hero-v2__inner {
		position: relative;
		z-index: 1;
		display: grid;
		grid-template-columns: minmax(0, 1fr) minmax(320px, 420px);
		gap: 28px;
		padding: 30px;
		align-items: stretch;
	}

	.event-hero-v2__content {
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		min-height: 420px;
	}

	.event-back-link {
		display: inline-flex;
		align-items: center;
		gap: 8px;
		min-height: 40px;
		color: rgba(255, 255, 255, .82);
		font-size: 13px;
		font-weight: 850;
	}

	.event-back-link:hover {
		color: #ffffff;
	}

	.event-eyebrow-row {
		display: flex;
		flex-wrap: wrap;
		gap: 10px;
		margin: 22px 0 18px;
	}

	.event-pill {
		display: inline-flex;
		align-items: center;
		min-height: 32px;
		padding: 7px 12px;
		border: 1px solid rgba(255, 255, 255, .16);
		border-radius: 999px;
		background: rgba(255, 255, 255, .12);
		color: rgba(255, 255, 255, .92);
		font-size: 12px;
		font-weight: 900;
		line-height: 1;
		backdrop-filter: blur(12px);
	}

	.event-pill--running {
		border-color: rgba(34, 197, 94, .28);
		background: rgba(220, 252, 231, .94);
		color: #166534;
	}

	.event-pill--upcoming {
		border-color: rgba(251, 146, 60, .3);
		background: rgba(255, 247, 237, .94);
		color: #c2410c;
	}

	.event-pill--completed {
		border-color: rgba(107, 114, 128, .32);
		background: rgba(229, 231, 235, .94);
		color: #4b5563;
	}

	.event-pill--iht {
		border-color: rgba(79, 70, 229, .32);
		background: rgba(238, 240, 254, .94);
		color: #4f46e5;
	}

	.event-title-v2 {
		max-width: 820px;
		margin: 0;
		font-size: clamp(32px, 4.6vw, 58px);
		font-weight: 950;
		letter-spacing: -.06em;
		line-height: .98;
	}

	.event-summary-v2 {
		max-width: 700px;
		margin: 18px 0 0;
		color: rgba(255, 255, 255, .76);
		font-size: 15.5px;
		line-height: 1.75;
	}

	.event-hero-stats {
		display: grid;
		grid-template-columns: repeat(4, minmax(0, 1fr));
		gap: 10px;
		margin-top: 28px;
	}

	.event-stat-card {
		min-height: 86px;
		padding: 13px;
		border: 1px solid rgba(255, 255, 255, .14);
		border-radius: 18px;
		background: rgba(255, 255, 255, .1);
		backdrop-filter: blur(14px);
	}

	.event-stat-card__label {
		display: block;
		margin-bottom: 7px;
		color: rgba(255, 255, 255, .58);
		font-size: 11px;
		font-weight: 900;
		letter-spacing: .06em;
		text-transform: uppercase;
	}

	.event-stat-card__value {
		display: block;
		color: #ffffff;
		font-size: 14px;
		font-weight: 900;
		line-height: 1.35;
		overflow-wrap: break-word;
	}

	.event-hero-visual {
		display: grid;
		grid-template-rows: minmax(260px, 1fr) auto;
		gap: 14px;
	}

	.event-cover-card {
		position: relative;
		border-radius: 24px;
		overflow: hidden;
		background: rgba(255, 255, 255, .08);
		box-shadow: 0 24px 54px rgba(15, 23, 42, .32);
	}

	.event-cover-card img {
		width: 100%;
		height: 100%;
		min-height: 300px;
		display: block;
		object-fit: cover;
	}

	.event-cover-card__shade {
		position: absolute;
		inset: 0;
		background: linear-gradient(180deg, transparent 46%, rgba(15, 23, 42, .72));
	}

	.event-price-strip {
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 16px;
		padding: 16px;
		border: 1px solid rgba(255, 255, 255, .14);
		border-radius: 22px;
		background: rgba(255, 255, 255, .12);
		backdrop-filter: blur(14px);
	}

	.event-price-label {
		display: block;
		color: rgba(255, 255, 255, .58);
		font-size: 11px;
		font-weight: 900;
		letter-spacing: .06em;
		text-transform: uppercase;
	}

	.event-price-value {
		display: block;
		margin-top: 2px;
		color: #ffffff;
		font-size: 26px;
		font-weight: 950;
		letter-spacing: -.04em;
	}

	.event-price-original {
		display: block;
		color: rgba(255, 255, 255, .55);
		font-size: 12px;
		font-weight: 800;
		text-decoration: line-through;
	}

	.event-primary-cta {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		min-height: 46px;
		padding: 12px 18px;
		border: 0;
		border-radius: 999px;
		background: #ffffff;
		color: #312e81;
		font-size: 13px;
		font-weight: 950;
		white-space: nowrap;
		cursor: pointer;
		box-shadow: 0 16px 28px rgba(15, 23, 42, .24);
		transition: transform .18s ease, box-shadow .18s ease;
	}

	.event-primary-cta:hover {
		color: #312e81;
		transform: translateY(-1px);
		box-shadow: 0 20px 34px rgba(15, 23, 42, .3);
	}

	.event-body-layout {
		display: grid;
		grid-template-columns: minmax(0, 1fr) 360px;
		gap: 22px;
		align-items: start;
	}

	.event-content-stack {
		display: grid;
		gap: 18px;
		min-width: 0;
	}

	.event-panel {
		border: 1px solid #e7e9f0;
		border-radius: 24px;
		background: #ffffff;
		box-shadow: 0 12px 34px rgba(15, 23, 42, .045);
		overflow: hidden;
	}

	.event-panel__body {
		padding: 24px;
	}

	.event-section-kicker {
		display: inline-flex;
		margin-bottom: 10px;
		color: var(--primary, #4F46E5);
		font-size: 11px;
		font-weight: 950;
		letter-spacing: .08em;
		text-transform: uppercase;
	}

	.event-section-title {
		margin: 0 0 14px;
		color: #111827;
		font-size: 24px;
		font-weight: 950;
		letter-spacing: -.045em;
		line-height: 1.12;
	}

	.event-description {
		color: #4b5563;
		font-size: 15px;
		line-height: 1.85;
	}

	.event-description p:last-child {
		margin-bottom: 0;
	}

	.event-highlight-grid {
		display: grid;
		grid-template-columns: repeat(2, minmax(0, 1fr));
		gap: 12px;
	}

	.event-highlight-card {
		padding: 16px;
		border: 1px solid #eef2f7;
		border-radius: 18px;
		background: linear-gradient(180deg, #ffffff, #f9fafb);
	}

	.event-highlight-card__label {
		display: block;
		margin-bottom: 6px;
		color: #9ca3af;
		font-size: 11px;
		font-weight: 950;
		letter-spacing: .06em;
		text-transform: uppercase;
	}

	.event-highlight-card__value {
		display: block;
		color: #111827;
		font-size: 15px;
		font-weight: 900;
		line-height: 1.45;
		overflow-wrap: break-word;
	}

	.event-agenda-list {
		display: grid;
		gap: 12px;
		counter-reset: agenda;
	}

	.event-agenda-item {
		position: relative;
		display: grid;
		grid-template-columns: 42px minmax(0, 1fr);
		gap: 12px;
		padding: 16px;
		border: 1px solid #eef2f7;
		border-radius: 18px;
		background: #ffffff;
	}

	.event-agenda-item::before {
		counter-increment: agenda;
		content: counter(agenda, decimal-leading-zero);
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 42px;
		height: 42px;
		border-radius: 14px;
		background: var(--primary-soft, #EEF0FE);
		color: var(--primary, #4F46E5);
		font-size: 13px;
		font-weight: 950;
	}

	.event-agenda-text {
		margin: 0;
		color: #374151;
		font-size: 14px;
		font-weight: 750;
		line-height: 1.65;
	}

	.event-instructor-grid {
		display: grid;
		grid-template-columns: repeat(2, minmax(0, 1fr));
		gap: 12px;
	}

	.event-instructor-card {
		display: flex;
		align-items: center;
		gap: 13px;
		padding: 14px;
		border: 1px solid #eef2f7;
		border-radius: 18px;
		background: #ffffff;
	}

	.event-instructor-avatar {
		width: 54px;
		height: 54px;
		border-radius: 18px;
		object-fit: cover;
		background: #eef2f7;
		box-shadow: 0 10px 18px rgba(15, 23, 42, .08);
		flex: 0 0 auto;
	}

	.event-instructor-name {
		margin: 0;
		color: #111827;
		font-size: 14px;
		font-weight: 950;
		line-height: 1.25;
	}

	.event-instructor-title {
		margin: 4px 0 0;
		color: #6b7280;
		font-size: 12.5px;
		font-weight: 700;
		line-height: 1.45;
	}

	.event-side-stack {
		position: sticky;
		top: calc(var(--topbar-h, 68px) + 18px);
		display: grid;
		gap: 16px;
	}

	.event-register-card {
		padding: 18px;
		border-radius: 24px;
		background: #111827;
		color: #ffffff;
		box-shadow: 0 18px 46px rgba(15, 23, 42, .18);
	}

	.event-register-card__label {
		display: block;
		color: rgba(255, 255, 255, .58);
		font-size: 11px;
		font-weight: 950;
		letter-spacing: .07em;
		text-transform: uppercase;
	}

	.event-register-card__price {
		display: block;
		margin-top: 4px;
		font-size: 32px;
		font-weight: 950;
		letter-spacing: -.05em;
		line-height: 1;
	}

	.event-register-card__original {
		display: block;
		margin-top: 5px;
		color: rgba(255, 255, 255, .52);
		font-size: 13px;
		font-weight: 800;
		text-decoration: line-through;
	}

	.event-register-button {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 100%;
		min-height: 48px;
		margin-top: 18px;
		border: 0;
		border-radius: 999px;
		background: #ffffff;
		color: #111827;
		font-size: 14px;
		font-weight: 950;
		cursor: pointer;
		box-shadow: 0 14px 28px rgba(0, 0, 0, .2);
	}

	.event-register-button:hover {
		color: #111827;
	}

	.event-register-note {
		margin: 13px 0 0;
		color: rgba(255, 255, 255, .68);
		font-size: 12.5px;
		line-height: 1.65;
	}

	.event-related-list {
		display: grid;
		gap: 10px;
	}

	.event-related-link {
		display: block;
		padding: 13px;
		border: 1px solid #eef2f7;
		border-radius: 16px;
		color: #111827;
		font-size: 13px;
		font-weight: 900;
		line-height: 1.45;
	}

	.event-related-link:hover {
		border-color: rgba(79, 70, 229, .3);
		color: var(--primary, #4F46E5);
	}

	@media (max-width: 1199.98px) {
		.event-hero-v2__inner,
		.event-body-layout {
			grid-template-columns: 1fr;
		}

		.event-hero-v2__content {
			min-height: auto;
		}

		.event-side-stack {
			position: static;
		}
	}

	@media (max-width: 767.98px) {
		.event-hero-v2 {
			border-radius: 24px;
		}

		.event-hero-v2__inner {
			padding: 20px;
			gap: 20px;
		}

		.event-hero-stats,
		.event-highlight-grid,
		.event-instructor-grid {
			grid-template-columns: 1fr;
		}

		.event-cover-card img {
			min-height: 220px;
		}

		.event-price-strip {
			align-items: stretch;
			flex-direction: column;
		}

		.event-primary-cta {
			width: 100%;
		}

		.event-panel__body {
			padding: 18px;
		}
	}

	@media (prefers-reduced-motion: reduce) {
		.event-detail-v2 * {
			transition: none !important;
		}
	}
</style>

<div class="event-detail-v2">
	<section class="event-hero-v2" aria-labelledby="event-title">
		<div class="event-hero-v2__inner">
			<div class="event-hero-v2__content">
				<div>
					<a href="{{ url('/event-kelas') }}" class="event-back-link">&larr; Kembali ke daftar kelas</a>

					<div class="event-eyebrow-row">
						<span class="event-pill">{{ $category }}</span>
						<span class="event-pill">{{ $mode }}</span>
						<span class="event-pill">{{ $level }}</span>
						<span class="event-pill event-pill--{{ $courseStatusClass }}">{{ $courseStatus }}</span>
						@if($jenis !== '')
						<span class="event-pill">{{ $jenis }}</span>
						@endif
					</div>

					<h1 class="event-title-v2" id="event-title">{{ $title }}</h1>
					<p class="event-summary-v2">
						{{ $plainDescription !== '' ? \Illuminate\Support\Str::limit($plainDescription, 190) : 'Pelajari kompetensi perbankan melalui kelas terstruktur bersama Bankir Academy.' }}
					</p>
				</div>

				<div class="event-hero-stats" aria-label="Ringkasan kelas">
					<div class="event-stat-card">
						<span class="event-stat-card__label">Pendaftaran</span>
						<span class="event-stat-card__value">{{ $formattedDate }}</span>
					</div>
					<div class="event-stat-card">
						<span class="event-stat-card__label">Waktu</span>
						<span class="event-stat-card__value">{{ $courseTimeLabel }}</span>
					</div>
					<div class="event-stat-card">
						<span class="event-stat-card__label">Kuota</span>
						<span class="event-stat-card__value">{{ $participantLimit ? $participantLimit . ' peserta' : 'Terbatas' }}</span>
					</div>
					<div class="event-stat-card">
						<span class="event-stat-card__label">Lokasi</span>
						<span class="event-stat-card__value">{{ $locationLabel }}</span>
					</div>
				</div>
			</div>

			<div class="event-hero-visual">
				<div class="event-cover-card">
					<img src="{{ $image }}" alt="{{ $title }}" onerror="this.src='{{ asset('assets/img/90x90.jpg') }}'">
					<span class="event-cover-card__shade" aria-hidden="true"></span>
				</div>

				<div class="event-price-strip">
					<div>
						<span class="event-price-label">Harga kelas</span>
						<span class="event-price-value">{{ $priceLabel }}</span>
						@if(! $isPriceComingSoon && $promoPrice > 0 && $price > $finalPrice)
						<span class="event-price-original">Rp {{ number_format($price, 0, ',', '.') }}</span>
						@endif
					</div>
					@if($isIhtOrderable)
					<form action="{{ route('membernonanggota.event.order-iht', data_get($class, 'unique_id')) }}" method="POST" class="m-0 js-iht-order-form">
						@csrf
						<button type="submit" class="event-primary-cta" data-loading-text="Memproses...">Daftar Kelas</button>
					</form>
					@else
						<button
							type="button"
							class="event-primary-cta js-event-order-button"
							@if($canRegister)
							data-toggle="modal"
							data-target="#eventRegistrationModal"
							data-backdrop="static"
							data-keyboard="false"
							@endif
							data-course-status="{{ $courseStatusClass }}"
							data-alert-icon="{{ data_get($registrationAlert, 'icon') }}"
							data-alert-title="{{ data_get($registrationAlert, 'title') }}"
							data-alert-text="{{ data_get($registrationAlert, 'text') }}"
							data-can-register="{{ $canRegister ? '1' : '0' }}"
						>
							Daftar Kelas
						</button>
					@endif
				</div>
			</div>
		</div>
	</section>

	<div class="event-body-layout">
		<main class="event-content-stack">
			<section class="event-panel" aria-labelledby="event-about-title">
				<div class="event-panel__body">
					<span class="event-section-kicker">Tentang Kelas</span>
					<h2 class="event-section-title" id="event-about-title">Apa yang akan Anda pelajari?</h2>
					<div class="event-description">
						@if(data_get($class, 'content'))
						{!! data_get($class, 'content') !!}
						@else
						<p>Deskripsi kelas belum tersedia. Silakan hubungi tim Bankir Academy untuk informasi lebih lanjut.</p>
						@endif
					</div>
				</div>
			</section>

			<section class="event-panel" aria-labelledby="event-info-title">
				<div class="event-panel__body">
					<span class="event-section-kicker">Detail Pelaksanaan</span>
					<h2 class="event-section-title" id="event-info-title">Informasi praktis sebelum mengikuti kelas</h2>
					<div class="event-highlight-grid">
						<div class="event-highlight-card">
							<span class="event-highlight-card__label">Pendaftaran</span>
							<span class="event-highlight-card__value">{{ $formattedDate }}</span>
						</div>
						<div class="event-highlight-card">
							<span class="event-highlight-card__label">Jam</span>
							<span class="event-highlight-card__value">{{ $courseTimeLabel }}</span>
						</div>
						<div class="event-highlight-card">
							<span class="event-highlight-card__label">Metode</span>
							<span class="event-highlight-card__value">{{ $mode }}</span>
						</div>
						<div class="event-highlight-card">
							<span class="event-highlight-card__label">Lokasi / Media</span>
							<span class="event-highlight-card__value">{{ $locationLabel }}</span>
						</div>
					</div>
				</div>
			</section>

			@if($events->isNotEmpty())
			<section class="event-panel" aria-labelledby="event-agenda-title">
				<div class="event-panel__body">
					<span class="event-section-kicker">Agenda</span>
					<h2 class="event-section-title" id="event-agenda-title">Rangkaian pembelajaran</h2>
					<div class="event-agenda-list">
						@foreach($events as $event)
						<div class="event-agenda-item">
							<p class="event-agenda-text">{{ data_get($event, 'description') ?: 'Sesi pembelajaran kelas' }}</p>
						</div>
						@endforeach
					</div>
				</div>
			</section>
			@endif

			@if($instructors->isNotEmpty())
			<section class="event-panel" aria-labelledby="event-instructor-title">
				<div class="event-panel__body">
					<span class="event-section-kicker">Mentor</span>
					<h2 class="event-section-title" id="event-instructor-title">Dibimbing oleh praktisi berpengalaman</h2>
					<div class="event-instructor-grid">
						@foreach($instructors as $instructor)
						@php
						$pictureUrl = data_get($instructor, 'picture_src.url');
						$picture = $pictureUrl ? asset('Image/' . $pictureUrl) : data_get($instructor, 'picture');
						$picture = $picture ?: asset('assets/img/90x90.jpg');
						@endphp
						<div class="event-instructor-card">
							<img src="{{ $picture }}" alt="{{ data_get($instructor, 'name', 'Instruktur') }}" class="event-instructor-avatar" onerror="this.src='{{ asset('assets/img/90x90.jpg') }}'">
							<div>
								<h3 class="event-instructor-name">{{ data_get($instructor, 'name', 'Instruktur Bankir Academy') }}</h3>
								<p class="event-instructor-title">{{ data_get($instructor, 'title') ?: 'Praktisi dan pengajar Bankir Academy' }}</p>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</section>
			@endif
		</main>

		<aside class="event-side-stack" aria-label="Ringkasan kelas">
			<section class="event-register-card">
				<span class="event-register-card__label">Harga kelas</span>
				<span class="event-register-card__price">{{ $priceLabel }}</span>
				@if(! $isPriceComingSoon && $promoPrice > 0 && $price > $finalPrice)
				<span class="event-register-card__original">Rp {{ number_format($price, 0, ',', '.') }}</span>
				@endif
				@if($isIhtOrderable)
				<form action="{{ route('membernonanggota.event.order-iht', data_get($class, 'unique_id')) }}" method="POST" class="m-0 js-iht-order-form">
					@csrf
					<button type="submit" class="event-register-button" data-loading-text="Memproses...">Daftar / Beli Kelas</button>
				</form>
				@else
					<button
						type="button"
						class="event-register-button js-event-order-button"
						@if($canRegister)
						data-toggle="modal"
						data-target="#eventRegistrationModal"
						data-backdrop="static"
						data-keyboard="false"
						@endif
						data-course-status="{{ $courseStatusClass }}"
						data-alert-icon="{{ data_get($registrationAlert, 'icon') }}"
						data-alert-title="{{ data_get($registrationAlert, 'title') }}"
						data-alert-text="{{ data_get($registrationAlert, 'text') }}"
						data-can-register="{{ $canRegister ? '1' : '0' }}"
					>
						Daftar / Beli Kelas
					</button>
				@endif
				<p class="event-register-note">Pastikan data profil Anda sudah lengkap sebelum melakukan pembelian atau pendaftaran kelas.</p>
			</section>

			<section class="event-panel">
				<div class="event-panel__body">
					<span class="event-section-kicker">Ringkasan</span>
					<h2 class="event-section-title">Kelas ini cocok untuk</h2>
					<div class="event-highlight-grid">
						<div class="event-highlight-card">
							<span class="event-highlight-card__label">Level</span>
							<span class="event-highlight-card__value">{{ $level }}</span>
						</div>
						<div class="event-highlight-card">
							<span class="event-highlight-card__label">Kuota</span>
							<span class="event-highlight-card__value">{{ $participantLimit ? $participantLimit . ' peserta' : 'Terbatas' }}</span>
						</div>
					</div>
				</div>
			</section>

			@if($relatedClasses->isNotEmpty())
			<section class="event-panel">
				<div class="event-panel__body">
					<span class="event-section-kicker">Rekomendasi</span>
					<h2 class="event-section-title">Kelas terkait</h2>
					<div class="event-related-list">
						@foreach($relatedClasses as $related)
						<a href="{{ url('/detail-event/' . $related->unique_id . '/' . \Illuminate\Support\Str::slug($related->title)) }}" class="event-related-link">
							{{ $related->title }}
						</a>
						@endforeach
					</div>
				</div>
			</section>
			@endif
		</aside>
	</div>
</div>

@include('membernonkeanggotaan.components.ui.event-registration-modal', ['class' => $class, 'modalId' => 'eventRegistrationModal'])

<script>
	document.addEventListener('DOMContentLoaded', function() {
		document.querySelectorAll('.js-iht-order-form').forEach(function(form) {
			form.addEventListener('submit', function(event) {
				if (form.dataset.submitted === '1') {
					event.preventDefault();
					return;
				}

				form.dataset.submitted = '1';
				const submitButton = form.querySelector('button[type="submit"]');

				if (submitButton) {
					submitButton.disabled = true;
					submitButton.dataset.originalText = submitButton.textContent.trim();
					submitButton.textContent = submitButton.dataset.loadingText || 'Memproses...';
				}
			});
		});

		document.querySelectorAll('.js-event-order-button').forEach(function(button) {
			button.addEventListener('click', function(event) {
				if (button.dataset.canRegister === '1') {
					return;
				}

				event.preventDefault();
				event.stopPropagation();

				const alertIcon = button.dataset.alertIcon || 'info';
				const alertTitle = button.dataset.alertTitle || 'Kelas belum dapat didaftarkan';
				const alertText = button.dataset.alertText || 'Kelas ini belum dapat diorder saat ini.';

				if (window.Swal && typeof window.Swal.fire === 'function') {
					window.Swal.fire({
						icon: alertIcon,
						title: alertTitle,
						text: alertText,
						confirmButtonText: 'Mengerti'
					});

					return;
				}

				alert(alertText);
			});
		});
	});
</script>
@endsection
