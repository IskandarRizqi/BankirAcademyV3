@once
    <style>
        .payment-chart-card {
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

        .payment-chart-card__header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
        }

        .payment-chart-card__eyebrow {
            margin: 0 0 6px;
            color: #6b7280;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .04em;
            line-height: 1.4;
            text-transform: uppercase;
        }

        .payment-chart-card__title {
            margin: 0;
            color: #111827;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1.3;
        }

        .payment-chart-card__container {
            min-height: 200px;
        }
    </style>
@endonce

<section class="payment-chart-card" aria-labelledby="payment-chart-title">
    <div>
        <div class="payment-chart-card__header">
            <div>
                <p class="payment-chart-card__eyebrow">Statistik Transaksi</p>
                <h2 class="payment-chart-card__title" id="payment-chart-title">Status Pembayaran</h2>
            </div>
        </div>
    </div>

    <div id="payment-donut-chart" class="payment-chart-card__container"></div>
</section>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var el = document.getElementById('payment-donut-chart');
            if (!el || typeof ApexCharts === 'undefined') return;

            var chart = new ApexCharts(el, {
                chart: {
                    type: 'donut',
                    height: 210,
                    fontFamily: 'Inter, sans-serif'
                },
                series: [
                    {{ $stats['lunas'] }},
                    {{ $stats['pending'] }},
                    {{ $stats['menunggu'] }},
                    {{ $stats['batal'] }}
                ],
                labels: ['Lunas', 'Pending', 'Konfirmasi Admin', 'Batal'],
                colors: ['#10B981', '#F59E0B', '#4F46E5', '#EF4444'],
                legend: {
                    position: 'bottom',
                    fontSize: '12px',
                    fontWeight: 700
                },
                dataLabels: {
                    enabled: false
                }
            });
            chart.render();
        });
    </script>
@endpush
