@php
    $modalId = $modalId ?? 'eventRegistrationModal';
    $classId = data_get($class, 'id');
    $classTitle = data_get($class, 'title', 'Kelas Bankir Academy');
    $pricing = data_get($class, 'pricing');
    $isPriceComingSoon = ! $pricing || (int) data_get($pricing, 'gratis', 0) === 1;
    $price = (int) data_get($pricing, 'price', 0);
    $promoPrice = (int) data_get($pricing, 'promo_price', 0);
    $finalPrice = max(0, $price - $promoPrice);
    $priceLabel = $isPriceComingSoon
        ? 'Price Coming Soon'
        : ($finalPrice > 0 ? 'Rp ' . number_format($finalPrice, 0, ',', '.') : 'Gratis');
    $certificateFee = (int) data_get($sertif ?? null, 'nominal', 100000);
@endphp

@once
<style>
    .event-registration-modal .modal-content {
        border: 0;
        border-radius: 24px;
        box-shadow: 0 28px 80px rgba(15, 23, 42, .28);
        overflow: hidden;
    }

    .event-registration-modal__header {
        background: linear-gradient(135deg, #111827, #312e81);
        color: #ffffff;
        border-bottom: 0;
    }

    .event-registration-modal__subtitle {
        margin: 6px 0 0;
        color: rgba(255, 255, 255, .68);
        font-size: 13px;
        line-height: 1.55;
    }

    .event-registration-modal__summary {
        display: grid;
        grid-template-columns: minmax(0, 1.4fr) minmax(220px, .6fr);
        gap: 14px;
        margin-bottom: 18px;
    }

    .event-registration-modal__card {
        padding: 16px;
        border: 1px solid #eef2f7;
        border-radius: 18px;
        background: #f9fafb;
    }

    .event-registration-modal__label {
        display: block;
        margin-bottom: 6px;
        color: #6b7280;
        font-size: 11px;
        font-weight: 900;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .event-registration-modal__value {
        display: block;
        color: #111827;
        font-size: 18px;
        font-weight: 950;
        line-height: 1.35;
    }

    .event-registration-option {
        display: block;
        height: 100%;
        cursor: pointer;
    }

    .event-registration-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .event-registration-option__box {
        height: 100%;
        padding: 14px;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        background: #ffffff;
        transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
    }

    .event-registration-option input:checked + .event-registration-option__box {
        border-color: #4f46e5;
        box-shadow: 0 14px 28px rgba(79, 70, 229, .14);
        transform: translateY(-1px);
    }

    .event-registration-participant {
        border: 1px solid #eef2f7;
        border-radius: 18px;
        background: #ffffff;
        overflow: hidden;
    }

    .event-registration-participant__header {
        padding: 10px 14px;
        background: #f8fafc;
        border-bottom: 1px solid #eef2f7;
        color: #4f46e5;
        font-size: 12px;
        font-weight: 950;
    }

    @media (max-width: 767.98px) {
        .event-registration-modal__summary {
            grid-template-columns: 1fr;
        }
    }
</style>
@endonce

<div class="modal fade event-registration-modal" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="{{ $modalId }}Title" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ url('/payment-order-class') }}" method="POST" id="eventRegistrationForm">
                @csrf
                <input type="hidden" name="class_id" value="{{ $classId }}">
                <input type="hidden" name="sertifikat_invoice" id="eventRegistrationCertificateValue" value="1">

                <div class="modal-header event-registration-modal__header">
                    <div>
                        <h5 class="modal-title font-weight-bold" id="{{ $modalId }}Title">Daftar Kelas</h5>
                        <p class="event-registration-modal__subtitle">Lengkapi data peserta untuk melanjutkan pendaftaran atau pembelian kelas.</p>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body p-4">
                    <div class="event-registration-modal__summary">
                        <div class="event-registration-modal__card">
                            <span class="event-registration-modal__label">Kelas</span>
                            <span class="event-registration-modal__value">{{ $classTitle }}</span>
                        </div>
                        <div class="event-registration-modal__card">
                            <span class="event-registration-modal__label">Harga</span>
                            <span class="event-registration-modal__value">{{ $priceLabel }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 mb-3">
                            <label for="eventRegistrationParticipantCount" class="font-weight-bold text-dark">Jumlah Peserta</label>
                            <input type="number" min="1" value="1" class="form-control form-control-lg" id="eventRegistrationParticipantCount" name="jml_peserta" required>
                        </div>
                        <div class="col-lg-8 mb-3">
                            <label class="font-weight-bold text-dark">Sertifikat</label>
                            <div class="row">
                                <div class="col-md-6 mb-2 mb-md-0">
                                    <label class="event-registration-option mb-0">
                                        <input type="radio" name="event_registration_certificate" value="1" checked>
                                        <span class="event-registration-option__box d-block">
                                            <strong class="d-block text-success">Ya, butuh sertifikat</strong>
                                            <small class="text-muted">+ Rp {{ number_format($certificateFee, 0, ',', '.') }} / peserta</small>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="event-registration-option mb-0">
                                        <input type="radio" name="event_registration_certificate" value="0">
                                        <span class="event-registration-option__box d-block">
                                            <strong class="d-block text-secondary">Tidak perlu sertifikat</strong>
                                            <small class="text-muted">Tidak ada biaya tambahan</small>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-2" id="eventRegistrationParticipants"></div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary font-weight-bold js-event-registration-submit" data-loading-text="Memproses...">Lanjut ke Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</div>

@once
<script>
    (function () {
        function notifyRegistration(message) {
            if (window.Swal) {
                Swal.fire({ title: 'Pemberitahuan', text: message, icon: 'warning' });
                return;
            }

            alert(message);
        }

        function participantTemplate(index) {
            return '' +
                '<div class="event-registration-participant mb-3">' +
                '<div class="event-registration-participant__header">Peserta #' + index + '</div>' +
                '<div class="p-3"><div class="row">' +
                '<div class="col-lg-4 mb-2 mb-lg-0"><input type="text" class="form-control" name="nama[]" placeholder="Nama peserta" required></div>' +
                '<div class="col-lg-4 mb-2 mb-lg-0"><input type="email" class="form-control" name="email[]" placeholder="Email peserta" required></div>' +
                '<div class="col-lg-4"><input type="number" class="form-control" name="nomor_handphone[]" placeholder="Nomor HP peserta" required></div>' +
                '</div></div>' +
                '</div>';
        }

        function renderParticipants() {
            var countInput = document.getElementById('eventRegistrationParticipantCount');
            var container = document.getElementById('eventRegistrationParticipants');

            if (!countInput || !container) {
                return;
            }

            var count = parseInt(countInput.value, 10) || 0;
            var html = '';

            for (var i = 1; i <= count; i++) {
                html += participantTemplate(i);
            }

            container.innerHTML = html;
        }

        function validateParticipants() {
            var participantInputs = document.querySelectorAll('#eventRegistrationParticipants input[required]');
            var firstInvalidInput = null;

            participantInputs.forEach(function (input) {
                if (input.value.trim() === '') {
                    input.classList.add('is-invalid');

                    if (!firstInvalidInput) {
                        firstInvalidInput = input;
                    }
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (firstInvalidInput) {
                firstInvalidInput.focus();
                return false;
            }

            return true;
        }

        document.addEventListener('DOMContentLoaded', function () {
            var countInput = document.getElementById('eventRegistrationParticipantCount');
            var modal = document.getElementById('{{ $modalId }}');
            var form = document.getElementById('eventRegistrationForm');

            if (countInput) {
                countInput.addEventListener('input', renderParticipants);
                renderParticipants();
            }

            if (form) {
                form.addEventListener('submit', function (event) {
                    var certificate = form.querySelector('input[name="event_registration_certificate"]:checked');
                    var participantCount = parseInt(countInput ? countInput.value : 0, 10) || 0;
                    var submitButton = form.querySelector('.js-event-registration-submit');

                    if (form.dataset.submitted === '1') {
                        event.preventDefault();
                        return;
                    }

                    if (participantCount < 1) {
                        event.preventDefault();
                        notifyRegistration('Jumlah peserta minimal 1.');
                        return;
                    }

                    if (!validateParticipants()) {
                        event.preventDefault();
                        notifyRegistration('Mohon lengkapi semua data peserta sebelum melanjutkan ke pembayaran.');
                        return;
                    }

                    document.getElementById('eventRegistrationCertificateValue').value = certificate ? certificate.value : '0';
                    form.dataset.submitted = '1';

                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.dataset.originalText = submitButton.textContent.trim();
                        submitButton.textContent = submitButton.dataset.loadingText || 'Memproses...';
                    }
                });
            }

            if (modal && form) {
                $('#' + modal.id).on('hidden.bs.modal', function () {
                    form.reset();

                    if (countInput) {
                        countInput.value = 1;
                    }

                    document.getElementById('eventRegistrationCertificateValue').value = '1';
                    delete form.dataset.submitted;
                    var submitButton = form.querySelector('.js-event-registration-submit');

                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.textContent = submitButton.dataset.originalText || 'Lanjut ke Pembayaran';
                    }

                    renderParticipants();
                });
            }
        });
    })();
</script>
@endonce
