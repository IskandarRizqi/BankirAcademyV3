@php
	$overviewData = $overview ?? [];
	$title = data_get($overviewData, 'title', 'Overview Pembelajaran');
	$progress = max(0, min(100, (int) data_get($overviewData, 'progress', 15)));
	$metrics = [
		[
			'label' => 'Total Jam Belajar',
			'value' => data_get($overviewData, 'total_learning_hours', '120 Jam'),
			'active' => true,
		],
		[
			'label' => 'Avg Nilai',
			'value' => data_get($overviewData, 'average_score', '80%'),
			'active' => false,
		],
		[
			'label' => 'Kelas Selesai',
			'value' => data_get($overviewData, 'completed_classes', '4/10'),
			'active' => false,
		],
	];
@endphp

@once
<style>
	.learning-overview-card {
		width: 100%;
		height: 100%;
		background: #ffffff;
		border: 1px solid #e5e7eb;
		border-radius: 10px;
		box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
		padding: 16px;
	}

	.learning-overview-card__title {
		margin: 0;
		color: #111827;
		font-size: 20px;
		font-weight: 800;
		letter-spacing: -0.02em;
		line-height: 1.3;
	}

	.learning-overview-grid {
		display: grid;
		grid-template-columns: repeat(3, minmax(0, 1fr));
		gap: 12px;
	}

	.learning-overview-metric {
		min-height: 48px;
		padding: 8px 10px;
		background: #f9fafb;
		border: 1px solid #eef2f7;
		border-radius: 10px;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
	}

	.learning-overview-metric--active {
		background: var(--primary-soft, #EEF0FE);
		border-color: var(--primary-soft, #EEF0FE);
	}

	.learning-overview-metric--active .learning-overview-metric__label,
	.learning-overview-metric--active .learning-overview-metric__value {
		color: var(--primary, #4F46E5);
	}

	.learning-overview-metric__label {
		margin: 0;
		color: #4b5563;
		font-size: 12px;
		font-weight: 700;
		line-height: 1.4;
	}

	.learning-overview-metric__value {
		display: block;
		margin-top: 6px;
		color: #111827;
		font-size: 24px;
		font-weight: 800;
		letter-spacing: -0.03em;
		line-height: 1;
		font-variant-numeric: tabular-nums;
	}

	.learning-progress-summary {
		grid-column: span 2;
		min-height: 48px;
		padding: 8px 10px;
		background: #ffffff;
		border: 1px solid #eef2f7;
		border-radius: 10px;
		display: flex;
		flex-direction: column;
		justify-content: center;
	}

	.learning-progress-summary__header {
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 12px;
		margin-bottom: 8px;
	}

	.learning-progress-summary__label,
	.learning-progress-summary__value {
		color: #4b5563;
		font-size: 12px;
		font-weight: 700;
		line-height: 1.4;
	}

	.learning-progress-summary__track {
		height: 8px;
		background: #eef2f7;
		border-radius: 999px;
		overflow: hidden;
	}

	.learning-progress-summary__bar {
		width: var(--progress-value, 0%);
		height: 100%;
		background: var(--primary, #4F46E5);
		border-radius: inherit;
	}

	@media (max-width: 1199.98px) {
		.learning-overview-grid {
			grid-template-columns: repeat(2, minmax(0, 1fr));
		}
	}

	@media (max-width: 575.98px) {
		.learning-overview-card {
			padding: 18px;
		}

		.learning-overview-grid {
			grid-template-columns: 1fr;
		}

		.learning-overview-metric {
			min-height: 46px;
		}

		.learning-progress-summary {
			grid-column: auto;
		}
	}
</style>
@endonce

<section class="learning-overview-card" aria-labelledby="learning-overview-title">
	<h2 class="learning-overview-card__title" id="learning-overview-title">{{ $title }}</h2>

	<div class="learning-overview-grid mt-2" aria-label="Ringkasan pembelajaran">
		@foreach($metrics as $metric)
		<div class="learning-overview-metric {{ $metric['active'] ? 'learning-overview-metric--active' : '' }}">
			<div>
				<p class="learning-overview-metric__label">{{ $metric['label'] }}</p>
				<span class="learning-overview-metric__value">{{ $metric['value'] }}</span>
			</div>
		</div>
		@endforeach
	</div>

	<div class="learning-overview-grid mt-2" aria-label="Progress pembelajaran">
		<div class="learning-overview-metric">
			<div>
				<p class="learning-overview-metric__label">Sedang Berjalan</p>
				<span class="learning-overview-metric__value">{{ data_get($overviewData, 'running_classes', '2/10') }}</span>
			</div>
		</div>

		<div class="learning-progress-summary" aria-label="Progress sedang berjalan {{ $progress }} persen dari 100 persen">
			<div class="learning-progress-summary__header">
				<span class="learning-progress-summary__label">Progress</span>
				<span class="learning-progress-summary__value">{{ $progress }}%</span>
			</div>
			<div class="learning-progress-summary__track" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ $progress }}">
				<div class="learning-progress-summary__bar" style="--progress-value: {{ $progress }}%;"></div>
			</div>
		</div>
	</div>
</section>
