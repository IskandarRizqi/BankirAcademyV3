<style>
    .pricing-help {
        width: 20px;
        height: 20px;
        padding: 0;
        border: 1px solid #4361ee;
        border-radius: 50%;
        color: #4361ee;
        font-size: 12px;
        font-weight: 700;
        line-height: 18px;
        text-align: center;
    }

    .pricing-help-panel {
        display: block;
        max-width: 360px;
        margin-top: 8px;
        padding: 10px 12px;
        border-left: 3px solid #4361ee;
        border-radius: 4px;
        background: #f4f6fd;
        color: #515365;
        font-size: 12px;
        font-weight: 400;
        line-height: 1.5;
    }

    .pricing-membership-card {
        width: 100%;
    }

    .pricing-membership-card label,
    .pricing-membership-card input,
    .pricing-membership-card .company-discount-online,
    .pricing-membership-card .company-discount-offline,
    .pricing-membership-card .company-discount-iht {
        display: block;
        width: 100%;
    }
</style>
<div class="modal fade modalwithselect2" id="classPricingModal" role="dialog" aria-labelledby="classPricingModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="classPricingModalLabel">Class Pricing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    onclick="closemodal('#classPricingModal')">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <h5 class="activeClassTitle text-uppercase">CLASS NAME GOES HERE</h5>
                <form action="/admin/classes/setpricing" id="newClassesForm" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="POST" id="hdnClassesMethod">
                    <input type="hidden" name="hdnClassesId" value="0" class="hdnClassesId">

                    <div id="regular-pricing-fields">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="numClassPrice">Harga Normal</label>
                                    <small id="nomClassPrice">Rp.0,00</small>
                                    <input type="number" name="numClassPrice" id="numClassPrice"
                                        class="form-control clsNumberOnPrice" value="0" required>
                                </div>
                                <hr>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="discount_type">
                                        Diskon Umum
                                        <button type="button"
                                            class="btn btn-link btn-sm p-0 ml-1 pricing-help"
                                            data-help-title="Aturan Diskon Umum"
                                            data-help-content="Batas diskon umum maksimal 15% dari harga normal."
                                            aria-label="Baca aturan diskon umum">?</button>
                                    </label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select name="discount_type" id="discount_type" class="form-control">
                                                <option value="percent">Persentase</option>
                                                <option value="nominal">Nominal</option>
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <div class="input-group-prepend" id="discount-currency-prefix" style="display: none;">
                                                    <span class="input-group-text">Rp</span>
                                                </div>
                                                <input type="text" name="discount_value" id="discount_value" inputmode="decimal" min="0" class="form-control" value="0" autocomplete="off">
                                                <div class="input-group-append" id="discount-percent-suffix">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                            <small id="discount-preview" class="form-text text-success font-weight-bold">Harga setelah diskon: Rp0</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="border rounded p-3 h-100 pricing-membership-card">
                                            <label for="individual_discount">
                                                Diskon Membership Perorangan (%)
                                                <button type="button"
                                                    class="btn btn-link btn-sm p-0 ml-1 pricing-help"
                                                    data-help-title="Aturan Membership Perorangan"
                                                    data-help-content="Diskon umum dan diskon membership perorangan dijumlahkan. Total diskon maksimal 15% dari harga normal."
                                                    aria-label="Baca aturan diskon membership perorangan">?</button>
                                            </label>
                                            <input type="number" name="individual_discount" id="individual_discount" step="any" min="0" max="15" class="form-control" value="0">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="border rounded p-3 h-100 pricing-membership-card">
                                            <label>
                                                Diskon Membership Perusahaan (%)
                                                <button type="button"
                                                    class="btn btn-link btn-sm p-0 ml-1 pricing-help"
                                                    data-help-title="Aturan Membership Perusahaan"
                                                    data-help-content="Untuk membership perusahaan, sistem menggunakan diskon terbesar antara diskon umum dan diskon membership. Diskon Online atau Offline maksimal 50%."
                                                    aria-label="Baca aturan diskon membership perusahaan">?</button>
                                            </label>
                                            <div class="company-discount-online">
                                                <input type="number" name="company_online_discount" id="company_online_discount" step="any" min="0" max="50" class="form-control" placeholder="Diskon Online">
                                            </div>
                                            <div class="company-discount-offline">
                                                <input type="number" name="company_offline_discount" id="company_offline_discount" step="any" min="0" max="50" class="form-control" placeholder="Diskon Offline">
                                            </div>
                                            <div class="company-discount-iht">
                                                <input type="number" name="company_iht_discount" id="company_iht_discount" step="any" min="0" max="50" class="form-control" placeholder="Diskon IHT">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 d-flex">
                                <div class="form-group">
                                    <input type="checkbox" name="bolClassGratis" id="bolClassGratis" value="1">
                                    <label for="bolClassGratis">Kelas Gratis</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="iht-pricing-fields" class="alert alert-info" style="display: none;">
                        <strong>Kelas IHT</strong>
                        <p class="mb-2">Kelas IHT diproses melalui order manual admin.</p>
                        <label for="iht-discount-only">Diskon Membership Perusahaan IHT (%)</label>
                        <input type="number" name="company_iht_discount_iht" id="iht-discount-only" step="any" min="0" max="50" class="form-control" value="0">
                        <small class="form-text text-muted">Nilai maksimal 50%. Nilai ini disalin ke konfigurasi perusahaan IHT.</small>
                    </div>
                    <span class="btn" data-dismiss="modal" onclick="closemodal('#classPricingModal')"><i
                            class="flaticon-cancel-12"></i> Discard</span>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>