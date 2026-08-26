@extends('layouts.appmembernonanggota')

@section('title', 'Kelola Lowongan')

@section('content')
@php
    $logo = data_get(json_decode((string) ($company->image ?? ''), true), 'url');
    $logoUrl = filled($logo)
        ? (\Illuminate\Support\Str::startsWith($logo, ['http://', 'https://', '/']) ? $logo : asset('image/loker/' . basename($logo)))
        : null;
    $filters = $filters ?? [
        'q' => '',
        'periode_dari' => null,
        'periode_sampai' => null,
        'status' => '',
    ];
@endphp

<style>
    .posting-page {
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    .posting-hero {
        position: relative;
        overflow: hidden;
        border-radius: 24px;
        padding: 28px;
        background:
            radial-gradient(circle at 82% 18%, rgba(6, 182, 212, .26), transparent 30%),
            linear-gradient(135deg, #111827 0%, #312e81 52%, #4f46e5 100%);
        color: #ffffff;
        box-shadow: 0 20px 48px rgba(49, 46, 129, .18);
    }

    .posting-hero__content {
        position: relative;
        z-index: 1;
        max-width: 760px;
    }

    .posting-hero__eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
        padding: 7px 12px;
        border: 1px solid rgba(255, 255, 255, .18);
        border-radius: 999px;
        background: rgba(255, 255, 255, .12);
        color: rgba(255, 255, 255, .9);
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .posting-hero__title {
        margin: 0;
        font-size: clamp(28px, 4vw, 46px);
        font-weight: 900;
        letter-spacing: -.05em;
        line-height: 1.05;
    }

    .posting-hero__description {
        max-width: 620px;
        margin: 14px 0 0;
        color: rgba(255, 255, 255, .82);
        font-size: 15px;
        line-height: 1.7;
    }

    .posting-panel {
        border: 1px solid #e7e9f0;
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 12px 34px rgba(15, 23, 42, .045);
    }

    .posting-panel__body {
        padding: 24px;
    }

    .posting-company-summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 22px;
        padding: 16px;
        border: 1px solid #e0e7ff;
        border-radius: 14px;
        background: #f8faff;
    }

    .posting-company-summary__identity {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .posting-company-summary__logo {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 52px;
        height: 52px;
        flex: 0 0 auto;
        overflow: hidden;
        border-radius: 12px;
        background: #ffffff;
    }

    .posting-company-summary__logo img {
        width: 100%;
        height: 100%;
        padding: 5px;
        object-fit: contain;
    }

    .posting-company-summary h2 {
        margin: 0;
        color: #111827;
        font-size: 16px;
        font-weight: 900;
    }

    .posting-company-summary p {
        margin: 3px 0 0;
        color: #6b7280;
        font-size: 12px;
    }

    .posting-heading {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 18px;
    }

    .posting-heading h2 {
        margin: 0;
        color: #111827;
        font-size: 22px;
        font-weight: 900;
        letter-spacing: -.03em;
    }

    .posting-heading p {
        margin: 4px 0 0;
        color: #6b7280;
        font-size: 13px;
    }

    .posting-filter {
        display: grid;
        grid-template-columns: minmax(180px, 2fr) repeat(2, minmax(140px, 1fr)) minmax(150px, 1fr) auto auto;
        gap: 10px;
        margin-bottom: 18px;
        padding: 12px;
        border: 1px solid #eef2f7;
        border-radius: 14px;
        background: #f8fafc;
    }

    .posting-filter__field {
        min-width: 0;
    }

    .posting-filter__label {
        display: block;
        margin-bottom: 4px;
        color: #64748b;
        font-size: 10px;
        font-weight: 900;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .posting-filter__control {
        width: 100%;
        min-height: 38px;
        padding: 7px 10px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        outline: none;
        background: #ffffff;
        color: #111827;
        font-size: 12px;
    }

    .posting-filter__control:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, .1);
    }

    .posting-filter__button,
    .posting-filter__reset {
        align-self: end;
        display: inline-flex;
        min-height: 38px;
        align-items: center;
        justify-content: center;
        padding: 7px 13px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 850;
        text-decoration: none;
        white-space: nowrap;
    }

    .posting-filter__button {
        border: 0;
        background: #4f46e5;
        color: #ffffff;
        cursor: pointer;
    }

    .posting-filter__button:hover,
    .posting-filter__button:focus-visible {
        background: #3730a3;
        color: #ffffff;
    }

    .posting-filter__reset {
        background: #ffffff;
        color: #64748b;
    }

    .posting-filter__reset:hover,
    .posting-filter__reset:focus-visible {
        background: #e5e7eb;
        color: #1f2937;
    }

    .posting-button {
        display: inline-flex;
        min-height: 40px;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 8px 14px;
        border: 0;
        border-radius: 9px;
        background: #4f46e5;
        color: #ffffff;
        font-size: 12px;
        font-weight: 850;
        text-decoration: none;
        white-space: nowrap;
    }

    .posting-button:hover,
    .posting-button:focus-visible {
        background: #3730a3;
        color: #ffffff;
    }

    .posting-button--secondary {
        background: #f3f4f6;
        color: #4b5563;
    }

    .posting-button--secondary:hover,
    .posting-button--secondary:focus-visible {
        background: #e5e7eb;
        color: #1f2937;
    }

    .posting-button--company-edit {
        background: #f59e0b;
        color: #ffffff;
    }

    .posting-button--company-edit:hover,
    .posting-button--company-edit:focus-visible {
        background: #d97706;
        color: #ffffff;
    }

    .posting-table-wrap {
        overflow-x: auto;
        border: 1px solid #eef2f7;
        border-radius: 14px;
    }

    .posting-table {
        width: 100%;
        min-width: 760px;
        margin: 0;
        border-collapse: collapse;
    }

    .posting-table th {
        padding: 12px 14px;
        background: #f8fafc;
        color: #64748b;
        font-size: 10px;
        font-weight: 900;
        letter-spacing: .04em;
        text-align: left;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .posting-table td {
        padding: 14px;
        border-top: 1px solid #eef2f7;
        color: #374151;
        font-size: 13px;
        vertical-align: middle;
    }

    .posting-table__title {
        display: block;
        max-width: 280px;
        color: #111827;
        font-weight: 850;
        overflow-wrap: anywhere;
    }

    .posting-table__date {
        color: #6b7280;
        font-size: 12px;
        white-space: nowrap;
    }

    .posting-status {
        display: inline-flex;
        min-height: 28px;
        align-items: center;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 850;
        white-space: nowrap;
    }

    .posting-status--pending {
        background: #fff7ed;
        color: #c2410c;
    }

    .posting-status--approved {
        background: #ecfdf5;
        color: #047857;
    }

    .posting-actions {
        display: flex;
        gap: 7px;
        white-space: nowrap;
    }

    .posting-action {
        display: inline-flex;
        width: 32px;
        height: 32px;
        align-items: center;
        justify-content: center;
        border: 0;
        border-radius: 8px;
        background: #eef0fe;
        color: #4f46e5;
        cursor: pointer;
    }

    .posting-action:hover,
    .posting-action:focus-visible {
        background: #4f46e5;
        color: #ffffff;
    }

    .posting-action--danger {
        background: #fef2f2;
        color: #dc2626;
    }

    .posting-action--danger:hover,
    .posting-action--danger:focus-visible {
        background: #dc2626;
        color: #ffffff;
    }

    .posting-empty {
        padding: 42px 22px;
        border: 1px dashed #cbd5e1;
        border-radius: 14px;
        background: #f8fafc;
        text-align: center;
    }

    .posting-empty h3 {
        margin: 10px 0 0;
        color: #111827;
        font-size: 18px;
        font-weight: 900;
    }

    .posting-empty p {
        margin: 6px auto 0;
        color: #6b7280;
        font-size: 13px;
    }

    .posting-pagination {
        display: flex;
        justify-content: center;
        width: 100%;
        margin-top: 20px;
    }

    .posting-pagination nav {
        display: flex;
        width: 100%;
        align-items: center;
        justify-content: center;
    }

    .posting-pagination nav > div:first-child,
    .posting-pagination nav > div:last-child > div:first-child {
        display: none;
    }

    .posting-pagination nav > div:last-child,
    .posting-pagination nav > div:last-child > div:last-child,
    .posting-pagination nav > div:last-child > div:last-child > span {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .posting-pagination nav > div:last-child > div:last-child > span {
        gap: 5px;
    }

    .posting-pagination nav a,
    .posting-pagination nav span[aria-disabled="true"] > span,
    .posting-pagination nav span[aria-current="page"] > span {
        display: inline-flex;
        min-width: 36px;
        height: 36px;
        align-items: center;
        justify-content: center;
        padding: 0 10px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: #ffffff;
        color: #4b5563;
        font-size: 12px;
        font-weight: 800;
        line-height: 1;
        text-decoration: none;
        transition: background-color .18s ease, border-color .18s ease, color .18s ease;
    }

    .posting-pagination nav a:hover,
    .posting-pagination nav a:focus-visible {
        border-color: #4f46e5;
        background: #eef0fe;
        color: #3730a3;
    }

    .posting-pagination nav span[aria-current="page"] > span {
        display: inline-flex;
        min-width: 36px;
        height: 36px;
        align-items: center;
        justify-content: center;
        padding: 0 10px;
        border: 0;
        background: transparent !important;
        color: #ffffff !important;
    }

    .posting-pagination nav span[aria-current="page"] {
        display: inline-flex;
        min-width: 36px;
        height: 36px;
        align-items: center;
        justify-content: center;
        border: 1px solid #4f46e5;
        border-radius: 8px;
        background: #4f46e5 !important;
        color: #ffffff !important;
        font-size: 12px;
        font-weight: 800;
    }

    .posting-pagination nav span[aria-disabled="true"] > span {
        background: #f8fafc;
        color: #cbd5e1;
        cursor: not-allowed;
    }

    .posting-pagination nav svg {
        width: 16px;
        height: 16px;
    }

    @media (max-width: 575.98px) {
        .posting-pagination {
            overflow-x: auto;
            justify-content: flex-start;
            padding-bottom: 2px;
        }

        .posting-pagination nav {
            min-width: max-content;
        }
    }

    @media (max-width: 767.98px) {
        .posting-hero {
            padding: 22px;
            border-radius: 20px;
        }

        .posting-panel__body {
            padding: 18px;
        }

        .posting-company-summary,
        .posting-heading {
            align-items: flex-start;
            flex-direction: column;
        }

        .posting-filter {
            grid-template-columns: 1fr;
        }

        .posting-filter__button,
        .posting-filter__reset {
            width: 100%;
        }

        .posting-button {
            width: 100%;
        }
    }
</style>

<div class="posting-page">
    <section class="posting-hero" aria-labelledby="posting-page-title">
        <div class="posting-hero__content">
            <span class="posting-hero__eyebrow"><i class="fas fa-briefcase" aria-hidden="true"></i> Company Career Center</span>
            <h1 class="posting-hero__title" id="posting-page-title">Kelola lowongan perusahaan</h1>
            <p class="posting-hero__description">
                Tambahkan peluang kerja untuk menjangkau kandidat yang tepat melalui Bankir Academy.
            </p>
        </div>
    </section>

    <section class="posting-panel" aria-labelledby="posting-list-title">
        <div class="posting-panel__body">
            <div class="posting-company-summary">
                <div class="posting-company-summary__identity">
                    <div class="posting-company-summary__logo">
                        @if($logo)
                            <img src="{{ $logoUrl }}" alt="Logo {{ $company->nama }}">
                        @else
                            <i class="fas fa-building text-muted" aria-hidden="true"></i>
                        @endif
                    </div>
                    <div>
                        <h2>{{ $company->nama }}</h2>
                        <p>{{ $company->email }} · {{ $company->kabupaten_name }}, {{ $company->provinsi_name }}</p>
                    </div>
                </div>
                <a href="{{ route('membernonanggota.loker.manage.company.edit') }}" class="posting-button posting-button--company-edit">
                    <i class="fas fa-edit" aria-hidden="true"></i> Edit perusahaan
                </a>
            </div>

            <div class="posting-heading">
                <div>
                    <h2 id="posting-list-title">Daftar lowongan</h2>
                    <p>Lowongan baru akan berstatus menunggu approval admin.</p>
                </div>
                <a href="{{ route('membernonanggota.loker.manage.create') }}" class="posting-button">
                    <i class="fas fa-plus" aria-hidden="true"></i> Tambah lowongan
                </a>
            </div>

            <form method="GET" action="{{ route('membernonanggota.loker.manage.index') }}" class="posting-filter" aria-label="Filter daftar lowongan">
                <div class="posting-filter__field">
                    <label class="posting-filter__label" for="posting-search">Posisi</label>
                    <input type="search" id="posting-search" name="q" class="posting-filter__control" value="{{ $filters['q'] }}" placeholder="Cari posisi...">
                </div>
                <div class="posting-filter__field">
                    <label class="posting-filter__label" for="posting-period-start">Periode mulai</label>
                    <input type="date" id="posting-period-start" name="periode_dari" class="posting-filter__control" value="{{ $filters['periode_dari'] }}">
                </div>
                <div class="posting-filter__field">
                    <label class="posting-filter__label" for="posting-period-end">Periode berakhir</label>
                    <input type="date" id="posting-period-end" name="periode_sampai" class="posting-filter__control" value="{{ $filters['periode_sampai'] }}">
                </div>
                <div class="posting-filter__field">
                    <label class="posting-filter__label" for="posting-status">Status</label>
                    <select id="posting-status" name="status" class="posting-filter__control">
                        <option value="">Semua status</option>
                        <option value="0" @selected($filters['status'] === '0')>Menunggu approve</option>
                        <option value="1" @selected($filters['status'] === '1')>Disetujui</option>
                    </select>
                </div>
                <button type="submit" class="posting-filter__button"><i class="fas fa-search" aria-hidden="true"></i> Cari</button>
                <a href="{{ route('membernonanggota.loker.manage.index') }}" class="posting-filter__reset">Reset</a>
            </form>

            @if($lokers->isNotEmpty())
                <div class="posting-table-wrap">
                    <table class="posting-table">
                        <thead>
                            <tr>
                                <th>Posisi</th>
                                <th>Periode</th>
                                <th>Gaji minimum</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lokers as $loker)
                                <tr>
                                    <td><span class="posting-table__title">{{ $loker->title }}</span></td>
                                    <td class="posting-table__date">{{ $loker->tanggal_awal }} - {{ $loker->tanggal_akhir }}</td>
                                    <td>Rp {{ number_format((float) $loker->gaji_min, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="posting-status {{ (int) $loker->status === 1 ? 'posting-status--approved' : 'posting-status--pending' }}">
                                            {{ (int) $loker->status === 1 ? 'Disetujui' : 'Menunggu approve' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="posting-actions">
                                            <a href="{{ route('membernonanggota.loker.manage.edit', $loker->id) }}" class="posting-action" title="Edit lowongan" aria-label="Edit lowongan">
                                                <i class="fas fa-edit" aria-hidden="true"></i>
                                            </a>
                                            @if((int) $loker->status === 0)
                                                <form action="{{ route('membernonanggota.loker.manage.destroy', $loker->id) }}" method="POST" class="js-delete-loker-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="posting-action posting-action--danger js-delete-loker" title="Hapus lowongan" aria-label="Hapus lowongan">
                                                        <i class="fas fa-trash-alt" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($lokers->hasPages())
                    <div class="posting-pagination">{{ $lokers->onEachSide(1)->links() }}</div>
                @endif
            @else
                <div class="posting-empty">
                    <i class="fas fa-briefcase fa-2x text-muted" aria-hidden="true"></i>
                    <h3>Belum ada lowongan</h3>
                    <p>Mulai posting lowongan pertama untuk perusahaan Anda.</p>
                </div>
            @endif
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.js-delete-loker').forEach(function (button) {
            button.addEventListener('click', function () {
                const form = button.closest('.js-delete-loker-form');
                const submit = function () {
                    form.submit();
                };

                if (window.Swal && typeof window.Swal.fire === 'function') {
                    window.Swal.fire({
                        icon: 'warning',
                        title: 'Hapus lowongan ini?',
                        text: 'Lowongan yang masih menunggu approval akan dihapus permanen.',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#dc2626'
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            submit();
                        }
                    });

                    return;
                }

                if (window.confirm('Hapus lowongan ini?')) {
                    submit();
                }
            });
        });
    });
</script>
@endpush
