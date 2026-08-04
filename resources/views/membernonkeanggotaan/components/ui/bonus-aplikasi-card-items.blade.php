@foreach($bonusAplikasi as $bonus)
    @php
        $isUpcoming = $bonus->status === \App\Models\BonusAplikasiModel::STATUS_UPCOMING;
        $isFile = $bonus->tipe_sumber === \App\Models\BonusAplikasiModel::SOURCE_FILE;
        $accessUrl = route('membernonanggota.bonus-aplikasi.access', $bonus->id);
    @endphp
    <article class="bonus-card {{ $isUpcoming ? 'bonus-card--upcoming' : '' }}">
        <div class="bonus-card__media">
            @if(filled($bonus->thumbnail_path))
                <img src="{{ asset($bonus->thumbnail_path) }}" alt="Thumbnail {{ $bonus->nama }}">
            @else
                <span class="bonus-card__placeholder" aria-hidden="true">
                    <i class="fas fa-tools"></i>
                </span>
            @endif

            @if($isUpcoming)
                <span class="bonus-card__upcoming-badge">Upcoming</span>
            @endif
        </div>

        <div class="bonus-card__body">
            <h3 class="bonus-card__title">{{ $bonus->nama }}</h3>
            <p class="bonus-card__description">
                {{ \Illuminate\Support\Str::limit($bonus->deskripsi ?: 'Deskripsi bonus aplikasi belum tersedia.', 120) }}
            </p>

            <div class="bonus-card__footer">
                @if($isUpcoming)
                    <span class="bonus-card__button bonus-card__button--disabled" aria-disabled="true">
                        Segera tersedia
                    </span>
                @else
                    <a
                        href="{{ $accessUrl }}"
                        class="bonus-card__button"
                        @if(! $isFile) target="_blank" rel="noopener noreferrer" @endif>
                        <i class="fas {{ $isFile ? 'fa-download' : 'fa-external-link-alt' }}" aria-hidden="true"></i>
                        Unduh aplikasi
                    </a>
                @endif
            </div>
        </div>
    </article>
@endforeach
