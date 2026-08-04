@props(['item'])

@php
    // Menyiapkan gambar cover
    $coverImage = !empty($item->image)
        ? asset($item->image) // Sesuaikan path folder penyimpanan gambar Anda
        : asset('images/default-course.jpg');

    // Menyiapkan meta tag dinamis
    $meta = array_filter([$item->level ?? null, $item->tipe ?? null, $item->kategori ?? null]);

    // AMAN: Mendapatkan final_price baik bentuknya Array maupun Object
    $resolved = $item->pricing->resolved ?? null;
    $finalPrice = 0;

    if ($resolved) {
        if (is_array($resolved)) {
            $finalPrice = $resolved['final_price'] ?? 0;
        } elseif (is_object($resolved)) {
            $finalPrice = $resolved->final_price ?? 0;
        }
    }

    $priceText = $finalPrice > 0 ? 'Rp ' . number_format($finalPrice, 0, ',', '.') : 'Gratis';
@endphp

<article class="course-card">
    <div class="course-cover"
        style="background-image: url('{{ $coverImage }}'); background-size: cover;  background-position: center;">
    </div>

    <div class="course-body">
        <h3>{{ $item->title }}</h3>

        <div class="course-meta">

            <span>{{ $item->category }}</span>

        </div>


        <p>{{ $item->contents ?? 'Tidak ada deskripsi singkat.' }}</p>

        <div class="course-actions">
            <span class="course-status">{{ $priceText }}</span>
            <a class="text-link" href="{{ route('frontend.class.detail', $item->id) }}">
                Lihat detail →
            </a>
        </div>
    </div>
</article>
