@extends('layouts.appmembernonanggota')

@section('content')
@once
<style>
	.kelas-anda-page {
		width: 100%;
	}

	.kelas-anda-page__header {
		margin-bottom: 24px;
	}

	.kelas-anda-page__title {
		margin: 0 0 4px;
		color: #111827;
		font-size: 28px;
		font-weight: 800;
		letter-spacing: -0.02em;
		line-height: 1.2;
	}

	.kelas-anda-page__subtitle {
		margin: 0;
		color: #6b7280;
		font-size: 14px;
		font-weight: 500;
		line-height: 1.5;
	}

	.tabs-nav {
		display: flex;
		gap: 8px;
		background: #f9fafb;
		border: 1px solid #eef2f7;
		border-radius: 10px;
		padding: 4px;
		margin-bottom: 20px;
		flex-wrap: wrap;
	}

	.tabs-nav__item {
		flex: 1;
		min-width: 140px;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		gap: 8px;
		padding: 10px 16px;
		border-radius: 8px;
		background: transparent;
		border: none;
		color: #6b7280;
		font-size: 14px;
		font-weight: 700;
		line-height: 1;
		cursor: pointer;
		transition: background .15s ease, color .15s ease;
		white-space: nowrap;
	}

	.tabs-nav__item:hover {
		background: #ffffff;
		color: #111827;
	}

	.tabs-nav__item--active {
		background: #ffffff;
		color: var(--primary, #4F46E5);
		box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
	}

	.tabs-nav__count {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		min-width: 22px;
		height: 22px;
		padding: 0 8px;
		border-radius: 999px;
		background: #eef2f7;
		color: #4b5563;
		font-size: 11px;
		font-weight: 800;
		line-height: 1;
	}

	.tabs-nav__item--active .tabs-nav__count {
		background: var(--primary-soft, #EEF0FE);
		color: var(--primary, #4F46E5);
	}

	.course-grid {
		display: grid;
		grid-template-columns: repeat(3, minmax(0, 1fr));
		gap: 20px;
	}

	.tab-panel.hidden {
		display: none;
	}

	@media (max-width: 1199.98px) {
		.course-grid {
			grid-template-columns: repeat(2, minmax(0, 1fr));
		}
	}

	@media (max-width: 575.98px) {
		.course-grid {
			grid-template-columns: 1fr;
		}
	}

	.empty-state {
		grid-column: 1 / -1;
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		padding: 60px 24px;
		background: #f9fafb;
		border: 1px dashed #e5e7eb;
		border-radius: 14px;
		text-align: center;
	}

	.empty-state__icon {
		width: 64px;
		height: 64px;
		border-radius: 16px;
		background: #eef2f7;
		color: #9ca3af;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		font-size: 28px;
		margin-bottom: 16px;
	}

	.empty-state__title {
		margin: 0 0 8px;
		color: #111827;
		font-size: 18px;
		font-weight: 800;
		line-height: 1.3;
	}

	.empty-state__text {
		margin: 0 0 20px;
		color: #6b7280;
		font-size: 14px;
		line-height: 1.6;
		max-width: 280px;
	}

	.empty-state__btn {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		gap: 8px;
		min-height: 44px;
		padding: 10px 20px;
		border-radius: 999px;
		background: var(--primary, #4F46E5);
		color: #ffffff;
		font-size: 14px;
		font-weight: 800;
		text-decoration: none;
		transition: background .15s ease, transform .15s ease, box-shadow .15s ease;
	}

	.empty-state__btn:hover {
		background: var(--primary-dark, #3D33D8);
		color: #ffffff;
		transform: translateY(-1px);
		box-shadow: 0 8px 18px rgba(79, 70, 229, .2);
	}

	.pagination-wrapper {
		margin-top: 24px;
		display: flex;
		justify-content: center;
	}

	.pagination-wrapper .pagination {
		margin: 0;
	}

	.pagination-wrapper .page-link {
		min-width: 40px;
		height: 40px;
		padding: 0 12px;
		border: 1px solid #e5e7eb;
		border-radius: 8px !important;
		margin: 0 4px;
		color: #4b5563;
		font-size: 14px;
		font-weight: 700;
		display: flex;
		align-items: center;
		justify-content: center;
		background: #ffffff;
		transition: all .15s ease;
	}

	.pagination-wrapper .page-link:hover {
		background: var(--primary-soft, #EEF0FE);
		border-color: var(--primary, #4F46E5);
		color: var(--primary, #4F46E5);
	}

	.pagination-wrapper .page-item.active .page-link {
		background: var(--primary, #4F46E5);
		border-color: var(--primary, #4F46E5);
		color: #ffffff;
	}

	.pagination-wrapper .page-item.disabled .page-link {
		color: #d1d5db;
		background: #f9fafb;
		border-color: #e5e7eb;
	}

	@media (prefers-reduced-motion: reduce) {

		.tabs-nav__item,
		.tabs-nav__item *,
		.member-course-card,
		.member-course-card *,
		.empty-state__btn,
		.empty-state__btn *,
		.pagination-wrapper .page-link,
		.pagination-wrapper .page-link * {
			transition: none !important;
		}
	}
</style>
@endonce

<div class="row member-dashboard-grid" id="cancel-row">
	<div class="col-12 layout-top-spacing layout-spacing dashboard-card-column">
		<section class="kelas-anda-page" aria-labelledby="kelas-anda-title">
			<header class="kelas-anda-page__header">
				<h1 class="kelas-anda-page__title" id="kelas-anda-title">Kelas Anda</h1>
				<p class="kelas-anda-page__subtitle">Kelola dan akses semua kelas yang telah Anda beli</p>
			</header>

			@include('membernonkeanggotaan.components.ui.class-summary', [
			'totalCount' => $totalCount,
			'activeCount' => $activeCount,
			'completedCount' => $completedCount,
			])

			<nav class="tabs-nav" role="tablist" aria-label="Filter status kelas">
				<button
					role="tab"
					aria-selected="{{ $activeTab === 'active' }}"
					aria-controls="active-panel"
					id="tab-active"
					class="tabs-nav__item {{ $activeTab === 'active' ? 'tabs-nav__item--active' : '' }}"
					onclick="switchTab('active')">
					Sedang Berjalan
					<span class="tabs-nav__count">{{ $activeCount }}</span>
				</button>
				<button
					role="tab"
					aria-selected="{{ $activeTab === 'completed' }}"
					aria-controls="completed-panel"
					id="tab-completed"
					class="tabs-nav__item {{ $activeTab === 'completed' ? 'tabs-nav__item--active' : '' }}"
					onclick="switchTab('completed')">
					Selesai
					<span class="tabs-nav__count">{{ $completedCount }}</span>
				</button>
			</nav>

			<div role="tabpanel" id="active-panel" aria-labelledby="tab-active" class="tab-panel {{ $activeTab === 'active' ? '' : 'hidden' }}">
				@if($activeClasses->count() > 0)
				<div class="course-grid" role="list" aria-label="Daftar kelas sedang berjalan">
					@foreach($activeClasses as $course)
					@include('membernonkeanggotaan.components.ui.my-course-card', [
					'course' => $course,
					])
					@endforeach
				</div>

				<div class="pagination-wrapper">
					{{ $activeClasses->appends(['tab' => 'active'])->links() }}
				</div>
				@else
				<div class="empty-state" role="status">
					<div class="empty-state__icon" aria-hidden="true">
						<i class="fas fa-play-circle"></i>
					</div>
					<h3 class="empty-state__title">Belum ada kelas berjalan</h3>
					<p class="empty-state__text">Anda belum memiliki kelas yang sedang berlangsung saat ini.</p>
					<a href="/kelas" class="empty-state__btn">
						<i class="fas fa-plus"></i>
						Temukan Kelas
					</a>
				</div>
				@endif
			</div>

			<div role="tabpanel" id="completed-panel" aria-labelledby="tab-completed" class="tab-panel {{ $activeTab === 'completed' ? '' : 'hidden' }}">
				@if($completedClasses->count() > 0)
				<div class="course-grid" role="list" aria-label="Daftar kelas selesai">
					@foreach($completedClasses as $course)
					@include('membernonkeanggotaan.components.ui.my-course-card', [
					'course' => $course,
					])
					@endforeach
				</div>

				<div class="pagination-wrapper">
					{{ $completedClasses->appends(['tab' => 'completed'])->links() }}
				</div>
				@else
				<div class="empty-state" role="status">
					<div class="empty-state__icon" aria-hidden="true">
						<i class="fas fa-check-circle"></i>
					</div>
					<h3 class="empty-state__title">Belum ada kelas selesai</h3>
					<p class="empty-state__text">Kelas yang telah Anda selesaikan akan muncul di sini.</p>
					<a href="/event-kelas" class="empty-state__btn">
						<i class="fas fa-plus"></i>
						Temukan Kelas
					</a>
				</div>
				@endif
			</div>
		</section>
	</div>
</div>

@push('scripts')
<script>
	function switchTab(tab) {
		const url = new URL(window.location.href);
		url.searchParams.set('tab', tab);
		window.history.pushState({}, '', url);

		document.querySelectorAll('.tab-panel').forEach(panel => {
			panel.classList.add('hidden');
		});
		document.querySelectorAll('.tabs-nav__item').forEach(btn => {
			btn.classList.remove('tabs-nav__item--active');
			btn.setAttribute('aria-selected', 'false');
		});

		const activePanel = document.getElementById(tab + '-panel');
		const activeTab = document.getElementById('tab-' + tab);

		if (activePanel) activePanel.classList.remove('hidden');
		if (activeTab) {
			activeTab.classList.add('tabs-nav__item--active');
			activeTab.setAttribute('aria-selected', 'true');
		}

		if (tab === 'active') {
			@if($activeTab !== 'active')
			window.location.href = '{{ url()->current() }}?tab=active';
			@endif
		} else {
			@if($activeTab !== 'completed')
			window.location.href = '{{ url()->current() }}?tab=completed';
			@endif
		}
	}

	document.addEventListener('DOMContentLoaded', function() {
		const urlParams = new URLSearchParams(window.location.search);
		const tab = urlParams.get('tab') || '{{ $activeTab }}';

		if (tab === 'completed') {
			switchTab('completed');
		}
	});
</script>
@endpush
@endsection