@extends('layouts.appmembernonanggota')

@section('title', 'Riwayat Lamaran')

@section('content')
    <style>
        .loker-history-page {
            display: grid;
            gap: 22px;
        }

        .loker-history-hero,
        .loker-history-card,
        .loker-history-disclaimer {
            border: 1px solid #e7e9f0;
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .04);
        }

        .loker-history-hero {
            padding: clamp(22px, 4vw, 32px);
            background: linear-gradient(135deg, #111827, #312e81 60%, #4f46e5);
            color: #ffffff;
        }

        .loker-history-hero__eyebrow {
            margin: 0 0 7px;
            color: #c7d2fe;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .loker-history-hero h1 {
            margin: 0;
            font-size: clamp(26px, 4vw, 38px);
            font-weight: 900;
            letter-spacing: -.05em;
        }

        .loker-history-hero p {
            max-width: 620px;
            margin: 10px 0 0;
            color: rgba(255, 255, 255, .78);
            font-size: 14px;
            line-height: 1.7;
        }

        .loker-history-card {
            overflow: hidden;
        }

        .loker-history-table-wrapper {
            overflow-x: auto;
        }

        .loker-history-table {
            width: 100%;
            min-width: 680px;
            margin: 0;
            border-collapse: collapse;
        }

        .loker-history-table th {
            padding: 15px 20px;
            border-bottom: 1px solid #eef0f5;
            background: #f8fafc;
            color: #6b7280;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .05em;
            text-align: left;
            text-transform: uppercase;
        }

        .loker-history-table td {
            padding: 18px 20px;
            border-bottom: 1px solid #f1f3f7;
            color: #4b5563;
            font-size: 13px;
            vertical-align: middle;
        }

        .loker-history-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .loker-history-job__title {
            display: block;
            color: #111827;
            font-size: 14px;
            font-weight: 900;
            text-decoration: none;
        }

        .loker-history-job__title:hover,
        .loker-history-job__title:focus-visible {
            color: #4338ca;
            text-decoration: none;
        }

        .loker-history-job__company {
            display: block;
            margin-top: 4px;
            color: #6b7280;
            font-size: 12px;
        }

        .loker-history-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 999px;
            background: #bfe7aa;
            color: #346717;
            font-size: 11px;
            font-weight: 900;
        }

        .loker-history-empty {
            padding: 56px 24px;
            text-align: center;
        }

        .loker-history-empty i {
            display: inline-flex;
            width: 58px;
            height: 58px;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            background: #eef2ff;
            color: #4f46e5;
            font-size: 22px;
        }

        .loker-history-empty h2 {
            margin: 16px 0 7px;
            color: #111827;
            font-size: 20px;
            font-weight: 900;
        }

        .loker-history-empty p {
            margin: 0 auto 18px;
            color: #6b7280;
            font-size: 13px;
        }

        .loker-history-empty a {
            display: inline-flex;
            min-height: 42px;
            align-items: center;
            padding: 8px 14px;
            border-radius: 9px;
            background: #4f46e5;
            color: #ffffff;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
        }

        .loker-history-pagination {
            padding: 16px 20px;
            border-top: 1px solid #eef0f5;
        }

        /* Style Tambahan untuk Informasi Disclaimer di Bawah */
        .loker-history-disclaimer {
            padding: 20px;
            background: #f8fafc;
            border-color: #e2e8f0;
            display: flex;
            gap: 16px;
            align-items: flex-start;
        }

        .loker-history-disclaimer__icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #e0e7ff;
            color: #4338ca;
            font-size: 16px;
            flex-shrink: 0;
        }

        .loker-history-disclaimer__content h3 {
            margin: 0 0 4px;
            font-size: 13px;
            font-weight: 800;
            color: #1e293b;
        }

        .loker-history-disclaimer__content p {
            margin: 0;
            font-size: 12px;
            line-height: 1.6;
            color: #64748b;
        }
    </style>

    <div class="loker-history-page">
        <section class="loker-history-hero" aria-labelledby="loker-history-title">
            <p class="loker-history-hero__eyebrow">Perjalanan karier Anda</p>
            <h1 id="loker-history-title">Riwayat Lamaran</h1>
            <p>Pantau lowongan yang sudah Anda lamar dan status prosesnya dalam satu tempat.</p>
        </section>

        <section class="loker-history-card" aria-label="Daftar riwayat lamaran">
            @if ($applications->isEmpty())
                <div class="loker-history-empty">
                    <i class="fas fa-briefcase" aria-hidden="true"></i>
                    <h2>Belum ada lamaran</h2>
                    <p>Lowongan yang Anda kirim dengan CV ATS akan muncul di sini.</p>
                    <a href="{{ route('membernonanggota.loker.index') }}">Lihat Lowongan</a>
                </div>
            @else
                <div class="loker-history-table-wrapper">
                    <table class="loker-history-table">
                        <thead>
                            <tr>
                                <th>Lowongan</th>
                                <th>Tanggal Lamar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($applications as $application)
                                @php
                                    $loker = $application->loker;
                                    $company = $loker?->perusahaan;
                                    $companyName = $loker?->nama ?: optional($company)->nama ?: 'Perusahaan mitra';
                                @endphp
                                <tr>
                                    <td>
                                        @if ($loker)
                                            <a class="loker-history-job__title"
                                                href="{{ route('membernonanggota.loker.show', $loker->id) }}">
                                                {{ $loker->title }}
                                            </a>
                                        @else
                                            <span class="loker-history-job__title">Lowongan tidak tersedia</span>
                                        @endif
                                        <span class="loker-history-job__company">{{ $companyName }}</span>
                                    </td>
                                    <td>{{ optional($application->created_at)->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}
                                    </td>
                                    <td>
                                        <span class="loker-history-status">
                                            <i class="fas fa-clock" aria-hidden="true"></i>
                                            Terkirim
                                        </span>
                                    </td>
                                    <td>
                                        @if ($loker)
                                            <a class="btn btn-sm btn-outline-primary"
                                                href="{{ route('membernonanggota.loker.show', $loker->id) }}">Detail</a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($applications->hasPages())
                    <div class="loker-history-pagination">
                        {{ $applications->onEachSide(1)->links() }}
                    </div>
                @endif
            @endif
        </section>

        <!-- Informasi Penting / Disclaimer di Bagian Paling Bawah -->
        <aside class="loker-history-disclaimer" aria-label="Informasi Penting Lamaran">
            <div class="loker-history-disclaimer__icon">
                <i class="fas fa-info-circle" aria-hidden="true"></i>
            </div>
            <div class="loker-history-disclaimer__content">
                <h3>Informasi Penting</h3>
                <p>
                    Mengirimkan lamaran pekerjaan melalui platform ini tidak menjamin Anda secara otomatis diterima atau
                    lolos ke tahap seleksi berikutnya. Seluruh keputusan peninjauan berkas, pemanggilan wawancara, hingga
                    penerimaan kerja sepenuhnya merupakan hak prerogatif dan kebijakan dari masing-masing perusahaan
                    penyedia lowongan.
                </p>
            </div>
        </aside>
    </div>
@endsection
