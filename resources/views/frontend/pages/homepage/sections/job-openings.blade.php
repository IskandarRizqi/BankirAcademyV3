<section class="section job-openings" id="lowongan">
    <div class="container">
        @include('frontend.components.section-head', [
            'eyebrow' => 'Peluang Karier',
            'title' => 'Temukan Langkah Karier Berikutnya',
            'description' => 'Lihat lowongan terbaru dari perusahaan mitra dan temukan peluang yang sesuai dengan kompetensi Anda.',
        ])

        <div class="job-grid">
            @forelse ($data['loker'] ?? [] as $loker)
                @php
                    $types = is_array($loker->type) ? $loker->type : json_decode($loker->type ?? '', true);
                    $types = is_array($types) ? $types : (filled($loker->type) ? [$loker->type] : []);
                    $company = $loker->nama ?: ($loker->perusahaan?->nama ?: ($loker->name ?: 'Perusahaan mitra'));
                    $image = is_array($loker->image) ? $loker->image : json_decode($loker->image ?? '', true);
                    $imageUrl = is_array($image) && filled($image['url'] ?? null)
                        ? asset('image/loker/' . $image['url'])
                        : null;
                @endphp

                <article class="job-card">
                    <div class="job-card-top">
                        <div class="job-company-mark">
                            {{-- @if ($imageUrl)
                                <img src="{{ $imageUrl }}" alt="Logo {{ $company }}"
                                    onerror="this.onerror=null; this.hidden=true; this.nextElementSibling.hidden=false;">
                            @endif --}}
                            <span class="job-fallback-icon" aria-hidden="true"{{ $imageUrl ? ' hidden' : '' }}>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 8.5h16v10H4v-10Z" stroke="currentColor" stroke-width="1.8"
                                        stroke-linejoin="round" />
                                    <path d="M8 8.5V6h8v2.5M9 13h6" stroke="currentColor" stroke-width="1.8"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </div>
                        <span class="job-posted">Terbaru</span>
                    </div>

                    <div class="job-card-body">
                        <p class="job-company">{{ $company }}</p>
                        <h3 class="job-title">{{ $loker->title }}</h3>

                        <div class="job-meta">
                            <span><span aria-hidden="true">⌖</span>{{ $loker->kabupaten_name ?: 'Lokasi fleksibel' }}</span>
                            @foreach (array_slice($types, 0, 2) as $type)
                                <span><span aria-hidden="true">◷</span>{{ ucfirst($type) }}</span>
                            @endforeach
                        </div>
                    </div>

                    <a class="job-detail-link" href="{{ route('membernonanggota.loker.show', $loker->id) }}">
                        Lihat detail lowongan
                        <span aria-hidden="true">→</span>
                    </a>
                </article>
            @empty
                <div class="job-empty">
                    <p>Belum ada lowongan terbaru yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>

        <div class="job-more">
            <a class="btn btn-outline" href="/member/loker">Lihat Semua Lowongan <span class="icon-arrow">→</span></a>
        </div>
    </div>
</section>
