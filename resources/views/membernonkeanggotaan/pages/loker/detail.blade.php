@extends(auth()->check() ? 'layouts.appmembernonanggota' : 'layouts.appfrontend')

@section('title', 'Detail Lowongan')

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

        if (!filled($path)) {
            return null;
        }

        return \Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/'])
            ? $path
            : asset('image/loker/' . ltrim($path, '/'));
    };

    $company = $loker->perusahaan;
    $companyName = optional($company)->nama ?: 'Perusahaan mitra';
    $imageUrl = $decodeImage($loker->image) ?: $decodeImage(optional($company)->image);
    $types = $decodeList($loker->type);
    $skills = $decodeList($loker->skill);
    $province = $loker->provinsi_name ?: optional($company)->provinsi_name;
    $city = $loker->kabupaten_name ?: optional($company)->kabupaten_name;
    $address = $loker->alamat ?: optional($company)->alamat;
    $description = trim(strip_tags((string) $loker->deskripsi));
    $jobdesk = trim(strip_tags((string) $loker->jobdesk));
    $shareTitle = trim((string) $loker->title) . ' | Lowongan Kerja Bankir Academy';
    $shareDescription = \Illuminate\Support\Str::limit(
        preg_replace('/\s+/', ' ', $description ?: $jobdesk ?: 'Lihat detail lowongan kerja di Bankir Academy.'),
        160,
    );
    $shareUrl = route('membernonanggota.loker.show', $loker->id);
    $shareImage = $imageUrl ?: asset('bankir-academy-icon.png');
    $shareText = rawurlencode($shareTitle . "\n" . $shareUrl);
    $facebookShareUrl = 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode($shareUrl);
    $datePosted = $loker->tanggal_awal ?: $loker->created_at;
    $jobPostingSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'JobPosting',
        'title' => $loker->title,
        'description' => $description ?: $jobdesk ?: $shareDescription,
        'datePosted' => $datePosted ? \Carbon\Carbon::parse($datePosted)->toDateString() : now()->toDateString(),
        'hiringOrganization' => [
            '@type' => 'Organization',
            'name' => $companyName,
            'sameAs' => url('/'),
            'logo' => $shareImage,
        ],
        'jobLocation' => [
            '@type' => 'Place',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $address ?: 'Indonesia',
                'addressLocality' => $city ?: 'Indonesia',
                'addressRegion' => $province ?: 'Indonesia',
                'addressCountry' => 'ID',
            ],
        ],
        'url' => $shareUrl,
    ];
    if ($loker->tanggal_akhir) {
        $jobPostingSchema['validThrough'] = \Carbon\Carbon::parse($loker->tanggal_akhir)->toIso8601String();
    }
    if ($types !== []) {
        $jobPostingSchema['employmentType'] = array_values(
            array_map(fn($type) => strtoupper(str_replace([' ', '-'], '_', (string) $type)), $types),
        );
    }
@endphp

@section('page-title', $shareTitle)
@section('page-description', $shareDescription)
@section('page-url', $shareUrl)
@section('page-image', $shareImage)
@section('page-image-alt', 'Gambar ' . $loker->title)
@section('og-type', 'article')

@section('head')
    <meta name="robots" content="index, follow">
    <meta property="og:site_name" content="Bankir Academy">
    <meta property="og:updated_time" content="{{ optional($loker->updated_at)->toIso8601String() }}">
    <meta name="twitter:image:alt" content="Gambar {{ $loker->title }}">
    <script type="application/ld+json">
        {!! json_encode($jobPostingSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
    </script>
@endsection

@section('content')

    <style>
        .loker-detail-page {
            width: min(1180px, calc(100% - 48px));
            margin: 0 auto;
            padding: 36px 0 72px;
            display: flex;
            flex-direction: column;
            gap: 22px;
        }

        .loker-detail-page--guest {
            padding-top: 122px;
        }

        .loker-detail-back {
            display: inline-flex;
            width: fit-content;
            min-height: 44px;
            align-items: center;
            gap: 8px;
            padding: 9px 14px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background: #ffffff;
            color: #374151;
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
        }

        .loker-detail-back:hover,
        .loker-detail-back:focus-visible {
            border-color: #c7d2fe;
            background: #eef2ff;
            color: #3730a3;
            text-decoration: none;
        }

        .loker-detail-layout {
            display: grid;
            grid-template-columns: minmax(0, 1.45fr) minmax(280px, .75fr);
            gap: 22px;
            align-items: start;
        }

        .loker-detail-card {
            border: 1px solid #e7e9f0;
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .04);
        }

        .loker-detail-main {
            padding: clamp(20px, 4vw, 32px);
        }

        .loker-detail-heading {
            display: flex;
            align-items: center;
            gap: 16px;
            padding-bottom: 24px;
            border-bottom: 1px solid #eef0f5;
        }

        .loker-detail-logo {
            display: flex;
            width: min(100%, 280px);
            min-height: 120px;
            flex: 0 1 280px;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            padding: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            background: #f8fafc;
        }

        .loker-detail-logo--zoomable {
            position: relative;
            cursor: zoom-in;
        }

        .loker-detail-logo--zoomable:hover,
        .loker-detail-logo--zoomable:focus-visible {
            border-color: #a5b4fc;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, .14);
            outline: none;
        }

        .loker-detail-logo__hint {
            position: absolute;
            right: 8px;
            bottom: 8px;
            padding: 4px 7px;
            border-radius: 6px;
            background: rgba(17, 24, 39, .72);
            color: #ffffff;
            font-size: 10px;
            font-weight: 800;
            pointer-events: none;
        }

        .loker-detail-logo img {
            display: block;
            width: auto;
            height: auto;
            max-width: 100%;
            max-height: 260px;
            object-fit: contain;
            object-position: center;
        }

        .loker-detail-logo>span {
            display: inline-flex;
            width: 42px;
            height: 42px;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            /* background: linear-gradient(135deg, #111827, #4338ca); */
            color: #ffffff;
            font-size: 21px;
            font-weight: 900;
            letter-spacing: .04em;
        }

        .loker-detail-eyebrow {
            margin: 0 0 6px;
            color: #4338ca;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .loker-detail-title {
            margin: 0;
            color: #111827;
            font-size: clamp(24px, 3vw, 34px);
            font-weight: 900;
            letter-spacing: -.04em;
            line-height: 1.15;
        }

        .loker-detail-company {
            margin: 7px 0 0;
            color: #6b7280;
            font-size: 14px;
            font-weight: 700;
        }

        .loker-detail-section {
            padding-top: 26px;
        }

        .loker-detail-section h2,
        .loker-detail-side h2 {
            margin: 0 0 12px;
            color: #111827;
            font-size: 18px;
            font-weight: 900;
            letter-spacing: -.025em;
        }

        .loker-detail-copy {
            margin: 0;
            color: #4b5563;
            font-size: 14px;
            line-height: 1.8;
            white-space: pre-line;
        }

        .loker-detail-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .loker-detail-tag {
            padding: 7px 11px;
            border: 1px solid #e0e7ff;
            border-radius: 999px;
            background: #f5f7ff;
            color: #4338ca;
            font-size: 12px;
            font-weight: 700;
        }

        .loker-detail-side {
            display: grid;
            gap: 18px;
        }

        .loker-detail-info,
        .loker-detail-company-card {
            padding: 22px;
        }

        .loker-detail-info-list {
            display: grid;
            gap: 17px;
            margin: 0;
        }

        .loker-detail-info-item {
            display: grid;
            grid-template-columns: 28px minmax(0, 1fr);
            gap: 10px;
            align-items: start;
        }

        .loker-detail-info-item__icon {
            display: inline-flex;
            width: 28px;
            height: 28px;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: #eef2ff;
            color: #4338ca;
            font-size: 12px;
        }

        .loker-detail-info-item dt {
            margin-bottom: 3px;
            color: #6b7280;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .03em;
            text-transform: uppercase;
        }

        .loker-detail-info-item dd {
            margin: 0;
            color: #111827;
            font-size: 13px;
            font-weight: 800;
            line-height: 1.55;
        }

        .loker-detail-company-card__name {
            margin: 0 0 14px;
            color: #111827;
            font-size: 18px;
            font-weight: 900;
        }

        .loker-detail-company-card__item {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            margin-top: 12px;
            color: #4b5563;
            font-size: 13px;
            line-height: 1.6;
        }

        .loker-detail-company-card__item i {
            width: 16px;
            margin-top: 4px;
            color: #6366f1;
            text-align: center;
        }

        .loker-detail-apply {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 22px;
            border: 1px solid #c7d2fe;
            border-radius: 18px;
            background: linear-gradient(145deg, #eef2ff, #ffffff);
        }

        .loker-detail-apply h2 {
            margin: 0;
            color: #111827;
            font-size: 18px;
            font-weight: 900;
        }

        .loker-detail-apply p {
            margin: 0;
            color: #4b5563;
            font-size: 13px;
            line-height: 1.6;
        }

        .loker-detail-apply__button {
            display: inline-flex;
            min-height: 44px;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 4px;
            border-radius: 10px;
            background: #4f46e5;
            color: #ffffff;
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
        }

        .loker-detail-apply__button:hover,
        .loker-detail-apply__button:focus-visible {
            background: #3730a3;
            color: #ffffff;
            text-decoration: none;
        }

        .loker-detail-share {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 20px 22px;
        }

        .loker-detail-share h2 {
            margin: 0;
            color: #111827;
            font-size: 18px;
            font-weight: 900;
        }

        .loker-detail-share p {
            margin: 0;
            color: #6b7280;
            font-size: 13px;
            line-height: 1.6;
        }

        .loker-detail-share__actions {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
        }

        .loker-detail-share__button {
            display: inline-flex;
            min-height: 40px;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 8px 10px;
            border: 1px solid #e5e7eb;
            border-radius: 9px;
            background: #ffffff;
            color: #374151;
            cursor: pointer;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
            transition: .15s ease;
        }

        .loker-detail-share__button:hover,
        .loker-detail-share__button:focus-visible {
            border-color: #c7d2fe;
            background: #eef2ff;
            color: #3730a3;
            text-decoration: none;
            transform: translateY(-1px);
        }

        .loker-detail-share__button--whatsapp i {
            color: #16a34a;
        }

        .loker-detail-share__button--facebook i {
            color: #2563eb;
        }

        .loker-detail-share__button--instagram i {
            color: #db2777;
        }

        .loker-detail-share__feedback {
            min-height: 18px;
            margin: 0;
            color: #047857;
            font-size: 12px;
            font-weight: 700;
        }

        .loker-related {
            display: grid;
            gap: 16px;
        }

        .loker-related h2 {
            margin: 0;
            color: #111827;
            font-size: 22px;
            font-weight: 900;
            letter-spacing: -.03em;
        }

        .loker-related-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .loker-image-lightbox {
            position: fixed;
            z-index: 1050;
            inset: 0;
            display: grid;
            place-items: center;
            padding: 24px;
            background: rgba(15, 23, 42, .84);
        }

        .loker-image-lightbox[hidden] {
            display: none;
        }

        .loker-image-lightbox__figure {
            position: relative;
            max-width: 100%;
            max-height: 100%;
            margin: 0;
            text-align: center;
        }

        .loker-image-lightbox__image {
            display: block;
            width: auto;
            max-width: min(94vw, 1200px);
            max-height: 86vh;
            border-radius: 10px;
            background: #ffffff;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .35);
            object-fit: contain;
        }

        .loker-image-lightbox__caption {
            margin-top: 10px;
            color: #e5e7eb;
            font-size: 12px;
            font-weight: 700;
        }

        .loker-image-lightbox__close {
            position: fixed;
            top: 16px;
            right: 18px;
            display: inline-flex;
            width: 40px;
            height: 40px;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, .35);
            border-radius: 50%;
            background: rgba(15, 23, 42, .72);
            color: #ffffff;
            cursor: pointer;
            font-size: 24px;
            line-height: 1;
        }

        body.loker-image-lightbox-open {
            overflow: hidden;
        }

        @media (max-width: 991.98px) {
            .loker-detail-layout {
                grid-template-columns: 1fr;
            }

            .loker-related-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 575.98px) {
            .loker-detail-page--guest {
                padding-top: 108px;
                padding-bottom: 56px;
            }

            .loker-detail-page {
                width: min(100% - 32px, 1180px);
                padding-top: 24px;
            }

            .loker-detail-page.loker-detail-page--guest {
                padding-top: 108px;
            }

            .loker-detail-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .loker-detail-logo {
                width: 100%;
                flex-basis: auto;
                min-height: 0;
            }

            .loker-detail-logo img {
                max-height: min(70vw, 320px);
            }

            .loker-related-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="loker-detail-page {{ auth()->guest() ? 'loker-detail-page--guest' : '' }}">
        <a class="loker-detail-back" href="{{ route('membernonanggota.loker.index') }}">
            <i class="fas fa-arrow-left" aria-hidden="true"></i>
            Kembali ke daftar loker
        </a>

        <div class="loker-detail-layout">
            <article class="loker-detail-card loker-detail-main">
                <header class="loker-detail-heading">
                    @if ($imageUrl)
                        <button class="loker-detail-logo loker-detail-logo--zoomable" type="button"
                            id="loker-image-trigger" aria-haspopup="dialog" aria-controls="loker-image-lightbox"
                            aria-label="Perbesar gambar {{ $companyName }}">
                            <img src="{{ $imageUrl }}" alt="Logo {{ $companyName }}">
                            <span class="loker-detail-logo__hint">↗️</span>
                        </button>
                    @else
                        <div class="loker-detail-logo">
                            <span aria-hidden="true">{{ strtoupper(substr($companyName, 0, 2)) }}</span>
                        </div>
                    @endif
                    <div>
                        <p class="loker-detail-eyebrow">Lowongan aktif</p>
                        <h1 class="loker-detail-title">{{ $loker->title }}</h1>
                        <p class="loker-detail-company">{{ $companyName }}</p>
                    </div>
                </header>

                <section class="loker-detail-section" aria-labelledby="loker-description-title">
                    <h2 id="loker-description-title">Deskripsi pekerjaan</h2>
                    <p class="loker-detail-copy">{{ $description ?: 'Deskripsi pekerjaan belum tersedia.' }}</p>
                </section>

                @if ($jobdesk)
                    <section class="loker-detail-section" aria-labelledby="loker-jobdesk-title">
                        <h2 id="loker-jobdesk-title">Tanggung jawab dan tugas</h2>
                        <p class="loker-detail-copy">{{ $jobdesk }}</p>
                    </section>
                @endif

                @if (count($skills) > 0)
                    <section class="loker-detail-section" aria-labelledby="loker-skill-title">
                        <h2 id="loker-skill-title">Keahlian yang dibutuhkan</h2>
                        <div class="loker-detail-tags">
                            @foreach ($skills as $skill)
                                <span class="loker-detail-tag">{{ $skill }}</span>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if (count($types) > 0)
                    <section class="loker-detail-section" aria-labelledby="loker-type-title">
                        <h2 id="loker-type-title">Tipe pekerjaan</h2>
                        <div class="loker-detail-tags">
                            @foreach ($types as $type)
                                <span class="loker-detail-tag">{{ ucfirst((string) $type) }}</span>
                            @endforeach
                        </div>
                    </section>
                @endif
            </article>

            <aside class="loker-detail-side">
                <section class="loker-detail-apply" aria-labelledby="loker-apply-title">
                    <h2 id="loker-apply-title">Tertarik dengan lowongan ini?</h2>
                    <p>{{ auth()->check() ? 'Periksa kembali CV ATS Anda sebelum melanjutkan proses lamaran.' : 'Silakan login terlebih dahulu untuk melamar lowongan ini.' }}
                    </p>
                    @if (auth()->check())
                        <a class="loker-detail-apply__button"
                            href="{{ route('membernonanggota.loker.apply', $loker->id) }}">
                            <i class="fas fa-paper-plane" aria-hidden="true"></i>
                            Lamar Sekarang
                        </a>
                    @else
                        <a class="loker-detail-apply__button"
                            href="{{ route('login.new', ['redirect' => request()->getRequestUri()]) }}">
                            <i class="fas fa-sign-in-alt" aria-hidden="true"></i>
                            Login untuk melamar
                        </a>
                    @endif
                </section>

                @include('frontend.partials.cv-ats-cta')

                <section class="loker-detail-card loker-detail-share" aria-labelledby="loker-share-title">
                    <h2 id="loker-share-title">Bagikan lowongan</h2>
                    <p>Bagikan tautan ini ke teman atau jaringan profesional Anda.</p>
                    <div class="loker-detail-share__actions">
                        <a class="loker-detail-share__button loker-detail-share__button--whatsapp"
                            href="https://wa.me/?text={{ $shareText }}" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-whatsapp" aria-hidden="true"></i>
                            WhatsApp
                        </a>
                        <a class="loker-detail-share__button loker-detail-share__button--facebook"
                            href="{{ $facebookShareUrl }}" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-facebook" aria-hidden="true"></i>
                            Facebook
                        </a>
                        <button class="loker-detail-share__button loker-detail-share__button--instagram" type="button"
                            data-share-platform="instagram" data-share-url="{{ $shareUrl }}">
                            <i class="fab fa-instagram" aria-hidden="true"></i>
                            Instagram
                        </button>
                        <button class="loker-detail-share__button" type="button" data-share-platform="copy"
                            data-share-url="{{ $shareUrl }}">
                            <i class="fas fa-link" aria-hidden="true"></i>
                            Salin tautan
                        </button>
                    </div>
                    <p class="loker-detail-share__feedback" id="loker-share-feedback" role="status" aria-live="polite"></p>
                </section>

                <section class="loker-detail-card loker-detail-info" aria-labelledby="loker-summary-title">
                    <h2 id="loker-summary-title">Ringkasan informasi</h2>
                    <dl class="loker-detail-info-list">
                        <div class="loker-detail-info-item">
                            <span class="loker-detail-info-item__icon" aria-hidden="true"><i
                                    class="fas fa-map-marker-alt"></i></span>
                            <div>
                                <dt>Lokasi penempatan</dt>
                                <dd>{{ collect([$city, $province])->filter()->join(', ') ?:'Belum tersedia' }}</dd>
                            </div>
                        </div>
                        <div class="loker-detail-info-item">
                            <span class="loker-detail-info-item__icon" aria-hidden="true"><i
                                    class="fas fa-money-bill-wave"></i></span>
                            <div>
                                <dt>Estimasi gaji</dt>
                                <dd>
                                    @if ((float) $loker->gaji_min > 0 || (float) $loker->gaji_max > 0)
                                        Rp {{ number_format((float) $loker->gaji_min, 0, ',', '.') }}
                                        @if ((float) $loker->gaji_max > 0)
                                            - Rp {{ number_format((float) $loker->gaji_max, 0, ',', '.') }}
                                        @endif
                                    @else
                                        Gaji kompetitif
                                    @endif
                                </dd>
                            </div>
                        </div>
                        <div class="loker-detail-info-item">
                            <span class="loker-detail-info-item__icon" aria-hidden="true"><i
                                    class="fas fa-calendar-alt"></i></span>
                            <div>
                                <dt>Periode pendaftaran</dt>
                                <dd>
                                    {{ $loker->tanggal_awal ? \Carbon\Carbon::parse($loker->tanggal_awal)->locale('id')->isoFormat('D MMM YYYY') : 'Terbuka' }}
                                    s/d
                                    {{ $loker->tanggal_akhir ? \Carbon\Carbon::parse($loker->tanggal_akhir)->locale('id')->isoFormat('D MMM YYYY') : 'Tidak ditentukan' }}
                                </dd>
                            </div>
                        </div>
                        <div class="loker-detail-info-item">
                            <span class="loker-detail-info-item__icon" aria-hidden="true"><i class="far fa-eye"></i></span>
                            <div>
                                <dt>Dilihat</dt>
                                <dd>{{ number_format($loker->views) }} kali</dd>
                            </div>
                        </div>
                    </dl>
                </section>

                <section class="loker-detail-card loker-detail-company-card" aria-labelledby="loker-company-title">
                    <h2 id="loker-company-title">Tentang perusahaan</h2>
                    <p class="loker-detail-company-card__name">{{ $companyName }}</p>
                    {{-- @if ($company?->email ?: $loker->email)
                        <div class="loker-detail-company-card__item">
                            <i class="fas fa-envelope" aria-hidden="true"></i>
                            <span>{{ $company?->email ?: $loker->email }}</span>
                        </div>
                    @endif --}}
                    @if ($address)
                        <div class="loker-detail-company-card__item">
                            <i class="fas fa-location-arrow" aria-hidden="true"></i>
                            <span>{{ $address }}</span>
                        </div>
                    @endif
                    @if (!$company?->email && !$loker->email && !$address)
                        <p class="loker-detail-copy">Informasi kontak perusahaan belum tersedia.</p>
                    @endif
                </section>
            </aside>
        </div>

        @if ($relatedLokers->isNotEmpty())
            <section class="loker-related" aria-labelledby="loker-related-title">
                <h2 id="loker-related-title">Lowongan lainnya</h2>
                <div class="loker-related-grid">
                    @foreach ($relatedLokers as $relatedLoker)
                        @include('membernonkeanggotaan.components.ui.loker-card', [
                            'loker' => $relatedLoker,
                        ])
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    @if ($imageUrl)
        <div class="loker-image-lightbox" id="loker-image-lightbox" role="dialog" aria-modal="true"
            aria-labelledby="loker-image-lightbox-caption" hidden>
            <button class="loker-image-lightbox__close" type="button" id="loker-image-lightbox-close"
                aria-label="Tutup gambar">&times;</button>
            <figure class="loker-image-lightbox__figure">
                <img class="loker-image-lightbox__image" src="{{ $imageUrl }}"
                    alt="Logo {{ $companyName }} diperbesar">
                <figcaption class="loker-image-lightbox__caption" id="loker-image-lightbox-caption">
                    {{ $companyName }}
                </figcaption>
            </figure>
        </div>
    @endif

    <script>
        (() => {
            const imageTrigger = document.getElementById('loker-image-trigger');
            const lightbox = document.getElementById('loker-image-lightbox');
            const lightboxClose = document.getElementById('loker-image-lightbox-close');

            if (imageTrigger && lightbox && lightboxClose) {
                const closeLightbox = () => {
                    lightbox.hidden = true;
                    document.body.classList.remove('loker-image-lightbox-open');
                    imageTrigger.focus();
                };

                imageTrigger.addEventListener('click', () => {
                    lightbox.hidden = false;
                    document.body.classList.add('loker-image-lightbox-open');
                    lightboxClose.focus();
                });
                lightboxClose.addEventListener('click', closeLightbox);
                lightbox.addEventListener('click', (event) => {
                    if (event.target === lightbox) {
                        closeLightbox();
                    }
                });
                document.addEventListener('keydown', (event) => {
                    if (event.key === 'Escape' && !lightbox.hidden) {
                        closeLightbox();
                    }
                });
            }

            const feedback = document.getElementById('loker-share-feedback');

            const copyText = async (text) => {
                if (navigator.clipboard && window.isSecureContext) {
                    await navigator.clipboard.writeText(text);
                    return;
                }

                const input = document.createElement('textarea');
                input.value = text;
                input.setAttribute('readonly', '');
                input.style.position = 'fixed';
                input.style.opacity = '0';
                document.body.appendChild(input);
                input.select();
                document.execCommand('copy');
                input.remove();
            };

            document.querySelectorAll('[data-share-platform]').forEach((button) => {
                button.addEventListener('click', async () => {
                    const platform = button.dataset.sharePlatform;
                    const shareUrl = button.dataset.shareUrl;

                    if (platform === 'instagram') {
                        window.open('https://www.instagram.com/', '_blank', 'noopener,noreferrer');
                    }

                    try {
                        await copyText(shareUrl);
                        feedback.textContent = platform === 'instagram' ?
                            'Tautan disalin. Tempelkan di Instagram.' :
                            'Tautan berhasil disalin.';
                    } catch (error) {
                        feedback.textContent =
                            'Tautan tidak dapat disalin otomatis. Silakan salin dari alamat browser.';
                    }
                });
            });
        })();
    </script>
@endsection
