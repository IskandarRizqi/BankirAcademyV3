@if (($data['news'] ?? collect())->isNotEmpty())
    <section class="section homepage-news" id="berita">
        <div class="container">
            @include('frontend.components.section-head', [
                'eyebrow' => 'Berita Terkini',
                'title' => 'Kabar Terbaru dari Bankir Academy',
                'description' => 'Ikuti kabar, program, dan informasi terbaru untuk ekosistem perbankan Indonesia.',
            ])

            <div class="homepage-news-slider" data-home-news-slider tabindex="0" aria-label="Berita terbaru">
                <div class="homepage-news-track">
                    @foreach ($data['news'] as $index => $item)
                        @php($image = $item->bannerImages->first())
                        <article class="homepage-news-slide" aria-hidden="{{ $index === 0 ? 'false' : 'true' }}">
                            <div class="homepage-news-slide__media">
                                @if ($image)
                                    <img src="{{ $image->url }}" alt="{{ $item->title }}" loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
                                @else
                                    <div class="homepage-news-slide__fallback" aria-hidden="true">
                                        <i class="far fa-newspaper"></i>
                                    </div>
                                @endif
                                <span class="homepage-news-slide__badge">Berita</span>
                            </div>
                            <div class="homepage-news-slide__body">
                                <time datetime="{{ optional($item->published_at ?? $item->created_at)->toDateString() }}">
                                    {{ optional($item->published_at ?? $item->created_at)->translatedFormat('d F Y') }}
                                </time>
                                <h3>{{ $item->title }}</h3>
                                <p>{{ $item->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($item->content), 180) }}</p>
                                <a class="btn btn-primary" href="{{ route('frontend.news.show', $item->slug) }}">
                                    Baca Berita <span class="icon-arrow" aria-hidden="true">→</span>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if ($data['news']->count() > 1)
                    <button class="homepage-news-control homepage-news-control--prev" type="button" data-home-news-prev aria-label="Berita sebelumnya">
                        <i class="fas fa-arrow-left" aria-hidden="true"></i>
                    </button>
                    <button class="homepage-news-control homepage-news-control--next" type="button" data-home-news-next aria-label="Berita berikutnya">
                        <i class="fas fa-arrow-right" aria-hidden="true"></i>
                    </button>
                    <div class="homepage-news-dots" role="tablist" aria-label="Pilih berita">
                        @foreach ($data['news'] as $index => $item)
                            <button class="homepage-news-dot{{ $index === 0 ? ' is-active' : '' }}" type="button" data-home-news-dot="{{ $index }}" role="tab" aria-label="Tampilkan berita {{ $index + 1 }}" aria-selected="{{ $index === 0 ? 'true' : 'false' }}"></button>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="homepage-news-more">
                <a class="btn btn-outline" href="{{ route('frontend.news.index') }}">
                    Lihat Semua Berita <span class="icon-arrow" aria-hidden="true">→</span>
                </a>
            </div>
        </div>
    </section>

    @push('frontend-scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var slider = document.querySelector('[data-home-news-slider]');
                if (!slider) return;

                var track = slider.querySelector('.homepage-news-track');
                var slides = Array.from(slider.querySelectorAll('.homepage-news-slide'));
                var dots = Array.from(slider.querySelectorAll('[data-home-news-dot]'));
                var current = 0;
                var timer;

                if (slides.length < 2) return;

                function showSlide(index) {
                    current = (index + slides.length) % slides.length;
                    track.style.transform = 'translateX(-' + (current * 100) + '%)';
                    slides.forEach(function(slide, slideIndex) {
                        slide.setAttribute('aria-hidden', slideIndex === current ? 'false' : 'true');
                    });
                    dots.forEach(function(dot, dotIndex) {
                        var active = dotIndex === current;
                        dot.classList.toggle('is-active', active);
                        dot.setAttribute('aria-selected', active ? 'true' : 'false');
                    });
                }

                function startAutoPlay() {
                    clearInterval(timer);
                    timer = setInterval(function() { showSlide(current + 1); }, 6000);
                }

                slider.querySelector('[data-home-news-prev]').addEventListener('click', function() {
                    showSlide(current - 1);
                    startAutoPlay();
                });
                slider.querySelector('[data-home-news-next]').addEventListener('click', function() {
                    showSlide(current + 1);
                    startAutoPlay();
                });
                dots.forEach(function(dot, dotIndex) {
                    dot.addEventListener('click', function() {
                        showSlide(dotIndex);
                        startAutoPlay();
                    });
                });
                slider.addEventListener('mouseenter', function() { clearInterval(timer); });
                slider.addEventListener('mouseleave', startAutoPlay);
                slider.addEventListener('focusin', function() { clearInterval(timer); });
                slider.addEventListener('focusout', function(event) {
                    if (!slider.contains(event.relatedTarget)) startAutoPlay();
                });
                slider.addEventListener('keydown', function(event) {
                    if (event.key === 'ArrowLeft') showSlide(current - 1);
                    if (event.key === 'ArrowRight') showSlide(current + 1);
                });
                startAutoPlay();
            });
        </script>
    @endpush
@endif
