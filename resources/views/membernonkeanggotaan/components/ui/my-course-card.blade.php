@php
    $course = $course ?? null;
    $title = data_get($course, 'title', 'Kelas pembelajaran');
    $category = data_get($course, 'category') ?: 'Kelas Bankir';
    $mode = [
        0 => 'Online',
        1 => 'Offline',
    ][(int) data_get($course, 'kategori')] ?? 'Kelas';
    $isIht = (int) data_get($course, 'iht') === 1;
    $endDate = data_get($course, 'date_end');
    $today = now()->startOfDay();
    $courseStatusClass = $endDate && $today->greaterThan(
        \Carbon\Carbon::parse($endDate)->endOfDay()
    ) ? 'completed' : 'active';
    $description = trim(strip_tags((string) data_get($course, 'content', '')));
    $description = $description !== ''
        ? \Illuminate\Support\Str::limit($description, 118)
        : 'Pelajari kompetensi perbankan melalui kelas terstruktur bersama Bankir Academy.';
    $image = data_get($course, 'image_mobile') ?: data_get($course, 'image');
    $image = $image ?: asset('assets/img/90x90.jpg');
    $detailUrl = data_get($course, 'unique_id')
        ? url('/detail-event/' . data_get($course, 'unique_id') . '/' . \Illuminate\Support\Str::slug($title))
        : 'javascript:void(0);';
@endphp

@once
<style>
    .member-my-course-card {
        height: 100%;
        background: #ffffff;
        border: 1px solid #e7e9f0;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, .05);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }

    .member-my-course-card:hover {
        border-color: rgba(79, 70, 229, .22);
        box-shadow: 0 18px 44px rgba(79, 70, 229, .1);
        transform: translateY(-4px);
    }

    .member-my-course-card--completed {
        background: #f3f4f6;
        border-color: #d1d5db;
        box-shadow: none;
    }

    .member-my-course-card--completed:hover {
        border-color: #d1d5db;
        box-shadow: none;
        transform: none;
    }

    .member-my-course-card__media {
        position: relative;
        aspect-ratio: 16 / 10;
        background: linear-gradient(135deg, #eef0fe, #f8fafc);
        overflow: hidden;
    }

    .member-my-course-card__media img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        transition: transform .3s ease;
    }

    .member-my-course-card:hover .member-my-course-card__media img {
        transform: scale(1.04);
    }

    .member-my-course-card--completed .member-my-course-card__media img {
        filter: grayscale(1);
        opacity: .62;
    }

    .member-my-course-card--completed:hover .member-my-course-card__media img {
        transform: none;
    }

    .member-my-course-card__body {
        padding: 18px;
        display: flex;
        flex: 1;
        flex-direction: column;
    }

    .member-my-course-card__badges {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        margin: 0 0 12px;
    }

    .member-my-course-card__badge {
        display: inline-flex;
        align-items: center;
        min-height: 24px;
        padding: 5px 9px;
        border-radius: 999px;
        background: var(--primary-soft, #eef0fe);
        color: var(--primary, #4f46e5);
        font-size: 11px;
        font-weight: 800;
        line-height: 1;
    }

    .member-my-course-card__badge--mode {
        background: #111827;
        color: #ffffff;
    }

    .member-my-course-card__badge--iht {
        background: #fff7ed;
        color: #c2410c;
    }

    .member-my-course-card__badge--regular {
        background: #ecfdf5;
        color: #047857;
    }

    .member-my-course-card__title {
        margin: 0;
        color: #111827;
        font-size: 18px;
        font-weight: 850;
        letter-spacing: -.03em;
        line-height: 1.28;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .member-my-course-card__title a {
        color: inherit;
    }

    .member-my-course-card__description {
        margin: 10px 0 0;
        color: #6b7280;
        font-size: 13.5px;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .member-my-course-card__footer {
        margin-top: auto;
        padding-top: 18px;
    }

    .member-my-course-card__button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        min-height: 40px;
        padding: 10px 14px;
        border-radius: 999px;
        background: var(--primary, #4f46e5);
        color: #ffffff;
        font-size: 13px;
        font-weight: 850;
        white-space: nowrap;
        box-shadow: 0 10px 20px rgba(79, 70, 229, .18);
        transition: background .18s ease, transform .18s ease, box-shadow .18s ease;
    }

    .member-my-course-card__button:hover {
        background: var(--primary-dark, #3d33d8);
        color: #ffffff;
        box-shadow: 0 12px 26px rgba(79, 70, 229, .24);
        transform: translateY(-1px);
    }

    .member-my-course-card--completed .member-my-course-card__title,
    .member-my-course-card--completed .member-my-course-card__description {
        color: #6b7280;
    }

    @media (max-width: 575.98px) {
        .member-my-course-card__body {
            padding: 16px;
        }

        .member-my-course-card__title {
            font-size: 16px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .member-my-course-card,
        .member-my-course-card *,
        .member-my-course-card__button {
            transition: none !important;
        }
    }
</style>
@endonce

<article class="member-my-course-card {{ $courseStatusClass === 'completed' ? 'member-my-course-card--completed' : '' }}">
    <a href="{{ $detailUrl }}" class="member-my-course-card__media" aria-label="Lihat detail {{ $title }}">
        <img src="{{ $image }}" alt="{{ $title }}" loading="lazy" onerror="this.src='{{ asset('assets/img/90x90.jpg') }}'">
    </a>

    <div class="member-my-course-card__body">
        <div class="member-my-course-card__badges" aria-label="Informasi kelas">
            <span class="member-my-course-card__badge">{{ $category }}</span>
            <span class="member-my-course-card__badge member-my-course-card__badge--mode">{{ $mode }}</span>
            <span class="member-my-course-card__badge {{ $isIht ? 'member-my-course-card__badge--iht' : 'member-my-course-card__badge--regular' }}">
                {{ $isIht ? 'IHT' : 'Non-IHT' }}
            </span>
        </div>

        <h3 class="member-my-course-card__title">
            <a href="{{ $detailUrl }}">{{ $title }}</a>
        </h3>
        <p class="member-my-course-card__description">{{ $description }}</p>

        @include('membernonkeanggotaan.components.ui.my-course-participants', [
            'classId' => data_get($course, 'id'),
            'participantCount' => data_get($course, 'participant_count', 0),
            'participants' => data_get($course, 'participant_list', []),
            'isIht' => data_get($course, 'participant_is_iht', false),
        ])

        <div class="member-my-course-card__footer">
            <a href="{{ $detailUrl }}" class="member-my-course-card__button">Lihat Kelas</a>
        </div>
    </div>
</article>
