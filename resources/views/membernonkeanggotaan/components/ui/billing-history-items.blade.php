@php
	$paymentHistories = $paymentHistories ?? collect();
	$logoFallback = asset(ltrim(env('CUSTOM_FAVICON', '/359x404.png'), '/'));
	$statusMap = [
		1 => ['label' => 'Berhasil', 'class' => 'billing-history-status--success'],
		2 => ['label' => 'Menunggu', 'class' => 'billing-history-status--warning'],
		99 => ['label' => 'Dibatalkan', 'class' => 'billing-history-status--danger'],
	];
@endphp

@foreach($paymentHistories as $payment)
@php
	$isMembership = is_null($payment->class_id) || $payment->pembelian === 'membership';
	$orderTitle = $isMembership ? 'Membership Bankir Academy' : data_get($payment, 'paymentClass.title', 'Kelas Bankir Academy');
	$thumbnail = $isMembership ? $logoFallback : (data_get($payment, 'paymentClass.image_mobile') ?: data_get($payment, 'paymentClass.image') ?: $logoFallback);
	$orderDate = optional($payment->created_at)->translatedFormat('d M Y, H:i');
	$expiredAtDate = $payment->created_at ? $payment->created_at->copy()->addMinutes((int) $payment->expired) : null;
	$expiredAt = optional($expiredAtDate)->toIso8601String();
	$isPaid = (int) $payment->status === \App\Models\DataPayment::STATUS_PAID;
	$isPending = (int) $payment->status === \App\Models\DataPayment::STATUS_PENDING;
	$isExpired = $expiredAtDate ? $expiredAtDate->isPast() : true;
	$classPaymentId = data_get($payment, 'classPayment.id');
	$invoiceUrl = $isMembership ? url('/classes/cetakinvoicepending/' . $payment->id) : ($classPaymentId ? url('/classes/getinvoice/' . $classPaymentId) . '?payment_invoice=' . $classPaymentId : null);
	$paymentUrl = $payment->link_payment;
@endphp

<article class="billing-history-card">
	<div class="billing-history-card__top">
		<div class="billing-history-card__media">
			<img src="{{ $thumbnail }}" alt="{{ $orderTitle }}" loading="lazy" onerror="this.src='{{ $logoFallback }}'">
		</div>

		<div class="billing-history-card__main">
			<div>
				<div class="billing-history-card__meta-row">
					<span class="billing-history-type {{ $isMembership ? 'billing-history-type--membership' : 'billing-history-type--class' }}">{{ $isMembership ? 'Membership' : 'Kelas' }}</span>
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

	@if($orderDate)
	<hr class="billing-history-card__divider">
	<div class="billing-history-card__footer">
		<div class="billing-history-card__footer-info">
			<div class="billing-history-card__payment-info">
				<span>Status pembayaran</span>
				<strong class="billing-history-countdown" data-expires-at="{{ $expiredAt }}" data-expire-url="{{ url('/pembayaran/' . $payment->id . '/expire') }}" data-payment-id="{{ $payment->id }}" data-status="{{ (int) $payment->status }}">-</strong>
			</div>

			<div class="billing-history-card__order-date">
				<span>Tanggal order</span>
				<strong>{{ $orderDate }}</strong>
			</div>
		</div>

		<div class="billing-history-card__actions">
			@if($isPaid && $invoiceUrl)
			<a href="{{ $invoiceUrl }}" target="_blank" rel="noopener" class="billing-history-action billing-history-action--invoice">
				<i class="fas fa-file-invoice" aria-hidden="true"></i>
				Cetak Invoice
			</a>
			@elseif($isPending && ! $isExpired && $paymentUrl)
			<a href="{{ $paymentUrl }}" target="_blank" rel="noopener" class="billing-history-action billing-history-action--pay" data-payment-action data-expires-at="{{ $expiredAt }}">
				<i class="fas fa-credit-card" aria-hidden="true"></i>
				Bayar Sekarang
			</a>
			@endif
		</div>
	</div>
	@endif
</article>
@endforeach
