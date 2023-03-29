@include('front.layout.head')
@include('front.layout.topbar')
@include(env('CUSTOM_HEADER', 'front.layout.header'))
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
            min-height: 345px;
        }

        .testimonial {
            height: 200px !important;
            border-radius: 20px !important;
            background-size: 120%;
            background-position: center;
            background-repeat: no-repeat
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
            height: 214px !important;
            border-radius: 20px !important;
            background-size: 120%;
            background-position: center;
            background-repeat: no-repeat
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
        /* cursor: pointer; */
        transition: all 500ms cubic-bezier(0.28, 1.02, 1, 0.14);
    }

    .card:hover .card-body {
        margin-top: 10px;
        transition: all 800ms cubic-bezier(0.19, 1, 0.22, 1);
    }

    .card .card-img-overlay {
        transition: all 800ms cubic-bezier(0.19, 1, 0.22, 1);
        background: #234f6d;
        background: linear-gradient(0deg, rgba(35, 79, 109, 0.3785889356) 0%, #455f71 100%);
    }

    .owl-carousel .owl-dots,
    .owl-carousel .owl-nav {
        text-align: left !important;
        -webkit-tap-highlight-color: transparent;
        line-height: 1;
    }

    .owl-carousel .owl-dots .owl-dot {
        display: inline-block;
        zoom: 1;
        width: 8px;
        height: 8px;
        margin: 30px 4px 0 4px;
        opacity: 0.5;
        border-radius: 50%;
        background-color: #ffffff;
        -webkit-transition: all .3s ease;
        -o-transition: all .3s ease;
        transition: all .3s ease;
    }
</style>

<!-- Content -->
<section id="content">
    <div id="carouselExampleControls" class="carousel slide d-none d-sm-block" data-ride="carousel">
        <div class="carousel-inner">
            {{-- @foreach ($banner_slide as $key => $value)
            <div class="carousel-item @if ($key == 0) active @endif">
                <img class="d-block w-100" src="/Image/{{ $value->image }}" alt="First slide">
            </div>
            @endforeach --}}
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <div id="oc-images" class="owl-carousel image-carousel carousel-widget owl-loaded owl-drag d-block d-sm-none"
        data-items-xs="1" data-items-sm="1" data-items-lg="2" data-items-xl="1">
        <div class="owl-stage-outer">
            <div class="owl-stage"
                style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1843px;">
                {{-- @if (isset($banner_slide_mobile))
                @foreach ($banner_slide_mobile as $key => $value)
                <div class="owl-item" style=" margin-right: 20px;">
                    <div class="oc-item">
                        <a href="#"><img src="/Image/{{ $value->image }}" alt="Image 1"></a>
                    </div>
                </div>
                @endforeach
                @else
                <div class="owl-item" style="margin-right: 20px;">
                    <div class="oc-item">
                        <a href="#"><img src="{{ asset('Backend/assets/img/600x300.jpg') }}" alt="Image 1"></a>
                    </div>
                </div>
                @endif --}}
            </div>
        </div>
    </div>
</section>
<section id="content">
    <div class="content-wrap mt-6" style="padding: 0px;">
        <div class="section border-top-0 mb-6">
            <div class="container">
                <div class="heading-block center">
                    <h2>Jelajahi Academy</h2>
                    <p>Berbagai macam pilihan kelas bankir academy dengan metode belajar yang cocok buat kamu</p>
                </div>
                <div class="row mb-2">
                    @foreach($data as $key => $value)
                    <div class="col-lg-4 mb-4">
                        <div class="card" style="min-height: auto">
                            <div class="card-body">
                                <div class="d-flex">
                                    <img src="{{$value->image?'/image/loker/'.json_decode($value->image)->url:''}}" alt="" width="60px" height="60px" style="border-radius: 13px">
                                    {{-- @if($value->google_id)
                                    <img src="{{$value->picture}}" alt="" width="60px" height="60px" style="border-radius: 13px">
                                    @else
                                    <img src="{{asset($value->picture?$value->picture:'aki.png')}}" alt="" width="60px" height="60px" style="border-radius: 13px">
                                    @endif --}}
                                    <div class="ml-2">
                                        <h3 style="margin: 0px">{{substr($value->title,0,16)}}</h3> {{--maksimal 15 karakters--}}
                                        @if($value->nama)
                                        <small>{{$value->nama}}</small>
                                        @else
                                        <small>{{json_decode($value->corporate)?json_decode($value->corporate)->name:'Anugrah Karya'}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-2">
                                    {{-- <p style="margin: 0px"><i class="icon-suitcase mr-2"></i>
                                        @if($value->skill)
                                            @foreach(json_decode($value->skill) as $key => $v)
                                                <span class="badge badge-info">{{$v}}</span>
                                            @endforeach
                                        @endif
                                    </p> --}}
                                    {{-- @if($value->gaji_min > 0)
                                    <p style="margin: 0px"><i class="icon-print mr-2"></i>{{$value->gaji_min}}</p>
                                    @else
                                    @endif --}}
                                    <p style="margin: 0px"><i class="icon-print mr-2"></i>Gaji Competitive</p>
                                    <p style="margin: 0px"><i class="icon-wallet mr-2"></i>{{\Carbon\Carbon::parse($value->tanggal_akhir)->format('d-m-Y')}}</p>
                                </div>
                                
                                <a class="btn btn-primary btn-sm btn-block" href="/loker/{{$value->id}}/detail">Detail</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                {{-- <div id="related-portfolio"
                    class="owl-carousel portfolio-carousel carousel-widget owl-loaded owl-drag with-carousel-dots"
                    data-margin="0" data-autoplay="5000" data-items-xs="0" data-items-sm="0" data-items-md="0"
                    data-items-xl="0">
                    <div class="owl-stage-outer">
                        <div class="owl-stage owlCustom"
                            style="transform: translate3d(-1989px, 0px, 0px); transition: all 0.25s ease 0s; width: 3315px;">
                            @foreach ($o['owlCustom'] as $k => $v)
                            {!!$v!!}
                            @endforeach
                            {!! $o['owlCustom'] !!}
                        </div>
                    </div>
                    <div class="owl-nav" hidden><button type="button" role="presentation" class="owl-prev"
                            style="zoom: 1 !important"><i class="icon-angle-left"></i></button><button type="button"
                            role="presentation" class="owl-next" style="zoom: 1 !important"><i
                                class="icon-angle-right"></i></button></div>
                </div>
                <hr style="width: 1100px">
                <div id="cateKelas">
                    @foreach ($o['cateKelas'] as $k => $v)
                    {!!$v!!}
                    @endforeach
                    {!! $o['cateKelas'] !!}
                </div> --}}
                {{-- <div class="center">
                    <input type="text" id="halaman" value="{{ $o['next_page'] }}" hidden>
                    <a id="allClass" class="btn btn-primary btn-block">Semua Kelas</a>
                </div> --}}
            </div>
        </div>

        {{-- <div class="section border-top-0" style="background-color:#0076f5">
            <div class="container text-center">
                <div class="heading-block center mt-4">
                    <h2 id="hrefpromo" class="text-white">Promo</h2>
                </div>
                <div id="oc-testi" class="owl-carousel testimonials-carousel carousel-widget owl-loaded"
                    data-margin="20" data-items-sm="1" data-items-md="2" data-items-xl="2">
                    <div class="owl-stage-outer">
                        <div class="owl-stage"
                            style="transform: translate3d(-877px, 0px, 0px); transition: all 0.25s ease 0s; width: 2194px;">
                            @if (isset($banner_promo))
                            @foreach ($banner_promo as $bp)
                            <div class="owl-item active" style="margin-right: 20px;">
                                <div class="oc-item">
                                    <a href="/promo">
                                        <img src="Image/{{ $bp->image }}" alt=""
                                            style="border-radius: 20px !important;">
                                    </a>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-row-reverse">
                    <a href="/promo">
                        <button class="btn btn-warning" style="border-radius: 9px">Promo Lainnya</button>
                    </a>
                </div>
            </div>
        </div>
        <div class="section border-top-0" style="background-color:#0076f5; padding-bottom: 118px !important">
            <div class=" container text-center">
                <div class="heading-block center mt-4">
                    <h2 class="text-white">Kelas Terdekat</h2>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-4">
                        <div id="oc-testi" class="owl-carousel testimonials-carousel carousel-widget" data-margin="20"
                            data-items-sm="1" data-items-md="1" data-items-xl="1">
                            @if (isset($kelas_mingguan))
                            @foreach ($kelas_mingguan as $km)
                            <div class="oc-item">
                                @foreach ($km as $k)
                                <div class="testimonial mb-2"
                                    style="background-color: #E9EEF0; padding: 10px !important">
                                    <div class="testi-content">
                                        <div class="testi-image">
                                            <a href="#"><img src="{{ $k->image }}" alt="Customer Testimonails"></a>
                                        </div>
                                        <p>{{ $k->title }}</p>
                                        <small>{{ \Carbon\Carbon::parse($k->date_start)->format('F d, Y') }}</small>
                                        <div class="testi-meta" style="padding-left: 90px;">
                                            <p>{{ $k->instructor_list[0]->name }}</p>
                                            <span>{{ $k->instructor_list[0]->title }}</span>
                                            @auth
                                            <a href="class/{{ $k->unique_id }}/{{ urlencode(
                                                                    str_ireplace(
                                                                        [
                                                                            '\'',
                                                                            '/',
                                                                            '//',
                                                                            '"',
                                                                            ' ,', ';' , '<' , '>' , ], '' , $k->title,
                                                ),
                                                ) }}">
                                                <button class="btn btn-primary btn-sm" width='100%'>Detail</button>
                                            </a>
                                            @else
                                            <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modelId"
                                                data-backdrop="static" data-keyboard="false">Detail</a>
                                            @endauth
                                        </div>
                                        <div style="text-center">
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
                        <a href="https://forms.gle/yHh3WpMyHRduPL6W6">
                            <div id="img_card" class="card text-white click-col"
                                style="background-image:url('Image/{{ $banner_bawah[0]->image }}');  background-size:contain !important;">
                            </div>
                        </a>
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
                                                <div class="testimonial" style="background-image:url('Image/{{ $banner_bawah[$i]->image }}');
                                                    border-radius: 20px !important;
                                                    background-size: 120%;
                                                    background-position: center;
                                                    background-repeat: no-repeat;
                                                    height:200px;">
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
                                                <div class="testimonial" style="background-image:url('{{ asset('Backend/assets/img/1280x857.jpg') }}'); border-radius: 20px !important;
                                                    background-size: 120%;
                                                    background-position: center;
                                                    background-repeat: no-repeat">
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
        </div> --}}
    </div>
    <div class="section border-top-0" style="background-color:#ffffff; padding-bottom: 0px">
        <div class="container text-center">
            <img src="{{ asset('cariin-kerja.webp') }}" alt="">
        </div>
    </div>

    {{-- Testimonial --}}
    {{-- <div id="Testimonial" class="section border-top-0" style="background-color:#FFA600; padding-bottom: 30px">
        <div class="container text-center">
            <div class="heading-block center text-white mt-4">
                <h2 class="text-white">Testimonial</h2>
            </div>
            <div id="oc-testi"
                class="owl-carousel testimonials-carousel carousel-widget owl-loaded owl-drag with-carousel-dots"
                data-margin="20" data-items-sm="1" data-items-md="2" data-items-xl="3">
                <div class="owl-stage-outer">
                    <div class="owl-stage"
                        style="transform: translate3d(-877px, 0px, 0px); transition: all 0.25s ease 0s; width: 2194px;">
                        @if (isset($testimoni))
                        @foreach ($testimoni as $key => $t)
                        <div class="owl-item active" style="width: 418.667px; margin-right: 20px;">
                            <div class="oc-item">
                                <div class="testimonial"
                                    style="background-color: #ffffffa1 !important; border-radius: 9px !important">
                                    <div class="testi-image">
                                        <a href="#"><img
                                                src="{{ $t->picture ? $t->picture : asset('avatars/avatar-' . ($key + 1) . '.png') }}"
                                                alt="Customer Testimonails"></a>
                                    </div>
                                    <div class="testi-content">
                                        <p>{{ $t->review }}</p>
                                        <div class="testi-meta">
                                            {{ $t->name }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- Gambar Bawah --}}
    {{-- <div class="section border-top-0 mb-6 mt-4">
        <div class="container text-center">
            <img src="{{ asset('gambar-footer-03.png') }}" alt="">
        </div>
    </div> --}}
        <div class="section border-top-0 mb-6 mt-4">
            <div class="container text-center">
                <div class="logo-perusahaan">
                    {{-- @if($logo_perusahaan)
                        @foreach(json_decode($logo_perusahaan->logo_perusahaan) as $key => $v)
                            @if($v)
                                <?php $f = explode('|',$v); ?>
                                @if(stripos($f[0],'https')>=0)
                                    <div><img src="{{$f[0]}}" alt=""></div>
                                @else
                                    <div><img src="{{asset($f[0])}}" alt=""></div>
                                @endif
                            @endif
                        @endforeach
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
    {{-- <textarea name="" id="kelas" cols="30" rows="10" hidden>{{ json_encode($o['kelas']) }}</textarea> --}}
</section>
<!-- #content end -->

@include('front.layout.footer')
<script>
    let arrkategori = JSON.parse($('#kelas').val());
    $(document).ready(function() {
        // lazyLoad(1);
        $('#allClass').click(function() {
            let hal = $('#halaman').val();
            lazyLoad(hal);
        })
        setTimeout(() => {
            tabsCategory('Semua');
        }, 500);
        $('.logo-perusahaan').slick({
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

    function tabsCategory(params) {
        console.log(params);
        $('.tabsCustom').each(function() {
            $(this).attr('hidden', true);
        })
        $('#' + params).removeAttr('hidden');
        // $('.' + params).removeClass('btn-outline-primary');
        // $('.' + params).addClass('btn-primary');
        arrkategori.forEach(element => {
            if (params == element) {
                $('.' + params).removeClass('btn-outline-primary');
                $('.' + params).addClass('btn-primary');
            } else {
                $('.' + element).addClass('btn-outline-primary');
                $('.' + element).removeClass('btn-primary');
            }
        });
        // $('#allClass').attr('href','/list-class/'+params);
    }

    function lazyLoad(page) {
        // $('#halaman').val(page)
        if (!page) {
            iziToast.error({
                title: 'Info',
                message: 'Semua Kelas Sudah Tampil',
                position: 'topRight',
            });
            return $('#allClass').attr('hidden', true)
        }
        return new Promise((resolve, reject) => {
            $.ajax({
                url: page,
                type: 'GET',
                beforeSend: function() {
                    $('.ajax-load').show();
                    // console.log('getData');
                },
                success: function(response) {
                    Object.keys(response).forEach(key => {
                        console.log(key.replace(/[^a-zA-Z0-9]/g,''));
                        $('#' + key.replace(/[^a-zA-Z0-9]/g,'')).append(response[key]);
                    });
                    $('#halaman').val(null)
                    if (response.next_page_url) {
                        $('#halaman').val(response.next_page_url)
                    }
                    resolve();
                }
            })
        })
    };
</script>