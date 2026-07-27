@once
<style>
	.membership-individual-modal .modal-content {
		border: 0;
		border-radius: 18px;
		overflow: hidden;
		box-shadow: 0 24px 70px rgba(15, 23, 42, .22);
	}

	.membership-individual-modal .modal-header {
		padding: 20px 22px 0;
		border-bottom: 0;
	}

	.membership-individual-modal__title {
		margin: 0;
		color: #111827;
		font-size: 20px;
		font-weight: 800;
		letter-spacing: -0.02em;
		line-height: 1.3;
	}

	.membership-individual-modal .modal-body {
		padding: 22px;
		background: #ffffff;
	}

	.membership-individual-card {
		border: 1px solid #e5e7eb;
		border-radius: 16px;
		background: linear-gradient(180deg, #f8faff 0%, #ffffff 42%);
		box-shadow: 0 14px 32px rgba(15, 23, 42, .08);
		overflow: hidden;
	}

	.membership-individual-card__header {
		display: flex;
		align-items: flex-start;
		justify-content: space-between;
		gap: 20px;
		padding: 20px;
		border-bottom: 1px solid #e5e7eb;
	}

	.membership-individual-card__eyebrow {
		margin: 0 0 6px;
		color: #4f46e5;
		font-size: 11px;
		font-weight: 800;
		letter-spacing: .06em;
		text-transform: uppercase;
	}

	.membership-individual-card__name {
		margin: 0;
		color: #111827;
		font-size: 24px;
		font-weight: 900;
		letter-spacing: -.03em;
		line-height: 1.2;
	}

	.membership-individual-card__description {
		max-width: 560px;
		margin: 8px 0 0;
		color: #6b7280;
		font-size: 13px;
		line-height: 1.6;
	}

	.membership-individual-card__price {
		flex: 0 0 auto;
		color: #111827;
		font-size: 24px;
		font-weight: 900;
		line-height: 1.2;
		text-align: right;
		white-space: nowrap;
	}

	.membership-individual-card__price small {
		color: #6b7280;
		font-size: 12px;
		font-weight: 700;
	}

	.membership-individual-card__comparison {
		display: grid;
		gap: 8px;
		padding: 16px 20px 20px;
	}

	.membership-individual-card__comparison-row {
		display: grid;
		grid-template-columns: minmax(0, 1.7fr) minmax(120px, 1fr) minmax(120px, 1fr);
		gap: 12px;
		align-items: center;
		padding: 11px 12px;
		border: 1px solid #eef2f7;
		border-radius: 10px;
		background: #ffffff;
	}

	.membership-individual-card__comparison-row--header {
		padding-top: 4px;
		padding-bottom: 4px;
		border: 0;
		background: transparent;
		color: #6b7280;
		font-size: 11px;
		font-weight: 800;
		letter-spacing: .04em;
		text-transform: uppercase;
	}

	.membership-individual-card__feature {
		color: #374151;
		font-size: 13px;
		font-weight: 700;
		line-height: 1.45;
	}

	.membership-individual-card__value {
		color: #6b7280;
		font-size: 12px;
		font-weight: 700;
		line-height: 1.45;
	}

	.membership-individual-card__value--member {
		color: #047857;
	}

	.membership-individual-card__mobile-label {
		display: none;
		margin-bottom: 2px;
		color: #9ca3af;
		font-size: 10px;
		font-weight: 800;
		letter-spacing: .04em;
		text-transform: uppercase;
	}

	.membership-individual-card__note {
		margin: 0;
		padding: 0 20px 20px;
		color: #6b7280;
		font-size: 11px;
		line-height: 1.5;
		text-align: center;
	}

	@media (max-width: 575.98px) {
		.membership-individual-modal .modal-header,
		.membership-individual-modal .modal-body {
			padding-left: 16px;
			padding-right: 16px;
		}

		.membership-individual-card__header {
			flex-direction: column;
			gap: 12px;
		}

		.membership-individual-card__price {
			text-align: left;
		}

		.membership-individual-card__comparison {
			padding: 12px;
		}

		.membership-individual-card__comparison-row--header {
			display: none;
		}

		.membership-individual-card__comparison-row {
			grid-template-columns: repeat(2, minmax(0, 1fr));
			gap: 12px;
			padding: 12px;
		}

		.membership-individual-card__feature {
			grid-column: 1 / -1;
		}

		.membership-individual-card__mobile-label {
			display: block;
		}

		.membership-individual-card__note {
			padding-right: 12px;
			padding-bottom: 16px;
			padding-left: 12px;
		}
	}
</style>
@endonce

<div class="modal fade membership-individual-modal" id="membershipIndividualModal" tabindex="-1" role="dialog" aria-labelledby="membershipIndividualModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="membership-individual-modal__title" id="membershipIndividualModalTitle">Member Perorangan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<article class="membership-individual-card" aria-labelledby="membershipIndividualCardTitle">
					<header class="membership-individual-card__header">
						<div>
							<p class="membership-individual-card__eyebrow">Membership Personal</p>
							<h2 class="membership-individual-card__name" id="membershipIndividualCardTitle">Member Perorangan</h2>
							<p class="membership-individual-card__description">Akses fasilitas karier, komunitas, dan pembelajaran eksklusif untuk kebutuhan pengembangan diri.</p>
						</div>
						<div class="membership-individual-card__price">Rp299.000,- <small>/tahun</small></div>
					</header>

					<div class="membership-individual-card__comparison" role="table" aria-label="Perbandingan fasilitas member perorangan">
						<div class="membership-individual-card__comparison-row membership-individual-card__comparison-row--header" role="row">
							<div role="columnheader">Fasilitas</div>
							<div role="columnheader">Non member</div>
							<div role="columnheader">Member</div>
						</div>

						<div class="membership-individual-card__comparison-row" role="row">
							<div class="membership-individual-card__feature" role="rowheader">Informasi lowongan umum</div>
							<div class="membership-individual-card__value" role="cell"><span class="membership-individual-card__mobile-label">Non member</span>Terbatas</div>
							<div class="membership-individual-card__value membership-individual-card__value--member" role="cell"><span class="membership-individual-card__mobile-label">Member</span>Ya</div>
						</div>
						<div class="membership-individual-card__comparison-row" role="row">
							<div class="membership-individual-card__feature" role="rowheader">Lowongan eksklusif mitra</div>
							<div class="membership-individual-card__value" role="cell"><span class="membership-individual-card__mobile-label">Non member</span>Tidak</div>
							<div class="membership-individual-card__value membership-individual-card__value--member" role="cell"><span class="membership-individual-card__mobile-label">Member</span>Ya</div>
						</div>
						<div class="membership-individual-card__comparison-row" role="row">
							<div class="membership-individual-card__feature" role="rowheader">Diskon kelas</div>
							<div class="membership-individual-card__value" role="cell"><span class="membership-individual-card__mobile-label">Non member</span>Tidak ada</div>
							<div class="membership-individual-card__value membership-individual-card__value--member" role="cell"><span class="membership-individual-card__mobile-label">Member</span>15%</div>
						</div>
						<div class="membership-individual-card__comparison-row" role="row">
							<div class="membership-individual-card__feature" role="rowheader">E-book gratis</div>
							<div class="membership-individual-card__value" role="cell"><span class="membership-individual-card__mobile-label">Non member</span>Terbatas</div>
							<div class="membership-individual-card__value membership-individual-card__value--member" role="cell"><span class="membership-individual-card__mobile-label">Member</span>Ya</div>
						</div>
						<div class="membership-individual-card__comparison-row" role="row">
							<div class="membership-individual-card__feature" role="rowheader">Konsultasi karier melalui chat</div>
							<div class="membership-individual-card__value" role="cell"><span class="membership-individual-card__mobile-label">Non member</span>Berbayar</div>
							<div class="membership-individual-card__value membership-individual-card__value--member" role="cell"><span class="membership-individual-card__mobile-label">Member</span>Termasuk sesuai kuota</div>
						</div>
						<div class="membership-individual-card__comparison-row" role="row">
							<div class="membership-individual-card__feature" role="rowheader">Template CV ATS</div>
							<div class="membership-individual-card__value" role="cell"><span class="membership-individual-card__mobile-label">Non member</span>Berbayar</div>
							<div class="membership-individual-card__value membership-individual-card__value--member" role="cell"><span class="membership-individual-card__mobile-label">Member</span>Gratis</div>
						</div>
						<div class="membership-individual-card__comparison-row" role="row">
							<div class="membership-individual-card__feature" role="rowheader">Review CV</div>
							<div class="membership-individual-card__value" role="cell"><span class="membership-individual-card__mobile-label">Non member</span>Berbayar</div>
							<div class="membership-individual-card__value membership-individual-card__value--member" role="cell"><span class="membership-individual-card__mobile-label">Member</span>Gratis</div>
						</div>
						<div class="membership-individual-card__comparison-row" role="row">
							<div class="membership-individual-card__feature" role="rowheader">Grup komunitas</div>
							<div class="membership-individual-card__value" role="cell"><span class="membership-individual-card__mobile-label">Non member</span>Tidak</div>
							<div class="membership-individual-card__value membership-individual-card__value--member" role="cell"><span class="membership-individual-card__mobile-label">Member</span>Ya</div>
						</div>
						<div class="membership-individual-card__comparison-row" role="row">
							<div class="membership-individual-card__feature" role="rowheader">Webinar eksklusif</div>
							<div class="membership-individual-card__value" role="cell"><span class="membership-individual-card__mobile-label">Non member</span>Tidak</div>
							<div class="membership-individual-card__value membership-individual-card__value--member" role="cell"><span class="membership-individual-card__mobile-label">Member</span>Ya</div>
						</div>
						<div class="membership-individual-card__comparison-row" role="row">
							<div class="membership-individual-card__feature" role="rowheader">Program afiliasi</div>
							<div class="membership-individual-card__value" role="cell"><span class="membership-individual-card__mobile-label">Non member</span>Tidak</div>
							<div class="membership-individual-card__value membership-individual-card__value--member" role="cell"><span class="membership-individual-card__mobile-label">Member</span>Ya</div>
						</div>
						<div class="membership-individual-card__comparison-row" role="row">
							<div class="membership-individual-card__feature" role="rowheader">Talent pool</div>
							<div class="membership-individual-card__value" role="cell"><span class="membership-individual-card__mobile-label">Non member</span>Tidak</div>
							<div class="membership-individual-card__value membership-individual-card__value--member" role="cell"><span class="membership-individual-card__mobile-label">Member</span>Ya</div>
						</div>
						<div class="membership-individual-card__comparison-row" role="row">
							<div class="membership-individual-card__feature" role="rowheader">Prioritas bootcamp</div>
							<div class="membership-individual-card__value" role="cell"><span class="membership-individual-card__mobile-label">Non member</span>Tidak</div>
							<div class="membership-individual-card__value membership-individual-card__value--member" role="cell"><span class="membership-individual-card__mobile-label">Member</span>Ya</div>
						</div>
						<div class="membership-individual-card__comparison-row" role="row">
							<div class="membership-individual-card__feature" role="rowheader">Member point</div>
							<div class="membership-individual-card__value" role="cell"><span class="membership-individual-card__mobile-label">Non member</span>Tidak</div>
							<div class="membership-individual-card__value membership-individual-card__value--member" role="cell"><span class="membership-individual-card__mobile-label">Member</span>Ya</div>
						</div>
						<div class="membership-individual-card__comparison-row" role="row">
							<div class="membership-individual-card__feature" role="rowheader">Mentoring</div>
							<div class="membership-individual-card__value" role="cell"><span class="membership-individual-card__mobile-label">Non member</span>Harga normal</div>
							<div class="membership-individual-card__value membership-individual-card__value--member" role="cell"><span class="membership-individual-card__mobile-label">Member</span>Harga khusus</div>
						</div>
						<div class="membership-individual-card__comparison-row" role="row">
							<div class="membership-individual-card__feature" role="rowheader">Kartu member digital</div>
							<div class="membership-individual-card__value" role="cell"><span class="membership-individual-card__mobile-label">Non member</span>Tidak</div>
							<div class="membership-individual-card__value membership-individual-card__value--member" role="cell"><span class="membership-individual-card__mobile-label">Member</span>Ya</div>
						</div>
					</div>

					<p class="membership-individual-card__note">Fasilitas member berlaku sesuai syarat dan kuota yang ditetapkan Bankir Academy.</p>
				</article>
			</div>
		</div>
	</div>
</div>
