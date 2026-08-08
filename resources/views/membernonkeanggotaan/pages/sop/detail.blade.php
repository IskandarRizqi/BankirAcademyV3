@extends('layouts.appmembernonanggota')

@section('title', $sop->judul)

@section('content')
<style>
    .sop-detail-page {
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    .sop-detail-hero {
        position: relative;
        overflow: hidden;
        border-radius: 28px;
        padding: 30px;
        background:
            radial-gradient(circle at 80% 20%, rgba(6, 182, 212, .2), transparent 28%),
            linear-gradient(135deg, #111827, #312e81 60%, #4f46e5);
        color: #ffffff;
        box-shadow: 0 20px 48px rgba(49, 46, 129, .18);
    }

    .sop-detail-hero__inner {
        position: relative;
        z-index: 1;
        max-width: 900px;
    }

    .sop-detail-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 40px;
        color: rgba(255, 255, 255, .82);
        font-size: 13px;
        font-weight: 800;
        text-decoration: none;
    }

    .sop-detail-back:hover {
        color: #ffffff;
    }

    .sop-detail-kicker {
        display: flex;
        align-items: center;
        gap: 7px;
        width: max-content;
        margin: 24px 0 14px;
        color: rgba(255, 255, 255, .7);
        font-size: 11px;
        font-weight: 900;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .sop-detail-hero h1 {
        max-width: 820px;
        margin: 0;
        font-size: clamp(30px, 4.5vw, 48px);
        font-weight: 900;
        letter-spacing: -.055em;
        line-height: 1.02;
    }

    .sop-detail-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 22px;
    }

    .sop-detail-meta span {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        min-height: 32px;
        padding: 7px 12px;
        border: 1px solid rgba(255, 255, 255, .16);
        border-radius: 999px;
        background: rgba(255, 255, 255, .1);
        color: rgba(255, 255, 255, .88);
        font-size: 12px;
        font-weight: 800;
    }

    .sop-detail-meta .sop-detail-meta--upcoming {
        border-color: rgba(239, 68, 68, .34);
        background: rgba(254, 226, 226, .96);
        color: #b91c1c;
    }

    .sop-detail-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        gap: 22px;
        align-items: start;
    }

    .sop-detail-panel {
        overflow: hidden;
        border: 1px solid #e7e9f0;
        border-radius: 22px;
        background: #ffffff;
        box-shadow: 0 12px 34px rgba(15, 23, 42, .045);
    }

    .sop-detail-panel__body {
        padding: 24px;
    }

    .sop-detail-section-kicker {
        display: inline-flex;
        margin-bottom: 10px;
        color: #4f46e5;
        font-size: 11px;
        font-weight: 900;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .sop-detail-section-title {
        margin: 0 0 14px;
        color: #111827;
        font-size: 24px;
        font-weight: 900;
        letter-spacing: -.045em;
        line-height: 1.12;
    }

    .sop-detail-description {
        color: #374151;
        font-size: 15px;
        line-height: 1.85;
        white-space: normal;
        overflow-wrap: anywhere;
    }

    .sop-detail-description p:last-child {
        margin-bottom: 0;
    }

    .sop-documents {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 10px;
    }

    .sop-document-link {
        display: flex;
        min-height: 100%;
        align-items: flex-start;
        flex-direction: column;
        justify-content: space-between;
        gap: 12px;
        padding: 14px;
        border: 1px solid #eef2f7;
        border-radius: 14px;
        color: #111827;
        text-decoration: none;
    }

    .sop-document-link:hover {
        border-color: rgba(79, 70, 229, .3);
        color: #4f46e5;
    }

    .sop-document-link__name {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
        font-size: 13px;
        font-weight: 850;
        overflow-wrap: anywhere;
    }

    .sop-document-link__name i {
        flex: 0 0 auto;
        color: #4f46e5;
        font-size: 18px;
    }

    .sop-detail-note {
        padding: 14px;
        border: 1px solid #fde68a;
        border-radius: 14px;
        background: #fffbeb;
        color: #92400e;
        font-size: 13px;
        line-height: 1.6;
    }

    .sop-detail-empty {
        color: #6b7280;
        font-size: 14px;
        line-height: 1.7;
    }

    @media (max-width: 1199.98px) {
        .sop-documents {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 991.98px) {
        .sop-documents {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .sop-detail-hero {
            padding: 22px;
            border-radius: 22px;
        }

        .sop-detail-panel__body {
            padding: 18px;
        }

        .sop-documents {
            grid-template-columns: 1fr;
        }
    }
</style>

@php
    $isUpcoming = $sop->status === \App\Models\SopModel::STATUS_UPCOMING;
@endphp

<div class="sop-detail-page">
    <section class="sop-detail-hero" aria-labelledby="sop-detail-title">
        <div class="sop-detail-hero__inner">
            <a href="{{ route('membernonanggota.sop.index') }}" class="sop-detail-back">
                <i class="fas fa-arrow-left" aria-hidden="true"></i> Kembali ke daftar SOP
            </a>
            <span class="sop-detail-kicker"><i class="fas fa-file-alt" aria-hidden="true"></i> Detail SOP</span>
            <h1 id="sop-detail-title">{{ $sop->judul }}</h1>
            <div class="sop-detail-meta" aria-label="Informasi SOP">
                @if($isUpcoming)
                    <span class="sop-detail-meta--upcoming"><i class="fas fa-hourglass-half" aria-hidden="true"></i> Upcoming</span>
                @endif
                <span><i class="fas fa-clock" aria-hidden="true"></i> Diperbarui {{ $sop->updated_at?->format('d M Y, H:i') ?: '-' }}</span>
            </div>
        </div>
    </section>

    <div class="sop-detail-layout">
        <main class="sop-detail-panel col-lg-12">
            <div class="sop-detail-panel__body">
                <span class="sop-detail-section-kicker">Informasi lengkap</span>
                <h2 class="sop-detail-section-title">Deskripsi SOP</h2>
                <div class="sop-detail-description">
                    @if(filled($sop->deskripsi))
                        {!! nl2br(e($sop->deskripsi)) !!}
                    @else
                        <p class="sop-detail-empty">Deskripsi SOP belum tersedia.</p>
                    @endif
                </div>
            </div>
        </main>

        <aside class="sop-detail-panel col-lg-12">
            <div class="sop-detail-panel__body">
                <span class="sop-detail-section-kicker">Dokumen</span>
                <h2 class="sop-detail-section-title">File SOP</h2>

                @if($isUpcoming)
                    <div class="sop-detail-note">
                        Dokumen SOP belum tersedia karena statusnya masih upcoming. Anda tetap dapat membaca detail SOP ini.
                    </div>
                @elseif($sop->dokumenFiles->isNotEmpty())
                    <div class="sop-documents">
                        @foreach($sop->dokumenFiles as $document)
                            @php
                                $isGoogleDrive = filled($document->link_google_drive);
                                $documentUrl = $isGoogleDrive
                                    ? $document->link_google_drive
                                    : route('membernonanggota.sop.documents.download', $document->id);
                            @endphp
                            <a
                                href="{{ $documentUrl }}"
                                class="sop-document-link"
                                @if($isGoogleDrive) target="_blank" rel="noopener noreferrer" @endif>
                                <span class="sop-document-link__name">
                                    <i class="{{ $isGoogleDrive ? 'fab fa-google-drive' : 'fas fa-download' }}" aria-hidden="true"></i>
                                    {{ $document->nama_file ?: 'Dokumen SOP' }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="sop-detail-empty mb-0">Belum ada file yang tersedia untuk SOP ini.</p>
                @endif
            </div>
        </aside>
    </div>

</div>
@endsection
