<section class="section job-openings" id="lowongan">
    <div class="container">
        @include('frontend.components.section-head', [
            'eyebrow' => 'Peluang Karier',
            'title' => 'Temukan Langkah Karier Berikutnya',
            'description' =>
                'Lihat lowongan terbaru dari perusahaan mitra dan temukan peluang yang sesuai dengan kompetensi Anda.',
        ])

        <div class="job-grid">
            @forelse ($data['loker'] ?? [] as $loker)
                @php
                    $types = is_array($loker->type) ? $loker->type : json_decode($loker->type ?? '', true);
                    $types = is_array($types) ? $types : (filled($loker->type) ? [$loker->type] : []);
                    $company = $loker->nama ?: ($loker->perusahaan?->nama ?: ($loker->name ?: 'Perusahaan mitra'));
                    $image = is_array($loker->image) ? $loker->image : json_decode($loker->image ?? '', true);
                    $imagePath = is_array($image) ? $image['url'] ?? null : null;
                    $imageUrl = filled($imagePath)
                        ? (\Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://', '/'])
                            ? $imagePath
                            : asset('image/loker/' . ltrim($imagePath, '/')))
                        : null;
                    $location = filled($loker->kabupaten_name) ? $loker->kabupaten_name : 'Lokasi fleksibel';
                    $salary = filled($loker->gaji_min)
                        ? 'Rp ' . number_format($loker->gaji_min, 0, ',', '.')
                        : 'Kompensasi dibahas';
                    if (filled($loker->gaji_min) && filled($loker->gaji_max) && $loker->gaji_max > $loker->gaji_min) {
                        $salary .= ' - ' . number_format($loker->gaji_max, 0, ',', '.');
                    }
                    $companyInitial = \Illuminate\Support\Str::upper(
                        \Illuminate\Support\Str::substr(trim($company), 0, 1),
                    );
                    $startDate = data_get($loker, 'tanggal_mulai') ?: data_get($loker, 'tanggal_awal');
                    $posted = $startDate
                        ? 'Diposting ' . \Carbon\Carbon::parse($startDate)->locale('id')->diffForHumans()
                        : 'Tanggal menyusul';
                @endphp

                <article class="job-card">
                    <div class="job-card-top">
                        <span class="job-posted"><span class="job-live-dot"></span>{{ $posted }}</span>
                    </div>

                    <div class="job-card-body">
                        <div class="job-company-row">
                            <div class="job-company-mark">
                                @if ($imageUrl)
                                    <img src="{{ $imageUrl }}" alt="Logo {{ $company }}"
                                        onerror="this.onerror=null; this.hidden=true; this.nextElementSibling.hidden=false;">
                                @endif
                                <span
                                    class="job-fallback-icon"{{ $imageUrl ? ' hidden' : '' }}>{{ $companyInitial }}</span>
                            </div>
                            <div>
                                <p class="job-company-label">Perusahaan mitra</p>
                                <p class="job-company">{{ $company }}</p>
                            </div>
                        </div>
                        <h3 class="job-title">{{ $loker->title }}</h3>

                        <div class="job-meta">
                            <span><svg aria-hidden="true" viewBox="0 0 16 16">
                                    <path d="M8 14s4-3.5 4-7a4 4 0 1 0-8 0c0 3.5 4 7 4 7Z" />
                                    <circle cx="8" cy="7" r="1.4" />
                                </svg>{{ $location }}</span>
                            @foreach (array_slice($types, 0, 2) as $type)
                                <span><svg aria-hidden="true" viewBox="0 0 16 16">
                                        <path d="M8 2v6l3.5 2" />
                                        <circle cx="8" cy="8" r="5.5" />
                                    </svg>{{ ucfirst($type) }}</span>
                            @endforeach
                        </div>

                        <div class="job-salary">
                            <span>Mulai dari</span>
                            <strong>{{ $salary }}</strong>
                        </div>
                    </div>

                    <a class="job-detail-link" href="{{ route('membernonanggota.loker.show', $loker->id) }}">
                        <span>Lihat detail</span>
                        <span class="job-link-arrow" aria-hidden="true">↗</span>
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
