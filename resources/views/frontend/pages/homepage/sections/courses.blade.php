<section class="section section-soft" id="kelas-online">
    <div class="container">
        @include('frontend.components.section-head', [
            'eyebrow' => 'Kelas Online Pilihan',
            'title' => 'Mulai Belajar dari Kelas yang Paling Relevan',
            'description' =>
                'Pilihan kelas terbaik yang dirancang untuk meningkatkan keahlian dan karier Anda secara profesional.',
        ])

        <div class="course-grid">
            @forelse ($data['kelas'] ?? [] as $item)
                @include('frontend.components.course-card', [
                    'item' => $item,
                ])
            @empty
                <div class="col-12 text-center py-4">
                    <p class="text-muted">Belum ada kelas yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>

        <div class="course-more">
            <a class="btn btn-primary" href="{{ route('frontend.classes.index') }}">
                Lihat Kelas Selengkapnya <span class="icon-arrow">→</span>
            </a>
        </div>
    </div>
</section>
