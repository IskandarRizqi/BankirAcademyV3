@extends('layouts.appmembernonanggota')

@section('title', 'Preview CV ATS')

@section('content')
    @php
        $company = $loker->perusahaan;
        $companyName = $loker->nama ?: optional($company)->nama ?: 'Perusahaan mitra';
    @endphp

    <style>
        .loker-apply-preview {
            display: grid;
            gap: 22px;
        }

        .loker-apply-preview__header,
        .loker-apply-preview__document {
            border: 1px solid #e7e9f0;
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .04);
        }

        .loker-apply-preview__header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 24px;
        }

        .loker-apply-preview__eyebrow {
            margin: 0 0 6px;
            color: #4338ca;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .loker-apply-preview__title {
            margin: 0;
            color: #111827;
            font-size: clamp(22px, 3vw, 30px);
            font-weight: 900;
            letter-spacing: -.04em;
        }

        .loker-apply-preview__company {
            margin: 6px 0 0;
            color: #6b7280;
            font-size: 14px;
            font-weight: 700;
        }

        .loker-apply-preview__actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .loker-apply-preview__actions a {
            display: inline-flex;
            min-height: 42px;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 8px 13px;
            border: 1px solid #e5e7eb;
            border-radius: 9px;
            background: #ffffff;
            color: #374151;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
        }

        .loker-apply-preview__actions form {
            display: inline-flex;
        }

        .loker-apply-preview__submit {
            display: inline-flex;
            min-height: 42px;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 8px 13px;
            border: 0;
            border-radius: 9px;
            background: #4f46e5;
            color: #ffffff;
            cursor: pointer;
            font-size: 12px;
            font-weight: 800;
        }

        .loker-apply-preview__submit:hover,
        .loker-apply-preview__submit:focus-visible {
            background: #3730a3;
        }

        .loker-apply-preview__submitted {
            display: inline-flex;
            min-height: 42px;
            align-items: center;
            gap: 7px;
            padding: 8px 13px;
            border-radius: 9px;
            background: #ecfdf5;
            color: #047857;
            font-size: 12px;
            font-weight: 800;
        }

        .loker-apply-preview__actions a:hover,
        .loker-apply-preview__actions a:focus-visible {
            border-color: #c7d2fe;
            background: #eef2ff;
            color: #3730a3;
            text-decoration: none;
        }

        .loker-apply-preview__document {
            overflow: hidden;
        }

        .loker-apply-preview__document-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 16px 20px;
            border-bottom: 1px solid #eef0f5;
        }

        .loker-apply-preview__document-header h2 {
            margin: 0;
            color: #111827;
            font-size: 17px;
            font-weight: 900;
        }

        .loker-apply-preview__document-header span {
            color: #6b7280;
            font-size: 12px;
            font-weight: 700;
        }

        .loker-apply-preview__frame {
            display: block;
            width: 100%;
            height: min(82vh, 1080px);
            border: 0;
            background: #f3f4f6;
        }

        @media (max-width: 767.98px) {
            .loker-apply-preview__header {
                align-items: flex-start;
                flex-direction: column;
            }

            .loker-apply-preview__actions,
            .loker-apply-preview__actions a,
            .loker-apply-preview__actions form,
            .loker-apply-preview__actions form button,
            .loker-apply-preview__submitted {
                width: 100%;
            }
        }
    </style>

    <div class="loker-apply-preview">
        <section class="loker-apply-preview__header" aria-labelledby="loker-apply-preview-title">
            <div>
                <p class="loker-apply-preview__eyebrow">Preview sebelum melamar</p>
                <h1 class="loker-apply-preview__title" id="loker-apply-preview-title">{{ $loker->title }}</h1>
                <p class="loker-apply-preview__company">{{ $companyName }}</p>
            </div>
            <div class="loker-apply-preview__actions">
                <a href="{{ route('membernonanggota.loker.show', $loker->id) }}">
                    <i class="fas fa-arrow-left" aria-hidden="true"></i>
                    Kembali
                </a>
                <a href="{{ route('membernonanggota.cv-ats.edit') }}">
                    <i class="fas fa-edit" aria-hidden="true"></i>
                    Edit CV ATS
                </a>
                <a href="{{ route('membernonanggota.cv-ats.pdf') }}" target="_blank" rel="noopener">
                    <i class="fas fa-external-link-alt" aria-hidden="true"></i>
                    Buka PDF
                </a>
                @if ($alreadyApplied)
                    <span class="loker-apply-preview__submitted">
                        <i class="fas fa-check-circle" aria-hidden="true"></i>
                        Lamaran sudah dikirim
                    </span>
                    <a href="{{ route('membernonanggota.loker.history') }}">
                        <i class="fas fa-history" aria-hidden="true"></i>
                        Lihat Riwayat
                    </a>
                @else
                    <form action="{{ route('membernonanggota.loker.apply.store', $loker->id) }}" method="POST"
                        onsubmit="return handleApplySubmit(this);">
                        @csrf
                        <button class="loker-apply-preview__submit" type="submit" id="btn-submit-apply">
                            <i class="fas fa-paper-plane" aria-hidden="true"></i>
                            <span>Kirim CV</span>
                        </button>
                    </form>
                @endif
            </div>
        </section>

        <section class="loker-apply-preview__document" aria-labelledby="cv-preview-title">
            <div class="loker-apply-preview__document-header">
                <h2 id="cv-preview-title">CV ATS Anda</h2>
                <span>{{ $cv->nama_lengkap }}</span>
            </div>
            <iframe class="loker-apply-preview__frame" src="{{ route('membernonanggota.cv-ats.pdf') }}"
                title="Preview CV ATS {{ $cv->nama_lengkap }}"></iframe>
        </section>
    </div>
    <script>
        function handleApplySubmit(form) {
            if (!confirm('Kirim CV ATS untuk lowongan ini?')) {
                return false;
            }

            const button = form.querySelector('button[type="submit"]');
            if (button) {
                // Nonaktifkan tombol agar tidak bisa diklik lagi
                button.disabled = true;
                button.style.opacity = '0.7';
                button.style.cursor = 'not-allowed';

                // Ubah tampilan text dan ikon menjadi loading
                button.innerHTML = `<i class="fas fa-spinner fa-spin" aria-hidden="true"></i> Memproses...`;
            }

            return true;
        }
    </script>
@endsection
