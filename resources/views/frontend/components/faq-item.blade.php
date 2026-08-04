@php($open = $open ?? false)

<article class="faq-item{{ $open ? ' open' : '' }}">
    <button class="faq-q" type="button">
        {{ $question }}
        <span class="faq-plus">＋</span>
    </button>
    <div class="faq-a">{{ $answer }}</div>
</article>
