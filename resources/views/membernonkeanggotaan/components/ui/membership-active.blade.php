@php
$user = auth()->user();
$profile = optional($user)->profile;
$membership = optional($profile)->membership;
$memberName = data_get($profile, 'name') ?: data_get($user, 'name', 'Member');
$memberType = data_get($membership, 'nama', 'Member');
$memberId = data_get($profile, 'user_id') ?: data_get($user, 'id');
$memberCode = $memberId ? 'BA-' . str_pad($memberId, 5, '0', STR_PAD_LEFT) : 'BA-00000';
$avatar = data_get($profile, 'picture') ?: asset('GambarV2/rectangle31.png');
$activeUntil = data_get($profile, 'masa_aktif_membership');
$joinedAt = data_get($profile, 'tanggal_bergabung_membership');
@endphp

@once
<style>
	.membership-active-card {
		width: 100%;
		height: 100%;
		min-height: 180px;
		border-radius: 10px;
		background: linear-gradient(135deg, #D4A017 0%, #FFD700 30%, #F0C040 52%, #DAA520 72%, #B8860B 100%);
		box-shadow: 0 16px 42px rgba(184, 134, 11, .22), 0 1px 2px rgba(15, 23, 42, .08);
		position: relative;
		overflow: hidden;
		color: #ffffff;
	}

	.membership-active-card::before {
		content: "";
		position: absolute;
		inset: 0;
		background-image:
			radial-gradient(circle at 18% 24%, rgba(255, 255, 255, .18), transparent 28%),
			radial-gradient(circle at 84% 72%, rgba(255, 255, 255, .1), transparent 34%),
			linear-gradient(rgba(255, 255, 255, .045) 1px, transparent 1px),
			linear-gradient(90deg, rgba(255, 255, 255, .045) 1px, transparent 1px);
		background-size: auto, auto, 36px 36px, 36px 36px;
		pointer-events: none;
	}

	.membership-active-card__content {
		position: relative;
		z-index: 1;
		padding: 18px;
		display: flex;
		flex-direction: column;
		gap: 18px;
	}

	.membership-active-card__header {
		display: flex;
		align-items: flex-start;
		justify-content: space-between;
		gap: 16px;
	}

	.membership-active-card__logo {
		height: 34px;
		width: auto;
		display: block;
		object-fit: contain;
	}

	.membership-active-card__badge {
		display: inline-flex;
		align-items: center;
		gap: 8px;
		min-height: 30px;
		padding: 6px 12px;
		border-radius: 999px;
		background: rgba(255, 255, 255, .16);
		border: 1px solid rgba(255, 255, 255, .18);
		color: #ffffff;
		font-size: 12px;
		font-weight: 800;
		backdrop-filter: blur(10px);
		white-space: nowrap;
	}

	.membership-active-card__badge-dot {
		width: 8px;
		height: 8px;
		border-radius: 999px;
		background: #22c55e;
		box-shadow: 0 0 0 4px rgba(34, 197, 94, .18);
	}

	.membership-active-card__body {
		display: flex;
		align-items: center;
		gap: 16px;
		min-width: 0;
	}

	.membership-active-card__avatar {
		width: 70px;
		height: 70px;
		border-radius: 50%;
		border: 3px solid rgba(255, 255, 255, .34);
		object-fit: cover;
		background: #f3f4f6;
		box-shadow: 0 8px 18px rgba(15, 23, 42, .18);
		flex: 0 0 auto;
	}

	.membership-active-card__info {
		min-width: 0;
		flex: 1;
	}

	.membership-active-card__name {
		margin: 0 0 5px;
		font-size: 21px;
		font-weight: 800;
		line-height: 1.2;
		letter-spacing: -.02em;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}

	.membership-active-card__tier-row {
		display: flex;
		align-items: center;
		gap: 8px;
		flex-wrap: wrap;
		color: rgba(255, 255, 255, .82);
		font-size: 13px;
		font-weight: 700;
	}

	.membership-active-card__tier {
		display: inline-flex;
		align-items: center;
		padding: 4px 10px;
		border-radius: 999px;
		background: rgba(26, 26, 46, .16);
		color: #1a1a2e;
		font-size: 11px;
		font-weight: 900;
		letter-spacing: .04em;
		text-transform: uppercase;
	}

	.membership-active-card__id {
		margin-top: 8px;
		display: flex;
		align-items: center;
		gap: 8px;
		color: rgba(255, 255, 255, .72);
		font-size: 12px;
		font-weight: 700;
		letter-spacing: .04em;
		text-transform: uppercase;
	}

	.membership-active-card__id strong {
		color: #ffffff;
		font-family: "Courier New", monospace;
		font-size: 13px;
		letter-spacing: .08em;
	}

	.membership-active-card__footer {
		display: grid;
		grid-template-columns: minmax(0, 1fr) auto minmax(0, 1fr);
		align-items: center;
		gap: 12px;
		padding-top: 14px;
		border-top: 1px solid rgba(255, 255, 255, .16);
	}

	.membership-active-card__meta-label {
		display: block;
		margin-bottom: 4px;
		color: rgba(255, 255, 255, .62);
		font-size: 11px;
		font-weight: 800;
		letter-spacing: .08em;
		text-transform: uppercase;
	}

	.membership-active-card__meta-value {
		display: block;
		color: #ffffff;
		font-size: 13px;
		font-weight: 800;
		line-height: 1.4;
	}

	.membership-active-card__benefit-button {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		min-height: 34px;
		padding: 8px 12px;
		border-radius: 999px;
		background: rgba(255, 255, 255, .94);
		color: #9a6b00;
		font-size: 12px;
		font-weight: 900;
		line-height: 1.2;
		text-align: center;
		white-space: nowrap;
		box-shadow: 0 8px 18px rgba(15, 23, 42, .12);
		transition: transform .18s ease, background .18s ease, box-shadow .18s ease;
		touch-action: manipulation;
	}

	.membership-active-card__benefit-button:hover {
		background: #ffffff;
		color: #9a6b00;
		box-shadow: 0 10px 24px rgba(15, 23, 42, .18);
		transform: translateY(-1px);
	}

	.membership-active-card__watermark {
		position: absolute;
		right: 16px;
		bottom: 8px;
		font-size: 48px;
		font-weight: 900;
		line-height: 1;
		letter-spacing: .08em;
		color: rgba(255, 255, 255, .08);
		pointer-events: none;
		user-select: none;
	}

	@media (max-width: 575.98px) {
		.membership-active-card__content {
			padding: 16px;
		}

		.membership-active-card__header,
		.membership-active-card__body {
			align-items: flex-start;
		}

		.membership-active-card__avatar {
			width: 58px;
			height: 58px;
		}

		.membership-active-card__name {
			font-size: 18px;
		}

		.membership-active-card__footer {
			grid-template-columns: 1fr;
		}

		.membership-active-card__benefit-button {
			width: 100%;
			min-height: 40px;
		}
	}

	@media (prefers-reduced-motion: reduce) {
		.membership-active-card * {
			transition: none !important;
		}
	}
</style>
@endonce

<section class="membership-active-card" aria-labelledby="membership-active-title">
	<div class="membership-active-card__content">
		<div class="membership-active-card__header">
			<img src="{{ asset('FE/logokartunew1.png') }}" alt="Bankir Academy" class="membership-active-card__logo">
			<span class="membership-active-card__badge">
				<span class="membership-active-card__badge-dot" aria-hidden="true"></span>
				Active
			</span>
		</div>

		<div class="membership-active-card__body">
			<img src="{{ $avatar }}" alt="Foto member {{ $memberName }}" class="membership-active-card__avatar" onerror="this.src='{{ asset('GambarV2/rectangle31.png') }}'">
			<div class="membership-active-card__info">
				<h2 class="membership-active-card__name" id="membership-active-title">{{ $memberName }}</h2>
				<div class="membership-active-card__tier-row">
					<span>{{ $memberType }}</span>
					<span class="membership-active-card__tier">Premium</span>
				</div>
				<div class="membership-active-card__id">
					<span>ID</span>
					<strong>{{ $memberCode }}</strong>
				</div>
			</div>
		</div>

		<div class="membership-active-card__footer">
			<div>
				<span class="membership-active-card__meta-label">Masa Aktif</span>
				<span class="membership-active-card__meta-value">
					{{ $activeUntil ? \Carbon\Carbon::parse($activeUntil)->translatedFormat('d F Y') : '-' }}
				</span>
			</div>
			<div>
				<span class="membership-active-card__meta-label">Bergabung</span>
				<span class="membership-active-card__meta-value">
					{{ $joinedAt ? \Carbon\Carbon::parse($joinedAt)->translatedFormat('d F Y') : '-' }}
				</span>
			</div>
			<a href="#benefit-member" class="membership-active-card__benefit-button">Lihat Benefit</a>


		</div>
	</div>
	<div class="membership-active-card__watermark">BA</div>
</section>