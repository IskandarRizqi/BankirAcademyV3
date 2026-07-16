@php
	$allowedVariants = ['primary', 'success', 'warning', 'danger'];
	$variant = in_array($variant ?? 'primary', $allowedVariants, true) ? $variant : 'primary';
	$icon = $icon ?? 'fas fa-receipt';
	$title = $title ?? 'Informasi Billing';
	$value = $value ?? '0';
	$description = $description ?? null;
@endphp

@once
<style>
	.billing-summary-card {
		width: 100%;
		min-height: 118px;
		padding: 14px;
		background: #ffffff;
		border: 1px solid #e5e7eb;
		border-radius: 12px;
		box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		gap: 10px;
	}

	.billing-summary-card__header {
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 12px;
	}

	.billing-summary-card__title {
		margin: 0;
		color: #4b5563;
		font-size: 13px;
		font-weight: 800;
		line-height: 1.4;
	}

	.billing-summary-card__icon {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 32px;
		height: 32px;
		border-radius: 8px;
		background: var(--billing-card-soft);
		color: var(--billing-card-accent);
		font-size: 14px;
		flex: 0 0 auto;
	}

	.billing-summary-card__value {
		display: block;
		color: #111827;
		font-size: 23px;
		font-weight: 800;
		letter-spacing: -0.03em;
		line-height: 1.1;
		font-variant-numeric: tabular-nums;
	}

	.billing-summary-card__description {
		margin: 4px 0 0;
		color: #6b7280;
		font-size: 11px;
		font-weight: 600;
		line-height: 1.5;
	}

	.billing-summary-card--primary {
		--billing-card-accent: #4f46e5;
		--billing-card-soft: #eef0fe;
	}

	.billing-summary-card--success {
		--billing-card-accent: #047857;
		--billing-card-soft: #ecfdf5;
	}

	.billing-summary-card--warning {
		--billing-card-accent: #b45309;
		--billing-card-soft: #fffbeb;
	}

	.billing-summary-card--danger {
		--billing-card-accent: #b91c1c;
		--billing-card-soft: #fef2f2;
	}

	@media (max-width: 575.98px) {
		.billing-summary-card {
			min-height: 112px;
			padding: 12px;
		}

		.billing-summary-card__value {
			font-size: 22px;
		}
	}
</style>
@endonce

<article class="billing-summary-card billing-summary-card--{{ $variant }}" aria-label="{{ $title }}">
	<div class="billing-summary-card__header">
		<p class="billing-summary-card__title">{{ $title }}</p>
		<span class="billing-summary-card__icon" aria-hidden="true">
			<i class="{{ $icon }}"></i>
		</span>
	</div>

	<div>
		<strong class="billing-summary-card__value">{{ $value }}</strong>
		@if($description)
		<p class="billing-summary-card__description">{{ $description }}</p>
		@endif
	</div>
</article>
