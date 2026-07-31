@once
<style>
    .loker-skeleton-card {
        display: flex;
        min-width: 0;
        flex-direction: column;
        height: 100%;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        background: #f3f4f6;
    }

    .loker-skeleton-card__media {
        height: clamp(96px, 10vw, 124px);
        border-bottom: 1px solid #e5e7eb;
    }

    .loker-skeleton-card__body {
        display: flex;
        flex: 1;
        flex-direction: column;
        gap: 14px;
        padding: 18px;
    }

    .loker-skeleton-card__line {
        height: 12px;
        border-radius: 6px;
        background: linear-gradient(90deg, #e5e7eb 25%, #f9fafb 50%, #e5e7eb 75%);
        background-size: 200% 100%;
        animation: loker-skeleton-shimmer 1.5s ease-in-out infinite;
    }

    .loker-skeleton-card__line--title {
        width: 78%;
        height: 20px;
    }

    .loker-skeleton-card__line--company {
        width: 58%;
    }

    .loker-skeleton-card__line--description {
        width: 100%;
    }

    .loker-skeleton-card__line--description-short {
        width: 72%;
    }

    .loker-skeleton-card__footer {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 12px;
        margin-top: auto;
        padding-top: 14px;
        border-top: 1px solid #e5e7eb;
    }

    .loker-skeleton-card__line--deadline {
        width: 34%;
    }

    .loker-skeleton-card__line--button {
        width: 92px;
        height: 44px;
        border-radius: 10px;
    }

    @keyframes loker-skeleton-shimmer {
        0% {
            background-position: 200% 0;
        }

        100% {
            background-position: -200% 0;
        }
    }

    @media (max-width: 575.98px) {
        .loker-skeleton-card {
            display: none;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .loker-skeleton-card__line {
            animation: none;
        }
    }
</style>
@endonce

<article class="loker-skeleton-card" aria-hidden="true">
    <div class="loker-skeleton-card__media"></div>
    <div class="loker-skeleton-card__body">
        <span class="loker-skeleton-card__line loker-skeleton-card__line--title"></span>
        <span class="loker-skeleton-card__line loker-skeleton-card__line--company"></span>
        <span class="loker-skeleton-card__line loker-skeleton-card__line--description"></span>
        <span class="loker-skeleton-card__line loker-skeleton-card__line--description-short"></span>
        <div class="loker-skeleton-card__footer">
            <span class="loker-skeleton-card__line loker-skeleton-card__line--deadline"></span>
            <span class="loker-skeleton-card__line loker-skeleton-card__line--button"></span>
        </div>
    </div>
</article>
