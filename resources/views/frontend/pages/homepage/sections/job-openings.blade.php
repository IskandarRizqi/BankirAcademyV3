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
                @include('membernonkeanggotaan.components.ui.loker-card', ['loker' => $loker])
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
