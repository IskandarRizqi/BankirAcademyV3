@php
$chartData = $chart ?? [];
$chartId = data_get($chartData, 'id', 'learning-class-chart');
$categories = data_get($chartData, 'categories', ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun']);
$completedClasses = data_get($chartData, 'completed_classes', [1, 2, 2, 4, 5, 7]);
$learningHours = data_get($chartData, 'learning_hours', [8, 16, 21, 34, 42, 56]);
$averageScore = data_get($chartData, 'average_score', [72, 75, 78, 80, 83, 86]);
@endphp

@once
<style>
	.learning-class-chart-card {
		width: 100%;
		height: 100%;
		background: #ffffff;
		border: 1px solid #e5e7eb;
		border-radius: 10px;
		box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
		padding: 16px;
	}

	.learning-class-chart-card__header {
		display: flex;
		align-items: flex-start;
		justify-content: space-between;
		gap: 16px;
		margin-bottom: 5px;
	}

	.learning-class-chart-card__title {
		margin: 0;
		color: #111827;
		font-size: 20px;
		font-weight: 800;
		letter-spacing: -0.02em;
		line-height: 1.3;
	}

	.learning-class-chart-card__subtitle {
		margin: 6px 0 0;
		color: #6b7280;
		font-size: 13px;
		line-height: 1.6;
	}

	.learning-class-chart-card__badge {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		min-height: 30px;
		padding: 6px 10px;
		border-radius: 999px;
		background: var(--primary-soft, #EEF0FE);
		color: var(--primary, #4F46E5);
		font-size: 12px;
		font-weight: 800;
		white-space: nowrap;
	}

	.learning-class-chart-card__chart {
		min-height: 220px;
		max-height: 240px;
	}

	.learning-class-chart-card__fallback {
		display: none;
		padding: 14px;
		border-radius: 10px;
		background: #f9fafb;
		border: 1px solid #eef2f7;
		color: #4b5563;
		font-size: 13px;
		line-height: 1.6;
	}

	@media (max-width: 575.98px) {
		.learning-class-chart-card {
			padding: 16px;
		}

		.learning-class-chart-card__header {
			flex-direction: column;
			gap: 10px;
		}

		.learning-class-chart-card__chart {
			min-height: 200px;
			max-height: 220px;
		}
	}
</style>
@endonce

<section class="learning-class-chart-card" aria-labelledby="learning-class-chart-title">
	<div class="learning-class-chart-card__header">
		<div>
			<h2 class="learning-class-chart-card__title" id="learning-class-chart-title">Grafik Pembelajaran Kelas</h2>
		</div>
		<span class="learning-class-chart-card__badge">6 Bulan</span>
	</div>

	<div id="{{ $chartId }}" class="learning-class-chart-card__chart" aria-label="Grafik tren pembelajaran kelas"></div>
	<div id="{{ $chartId }}-fallback" class="learning-class-chart-card__fallback">Grafik belum dapat dimuat. Silakan muat ulang halaman.</div>
</section>

@push('scripts')
<script>
	document.addEventListener('DOMContentLoaded', function() {
		var chartElement = document.getElementById(@json($chartId));
		var fallbackElement = document.getElementById(@json($chartId.
			'-fallback'));

		if (!chartElement || typeof ApexCharts === 'undefined') {
			if (fallbackElement) {
				fallbackElement.style.display = 'block';
			}
			return;
		}

		var chart = new ApexCharts(chartElement, {
			chart: {
				type: 'line',
				height: 220,
				toolbar: {
					show: false
				},
				zoom: {
					enabled: false
				},
				fontFamily: 'Inter, sans-serif'
			},
			series: [{
					name: 'Kelas Selesai',
					data: @json($completedClasses)
				},
				{
					name: 'Jam Belajar',
					data: @json($learningHours)
				},
				{
					name: 'Avg Nilai',
					data: @json($averageScore)
				}
			],
			xaxis: {
				categories: @json($categories),
				labels: {
					style: {
						colors: '#6b7280',
						fontSize: '12px',
						fontWeight: 700
					}
				},
				axisBorder: {
					show: false
				},
				axisTicks: {
					show: false
				}
			},
			yaxis: {
				min: 0,
				labels: {
					style: {
						colors: '#6b7280',
						fontSize: '12px',
						fontWeight: 700
					}
				}
			},
			colors: ['#4F46E5', '#0891B2', '#10B981'],
			stroke: {
				curve: 'smooth',
				width: 3
			},
			markers: {
				size: 4,
				strokeWidth: 2,
				hover: {
					size: 6
				}
			},
			grid: {
				borderColor: '#eef2f7',
				strokeDashArray: 4,
				xaxis: {
					lines: {
						show: false
					}
				}
			},
			legend: {
				position: 'top',
				horizontalAlign: 'left',
				fontSize: '12px',
				fontWeight: 700,
				labels: {
					colors: '#374151'
				},
				markers: {
					width: 8,
					height: 8,
					radius: 8
				}
			},
			tooltip: {
				shared: true,
				intersect: false,
				y: {
					formatter: function(value, options) {
						if (options.seriesIndex === 0) {
							return value + ' kelas';
						}
						if (options.seriesIndex === 1) {
							return value + ' jam';
						}
						return value + '%';
					}
				}
			},
			responsive: [{
				breakpoint: 576,
				options: {
					chart: {
						height: 200
					},
					legend: {
						position: 'bottom'
					},
					stroke: {
						width: 2
					}
				}
			}]
		});

		chart.render();
	});
</script>
@endpush
