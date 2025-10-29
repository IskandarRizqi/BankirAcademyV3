@include('front.layout.head')
<!-- HTML Meta Tags -->
@if ($data)
@if ($data->og)
<meta name="description" content="
{{json_decode($data->og)->description}}">

<!-- Facebook Meta Tags -->
<meta property="og:url" content="{{url()->current()}}">
<meta property="og:type" content="website">
<meta property="og:title" content="{{json_decode($data->og)->title}}">
<meta property="og:description" content="{{json_decode($data->og)->description}}">
<meta property="og:image" content="{{asset('/Image/laman/meta_image/'.json_decode($data->og)->image)}}">

<!-- Twitter Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta property="twitter:domain" content="{{env('APP_URL','localhost')}}">
<meta property="twitter:url" content="{{url()->current()}}">
<meta name="twitter:title" content="{{json_decode($data->og)->title}}">
<meta name="twitter:description" content="{{json_decode($data->og)->description}}">
<meta name="twitter:image" content="{{asset('/Image/laman/meta_image/'.json_decode($data->og)->image)}}">
@endif

@if (is_object(json_decode($data->meta)))
@foreach (json_decode($data->meta)->name as $k=>$x)
<meta name="{{$x}}" content="{{json_decode($data->meta)->content[$k]}}">
@endforeach
@endif
@include('front.layout.topbar')
@include(env('CUSTOM_HEADER', 'front.layout.header'))

<section
    style="padding: 250px 0; background-image: url('{{asset(json_decode($data->banner)?'/image/laman/banner/'.json_decode($data->banner)->url:'526x417-05.png')}}'); background-size: contain; background-position: center; background-repeat:no-repeat;">
    <div class="container clearfix">
        <h1 class=" text-white">{{$data->title}}</h1>
        {{-- <span>Everything you need to know about our Company</span> --}}
    </div>
</section>
<style>
    p {
        margin: 0px;
    }
</style>
<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">
            {!!$data->content!!}
            {{-- <div class="row col-mb-50 mb-0">
                <div class="col-lg-4">
                    <div class="heading-block fancy-title border-bottom-0 title-bottom-border">
                        <h4>Why choose <span>Us</span>.</h4>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi quidem minus id omnis, nam
                        expedita, ea fuga commodi voluptas iusto, hic autem deleniti dolores explicabo labore enim
                        repellat earum perspiciatis.</p>
                </div>
                <div class="col-lg-4">
                    <div class="heading-block fancy-title border-bottom-0 title-bottom-border">
                        <h4>Our <span>Mission</span>.</h4>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi quidem minus id omnis, nam
                        expedita, ea fuga commodi voluptas iusto, hic autem deleniti dolores explicabo labore enim
                        repellat earum perspiciatis.</p>
                </div>
                <div class="col-lg-4">
                    <div class="heading-block fancy-title border-bottom-0 title-bottom-border">
                        <h4>What we <span>Do</span>.</h4>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi quidem minus id omnis, nam
                        expedita, ea fuga commodi voluptas iusto, hic autem deleniti dolores explicabo labore enim
                        repellat earum perspiciatis.</p>
                </div>
            </div> --}}
        </div>
    </div>
</section>
@endif
@include(env('CUSTOM_FOOTER', 'front.layout.footer'))