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

	.membership-individual-modal__subtitle {
		margin: 6px 0 0;
		color: #6b7280;
		font-size: 13px;
		line-height: 1.6;
	}

	.membership-individual-modal .modal-body {
		padding: 22px;
	}

	.membership-individual-grid {
		display: grid;
		grid-template-columns: repeat(2, minmax(0, 1fr));
		gap: 16px;
	}

	.membership-individual-card {
		display: flex;
		flex-direction: column;
		min-height: 100%;
		padding: 18px;
		border: 1px solid #e5e7eb;
		border-radius: 14px;
		background: #ffffff;
	}

	.membership-individual-card--featured {
		border-color: #facc15;
		background: linear-gradient(180deg, #fffbeb 0%, #ffffff 52%);
		box-shadow: 0 14px 32px rgba(184, 134, 11, .12);
	}

	.membership-individual-card__badge {
		display: inline-flex;
		align-items: center;
		width: fit-content;
		min-height: 28px;
		padding: 5px 10px;
		border-radius: 999px;
		background: #fef3c7;
		color: #92400e;
		font-size: 11px;
		font-weight: 800;
		letter-spacing: .03em;
		text-transform: uppercase;
	}

	.membership-individual-card__name {
		margin: 14px 0 8px;
		color: #111827;
		font-size: 22px;
		font-weight: 800;
		letter-spacing: -0.03em;
		line-height: 1.2;
	}

	.membership-individual-card__price {
		margin: 0;
		color: #111827;
		font-size: 26px;
		font-weight: 900;
		line-height: 1.15;
	}

	.membership-individual-card__price small {
		color: #6b7280;
		font-size: 13px;
		font-weight: 700;
	}

	.membership-individual-card__description {
		margin: 10px 0 16px;
		color: #6b7280;
		font-size: 13px;
		line-height: 1.6;
	}

	.membership-individual-card__benefits {
		display: grid;
		gap: 10px;
		padding: 0;
		margin: 0 0 18px;
		list-style: none;
	}

	.membership-individual-card__benefit {
		display: flex;
		align-items: flex-start;
		gap: 8px;
		color: #374151;
		font-size: 13px;
		font-weight: 600;
		line-height: 1.45;
	}

	.membership-individual-card__benefit svg {
		width: 16px;
		height: 16px;
		margin-top: 1px;
		flex: 0 0 auto;
	}

	.membership-individual-card__benefit>span {
		display: grid;
		grid-template-columns: minmax(0, 1fr) minmax(80px, auto);
		gap: 2px 12px;
		align-items: start;
		width: 100%;
	}

	.membership-individual-card__benefit strong {
		color: #374151;
		font-weight: 700;
	}

	.membership-individual-card__benefit small {
		max-width: 150px;
		color: #6b7280;
		font-size: 11.5px;
		font-weight: 600;
		line-height: 1.35;
		text-align: right;
		word-break: normal;
		overflow-wrap: anywhere;
	}

	.membership-individual-card__benefit--muted {
		color: #9ca3af;
	}

	.membership-individual-card__benefit--available svg {
		color: #059669;
	}

	.membership-individual-card__benefit--muted svg {
		color: #d97706;
	}

	.membership-individual-card__divider {
		width: 100%;
		height: 1px;
		margin: 2px 0 14px;
		background: #e5e7eb;
	}

	.membership-individual-card__note {
		margin: 0 0 18px;
		color: #4b5563;
		font-size: 11.5px;
		font-weight: 600;
		line-height: 1.45;
	}

	.membership-individual-card__action {
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

	.membership-individual-card__action:hover {
		background: var(--primary, #4F46E5);
		color: #ffffff;
		transform: translateY(-1px);
	}

	.membership-individual-card__action[disabled] {
		background: #f3f4f6;
		color: #9ca3af;
		cursor: not-allowed;
		transform: none;
	}

	@media (max-width: 767.98px) {
		.membership-individual-grid {
			grid-template-columns: 1fr;
		}
	}

	@media (max-width: 575.98px) {

		.membership-individual-modal .modal-header,
		.membership-individual-modal .modal-body {
			padding-left: 16px;
			padding-right: 16px;
		}

		.membership-individual-card__benefit>span {
			grid-template-columns: minmax(0, 1fr) minmax(80px, 42%);
			gap: 2px 8px;
		}

		.membership-individual-card__benefit small {
			max-width: none;
		}
	}

	@media (prefers-reduced-motion: reduce) {
		.membership-individual-card__action {
			transition: none;
		}

		.membership-individual-card__action:hover {
			transform: none;
		}
	}
</style>
@endonce

@php
$facilities = [
['name' => 'Informasi lowongan umum', 'non_member' => 'Terbatas', 'member' => 'Ya'],
['name' => 'Lowongan eksklusif mitra', 'non_member' => 'Tidak', 'member' => 'Ya'],
['name' => 'Diskon kelas', 'non_member' => 'Tidak ada', 'member' => '15%'],
['name' => 'E-book gratis', 'non_member' => 'Terbatas', 'member' => 'Ya'],
['name' => 'Konsultasi karier melalui chat', 'non_member' => 'Berbayar', 'member' => 'Ya'],
['name' => 'Buat CV ATS', 'non_member' => 'Berbayar', 'member' => 'Gratis'],
['name' => 'Review CV', 'non_member' => 'Berbayar', 'member' => 'Gratis'],
['name' => 'Grup komunitas', 'non_member' => 'Tidak', 'member' => 'Ya'],
['name' => 'Webinar eksklusif', 'non_member' => 'Tidak', 'member' => 'Ya'],
['name' => 'Program afiliasi', 'non_member' => 'Tidak', 'member' => 'Ya'],
['name' => 'Prioritas bootcamp', 'non_member' => 'Tidak', 'member' => 'Ya'],
['name' => 'Member point', 'non_member' => 'Tidak', 'member' => 'Ya'],
['name' => 'Mentoring', 'non_member' => 'Harga normal', 'member' => 'Ya'],
['name' => 'Kartu member digital', 'non_member' => 'Tidak', 'member' => 'Ya'],
];

$membershipCards = [
[
'name' => 'Non Member',
'price' => 'Rp0,-',
'description' => 'Akses dasar untuk mulai membangun pengalaman dan jaringan profesional.',
'featured' => false,
'column' => 'non_member',
'note' => 'Fasilitas terbatas sesuai status non member.',
],
[
'name' => 'Member',
'price' => 'Rp99.000,-',
'description' => 'Akses premium untuk mendukung perkembangan karier dan peluang profesional.',
'featured' => true,
'column' => 'member',
'note' => 'Membership berlaku selama 1 tahun.',
],
];


$nominal = 99000;
$userid = Auth::user()->id;
$statuspaymentmembership = 2;
$qty = 1;
$pembelian = 'Membership';
$keterangan = 'Membership perorangan';
$pembeliantipe = 1;
$tipemembership = 2;
@endphp

<div class="modal fade membership-individual-modal" id="membershipIndividualModal" tabindex="-1" role="dialog" aria-labelledby="membershipIndividualModalTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div>
					<h5 class="membership-individual-modal__title" id="membershipIndividualModalTitle">Pilih Membership Perorangan</h5>
					<p class="membership-individual-modal__subtitle">Bandingkan fasilitas non member dan member sebelum melanjutkan pendaftaran.</p>
				</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<div class="membership-individual-grid">
					@foreach($membershipCards as $card)
					<article class="membership-individual-card {{ $card['featured'] ? 'membership-individual-card--featured' : '' }}" aria-labelledby="individual-{{ $card['column'] }}-title">
						@if($card['featured'])
						<del class="membership-package-card__price-before">Rp299.000,- /tahun</del>
						@endif
						<p class="membership-individual-card__price">{{ $card['price'] }} <small>/tahun</small></p>
						<h3 class="membership-individual-card__name" id="individual-{{ $card['column'] }}-title">{{ $card['name'] }}</h3>
						<p class="membership-individual-card__description">{{ $card['description'] }}</p>

						<ul class="membership-individual-card__benefits">
							@foreach($facilities as $facility)
							<li class="membership-individual-card__benefit {{ $card['featured'] ? 'membership-individual-card__benefit--available' : 'membership-individual-card__benefit--muted' }}">
								@if($card['featured'])
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
									<path d="M20 6 9 17l-5-5" />
								</svg>
								@else
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
									<path d="M18 6 6 18" />
									<path d="m6 6 12 12" />
								</svg>
								@endif
								<span>
									<strong>{{ $facility['name'] }}</strong>
									<small>{{ $facility[$card['column']] }}</small>
								</span>
							</li>
							@endforeach
						</ul>

						<div class="membership-individual-card__divider"></div>
						@if($card['featured'])
						<!-- <button type="button" class="membership-individual-card__action">Berlangganan sekarang</button> -->
						<form action="/payment-membership" method="post">
							<input type="hidden" name="nominal" value="{{$nominal}}">
							<input type="hidden" name="user_id" value="{{ $userid }}">
							<input type="hidden" name="status_membership" value="{{$statuspaymentmembership}}">
							<input type="hidden" name="qty" value="{{$qty}}">
							<input type="hidden" name="pembelian" value="{{$pembelian}}">
							<input type="hidden" name="keterangan" value="{{$keterangan}}">
							<input type="hidden" name="pembelian_tipe" value="{{$pembeliantipe}}">
							<input type="hidden" name="membership_tipe" value="{{$tipemembership}}">
							@csrf
							<button type="submit" class="membership-package-card__action">Berlangganan sekarang</button>
						</form>
						@else
						<button type="button" class="membership-individual-card__action" disabled>Paket Saat Ini</button>
						@endif
					</article>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>