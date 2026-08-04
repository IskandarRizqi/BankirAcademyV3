@php
    $secondaryLabel = $secondaryLabel ?? null;
    $secondaryUrl = $secondaryUrl ?? null;
@endphp

<section class="final-cta">
    <div class="container">
        <div class="cta-box">
            <div>
                <h2>{{ $title }}</h2>
                <p>{{ $description }}</p>
            </div>
            <div class="cta-actions">
                <a class="btn btn-light" href="{{ $primaryUrl }}">{{ $primaryLabel }}</a>
                @if ($secondaryLabel && $secondaryUrl)
                    <a class="btn btn-secondary" href="{{ $secondaryUrl }}">{{ $secondaryLabel }}</a>
                @endif
            </div>
        </div>
    </div>
</section>
