@php
$user = auth()->user();
$membershipStatusValue = (int) optional(optional($user)->profile)->status_membership;
$isPendingMember = $membershipStatusValue === 2;
$isMember = $membershipStatusValue === 1;
$membershipStatus = $isMember ? 'Member Aktif' : 'Belum Member';
$membershipDescription = $isMember
? 'Akun Anda sudah memiliki akses membership. Lanjutkan pembelajaran dan manfaatkan fasilitas yang tersedia.'
: 'Akun Anda belum terdaftar sebagai member. Daftar sekarang untuk membuka akses ke seluruh kelas pembelajaran dan menikmati berbagai manfaat eksklusif.';
@endphp

@if($isPendingMember)
	@include('membernonkeanggotaan.components.ui.membership-pending')
@elseif($isMember)
	@include('membernonkeanggotaan.components.ui.membership-active')
@else

@once
<style>
	.membership-status-card {
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

	.membership-status-card__header {
		display: flex;
		align-items: flex-start;
		justify-content: space-between;
		gap: 16px;
	}

	.membership-status-card__eyebrow {
		margin: 0 0 6px;
		color: #6b7280;
		font-size: 12px;
		font-weight: 700;
		letter-spacing: .04em;
		line-height: 1.4;
		text-transform: uppercase;
	}

	.membership-status-card__title {
		margin: 0;
		color: #111827;
		font-size: 20px;
		font-weight: 800;
		letter-spacing: -0.02em;
		line-height: 1.3;
	}

	.membership-status-card__badge {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		min-height: 30px;
		padding: 6px 10px;
		border-radius: 999px;
		background: #fff7ed;
		color: #9a3412;
		font-size: 12px;
		font-weight: 800;
		white-space: nowrap;
	}

	.membership-status-card__badge--active {
		background: #ecfdf5;
		color: #047857;
	}

	.membership-status-card__description {
		margin: 0;
		max-width: 560px;
		color: #4b5563;
		font-size: 14px;
		line-height: 1.65;
	}

	.membership-status-card__actions {
		display: grid;
		grid-template-columns: repeat(2, minmax(0, 1fr));
		gap: 10px;
	}

	.membership-status-card__button {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 100%;
		min-height: 42px;
		padding: 10px 14px;
		border-radius: 10px;
		background: #111827;
		color: #ffffff;
		font-size: 13px;
		font-weight: 800;
		border: 0;
		transition: background .18s ease, transform .18s ease;
		touch-action: manipulation;
	}

	.membership-status-card__button--secondary {
		background: #f3f4f6;
		color: #111827;
	}

	.membership-status-card__button--secondary:hover {
		background: var(--primary-soft, #EEF0FE);
		color: var(--primary, #4F46E5);
	}

	.membership-status-card__button:hover {
		background: var(--primary, #4F46E5);
		color: #ffffff;
		transform: translateY(-1px);
	}

	.membership-status-card__note {
		color: #6b7280;
		font-size: 12px;
		font-weight: 600;
		line-height: 1.5;
	}

	@media (max-width: 575.98px) {
		.membership-status-card {
			padding: 16px;
		}

		.membership-status-card__header {
			flex-direction: column;
			gap: 10px;
		}

		.membership-status-card__actions {
			grid-template-columns: 1fr;
			width: 100%;
		}
	}

	@media (prefers-reduced-motion: reduce) {
		.membership-status-card__button {
			transition: none;
		}

		.membership-status-card__button:hover {
			transform: none;
		}
	}
</style>
@endonce

<section class="membership-status-card" aria-labelledby="membership-status-title">
	<div>
		<div class="membership-status-card__header">
			<div>
				<p class="membership-status-card__eyebrow">Status Keanggotaan</p>
				<h2 class="membership-status-card__title" id="membership-status-title">{{ $membershipStatus }}</h2>
			</div>
			<span class="membership-status-card__badge {{ $isMember ? 'membership-status-card__badge--active' : '' }}">
				{{ $isMember ? 'Aktif' : 'Non Member' }}
			</span>
		</div>

		<p class="membership-status-card__description mt-3">{{ $membershipDescription }}</p>
	</div>

	@if(!$isMember)
	<div class="membership-status-card__actions">
		<button type="button" class="membership-status-card__button membership-status-card__button--secondary" data-toggle="modal" data-target="#membershipPackageModal" data-member-type="perusahaan">Member Perusahaan</button>
		<button type="button" class="membership-status-card__button" data-toggle="modal" data-target="#membershipIndividualModal" data-member-type="perorangan">Member Perorangan</button>
	</div>
	@endif
</section>

@include('membernonkeanggotaan.components.ui.membership-package-modal')
@include('membernonkeanggotaan.components.ui.membership-individual-modal')
@endif
