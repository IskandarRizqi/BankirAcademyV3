@php
	$filters = $filters ?? [];
	$selectedStatus = data_get($filters, 'status', 'semua');
	$startDate = data_get($filters, 'start_date');
	$endDate = data_get($filters, 'end_date');
	$statusOptions = [
		'semua' => 'Semua',
		'berhasil' => 'Lunas',
		'menunggu' => 'Menunggu',
		'dibatalkan' => 'Batal/Dibatalkan',
	];
@endphp

@once
<style>
	.billing-filter-card {
		width: 100%;
		padding: 14px;
		background: #ffffff;
		border: 1px solid #e5e7eb;
		border-radius: 12px;
		box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
	}

	.billing-filter-form {
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 12px;
		flex-wrap: wrap;
	}

	.billing-filter-badges {
		display: flex;
		align-items: center;
		gap: 8px;
		flex-wrap: wrap;
	}

	.billing-filter-badge {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		min-height: 34px;
		padding: 8px 12px;
		border: 1px solid #e5e7eb;
		border-radius: 999px;
		background: #f9fafb;
		color: #4b5563;
		font-size: 12px;
		font-weight: 800;
		line-height: 1;
		white-space: nowrap;
		transition: background .16s ease, border-color .16s ease, color .16s ease;
	}

	.billing-filter-badge:hover,
	.billing-filter-badge--active {
		background: var(--primary-soft, #eef0fe);
		border-color: var(--primary, #4f46e5);
		color: var(--primary, #4f46e5);
	}

	.billing-filter-date-range {
		display: flex;
		align-items: center;
		gap: 8px;
		flex-wrap: wrap;
		margin-left: auto;
	}

	.billing-filter-date-field {
		display: flex;
		align-items: center;
		gap: 6px;
		min-height: 34px;
		padding: 0 10px;
		border: 1px solid #e5e7eb;
		border-radius: 10px;
		background: #ffffff;
	}

	.billing-filter-date-field span {
		color: #6b7280;
		font-size: 12px;
		font-weight: 700;
		white-space: nowrap;
	}

	.billing-filter-date-field input {
		width: 132px;
		min-height: 32px;
		padding: 0;
		border: 0;
		background: transparent;
		color: #111827;
		font-size: 12px;
		font-weight: 700;
		outline: 0;
	}

	.billing-filter-submit {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		min-height: 34px;
		padding: 8px 14px;
		border: 0;
		border-radius: 10px;
		background: #111827;
		color: #ffffff;
		font-size: 12px;
		font-weight: 800;
		line-height: 1;
		cursor: pointer;
	}

	.billing-filter-submit:hover {
		background: var(--primary, #4f46e5);
	}

	@media (max-width: 991.98px) {
		.billing-filter-form,
		.billing-filter-date-range {
			align-items: stretch;
			width: 100%;
		}

		.billing-filter-date-range {
			margin-left: 0;
		}

		.billing-filter-date-field {
			flex: 1 1 180px;
		}

		.billing-filter-date-field input {
			width: 100%;
		}
	}

	@media (max-width: 575.98px) {
		.billing-filter-card {
			padding: 12px;
		}

		.billing-filter-badges,
		.billing-filter-date-range {
			gap: 6px;
		}

		.billing-filter-badge,
		.billing-filter-submit {
			flex: 1 1 calc(50% - 6px);
		}

		.billing-filter-date-field {
			flex: 1 1 100%;
		}
	}
</style>
@endonce

<section class="billing-filter-card" aria-label="Filter pembayaran">
	<form class="billing-filter-form" action="{{ url('/pembayaran') }}" method="GET">
		<input type="hidden" name="status" value="{{ $selectedStatus }}">

		<div class="billing-filter-badges" aria-label="Filter status pembayaran">
			@foreach($statusOptions as $statusValue => $statusLabel)
			<a
				href="{{ url('/pembayaran') . '?' . http_build_query(array_filter(['status' => $statusValue, 'start_date' => $startDate, 'end_date' => $endDate])) }}"
				class="billing-filter-badge {{ $selectedStatus === $statusValue ? 'billing-filter-badge--active' : '' }}"
			>
				{{ $statusLabel }}
			</a>
			@endforeach
		</div>

		<div class="billing-filter-date-range" aria-label="Filter rentang tanggal">
			<label class="billing-filter-date-field">
				<span>Dari</span>
				<input type="date" name="start_date" value="{{ $startDate }}">
			</label>

			<label class="billing-filter-date-field">
				<span>Sampai</span>
				<input type="date" name="end_date" value="{{ $endDate }}">
			</label>

			<button type="submit" class="billing-filter-submit">Terapkan</button>
		</div>
	</form>
</section>
