@extends('layouts.appmembernonanggota')

@section('content')
@once
<style>
    .certificate-page {
        width: 100%;
    }

    .certificate-page__hero {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 24px;
        padding: 28px;
        border-radius: 24px;
        background:
            radial-gradient(circle at 85% 15%, rgba(196, 181, 253, .44), transparent 30%),
            linear-gradient(135deg, #312e81, #4f46e5 55%, #7c3aed);
        color: #ffffff;
        box-shadow: 0 20px 50px rgba(79, 70, 229, .2);
    }

    .certificate-page__eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 10px;
        color: rgba(255, 255, 255, .76);
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .certificate-page__title {
        margin: 0;
        font-size: clamp(26px, 4vw, 36px);
        font-weight: 900;
        letter-spacing: -.04em;
        line-height: 1.1;
    }

    .certificate-page__subtitle {
        max-width: 680px;
        margin: 10px 0 0;
        color: rgba(255, 255, 255, .78);
        font-size: 14px;
        line-height: 1.65;
    }

    .certificate-page__total {
        flex: 0 0 auto;
        min-width: 118px;
        padding: 14px 16px;
        border: 1px solid rgba(255, 255, 255, .18);
        border-radius: 18px;
        background: rgba(255, 255, 255, .12);
        text-align: center;
        backdrop-filter: blur(10px);
    }

    .certificate-page__total strong {
        display: block;
        font-size: 28px;
        line-height: 1;
    }

    .certificate-page__total span {
        display: block;
        margin-top: 7px;
        color: rgba(255, 255, 255, .75);
        font-size: 11px;
        font-weight: 800;
        line-height: 1.3;
    }

    .certificate-filter {
        margin-bottom: 24px;
        padding: 18px;
        border: 1px solid #e7e9f0;
        border-radius: 18px;
        background: #ffffff;
        box-shadow: 0 8px 26px rgba(15, 23, 42, .035);
    }

    .certificate-filter__grid {
        display: grid;
        grid-template-columns: minmax(220px, 1.8fr) repeat(2, minmax(150px, 1fr)) auto;
        gap: 12px;
        align-items: end;
    }

    .certificate-filter__field label {
        display: block;
        margin-bottom: 6px;
        color: #4b5563;
        font-size: 12px;
        font-weight: 800;
    }

    .certificate-filter__control {
        width: 100%;
        min-height: 42px;
        padding: 9px 12px;
        border: 1px solid #dbe2ea;
        border-radius: 9px;
        background: #ffffff;
        color: #374151;
        font-size: 13px;
    }

    .certificate-filter__control:focus {
        border-color: var(--primary, #4f46e5);
        outline: 0;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, .12);
    }

    .certificate-filter__actions {
        display: flex;
        gap: 8px;
    }

    .certificate-filter__button,
    .certificate-filter__reset {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        padding: 9px 14px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 850;
        text-decoration: none;
        white-space: nowrap;
    }

    .certificate-filter__button {
        border: 1px solid var(--primary, #4f46e5);
        background: var(--primary, #4f46e5);
        color: #ffffff;
        cursor: pointer;
    }

    .certificate-filter__button:hover {
        border-color: var(--primary-dark, #3d33d8);
        background: var(--primary-dark, #3d33d8);
        color: #ffffff;
    }

    .certificate-filter__reset {
        border: 1px solid #e5e7eb;
        background: #ffffff;
        color: #64748b;
    }

    .certificate-filter__reset:hover {
        border-color: #cbd5e1;
        background: #f8fafc;
        color: #374151;
    }

    .certificate-filter__error {
        margin: 12px 0 0;
        color: #b91c1c;
        font-size: 12px;
    }

    .certificate-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .certificate-card {
        display: flex;
        min-width: 0;
        flex-direction: column;
        overflow: hidden;
        border: 1px solid #e7e9f0;
        border-radius: 18px;
        background: #ffffff;
        box-shadow: 0 8px 26px rgba(15, 23, 42, .045);
    }

    .certificate-card__media {
        position: relative;
        aspect-ratio: 16 / 8;
        overflow: hidden;
        background: linear-gradient(135deg, #eef0fe, #ede9fe);
    }

    .certificate-card__media img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }

    .certificate-card__media::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, transparent 38%, rgba(15, 23, 42, .42));
        pointer-events: none;
    }

    .certificate-card__media-icon {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6366f1;
        font-size: 42px;
    }

    .certificate-card__body {
        display: flex;
        flex: 1;
        flex-direction: column;
        padding: 18px;
    }

    .certificate-card__status {
        align-self: flex-start;
        margin-bottom: 11px;
        padding: 6px 9px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 850;
        line-height: 1;
    }

    .certificate-card__status--available {
        background: #dcfce7;
        color: #166534;
    }

    .certificate-card__status--warning {
        background: #fef3c7;
        color: #92400e;
    }

    .certificate-card__title {
        display: -webkit-box;
        margin: 0;
        overflow: hidden;
        color: #111827;
        font-size: 18px;
        font-weight: 850;
        letter-spacing: -.025em;
        line-height: 1.3;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }

    .certificate-card__meta {
        display: flex;
        flex-wrap: wrap;
        gap: 8px 14px;
        margin: 12px 0 0;
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
    }

    .certificate-card__meta span {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .certificate-card__message {
        margin: 16px 0 0;
        padding: 11px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: #f8fafc;
        color: #64748b;
        font-size: 12.5px;
        line-height: 1.55;
    }

    .certificate-card__message--notice {
        border-color: #fed7aa;
        background: #fff7ed;
        color: #9a3412;
        font-weight: 750;
    }

    .certificate-card__actions {
        display: grid;
        gap: 9px;
        margin-top: auto;
        padding-top: 18px;
    }

    .certificate-card__select {
        width: 100%;
        min-height: 42px;
        padding: 9px 12px;
        border: 1px solid #dbe2ea;
        border-radius: 10px;
        background: #ffffff;
        color: #374151;
        font-size: 13px;
    }

    .certificate-card__actions .select2-container {
        width: 100% !important;
    }

    .certificate-card__actions .select2-container--default .select2-selection--single {
        height: 42px;
        border: 1px solid #dbe2ea;
        border-radius: 10px;
        background: #ffffff;
    }

    .certificate-card__actions .select2-container--default .select2-selection--single .select2-selection__rendered {
        padding: 6px 36px 6px 12px;
        color: #374151;
        font-size: 13px;
        line-height: 28px;
    }

    .certificate-card__actions .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
        right: 8px;
    }

    .certificate-card__actions .select2-container--default.select2-container--open .select2-selection--single,
    .certificate-card__actions .select2-container--focus .select2-selection--single {
        border-color: var(--primary, #4f46e5);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, .12);
    }

    .certificate-card__actions .select2-dropdown {
        border-color: #dbe2ea;
        border-radius: 10px;
        overflow: hidden;
    }

    .certificate-card__actions .select2-search__field {
        border-color: #dbe2ea !important;
        border-radius: 7px;
    }

    .certificate-card__button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        width: 100%;
        min-height: 42px;
        padding: 10px 13px;
        border: 1px solid var(--primary, #4f46e5);
        border-radius: 10px;
        background: var(--primary, #4f46e5);
        color: #ffffff;
        font-size: 12px;
        font-weight: 850;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
        transition: background .18s ease, border-color .18s ease, transform .18s ease;
    }

    .certificate-card__button:hover {
        border-color: var(--primary-dark, #3d33d8);
        background: var(--primary-dark, #3d33d8);
        color: #ffffff;
        transform: translateY(-1px);
    }

    .certificate-card__button--secondary {
        border-color: #e5e7eb;
        background: #ffffff;
        color: var(--primary, #4f46e5);
    }

    .certificate-card__button--secondary:hover {
        border-color: var(--primary, #4f46e5);
        background: var(--primary-soft, #eef0fe);
        color: var(--primary-dark, #3d33d8);
    }

    .certificate-card__button--success {
        border-color: #16a34a;
        background: #16a34a;
        color: #ffffff;
    }

    .certificate-card__button[aria-disabled="true"] {
        cursor: wait;
        opacity: .72;
        transform: none;
    }

    .certificate-card__button:disabled {
        border-color: #d1d5db;
        background: #e5e7eb;
        color: #9ca3af;
        cursor: not-allowed;
        box-shadow: none;
        opacity: 1;
        transform: none;
    }

    .certificate-empty {
        grid-column: 1 / -1;
        padding: 64px 24px;
        border: 1px dashed #dbe2ea;
        border-radius: 18px;
        background: #f8fafc;
        color: #64748b;
        text-align: center;
    }

    .certificate-empty i {
        margin-bottom: 16px;
        color: #a5b4fc;
        font-size: 42px;
    }

    .certificate-empty h2 {
        margin: 0 0 8px;
        color: #111827;
        font-size: 19px;
        font-weight: 850;
    }

    .certificate-empty p {
        max-width: 420px;
        margin: 0 auto;
        font-size: 13px;
        line-height: 1.6;
    }

    .certificate-pagination {
        display: flex;
        justify-content: center;
        margin-top: 24px;
    }

    .certificate-pagination .pagination {
        margin: 0;
    }

    @media (max-width: 1199.98px) {
        .certificate-filter__grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .certificate-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .certificate-page__hero {
            align-items: stretch;
            flex-direction: column;
            padding: 22px;
        }

        .certificate-page__total {
            align-self: flex-start;
        }

        .certificate-filter__grid {
            grid-template-columns: 1fr;
        }

        .certificate-filter__actions {
            flex-wrap: wrap;
        }

        .certificate-filter__button,
        .certificate-filter__reset {
            flex: 1;
        }

        .certificate-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .certificate-card__button {
            transition: none !important;
        }
    }
</style>
@endonce

<div class="row member-dashboard-grid" id="cancel-row">
    <div class="col-12 layout-top-spacing layout-spacing dashboard-card-column">
        <section class="certificate-page" aria-labelledby="certificate-page-title">
            <header class="certificate-page__hero">
                <div>
                    <span class="certificate-page__eyebrow">
                        <i class="fas fa-medal" aria-hidden="true"></i>
                        Pencapaian pembelajaran
                    </span>
                    <h1 class="certificate-page__title" id="certificate-page-title">Sertifikat Anda</h1>
                    <p class="certificate-page__subtitle">
                        Cetak sertifikat untuk peserta yang telah didaftarkan setelah kegiatan kelas selesai.
                    </p>
                </div>
                <div class="certificate-page__total" aria-label="Jumlah kelas terdaftar">
                    <strong>{{ $classes->total() }}</strong>
                    <span>Kelas terdaftar</span>
                </div>
            </header>

            <form class="certificate-filter" method="GET" action="{{ route('membernonanggota.certificates.index') }}">
                <div class="certificate-filter__grid">
                    <div class="certificate-filter__field">
                        <label for="certificate-class-name">Nama kelas</label>
                        <input
                            type="search"
                            id="certificate-class-name"
                            name="class_name"
                            class="certificate-filter__control"
                            value="{{ $filters['class_name'] }}"
                            placeholder="Cari nama kelas..."
                            autocomplete="off">
                    </div>
                    <div class="certificate-filter__field">
                        <label for="certificate-date-from">Tanggal mulai event</label>
                        <input
                            type="date"
                            id="certificate-date-from"
                            name="date_from"
                            class="certificate-filter__control"
                            value="{{ $filters['date_from'] }}">
                    </div>
                    <div class="certificate-filter__field">
                        <label for="certificate-date-to">Tanggal akhir event</label>
                        <input
                            type="date"
                            id="certificate-date-to"
                            name="date_to"
                            class="certificate-filter__control"
                            value="{{ $filters['date_to'] }}">
                    </div>
                    <div class="certificate-filter__actions">
                        <button type="submit" class="certificate-filter__button">
                            <i class="fas fa-filter mr-1" aria-hidden="true"></i>
                            Filter
                        </button>
                        <a href="{{ route('membernonanggota.certificates.index') }}" class="certificate-filter__reset">Reset</a>
                    </div>
                </div>
                @if($errors->has('date_to'))
                    <p class="certificate-filter__error" role="alert">{{ $errors->first('date_to') }}</p>
                @endif
            </form>

            <div class="certificate-grid" role="list" aria-label="Daftar kelas untuk sertifikat">
                @forelse($certificateClasses as $entry)
                    @php
                        $class = $entry['class'];
                        $isAvailable = $entry['status'] === 'available';
                        $statusClass = $isAvailable ? 'available' : 'warning';
                        $image = data_get($class, 'image_mobile') ?: data_get($class, 'image');
                    @endphp

                    <article class="certificate-card" role="listitem">
                        <div class="certificate-card__media">
                            @if($image && file_exists(public_path($image)))
                                <img src="{{ asset($image) }}" alt="{{ $class->title }}" loading="lazy">
                            @else
                                <div class="certificate-card__media-icon" aria-hidden="true">
                                    <i class="fas fa-award"></i>
                                </div>
                            @endif
                        </div>

                        <div class="certificate-card__body">
                            @if($entry['status'] !== 'not_requested')
                                <span class="certificate-card__status certificate-card__status--{{ $statusClass }}">
                                    <i class="fas {{ $isAvailable ? 'fa-check-circle' : 'fa-info-circle' }} mr-1" aria-hidden="true"></i>
                                    {{ $entry['status_label'] }}
                                </span>
                            @endif
                            <h2 class="certificate-card__title">{{ $class->title }}</h2>

                            <div class="certificate-card__meta">
                                <span><i class="fas fa-users" aria-hidden="true"></i> {{ $entry['participant_count'] }} peserta terdaftar</span>
                            </div>

                            @if($isAvailable)
                                <div class="certificate-card__actions">
                                    <form action="{{ route('membernonanggota.certificates.show', ['classId' => $class->id]) }}" method="GET" target="_blank" data-certificate-form>
                                        <label class="sr-only" for="participant-{{ $class->id }}">Pilih peserta sertifikat</label>
                                        <select class="certificate-card__select" id="participant-{{ $class->id }}" name="participant_index" required>
                                            <option value="">Pilih nama peserta</option>
                                            @foreach($entry['participants'] as $participant)
                                                <option value="{{ $participant['index'] }}" data-printable="{{ $participant['can_print'] ? '1' : '0' }}">
                                                    {{ $participant['nama'] }}{{ $participant['can_print'] ? '' : ' - Sertifikat tidak termasuk order' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="certificate-card__button mt-2" data-certificate-print-button disabled>
                                            <i class="fas fa-print" aria-hidden="true"></i>
                                            Cetak Sertifikat
                                        </button>
                                    </form>
                                    <a href="{{ route('membernonanggota.certificates.download', ['classId' => $class->id]) }}" class="certificate-card__button certificate-card__button--secondary js-certificate-zip-download">
                                        <i class="fas fa-file-archive" aria-hidden="true"></i>
                                        Unduh Semua (.zip)
                                    </a>
                                </div>
                            @else
                                <p class="certificate-card__message {{ $entry['status'] === 'not_requested' ? 'certificate-card__message--notice' : '' }}" role="status">
                                    <i class="fas fa-info-circle mr-1" aria-hidden="true"></i>
                                    {{ $entry['status_message'] }}
                                </p>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="certificate-empty" role="status">
                        <i class="fas fa-certificate" aria-hidden="true"></i>
                        @if($filters['class_name'] || $filters['date_from'] || $filters['date_to'])
                            <h2>Kelas tidak ditemukan</h2>
                            <p>Tidak ada kelas yang sesuai dengan filter pencarian Anda.</p>
                        @else
                            <h2>Belum ada kelas terdaftar</h2>
                            <p>Kelas yang Anda order akan muncul di sini ketika pembayaran berhasil.</p>
                        @endif
                    </div>
                @endforelse
            </div>

            @if($classes->hasPages())
                <div class="certificate-pagination">
                    {{ $classes->withQueryString()->links() }}
                </div>
            @endif
        </section>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (!window.jQuery || !window.jQuery.fn || !window.jQuery.fn.select2) {
            return;
        }

        window.jQuery('.certificate-card__select').select2({
            width: '100%',
            minimumResultsForSearch: 0,
            language: {
                noResults: function() {
                    return 'Nama peserta tidak ditemukan';
                },
                searching: function() {
                    return 'Mencari nama peserta...';
                }
            }
        });

        document.querySelectorAll('[data-certificate-form]').forEach(function(form) {
            var select = form.querySelector('.certificate-card__select');
            var submitButton = form.querySelector('[data-certificate-print-button]');

            if (!select || !submitButton) {
                return;
            }

            function syncPrintButton() {
                var selectedOption = select.options[select.selectedIndex];
                var canPrint = selectedOption && selectedOption.dataset.printable === '1';
                submitButton.disabled = !canPrint;
            }

            select.addEventListener('change', syncPrintButton);
            window.jQuery(select).on('change', syncPrintButton);
            syncPrintButton();
        });
    });
</script>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.js-certificate-zip-download').forEach(function(button) {
            button.addEventListener('click', async function(event) {
                event.preventDefault();

                if (button.dataset.downloading === 'true') {
                    return;
                }

                const originalContent = button.innerHTML;
                let downloadStarted = false;
                button.dataset.downloading = 'true';
                button.setAttribute('aria-disabled', 'true');
                button.setAttribute('aria-busy', 'true');
                button.innerHTML = '<i class="fas fa-spinner fa-spin" aria-hidden="true"></i> Menyiapkan ZIP...';

                if (window.Swal && typeof window.Swal.fire === 'function') {
                    window.Swal.fire({
                        title: 'Menyiapkan unduhan',
                        text: 'Sertifikat sedang dikemas ke dalam file ZIP.',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: function() {
                            window.Swal.showLoading();
                        }
                    });
                }

                try {
                    const response = await fetch(button.href, {
                        credentials: 'same-origin',
                        headers: {
                            Accept: 'application/zip'
                        }
                    });

                    if (!response.ok) {
                        throw new Error('ZIP gagal dibuat.');
                    }

                    const blob = await response.blob();
                    const downloadUrl = URL.createObjectURL(blob);
                    const contentDisposition = response.headers.get('Content-Disposition') || '';
                    const filenameMatch = contentDisposition.match(/filename="?([^";]+)"?/i);
                    const filename = filenameMatch ? filenameMatch[1] : 'Sertifikat.zip';
                    const downloadLink = document.createElement('a');

                    downloadLink.href = downloadUrl;
                    downloadLink.download = filename;
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    downloadLink.remove();
                    URL.revokeObjectURL(downloadUrl);
                    downloadStarted = true;

                    button.classList.remove('certificate-card__button--secondary');
                    button.classList.add('certificate-card__button--success');
                    button.innerHTML = '<i class="fas fa-check-circle" aria-hidden="true"></i> Unduh berhasil';

                    if (window.Swal && typeof window.Swal.fire === 'function') {
                        window.Swal.close();
                        window.Swal.fire({
                            icon: 'success',
                            title: 'Unduh berhasil',
                            text: 'File ZIP sertifikat sudah mulai diunduh.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3500,
                            timerProgressBar: true
                        });
                    }
                } catch (error) {
                    if (window.Swal && typeof window.Swal.fire === 'function') {
                        window.Swal.close();
                        window.Swal.fire({
                            icon: 'error',
                            title: 'Unduh gagal',
                            text: 'File ZIP belum berhasil dibuat. Silakan coba lagi.',
                            confirmButtonText: 'Mengerti',
                            confirmButtonColor: '#4F46E5'
                        });
                    }
                } finally {
                    button.removeAttribute('aria-disabled');
                    button.removeAttribute('aria-busy');
                    button.dataset.downloading = 'false';

                    window.setTimeout(function() {
                        if (!downloadStarted) {
                            button.innerHTML = originalContent;
                            return;
                        }

                        button.classList.remove('certificate-card__button--success');
                        button.classList.add('certificate-card__button--secondary');
                        button.innerHTML = originalContent;
                    }, downloadStarted ? 3500 : 0);
                }
            });
        });
    });
</script>
@endpush
