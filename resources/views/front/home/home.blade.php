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
{{-- <style>
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
</style> --}}
<section id="content">
    {{-- <div id="oc-images" class="owl-carousel image-carousel carousel-widget owl-loaded owl-drag d-none d-sm-block"
        data-items-xs="1" data-items-sm="1" data-items-lg="1" data-items-xl="1">
        <div class="owl-stage-outer">
            <div class="owl-stage"
                style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1843px;">
                @foreach ($banner_slide as $key => $value)
                <div class="owl-item">
                    <div class="oc-item">
                        <a href="#"><img src="/Image/{{ $value->image }}" alt="Image 1"></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div> --}}
    <div id="carouselExampleControls" class="carousel slide d-none d-sm-block" data-ride="carousel">
        <div class="carousel-inner">
            @foreach ($banner_slide as $key => $value)
            <div class="carousel-item @if ($key == 0)
                active
            @endif">
                <img class="d-block w-100" src="/Image/{{ $value->image }}" alt="First slide">
            </div>
            @endforeach
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
        data-items-xs="1" data-items-sm="1" data-items-lg="1" data-items-xl="1">
        <div class="owl-stage-outer">
            <div class="owl-stage"
                style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1843px;">
                @if (isset($banner_slide_mobile))
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
                    <h2>Jelajahi Akademi</h2>
                    <p>Berbagai macam pilihan akademi dengan metode belajar yang cocok buat kamu</p>
                </div>
                <div id="related-portfolio"
                    class="owl-carousel portfolio-carousel carousel-widget owl-loaded owl-drag with-carousel-dots"
                    data-margin="0" data-autoplay="5000" data-items-xs="0" data-items-sm="0" data-items-md="0"
                    data-items-xl="0">
                    <div class="owl-stage-outer">
                        <div class="owl-stage owlCustom"
                            style="transform: translate3d(-1989px, 0px, 0px); transition: all 0.25s ease 0s; width: 3315px;">
                            {{-- @if (isset($kelas))
                            @foreach ($kelas as $key => $k)
                            <div class="owl-item" style="">
                                <div class="oc-item">
                                    <div class="portfolio-item">
                                        <div class="portfolio-image">
                                            <button class="button button-circle"
                                                onclick="tabsCategory('{{str_replace(' ','_',$key)}}')">{{$key}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif --}}
                        </div>
                    </div>
                    <div class="owl-nav" hidden><button type="button" role="presentation" class="owl-prev"
                            style="zoom: 1 !important"><i class="icon-angle-left"></i></button><button type="button"
                            role="presentation" class="owl-next" style="zoom: 1 !important"><i
                                class="icon-angle-right"></i></button></div>
                </div>
                <hr style="width: 1100px">
                <div id="cateKelas"></div>
                <div class="center">
                    <input type="text" id="halaman" hidden>
                    <a id="allClass" class="btn btn-primary btn-block">Semua Kelas</a>
                </div>
            </div>
        </div>

        <div class="section border-top-0 mb-6" hidden>
            <div class="container text-center">
                <div class="heading-block center">
                    <h2 id="hrefpromo">Promo</h2>
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

        <div class="section border-top-0 mb-6" hidden>
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

    <div class="section border-top-0 mb-6" hidden>
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
                                                src="{{ $t->picture ? $t->picture : asset('front/one-page/images/team/3.jpg') }}"
                                                alt="Customer Testimonails"></a>
                                    </div>
                                    <div class="testi-content">
                                        <p>{{ $t->review }}</p>
                                        <div class="testi-meta">
                                            {{ $t->name }}
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

    <div class="section border-top-0 mb-6" hidden>
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
            <img src="{{ asset('partner-eclass.png') }}" alt="" style="width: 700px">
        </div>
    </div>
    </div>
</section>
<!-- #content end -->

@include('front.layout.footer')
<script>
    $(document).ready(function() {
        lazyLoad(1);
        $('#allClass').click(function() {
            let hal = $('#halaman').val();
            lazyLoad(hal);
        })
        setTimeout(() => {
            tabsCategory('Semua');
        }, 3000);
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
        $('.tabsCustom').each(function() {
            $(this).attr('hidden', true);
        })
        $('#' + params).removeAttr('hidden');
        // $('#allClass').attr('href','/list-class/'+params);
    }

    function lazyLoad(page) {
        $('#halaman').val(page)
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '?page=' + page,
                type: 'GET',
                beforeSend: function() {
                    // $('.ajax-load').show();
                    console.log('getData');
                },
                success: function(response) {
                    let next_page = 0;
                    // $('.owlCustom').html(null);
                    for (const key in response.kelas) {
                        if (Object.hasOwnProperty.call(response.kelas, key)) {
                            const element = response.kelas[key];
                            let owl = '';
                            owl += '<div class="owl-item" style="margin:0px !important;">';
                            owl += '    <div class="oc-item">';
                            owl += '        <div class="portfolio-item">';
                            owl += '            <div class="portfolio-image">';
                            owl += '                <button class="button button-circle"';
                            owl += '                    onclick=tabsCategory("' + key.replace(/([.*+?^$|(){}\[\]])/mg, "_").replace(/ /g,'_') + '")><small>' + key + '</small></button>';
                            owl += '            </div>';
                            owl += '        </div>';
                            owl += '    </div>';
                            owl += '</div>';
                            // let hal = $('#halaman').val();
                            if (page == 1) {
                                $('.owlCustom').append(owl);
                                $('#cateKelas').append('<div id="' + key.replace(/([.*+?^$|(){}\[\]])/mg, "_").replace(/ /g,'_') + '" class="row tabsCustom mt-2" hidden></div>');
                            }

                            let html = '';
                            element.data.forEach(el => {
                                html += '<div class="col-lg-4 col-sm-6 mb-4">';
                                html += '    <div class=card>';
                                html += '        <div class=card-body>';
                                html +=
                                    '            <div class="card" style="min-height: 0px !important">';
                                html += '                <img src="' + el.image +
                                    '" width=100%>';
                                html += '            </div>';
                                html +=
                                    '            <h5 class="text-uppercase mt-2" style="margin-bottom: 0px !important">' +
                                    el.title + '</h5>';
                                    if (el.date_start == el.date_end) {
                                        html += '<h6 style="margin: 0px !important;">' + new Intl
                                            .DateTimeFormat('id-ID', {
                                                dateStyle: 'medium'
                                            }).format(new Date(el
                                                .date_start)) + '</h6>';
                                    } else {
                                        html += '<h6 style="margin: 0px !important;">' + new Intl
                                            .DateTimeFormat('id-ID', {
                                                dateStyle: 'medium'
                                            }).format(new Date(el
                                                .date_start)) + ' - ' + new Intl
                                            .DateTimeFormat('id-ID', {
                                                dateStyle: 'medium'
                                            }).format(new Date(el.date_end)) + '</h6>';
                                    }
                                html += '            <a href="/profile-instructor/'+el.instructor_list[0].id+'/'+el.instructor_list[0].name+'" class="d-flex mt-2">';
                                html += '                <img class="mr-3 rounded-circle"';
                                html += '                    src="Image/' + JSON.parse(el
                                        .instructor_list[0].picture).url +
                                    '" alt=Generic placeholder image style="max-width:50px; max-height:50px;">';
                                html += '                <div class=>';
                                html += '                    <label class="d-block mb-0">' +
                                    el.instructor_list[0].name;
                                html += '                    </label>';
                                html += '                    <small>' + el.instructor_list[
                                    0].title + '</small>';
                                html += '                </div>';
                                html += '                <div class="ml-2 flex-fill">';
                                html +=
                                    '                    <label class="d-block mb-0"> Harga';
                                html += '                    </label>';
                                if (el.pricing) {
                                    if (el.pricing.promo) {
                                        html += '<del>' + new Intl.NumberFormat('id-ID', {
                                            style: 'currency',
                                            currency: 'IDR',
                                            maximumFractionDigits: 0
                                        }).format(el.pricing.price) + '</del>';
                                    } else {
                                        html += '<small>' + new Intl.NumberFormat('id-ID', {
                                            style: 'currency',
                                            currency: 'IDR',
                                            maximumFractionDigits: 0
                                        }).format(el.pricing.price) + '</small>';
                                    }
                                }
                                html += '                </div>';
                                html += '            </a>';
                                html += '            <div class="text-center mt-2 w-100">';
                                if (el.pricing) {
                                    if (el.pricing.promo) {
                                        html +=
                                            '<h3 style="margin: 0px !important; color:#007038 !important;">' +
                                            new Intl.NumberFormat('id-ID', {
                                                style: 'currency',
                                                currency: 'IDR',
                                                maximumFractionDigits: 0
                                            }).format(el.pricing.price - el.pricing
                                                .promo_price) +
                                            '<span class="badge badge-info badge-sm">' +
                                            ((el.pricing.promo_price / el.pricing.price) *
                                                100) + ' %</span></h3>';
                                    }
                                }
                                html +=
                                    '                <a class="btn btn-success btn-block btn-rounded"';
                                html +=
                                    '                    style="border-radius:10px !important"';
                                html += '                    href="class/' + el.unique_id +
                                    '/' + el.title.replace('/',' ') + '">';
                                html += '                    Detail';
                                html += '                </a>';
                                html += '            </div>';
                                html += '        </div>';
                                html += '    </div>';
                                html += '</div>';
                            });
                            if (element.next_page_url) {
                                next_page++;
                            }
                            $('#' + key.replace(/([.*+?^$|(){}\[\]])/mg, "_").replace(/ /g,'_')).append(html);
                        }
                    }
                    if (next_page <= 0) {
                        $('#allClass').attr('disabled', true);
                    }
                    $('#halaman').val(parseInt(page) + 1);
                    resolve();
                }
            })
        })
    };
</script>