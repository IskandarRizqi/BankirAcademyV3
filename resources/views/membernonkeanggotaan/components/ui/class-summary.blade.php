@php
    $summaryItems = [
        [
            'title' => 'Total Kelas',
            'value' => $totalCount ?? 0,
            'description' => 'Semua kelas yang Anda miliki',
            'variant' => 'primary',
            'icon' => 'fas fa-book-open',
        ],
        [
            'title' => 'Sedang Berjalan',
            'value' => $activeCount ?? 0,
            'description' => 'Kelas yang masih aktif',
            'variant' => 'success',
            'icon' => 'fas fa-play-circle',
        ],
        [
            'title' => 'Selesai',
            'value' => $completedCount ?? 0,
            'description' => 'Kelas yang telah selesai',
            'variant' => 'warning',
            'icon' => 'fas fa-check-circle',
        ],
    ];
@endphp

@once
<style>
    .class-summary-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    @media (max-width: 991.98px) {
        .class-summary-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 575.98px) {
        .class-summary-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endonce

<section class="class-summary-grid" aria-label="Ringkasan kelas">
    @foreach($summaryItems as $item)
        @include('membernonkeanggotaan.components.ui.billing-summary-card', $item)
    @endforeach
</section>
