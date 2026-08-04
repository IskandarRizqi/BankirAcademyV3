@php
    $description = $description ?? null;
    $align = $align ?? null;
@endphp

<div class="section-head{{ $align ? ' '.$align : '' }}">
    <span class="eyebrow">{{ $eyebrow }}</span>
    <h2>{!! $title !!}</h2>
    @if ($description)
        <p>{!! $description !!}</p>
    @endif
</div>
