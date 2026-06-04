<style>
	.new-member-section {
		min-height: 400px;
		display: flex;
		align-items: center;
		justify-content: center;
		padding: 60px 0;
	}

	.member-card {
		max-width: 553px;
		width: 100%;
		border-radius: 20px;
		background: #fff;
		box-shadow: 0 12px 40px rgba(0, 0, 0, 0.18);
		padding: 40px 32px;
		display: flex;
		flex-direction: column;
		transition: transform 0.3s ease, box-shadow 0.3s ease;
	}

	.member-card:hover {
		box-shadow: 0 18px 50px rgba(0, 0, 0, 0.22);
	}

	.best-seller-badge {
		position: absolute;
		top: -41px;
		right: -44px;
		width: 154px;
		height: auto;
		z-index: 10;
	}

	@media (max-width: 1199.98px) {
		.member-card {
			padding: 32px 24px;
		}
	}

	@media (max-width: 1199.98px) {
		.best-seller-badge {
			width: 110px;
			top: -30px;
			right: -20px;
		}
	}

	@media (max-width: 767.98px) {
		.member-card {
			padding: 24px 20px;
			max-width: 100%;
		}

		.member-card .price-area .price {
			font-size: 2rem;
		}

		.member-card .card-wave {
			left: 0;
			right: 0;
			width: 100%;
			height: 120px;
		}

		.member-card .card-footer-area {
			padding-bottom: 130px;
		}

		.member-wrapper {
			margin-bottom: 24px;
		}

		.member-wrapper:last-child {
			margin-bottom: 0;
		}

		.best-seller-badge {
			width: 80px;
			top: -20px;
			right: -15px;
		}
	}

	@media (min-width: 768px) {
		.member-wrapper {
			margin-bottom: 0;
		}
	}

	.member-card .card-header-area {
		text-align: center;
		padding-bottom: 20px;
		border-bottom: 1px solid #f0f0f0;
	}

	.member-card .card-header-area .icon-box {
		width: 72px;
		height: 72px;
		border-radius: 18px;
		display: flex;
		align-items: center;
		justify-content: center;
		margin: 0 auto 16px;
	}

	.member-card .card-header-area .icon-box.non-member {
		background: #f0f2f5;
	}

	.member-card .card-header-area .icon-box.member {
		background: linear-gradient(135deg, #1e3c72, #2a5298);
	}

	.member-card .card-header-area .plan-name {
		font-size: 1.5rem;
		font-weight: 800;
		color: #1a1a2e;
		margin-bottom: 4px;
	}

	.member-card .card-header-area .plan-sub {
		font-size: 0.85rem;
		color: #9ca3af;
	}

	.member-card .price-area {
		text-align: center;
		padding: 24px 0;
	}

	.member-card .price-area .price {
		font-size: 2.5rem;
		font-weight: 800;
		color: #1e3c72;
	}

	.member-card .price-area .price .currency {
		font-size: 1.2rem;
		vertical-align: super;
	}

	.member-card .price-area .price .period {
		font-size: 0.9rem;
		font-weight: 400;
		color: #9ca3af;
	}

	.member-card .price-area .price-sub {
		font-size: 0.85rem;
		color: #9ca3af;
		margin-top: 4px;
	}

	.member-card .benefit-list {
		list-style: none;
		padding: 0;
		margin: 15px 0 20px;
		flex: 1;
	}

	.member-card .benefit-list li {
		padding: 10px 0;
		font-size: 16px;
		font-weight: 400;
		display: flex;
		align-items: center;
		gap: 12px;
	}

	.member-card .benefit-list li .icon-svg {
		flex-shrink: 0;
		width: 20px;
		height: 20px;
		display: block;
	}

	.member-card .benefit-list li .benefit-price {
		margin-left: auto;
		font-size: 14px;
		font-weight: 600;
		color: #1e3c72;
		white-space: nowrap;
	}

	.member-card .benefit-divider {
		margin-top: 10px;
		margin-bottom: 10px;
		border-bottom: 1px solid #e0e0e0;
	}

	.member-card .benefit-list li .benefit-text {
		color: #374151;
		line-height: 1.4;
	}

	.member-card .benefit-list li .benefit-text.muted {
		color: #d1d5db;
	}

	.member-card .card-footer-area {
		padding-top: 20px;
		padding-bottom: 160px;
		position: relative;
		z-index: 1;
	}

	.member-card .card-wave {
		position: absolute;
		left: 0;
		right: 0;
		bottom: 0;
		width: 100%;
		height: 151px;
		display: block;
		object-fit: cover;
		border-radius: 0 0 20px 20px;
		z-index: 0;
	}

	.member-card .card-footer-area .btn-plan {
		width: 100%;
		padding: 14px;
		border-radius: 50px;
		font-weight: 700;
		font-size: 1rem;
		border: none;
		transition: all 0.3s ease;
		cursor: pointer;
	}

	.member-card .card-footer-area .btn-plan.btn-non-member {
		background: #f0f2f5;
		color: #9ca3af;
		cursor: not-allowed;
	}

	.member-card .card-footer-area .btn-plan.btn-member {
		width: 100%;
		max-width: 450px;
		height: 50px;
		border-radius: 20px;
		background: #FFC107;
		color: #fff;
		font-size: 15px;
		font-weight: 700;
		margin: 0 auto;
		display: block;
		box-shadow: 0 4px 15px rgba(13, 46, 81, 0.3);
	}

	.member-card .card-footer-area .btn-plan.btn-member:hover {
		background: #FFC107;
		color: #fff;
		box-shadow: 0 6px 20px rgba(255, 193, 7, 0.4);
	}

	.member-premium-card {
		max-width: 520px;
		margin: 0 auto;
	}

	.member-premium-card .mc-inner {
		background: linear-gradient(135deg, #D4A017 0%, #FFD700 30%, #F0C040 50%, #DAA520 70%, #B8860B 100%);
		border-radius: 24px;
		padding: 0;
		position: relative;
		overflow: hidden;
		box-shadow: 0 20px 60px rgba(212, 160, 23, 0.35), 0 8px 20px rgba(0, 0, 0, 0.15);
		transition: transform 0.4s ease, box-shadow 0.4s ease;
	}

	.member-premium-card .mc-inner:hover {
		transform: translateY(-6px);
		box-shadow: 0 30px 80px rgba(212, 160, 23, 0.45), 0 10px 30px rgba(0, 0, 0, 0.2);
	}

	.member-premium-card .mc-bg-pattern {
		position: absolute;
		inset: 0;
		background-image:
			radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.08) 0%, transparent 50%),
			radial-gradient(circle at 80% 70%, rgba(255, 255, 255, 0.05) 0%, transparent 50%),
			radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.03) 0%, transparent 70%);
		pointer-events: none;
	}

	.member-premium-card .mc-grid {
		position: absolute;
		inset: 0;
		background-image:
			linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
			linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
		background-size: 40px 40px;
		pointer-events: none;
	}

	.member-premium-card .mc-glow {
		position: absolute;
		top: -50%;
		right: -30%;
		width: 300px;
		height: 300px;
		border-radius: 50%;
		background: radial-gradient(circle, rgba(255, 255, 255, 0.12) 0%, transparent 70%);
		pointer-events: none;
	}

	.member-premium-card .mc-content {
		position: relative;
		z-index: 2;
		padding: 35px 30px;
	}

	.member-premium-card .mc-header {
		display: flex;
		justify-content: space-between;
		align-items: flex-start;
		margin-bottom: 30px;
	}

	.member-premium-card .mc-brand {
		display: flex;
		flex-direction: column;
	}

	.member-premium-card .mc-brand-logo {
		height: 52px;
		width: auto;
		display: block;
		margin-bottom: 6px;
	}

	.member-premium-card .mc-brand-tag {
		font-size: 0.85rem;
		color: rgba(255, 255, 255, 0.5);
		letter-spacing: 2px;
		text-transform: uppercase;
	}

	.member-premium-card .mc-chip {
		width: 52px;
		height: 40px;
		background: linear-gradient(135deg, #ffd700 0%, #f0c040 50%, #d4a800 100%);
		border-radius: 6px;
		position: relative;
		overflow: hidden;
		flex-shrink: 0;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
	}

	.member-premium-card .mc-chip::before {
		content: '';
		position: absolute;
		left: 50%;
		top: 50%;
		transform: translate(-50%, -50%);
		width: 28px;
		height: 18px;
		border: 1.5px solid rgba(180, 140, 0, 0.4);
		border-radius: 3px;
	}

	.member-premium-card .mc-chip::after {
		content: '';
		position: absolute;
		left: 50%;
		top: 50%;
		transform: translate(-50%, -50%);
		width: 10px;
		height: 10px;
		border: 1.5px solid rgba(180, 140, 0, 0.3);
		border-radius: 50%;
	}

	.member-premium-card .mc-badge-status {
		display: inline-flex;
		align-items: center;
		gap: 8px;
		background: rgba(255, 255, 255, 0.15);
		backdrop-filter: blur(10px);
		padding: 7px 18px;
		border-radius: 50px;
		font-size: 0.85rem;
		font-weight: 700;
		color: #fff;
		letter-spacing: 0.5px;
		border: 1px solid rgba(255, 255, 255, 0.1);
	}

	.member-premium-card .mc-badge-status .dot {
		width: 8px;
		height: 8px;
		border-radius: 50%;
		background: #00e676;
		animation: pulse-dot 2s infinite;
	}

	@keyframes pulse-dot {

		0%,
		100% {
			opacity: 1;
		}

		50% {
			opacity: 0.4;
		}
	}

	.member-premium-card .mc-body {
		display: flex;
		gap: 28px;
		align-items: center;
		margin-bottom: 32px;
	}

	.member-premium-card .mc-avatar {
		width: 100px;
		height: 100px;
		border-radius: 50%;
		border: 3px solid rgba(255, 255, 255, 0.3);
		object-fit: cover;
		flex-shrink: 0;
		box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
		background: #f0f2f5;
	}

	.member-premium-card .mc-member-info {
		flex: 1;
		min-width: 0;
	}

	.member-premium-card .mc-member-name {
		font-size: 1.65rem;
		font-weight: 700;
		color: #fff;
		margin: 0 0 2px;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}

	.member-premium-card .mc-member-type {
		font-size: 1rem;
		color: rgba(255, 255, 255, 0.7);
		margin-bottom: 10px;
		display: flex;
		align-items: center;
		gap: 10px;
	}

	.member-premium-card .mc-member-type .badge-tier {
		background: linear-gradient(135deg, #ffd700, #ff8c00);
		color: #1a1a2e;
		font-size: 0.75rem;
		font-weight: 800;
		padding: 4px 14px;
		border-radius: 50px;
		text-transform: uppercase;
		letter-spacing: 1px;
	}

	.member-premium-card .mc-id-row {
		display: flex;
		align-items: center;
		gap: 8px;
	}

	.member-premium-card .mc-id-label {
		font-size: 0.8rem;
		color: rgba(255, 255, 255, 0.5);
		text-transform: uppercase;
		letter-spacing: 1px;
	}

	.member-premium-card .mc-id-value {
		font-size: 1rem;
		font-weight: 600;
		color: rgba(255, 255, 255, 0.9);
		font-family: 'Courier New', monospace;
		letter-spacing: 1.5px;
	}

	.member-premium-card .mc-footer {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding-top: 20px;
		border-top: 1px solid rgba(255, 255, 255, 0.1);
	}

	.member-premium-card .mc-footer-item {
		display: flex;
		flex-direction: column;
	}

	.member-premium-card .mc-footer-label {
		font-size: 0.75rem;
		color: rgba(255, 255, 255, 0.45);
		text-transform: uppercase;
		letter-spacing: 1.5px;
		margin-bottom: 4px;
	}

	.member-premium-card .mc-footer-value {
		font-size: 1rem;
		font-weight: 600;
		color: #fff;
	}

	.member-premium-card .mc-footer-value small {
		font-weight: 400;
		font-size: 0.7rem;
		color: rgba(255, 255, 255, 0.5);
	}

	.member-premium-card .mc-watermark {
		position: absolute;
		bottom: 20px;
		right: 25px;
		font-size: 4rem;
		font-weight: 900;
		color: rgba(255, 255, 255, 0.04);
		letter-spacing: 4px;
		pointer-events: none;
		line-height: 1;
		user-select: none;
		font-family: 'Arial Black', sans-serif;
	}

	.member-premium-card .mc-actions {
		display: flex;
		gap: 12px;
		margin-top: 24px;
		justify-content: center;
		flex-wrap: wrap;
	}

	.member-premium-card .mc-btn {
		padding: 12px 28px;
		border-radius: 50px;
		font-size: 0.95rem;
		font-weight: 700;
		border: none;
		cursor: pointer;
		transition: all 0.3s ease;
		display: inline-flex;
		align-items: center;
		gap: 8px;
		text-decoration: none;
	}

	.member-premium-card .mc-btn-primary {
		background: #fff;
		color: #B8860B;
		box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
	}

	.member-premium-card .mc-btn-primary:hover {
		background: #fffdf0;
		transform: translateY(-2px);
		box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
		color: #B8860B;
	}

	.member-premium-card .mc-btn-primary:hover {
		background: #f0f4ff;
		transform: translateY(-2px);
		box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
		color: #005CFF;
	}

	.member-premium-card .mc-btn-primary:hover {
		background: #f0f4ff;
		transform: translateY(-2px);
		box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
		color: #005CFF;
	}

	.member-premium-card .mc-btn-outline {
		background: transparent;
		color: #fff;
		border: 1.5px solid rgba(255, 255, 255, 0.3);
	}

	.member-premium-card .mc-btn-outline:hover {
		background: rgba(255, 255, 255, 0.1);
		border-color: rgba(255, 255, 255, 0.5);
		color: #fff;
		transform: translateY(-2px);
	}

	@media (max-width: 575.98px) {
		.member-premium-card .mc-content {
			padding: 24px 20px;
		}

		.member-premium-card .mc-body {
			gap: 16px;
		}

		.member-premium-card .mc-avatar {
			width: 72px;
			height: 72px;
		}

		.member-premium-card .mc-member-name {
			font-size: 1.25rem;
		}

		.member-premium-card .mc-header {
			margin-bottom: 20px;
		}

		.member-premium-card .mc-footer {
			flex-direction: column;
			gap: 12px;
			align-items: flex-start;
		}

		.member-premium-card .mc-watermark {
			font-size: 2.5rem;
			bottom: 15px;
			right: 15px;
		}

		.member-premium-card .mc-actions {
			flex-direction: column;
		}

		.member-premium-card .mc-btn {
			width: 100%;
			justify-content: center;
		}
	}

	@media (min-width: 576px) and (max-width: 767.98px) {
		.member-premium-card .mc-content {
			padding: 28px 24px;
		}
	}

	.mc-benefits {
		max-width: 520px;
		margin: 32px auto 0;
	}

	.mc-benefits .mc-benefits-header {
		display: flex;
		align-items: center;
		gap: 10px;
		margin-bottom: 20px;
	}

	.mc-benefits .mc-benefits-header h4 {
		font-size: 1.1rem;
		font-weight: 700;
		color: #1a1a2e;
		margin: 0;
	}

	.mc-benefits .mc-benefits-header .line {
		flex: 1;
		height: 1.5px;
		background: linear-gradient(90deg, #D4A017 0%, rgba(212, 160, 23, 0.1) 100%);
		border-radius: 2px;
	}

	.mc-benefits .benefits-grid {
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 12px;
	}

	.mc-benefits .benefit-item {
		display: flex;
		align-items: center;
		gap: 14px;
		padding: 16px 18px;
		border-radius: 14px;
		background: #fff;
		border: 1px solid rgba(212, 160, 23, 0.12);
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
		transition: all 0.3s ease;
	}

	.mc-benefits .benefit-item:hover {
		border-color: rgba(212, 160, 23, 0.3);
		box-shadow: 0 4px 16px rgba(212, 160, 23, 0.1);
		transform: translateY(-2px);
	}

	.mc-benefits .benefit-icon {
		width: 36px;
		height: 36px;
		border-radius: 10px;
		background: linear-gradient(135deg, #D4A017, #FFD700);
		display: flex;
		align-items: center;
		justify-content: center;
		flex-shrink: 0;
	}

	.mc-benefits .benefit-icon svg {
		width: 18px;
		height: 18px;
		color: #fff;
	}

	.mc-benefits .benefit-text {
		font-size: 0.85rem;
		font-weight: 500;
		color: #374151;
		line-height: 1.4;
	}

	@media (max-width: 575.98px) {
		.mc-benefits .benefits-grid {
			grid-template-columns: 1fr;
			gap: 10px;
		}

		.mc-benefits .benefit-item {
			padding: 14px 16px;
		}

		.mc-benefits .benefit-text {
			font-size: 0.8rem;
		}
	}
</style>

<section class="new-member-section">
	<div class="container">


		@if($ismember == 2)
		<div class="row justify-content-center">
			<div class="col-md-8 text-center">
				<div class="pending-member-box text-center">
					<div class="mb-4">
						<span style="font-size: 5rem;">⏳</span>
					</div>
					<h2 class="font-weight-bold mb-2 text-white">Menunggu Konfirmasi Pembayaran</h2>
					<p class="lead opacity-75">Bukti pembayaran Anda telah kami terima. Tim Admin Bankir Academy sedang melakukan verifikasi data pendaftaran Anda.</p>
					<hr style="border-top: 1px solid rgba(255,255,255,0.2)">
					<div class="d-inline-block bg-white text-dark px-4 py-2 rounded-pill font-weight-bold mt-2 shadow-sm">
						🔔 Proses verifikasi biasanya memakan waktu maksimal 1x24 jam.
					</div>
				</div>
			</div>
		</div>
		@elseif($ismember == 1)
		<div class="member-premium-card">
			<div class="mc-inner">
				<div class="mc-bg-pattern"></div>
				<div class="mc-grid"></div>
				<div class="mc-glow"></div>

				<div class="mc-content">
					<div class="mc-header">
						<div class="mc-brand">
							<img src="{{ asset('FE/logokartunew1.png') }}" alt="Bankir Academy" class="mc-brand-logo">
							<!-- <span class="mc-brand-tag">Bankir Academy</span> -->
						</div>
						<div style="display:flex;flex-direction:column;align-items:flex-end;gap:8px;">
							<!-- <div class="mc-chip"></div> -->
							<span class="mc-badge-status">
								<span class="dot"></span>
								Active
							</span>
						</div>
					</div>

					<div class="mc-body">
						<img src="{{ isset($pfl) && $pfl->picture ? $pfl->picture : '/GambarV2/rectangle31.png' }}"
							alt="Member"
							class="mc-avatar"
							onerror="this.src='/GambarV2/rectangle31.png'">
						<div class="mc-member-info">
							<h3 class="mc-member-name">{{ isset($pfl) && $pfl->name ? $pfl->name : $user->name ?? 'Member' }}</h3>
							<div class="mc-member-type">
								<span>{{ isset($pfl) && $pfl->membership ? $pfl->membership->nama : 'Member' }}</span>
								<span class="badge-tier">Premium</span>
							</div>
							<div class="mc-id-row">
								<span class="mc-id-label">ID</span>
								<span class="mc-id-value">{{'BA-' . str_pad($pfl->user_id, 5, '0', STR_PAD_LEFT)}}</span>
							</div>
						</div>
					</div>

					<div class="mc-footer">
						<div class="mc-footer-item">
							<span class="mc-footer-label">Masa Aktif</span>
							<span class="mc-footer-value">
								{{ isset($pfl) && $pfl->masa_aktif_membership ? \Carbon\Carbon::parse($pfl->masa_aktif_membership)->translatedFormat('d F Y') : '-' }}
							</span>
						</div>
						<div class="mc-footer-item" style="text-align:right;">
							<span class="mc-footer-label">Bergabung</span>
							<span class="mc-footer-value">
								{{ isset($user) && $user->created_at ? \Carbon\Carbon::parse($user->created_at)->translatedFormat('d F Y') : '-' }}
							</span>
						</div>
					</div>
				</div>
				<div class="mc-watermark">BA</div>
			</div>

		</div>

		<div class="mc-benefits">
			<div class="mc-benefits-header">
				<h4>Benefit Member</h4>
				<span class="line"></span>
			</div>
			<div class="benefits-grid">
				<div class="benefit-item">
					<div class="benefit-icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
							<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
							<polyline points="22 4 12 14.01 9 11.01" />
						</svg>
					</div>
					<span class="benefit-text">Sertifikat Pelatihan (Digital & Fisik)</span>
				</div>
				<div class="benefit-item">
					<div class="benefit-icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
							<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
							<polyline points="22 4 12 14.01 9 11.01" />
						</svg>
					</div>
					<span class="benefit-text">5 Aset Video Pembelajaran Gratis</span>
				</div>
				<div class="benefit-item">
					<div class="benefit-icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
							<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
							<polyline points="22 4 12 14.01 9 11.01" />
						</svg>
					</div>
					<span class="benefit-text">Akses &gt; 25 Dokumen SOP Perbankan</span>
				</div>
				<div class="benefit-item">
					<div class="benefit-icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
							<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
							<polyline points="22 4 12 14.01 9 11.01" />
						</svg>
					</div>
					<span class="benefit-text">Pasang Lowongan Kerja Tanpa Batas</span>
				</div>
				<div class="benefit-item">
					<div class="benefit-icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
							<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
							<polyline points="22 4 12 14.01 9 11.01" />
						</svg>
					</div>
					<span class="benefit-text">10 Program Inkubasi UMKM</span>
				</div>
				<div class="benefit-item">
					<div class="benefit-icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
							<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
							<polyline points="22 4 12 14.01 9 11.01" />
						</svg>
					</div>
					<span class="benefit-text">Konsultasi</span>
				</div>
				<div class="benefit-item">
					<div class="benefit-icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
							<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
							<polyline points="22 4 12 14.01 9 11.01" />
						</svg>
					</div>
					<span class="benefit-text">Bonus Aplikasi Pendukung</span>
				</div>
				<div class="benefit-item">
					<div class="benefit-icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
							<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
							<polyline points="22 4 12 14.01 9 11.01" />
						</svg>
					</div>
					<span class="benefit-text">Akses Penuh Komunitas & Program Afiliasi</span>
				</div>
				<div class="benefit-item">
					<div class="benefit-icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
							<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
							<polyline points="22 4 12 14.01 9 11.01" />
						</svg>
					</div>
					<span class="benefit-text">Diskon Member Calon Bankir</span>
				</div>
			</div>
		</div>
		@else
		<div class="text-center mb-5">
			<h3 class="font-weight-bold" style="color: #1a1a2e;">Pilih Paket Membership</h3>
			<p style="color: #9ca3af;">Dapatkan akses penuh ke semua fitur premium</p>
		</div>
		<div class="row justify-content-center align-items-stretch g-4">
			<div class="col-12 col-md-6 col-xl-5 d-flex justify-content-center member-wrapper">
				<div class="member-card h-100" style="position: relative; overflow: hidden; padding-bottom: 0;">
					<div class="price-area" style="text-align: left; padding-top: 10px; padding-bottom: 15px;">
						<div style="font-size: 35px; font-weight: 800; color: #1e3c72; line-height: 1;">
							Rp0,- <small style="font-size: 18px;">/tahun</small>
						</div>

					</div>
					<div class="card-header-area">
						<div class="plan-name" style="text-align: left; font-size: 30px; font-weight: 500; color: #FF0707;">Non Member</div>
					</div>
					<ul class="benefit-list">
						<li>
							<img src="{{ asset('FE/si_check-fill.svg') }}" alt="" class="icon-svg">
							<span class="benefit-text">Sertifikat Pelatihan (Digital)</span>
						</li>
						<li>
							<img src="{{ asset('FE/si_close-line.svg') }}" alt="" class="icon-svg">
							<span class="benefit-text muted">Aset Video Pembelajaran</span>
						</li>
						<li>
							<img src="{{ asset('FE/si_close-line.svg') }}" alt="" class="icon-svg">
							<span class="benefit-text muted">Akses Dokumen SOP Perbankan</span>
						</li>
						<li>
							<img src="{{ asset('FE/si_close-line.svg') }}" alt="" class="icon-svg">
							<span class="benefit-text muted">Pasang Lowongan Kerja</span>
						</li>
						<li>
							<img src="{{ asset('FE/si_close-line.svg') }}" alt="" class="icon-svg">
							<span class="benefit-text muted">Program Inkubasi UMKM</span>
						</li>
						<li>
							<img src="{{ asset('FE/si_close-line.svg') }}" alt="" class="icon-svg">
							<span class="benefit-text muted">Konsultasi</span>
						</li>
						<li>
							<img src="{{ asset('FE/si_close-line.svg') }}" alt="" class="icon-svg">
							<span class="benefit-text muted">Bonus Aplikasi Pendukung</span>
						</li>
						<li>
							<img src="{{ asset('FE/si_close-line.svg') }}" alt="" class="icon-svg">
							<span class="benefit-text muted">Akses Penuh Komunitas &amp; Program Afiliasi</span>
						</li>
						<li>
							<img src="{{ asset('FE/si_close-line.svg') }}" alt="" class="icon-svg">
							<span class="benefit-text muted">Diskon Member Calon Bankir</span>
						</li>
					</ul>
					<div class="benefit-divider"></div>
					<ul class="benefit-list">
						<li>
							<img src="{{ asset('FE/inforound.svg') }}" alt="" class="icon-svg">
							<span class="benefit-text">Biaya Pelatihan Online (Live Webinar &amp; Interactive Class) <br> Rp650.000,-</span>
						</li>
						<li>
							<img src="{{ asset('FE/inforound.svg') }}" alt="" class="icon-svg">
							<span class="benefit-text">Biaya Pelatihan Offline <br> Rp1.350.000,-</span>
						</li>
						<li>
							<img src="{{ asset('FE/inforound.svg') }}" alt="" class="icon-svg">
							<span class="benefit-text">Biaya Pelatihan IHT (In House Training) <br> Rp350.000,-</span>
						</li>
						<li>
							<img src="{{ asset('FE/inforound.svg') }}" alt="" class="icon-svg">
							<span class="benefit-text">Biaya Video Pembelajaran (On-Demand Video Course) <br> Rp200.000,-</span>
						</li>
					</ul>
					<div class="card-footer-area">
						<!-- <button class="btn-plan btn-non-member">Paket Saat Ini</button> -->
					</div>
					<img src="{{ asset('FE/wave_free.svg') }}" alt="" class="card-wave">
				</div>
			</div>
			<div class="col-12 col-md-6 col-xl-5 d-flex justify-content-center member-wrapper">
				<div class="member-card h-100" style="position: relative; overflow: visible; padding-bottom: 0;">
					<img src="{{ asset('FE/icons8-hot-price-94.png') }}" alt="Best Seller" class="best-seller-badge">
					<div class="price-area" style="text-align: left; padding-top: 10px; padding-bottom: 15px;">
						<!-- Rp5000K -->
						<div style="font-size: 20px; font-weight: 800; color: #1e3c72; line-height: 1;">
							<del>Rp5.000.000,- </del><small style="font-size: 18px;">/tahun</small>
						</div>
					</div>
					<div class="price-area" style="text-align: left; padding-top: 0px; padding-bottom: 15px;">
						<div style="font-size: 35px; font-weight: 800; color: #1e3c72; line-height: 1;">
							Rp3.000.000,- <small style="font-size: 18px;">/tahun</small>
						</div>

					</div>
					<div class="card-header-area">
						<div class="plan-name" style="text-align: left; font-size: 30px; font-weight: 500; color: #00A329;">Member</div>
					</div>
					<ul class="benefit-list">
						<li>
							<img src="{{ asset('FE/si_check-fill.svg') }}" alt="" class="icon-svg">
							<span class="benefit-text">Sertifikat Pelatihan (Digital)</span>
						</li>
						<li>
							<img src="{{ asset('FE/si_check-fill.svg') }}" alt="" class="icon-svg">
							<span class="benefit-text">Aset Video Pembelajaran</span>
						</li>
						<li>
							<img src="{{ asset('FE/si_check-fill.svg') }}" alt="" class="icon-svg">
							<span class="benefit-text">Akses Dokumen SOP Perbankan</span>
						</li>
						<li>
							<img src="{{ asset('FE/si_check-fill.svg') }}" alt="" class="icon-svg">
							<span class="benefit-text">Pasang Lowongan Kerja</span>
						</li>
						<li>
							<img src="{{ asset('FE/si_check-fill.svg') }}" alt="" class="icon-svg">
							<span class="benefit-text">Program Inkubasi UMKM</span>
						</li>
						<li>
							<img src="{{ asset('FE/si_check-fill.svg') }}" alt="" class="icon-svg">
							<span class="benefit-text">Konsultasi</span>
						</li>
						<li>
							<img src="{{ asset('FE/si_check-fill.svg') }}" alt="" class="icon-svg">
							<span class="benefit-text">Bonus Aplikasi Pendukung</span>
						</li>
						<li>
							<img src="{{ asset('FE/si_check-fill.svg') }}" alt="" class="icon-svg">
							<span class="benefit-text">Akses Penuh Komunitas &amp; Program Afiliasi</span>
						</li>
						<li>
							<img src="{{ asset('FE/si_check-fill.svg') }}" alt="" class="icon-svg">
							<span class="benefit-text">Diskon Member Calon Bankir</span>
						</li>
					</ul>
					<div class="benefit-divider"></div>
					<ul class="benefit-list">
						<li>
							<img src="{{ asset('FE/inforound.svg') }}" alt="" class="icon-svg">
							<span class="benefit-text">Biaya Pelatihan Online (Live Webinar &amp; Interactive Class) <br> <del>Rp650.000-,</del> Rp585.000,-</span>
						</li>
						<li>
							<img src="{{ asset('FE/inforound.svg') }}" alt="" class="icon-svg">
							<span class="benefit-text">Biaya Pelatihan Offline <br><del>Rp1.350.000,-</del> Rp1.215.000,-</span>
						</li>
						<li>
							<img src="{{ asset('FE/inforound.svg') }}" alt="" class="icon-svg">
							<span class="benefit-text">Biaya Pelatihan IHT (In House Training) <br> <del>Rp350.000,-</del> Rp200.000,-</span>
						</li>
						<li>
							<img src="{{ asset('FE/inforound.svg') }}" alt="" class="icon-svg">
							<span class="benefit-text">Biaya Video Pembelajaran (On-Demand Video Course) <br> <del>Rp200.000,-</del> Rp150.000,-</span>
						</li>
					</ul>
					<div class="card-footer-area">
						<button class="btn-plan btn-member" onclick="openmember()">Beli Paket</button>
					</div>
					<img src="{{ asset('FE/wave_free.svg') }}" alt="" class="card-wave">
				</div>
			</div>
			<div class="modal fade" id="modalmember" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header border-0 pb-0">
							<h5 class="modal-title font-weight-bold" id="exampleModalLabel">Konfirmasi Pendaftaran</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body p-4">
							<form action="/updatemember" method="POST" enctype="multipart/form-data">
								@csrf
								<input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
								<input type="hidden" name="status_membership" id="status_membership" value="2">
								<input type="hidden" name="id_member" id="id_member">

								<div id="detailmember" class="mb-4"></div>

								<div class="form-group mb-3">
									<label class="font-weight-bold small text-muted">UPLOAD BUKTI PEMBAYARAN</label>
									<input type="file" class="form-control-file p-2 border rounded w-100" name="image_bukti_pembayaran" id="image_bukti_pembayaran" accept="image/png, image/jpeg" required>
									@error('image_bukti_pembayaran')
									<div class="text-danger small mt-1">{{ $message }}</div>
									@enderror
								</div>

								<div class="preview-img-container mb-3 d-none" id="previewContainer">
									<img id="pctrbuktipembayaran" src="" alt="Preview Bukti" class="img-fluid rounded" style="max-height: 250px;">
								</div>

								<div class="row pt-2">
									<div class="col-6">
										<button type="button" class="btn btn-light btn-block rounded-pill" data-dismiss="modal">Batal</button>
									</div>
									<div class="col-6">
										<button type="submit" class="btn btn-success btn-block rounded-pill font-weight-bold shadow-sm">Kirim Bukti</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endif
	</div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
	function openmember() {
		// $('#id_member').val(val.id);
		//   <h4 class="font-weight-bold text-primary">Rp ${parseInt(val.harga).toLocaleString('id-ID')}</h4>
		//   <span class="text-muted d-block small uppercase">NAMA PAKET</span>
		$('#image_bukti_pembayaran').val('');
		$('#previewContainer').addClass('d-none');

		let p = `
            <div class="card bg-light border-0 mb-3">
                <div class="card-body p-3">
                    <h5 class="font-weight-bold text-dark">Membership</h5>
                    <hr class="my-2">
                    <span class="text-muted d-block small">TOTAL TAGIHAN</span>
						  <h4 class="font-weight-bold text-primary">Rp ${parseInt(3000000).toLocaleString('id-ID')}</h4>
                </div>
            </div>
            
            <div class="p-3 border rounded mb-3" style="background-color: #fffdf5; border-color: #ffeeba !important;">
                <span class="text-muted d-block small font-weight-bold text-warning">REKENING PEMBAYARAN</span>
                <span class="d-block mt-1"><strong>Bank Central Asia (BCA)</strong></span>
                <span class="d-block text-monospace font-weight-bold text-dark" style="font-size: 1.15rem;">803 555 9091</span>
                <span class="small d-block text-muted">a.n. PT. Bankir Academy Indonesia</span>
            </div>

            <a href="/classes/cetakinvoicepending/8127228529" target="_blank" class="btn btn-outline-info btn-block btn-sm rounded-pill mb-2">
                <i class="fa fa-file-text-o"></i> Unduh Invoice Digital (PDF)
            </a>
        `;

		$('#detailmember').html(p);
		$('#modalmember').modal('show');
	}

	document.getElementById('image_bukti_pembayaran').onchange = function(evt) {
		const [file] = this.files;
		if (file) {
			document.getElementById('pctrbuktipembayaran').src = URL.createObjectURL(file);
			document.getElementById('previewContainer').classList.remove('d-none');
		}
	};
</script>