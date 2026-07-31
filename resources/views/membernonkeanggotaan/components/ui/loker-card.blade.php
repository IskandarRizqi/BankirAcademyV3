@php
    $decodeList = static function ($value): array {
        $decoded = json_decode((string) $value, true);

        if (is_array($decoded)) {
            return array_values($decoded);
        }

        return filled($value) ? [(string) $value] : [];
    };

    $decodeImage = static function ($value): ?string {
        $decoded = json_decode((string) $value, true);
        $path = is_array($decoded) ? data_get($decoded, 'url') : $value;

        if (! filled($path)) {
            return null;
        }

        return \Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/'])
            ? $path
            : asset('image/loker/' . ltrim($path, '/'));
    };

    $company = $loker->perusahaan;
    $companyName = $loker->nama ?: optional($company)->nama ?: 'Perusahaan mitra';
    $imageUrl = $decodeImage($loker->image) ?: $decodeImage(optional($company)->image);
    $types = $decodeList($loker->type);
    $skills = $decodeList($loker->skill);
    $location = $loker->kabupaten_name ?: optional($company)->kabupaten_name;
    $location = $location ?: $loker->provinsi_name ?: optional($company)->provinsi_name;
@endphp

@once
<style>
    .loker-card {
        display: flex;
        min-width: 0;
        flex-direction: column;
        height: 100%;
        overflow: hidden;
        border: 1px solid #e7e9f0;
        border-radius: 18px;
        background: #ffffff;
        box-shadow: 0 6px 24px rgba(15, 23, 42, .04);
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }

    .loker-card:hover {
        border-color: rgba(79, 70, 229, .3);
        box-shadow: 0 16px 34px rgba(15, 23, 42, .1);
        transform: translateY(-3px);
    }

    .loker-card__media {
        position: relative;
        display: flex;
        height: clamp(96px, 10vw, 124px);
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 16px 24px;
        background: #f8fafc;
        border-bottom: 1px solid #eef0f5;
    }

    .loker-card__media img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
    }

    .loker-card__placeholder {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 64px;
        height: 64px;
        border: 1px solid rgba(255, 255, 255, .3);
        border-radius: 18px;
        background: linear-gradient(135deg, #111827, #4338ca);
        color: #ffffff;
        font-size: 24px;
        font-weight: 900;
        letter-spacing: .04em;
    }

    .loker-card__status {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 6px 10px;
        border-radius: 999px;
        background: rgba(15, 23, 42, .76);
        color: #ffffff;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .loker-card__body {
        display: flex;
        flex: 1;
        flex-direction: column;
        gap: 14px;
        padding: 18px;
    }

    .loker-card__title {
        display: -webkit-box;
        overflow: hidden;
        margin: 0;
        color: #111827;
        font-size: 18px;
        font-weight: 900;
        letter-spacing: -.025em;
        line-height: 1.3;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }

    .loker-card__company,
    .loker-card__meta {
        display: flex;
        align-items: center;
        gap: 7px;
        color: #6b7280;
        font-size: 13px;
        line-height: 1.5;
    }

    .loker-card__company {
        color: #4338ca;
        font-weight: 800;
    }

    .loker-card__icon {
        width: 15px;
        color: #6366f1;
        text-align: center;
    }

    .loker-card__description {
        display: -webkit-box;
        overflow: hidden;
        margin: 0;
        color: #4b5563;
        font-size: 13px;
        line-height: 1.65;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
    }

    .loker-card__tags {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .loker-card__tag {
        max-width: 100%;
        padding: 5px 9px;
        overflow: hidden;
        border: 1px solid #e0e7ff;
        border-radius: 999px;
        background: #f5f7ff;
        color: #4338ca;
        font-size: 11px;
        font-weight: 700;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .loker-card__footer {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 12px;
        padding-top: 14px;
        border-top: 1px solid #eef0f5;
    }

    .loker-card__deadline {
        display: grid;
        gap: 3px;
        color: #6b7280;
        font-size: 11px;
        line-height: 1.4;
    }

    .loker-card__deadline strong {
        color: #374151;
        font-size: 12px;
    }

    .loker-card__link {
        display: inline-flex;
        min-height: 44px;
        align-items: center;
        justify-content: center;
        padding: 9px 13px;
        border-radius: 10px;
        background: #4f46e5;
        color: #ffffff;
        font-size: 12px;
        font-weight: 800;
        text-decoration: none;
        transition: background .18s ease, transform .18s ease;
        white-space: nowrap;
    }

    .loker-card__link:hover,
    .loker-card__link:focus-visible {
        background: #3730a3;
        color: #ffffff;
        text-decoration: none;
        transform: translateY(-1px);
    }

    @media (max-width: 575.98px) {
        .loker-card__body {
            padding: 16px;
        }

        .loker-card__footer {
            align-items: stretch;
            flex-direction: column;
        }

        .loker-card__link {
            width: 100%;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .loker-card,
        .loker-card__link {
            transition: none;
        }

        .loker-card:hover,
        .loker-card__link:hover {
            transform: none;
        }
    }
</style>
@endonce

<article class="loker-card">
    <div class="loker-card__media">
        @if($imageUrl)
            <img src="{{ $imageUrl }}" alt="Logo {{ $companyName }}" loading="lazy">
        @else
            <span class="loker-card__placeholder" aria-hidden="true">{{ strtoupper(substr($companyName, 0, 2)) }}</span>
        @endif
        <span class="loker-card__status">Lowongan aktif</span>
    </div>

    <div class="loker-card__body">
        <div>
            <h3 class="loker-card__title">{{ $loker->title }}</h3>
            <div class="loker-card__company mt-2">
                <span class="loker-card__icon" aria-hidden="true"><i class="fas fa-building"></i></span>
                <span>{{ $companyName }}</span>
            </div>
        </div>

        <p class="loker-card__description">{{ \Illuminate\Support\Str::limit(strip_tags((string) $loker->deskripsi), 155) }}</p>

        @if(count($types) > 0 || count($skills) > 0)
        <div class="loker-card__tags" aria-label="Kategori loker">
            @foreach(array_slice($types, 0, 2) as $type)
                <span class="loker-card__tag">{{ ucfirst((string) $type) }}</span>
            @endforeach
            @foreach(array_slice($skills, 0, 2) as $skill)
                <span class="loker-card__tag">{{ $skill }}</span>
            @endforeach
        </div>
        @endif

        <div class="loker-card__meta">
            <span class="loker-card__icon" aria-hidden="true"><i class="fas fa-map-marker-alt"></i></span>
            <span>{{ $location ?: 'Lokasi belum tersedia' }}</span>
        </div>

        <div class="loker-card__footer mt-auto">
            <div class="loker-card__deadline">
                <span>Batas pendaftaran</span>
                <strong>
                    {{ $loker->tanggal_akhir ? \Carbon\Carbon::parse($loker->tanggal_akhir)->locale('id')->isoFormat('D MMM YYYY') : 'Tidak ditentukan' }}
                </strong>
            </div>
            <a class="loker-card__link" href="{{ route('membernonanggota.loker.show', $loker->id) }}">
                Lihat detail
            </a>
        </div>
    </div>
</article>
