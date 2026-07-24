@php
$course = $course ?? null;
$levels = [
1 => 'Pemula',
2 => 'Menengah',
3 => 'Lanjutan',
];

$title = data_get($course, 'title', 'Kelas pembelajaran');
$level = $levels[(int) data_get($course, 'level')] ?? 'Semua Level';
$category = data_get($course, 'category') ?: 'Kelas Bankir';
$mode = [
	0 => 'Online',
	1 => 'Offline',
][(int) data_get($course, 'kategori')] ?? 'Kelas';
$mediaIcon = $mode === 'Offline' ? 'fa-users' : 'fa-video';
$mediaTooltip = $mode === 'Offline' ? 'Tatap muka di lokasi penyelenggara' : 'Online melalui Zoom';
$startDate = data_get($course, 'date_start');
$endDate = data_get($course, 'date_end');
$isIht = (int) data_get($course, 'iht') === 1;
$courseTime = data_get($course, 'jam_acara');
$participantLimit = data_get($course, 'participant_limit');
$pricing = data_get($course, 'pricing');
	$isFree = ! $isIht && $pricing && (int) data_get($pricing, 'gratis', 0) === 1;
	$isPriceComingSoon = ! $isIht && ! $pricing;
$price = (int) data_get($pricing, 'price', 0);
$promoPrice = (int) data_get($pricing, 'promo_price', 0);
$finalPrice = max(0, $price - $promoPrice);
	$priceLabel = $isIht
		? 'Hubungi Tim Kami'
		: ($isFree
			? 'Gratis'
			: ($isPriceComingSoon
			? 'Price Coming Soon'
			: ($finalPrice > 0 ? 'Rp ' . number_format($finalPrice, 0, ',', '.') : 'Gratis')));
$description = trim(strip_tags((string) data_get($course, 'content', '')));
$description = $description !== '' ? \Illuminate\Support\Str::limit($description, 118) : 'Pelajari kompetensi perbankan melalui kelas terstruktur bersama Bankir Academy.';
$image = data_get($course, 'image_mobile') ?: data_get($course, 'image');
$image = $image ?: asset('assets/img/90x90.jpg');
$detailUrl = data_get($course, 'unique_id')
? url('/detail-event/' . data_get($course, 'unique_id') . '/' . \Illuminate\Support\Str::slug($title))
: 'javascript:void(0);';
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
$registrationDate = 'Fleksibel';
$courseStatus = 'Upcoming';
$courseStatusClass = 'upcoming';

	if ($startDate && $endDate) {
		$start = \Carbon\Carbon::parse($startDate);
		$end = \Carbon\Carbon::parse($endDate);
		$statusEnd = $isIht ? $end->copy() : $end->copy()->subDay();
		$today = now()->startOfDay();
	$registrationDate = $start->isSameMonth($end) && $start->isSameYear($end)
		? $formatCourseDate($start, false) . ' - ' . $formatCourseDate($end)
		: $formatCourseDate($start, ! $start->isSameYear($end)) . ' - ' . $formatCourseDate($end);

	if ($today->betweenIncluded($start->copy()->startOfDay(), $statusEnd->endOfDay())) {
		$courseStatus = 'Running';
		$courseStatusClass = 'running';
	} elseif ($today->greaterThan($statusEnd->endOfDay())) {
		$courseStatus = 'Completed';
		$courseStatusClass = 'completed';
	}
} elseif ($startDate) {
	$registrationDate = $formatCourseDate($startDate);

	if (now()->startOfDay()->greaterThan(\Carbon\Carbon::parse($startDate)->endOfDay())) {
		$courseStatus = 'Completed';
		$courseStatusClass = 'completed';
	}
}

if (! $isIht && $endDate) {
	$registrationDate = $formatCourseDate(\Carbon\Carbon::parse($endDate)->subDay());
}

if ($isIht && $courseStatusClass === 'upcoming') {
	$courseStatus = 'IHT';
	$courseStatusClass = 'iht';
	$registrationDate = 'Hubungi Tim Kami';
}
@endphp

@if(empty($withoutStyle))
@once
<style>
	.member-course-card {
		height: 100%;
		min-height: 100%;
		background: #ffffff;
		border: 1px solid #e7e9f0;
		border-radius: 18px;
		box-shadow: 0 10px 30px rgba(15, 23, 42, .05);
		overflow: hidden;
		display: flex;
		flex-direction: column;
		transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
	}

	.member-course-card:hover {
		border-color: rgba(79, 70, 229, .22);
		box-shadow: 0 18px 44px rgba(79, 70, 229, .1);
		transform: translateY(-4px);
	}

	.member-course-card--completed {
		background: #f3f4f6;
		border-color: #d1d5db;
		box-shadow: none;
	}

	.member-course-card--completed:hover {
		border-color: #d1d5db;
		box-shadow: none;
		transform: none;
	}

	.member-course-card__media {
		position: relative;
		aspect-ratio: 16 / 10;
		background: linear-gradient(135deg, #eef0fe, #f8fafc);
		overflow: hidden;
	}

	.member-course-card__media img {
		width: 100%;
		height: 100%;
		display: block;
		object-fit: cover;
		transition: transform .3s ease;
	}

	.member-course-card:hover .member-course-card__media img {
		transform: scale(1.04);
	}

	.member-course-card--completed .member-course-card__media img {
		filter: grayscale(1);
		opacity: .62;
	}

	.member-course-card--completed:hover .member-course-card__media img {
		transform: none;
	}

	.member-course-card__badge-row {
		position: absolute;
		left: 14px;
		right: 14px;
		top: 14px;
		display: flex;
		align-items: center;
		justify-content: flex-start;
		gap: 10px;
	}

	.member-course-card__badge {
		display: inline-flex;
		align-items: center;
		min-height: 28px;
		padding: 6px 10px;
		border-radius: 999px;
		background: rgba(17, 24, 39, .76);
		color: #ffffff;
		font-size: 11px;
		font-weight: 800;
		line-height: 1;
		backdrop-filter: blur(10px);
	}

	.member-course-card__badge--level {
		background: rgba(79, 70, 229, .92);
	}

	.member-course-card__body {
		padding: 18px;
		display: flex;
		flex: 1;
		flex-direction: column;
	}

	.member-course-card__category {
		display: flex;
		align-items: center;
		gap: 8px;
		flex-wrap: wrap;
		margin: 0 0 8px;
		color: var(--primary, #4F46E5);
		font-size: 12px;
		font-weight: 800;
		letter-spacing: .04em;
		text-transform: uppercase;
	}

	.member-course-card__category-badge {
		display: inline-flex;
		align-items: center;
		min-height: 24px;
		padding: 5px 9px;
		border-radius: 999px;
		background: var(--primary-soft, #EEF0FE);
		color: var(--primary, #4F46E5);
		font-size: 11px;
		font-weight: 850;
		letter-spacing: 0;
		text-transform: none;
	}

	.member-course-card__category-badge--mode {
		background: #111827;
		color: #ffffff;
	}

	.member-course-card__category-badge--status-running {
		background: #dcfce7;
		color: #166534;
	}

	.member-course-card__category-badge--status-upcoming {
		background: #fff7ed;
		color: #c2410c;
	}

	.member-course-card__category-badge--status-completed {
		background: #e5e7eb;
		color: #4b5563;
	}

	.member-course-card__category-badge--status-iht {
		background: #eef0fe;
		color: #4f46e5;
	}

	.member-course-card--completed .member-course-card__category-badge,
	.member-course-card--completed .member-course-card__meta-item {
		background: #e5e7eb;
		border-color: #d1d5db;
		color: #4b5563;
	}

	.member-course-card--completed .member-course-card__category-badge--status-completed {
		background: #fee2e2;
		border-color: #fecaca;
		color: #b91c1c;
	}

	.member-course-card--completed .member-course-card__title,
	.member-course-card--completed .member-course-card__description,
	.member-course-card--completed .member-course-card__meta-value,
	.member-course-card--completed .member-course-card__price-value {
		color: #6b7280;
	}

	.member-course-card__title {
		margin: 0;
		color: #111827;
		font-size: 18px;
		font-weight: 850;
		letter-spacing: -.03em;
		line-height: 1.28;
		display: -webkit-box;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical;
		overflow: hidden;
	}

	.member-course-card__title a {
		color: inherit;
	}

	.member-course-card__description {
		margin: 10px 0 0;
		color: #6b7280;
		font-size: 13.5px;
		line-height: 1.6;
		display: -webkit-box;
		-webkit-line-clamp: 3;
		-webkit-box-orient: vertical;
		overflow: hidden;
	}

	.member-course-card__meta {
		margin-top: 16px;
		display: grid;
		grid-template-columns: repeat(2, minmax(0, 1fr));
		gap: 10px;
	}

	.member-course-card__meta-item {
		padding: 10px;
		border: 1px solid #eef2f7;
		border-radius: 12px;
		background: #f9fafb;
	}

	.member-course-card__meta-label {
		display: block;
		margin-bottom: 3px;
		color: #9ca3af;
		font-size: 11px;
		font-weight: 800;
		letter-spacing: .04em;
		text-transform: uppercase;
	}

	.member-course-card__meta-value {
		display: block;
		color: #1f2937;
		font-size: 12.5px;
		font-weight: 800;
		line-height: 1.35;
		overflow-wrap: break-word;
	}

	.member-course-card__media-icon {
		position: relative;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 24px;
		height: 24px;
		border-radius: 50%;
		background: rgba(17, 24, 39, .76);
		color: #ffffff;
		font-size: 11px;
		cursor: help;
	}

	.member-course-card__media-icon::after {
		content: attr(data-tooltip);
		position: absolute;
		left: 50%;
		bottom: calc(100% + 8px);
		z-index: 3;
		width: max-content;
		max-width: 190px;
		padding: 6px 8px;
		border-radius: 6px;
		background: #111827;
		color: #ffffff;
		font-size: 10px;
		font-weight: 600;
		line-height: 1.3;
		text-align: center;
		white-space: normal;
		pointer-events: none;
		opacity: 0;
		transform: translate(-50%, 4px);
		transition: opacity .18s ease, transform .18s ease;
	}

	.member-course-card__media-icon:hover::after,
	.member-course-card__media-icon:focus-visible::after {
		opacity: 1;
		transform: translate(-50%, 0);
	}

	.member-course-card__footer {
		margin-top: auto;
		padding-top: 18px;
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 14px;
	}

	.member-course-card__price {
		min-width: 0;
	}

	.member-course-card__price-label {
		display: block;
		color: #9ca3af;
		font-size: 11px;
		font-weight: 800;
		text-transform: uppercase;
	}

	.member-course-card__price-value {
		display: block;
		color: #111827;
		font-size: 18px;
		font-weight: 900;
		letter-spacing: -.03em;
		line-height: 1.25;
	}

	.member-course-card__price-value--coming-soon {
		font-size: 16px;
	}

	.member-course-card__price-original {
		display: block;
		color: #9ca3af;
		font-size: 12px;
		font-weight: 700;
		text-decoration: line-through;
	}

	.member-course-card__button {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		min-height: 40px;
		padding: 10px 14px;
		border-radius: 999px;
		background: var(--primary, #4F46E5);
		color: #ffffff;
		font-size: 13px;
		font-weight: 850;
		white-space: nowrap;
		box-shadow: 0 10px 20px rgba(79, 70, 229, .18);
		transition: background .18s ease, transform .18s ease, box-shadow .18s ease;
	}

	.member-course-card__button:hover {
		background: var(--primary-dark, #3D33D8);
		color: #ffffff;
		box-shadow: 0 12px 26px rgba(79, 70, 229, .24);
		transform: translateY(-1px);
	}

	@media (max-width: 575.98px) {
		.member-course-card__body {
			padding: 16px;
		}

		.member-course-card__title {
			font-size: 16px;
		}

		.member-course-card__footer {
			align-items: stretch;
			flex-direction: column;
		}

		.member-course-card__button {
			width: 100%;
		}
	}

	@media (prefers-reduced-motion: reduce) {

		.member-course-card,
		.member-course-card * {
			transition: none !important;
		}
	}
</style>
@endonce
@endif

<article class="member-course-card {{ $courseStatusClass === 'completed' ? 'member-course-card--completed' : '' }}">
	<a href="{{ $detailUrl }}" class="member-course-card__media" aria-label="Lihat detail {{ $title }}">
		<img src="{{ $image }}" alt="{{ $title }}" loading="lazy" onerror="this.src='{{ asset('assets/img/90x90.jpg') }}'">
	</a>

	<div class="member-course-card__body">
		<p class="member-course-card__category">
			<span class="member-course-card__category-badge">{{ $category }}</span>
			<span class="member-course-card__category-badge member-course-card__category-badge--status-{{ $courseStatusClass }}">{{ $courseStatus }}</span>
		</p>
		<h3 class="member-course-card__title">
			<a href="{{ $detailUrl }}">{{ $title }}</a>
		</h3>
		<p class="member-course-card__description">{{ $description }}</p>

		<div class="member-course-card__meta" aria-label="Informasi kelas">
			<div class="member-course-card__meta-item">
				<span class="member-course-card__meta-label">{{ $isIht ? 'Pendaftaran' : 'Batas Pendaftaran' }}</span>
				<span class="member-course-card__meta-value">
					{{ $registrationDate }}
				</span>
			</div>
			<div class="member-course-card__meta-item">
				<span class="member-course-card__meta-label">Waktu</span>
				<span class="member-course-card__meta-value">{{ $courseTime ?: 'Menyesuaikan' }}</span>
			</div>
			<div class="member-course-card__meta-item">
				<span class="member-course-card__meta-label">Level</span>
				<span class="member-course-card__meta-value">{{ $level }}</span>
			</div>
			<div class="member-course-card__meta-item">
				<span class="member-course-card__meta-label">Media</span>
				<span class="member-course-card__meta-value">
					<span
						class="member-course-card__media-icon"
						tabindex="0"
						role="img"
						aria-label="{{ $mediaTooltip }}"
						data-tooltip="{{ $mediaTooltip }}"
					>
						<i class="fas {{ $mediaIcon }}" aria-hidden="true"></i>
					</span>
				</span>
			</div>
		</div>

		<div class="member-course-card__footer">
			<div class="member-course-card__price">
				<span class="member-course-card__price-label">Investasi</span>
				<span class="member-course-card__price-value {{ $isPriceComingSoon ? 'member-course-card__price-value--coming-soon' : '' }}">{{ $priceLabel }}</span>
				@if(! $isPriceComingSoon && $promoPrice > 0 && $price > $finalPrice)
				<span class="member-course-card__price-original">Rp {{ number_format($price, 0, ',', '.') }}</span>
				@endif
			</div>
			<a href="{{ $detailUrl }}" class="member-course-card__button">Lihat Kelas</a>
		</div>
	</div>
</article>
