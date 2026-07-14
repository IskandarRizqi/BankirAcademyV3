@extends('layouts.appmembernonanggota')

@section('title', 'Event Kelas')

@section('content')
@php
$classes = $classes ?? collect();
$filters = $filters ?? [
'q' => '',
'level' => null,
'category' => [],
'instructor' => [],
'jenis' => [],
'kategori' => [],
];
$filterOptions = $filterOptions ?? [
'category' => [],
'instructor' => [],
'jenis' => [],
'kategori' => [],
];
$levelOptions = [
'1' => 'Pemula',
'2' => 'Menengah',
'3' => 'Lanjutan',
];
@endphp

<style>
	.course-list-page {
		display: flex;
		flex-direction: column;
		gap: 22px;
	}

	.course-list-hero {
		position: relative;
		overflow: hidden;
		border-radius: 24px;
		padding: 28px;
		background:
			radial-gradient(circle at 82% 18%, rgba(6, 182, 212, .26), transparent 30%),
			linear-gradient(135deg, #111827 0%, #312e81 52%, #4f46e5 100%);
		color: #ffffff;
		box-shadow: 0 20px 48px rgba(49, 46, 129, .18);
	}

	.course-list-hero::after {
		content: "";
		position: absolute;
		inset: 0;
		background-image:
			linear-gradient(rgba(255, 255, 255, .06) 1px, transparent 1px),
			linear-gradient(90deg, rgba(255, 255, 255, .06) 1px, transparent 1px);
		background-size: 38px 38px;
		mask-image: linear-gradient(90deg, transparent, #000 22%, #000 88%, transparent);
		pointer-events: none;
	}

	.course-list-hero__content {
		position: relative;
		z-index: 1;
		max-width: 720px;
	}

	.course-list-hero__eyebrow {
		display: inline-flex;
		align-items: center;
		gap: 8px;
		margin-bottom: 12px;
		padding: 7px 12px;
		border: 1px solid rgba(255, 255, 255, .18);
		border-radius: 999px;
		background: rgba(255, 255, 255, .12);
		color: rgba(255, 255, 255, .9);
		font-size: 12px;
		font-weight: 800;
		letter-spacing: .06em;
		text-transform: uppercase;
		backdrop-filter: blur(10px);
	}

	.course-list-hero__title {
		margin: 0;
		font-size: clamp(28px, 4vw, 46px);
		font-weight: 900;
		letter-spacing: -.05em;
		line-height: 1.05;
	}

	.course-list-hero__description {
		max-width: 620px;
		margin: 14px 0 0;
		color: rgba(255, 255, 255, .78);
		font-size: 15px;
		line-height: 1.7;
	}

	.course-filter-card {
		position: sticky;
		top: calc(var(--topbar-h, 68px) + 18px);
		padding: 16px;
		border: 1px solid #e7e9f0;
		border-radius: 18px;
		background: #ffffff;
		box-shadow: 0 10px 30px rgba(15, 23, 42, .04);
	}

	.course-filter-form {
		display: flex;
		flex-direction: column;
		gap: 12px;
	}

	.course-filter-card__title {
		margin: 0 0 4px;
		color: #111827;
		font-size: 16px;
		font-weight: 900;
		letter-spacing: -.02em;
	}

	.course-filter-card__subtitle {
		margin: 0 0 14px;
		color: #6b7280;
		font-size: 13px;
		line-height: 1.5;
	}

	.course-filter-field label {
		display: block;
		margin-bottom: 6px;
		color: #4b5563;
		font-size: 12px;
		font-weight: 800;
		letter-spacing: .04em;
		text-transform: uppercase;
	}

	.course-filter-control {
		width: 100%;
		height: 44px;
		border: 1px solid #e5e7eb;
		border-radius: 12px;
		background: #ffffff;
		color: #111827;
		padding: 0 13px;
		font-size: 14px;
		font-weight: 600;
		outline: none;
		transition: border-color .18s ease, box-shadow .18s ease;
	}

	.course-filter-control:focus {
		border-color: var(--primary, #4F46E5);
		box-shadow: 0 0 0 4px rgba(79, 70, 229, .1);
	}

	.course-filter-control:disabled {
		background: #f9fafb;
		color: #9ca3af;
		cursor: not-allowed;
	}

	.course-filter-actions {
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 10px;
		align-items: center;
		padding-top: 4px;
	}

	.course-filter-button {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		height: 44px;
		padding: 0 16px;
		border: 0;
		border-radius: 12px;
		background: var(--primary, #4F46E5);
		color: #ffffff;
		font-size: 13px;
		font-weight: 850;
		cursor: pointer;
		white-space: nowrap;
	}

	.course-filter-reset {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		height: 44px;
		padding: 0 14px;
		border-radius: 12px;
		background: #f3f4f6;
		color: #4b5563;
		font-size: 13px;
		font-weight: 800;
		white-space: nowrap;
	}

	.course-list-layout {
		display: grid;
		grid-template-columns: 280px minmax(0, 1fr);
		gap: 22px;
		align-items: start;
	}

	.course-list-content {
		min-width: 0;
	}

	.course-section-header {
		display: flex;
		align-items: flex-end;
		justify-content: space-between;
		gap: 16px;
	}

	.course-section-header h2 {
		margin: 0;
		color: #111827;
		font-size: 22px;
		font-weight: 900;
		letter-spacing: -.03em;
	}

	.course-section-header p {
		margin: 4px 0 0;
		color: #6b7280;
		font-size: 14px;
	}

	.course-result-count {
		padding: 8px 12px;
		border-radius: 999px;
		background: var(--primary-soft, #EEF0FE);
		color: var(--primary, #4F46E5);
		font-size: 12px;
		font-weight: 850;
		white-space: nowrap;
	}

	.course-grid {
		display: grid;
		grid-template-columns: repeat(3, minmax(0, 1fr));
		gap: 18px;
	}

	.course-empty-state {
		padding: 42px 22px;
		border: 1px dashed #cbd5e1;
		border-radius: 18px;
		background: #ffffff;
		text-align: center;
	}

	.course-empty-state h3 {
		margin: 0;
		color: #111827;
		font-size: 20px;
		font-weight: 900;
	}

	.course-empty-state p {
		max-width: 460px;
		margin: 8px auto 0;
		color: #6b7280;
		font-size: 14px;
		line-height: 1.6;
	}

	.course-pagination {
		display: flex;
		justify-content: center;
	}

	.course-infinite-scroll {
		display: flex;
		justify-content: center;
		margin-top: 22px;
		min-height: 44px;
	}

	.course-load-more-button {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		min-height: 42px;
		padding: 10px 18px;
		border: 0;
		border-radius: 999px;
		background: var(--primary-soft, #EEF0FE);
		color: var(--primary, #4F46E5);
		font-size: 13px;
		font-weight: 850;
		cursor: pointer;
	}

	.course-load-more-button:disabled {
		cursor: wait;
		opacity: .72;
	}

	.course-load-more-button[hidden] {
		display: none;
	}

	.course-load-status {
		align-self: center;
		color: #6b7280;
		font-size: 13px;
		font-weight: 700;
	}

	@media (max-width: 1199.98px) {
		.course-list-layout {
			grid-template-columns: 260px minmax(0, 1fr);
		}

		.course-grid {
			grid-template-columns: repeat(2, minmax(0, 1fr));
		}
	}

	@media (max-width: 991.98px) {
		.course-filter-card {
			position: static;
		}

		.course-list-layout {
			grid-template-columns: 1fr;
		}

		.course-filter-form {
			display: grid;
			grid-template-columns: repeat(2, minmax(0, 1fr));
		}

		.course-filter-actions {
			grid-column: 1 / -1;
		}
	}

	@media (max-width: 767.98px) {
		.course-list-hero {
			padding: 22px;
			border-radius: 20px;
		}

		.course-filter-form {
			grid-template-columns: 1fr;
		}

		.course-filter-actions {
			grid-column: auto;
		}

		.course-section-header {
			align-items: flex-start;
			flex-direction: column;
		}

		.course-grid {
			grid-template-columns: 1fr;
		}
	}

	@media (max-width: 420px) {
		.course-filter-actions {
			grid-template-columns: 1fr;
		}
	}
</style>

<div class="course-list-page">
	<section class="course-list-hero" aria-labelledby="course-list-title">
		<div class="course-list-hero__content">
			<span class="course-list-hero__eyebrow">Bankir Academy Learning</span>
			<h1 class="course-list-hero__title" id="course-list-title">Pilih kelas pembelajaran yang sesuai target karier Anda</h1>
			<p class="course-list-hero__description">
				Temukan kelas, event, dan pelatihan perbankan yang dirancang untuk meningkatkan kompetensi secara praktis dan terukur.
			</p>
		</div>
	</section>

	<div class="course-list-layout">
		<aside class="course-filter-card" aria-label="Filter kelas pembelajaran">
			<h2 class="course-filter-card__title">Filter Kelas</h2>
			<p class="course-filter-card__subtitle">Pilih kategori, instruktur, level, jenis, dan mode kelas.</p>

			<form class="course-filter-form" method="GET" action="{{ url('/event-kelas') }}">
				<div class="course-filter-field">
					<label for="course-search">Cari kelas</label>
					<input type="search" id="course-search" class="course-filter-control" value="{{ $filters['q'] }}" placeholder="Cari kelas anda">
				</div>

				<div class="course-filter-field">
					<label for="course-category">Kategori</label>
					<select id="course-category" name="category" class="course-filter-control">
						<option value="">Semua kategori</option>
						@foreach($filterOptions['category'] as $value => $label)
						<option value="{{ $value }}" {{ in_array((string) $value, $filters['category'], true) ? 'selected' : '' }}>{{ $label }}</option>
						@endforeach
					</select>
				</div>

				<div class="course-filter-field">
					<label for="course-instructor">Instruktur</label>
					<select id="course-instructor" name="instructor" class="course-filter-control">
						<option value="">Semua instruktur</option>
						@foreach($filterOptions['instructor'] as $value => $label)
						<option value="{{ $value }}" {{ in_array((string) $value, $filters['instructor'], true) ? 'selected' : '' }}>{{ $label }}</option>
						@endforeach
					</select>
				</div>

				<div class="course-filter-field">
					<label for="course-level">Level</label>
					<select id="course-level" name="level" class="course-filter-control">
						<option value="">Semua level</option>
						@foreach($levelOptions as $value => $label)
						<option value="{{ $value }}" {{ (string) $filters['level'] === (string) $value ? 'selected' : '' }}>{{ $label }}</option>
						@endforeach
					</select>
				</div>

				<div class="course-filter-field">
					<label for="course-jenis">Jenis</label>
					<select id="course-jenis" name="jenis" class="course-filter-control">
						<option value="">Semua jenis</option>
						@foreach($filterOptions['jenis'] as $value => $label)
						<option value="{{ $value }}" {{ in_array((string) $value, $filters['jenis'], true) ? 'selected' : '' }}>{{ $label }}</option>
						@endforeach
					</select>
				</div>

				<div class="course-filter-field">
					<label for="course-kategori">Mode</label>
					<select id="course-kategori" name="kategori" class="course-filter-control">
						<option value="">Semua mode</option>
						@foreach($filterOptions['kategori'] as $value => $label)
						<option value="{{ $value }}" {{ in_array((string) $value, $filters['kategori'], true) ? 'selected' : '' }}>{{ $label }}</option>
						@endforeach
					</select>
				</div>

				<div class="course-filter-actions">
					<button type="submit" class="course-filter-button">Terapkan</button>
					<a href="{{ url('/event-kelas') }}" class="course-filter-reset">Reset</a>
				</div>
			</form>
		</aside>

		<section class="course-list-content" aria-labelledby="course-grid-title">
			<div class="course-section-header mb-3">
				<div>
					<h2 id="course-grid-title">Daftar Kelas</h2>
					<p>Kelas aktif yang tersedia untuk Anda ikuti.</p>
				</div>
				@if(method_exists($classes, 'total'))
				<span class="course-result-count">{{ $classes->total() }} kelas tersedia</span>
				@endif
			</div>

			@if($classes->count() > 0)
			<div class="course-grid" id="courseGrid">
				@include('membernonkeanggotaan.components.ui.course-card-items', ['classes' => $classes])
			</div>

			@if(method_exists($classes, 'hasPages') && $classes->hasPages())
			<div class="course-infinite-scroll" id="courseInfiniteScroll" data-next-url="{{ $classes->nextPageUrl() }}">
				<button type="button" class="course-load-more-button" id="courseLoadMoreButton">Muat kelas lainnya</button>
				<span class="course-load-status" id="courseLoadStatus" hidden>Memuat kelas...</span>
			</div>
			@endif
			@else
			<div class="course-empty-state">
				<h3>Belum ada kelas yang cocok</h3>
				<p>Ubah filter kategori, instruktur, level, jenis, atau mode untuk melihat kelas pembelajaran lain yang tersedia.</p>
			</div>
			@endif
		</section>
	</div>
</div>
@endsection

@push('scripts')
<script>
	(function() {
		const grid = document.getElementById('courseGrid');
		const loader = document.getElementById('courseInfiniteScroll');
		const loadMoreButton = document.getElementById('courseLoadMoreButton');
		const loadStatus = document.getElementById('courseLoadStatus');

		if (!grid || !loader || !loadMoreButton || !loadStatus) {
			return;
		}

		let nextUrl = loader.dataset.nextUrl;
		let isLoading = false;
		let observer = null;

		function setLoadingState(isActive) {
			isLoading = isActive;
			loadMoreButton.disabled = isActive;
			loadMoreButton.hidden = isActive;
			loadStatus.hidden = !isActive;
		}

		function finishLoading(nextPageUrl) {
			nextUrl = nextPageUrl;
			loader.dataset.nextUrl = nextPageUrl || '';
			setLoadingState(false);

			if (!nextUrl) {
				if (observer) {
					observer.disconnect();
				}

				loader.remove();
			}
		}

		async function loadNextPage() {
			if (isLoading || !nextUrl) {
				return;
			}

			setLoadingState(true);

			try {
				const response = await fetch(nextUrl, {
					headers: {
						'X-Requested-With': 'XMLHttpRequest',
						'Accept': 'application/json'
					},
					credentials: 'same-origin'
				});

				if (!response.ok) {
					throw new Error('Gagal memuat data kelas.');
				}

				const payload = await response.json();
				grid.insertAdjacentHTML('beforeend', payload.html || '');
				finishLoading(payload.has_more_pages ? payload.next_page_url : null);
			} catch (error) {
				setLoadingState(false);
				loadMoreButton.hidden = false;
				loadMoreButton.textContent = 'Coba muat lagi';
			}
		}

		loadMoreButton.addEventListener('click', loadNextPage);

		if ('IntersectionObserver' in window) {
			observer = new IntersectionObserver(function(entries) {
				if (entries.some(function(entry) {
						return entry.isIntersecting;
					})) {
					loadNextPage();
				}
			}, {
				rootMargin: '360px 0px'
			});

			observer.observe(loader);
		}
	})();
</script>
@endpush