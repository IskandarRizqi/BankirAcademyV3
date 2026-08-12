@extends('layouts.compact')

@section('content')
    <div class="col-lg-12">
        <div class="card shadow-sm border-0 mb-4">
            {{-- Card Header / Filter Bar --}}
            <div class="card-body">
                <form action="/admin/classes" method="GET">
                    <div class="row align-items-center justify-content-between g-3">
                        <div class="col-lg-8">
                            <div class="row align-items-center">
                                {{-- Range Date Filter --}}
                                <div class="col-md-7 mb-2 mb-md-0">
                                    <label class="form-label font-weight-bold text-muted small mb-1">Periode Tanggal</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" value="{{ $param['date_start'] }}"
                                            name="param_date_start" aria-label="Date Start">
                                        <div class="input-group-append input-group-prepend">
                                            <span class="input-group-text bg-light text-muted">s/d</span>
                                        </div>
                                        <input type="date" class="form-control" value="{{ $param['date_end'] }}"
                                            name="param_date_end" aria-label="Date End">
                                    </div>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="col-md-5 d-flex align-items-end mt-2 mt-md-0 pt-md-4">
                                    <button class="btn btn-primary mr-2 flex-grow-1" type="submit">
                                        <i class="bx bx-search-alt mr-1"></i> Cari
                                    </button>
                                    <a href="/admin/classes" class="btn btn-outline-secondary">
                                        <i class="bx bx-refresh mr-1"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Add New Class --}}
                        <div class="col-lg-4 text-lg-right mt-3 mt-lg-0 pt-lg-4">
                            <a href="/admin/classes/create" class="btn btn-success px-4">
                                <i class="bx bx-plus mr-1"></i> Tambah Kelas Baru
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Main Table Section --}}
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="tblClasses" class="table table-hover align-middle mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th width="5%">Status</th>
                                <th>Tanggal</th>
                                <th>Tipe</th>
                                <th>Jam</th>
                                <th width="20%">Kelas</th>
                                <th>Kategori</th>
                                <th>Instruktur</th>
                                <th class="text-center" width="10%">
                                    Peserta<br>
                                    <small class="text-muted"><span class="text-danger font-weight-bold">A</span> (All) |
                                        <span class="text-success font-weight-bold">L</span> (Lunas)</small>
                                </th>
                                <th class="text-center">Data</th>
                                <th class="text-center" width="8%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($classes as $k => $v)
                                <tr>
                                    {{-- Status Badge --}}
                                    <td>
                                        <span
                                            class="badge badge-{{ $v->status == 1 ? 'success' : 'danger' }} badge-pill px-2 py-1">
                                            {{ $v->status == 1 ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>

                                    {{-- Date --}}
                                    <td>
                                        <span
                                            hidden>{{ $v->date_start ? Carbon\Carbon::parse($v->date_start)->format('U') : 0 }}</span>
                                        @if (!$v->date_start && !$v->date_end && $v->iht == 1)
                                            <span class="badge badge-soft-info badge-pill">Kelas IHT</span>
                                        @elseif($v->date_start)
                                            <div class="small font-weight-bold">
                                                {{ Carbon\Carbon::parse($v->date_start)->format('d/m/Y') }}
                                                <span class="text-muted">s/d</span>
                                                {{ Carbon\Carbon::parse($v->date_end)->format('d/m/Y') }}
                                            </div>
                                        @else
                                            <span class="badge badge-light text-muted">Akan Datang</span>
                                        @endif
                                    </td>

                                    {{-- Class Type --}}
                                    <td>
                                        <span class="badge badge-{{ $v->kategori == 0 ? 'primary' : 'info' }}">
                                            {{ $v->kategori == 0 ? 'Online' : 'Offline' }}
                                        </span>
                                    </td>

                                    {{-- Time --}}
                                    <td>
                                        @if (!$v->date_start && !$v->date_end && $v->iht == 1)
                                            <span class="badge badge-soft-info">Kelas IHT</span>
                                        @elseif($v->jam_acara != null)
                                            <small class="font-weight-bold text-dark"><i
                                                    class="bx bx-time-five mr-1"></i>{{ $v->jam_acara }}</small>
                                        @else
                                            <span class="badge badge-soft-danger text-danger">Belum Set</span>
                                        @endif
                                    </td>

                                    {{-- Class Title --}}
                                    <td>
                                        <div class="text-truncate font-weight-bold text-dark" style="max-width: 220px;"
                                            title="{{ $v->title }}">
                                            {{ $v->title }}
                                        </div>
                                    </td>

                                    {{-- Category --}}
                                    <td><span class="text-muted small font-weight-bold">{{ $v->category }}</span></td>

                                    {{-- Instructors --}}
                                    <td>
                                        @foreach ($v->instructor_list as $i)
                                            <span
                                                class="badge badge-light border text-dark mr-1 mb-1">{{ $i->name }}</span>
                                        @endforeach
                                    </td>

                                    {{-- Participants Count --}}
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2 bs-tooltip"
                                            title="Total Peserta" data-toggle="modal" data-target="#listPesertaModal"
                                            onclick="openPeserta({{ $v->peserta_list['all'] }}, {{ $v->id }})">
                                            {{ count($v->peserta_list['all']) }}
                                        </button>
                                        <span class="text-muted mx-1">|</span>
                                        <button type="button" class="btn btn-sm btn-outline-success py-0 px-2 bs-tooltip"
                                            title="Peserta Lunas" data-toggle="modal" data-target="#listPesertaModal"
                                            onclick="openPeserta({{ $v->peserta_list['lunas'] }}, {{ $v->id }})">
                                            {{ count($v->peserta_list['lunas']) }}
                                        </button>
                                    </td>

                                    {{-- Quick Data Actions --}}
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button
                                                class="btn {{ $v->pricing ? 'btn-info' : 'btn-outline-secondary' }} bs-tooltip"
                                                title="Pricing" onclick="classPricing({{ $v }})">
                                                <i class="bx bx-dollar"></i>
                                            </button>
                                            <button
                                                class="btn {{ count($v->content_list) > 0 ? 'btn-success' : 'btn-outline-secondary' }} bs-tooltip"
                                                title="File Content" onclick="classContent({{ $v }})">
                                                <i class="bx bx-file"></i>
                                            </button>
                                            <a class="btn {{ $v->events_exist ? 'btn-primary' : 'btn-outline-secondary' }} bs-tooltip"
                                                title="Event Schedule"
                                                href="/admin/classes/createevent/{{ $v->id }}">
                                                <i class="bx bx-calendar"></i>
                                            </a>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button
                                                    class="btn {{ $v->certif_exist ? 'btn-warning text-white' : 'btn-outline-secondary' }} dropdown-toggle bs-tooltip"
                                                    type="button" data-toggle="dropdown" aria-expanded="false"
                                                    title="Certificate Setting">
                                                    <i class="bx bx-certification"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right shadow border-0">
                                                    <a class="dropdown-item"
                                                        href="/admin/classes/createcertificate/{{ $v->id }}"><i
                                                            class="bx bx-plus-circle mr-2"></i>Create Certificate</a>
                                                    <a class="dropdown-item"
                                                        href="/admin/classes/previewcertificate/{{ $v->id }}"
                                                        target="_blank"><i class="bx bx-show mr-2"></i>Show
                                                        Certificate</a>
                                                    <a class="dropdown-item"
                                                        href="/admin/classes/getreview/{{ $v->id }}"
                                                        target="_blank"><i class="bx bx-star mr-2"></i>Show Review</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-primary" href="javascript:void(0)"
                                                        data-toggle="modal" data-target="#modalSertifikat"
                                                        onclick="biayasertifikat('{{ $v->id }}','{{ $v->tipebs }}','{{ $v->nominal }}')">
                                                        <i class="bx bx-coin-stack mr-2"></i>Biaya Sertifikat
                                                    </a>
                                                </div>
                                            </div>
                                            <button
                                                class="btn {{ $v->videos ? 'btn-info' : 'btn-outline-secondary' }} bs-tooltip"
                                                title="Video Material" onclick="classVideo({{ $v }})">
                                                <i class="bx bx-video-plus"></i>
                                            </button>
                                        </div>
                                    </td>

                                    {{-- Main Options Dropdown --}}
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light border dropdown-toggle" type="button"
                                                data-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right shadow border-0">
                                                <a class="dropdown-item"
                                                    href="/admin/classes/{{ $v->id }}/edit"><i
                                                        class="bx bx-edit text-warning mr-2"></i>Edit</a>
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                    onclick="activedClasses({{ $v->id }},{{ $v->status }})">
                                                    <i
                                                        class="bx bx-power-off text-info mr-2"></i>{{ $v->status == 1 ? 'De-Activate' : 'Activate' }}
                                                </a>
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                    onclick="openClasses({{ $v->id }},{{ $v->is_open }})">
                                                    <i
                                                        class="bx bx-door-open text-primary mr-2"></i>{{ $v->is_open == 1 ? 'Close Class' : 'Open Class' }}
                                                </a>
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                    data-target="#upcomingmodal" data-toggle="modal"
                                                    onclick="setupcoming({{ $v }})">
                                                    <i class="bx bx-time text-secondary mr-2"></i>Set Status Running
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-danger" href="javascript:void(0)"
                                                    onclick="deleteClasses({{ $v->id }})">
                                                    <i class="bx bx-trash mr-2"></i>Hapus
                                                </a>
                                                <form action="#" method="post" id="formdelclasses">@csrf
                                                    @method('DELETE')</form>
                                                <form action="#" method="get" id="formacclasses">@csrf</form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal List Peserta --}}
    <div class="modal fade" id="listPesertaModal" tabindex="-1" aria-labelledby="listPesertaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title font-weight-bold" id="listPesertaModalLabel"><i
                            class="bx bx-group mr-2"></i>List Peserta Sertifikat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="tblListPeserta" class="table table-hover table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Status</th>
                                    <th>Nama Akun</th>
                                    <th>Nama Sertifikat</th>
                                    <th>No HP</th>
                                    <th>Instansi</th>
                                    <th>Price</th>
                                    <th>Sertifikat</th>
                                </tr>
                            </thead>
                            <tbody id="listPeserta"></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Biaya Sertifikat --}}
    <div class="modal fade" id="modalSertifikat" tabindex="-1" aria-labelledby="modalSertifikatLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form action="/classes/biaya_certificate" method="POST">
                    @csrf
                    <div class="modal-header bg-light">
                        <h5 class="modal-title font-weight-bold" id="modalSertifikatLabel"><i
                                class="bx bx-coin-stack mr-2"></i>Biaya Sertifikat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="id_kelas" id="id_kelas" hidden>
                        <div class="form-group">
                            <label class="font-weight-bold">Tipe Biaya</label>
                            <select name="tipe" id="tipe" class="form-control" required>
                                <option value="0">Nominal (Fixed IDR)</option>
                                <option value="1">Persentase (%)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Nominal / Persentase</label>
                            <input type="text" name="nominal" id="nominal" class="form-control"
                                placeholder="Masukkan nilai" required>
                            <small id="labelNominal" class="form-text text-primary font-weight-bold mt-1"></small>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Upcoming / Reschedule / Running --}}
    <div class="modal fade" id="upcomingmodal" tabindex="-1" aria-labelledby="upcomingmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title font-weight-bold"><i class="bx bx-time-five mr-2"></i>Update Status Kelas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/admin/classes/setupcoming" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="text" name="upcoming_id" id="upcoming_id" hidden>
                        <div class="form-group">
                            <label class="font-weight-bold mb-3">Pilih Status Keberlangsungan Kelas:</label>
                            <div class="custom-control custom-radio mb-2">
                                <input type="radio" id="upcoming0" name="upcoming" value="0"
                                    class="custom-control-input">
                                <label class="custom-control-label font-weight-bold text-success" for="upcoming0">
                                    Running <small class="text-muted d-block">Kelas sedang berjalan aktif</small>
                                </label>
                            </div>
                            <div class="custom-control custom-radio mb-2">
                                <input type="radio" id="upcoming2" name="upcoming" value="2"
                                    class="custom-control-input">
                                <label class="custom-control-label font-weight-bold text-warning" for="upcoming2">
                                    Re-Schedule <small class="text-muted d-block">Jadwal kelas ditunda / diubah</small>
                                </label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="upcoming3" name="upcoming" value="1"
                                    class="custom-control-input">
                                <label class="custom-control-label font-weight-bold text-info" for="upcoming3">
                                    Upcoming <small class="text-muted d-block">Kelas dijadwalkan di masa depan</small>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary px-4" type="submit">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('backend.classes.newclassesmodal')
    @include('backend.classes.classpricingmodal')
    @include('backend.classes.classvideomodal')
    @include('backend.classes.classcontentmodal')
@endsection

@section('custom-js')
    <script>
        createDataTable('#tblClasses');
        createDataTable('#tblListPeserta');

        $(document).ready(function() {
            $('#tipe, #nominal').on('input change', function() {
                var v = $('#nominal').val();
                if ($('#tipe').val() == 0) {
                    var n = Number(v).toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    });
                    $('#labelNominal').text(n);
                } else {
                    $('#labelNominal').text(v + ' %');
                }
            });

            $('#numClassPrice').on('input change', function() {
                toggleDiscountInput();
                updatePricingPreview();
            });

            $(document).on('click', '.pricing-help', function(event) {
                event.preventDefault();
                event.stopPropagation();

                $('.pricing-help-panel').remove();
                $('<span>', {
                    class: 'pricing-help-panel',
                    role: 'tooltip',
                    text: $(this).data('help-title') + ': ' + $(this).data('help-content')
                }).insertAfter(this);
            });

            $(document).on('click', function(event) {
                if (!$(event.target).closest('.pricing-help, .pricing-help-panel').length) {
                    $('.pricing-help-panel').remove();
                }
            });

            $('#discount_type').on('change', function() {
                toggleDiscountInput();
                updatePricingPreview();
            });

            $('#discount_value').on('input change', function() {
                if ($('#discount_type').val() === 'nominal') {
                    $(this).val(formatRupiah($(this).val()));
                }
                updatePricingPreview();
            });

            $('#newClassesForm').on('submit', function() {
                if ($('#discount_type').val() === 'nominal') {
                    $('#discount_value').val(normalizeRupiah($('#discount_value').val()));
                }
            });
        });

        function toggleDiscountInput() {
            var nominal = $('#discount_type').val() === 'nominal';
            var price = Number($('#numClassPrice').val()) || 0;
            $('#discount-currency-prefix').toggle(nominal);
            $('#discount-percent-suffix').toggle(!nominal);
            $('#discount_value').attr('max', nominal ? price * 0.15 : 15);

            if (nominal) {
                $('#discount_value').attr('inputmode', 'numeric');
                $('#discount_value').val(formatRupiah($('#discount_value').val()));
            } else {
                $('#discount_value').attr('inputmode', 'decimal');
                $('#discount_value').val(normalizePercent($('#discount_value').val()));
            }
        }

        function normalizeRupiah(value) {
            return String(value || '').replace(/\D/g, '');
        }

        function formatRupiah(value) {
            var normalized = normalizeRupiah(value);
            return normalized ? Number(normalized).toLocaleString('id-ID') : '';
        }

        function normalizePercent(value) {
            return String(value || '').replace(/[^0-9.,]/g, '').replace(',', '.');
        }

        function updatePricingPreview() {
            var price = Number($('#numClassPrice').val()) || 0;
            var rawValue = $('#discount_type').val() === 'nominal' ?
                normalizeRupiah($('#discount_value').val()) :
                normalizePercent($('#discount_value').val());
            var value = Number(rawValue) || 0;
            var discount = $('#discount_type').val() === 'percent' ?
                price * value / 100 :
                value;

            $('#nomClassPrice').text('Rp. ' + price.toLocaleString('id-ID'));
            $('#discount-preview').text(
                'Harga setelah diskon: Rp ' + Math.max(0, price - discount).toLocaleString('id-ID')
            );
        }

        function biayasertifikat(id, tipe, nominal) {
            $('#id_kelas').val(id);
            $('#tipe').val(tipe);
            $('#nominal').val(nominal);
            $('#nominal').change();
        }

        function openPeserta(data, id_class) {
            let html = '';
            $('#listPeserta').html('');

            if (data.length > 0) {
                data.forEach(el => {
                    let status = el.status ? '<span class="badge badge-success">Lunas</span>' :
                        '<span class="badge badge-warning">Belum Lunas</span>';
                    html += `
                    <tr>
                        <td>${status}</td>
                        <td class="font-weight-bold">${el.account_name ?? '-'}</td>
                        <td>${el.certificate_name ?? '-'}</td>
                        <td>${el.phone ?? '-'}</td>
                        <td>${el.institution ?? '-'}</td>
                        <td>Rp ${Number(el.price || 0).toLocaleString('id-ID')}</td>
                        <td>${el.certificate_code ?? '-'}</td>
                    </tr>
                `;
                });
            } else {
                html = `<tr><td colspan="7" class="text-center text-muted py-3">Tidak ada data peserta.</td></tr>`;
            }
            $('#listPeserta').html(html);
        }

        function activedClasses(id, s) {
            swal({
                title: 'Are you sure?',
                text: "You want change status class?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirm',
                padding: '2em'
            }).then(function(result) {
                if (result.value) {
                    $('#formacclasses').attr('action', '/admin/classes/activated/' + id + '/' + s);
                    $('#formacclasses').submit();
                } else {
                    $('#formacclasses').attr('action', '#');
                }
            })
        }

        function deleteClasses(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                padding: '2em'
            }).then(function(result) {
                if (result.value) {
                    $('#formdelclasses').attr('action', '/admin/classes/' + id);
                    $('#formdelclasses').submit();
                } else {
                    $('#formdelclasses').attr('action', '#');
                }
            })
        }

        function classVideo(c) {
            $('.hdnClassesId').val(c.id);
            $('.activeClassTitle').text(c.title);
            if (c.videos) {
                $('#video_preview').attr('src', '/video/kelas/' + `{{ Auth::user()->email }}` + '/' + c.videos.image);
            }
            openmodal('#classVideoModal');
        }

        function classPricing(c) {
            $('#numClassPrice').val(0);
            $('#discount_type').val('percent');
            $('#discount_value').val(0);
            $('#individual_discount').val(0);
            $('#company_online_discount').val(0);
            $('#company_offline_discount').val(0);
            $('#company_iht_discount').val(0);
            $('#iht-discount-only').val(0);
            $('#bolClassGratis').prop('checked', false);

            const isIht = Number(c.iht) === 1;
            const classType = isIht ? 'iht' : (Number(c.kategori) === 1 ? 'offline' : 'online');
            $('#regular-pricing-fields').toggle(!isIht);
            $('#iht-pricing-fields').toggle(isIht);
            $('#numClassPrice').prop('required', !isIht);
            $('.company-discount-online').toggle(classType === 'online');
            $('.company-discount-offline').toggle(classType === 'offline');
            $('.company-discount-iht').toggle(classType === 'iht');

            if (c.pricing) {
                $('#numClassPrice').val(c.pricing.price).trigger('change').trigger('input');
                if (c.pricing.gratis == 1) {
                    $('#bolClassGratis').prop('checked', true);
                }

                $('#discount_type').val(c.pricing.discount_type || 'nominal');
                $('#discount_value').val(c.pricing.discount_value || c.pricing.promo_price || 0);

                const discounts = c.pricing.membership_discounts || [];
                const getDiscount = (membershipType, category) => {
                    const discount = discounts.find(item => item.membership_type === membershipType && item
                        .discount_category === category);
                    return discount ? discount.discount_percent : 0;
                };

                $('#individual_discount').val(getDiscount('individual', 'individual_class'));
                $('#company_online_discount').val(getDiscount('company', 'company_online'));
                $('#company_offline_discount').val(getDiscount('company', 'company_offline'));
                $('#company_iht_discount').val(getDiscount('company', 'company_iht'));
                $('#iht-discount-only').val(getDiscount('company', 'company_iht'));
            }

            $('#discount_type').trigger('change');
            $('.hdnClassesId').val(c.id);
            $('.activeClassTitle').text(c.title);
            openmodal('#classPricingModal');
        }

        function classContent(c) {
            $('#tbdClassContent').html('');
            $('.hdnClassesId').val(c.id);
            if (c.content_list) {
                console.log(c.content_list);
                c.content_list.forEach(e => {
                    var sd = '';
                    var sg = '';
                    var sv = '';
                    var dd = 'style="display:none;"';
                    var dg = 'style="display:none;"';
                    var dv = 'style="display:none;"';

                    if (e.type == 1) {
                        sd = 'selected';
                        dd = '';
                    } else if (e.type == 2) {
                        sg = 'selected';
                        dg = '';
                    } else if (e.type == 3) {
                        sv = 'selected';
                        dv = '';
                    }

                    $('#tbdClassContent').append('' +
                        '<tr>' +
                        '	<td>' +
                        '		<input type="hidden" name="txtClassContentId[]" class="form-control txtClassContentId" value="' +
                        e.id + '">' +
                        '		<select name="slcClassContentType[]" class="form-control slcClassContentType" onchange="slcClassContentTypeChanged($(this))">' +
                        '			<option value="1" ' + sd + '>Dokumen</option>' +
                        '			<option value="2" ' + sg + '>Gambar</option>' +
                        '			<option value="3" ' + sv + '>Video</option>' +
                        '		</select>' +
                        '	</td>' +
                        '	<td>' +
                        '		<input type="text" name="txtClassContentTitle[]" class="form-control txtClassContentTitle" value="' +
                        e.title + '">' +
                        '	</td>' +
                        '	<td>' +
                        '		<small>Change File Only If Needed</small><a href="getBerkas?rf=/' + e.url +
                        '" target="_blank"> Download</a>' +
                        '		<input type="file" name="txtClassContentDoc[]" class="form-control txtClassContentDoc" ' +
                        dd + ' value="' + e.url + '">' +
                        '		<input type="file" name="txtClassContentImg[]" class="form-control txtClassContentImg" ' +
                        dg + ' value="' + e.url + '">' +
                        '		<input type="text" name="txtClassContentVid[]" class="form-control txtClassContentVid" ' +
                        dv + ' value="' + e.url + '">' +
                        '	</td>' +
                        '	<td>' +
                        '		<button class="btn btn-danger" onclick="delClassContentRow($(this),' + e.id +
                        ')"><i class="bx bx-trash"></i></button>' +
                        '	</td>' +
                        '</tr>' +
                        '');
                });
            }
            openmodal('#classContentModal');
        }

        function addNewClassContentRow() {
            $('#tbdClassContent').append(
                '<tr>' +
                '	<td>' +
                '		<input type="hidden" name="txtClassContentId[]" class="form-control txtClassContentId" value="0">' +
                '		<select name="slcClassContentType[]" class="form-control slcClassContentType" onchange="slcClassContentTypeChanged($(this))">' +
                '			<option value="1">Dokumen</option>' +
                '			<option value="2">Gambar</option>' +
                '			<option value="3">Video</option>' +
                '		</select>' +
                '	</td>' +
                '	<td>' +
                '		<input type="text" name="txtClassContentTitle[]" class="form-control txtClassContentTitle">' +
                '	</td>' +
                '	<td>' +
                '		<input type="file" name="txtClassContentDoc[]" class="form-control txtClassContentDoc">' +
                '		<input type="file" name="txtClassContentImg[]" class="form-control txtClassContentImg" style="display: none;">' +
                '		<input type="text" name="txtClassContentVid[]" class="form-control txtClassContentVid" style="display: none;">' +
                '	</td>' +
                '	<td>' +
                '		<button class="btn btn-danger" onclick="delClassContentRow($(this),0)"><i class="bx bx-trash"></i></button>' +
                '	</td>' +
                '</tr>');
        }

        function slcClassContentTypeChanged(ths) {
            ths.parent('td').parent('tr').find('.txtClassContentDoc,.txtClassContentImg,.txtClassContentVid').hide();
            var v = ths.val();
            if (v == 1) {
                ths.parent('td').parent('tr').find('.txtClassContentDoc').show();
            } else if (v == 2) {
                ths.parent('td').parent('tr').find('.txtClassContentImg').show();
            } else if (v == 3) {
                ths.parent('td').parent('tr').find('.txtClassContentVid').show();
            }
        }

        function delClassContentRow(ths, id) {
            var tr = ths.parent('td').parent('tr');
            $('.hdnContentTBDId').val($('.hdnContentTBDId').val() + ',' + id);
            if (!tr.attr('clsCtnId') || tr.attr('clsCtnId') == 0) {
                tr.remove();
            }
        }
    </script>
@endsection
