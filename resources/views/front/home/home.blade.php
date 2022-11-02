@include('front.layout.head')
@include('front.layout.topbar')
@include(env("CUSTOM_HEADER","front.layout.header"))

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
        min-height: 425px;
        box-shadow: 0 0 12px 0 rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 768px) {
        .card {
            min-height: 350px;
        }

        .testimonial {
            height: 166px !important;
        }

    }

    @media (max-width: 420px) {
        .card {
            min-height: 180px;
        }

        .card img {
            max-width: 100%;
        }

        .testimonial {
            height: 180px !important;
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

<!-- Content -->
@if (isset($banner_slide))
<style>
    .owl-carousel .owl-nav [class*=owl-] {
        position: absolute;
        top: 50%;
        margin-top: -18px;
        left: -36px;
        zoom: 2;
        width: 40px;
        height: 40px;
        line-height: 32px;
        border: 1px solid rgba(0, 0, 0, 0.2);
        color: #0b5fc7;
        background-color: #FFF;
        font-size: 18px;
        border-radius: 50%;
        opacity: 0;
        -webkit-transition: all .3s ease;
        -o-transition: all .3s ease;
        transition: all .3s ease;
    }
</style>
<section id="content">
    <div id="oc-images" class="owl-carousel image-carousel carousel-widget owl-loaded owl-drag d-none d-sm-block"
        data-items-xs="1" data-items-sm="1" data-items-lg="1" data-items-xl="1">
        <div class="owl-stage-outer">
            <div class="owl-stage"
                style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1843px;">
                @foreach ($banner_slide as $key => $value)
                <div class="owl-item" style=" margin-right: 20px;">
                    <div class="oc-item">
                        <a href="#"><img src="/Image/{{$value->image}}" alt="Image 1"></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>


        {{-- style="zoom: 2 !important; width: 40px !important; height: 40px !important; color: #0b5fc7 ! important;
        background-color: #fff" --}}

        {{-- <div class="owl-nav">
            <button type="button" role="presentation" class="owl-prev"><i class="icon-angle-left"></i></button>
            <button type="button" role="presentation" class="owl-next disabled"><i
                    class="icon-angle-right"></i></button>
        </div> --}}
        {{-- <div class="owl-dots"><button role="button" class="owl-dot"><span></span></button><button role="button"
                class="owl-dot active"><span></span></button></div> --}}
    </div>
    <div id="oc-images" class="owl-carousel image-carousel carousel-widget owl-loaded owl-drag d-block d-sm-none"
        data-items-xs="1" data-items-sm="1" data-items-lg="1" data-items-xl="1">
        <div class="owl-stage-outer">
            <div class="owl-stage"
                style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1843px;">
                @if (isset($banner_slide_mobile))
                @foreach ($banner_slide_mobile as $key => $value)
                <div class="owl-item" style=" margin-right: 20px;">
                    <div class="oc-item">
                        <a href="#"><img src="/Image/{{$value->image}}" alt="Image 1"></a>
                    </div>
                </div>
                @endforeach
                @else
                <div class="owl-item" style=" margin-right: 20px;">
                    <div class="oc-item">
                        <a href="#"><img src="{{asset('Backend/assets/img/600x300.jpg')}}" alt="Image 1"></a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endif
<section id="content">
    <div class="content-wrap" style="padding: 0px;">
        <div class="section border-top-0 mb-6">
            <div class="container text-center">
                <div class="heading-block center">
                    <h2>SEMUA KELAS</h2>
                </div>
                <div class="tabs tabs-alt clearfix" id="tabs-profile">
                    @if (isset($kelas))
                    <ul class="tab-nav clearfix" style="overflow-x: scroll !important; overflow-y: hidden !important;">
                        @foreach ($kelas as $key => $k )
                        <li><a href="#{{str_replace(' ','_',$key)}}"><i class="icon-credit-cards"></i>{{str_replace('
                                ','_',$key)}}</a></li>
                        @endforeach
                    </ul>
                    <div class="tab-container">
                        @foreach ($kelas as $key => $k )
                        <div class="tab-content clearfix" id="{{str_replace(' ','_',$key)}}">
                            <div class="row">
                                @foreach ($k as $ke)
                                <div class="col-lg-4 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="card" style="min-height: 0px !important">
                                                <img src="<?= $ke->image ?>" alt="" width="100%">
                                            </div>
                                            <h5 class="text-uppercase mt-2">{{ $ke->title }}</h5>
                                            <div class="d-flex mt-2">
                                                <img class="mr-3 rounded-circle"
                                                    src="Image/{{ json_decode($ke->instructor_list[0]->picture)->url }}"
                                                    alt="Generic placeholder image"
                                                    style="max-width:50px; max-height:50px;">
                                                <div class="">
                                                    <label class="d-block mb-0"> {{ $ke->instructor_list[0]->name }}
                                                    </label>
                                                    <small>{{ $ke->instructor_list[0]->title }}</small>
                                                </div>
                                                <div class="ml-2 flex-fill">
                                                    <label class="d-block mb-0"> Harga
                                                    </label>
                                                    @if ($ke->pricing)
                                                    <small>
                                                        {{ numfmt_format_currency(numfmt_create('id_ID',
                                                        \NumberFormatter::CURRENCY), $ke->pricing->price, 'IDR') }}
                                                    </small>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="text-right mt-2 w-100">
                                                <a class="btn btn-success btn-block btn-rounded"
                                                    style=" border-radius:10px !important"
                                                    href="class/{{ $ke->unique_id }}/{{ urlencode(str_ireplace( array( '\'', '/', '//', '"', ',' , ';', '<', '>' ), '', $ke->title)) }}">
                                                    Detail
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                {{-- <div class="row" id="sld"> --}}
                    {{-- <div class="row" id="">
                        @if (isset($pop))
                        @foreach ($pop as $p)
                        <div class="col-lg-4 col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card" style="min-height: 0px !important">
                                        <img src="<?= $p->image ?>" alt="" width="100%">
                                    </div>
                                    <h5 class="text-uppercase mt-2">{{ $p->title }}</h5>
                                    <div class="d-flex mt-2">
                                        <img class="mr-3 rounded-circle"
                                            src="Image/{{ json_decode($p->instructor_list[0]->picture)->url }}"
                                            alt="Generic placeholder image" style="max-width:50px; max-height:50px;">
                                        <div class="">
                                            <label class="d-block mb-0"> {{ $p->instructor_list[0]->name }}
                                            </label>
                                            <small>{{ $p->instructor_list[0]->title }}</small>
                                        </div>
                                        <div class="ml-2 flex-fill">
                                            <label class="d-block mb-0"> Harga
                                            </label>
                                            @if ($p->pricing)
                                            <small>
                                                {{ numfmt_format_currency(numfmt_create('id_ID',
                                                \NumberFormatter::CURRENCY), $p->pricing->price, 'IDR') }}
                                            </small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-right mt-2 w-100">
                                        <a class="btn btn-success btn-block btn-rounded"
                                            style=" border-radius:10px !important"
                                            href="class/{{ $p->unique_id }}/{{ $p->title }}">
                                            Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div> --}}
                    {{--
                </div> --}}
                <div class="center">
                    <a href="#" class="btn btn-primary btn-block">Load more...</a>
                </div>
            </div>
        </div>

        <div class="section border-top-0 mb-6">
            <div class="container text-center">
                <div class="heading-block center">
                    <h2>Promo</h2>
                </div>
                <div id="oc-testi"
                    class="owl-carousel testimonials-carousel carousel-widget owl-loaded owl-drag with-carousel-dots"
                    data-margin="20" data-items-sm="1" data-items-md="2" data-items-xl="2">
                    <div class="owl-stage-outer">
                        <div class="owl-stage"
                            style="transform: translate3d(-877px, 0px, 0px); transition: all 0.25s ease 0s; width: 2194px;">
                            @if (isset($banner_promo))
                            @foreach ($banner_promo as $bp)
                            <div class="owl-item active" style="margin-right: 20px;">
                                <div class="oc-item">
                                    <div class="testimonial"
                                        style="background-image:url('Image/{{ $bp->image }}');
                                                    border-radius: 20px !important; height: 316px; background-size:100%;">
                                        <a href="#"></a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
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
                    <h2>Kelas Terdekat</h2>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-4">
                        <div id="oc-testi" class="owl-carousel testimonials-carousel carousel-widget" data-margin="20"
                            data-items-sm="1" data-items-md="1" data-items-xl="1">
                            @if (isset($kelas_mingguan))
                            @foreach ($kelas_mingguan as $km)
                            <div class="oc-item">
                                @foreach ($km as $k)
                                <div class="testimonial mb-2" style="background-color: #E9EEF0">
                                    <div class="testi-content">
                                        <div class="testi-image">
                                            <a href="#"><img src="{{ $k->image }}" alt="Customer Testimonails"></a>
                                        </div>
                                        <p>{{ $k->title }}</p>
                                        <small><i class="far fa-clock"></i>
                                            {{ \Carbon\Carbon::parse($k->date_start)->format('F d, Y') }}</small>
                                        <div class="testi-meta">
                                            {{ $k->instructor_list[0]->name }}
                                            <span style="padding-left: 83px">{{ $k->instructor_list[0]->title }}
                                            </span>
                                            @auth
                                            <a href="class/{{ $k->unique_id }}/{{ urlencode(str_ireplace( array( '\'', '/', '//', '"', ',' , ';', '<', '>' ), '', $k->title)) }}">
                                                <button class="btn btn-success btn-sm" style="margin-left: 83px"
                                                    width='100%'>Detail</button>
                                            </a>
                                            @else
                                            <a class="btn btn-success btn-sm" style="margin-left: 83px;"
                                                data-toggle="modal" data-target="#modelId" data-backdrop="static"
                                                data-keyboard="false">Detail</a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-8 mb-4">
                        @if (isset($banner_bawah))
                        @if (count($banner_bawah) > 0)
                        <div id="img_card" class="card text-white click-col"
                            style="background-image:url('Image/{{ $banner_bawah[0]->image }}');  background-size:contain !important;">
                        </div>
                        <div class="d-flex mt-4">
                            <div id="oc-testi"
                                class="owl-carousel testimonials-carousel carousel-widget owl-loaded owl-drag with-carousel-dots"
                                data-margin="20" data-items-sm="1" data-items-md="2" data-items-xl="2"
                                style="height: 155px">
                                <div class="owl-stage-outer">
                                    <div class="owl-stage"
                                        style="transform: translate3d(-877px, 0px, 0px); transition: all 0.25s ease 0s; width: 2194px;">
                                        @for ($i = 1; $i < count($banner_bawah); $i++) <div class="owl-item active"
                                            style="width: 418.667px; margin-right: 20px;">
                                            <div class="oc-item">
                                                <div class="testimonial"
                                                    style="background-image:url('Image/{{ $banner_bawah[$i]->image }}');
                                                    border-radius: 20px !important; height: 260px !important; background-size:100%;">
                                                    <a href="#"></a>
                                                </div>
                                            </div>
                                    </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        @else
                        <div id="img_card" class="card text-white click-col"
                            style="background-image:url('{{ asset('Backend/assets/img/1280x857.jpg') }}'); min-height:0px; background-size:contain !important;">
                        </div>
                        <div class="d-flex mt-4">
                            <div id="oc-testi"
                                class="owl-carousel testimonials-carousel carousel-widget owl-loaded owl-drag with-carousel-dots"
                                data-margin="20" data-items-sm="1" data-items-md="2" data-items-xl="2">
                                <div class="owl-stage-outer">
                                    <div class="owl-stage"
                                        style="transform: translate3d(-877px, 0px, 0px); transition: all 0.25s ease 0s; width: 2194px;">
                                        <div class="owl-item active" style="width: 418.667px; margin-right: 20px;">
                                            <div class="oc-item">
                                                <div class="testimonial"
                                                    style="background-image:url('{{ asset('Backend/assets/img/1280x857.jpg') }}'); border-radius: 20px !important; height: 285px;">
                                                    <a href="#"><img
                                                            src="{{ asset('Backend/assets/img/1280x857.jpg') }}"
                                                            alt="Customer Testimonails" height="100%"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endif
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
                        @if (isset($testimoni))
                        @foreach ($testimoni as $t)
                        <div class="owl-item active" style="width: 418.667px; margin-right: 20px;">
                            <div class="oc-item">
                                <div class="testimonial">
                                    <div class="testi-image">
                                        <a href="#"><img
                                                src="{{ $t->picture?$t->picture:asset('front/one-page/images/team/3.jpg') }}"
                                                alt="Customer Testimonails"></a>
                                    </div>
                                    <div class="testi-content">
                                        <p>{{$t->review}}</p>
                                        <div class="testi-meta">
                                            {{$t->name}}
                                            {{-- <span>XYZ Inc.</span> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
                {{-- <div class="owl-nav"><button type="button" role="presentation" class="owl-prev"><i
                            class="icon-angle-left"></i></button><button type="button" role="presentation"
                        class="owl-next disabled"><i class="icon-angle-right"></i></button></div>
                <div class="owl-dots"><button role="button" class="owl-dot"><span></span></button><button role="button"
                        class="owl-dot active"><span></span></button></div> --}}
            </div>
        </div>
    </div>

    <div class="section border-top-0 mb-6">
        <div class="container text-center">
            <div class="heading-block center">
                <h2>Partner</h2>
            </div>
            {{-- <div id="oc-testi" class="owl-carousel testimonials-carousel carousel-widget" data-margin="20"
                data-items-sm="1" data-items-md="2" data-items-xl="3">
                @if (isset($partner))
                @foreach ($partner as $p)
                <div class="oc-item">
                    <div class="testimonial"
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
                    </div>
                    <a href="{{ $p->link }}">
                        <img src="Image/Partner/{{ json_decode($p->image)->url }}" alt="">
                    </a>
                </div>
                @endforeach
                @endif
            </div> --}}
            <img src="{{asset('partner-eclass.png')}}" alt="" style="width: 700px">
        </div>
    </div>
    </div>
</section>
<!-- #content end -->

@include('front.layout.footer')
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
    }); $('#sld').slick({
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
    }); $('#sld1').slick({
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
    }); $('#sld2').slick({
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