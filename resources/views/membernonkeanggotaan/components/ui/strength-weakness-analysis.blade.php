@php
$competencyAnalysis = $competencyAnalysis ?? [
['name' => 'Dasar Operasional Perbankan', 'status' => 'kuat'],
['name' => 'Layanan Nasabah', 'status' => 'kuat'],
['name' => 'Analisis Kredit Mikro', 'status' => 'perlu belajar lebih'],
['name' => 'Manajemen Risiko', 'status' => 'perlu belajar lebih'],
['name' => 'Kepatuhan & Anti Fraud', 'status' => 'kuat'],
];
@endphp

@once
<style>
	.strength-weakness-card {
		width: 100%;
		height: 100%;
		padding: 18px;
		background: #ffffff;
		border: 1px solid #e5e7eb;
		border-radius: 10px;
		box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
		display: flex;
		flex-direction: column;
		overflow: hidden;
		overflow-x: hidden;
	}

	.strength-weakness-card__list::-webkit-scrollbar {
		width: 6px;
	}

	.strength-weakness-card__list::-webkit-scrollbar-thumb {
		background: #d1d5db;
		border-radius: 999px;
	}

	.strength-weakness-card__list::-webkit-scrollbar-track {
		background: transparent;
	}

	.strength-weakness-card__title {
		margin: 0;
		color: #111827;
		font-size: 20px;
		font-weight: 800;
		letter-spacing: -0.02em;
		line-height: 1.3;
	}

	.strength-weakness-card__subtitle {
		margin: 6px 0 16px;
		color: #6b7280;
		font-size: 13px;
		line-height: 1.6;
	}

	.strength-weakness-card__list {
		display: grid;
		gap: 10px;
		margin: 0;
		padding: 0;
		list-style: none;
		min-height: 0;
		overflow-y: auto;
		overflow-x: hidden;
	}

	.strength-weakness-card__item {
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 12px;
		padding: 11px 12px;
		background: #f9fafb;
		border: 1px solid #eef2f7;
		border-radius: 10px;
	}

	.strength-weakness-card__competency {
		color: #374151;
		font-size: 13px;
		font-weight: 700;
		line-height: 1.4;
	}

	.strength-weakness-card__status {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		min-height: 28px;
		padding: 5px 10px;
		border-radius: 999px;
		font-size: 11.5px;
		font-weight: 800;
		line-height: 1.2;
		white-space: nowrap;
	}

	.strength-weakness-card__status--strong {
		background: #ecfdf5;
		color: #047857;
	}

	.strength-weakness-card__status--needs-work {
		background: #fff7ed;
		color: #c2410c;
	}

	@media (max-width: 575.98px) {
		.strength-weakness-card {
			padding: 16px;
		}

		.strength-weakness-card__item {
			align-items: flex-start;
			flex-direction: column;
		}
	}
</style>
@endonce

<section class="strength-weakness-card" aria-labelledby="strength-weakness-title">
	<h2 class="strength-weakness-card__title" id="strength-weakness-title">Analisis Kekuatan &amp; Kelemahan</h2>
	<ul class="strength-weakness-card__list" aria-label="Daftar analisis kompetensi">
		@foreach($competencyAnalysis as $competency)
		@php
		$isStrong = data_get($competency, 'status') === 'kuat';
		@endphp
		<li class="strength-weakness-card__item">
			<span class="strength-weakness-card__competency">{{ data_get($competency, 'name') }}</span>
			<span class="strength-weakness-card__status {{ $isStrong ? 'strength-weakness-card__status--strong' : 'strength-weakness-card__status--needs-work' }}">
				{{ $isStrong ? 'Kuat' : 'Perlu Belajar Lebih' }}
			</span>
		</li>
		@endforeach
	</ul>
</section>
