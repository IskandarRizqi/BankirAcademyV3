@once
    <style>
        .recent-payments-card {
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
            width: 100%;
        }

        .recent-payments-card__header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
        }

        .recent-payments-card__eyebrow {
            margin: 0 0 6px;
            color: #6b7280;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .04em;
            line-height: 1.4;
            text-transform: uppercase;
        }

        .recent-payments-card__title {
            margin: 0;
            color: #111827;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1.3;
        }

        .recent-payments-card__list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .recent-payments-card__item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 12px;
            background: #f9fafb;
            border: 1px solid #eef2f7;
            border-radius: 10px;
            gap: 12px;
        }

        .recent-payments-card__invoice {
            margin: 0;
            font-size: 13px;
            font-weight: 800;
            color: #111827;
        }

        .recent-payments-card__type {
            font-size: 12px;
            color: #6b7280;
            font-weight: 600;
        }

        .recent-payments-card__status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 26px;
            padding: 4px 8px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 800;
            white-space: nowrap;
        }

        .recent-payments-card__status-badge--1 {
            background: #ecfdf5;
            color: #047857;
        }

        .recent-payments-card__status-badge--2 {
            background: #fff7ed;
            color: #9a3412;
        }

        .recent-payments-card__status-badge--3 {
            background: #eef0fe;
            color: #4f46e5;
        }

        .recent-payments-card__status-badge--99 {
            background: #fef2f2;
            color: #991b1b;
        }
    </style>
@endonce

<section class="recent-payments-card" aria-labelledby="recent-payments-title">
    <div>
        <div class="recent-payments-card__header">
            <div>
                <p class="recent-payments-card__eyebrow">Aktivitas</p>
                <h2 class="recent-payments-card__title" id="recent-payments-title">Transaksi Terbaru</h2>
            </div>
        </div>
    </div>

    <ul class="recent-payments-card__list">
        @forelse($payments as $payment)
            <li class="recent-payments-card__item">
                <div>
                    <p class="recent-payments-card__invoice">{{ $payment->no_invoice }}</p>
                    <span class="recent-payments-card__type">{{ ucfirst($payment->pembelian ?? 'Layanan') }} • Rp
                        {{ number_format($payment->nominal, 0, ',', '.') }}</span>
                </div>
                <div>
                    @if ($payment->status == 1)
                        <span
                            class="recent-payments-card__status-badge recent-payments-card__status-badge--1">Lunas</span>
                    @elseif($payment->status == 2)
                        <span
                            class="recent-payments-card__status-badge recent-payments-card__status-badge--2">Pending</span>
                    @elseif($payment->status == 3)
                        <span
                            class="recent-payments-card__status-badge recent-payments-card__status-badge--3">Konfirmasi</span>
                    @else
                        <span
                            class="recent-payments-card__status-badge recent-payments-card__status-badge--99">Batal</span>
                    @endif
                </div>
            </li>
        @empty
            <li class="recent-payments-card__item text-muted justify-content-center">
                Belum ada transaksi.
            </li>
        @endforelse
    </ul>
</section>
