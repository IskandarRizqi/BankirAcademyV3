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
		min-height: 220px;
		padding: 22px;
		background: #ffffff;
	}

	@media (max-width: 575.98px) {
		.membership-individual-modal .modal-header,
		.membership-individual-modal .modal-body {
			padding-left: 16px;
			padding-right: 16px;
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

			<div class="modal-body"></div>
		</div>
	</div>
</div>
