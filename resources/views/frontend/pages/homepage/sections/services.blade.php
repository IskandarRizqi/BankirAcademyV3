<section class="section" id="layanan">
    <div class="container">
        @include('frontend.components.section-head', [
            'eyebrow' => 'Layanan Terintegrasi',
            'title' => 'Solusi yang Tumbuh Bersama Kebutuhan Organisasi',
            'description' => 'Setiap layanan dapat digunakan secara mandiri atau digabungkan menjadi program pengembangan yang lebih menyeluruh, dengan ruang lingkup, metode, dan indikator keberhasilan yang disepakati bersama.',
        ])

        <div class="cards-3">
            @include('frontend.components.service-card', [
                'id' => 'banking-solution',
                'icon' => '▦',
                'tag' => 'Institutional Solution',
                'title' => 'Banking Solution',
                'url' => route('frontend.service.banking-solution'),
                'description' => 'Solusi konsultatif dan pendampingan terapan untuk membantu institusi memperkuat proses bisnis, tata kelola, layanan, dan transformasi operasional.',
                'items' => ['Pemetaan kebutuhan dan permasalahan', 'Penyusunan panduan dan perangkat kerja', 'Pendampingan implementasi bertahap'],
            ])
            @include('frontend.components.service-card', [
                'id' => 'capacity-building',
                'icon' => '↗',
                'tag' => 'People Development',
                'title' => 'Capacity Building',
                'url' => route('frontend.service.capacity-building'),
                'description' => 'Program pengembangan kompetensi untuk calon bankir, pegawai, pimpinan, dan tim melalui pembelajaran yang disesuaikan dengan kebutuhan organisasi.',
                'items' => ['Kelas publik dan in-house training', 'Workshop, coaching, dan blended learning', 'Evaluasi pembelajaran yang proporsional'],
            ])
            @include('frontend.components.service-card', [
                'id' => 'banking-talent',
                'icon' => '◇',
                'tag' => 'Talent Development',
                'title' => 'Banking Talent Solution',
                'url' => route('frontend.service.banking-talent'),
                'description' => 'Solusi pemetaan dan pengembangan talenta melalui competency mapping, learning path, persiapan karier, dan penguatan kompetensi jabatan.',
                'items' => ['Competency mapping dan gap analysis', 'Individual development plan', 'Talent pool dan kesiapan karier'],
            ])
        </div>
    </div>
</section>
