@foreach($sops as $sop)
    @php
        $isUpcoming = $sop->status === \App\Models\SopModel::STATUS_UPCOMING;
        $hasBanner = filled($sop->banner)
            && \Illuminate\Support\Facades\Storage::disk('public')->exists($sop->banner);
        $bannerUrl = '/storage/' . ltrim(str_replace('\\', '/', (string) $sop->banner), '/');
    @endphp
    <article class="sop-card {{ $isUpcoming ? 'sop-card--upcoming' : '' }}">
        <div class="sop-card__media" aria-hidden="true">
            @if ($hasBanner)
                <img src="{{ $bannerUrl }}" alt="" class="sop-card__banner">
            @else
                <span class="sop-card__media-icon">
                    <img src="{{ asset('bankir-academy-icon.png') }}" alt="">
                </span>
            @endif
            @if($isUpcoming)
                <span class="sop-card__upcoming-badge">Upcoming</span>
            @endif
        </div>

        <div class="sop-card__body">
            <h3 class="sop-card__title">{{ $sop->judul }}</h3>
            <p class="sop-card__description">
                {{ \Illuminate\Support\Str::limit($sop->deskripsi ?: 'Deskripsi SOP belum tersedia.', 120) }}
            </p>

            <div class="sop-card__footer">
                <a href="{{ route('membernonanggota.sop.show', $sop->id) }}" class="sop-card__button">
                    Detail <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </article>
@endforeach
