@include("front.layout.head")
@include("front.layout.topbar")
@include("front.layout.header")

<!-- Content -->
@if(isset($bannerslide))
<section id="slider" class="slider-element h-auto" style="background-color: #222;">
    <div class="slider-inner">
        <div class="owl-carousel carousel-widget" data-margin="0" data-items="1" data-pagi="false" data-loop="true"
            data-animate="fadeIn" data-speed="450" data-autoplay="5000">
            @foreach($bannerslide as $key => $value)
            <a href="#"><img src="/image/{{$value->image}}" alt="Slider"></a>
            @endforeach
        </div>
    </div>
</section>
@endif
<style>
    .scroll-no-ui {
        height: 100%;
        width: 100%;
        border: 1px solid green;
        overflow: hidden;
    }

    .scroll-ui {
        width: 100%;
        height: 99%;
        border: 1px solid blue;
        overflow: auto;
        padding-right: 15px;
    }

    .slick-track {
        opacity: 1;
        width: 1356px !important;
        transform: translate3d(0px, 0px, 0px);
    }

    .card {
        border: none;
        transition: all 500ms cubic-bezier(0.19, 1, 0.22, 1);
        overflow: hidden;
        border-radius: 20px;
        min-height: 450px;
        box-shadow: 0 0 12px 0 rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 768px) {
        .card {
            min-height: 350px;
        }
    }

    @media (max-width: 420px) {
        .card {
            min-height: 300px;
        }
    }

    .card.card-has-bg {
        transition: all 500ms cubic-bezier(0.19, 1, 0.22, 1);
        background-size: 120%;
        background-repeat: no-repeat;
        background-position: center center;
    }

    .card.card-has-bg:before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: inherit;
        -webkit-filter: grayscale(1);
        -moz-filter: grayscale(100%);
        -ms-filter: grayscale(100%);
        -o-filter: grayscale(100%);
        filter: grayscale(100%);
    }

    .card.card-has-bg:hover {
        transform: scale(0.98);
        box-shadow: 0 0 5px -2px rgba(0, 0, 0, 0.3);
        background-size: 130%;
        transition: all 500ms cubic-bezier(0.19, 1, 0.22, 1);
    }

    .card.card-has-bg:hover .card-img-overlay {
        transition: all 800ms cubic-bezier(0.19, 1, 0.22, 1);
        background: #234f6d;
        background: linear-gradient(0deg, rgba(4, 69, 114, 0.5) 0%, #044572 100%);
    }

    .card .card-footer {
        background: none;
        border-top: none;
    }

    .card .card-footer .media img {
        border: solid 3px rgba(255, 255, 255, 0.3);
    }

    .card .card-meta {
        color: #26bd75;
    }

    .card .card-body {
        transition: all 500ms cubic-bezier(0.19, 1, 0.22, 1);
    }

    .card:hover {
        cursor: pointer;
        transition: all 800ms cubic-bezier(0.19, 1, 0.22, 1);
    }

    .card:hover .card-body {
        margin-top: 30px;
        transition: all 800ms cubic-bezier(0.19, 1, 0.22, 1);
    }

    .card .card-img-overlay {
        transition: all 800ms cubic-bezier(0.19, 1, 0.22, 1);
        background: #234f6d;
        background: linear-gradient(0deg, rgba(35, 79, 109, 0.3785889356) 0%, #455f71 100%);
    }
</style>
<section id="content">
    <div class="content-wrap" style="padding: 0px;">
        <div class="section border-top-0 mb-6">
            <div class="container text-center">
                <div class="heading-block center">
                    <h2>SEMUA KELAS</h2>
                </div>
                {{-- <div class="row" id="sld"> --}}
                    <div class="row" id="">
                        @foreach ($pop as $p)
                        <div class="col-lg-4 mb-4">
                            <div class="card text-white card-has-bg click-col"
                                style="background-image:url('<?= $p->image ?>');">
                                <img class="card-img d-none" src="<?= $p->image ?>">
                                <div class="card-img-overlay d-flex flex-column">
                                    <div class="card-body">
                                        <!-- <small class="card-meta mb-2">Thought Leadership</small> -->
                                        <h4 class="card-title mt-0 "><a class="text-white" herf="#">{{$p->title}}</a>
                                        </h4>
                                        <small><i class="far fa-clock"></i> {{
                                            \Carbon\Carbon::parse($p->date_start)->format('F d, Y') }} - {{
                                            \Carbon\Carbon::parse($p->date_end)->format('F d, Y') }}</small>
                                    </div>
                                    <div class="card-footer">
                                        <div class="media">
                                            <img class="mr-3 rounded-circle"
                                                src="Image/{{json_decode($p->instructor_list[0]->picture)->url}}"
                                                alt="Generic placeholder image" style="max-width:50px">
                                            <div class="media-body">
                                                <h6 class="my-0 text-white d-block"> {{$p->instructor_list[0]->name}}
                                                </h6>
                                                <small>{{$p->instructor_list[0]->title}}</small>
                                            </div>
                                        </div>
                                        @auth
                                        <a href="class/{{$p->unique_id}}/{{$p->title}}">
                                            <button class="button button-circle" width='100%'>Detail</button>
                                        </a>
                                        @else
                                        <a class="button button-circle" data-toggle="modal" data-target="#modelId"
                                            data-backdrop="static" data-keyboard="false">Detail</a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    {{--
                </div> --}}
            </div>
        </div>

        <div class="section border-top-0 mb-6">
            <div class="container text-center">
                <div class="heading-block center">
                    <h2>Kelas</h2>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-4">

                        <div id="oc-testi" class="owl-carousel testimonials-carousel carousel-widget" data-margin="20"
                            data-items-sm="1" data-items-md="1" data-items-xl="1">
                            <div class="oc-item">
                                <div class="testimonial mb-2"
                                    style="background-image: url('{{asset('front/one-page/images/portfolio/mixed/6.jpg')}}')">
                                    <div class="testi-content">
                                        <div class="testi-image">
                                            <a href="#"><img
                                                    src="{{asset('front/one-page/images/portfolio/mixed/6.jpg')}}"
                                                    alt="Customer Testimonails"></a>
                                        </div>
                                        <p>Incidunt deleniti blanditiis quas</p>
                                        <div class="testi-meta">
                                            John Doe
                                            <span>XYZ Inc.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="testimonial mb-2"
                                    style="background-image: url('{{asset('front/one-page/images/portfolio/mixed/6.jpg')}}')">
                                    <div class="testi-content">
                                        <div class="testi-image">
                                            <a href="#"><img
                                                    src="{{asset('front/one-page/images/portfolio/mixed/6.jpg')}}"
                                                    alt="Customer Testimonails"></a>
                                        </div>
                                        <p>Incidunt deleniti blanditiis quas</p>
                                        <div class="testi-meta">
                                            John Doe
                                            <span>XYZ Inc.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="testimonial mb-2"
                                    style="background-image: url('{{asset('front/one-page/images/portfolio/mixed/6.jpg')}}')">
                                    <div class="testi-content">
                                        <div class="testi-image">
                                            <a href="#"><img
                                                    src="{{asset('front/one-page/images/portfolio/mixed/6.jpg')}}"
                                                    alt="Customer Testimonails"></a>
                                        </div>
                                        <p>Incidunt deleniti blanditiis quas</p>
                                        <div class="testi-meta">
                                            John Doe
                                            <span>XYZ Inc.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="testimonial mb-2"
                                    style="background-image: url('{{asset('front/one-page/images/portfolio/mixed/6.jpg')}}')">
                                    <div class="testi-content">
                                        <div class="testi-image">
                                            <a href="#"><img
                                                    src="{{asset('front/one-page/images/portfolio/mixed/6.jpg')}}"
                                                    alt="Customer Testimonails"></a>
                                        </div>
                                        <p>Incidunt deleniti blanditiis quas</p>
                                        <div class="testi-meta">
                                            John Doe
                                            <span>XYZ Inc.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="oc-item">
                                <div class="testimonial mb-2"
                                    style="background-image: url('{{asset('front/one-page/images/portfolio/mixed/6.jpg')}}')">
                                    <div class="testi-content">
                                        <div class="testi-image">
                                            <a href="#"><img
                                                    src="{{asset('front/one-page/images/portfolio/mixed/6.jpg')}}"
                                                    alt="Customer Testimonails"></a>
                                        </div>
                                        <p>Incidunt deleniti blanditiis quas</p>
                                        <div class="testi-meta">
                                            John Doe
                                            <span>XYZ Inc.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="testimonial mb-2"
                                    style="background-image: url('{{asset('front/one-page/images/portfolio/mixed/6.jpg')}}')">
                                    <div class="testi-content">
                                        <div class="testi-image">
                                            <a href="#"><img
                                                    src="{{asset('front/one-page/images/portfolio/mixed/6.jpg')}}"
                                                    alt="Customer Testimonails"></a>
                                        </div>
                                        <p>Incidunt deleniti blanditiis quas</p>
                                        <div class="testi-meta">
                                            John Doe
                                            <span>XYZ Inc.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="testimonial mb-2"
                                    style="background-image: url('{{asset('front/one-page/images/portfolio/mixed/6.jpg')}}')">
                                    <div class="testi-content">
                                        <div class="testi-image">
                                            <a href="#"><img
                                                    src="{{asset('front/one-page/images/portfolio/mixed/6.jpg')}}"
                                                    alt="Customer Testimonails"></a>
                                        </div>
                                        <p>Incidunt deleniti blanditiis quas</p>
                                        <div class="testi-meta">
                                            John Doe
                                            <span>XYZ Inc.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="testimonial mb-2"
                                    style="background-image: url('{{asset('front/one-page/images/portfolio/mixed/6.jpg')}}')">
                                    <div class="testi-content">
                                        <div class="testi-image">
                                            <a href="#"><img
                                                    src="{{asset('front/one-page/images/portfolio/mixed/6.jpg')}}"
                                                    alt="Customer Testimonails"></a>
                                        </div>
                                        <p>Incidunt deleniti blanditiis quas</p>
                                        <div class="testi-meta">
                                            John Doe
                                            <span>XYZ Inc.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 mb-4">
                        <div id="img_card" class="card text-white card-has-bg click-col"
                            style="background-image:url('{{asset('front/one-page/images/outdoor/3Copy.jpg')}}'); height: 525px !important; background-size:contain !important;">
                            <div class="card-img-overlay d-flex flex-column">
                                <div class="card-body">
                                    {{-- --}}
                                </div>
                                <div class="card-footer">
                                    <div class="media">
                                        {{-- --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section border-top-0 mb-6">
            <div class="container text-center">
                <div class="heading-block center">
                    <h2>Testimonial</h2>
                </div>
                <div id="oc-testi"
                    class="owl-carousel testimonials-carousel carousel-widget owl-loaded owl-drag with-carousel-dots"
                    data-margin="20" data-items-sm="1" data-items-md="2" data-items-xl="3">
                    <div class="owl-stage-outer">
                        <div class="owl-stage"
                            style="transform: translate3d(-877px, 0px, 0px); transition: all 0.25s ease 0s; width: 2194px;">
                            <div class="owl-item active" style="width: 418.667px; margin-right: 20px;">
                                <div class="oc-item">
                                    <div class="testimonial">
                                        <div class="testi-image">
                                            <a href="#"><img src="{{asset('front/one-page/images/team/3.jpg')}}"
                                                    alt="Customer Testimonails"></a>
                                        </div>
                                        <div class="testi-content">
                                            <p>Incidunt deleniti blanditiis quas aperiam recusandae consequatur ullam
                                                quibusdam
                                                cum libero illo rerum repellendus!</p>
                                            <div class="testi-meta">
                                                John Doe
                                                <span>XYZ Inc.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="owl-nav"><button type="button" role="presentation" class="owl-prev"><i
                                class="icon-angle-left"></i></button><button type="button" role="presentation"
                            class="owl-next disabled"><i class="icon-angle-right"></i></button></div>
                    <div class="owl-dots"><button role="button" class="owl-dot"><span></span></button><button
                            role="button" class="owl-dot active"><span></span></button></div>
                </div>
            </div>
        </div>

        <div class="section border-top-0 mb-6">
            <div class="container text-center">
                <div class="heading-block center">
                    <h2>Partner</h2>
                </div>
                <div id="oc-testi" class="owl-carousel testimonials-carousel carousel-widget" data-margin="20"
                    data-items-sm="1" data-items-md="2" data-items-xl="3">
                    <div class="oc-item">
                        {{-- <div class="testimonial"
                            style="background-image: url('{{asset('front/one-page/images/portfolio/mixed/6.jpg')}}')">
                            <div class="testi-content">
                                <div class="testi-image">
                                    <a href="#"><img src="{{asset('front/one-page/images/portfolio/mixed/6.jpg')}}"
                                            alt="Customer Testimonails"></a>
                                </div>
                                <p>Incidunt deleniti blanditiis quas</p>
                                <div class="testi-meta">
                                    John Doe
                                    <span>XYZ Inc.</span>
                                </div>
                            </div>
                        </div> --}}
                        <img src="{{asset('front/one-page/images/portfolio/mixed/6.jpg')}}" width="310px" height="200px"
                            alt="">
                    </div>
                </div>
            </div>
        </div>
</section>
<!-- #content end -->

@include("front.layout.footer")
<script>
    $(document).ready(function() {
        $('#sldall').slick({
            dots: true,
            infinite: false,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 4,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
        $('#sld').slick({
            dots: true,
            infinite: false,
            speed: 300,
            slidesToShow: 3,
            slidesToScroll: 3,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
        $('#sld1').slick({
            dots: true,
            infinite: false,
            speed: 300,
            slidesToShow: 3,
            slidesToScroll: 3,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
        $('#sld2').slick({
            dots: true,
            infinite: false,
            speed: 300,
            slidesToShow: 3,
            slidesToScroll: 3,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });

    })
</script>