@php
    $id = $id ?? null;
    $items = $items ?? [];
@endphp

<article @if ($id) id="{{ $id }}" @endif class="service-card">
    <div class="card-icon">{{ $icon }}</div>
    <span class="tag tag-spaced">{{ $tag }}</span>
    <h3><a href="{{ $url }}">{{ $title }}</a></h3>
    <p>{{ $description }}</p>
    @if ($items)
        <ul class="card-list">
            @foreach ($items as $item)
                <li>{{ $item }}</li>
            @endforeach
        </ul>
    @endif
    <a class="text-link" href="{{ $url }}">Lihat selengkapnya →</a>
</article>
