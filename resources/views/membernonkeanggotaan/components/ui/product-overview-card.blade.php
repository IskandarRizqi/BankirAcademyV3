@once
    <style>
        .product-overview-card {
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

        .product-overview-card__header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
        }

        .product-overview-card__eyebrow {
            margin: 0 0 6px;
            color: #6b7280;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .04em;
            line-height: 1.4;
            text-transform: uppercase;
        }

        .product-overview-card__title {
            margin: 0;
            color: #111827;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1.3;
        }

        .product-overview-card__badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 30px;
            padding: 6px 10px;
            border-radius: 999px;
            background: var(--primary-soft, #EEF0FE);
            color: var(--primary, #4F46E5);
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
        }

        .product-overview-card__grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
        }

        .product-overview-card__item {
            background: #f9fafb;
            border: 1px solid #eef2f7;
            border-radius: 10px;
            padding: 12px 10px;
            text-align: center;
        }

        .product-overview-card__item-value {
            display: block;
            color: #111827;
            font-size: 22px;
            font-weight: 800;
            line-height: 1.2;
        }

        .product-overview-card__item-label {
            display: block;
            margin-top: 4px;
            color: #6b7280;
            font-size: 12px;
            font-weight: 700;
        }

        @media (max-width: 575.98px) {
            .product-overview-card {
                padding: 16px;
            }

            .product-overview-card__grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endonce

<section class="product-overview-card" aria-labelledby="product-overview-title">
    <div>
        <div class="product-overview-card__header">
            <div>
                <p class="product-overview-card__eyebrow">Akses Konten</p>
                <h2 class="product-overview-card__title" id="product-overview-title">Materi Dimiliki</h2>
            </div>
            <span class="product-overview-card__badge">Aktif Digunakan</span>
        </div>
    </div>

    <div class="product-overview-card__grid">
        <div class="product-overview-card__item">
            <span class="product-overview-card__item-value">{{ $totalClasses }}</span>
            <span class="product-overview-card__item-label">Kelas</span>
        </div>
        <div class="product-overview-card__item">
            <span class="product-overview-card__item-value">{{ $totalEbooks }}</span>
            <span class="product-overview-card__item-label">E-Book</span>
        </div>
        <div class="product-overview-card__item">
            <span class="product-overview-card__item-value">{{ $totalVideos }}</span>
            <span class="product-overview-card__item-label">Video</span>
        </div>
    </div>
</section>
