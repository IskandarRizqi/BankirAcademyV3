@extends('front.home.laman')
@section('seohead')
@endsection
@section('contents')
<section id="page-title" class="page-title-parallax page-title-dark include-header"
    style="padding: 250px 0; background-image: url( {{json_decode($data->banner)?'/Image/laman/banner/'.json_decode($data->banner)->url:'images/about/parallax.jpg'}}); background-size: cover; background-position: center center;"
    data-bottom-top="background-position:0px 400px;" data-top-bottom="background-position:0px -500px;">
    <div class="container clearfix">
        <h1>{{$data->title}}</h1>
        {{-- <span>Everything you need to know about our Company</span> --}}
    </div>
</section>
{{-- {{$data}} --}}
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
@endsection