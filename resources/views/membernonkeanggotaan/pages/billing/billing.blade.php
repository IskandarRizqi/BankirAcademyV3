@extends('layouts.appmembernonanggota')
@section('content')
@php
	$summary = $billingSummary ?? [];
	$billingCards = [
		[
			'title' => 'Pembayaran lunas',
			'value' => data_get($summary, 'paid_count', 0),
			'description' => 'Transaksi berhasil dibayar',
			'icon' => 'fas fa-check-circle',
			'variant' => 'success',
		],
		[
			'title' => 'Pembayaran pending',
			'value' => data_get($summary, 'pending_count', 0),
			'description' => 'Menunggu pembayaran atau konfirmasi',
			'icon' => 'fas fa-clock',
			'variant' => 'warning',
		],
		[
			'title' => 'Pembayaran gagal',
			'value' => data_get($summary, 'failed_count', 0),
			'description' => 'Transaksi batal atau kedaluwarsa',
			'icon' => 'fas fa-times-circle',
			'variant' => 'danger',
		],
	];
@endphp

@once
<style>
	.billing-summary-grid {
		row-gap: 24px;
	}

	.billing-summary-column {
		display: flex;
	}

	.billing-filter-section {
		margin-top: 24px;
	}

	.billing-history-section {
		margin-top: 22px;
	}

	.billing-history-header {
		display: flex;
		align-items: flex-end;
		justify-content: space-between;
		gap: 14px;
		margin-bottom: 14px;
	}

	.billing-history-header h2 {
		margin: 0;
		color: #111827;
		font-size: 20px;
		font-weight: 900;
		letter-spacing: -0.03em;
	}

	.billing-history-header p {
		margin: 4px 0 0;
		color: #6b7280;
		font-size: 13px;
	}

	.billing-history-count {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		padding: 8px 12px;
		border-radius: 999px;
		background: var(--primary-soft, #eef0fe);
		color: var(--primary, #4f46e5);
		font-size: 12px;
		font-weight: 850;
		white-space: nowrap;
	}

	.billing-history-list {
		display: flex;
		flex-direction: column;
		gap: 12px;
	}

	.billing-history-card {
		display: flex;
		flex-direction: column;
		gap: 12px;
		padding: 14px;
		border: 1px solid #e5e7eb;
		border-radius: 14px;
		background: #ffffff;
		box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
	}

	.billing-history-card__top {
		display: flex;
		align-items: stretch;
		gap: 14px;
	}

	.billing-history-card__media {
		width: 74px;
		height: 74px;
		border-radius: 12px;
		background: #f9fafb;
		border: 1px solid #eef2f7;
		overflow: hidden;
		flex: 0 0 auto;
	}

	.billing-history-card__media img {
		width: 100%;
		height: 100%;
		object-fit: cover;
	}

	.billing-history-card__main {
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 16px;
		min-width: 0;
		flex: 1;
	}

	.billing-history-card__meta-row {
		display: flex;
		align-items: center;
		gap: 8px;
		flex-wrap: wrap;
		margin-bottom: 6px;
	}

	.billing-history-type {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		min-height: 24px;
		padding: 5px 9px;
		border-radius: 999px;
		font-size: 11px;
		font-weight: 850;
		line-height: 1;
	}

	.billing-history-type--class {
		background: #eef0fe;
		color: #4f46e5;
	}

	.billing-history-type--membership {
		background: #ecfdf5;
		color: #047857;
	}

	.billing-history-type:not(.billing-history-type--class):not(.billing-history-type--membership) {
		background: #f3f4f6;
		color: #4b5563;
	}

	.billing-history-card__title {
		margin: 0;
		color: #111827;
		font-size: 15px;
		font-weight: 900;
		line-height: 1.35;
	}

	.billing-history-card__invoice {
		margin: 4px 0 0;
		color: #6b7280;
		font-size: 12px;
		font-weight: 700;
	}

	.billing-history-card__divider {
		width: 100%;
		margin: 0;
		border: 0;
		border-top: 1px solid #eef2f7;
	}

	.billing-history-card__footer {
		display: flex;
		align-items: flex-start;
		justify-content: space-between;
		gap: 18px;
		flex-wrap: wrap;
	}

	.billing-history-card__footer-info {
		display: flex;
		align-items: flex-start;
		gap: 36px;
		flex-wrap: wrap;
	}

	.billing-history-card__payment-info span,
	.billing-history-card__order-date span {
		display: block;
		color: #6b7280;
		font-size: 12px;
		font-weight: 800;
		line-height: 1.4;
	}

	.billing-history-card__payment-info strong,
	.billing-history-card__order-date strong {
		display: block;
		margin-top: 2px;
		color: #111827;
		font-size: 13px;
		font-weight: 850;
		line-height: 1.45;
	}

	.billing-history-card__payment-info strong.is-success {
		color: #047857;
	}

	.billing-history-card__payment-info strong.is-danger {
		color: #b91c1c;
	}

	.billing-history-card__order-date {
		text-align: left;
	}

	.billing-history-card__actions {
		display: flex;
		align-items: center;
		justify-content: flex-end;
		margin-left: auto;
	}

	.billing-history-action {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		gap: 7px;
		min-height: 34px;
		padding: 9px 13px;
		border-radius: 10px;
		font-size: 12px;
		font-weight: 850;
		line-height: 1;
		white-space: nowrap;
	}

	.billing-history-action--invoice {
		background: #ecfdf5;
		color: #047857;
	}

	.billing-history-action--invoice:hover {
		background: #d1fae5;
		color: #065f46;
	}

	.billing-history-action--pay {
		background: var(--primary, #4f46e5);
		color: #ffffff;
	}

	.billing-history-action--pay:hover {
		background: var(--primary-dark, #3d33d8);
		color: #ffffff;
	}

	.billing-history-card__amount {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		text-align: center;
		white-space: nowrap;
	}

	.billing-history-card__amount span {
		display: block;
		color: #6b7280;
		font-size: 11px;
		font-weight: 800;
		line-height: 1.4;
	}

	.billing-history-card__amount strong {
		display: block;
		margin-top: 3px;
		color: #111827;
		font-size: 17px;
		font-weight: 900;
		letter-spacing: -0.03em;
	}

	.billing-history-empty {
		padding: 34px 20px;
		border: 1px dashed #cbd5e1;
		border-radius: 14px;
		background: #ffffff;
		text-align: center;
	}

	.billing-history-empty h3 {
		margin: 0;
		color: #111827;
		font-size: 18px;
		font-weight: 900;
	}

	.billing-history-empty p {
		margin: 8px auto 0;
		max-width: 460px;
		color: #6b7280;
		font-size: 13px;
		line-height: 1.6;
	}

	.billing-history-loader {
		display: flex;
		justify-content: center;
		margin-top: 18px;
		min-height: 42px;
	}

	.billing-history-load-more {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		min-height: 40px;
		padding: 10px 18px;
		border: 0;
		border-radius: 999px;
		background: var(--primary-soft, #eef0fe);
		color: var(--primary, #4f46e5);
		font-size: 13px;
		font-weight: 850;
		cursor: pointer;
	}

	.billing-history-load-more:disabled {
		cursor: wait;
		opacity: .72;
	}

	.billing-history-load-more[hidden] {
		display: none;
	}

	.billing-history-load-status {
		align-self: center;
		color: #6b7280;
		font-size: 13px;
		font-weight: 700;
	}

	@media (max-width: 767.98px) {
		.billing-history-header,
		.billing-history-card__main {
			align-items: flex-start;
			flex-direction: column;
		}

		.billing-history-card__amount {
			text-align: center;
			white-space: normal;
		}

		.billing-history-card__footer,
		.billing-history-card__footer-info {
			gap: 18px;
		}

		.billing-history-card__actions {
			width: 100%;
			justify-content: flex-start;
			margin-left: 0;
		}
	}

	@media (max-width: 575.98px) {
		.billing-history-card {
			padding: 12px;
		}

		.billing-history-card__top {
			gap: 12px;
		}

		.billing-history-card__media {
			width: 62px;
			height: 62px;
		}
	}
</style>
@endonce

<div class="row billing-summary-grid" id="cancel-row">
	@foreach($billingCards as $card)
	<div class="col-xl-4 col-md-6 col-12 layout-top-spacing layout-spacing billing-summary-column">
		@include('membernonkeanggotaan.components.ui.billing-summary-card', $card)
	</div>
	@endforeach
</div>

<div class="billing-filter-section">
	@include('membernonkeanggotaan.components.ui.billing-filter', ['filters' => $billingFilters ?? []])
</div>

<section class="billing-history-section" aria-labelledby="billing-history-title">
	<div class="billing-history-header">
		<div>
			<h2 id="billing-history-title">Histori Pembayaran</h2>
			<p>Daftar transaksi membership dan kelas yang pernah Anda order.</p>
		</div>
		@if(method_exists($paymentHistories, 'total'))
		<span class="billing-history-count">{{ $paymentHistories->total() }} transaksi</span>
		@endif
	</div>

	@if($paymentHistories->count() > 0)
	<div class="billing-history-list" id="billingHistoryList">
		@include('membernonkeanggotaan.components.ui.billing-history-items', ['paymentHistories' => $paymentHistories])
	</div>

	@if(method_exists($paymentHistories, 'hasPages') && $paymentHistories->hasPages())
	<div class="billing-history-loader" id="billingHistoryLoader" data-next-url="{{ $paymentHistories->nextPageUrl() }}">
		<button type="button" class="billing-history-load-more" id="billingHistoryLoadMoreButton">Muat histori lainnya</button>
		<span class="billing-history-load-status" id="billingHistoryLoadStatus" hidden>Memuat histori...</span>
	</div>
	@endif
	@else
	<div class="billing-history-empty">
		<h3>Belum ada histori pembayaran</h3>
		<p>Ubah filter status atau rentang tanggal untuk mencari transaksi pembayaran lainnya.</p>
	</div>
	@endif
</section>
@endsection

@push('scripts')
<script>
	(function() {
		const list = document.getElementById('billingHistoryList');
		const loader = document.getElementById('billingHistoryLoader');
		const loadMoreButton = document.getElementById('billingHistoryLoadMoreButton');
		const loadStatus = document.getElementById('billingHistoryLoadStatus');

		if (!list || !loader || !loadMoreButton || !loadStatus) {
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
					throw new Error('Gagal memuat histori pembayaran.');
				}

				const payload = await response.json();
				list.insertAdjacentHTML('beforeend', payload.html || '');
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
				rootMargin: '320px 0px'
			});

			observer.observe(loader);
		}
	})();

	(function() {
		const pendingStatus = '2';

		function pad(value) {
			return String(value).padStart(2, '0');
		}

		function formatRemaining(milliseconds) {
			const totalSeconds = Math.max(0, Math.floor(milliseconds / 1000));
			const days = Math.floor(totalSeconds / 86400);
			const hours = Math.floor((totalSeconds % 86400) / 3600);
			const minutes = Math.floor((totalSeconds % 3600) / 60);
			const seconds = totalSeconds % 60;

			if (days > 0) {
				return days + ' hari ' + pad(hours) + ':' + pad(minutes) + ':' + pad(seconds);
			}

			return pad(hours) + ':' + pad(minutes) + ':' + pad(seconds);
		}

		function updatePaymentActions() {
			document.querySelectorAll('[data-payment-action]').forEach(function(action) {
				const expiresAt = new Date(action.dataset.expiresAt).getTime();

				if (expiresAt && expiresAt <= Date.now()) {
					action.remove();
				}
			});
		}

		async function expirePayment(element) {
			if (element.dataset.expireRequested === '1') {
				return;
			}

			element.dataset.expireRequested = '1';

			try {
				const response = await fetch(element.dataset.expireUrl, {
					method: 'POST',
					headers: {
						'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
						'X-Requested-With': 'XMLHttpRequest',
						'Accept': 'application/json'
					},
					credentials: 'same-origin'
				});

				if (!response.ok) {
					throw new Error('Gagal memperbarui status pembayaran.');
				}

				const payload = await response.json();

				element.dataset.status = String(payload.status);

				if (element.dataset.status === pendingStatus) {
					element.dataset.expireRequested = '0';
				}
			} catch (error) {
				element.dataset.expireRequested = '0';
			}
		}

		function updateCountdowns() {
			document.querySelectorAll('.billing-history-countdown').forEach(function(element) {
				element.classList.remove('is-success', 'is-danger');

				if (element.dataset.status !== pendingStatus) {
					element.textContent = element.dataset.status === '1' ? 'Lunas' : 'Batal/Dibatalkan';
					element.classList.add(element.dataset.status === '1' ? 'is-success' : 'is-danger');
					return;
				}

				const expiresAt = new Date(element.dataset.expiresAt).getTime();

				if (!expiresAt) {
					element.textContent = '-';
					return;
				}

				const remaining = expiresAt - Date.now();

				if (remaining > 0) {
					element.textContent = formatRemaining(remaining);
					return;
				}

				element.textContent = 'Batal/Dibatalkan';
				element.classList.add('is-danger');
				expirePayment(element);
			});

			updatePaymentActions();
		}

		updateCountdowns();
		window.setInterval(updateCountdowns, 1000);
	})();
</script>
@endpush
