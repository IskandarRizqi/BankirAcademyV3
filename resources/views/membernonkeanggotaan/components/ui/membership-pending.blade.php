@once
<style>
	.membership-pending-card {
		height: 100%;
		min-height: 180px;
		padding: 18px;
		background: #ffffff;
		border: 1px solid #e5e7eb;
		border-radius: 10px;
		box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		gap: 18px;
	}

	.membership-pending-card__header {
		display: flex;
		align-items: flex-start;
		justify-content: space-between;
		gap: 16px;
	}

	.membership-pending-card__icon {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 44px;
		height: 44px;
		border-radius: 10px;
		background: #fff7ed;
		color: #c2410c;
		flex: 0 0 auto;
	}

	.membership-pending-card__icon svg {
		width: 22px;
		height: 22px;
	}

	.membership-pending-card__eyebrow {
		margin: 0 0 6px;
		color: #6b7280;
		font-size: 12px;
		font-weight: 700;
		letter-spacing: .04em;
		line-height: 1.4;
		text-transform: uppercase;
	}

	.membership-pending-card__title {
		margin: 0;
		color: #111827;
		font-size: 20px;
		font-weight: 800;
		letter-spacing: -0.02em;
		line-height: 1.3;
	}

	.membership-pending-card__description {
		margin: 0;
		color: #4b5563;
		font-size: 14px;
		line-height: 1.65;
	}

	.membership-pending-card__notice {
		display: flex;
		align-items: flex-start;
		gap: 10px;
		padding: 12px;
		background: #f9fafb;
		border: 1px solid #eef2f7;
		border-radius: 10px;
		color: #374151;
		font-size: 13px;
		font-weight: 700;
		line-height: 1.5;
	}

	.membership-pending-card__notice-icon {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 22px;
		height: 22px;
		border-radius: 999px;
		background: #fff7ed;
		color: #c2410c;
		font-size: 12px;
		font-weight: 900;
		flex: 0 0 auto;
	}

	@media (max-width: 575.98px) {
		.membership-pending-card {
			padding: 16px;
		}

		.membership-pending-card__header {
			flex-direction: column;
			gap: 12px;
		}
	}
</style>
@endonce

<section class="membership-pending-card" aria-labelledby="membership-pending-title">
	<div>
		<div class="membership-pending-card__header">
			<div>
				<p class="membership-pending-card__eyebrow">Status Keanggotaan</p>
				<h2 class="membership-pending-card__title" id="membership-pending-title">Menunggu Konfirmasi Pembayaran</h2>
			</div>
			<span class="membership-pending-card__icon" aria-hidden="true">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
					<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
					<path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
				</svg>
			</span>
		</div>

		<p class="membership-pending-card__description mt-3">Bukti pembayaran Anda telah kami terima. Tim Admin Bankir Academy sedang melakukan verifikasi data pendaftaran Anda.</p>
	</div>

	<div class="membership-pending-card__notice">
		<span class="membership-pending-card__notice-icon" aria-hidden="true">i</span>
		<span>Proses verifikasi biasanya memakan waktu maksimal 1x24 jam.</span>
	</div>
</section>
