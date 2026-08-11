@extends('layouts.appmembernonanggota')

@section('title', 'Detail Lowongan')

@section('content')
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
        $companyName = $loker->nama ?: optional($company)->nama ?: 'Perusahaan mitra';
        $imageUrl = $decodeImage($loker->image) ?: $decodeImage(optional($company)->image);
        $types = $decodeList($loker->type);
        $skills = $decodeList($loker->skill);
        $province = $loker->provinsi_name ?: optional($company)->provinsi_name;
        $city = $loker->kabupaten_name ?: optional($company)->kabupaten_name;
        $address = $loker->alamat ?: optional($company)->alamat;
        $description = trim(strip_tags((string) $loker->deskripsi));
        $jobdesk = trim(strip_tags((string) $loker->jobdesk));
    @endphp

    <style>
        .loker-detail-page {
            display: flex;
            flex-direction: column;
            gap: 22px;
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
            width: min(100%, 220px);
            height: 96px;
            flex: 0 0 220px;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            padding: 14px 20px;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            background: #f8fafc;
        }

        .loker-detail-logo img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
        }

        .loker-detail-logo>span {
            display: inline-flex;
            width: 64px;
            height: 64px;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            background: linear-gradient(135deg, #111827, #4338ca);
            color: #ffffff;
            font-size: 24px;
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

        @media (max-width: 991.98px) {
            .loker-detail-layout {
                grid-template-columns: 1fr;
            }

            .loker-related-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 575.98px) {
            .loker-detail-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .loker-detail-logo {
                width: 100%;
                flex-basis: auto;
            }

            .loker-related-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="loker-detail-page">
        <a class="loker-detail-back" href="{{ route('membernonanggota.loker.index') }}">
            <i class="fas fa-arrow-left" aria-hidden="true"></i>
            Kembali ke daftar loker
        </a>

        <div class="loker-detail-layout">
            <article class="loker-detail-card loker-detail-main">
                <header class="loker-detail-heading">
                    <div class="loker-detail-logo">
                        @if ($imageUrl)
                            <img src="{{ $imageUrl }}" alt="Logo {{ $companyName }}">
                        @else
                            <span aria-hidden="true">{{ strtoupper(substr($companyName, 0, 2)) }}</span>
                        @endif
                    </div>
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
                @if ($canApply)
                    <section class="loker-detail-apply" aria-labelledby="loker-apply-title">
                        <h2 id="loker-apply-title">Tertarik dengan lowongan ini?</h2>
                        <p>Periksa kembali CV ATS Anda sebelum melanjutkan proses lamaran.</p>
                        <a class="loker-detail-apply__button"
                            href="{{ route('membernonanggota.loker.apply', $loker->id) }}">
                            <i class="fas fa-paper-plane" aria-hidden="true"></i>
                            Lamar Sekarang
                        </a>
                    </section>
                @endif

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
                    </dl>
                </section>

                <section class="loker-detail-card loker-detail-company-card" aria-labelledby="loker-company-title">
                    <h2 id="loker-company-title">Tentang perusahaan</h2>
                    <p class="loker-detail-company-card__name">{{ $companyName }}</p>
                    @if ($company?->email ?: $loker->email)
                        <div class="loker-detail-company-card__item">
                            <i class="fas fa-envelope" aria-hidden="true"></i>
                            <span>{{ $company?->email ?: $loker->email }}</span>
                        </div>
                    @endif
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
@endsection
