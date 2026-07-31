@if (config('app.live_purchase_toast.enabled', true))
    @once
        <link rel="stylesheet" href="{{ asset('css/live-purchase-toast.css') }}">

        <div
            id="live-purchase-toast"
            class="live-purchase-toast"
            role="status"
            aria-live="polite"
            aria-atomic="true"
            aria-hidden="true"
            hidden
        >
            <div class="live-purchase-toast__icon" aria-hidden="true">BA</div>
            <div class="live-purchase-toast__body">
                <div class="live-purchase-toast__title-row">
                    <strong class="live-purchase-toast__title">Pembelian terbaru</strong>
                    <span class="live-purchase-toast__time" data-toast-time></span>
                </div>
                <p class="live-purchase-toast__message" data-toast-message>
                    <strong data-toast-customer></strong>
                    <span data-toast-context></span>
                    <strong data-toast-product></strong>
                </p>
                <div class="live-purchase-toast__verified">
                    <svg class="live-purchase-toast__verified-icon" viewBox="0 0 20 20" aria-hidden="true">
                        <path d="M10 1.75a2.2 2.2 0 0 1 1.95 1.18l.28.54.6.06a2.2 2.2 0 0 1 1.7 1.28l.25.55.55.25a2.2 2.2 0 0 1 1.28 1.7l.06.6.54.28a2.2 2.2 0 0 1 0 3.9l-.54.28-.06.6a2.2 2.2 0 0 1-1.28 1.7l-.55.25-.25.55a2.2 2.2 0 0 1-1.7 1.28l-.6.06-.28.54a2.2 2.2 0 0 1-3.9 0l-.28-.54-.6-.06a2.2 2.2 0 0 1-1.7-1.28l-.25-.55-.55-.25a2.2 2.2 0 0 1-1.28-1.7l-.06-.6-.54-.28a2.2 2.2 0 0 1 0-3.9l.54-.28.06-.6a2.2 2.2 0 0 1 1.28-1.7l.55-.25.25-.55a2.2 2.2 0 0 1 1.7-1.28l.6-.06.28-.54A2.2 2.2 0 0 1 10 1.75Z" />
                        <path class="live-purchase-toast__verified-check" d="m6.4 10.1 2.1 2.1 5.1-5.1" />
                    </svg>
                    <span>Diverifikasi oleh <strong>Doku</strong></span>
                </div>
            </div>
            <button
                type="button"
                class="live-purchase-toast__close"
                aria-label="Tutup pemberitahuan"
                data-toast-close
            >&times;</button>
        </div>

        @php
            $livePurchaseToastConfig = [
                'enabled' => (bool) config('app.live_purchase_toast.enabled', true),
                'endpoint' => route('live-purchase-toast'),
                'displaySeconds' => (int) config('app.live_purchase_toast.display_seconds', 7),
                'retrySeconds' => (int) config('app.live_purchase_toast.min_interval_seconds', 60),
            ];
        @endphp
        <script>
            window.bankirLivePurchaseToast = @json($livePurchaseToastConfig);
        </script>
        <script src="{{ asset('js/live-purchase-toast.js') }}" defer></script>
    @endonce
@endif
