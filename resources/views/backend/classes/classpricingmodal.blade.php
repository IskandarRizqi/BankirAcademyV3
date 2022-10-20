<div class="modal fade modalwithselect2" id="classPricingModal" role="dialog" aria-labelledby="classPricingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="classPricingModalLabel">Pricing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closemodal('#classPricingModal')">
					<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
				<h5 class="activeClassTitle">CLASS NAME GOES HERE</h5>
				<form action="/admin/classes/setpricing" id="newClassesForm" method="POST" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="_method" value="POST" id="hdnClassesMethod">
					<input type="hidden" name="hdnClassesId" value="0" class="hdnClassesId">

					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="numClassPrice">Price</label>
								<small id="nomClassPrice">Rp.0,00</small>
								<input type="number" name="numClassPrice" id="numClassPrice" class="form-control clsNumberOnPrice" value="0" required>
							</div>
							<hr>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<input type="checkbox" name="bolClassPromo" id="bolClassPromo" value="1">
								<label for="bolClassPromo">Promo</label>
							</div>
						</div>
						<div class="col-lg-10">
							<div class="form-group">
								<label for="datPromoDateStart">Promo Date</label>
								<small class="inputerrormessage text-danger" input-target="datPromoDateStart" style="display: none;"></small>
								<small class="inputerrormessage text-danger" input-target="datPromoDateEnd" style="display: none;"></small>
								<div class="input-group mb-4">
									<input type="date" class="form-control" name="datPromoDateStart" id="datPromoDateStart" placeholder="Promo Start" aria-label="Promo Start">
									<div class="input-group-append">
										<span class="input-group-text" id="basic-addon5">s/d</span>
									</div>
									<input type="date" class="form-control" name="datPromoDateEnd" id="datPromoDateEnd" placeholder="Promo End" aria-label="Promo End">
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label for="numClassPromo">Promo</label>
								<small id="nomClassPromo">Rp.0,00</small>
								<div class="row">
									<div class="col-lg-9">
										<input type="number" name="numClassPromo" id="numClassPromo" class="form-control clsNumberOnPrice" value="0">
									</div>
									<div class="col-lg-3">
										<div class="input-group mb-4">
											<input type="number" name="numClassPromoPrctg" id="numClassPromoPrctg" class="form-control clsNumberOnPrice" value="0">
											<div class="input-group-append">
												<span class="input-group-text">%</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<button class="btn" data-dismiss="modal" onclick="closemodal('#classPricingModal')"><i class="flaticon-cancel-12"></i> Discard</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>