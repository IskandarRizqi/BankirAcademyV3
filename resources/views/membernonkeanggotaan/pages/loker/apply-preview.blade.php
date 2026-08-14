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

        /* --- Custom Modal Overlay --- */
        .custom-modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(4px);
            opacity: 0;
            visibility: hidden;
            transition: all 0.25s ease-in-out;
        }

        .custom-modal-overlay.is-visible {
            opacity: 1;
            visibility: visible;
        }

        /* --- Custom Modal Card --- */
        .custom-modal {
            width: 100%;
            max-width: 420px;
            padding: 28px 24px 24px;
            border-radius: 20px;
            background: #ffffff;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            text-align: center;
            transform: scale(0.95);
            transition: transform 0.25s ease-in-out;
        }

        .custom-modal-overlay.is-visible .custom-modal {
            transform: scale(1);
        }

        .custom-modal__icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            margin-bottom: 16px;
            border-radius: 50%;
            background: #e0e7ff;
            color: #4f46e5;
            font-size: 24px;
        }

        .custom-modal__title {
            margin: 0 0 8px;
            color: #111827;
            font-size: 18px;
            font-weight: 800;
        }

        .custom-modal__description {
            margin: 0 0 24px;
            color: #6b7280;
            font-size: 14px;
            line-height: 1.5;
        }

        .custom-modal__actions {
            display: flex;
            gap: 12px;
        }

        .custom-modal__btn {
            display: inline-flex;
            flex: 1;
            min-height: 44px;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }

        .custom-modal__btn--cancel {
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #374151;
        }

        .custom-modal__btn--cancel:hover {
            background: #f9fafb;
            color: #111827;
        }

        .custom-modal__btn--confirm {
            border: 0;
            background: #4f46e5;
            color: #ffffff;
        }

        .custom-modal__btn--confirm:hover {
            background: #3730a3;
        }

        .custom-modal__btn--confirm:disabled {
            opacity: 0.7;
            cursor: not-allowed;
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
                    <span class="loker-apply-preview__submitted loker-apply-preview__submitted--cooldown"
                        title="Jeda lamaran 15 hari">
                        <i class="fas fa-clock" aria-hidden="true"></i>
                        Dapat melamar lagi: {{ $nextApplyDate->translatedFormat('d M Y') }}
                    </span>
                    <a href="{{ route('membernonanggota.loker.history') }}">
                        <i class="fas fa-history" aria-hidden="true"></i>
                        Lihat Riwayat
                    </a>
                @else
                    <form id="apply-form" action="{{ route('membernonanggota.loker.apply.store', $loker->id) }}"
                        method="POST">
                        @csrf
                        <button class="loker-apply-preview__submit" type="button" onclick="openApplyModal()">
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

    <!-- Modal Konfirmasi Custom -->
    <div class="custom-modal-overlay" id="confirm-modal" role="dialog" aria-modal="true" aria-labelledby="modal-title">
        <div class="custom-modal">
            <div class="custom-modal__icon">
                <i class="fas fa-paper-plane"></i>
            </div>
            <h3 class="custom-modal__title" id="modal-title">Kirim Lamaran?</h3>
            <p class="custom-modal__description">
                Apakah Anda yakin ingin mengirim CV ATS untuk posisi <strong>{{ $loker->title }}</strong>?
            </p>
            <div class="custom-modal__actions">
                <button type="button" class="custom-modal__btn custom-modal__btn--cancel" onclick="closeApplyModal()">
                    Batal
                </button>
                <button type="button" class="custom-modal__btn custom-modal__btn--confirm" id="btn-confirm-apply"
                    onclick="processApply()">
                    <i class="fas fa-paper-plane"></i>
                    <span>Ya, Kirim Sekarang</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('confirm-modal');
        const applyForm = document.getElementById('apply-form');
        const confirmBtn = document.getElementById('btn-confirm-apply');

        function openApplyModal() {
            modal.classList.add('is-visible');
        }

        function closeApplyModal() {
            modal.classList.remove('is-visible');
        }

        function processApply() {
            // Ubah tombol konfirmasi ke state loading
            confirmBtn.disabled = true;
            confirmBtn.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Memproses...`;

            // Submit form
            applyForm.submit();
        }

        // Tutup modal jika pengguna mengklik area luar modal (backdrop)
        modal.addEventListener('click', function(e) {
            if (e.target === modal && !confirmBtn.disabled) {
                closeApplyModal();
            }
        });
    </script>
@endsection
