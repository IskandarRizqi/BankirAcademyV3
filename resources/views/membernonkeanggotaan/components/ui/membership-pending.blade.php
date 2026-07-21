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

	.membership-pending-card__cancel {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		min-height: 38px;
		padding: 9px 14px;
		border: 1px solid #fecaca;
		border-radius: 8px;
		background: #fff1f2;
		color: #b91c1c;
		font-size: 13px;
		font-weight: 800;
		cursor: pointer;
		white-space: nowrap;
		transition: background .18s ease, color .18s ease;
	}

	.membership-pending-card__cancel:hover {
		background: #fee2e2;
		color: #991b1b;
	}

	.membership-pending-card__actions {
		display: grid;
		grid-template-columns: repeat(2, minmax(0, 1fr));
		gap: 10px;
	}

	.membership-pending-card__actions form {
		margin: 0;
		width: 100%;
	}

	.membership-pending-card__actions .membership-pending-card__cancel {
		width: 100%;
	}

	.membership-pending-card__continue {
		border-color: #c7d2fe;
		background: #eef0fe;
		color: #4338ca;
	}

	.membership-pending-card__continue:hover {
		background: #e0e7ff;
		color: #3730a3;
	}

	@media (max-width: 575.98px) {
		.membership-pending-card {
			padding: 16px;
		}

		.membership-pending-card__header {
			flex-direction: column;
			gap: 12px;
		}

		.membership-pending-card__cancel {
			width: 100%;
		}

		.membership-pending-card__actions {
			grid-template-columns: 1fr;
		}
	}
</style>
@endonce

<section class="membership-pending-card" aria-labelledby="membership-pending-title">
	<div>
		<div class="membership-pending-card__header">
			<div>
				<p class="membership-pending-card__eyebrow">Status Keanggotaan</p>
				<h2 class="membership-pending-card__title" id="membership-pending-title">Selesaikan proses pembayaran Anda</h2>
			</div>
			<span class="membership-pending-card__icon" aria-hidden="true">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
					<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
					<path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
				</svg>
			</span>
		</div>

		<p class="membership-pending-card__description mt-3">Pembayaran membership Anda sedang diproses oleh sistem. Status membership akan diperbarui secara otomatis setelah pembayaran berhasil.</p>
	</div>

	<div class="membership-pending-card__actions">
		<form method="POST" action="{{ route('membernonanggota.membership.continue-payment') }}">
			@csrf
			<button type="submit" class="membership-pending-card__cancel membership-pending-card__continue">Lanjutkan Pembayaran</button>
		</form>

		<form method="POST" action="{{ route('membernonanggota.membership.cancel') }}" class="js-cancel-membership-form">
			@csrf
			<button type="submit" class="membership-pending-card__cancel">Batal Order Membership</button>
		</form>
	</div>
</section>

@push('scripts')
<script>
	(function() {
		document.querySelectorAll('.js-cancel-membership-form').forEach(function(form) {
			form.addEventListener('submit', function(event) {
				if (!window.Swal || typeof window.Swal.fire !== 'function') {
					return;
				}

				event.preventDefault();

				window.Swal.fire({
					title: 'Batalkan order membership?',
					text: 'Proses pembayaran membership yang sedang berjalan akan dibatalkan.',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonText: 'Ya, batalkan',
					cancelButtonText: 'Tidak',
					reverseButtons: true,
					focusCancel: true
				}).then(function(result) {
					if (result.isConfirmed) {
						HTMLFormElement.prototype.submit.call(form);
					}
				});
			});
		});
	})();
</script>
@endpush
