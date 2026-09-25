@props(['item'])

@php
    // Menyiapkan gambar cover
    $coverImage = !empty($item->image) ? asset($item->image) : asset('images/default-course.jpg');

    // Menyiapkan meta tag dinamis
    $meta = array_filter([$item->level ?? null, $item->tipe ?? null, $item->kategori ?? null]);

    // AMAN: Mendapatkan final_price baik bentuknya Array maupun Object
    $resolved = $item->pricing->resolved ?? null;
    $finalPrice = 0;

    if ($resolved) {
        if (is_array($resolved)) {
            $finalPrice = $resolved['final_price'] ?? 0;
        } elseif (is_object($resolved)) {
            $finalPrice = $resolved->final_price ?? 0;
        }
    }

    $priceText = $finalPrice > 0 ? 'Rp ' . number_format($finalPrice, 0, ',', '.') : 'Gratis';
    $instructorNames = collect($item->instructor_list ?? [])
        ->pluck('name')
        ->filter()
        ->values();
@endphp

<article class="course-card">
    <div class="course-cover-wrapper">
        <div class="course-cover"
            style="background-image: url('{{ $coverImage }}'); background-size: cover;  background-position: center;">
            <div class="category-badge">{{ $item->category ?: 'Kelas pilihan' }}</div>
        </div>
    </div>

    <div class="course-body">
        <h3 class="course-title">{{ $item->title }}</h3>

        <div class="course-instructor">
            <span class="instructor-icon" aria-hidden="true">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 21C20 17.6863 17.3137 15 14 15H10C6.68629 15 4 17.6863 4 21" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" />
                    <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="1.8" />
                </svg>
            </span>
            <span class="instructor-label">Instruktur</span>
            <span class="instructor-name">
                {{ $instructorNames->isNotEmpty() ? $instructorNames->join(', ') : 'Bankir Academy' }}
            </span>
        </div>

        <div class="course-actions">
            <span class="course-price">{{ $priceText }}</span>
            <a class="btn-detail" href="{{ route('frontend.class.detail', $item->slug) }}" aria-label="Lihat detail {{ $item->title }}">
                Lihat detail
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 6H11M11 6L6 1M11 6L6 11" stroke="white" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </a>
        </div>
    </div>
</article>

<style>
    .course-card {
        width: 100%;
        max-width: 340px;
        height: 100%;
        display: flex;
        flex-direction: column;
        background: #fff;
        border: 1px solid #e7e8f3;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(52, 42, 120, 0.08);
        font-family: 'Inter', sans-serif;
        transition: transform 0.24s ease, box-shadow 0.24s ease, border-color 0.24s ease;
    }

    .course-card:hover {
        transform: translateY(-7px);
        border-color: rgba(103, 87, 217, 0.3);
        box-shadow: 0 18px 36px rgba(52, 42, 120, 0.16);
    }

    .course-cover-wrapper {
        position: relative;
        overflow: hidden;
    }

    .course-cover {
        height: 180px;
        display: flex;
        align-items: flex-end;
        padding: 16px;
    }

    .category-badge {
        background-color: #ff7f50;
        color: #fff;
        font-size: 10px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        text-transform: uppercase;
    }

    .course-body {
        flex: 1;
        display: flex;
        flex-direction: column;
        padding: 20px;
    }

    .course-title {
        display: -webkit-box;
        min-height: 48px;
        margin: 0 0 13px;
        overflow: hidden;
        color: #25213f;
        font-size: 18px;
        font-weight: 800;
        line-height: 1.35;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }

    .course-instructor {
        display: flex;
        align-items: center;
        gap: 7px;
        min-width: 0;
        margin-bottom: 19px;
        color: #716d85;
        font-size: 11px;
        line-height: 1.4;
    }

    .instructor-icon {
        display: inline-flex;
        flex: 0 0 28px;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        color: #6757d9;
        background: #f1efff;
        border-radius: 50%;
    }

    .instructor-label {
        color: #9995aa;
        font-weight: 600;
    }

    .instructor-name {
        overflow: hidden;
        color: #4a4563;
        font-weight: 700;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .course-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: auto;
        padding-top: 16px;
        border-top: 1px solid #f0eff6;
    }

    .course-price {
        color: #6757d9;
        font-size: 15px;
        font-weight: 800;
        white-space: nowrap;
    }

    .btn-detail {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
        background: #6757d9;
        color: #fff;
        font-size: 11px;
        font-weight: 800;
        padding: 11px 13px;
        border-radius: 12px;
        text-decoration: none;
        transition: background 0.2s ease, transform 0.2s ease;
    }

    .btn-detail:hover {
        background: #342a78;
        color: #fff;
        transform: translateX(2px);
    }

    @media (max-width: 700px) {
        .course-card {
            max-width: none;
        }
    }
</style>
