@extends('layouts.appmembernonanggota')

@section('title', 'Buat CV ATS')

@section('content')
    <style>
        .cv-page {
            display: flex;
            flex-direction: column;
            gap: 22px;
            /* max-width: 1080px; */
            margin: 0 auto;
        }

        .cv-hero,
        .cv-card,
        .empty-cv {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
        }

        .cv-hero {
            position: relative;
            overflow: hidden;
            border-radius: 24px;
            padding: clamp(24px, 5vw, 42px);
            color: #ffffff;
            background:
                radial-gradient(circle at 84% 18%, rgba(129, 140, 248, .35), transparent 28%),
                linear-gradient(135deg, #111827 0%, #312e81 55%, #4f46e5 100%);
            box-shadow: 0 20px 48px rgba(49, 46, 129, .2);
        }

        .cv-hero::after {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, .06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, .06) 1px, transparent 1px);
            background-size: 38px 38px;
            content: "";
            mask-image: linear-gradient(90deg, transparent, #000 22%, #000 88%, transparent);
            pointer-events: none;
        }

        .cv-hero-content {
            position: relative;
            z-index: 1;
        }

        .cv-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 14px;
            padding: 7px 12px;
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 999px;
            background: rgba(255, 255, 255, .12);
            color: rgba(255, 255, 255, .9);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .cv-hero h1 {
            margin: 0;
            font-size: clamp(28px, 4vw, 46px);
            font-weight: 900;
            letter-spacing: -.05em;
            line-height: 1.05;
        }

        .cv-hero p {
            max-width: 650px;
            margin: 14px 0 0;
            color: rgba(255, 255, 255, .84);
            font-size: 15px;
            line-height: 1.7;
        }

        .cv-actions {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 10px;
            margin-top: 22px;
        }

        .cv-actions .btn,
        .empty-cv .btn {
            /* min-height: 44px; */
            border-radius: 10px;
            /* font-weight: 700; */
        }

        .cv-actions .cv-print-button {
            border-color: #ffffff;
            background: #ffffff;
            color: #3730a3;
        }

        .cv-actions .cv-print-button:hover,
        .cv-actions .cv-print-button:focus-visible {
            border-color: #eef2ff;
            background: #eef2ff;
            color: #312e81;
        }

        .cv-card {
            height: 100%;
            padding: 26px;
        }

        .cv-section+.cv-section {
            margin-top: 28px;
            padding-top: 28px;
            border-top: 1px solid #edf0f5;
        }

        .cv-section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
            color: #172033;
            font-size: 1rem;
            font-weight: 800;
        }

        .cv-section-title i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 9px;
            color: #4f46e5;
            background: #eef0fe;
        }

        .cv-meta-label {
            margin-bottom: 4px;
            color: #6b7280;
            font-size: 12px;
            font-weight: 600;
        }

        .cv-meta-value {
            color: #172033;
            font-size: 14px;
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .cv-summary {
            margin: 0;
            color: #4b5563;
            line-height: 1.75;
            white-space: pre-line;
        }

        .cv-item {
            padding: 16px;
            border: 1px solid #edf0f5;
            border-radius: 12px;
            background: #fbfcfe;
        }

        .cv-item+.cv-item {
            margin-top: 12px;
        }

        .cv-item-title {
            margin: 0;
            color: #172033;
            font-size: 15px;
            font-weight: 800;
        }

        .cv-item-subtitle {
            margin: 4px 0 0;
            color: #4f46e5;
            font-size: 13px;
            font-weight: 700;
        }

        .cv-item-period {
            flex: 0 0 auto;
            color: #64748b;
            font-size: 12px;
            font-weight: 700;
        }

        .cv-item-description {
            margin: 12px 0 0;
            color: #4b5563;
            font-size: 13px;
            line-height: 1.65;
            white-space: pre-line;
        }

        .empty-cv {
            padding: clamp(32px, 7vw, 72px) 24px;
            text-align: center;
        }

        .empty-cv-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 68px;
            height: 68px;
            margin-bottom: 20px;
            border-radius: 20px;
            color: #4f46e5;
            background: #eef0fe;
            font-size: 28px;
        }

        .empty-cv h1 {
            margin-bottom: 10px;
            color: #172033;
            font-size: clamp(1.35rem, 3vw, 1.75rem);
            font-weight: 800;
        }

        .empty-cv p {
            max-width: 520px;
            margin: 0 auto 24px;
            color: #6b7280;
        }

        @media (max-width: 767.98px) {

            .cv-hero,
            .cv-card {
                padding: 22px;
            }

            .cv-actions {
                justify-content: flex-start;
                margin-top: 22px;
            }

            .cv-actions .btn {
                flex: 1;
            }

            .cv-item-header {
                display: block !important;
            }

            .cv-item-period {
                display: inline-block;
                margin-top: 8px;
            }
        }
    </style>

    <div class="cv-page">
        @if (!$cv)
            <div class="empty-cv">
                <div class="empty-cv-icon" aria-hidden="true"><i class="fas fa-file-signature"></i></div>
                <h1>Anda belum mengisi informasi riwayat hidup / CV Anda.</h1>
                <p>Lengkapi data diri, pendidikan, pengalaman kerja, dan sertifikasi untuk membuat CV ATS yang lebih siap
                    digunakan.</p>
                <a href="{{ route('membernonanggota.cv-ats.create') }}" class="btn btn-primary px-4">
                    <i class="fas fa-plus mr-2" aria-hidden="true"></i> Isi Informasi CV
                </a>
            </div>
        @else
            <section class="cv-hero" aria-labelledby="cv-page-title">
                <div class="row align-items-center cv-hero-content">
                    <div class="col-12">
                        <h1 id="cv-page-title">{{ $cv->nama_lengkap }}</h1>
                        <p>Anda dapat memperbarui data kapan saja tanpa membuat CV baru.</p>
                        <div class="cv-actions">
                            <a href="{{ route('membernonanggota.cv-ats.edit') }}" class="btn btn-warning px-3">
                                Edit CV
                            </a>
                            <a href="{{ route('membernonanggota.cv-ats.pdf') }}" class="btn cv-print-button px-3"
                                target="_blank" rel="noopener">
                                Cetak CV ATS
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="cv-card">
                        <section class="cv-section">
                            <h2 class="cv-section-title"><i class="fas fa-user" aria-hidden="true"></i> Data Pribadi</h2>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <div class="cv-meta-label">Nama panggilan</div>
                                    <div class="cv-meta-value">{{ $cv->nama_panggilan }}</div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="cv-meta-label">No. Telepon / WhatsApp</div>
                                    <div class="cv-meta-value">{{ $cv->telpdomisili }}</div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="cv-meta-label">Tempat, tanggal lahir</div>
                                    <div class="cv-meta-value">{{ $cv->tmpttgllahir }}</div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="cv-meta-label">Tempat lahir</div>
                                    <div class="cv-meta-value">{{ $cv->tempat_lahir ?? '-' }}</div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="cv-meta-label">Tanggal lahir</div>
                                    <div class="cv-meta-value">
                                        {{ $cv->tanggal_lahir ? \Carbon\Carbon::parse($cv->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="cv-meta-label">Agama</div>
                                    <div class="cv-meta-value">{{ $cv->namaagama }}</div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="cv-meta-label">Status perkawinan</div>
                                    <div class="cv-meta-value">{{ $cv->statusperkawinan }}</div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="cv-meta-label">Kode pos</div>
                                    <div class="cv-meta-value">{{ $cv->kodepos }}</div>
                                </div>
                                <div class="col-12">
                                    <div class="cv-meta-label">Alamat domisili</div>
                                    <div class="cv-meta-value">{{ $cv->alamatdomisili }}</div>
                                </div>
                            </div>
                        </section>

                        <section class="cv-section">
                            <h2 class="cv-section-title"><i class="fas fa-align-left" aria-hidden="true"></i> Ringkasan
                                Profil</h2>
                            <p class="cv-summary">{{ $cv->pengalamanspesifik }}</p>
                        </section>

                        <section class="cv-section">
                            <h2 class="cv-section-title"><i class="fas fa-graduation-cap" aria-hidden="true"></i> Riwayat
                                Pendidikan</h2>
                            @if ($cv->perguruannama)
                                <div class="cv-item mb-3">
                                    <h3 class="cv-item-title">{{ $cv->perguruannama }}</h3>
                                    <p class="cv-item-subtitle">{{ $cv->perguruanfakultas }} · {{ $cv->perguruangelar }}
                                    </p>
                                    <span class="cv-item-period">{{ $cv->perguruantahun }}</span>
                                </div>
                            @endif
                            @if ($cv->smanama)
                                <div class="cv-item">
                                    <h3 class="cv-item-title">{{ $cv->smanama }}</h3>
                                    <p class="cv-item-subtitle">{{ $cv->smafakultas }}</p>
                                    <span class="cv-item-period">{{ $cv->smatahun }}</span>
                                </div>
                            @endif
                        </section>
                    </div>
                </div>

                <div class="col-lg-8 mb-4">
                    <div class="cv-card">
                        <section class="cv-section">
                            <h2 class="cv-section-title"><i class="fas fa-briefcase" aria-hidden="true"></i> Pengalaman
                                Kerja</h2>
                            @forelse($experiences as $experience)
                                <article class="cv-item">
                                    <div class="cv-item-header d-flex justify-content-between align-items-start">
                                        <div>
                                            <h3 class="cv-item-title">{{ $experience['position'] }}</h3>
                                            <p class="cv-item-subtitle">{{ $experience['company'] }}</p>
                                        </div>
                                        <span class="cv-item-period">{{ $experience['period'] }}</span>
                                    </div>
                                    <p class="cv-item-description">{{ $experience['responsibility'] }}</p>
                                </article>
                            @empty
                                <p class="text-muted mb-0">Belum ada pengalaman kerja yang ditambahkan.</p>
                            @endforelse
                        </section>

                        <section class="cv-section">
                            <h2 class="cv-section-title"><i class="fas fa-certificate" aria-hidden="true"></i> Pelatihan
                                &amp; Sertifikasi</h2>
                            @forelse($trainings as $training)
                                <article class="cv-item">
                                    <div class="cv-item-header d-flex justify-content-between align-items-start">
                                        <div>
                                            <h3 class="cv-item-title">{{ $training['name'] }}</h3>
                                            <p class="cv-item-subtitle">{{ $training['organizer'] }}</p>
                                        </div>
                                        <span class="cv-item-period">{{ $training['year'] }}</span>
                                    </div>
                                </article>
                            @empty
                                <p class="text-muted mb-0">Belum ada pelatihan atau sertifikasi yang ditambahkan.</p>
                            @endforelse
                        </section>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
