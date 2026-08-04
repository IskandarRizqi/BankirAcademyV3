<div class="faq-wrap">
    @foreach ($items as $item)
        @include('frontend.components.faq-item', $item)
    @endforeach
</div>
