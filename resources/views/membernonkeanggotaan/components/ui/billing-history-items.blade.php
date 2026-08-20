@php
    $paymentHistories = $paymentHistories ?? collect();
    $logoFallback = asset(ltrim(env('CUSTOM_FAVICON', '/359x404.png'), '/'));
@endphp

@foreach ($paymentHistories as $payment)
    @php
        // Identifikasi jenis pembelian berdasarkan kolom 'pembelian' atau 'tipe_pembelian'
        $pembelian = strtolower((string) $payment->pembelian);
        $tipe = (int) $payment->tipe_pembelian;

        $isMembership =
            $pembelian === \App\Models\DataPayment::PURCHASE_MEMBERSHIP ||
            $tipe === \App\Models\DataPayment::PURCHASE_TYPE_MEMBERSHIP ||
            (is_null($payment->class_id) && blank($payment->pembelian));

        $isEbook =
            $pembelian === \App\Models\DataPayment::PURCHASE_EBOOK ||
            $tipe === \App\Models\DataPayment::PURCHASE_TYPE_EBOOK;

        $isVideo =
            $pembelian === \App\Models\DataPayment::PURCHASE_VIDEO ||
            $tipe === \App\Models\DataPayment::PURCHASE_TYPE_VIDEO;

        $isClass =
            $pembelian === \App\Models\DataPayment::PURCHASE_CLASS ||
            $tipe === \App\Models\DataPayment::PURCHASE_TYPE_CLASS ||
            (!$isMembership && !$isEbook && !$isVideo);

        // Menentukan Label Type & Class Badge
        if ($isMembership) {
            $typeLabel = 'Membership';
            $typeClass = 'billing-history-type--membership';
            $orderTitle = 'Membership Bankir Academy';
        } elseif ($isEbook) {
            $typeLabel = 'E-Book';
            $typeClass = 'billing-history-type--ebook';
            $orderTitle = data_get($payment, 'paymentClass.title', 'E-Book Bankir Academy');
        } elseif ($isVideo) {
            $typeLabel = 'Video';
            $typeClass = 'billing-history-type--video';
            $orderTitle = data_get($payment, 'paymentClass.title', 'Video Bankir Academy');
        } else {
            $typeLabel = 'Kelas';
            $typeClass = 'billing-history-type--class';
            $orderTitle = data_get($payment, 'paymentClass.title', 'Kelas Bankir Academy');
        }

        // Thumbnail, Date, Quantity, & Status
        $thumbnail = $isMembership
            ? $logoFallback
            : (data_get($payment, 'paymentClass.image_mobile') ?:
            data_get($payment, 'paymentClass.image') ?:
            $logoFallback);

        $orderDate = optional($payment->created_at)->translatedFormat('d M Y, H:i');
        $participantQuantity = $isMembership ? null : data_get($payment, 'qty');
        $displayStatus = $payment->billingStatus();
        $isIhtWithoutExpiry = $payment->isIhtWithoutExpiry();
        $isWaitingForIhtConfirmation = $payment->isWaitingForIhtConfirmation();
        $canPayConfirmedIht = $payment->canPayConfirmedIht();
        $expiredAtDate = $payment->paymentExpiresAt();
        $expiredAt = optional($expiredAtDate)->toIso8601String();
        $isPaid = $displayStatus === \App\Models\DataPayment::STATUS_PAID;
        $isPending = $displayStatus === \App\Models\DataPayment::STATUS_PENDING;
        $isExpired = $expiredAtDate ? $expiredAtDate->isPast() : true;
        $pendingLabel = $isWaitingForIhtConfirmation ? 'Menunggu Konfirmasi' : 'Menunggu Pembayaran';
        $classPaymentId = data_get($payment, 'classPayment.id');

        // DETEKSI GATEWAY / VA vs MANUAL:
        // Jika link_payment diawali 'http://' atau 'https://', maka itu tautan pembayaran VA/Gateway.
        $rawLinkPayment = (string) $payment->link_payment;
        $isUrlPayment = \Illuminate\Support\Str::startsWith($rawLinkPayment, ['http://', 'https://']);

        // Transaksi manual jika: flag manual = 1 OR BUKAN URL payment (link_payment null, empty, atau berupa path file bukti)
        $isManualPayment = (int) data_get($payment, 'riwayatTransaksi.manual', 0) === 1 || !$isUrlPayment;

        $invoiceUrl = $isMembership
            ? url('/classes/cetakinvoicepending/' . $payment->id)
            : ($classPaymentId
                ? url('/classes/getinvoice/' . $payment->id)
                : null);

        // URL Invoice Pending
        $pendingInvoiceUrl =
            $isEbook || $isVideo
                ? url('/materi/cetakinvoicepending/' . $payment->id)
                : ($isClass
                    ? url('/classes/getinvoice/' . $payment->id)
                    : null);

        $paymentUrl = $isUrlPayment ? $payment->link_payment : null;
        $hasUploadedProof = !$isUrlPayment && !empty($payment->link_payment);
    @endphp

    <article class="billing-history-card">
        <div class="billing-history-card__top">
            <div class="billing-history-card__media">
                <img src="{{ $thumbnail }}" alt="{{ $orderTitle }}" loading="lazy"
                    onerror="this.src='{{ $logoFallback }}'">
            </div>

            <div class="billing-history-card__main">
                <div>
                    <div class="billing-history-card__meta-row">
                        <span class="billing-history-type {{ $typeClass }}">{{ $typeLabel }}</span>
                    </div>
                    <h3 class="billing-history-card__title">{{ $orderTitle }}</h3>
                    <p class="billing-history-card__invoice">{{ $payment->no_invoice }}</p>
                </div>

                <div class="billing-history-card__amount" aria-label="Total pembayaran">
                    <span>Total Pembayaran</span>
                    <strong>Rp {{ number_format((float) $payment->nominal, 0, ',', '.') }}</strong>
                </div>
            </div>
        </div>

        @if ($orderDate)
            <hr class="billing-history-card__divider">
            <div class="billing-history-card__footer">
                <div class="billing-history-card__footer-info">
                    <div class="billing-history-card__payment-info">
                        <span>Status pembayaran</span>
                        <strong class="billing-history-countdown" data-expires-at="{{ $expiredAt }}"
                            data-expire-url="{{ url('/pembayaran/' . $payment->id . '/expire') }}"
                            data-payment-id="{{ $payment->id }}" data-status="{{ $displayStatus }}"
                            data-pending-label="{{ $pendingLabel }}">-</strong>
                    </div>

                    <div class="billing-history-card__order-date">
                        <span>Tanggal order</span>
                        <strong>{{ $orderDate }}</strong>
                    </div>

                    @if (!$isMembership)
                        <div class="billing-history-card__participant-count">
                            <span>Jumlah {{ $isEbook || $isVideo ? 'item' : 'peserta' }}</span>
                            <strong>{{ $participantQuantity !== null ? number_format((float) $participantQuantity, 0, ',', '.') : '-' }}</strong>
                        </div>
                    @endif
                </div>

                <div class="billing-history-card__actions">
                    @if ($isPaid && $invoiceUrl)
                        <a href="{{ $invoiceUrl }}" target="_blank" rel="noopener"
                            class="billing-history-action billing-history-action--invoice">
                            <i class="fas fa-file-invoice" aria-hidden="true"></i>
                            Cetak Invoice
                        </a>
                    @elseif(!$isExpired && $isManualPayment && !$isPaid && ($displayStatus == 3 || $displayStatus == 2))
                        {{-- Tombol Cetak Invoice Pending --}}
                        @if ($pendingInvoiceUrl)
                            <a href="{{ $pendingInvoiceUrl }}" target="_blank" rel="noopener"
                                class="billing-history-action billing-history-action--invoice-pending">
                                <i class="fas fa-file-invoice" aria-hidden="true"></i>
                                Cetak Invoice Pending
                            </a>
                        @endif

                        {{-- Tombol Bayar Manual / Upload Bukti Transfer --}}
                        <button type="button" class="billing-history-action billing-history-action--pay"
                            data-toggle="modal" data-target="#modalUploadBukti{{ $payment->id }}"
                            data-bs-toggle="modal" data-bs-target="#modalUploadBukti{{ $payment->id }}">
                            <i class="fas {{ $hasUploadedProof ? 'fa-edit' : 'fa-upload' }}" aria-hidden="true"></i>
                            {{ $hasUploadedProof ? 'Ubah Bukti Transfer' : 'Bayar Sekarang' }}
                        </button>

                        {{-- Modal Form Upload --}}
                        <div class="modal fade" id="modalUploadBukti{{ $payment->id }}" tabindex="-1" role="dialog"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('pembayaran.upload-bukti', $payment->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Upload Bukti Transfer</h5>
                                            <button type="button" class="close btn-close" data-dismiss="modal"
                                                data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-start">
                                            <p class="mb-2">Silakan transfer sesuai nominal ke rekening berikut:</p>
                                            <div class="alert alert-info">
                                                <strong>Bank BCA</strong><br>
                                                No. Rek: 803 555 9091<br>
                                                a.n. PT Bankir Academy
                                            </div>
                                            <div class="mb-3">
                                                <label for="link_payment_{{ $payment->id }}" class="form-label">Bukti
                                                    Transfer (JPG, PNG, max 2MB)</label>
                                                <input type="file" name="link_payment"
                                                    id="link_payment_{{ $payment->id }}" class="form-control"
                                                    accept="image/*" required>
                                            </div>
                                            @if ($hasUploadedProof)
                                                <div class="mt-2">
                                                    <small class="text-muted">Bukti terunggah saat ini:</small><br>
                                                    <a href="{{ asset('storage/' . $payment->link_payment) }}"
                                                        target="_blank" class="text-primary">Lihat File</a>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Kirim Bukti Transfer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @elseif($canPayConfirmedIht && $paymentUrl)
                        <a href="{{ $paymentUrl }}" target="_blank" rel="noopener"
                            class="billing-history-action billing-history-action--pay" data-payment-action
                            data-expires-at="{{ $expiredAt }}">
                            <i class="fas fa-credit-card" aria-hidden="true"></i>
                            Bayar Sekarang
                        </a>
                    @elseif($canPayConfirmedIht)
                        <form action="{{ route('membernonanggota.payment-iht', $payment) }}" method="POST"
                            data-iht-payment-form>
                            @csrf
                            <button type="submit" class="billing-history-action billing-history-action--pay"
                                data-iht-payment-submit>
                                <i class="fas fa-credit-card" aria-hidden="true"></i>
                                Bayar Sekarang
                            </button>
                        </form>
                    @elseif($isPending && !$isExpired && $paymentUrl)
                        <a href="{{ $paymentUrl }}" target="_blank" rel="noopener"
                            class="billing-history-action billing-history-action--pay" data-payment-action
                            data-expires-at="{{ $expiredAt }}">
                            <i class="fas fa-credit-card" aria-hidden="true"></i>
                            Bayar Sekarang
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </article>
@endforeach
