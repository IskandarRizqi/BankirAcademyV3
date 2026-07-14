@once
<style>
	.membership-package-modal .modal-content {
		border: 0;
		border-radius: 18px;
		overflow: hidden;
		box-shadow: 0 24px 70px rgba(15, 23, 42, .22);
	}

	.membership-package-modal .modal-header {
		padding: 20px 22px 0;
		border-bottom: 0;
	}

	.membership-package-modal__title {
		margin: 0;
		color: #111827;
		font-size: 20px;
		font-weight: 800;
		letter-spacing: -0.02em;
		line-height: 1.3;
	}

	.membership-package-modal__subtitle {
		margin: 6px 0 0;
		color: #6b7280;
		font-size: 13px;
		line-height: 1.6;
	}

	.membership-package-modal .modal-body {
		padding: 22px;
	}

	.membership-package-grid {
		display: grid;
		grid-template-columns: repeat(2, minmax(0, 1fr));
		gap: 16px;
	}

	.membership-package-card {
		display: flex;
		flex-direction: column;
		min-height: 100%;
		padding: 18px;
		border: 1px solid #e5e7eb;
		border-radius: 14px;
		background: #ffffff;
	}

	.membership-package-card--featured {
		border-color: #facc15;
		background: linear-gradient(180deg, #fffbeb 0%, #ffffff 52%);
		box-shadow: 0 14px 32px rgba(184, 134, 11, .12);
	}

	.membership-package-card__badge {
		display: inline-flex;
		align-items: center;
		width: fit-content;
		min-height: 28px;
		padding: 5px 10px;
		border-radius: 999px;
		background: #f3f4f6;
		color: #4b5563;
		font-size: 11px;
		font-weight: 800;
		letter-spacing: .03em;
		text-transform: uppercase;
	}

	.membership-package-card__badge--featured {
		background: #fef3c7;
		color: #92400e;
	}

	.membership-package-card__name {
		margin: 14px 0 8px;
		color: #111827;
		font-size: 22px;
		font-weight: 800;
		letter-spacing: -0.03em;
		line-height: 1.2;
	}

	.membership-package-card__price {
		margin: 0;
		color: #111827;
		font-size: 26px;
		font-weight: 900;
		line-height: 1.15;
	}

	.membership-package-card__price-before {
		display: block;
		margin: 0 0 4px;
		color: #9ca3af;
		font-size: 14px;
		font-weight: 800;
		line-height: 1.2;
	}

	.membership-package-card__price small {
		color: #6b7280;
		font-size: 13px;
		font-weight: 700;
	}

	.membership-package-card__description {
		margin: 10px 0 16px;
		color: #6b7280;
		font-size: 13px;
		line-height: 1.6;
	}

	.membership-package-card__benefits {
		display: grid;
		gap: 10px;
		padding: 0;
		margin: 0 0 18px;
		list-style: none;
	}

	.membership-package-card__benefit {
		display: flex;
		align-items: flex-start;
		gap: 8px;
		color: #374151;
		font-size: 13px;
		font-weight: 600;
		line-height: 1.45;
	}

	.membership-package-card__benefit svg {
		width: 16px;
		height: 16px;
		margin-top: 1px;
		flex: 0 0 auto;
	}

	.membership-package-card__benefit--muted {
		color: #9ca3af;
	}

	.membership-package-card__benefit--available svg {
		color: #059669;
	}

	.membership-package-card__benefit--muted svg {
		color: #d97706;
	}

	.membership-package-card__divider {
		width: 100%;
		height: 1px;
		margin: 2px 0 14px;
		background: #e5e7eb;
	}

	.membership-package-card__notes {
		display: grid;
		gap: 9px;
		padding: 0;
		margin: 0 0 18px;
		list-style: none;
	}

	.membership-package-card__note {
		color: #4b5563;
		font-size: 11.5px;
		font-weight: 600;
		line-height: 1.45;
	}

	.membership-package-card__note del {
		color: #9ca3af;
		text-decoration-thickness: 1.5px;
	}

	.membership-package-card__note strong {
		color: #111827;
		font-weight: 800;
	}

	.membership-package-card__action {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 100%;
		min-height: 42px;
		margin-top: auto;
		padding: 10px 14px;
		border: 0;
		border-radius: 10px;
		background: #111827;
		color: #ffffff;
		font-size: 13px;
		font-weight: 800;
		transition: background .18s ease, transform .18s ease;
	}

	.membership-package-card__action:hover {
		background: var(--primary, #4F46E5);
		color: #ffffff;
		transform: translateY(-1px);
	}

	.membership-package-card__action[disabled] {
		background: #f3f4f6;
		color: #9ca3af;
		cursor: not-allowed;
		transform: none;
	}

	@media (max-width: 767.98px) {
		.membership-package-grid {
			grid-template-columns: 1fr;
		}
	}

	@media (max-width: 575.98px) {

		.membership-package-modal .modal-header,
		.membership-package-modal .modal-body {
			padding-left: 16px;
			padding-right: 16px;
		}
	}

	@media (prefers-reduced-motion: reduce) {
		.membership-package-card__action {
			transition: none;
		}

		.membership-package-card__action:hover {
			transform: none;
		}
	}
</style>
@endonce

<div class="modal fade membership-package-modal" id="membershipPackageModal" tabindex="-1" role="dialog" aria-labelledby="membershipPackageModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div>
					<h5 class="membership-package-modal__title" id="membershipPackageModalTitle">Pilih Paket Membership</h5>
					<p class="membership-package-modal__subtitle">Bandingkan manfaat non member dan member sebelum melanjutkan pendaftaran.</p>
				</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<div class="membership-package-grid">
					<article class="membership-package-card" aria-labelledby="non-member-package-title">
						<p class="membership-package-card__price">Rp0,- <small>/tahun</small></p>
						<h3 class="membership-package-card__name" id="non-member-package-title">Non Member</h3>
						<p class="membership-package-card__description">Akses dasar untuk mulai belajar dan mengikuti pelatihan pilihan.</p>

						<ul class="membership-package-card__benefits">
							<li class="membership-package-card__benefit membership-package-card__benefit--available">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
									<path d="M20 6 9 17l-5-5" />
								</svg>
								<span>Sertifikat Pelatihan (Digital)</span>
							</li>
							<li class="membership-package-card__benefit membership-package-card__benefit--muted">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
									<path d="M18 6 6 18" />
									<path d="m6 6 12 12" />
								</svg>
								<span>Aset Video Pembelajaran</span>
							</li>
							<li class="membership-package-card__benefit membership-package-card__benefit--muted">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
									<path d="M18 6 6 18" />
									<path d="m6 6 12 12" />
								</svg>
								<span>Akses Dokumen SOP Perbankan</span>
							</li>
							<li class="membership-package-card__benefit membership-package-card__benefit--muted">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
									<path d="M18 6 6 18" />
									<path d="m6 6 12 12" />
								</svg>
								<span>Pasang Lowongan Kerja</span>
							</li>
							<li class="membership-package-card__benefit membership-package-card__benefit--muted">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
									<path d="M18 6 6 18" />
									<path d="m6 6 12 12" />
								</svg>
								<span>Program Inkubasi UMKM</span>
							</li>
							<li class="membership-package-card__benefit membership-package-card__benefit--muted">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
									<path d="M18 6 6 18" />
									<path d="m6 6 12 12" />
								</svg>
								<span>Konsultasi</span>
							</li>
							<li class="membership-package-card__benefit membership-package-card__benefit--muted">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
									<path d="M18 6 6 18" />
									<path d="m6 6 12 12" />
								</svg>
								<span>Bonus Aplikasi Pendukung</span>
							</li>
							<li class="membership-package-card__benefit membership-package-card__benefit--muted">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
									<path d="M18 6 6 18" />
									<path d="m6 6 12 12" />
								</svg>
								<span>Akses Penuh Komunitas &amp; Program Afiliasi</span>
							</li>
							<li class="membership-package-card__benefit membership-package-card__benefit--muted">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
									<path d="M18 6 6 18" />
									<path d="m6 6 12 12" />
								</svg>
								<span>Diskon Member Calon Bankir</span>
							</li>
						</ul>

						<div class="membership-package-card__divider"></div>

						<ul class="membership-package-card__notes">
							<li class="membership-package-card__note">Biaya Pelatihan Online (Live Webinar &amp; Interactive Class)<br><strong>Rp650.000,-</strong></li>
							<li class="membership-package-card__note">Biaya Pelatihan Offline<br><strong>Rp1.350.000,-</strong></li>
							<li class="membership-package-card__note">Biaya Pelatihan IHT (In House Training)<br><strong>Rp350.000,-</strong></li>
							<li class="membership-package-card__note">Biaya Video Pembelajaran (On-Demand Video Course)<br><strong>Rp200.000,-</strong></li>
						</ul>

						<button type="button" class="membership-package-card__action" disabled>Paket Saat Ini</button>
					</article>

					<article class="membership-package-card membership-package-card--featured" aria-labelledby="member-package-title">
						<del class="membership-package-card__price-before">Rp5.000.000,- /tahun</del>
						<p class="membership-package-card__price">Rp3.000.000,- <small>/tahun</small></p>
						<h3 class="membership-package-card__name" id="member-package-title">Member</h3>
						<p class="membership-package-card__description">Akses premium untuk pembelajaran, dokumen, benefit karier, dan komunitas.</p>

						<ul class="membership-package-card__benefits">
							<li class="membership-package-card__benefit membership-package-card__benefit--available">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
									<path d="M20 6 9 17l-5-5" />
								</svg>
								<span>Sertifikat Pelatihan (Digital)</span>
							</li>
							<li class="membership-package-card__benefit membership-package-card__benefit--available">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
									<path d="M20 6 9 17l-5-5" />
								</svg>
								<span>Aset Video Pembelajaran</span>
							</li>
							<li class="membership-package-card__benefit membership-package-card__benefit--available">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
									<path d="M20 6 9 17l-5-5" />
								</svg>
								<span>Akses Dokumen SOP Perbankan</span>
							</li>
							<li class="membership-package-card__benefit membership-package-card__benefit--available">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
									<path d="M20 6 9 17l-5-5" />
								</svg>
								<span>Pasang Lowongan Kerja</span>
							</li>
							<li class="membership-package-card__benefit membership-package-card__benefit--available">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
									<path d="M20 6 9 17l-5-5" />
								</svg>
								<span>Program Inkubasi UMKM</span>
							</li>
							<li class="membership-package-card__benefit membership-package-card__benefit--available">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
									<path d="M20 6 9 17l-5-5" />
								</svg>
								<span>Konsultasi</span>
							</li>
							<li class="membership-package-card__benefit membership-package-card__benefit--available">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
									<path d="M20 6 9 17l-5-5" />
								</svg>
								<span>Bonus Aplikasi Pendukung</span>
							</li>
							<li class="membership-package-card__benefit membership-package-card__benefit--available">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
									<path d="M20 6 9 17l-5-5" />
								</svg>
								<span>Akses Penuh Komunitas &amp; Program Afiliasi</span>
							</li>
							<li class="membership-package-card__benefit membership-package-card__benefit--available">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
									<path d="M20 6 9 17l-5-5" />
								</svg>
								<span>Diskon Member Calon Bankir</span>
							</li>
						</ul>

						<div class="membership-package-card__divider"></div>

						<ul class="membership-package-card__notes">
							<li class="membership-package-card__note">Biaya Pelatihan Online (Live Webinar &amp; Interactive Class) <del>Rp650.000,-</del>, <strong>Rp585.000,-</strong></li>
							<li class="membership-package-card__note">Biaya Pelatihan Offline <del>Rp1.350.000,-</del> <strong>Rp1.215.000,-</strong></li>
							<li class="membership-package-card__note">Biaya Pelatihan IHT (In House Training) <del>Rp350.000,-</del> <strong>Rp200.000,-</strong></li>
							<li class="membership-package-card__note">Biaya Video Pembelajaran (On-Demand Video Course) <del>Rp200.000,-</del> <strong>Rp150.000,-</strong></li>
						</ul>

						<a href="" class="membership-package-card__action">Berlangganan sekarang</a>
					</article>
				</div>
			</div>
		</div>
	</div>
</div>