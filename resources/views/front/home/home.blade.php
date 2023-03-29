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
@if (isset($banner_slide))
<section id="content">
    <div id="carouselExampleControls" class="carousel slide d-none d-sm-block" data-ride="carousel">
        <div class="carousel-inner">
            @foreach ($banner_slide as $key => $value)
            <div class="carousel-item @if ($key == 0) active @endif">
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
        data-items-xs="1" data-items-sm="1" data-items-lg="2" data-items-xl="1">
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
    <div class="content-wrap mt-6" style="padding: 0px;">
        <div class="section border-top-0 mb-6">
            <div class="container">
                <div class="heading-block center">
                    <h2>Jelajahi Academy</h2>
                    <p>Berbagai macam pilihan kelas bankir academy dengan metode belajar yang cocok buat kamu</p>
                </div>
                <div id="related-portfolio"
                    class="owl-carousel portfolio-carousel carousel-widget owl-loaded owl-drag with-carousel-dots"
                    data-margin="0" data-autoplay="5000" data-items-xs="0" data-items-sm="0" data-items-md="0"
                    data-items-xl="0">
                    <div class="owl-stage-outer">
                        <div class="owl-stage owlCustom"
                            style="transform: translate3d(-1989px, 0px, 0px); transition: all 0.25s ease 0s; width: 3315px;">
                            {{-- @foreach ($o['owlCustom'] as $k => $v)
                            {!!$v!!}
                            @endforeach --}}
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
                    {{-- @foreach ($o['cateKelas'] as $k => $v)
                    {!!$v!!}
                    @endforeach --}}
                    {!! $o['cateKelas'] !!}
                </div>
                <div class="center">
                    <input type="text" id="halaman" value="{{ $o['next_page'] }}" hidden>
                    <a id="allClass" class="btn btn-primary btn-block">Semua Kelas</a>
                </div>
            </div>
        </div>

        <div class="section border-top-0" style="background-color:#0076f5">
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
                                        {{-- <div class="shadow p-3 mb-5 bg-white rounded">
                                        </div> --}}
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
                    <div class="col-lg-6 mb-4">
                        {{-- <div id="oc-testi" class="owl-carousel testimonials-carousel carousel-widget" data-margin="20"
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
                        </div> --}}
                        <div class="card">
                            <div class="card-body">
                                <div class="tabs clearfix ui-tabs ui-corner-all ui-widget ui-widget-content" id="tab-1">
                                    <ul class="tab-nav ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header" role="tablist">
                                        @foreach($class_upcoming as $key => $value)
                                        <li role="tab" tabindex="-1" class="ui-tabs-tab ui-corner-top ui-state-default ui-tab" aria-controls="tabs-2" aria-labelledby="ui-id-2" aria-selected="false" aria-expanded="false"><a href="#{{$key}}" tabindex="0" class="ui-tabs-anchor" id="tabs">{{$key}}</a></li>
                                        @endforeach
                                        {{-- <li role="tab" tabindex="0" class="ui-tabs-tab ui-corner-top ui-state-default ui-tab ui-tabs-active ui-state-active" aria-controls="tabs-1" aria-labelledby="ui-id-1" aria-selected="true" aria-expanded="true"><a href="#tabs-1" tabindex="-1" class="ui-tabs-anchor" id="ui-id-1"><i class="icon-home2 me-0"></i></a></li>
                                        <li role="tab" tabindex="-1" class="ui-tabs-tab ui-corner-top ui-state-default ui-tab" aria-controls="tabs-3" aria-labelledby="ui-id-3" aria-selected="false" aria-expanded="false"><a href="#tabs-3" tabindex="-1" class="ui-tabs-anchor" id="ui-id-3">Proin dolor</a></li>
                                        <li class="d-none d-md-block ui-tabs-tab ui-corner-top ui-state-default ui-tab" role="tab" tabindex="-1" aria-controls="tabs-4" aria-labelledby="ui-id-4" aria-selected="false" aria-expanded="false"><a href="#tabs-4" tabindex="-1" class="ui-tabs-anchor" id="ui-id-4">Aenean lacinia</a></li> --}}
                                    </ul>
                                    <div class="tab-container">
                                        @foreach($class_upcoming as $key => $valu)
                                        <?php $i = 0; ?>
                                        <div class="tab-content ui-tabs-panel ui-corner-bottom ui-widget-content" id="{{$key}}" aria-labelledby="ui-id-1" role="tabpanel" aria-hidden="false" style="">
                                            <div class="table-responsive">
                                                <table id="class-upcoming{{$i}}" class="table table-bordered">
                                                    <?php $i++; ?>
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th style="font-size: 10px">No</th>
                                                            <th style="font-size: 10px">Judul Kelas</th>
                                                            {{-- <th style="font-size: 10px">Bulan</th> --}}
                                                            {{-- <th>Harga</th> --}}
                                                            {{-- <th>Status</th>
                                                            <th>Aksi</th> --}}
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($valu as $k => $v)
                                                        <tr>
                                                            <td style="font-size: 10px">{{$k+1}}</td>
                                                            {{-- <td>
                                                                <a href="/class/{{$v->unique_id}}/{{str_replace('/', '-', $v->title)}}">
                                                                    {{substr($v->title,0,17)}}...
                                                                </a>
                                                            </td> --}}
                                                            <td style="font-size: 12px" class="text-left">{{$v->title}}</td>
                                                            {{-- <td style="font-size: 10px">{{date_format(date_create($v->date_end),'Y-m')}}</td> --}}
                                                            {{-- <td>{{$v->instructor_list[0]->name}}</td>
                                                            @if($v->pricing)
                                                            @if(!$v->pricing->promo)
                                                                <td>Rp. {{number_format($v->pricing->price-$v->pricing->promo_price)}}</td>
                                                            @else
                                                                <td>Rp. {{number_format($v->pricing->price)}}</td>
                                                            @endif
                                                            @else
                                                                <td>Rp. 0</td>
                                                            @endif --}}
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @endforeach
                                        {{-- <div class="tab-content ui-tabs-panel ui-corner-bottom ui-widget-content" id="tabs-2" aria-labelledby="ui-id-2" role="tabpanel" aria-hidden="true" style="display: none;">
                                        Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor. Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.
                                        </div>
                                        <div class="tab-content ui-tabs-panel ui-corner-bottom ui-widget-content" id="tabs-3" aria-labelledby="ui-id-3" role="tabpanel" aria-hidden="true" style="display: none;">
                                        <p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
                                        Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.
                                        </div>
                                        <div class="tab-content ui-tabs-panel ui-corner-bottom ui-widget-content" id="tabs-4" aria-labelledby="ui-id-4" role="tabpanel" aria-hidden="true" style="display: none;">
                                        Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        @if (isset($banner_bawah))
                        @if (count($banner_bawah) > 0)
                        <div id="img_card" class="card text-white click-col" style="min-height: 0px"
                        {{-- style="background-image:url('Image/{{ $banner_bawah[0]->image }}');  background-size:contain !important;" --}}
                        >
                        <a href="https://forms.gle/yHh3WpMyHRduPL6W6">
                            <img src="Image/{{ $banner_bawah[0]->image }}" alt="" height="auto">
                        </a>
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
                                                {{-- <div class="testimonial" style="background-image:url('Image/{{ $banner_bawah[$i]->image }}');
                                                    border-radius: 20px !important;
                                                    background-size: 120%;
                                                    background-position: center;
                                                    background-repeat: no-repeat;
                                                    height:200px;">
                                                    <a href="#"></a>
                                                </div> --}}
                                                <div id="img_card" class="card text-white click-col" style="min-height: 0px;">
                                                    <a href="https://forms.gle/yHh3WpMyHRduPL6W6">
                                                        <img src="Image/{{ $banner_bawah[$i]->image}}" alt="">
                                                    </a>
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
        </div>
    </div>
    <div class="section border-top-0" style="background-color:#ffffff; padding-bottom: 0px">
        <div class="container text-center">
            <img src="{{ asset('cariin-kerja.webp') }}" alt="">
        </div>
        <div class="container">
        <div class="row p-4">
            @foreach($loker as $key => $value)
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
        <div class="d-flex flex-row-reverse mb-2 mr-4">
            <a href="/loker" class="badge badge-primary">Lebih Banyak <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgb(255, 255, 255);transform: ;msFilter:;"><path d="m10.998 16 5-4-5-4v3h-9v2h9z"></path><path d="M12.999 2.999a8.938 8.938 0 0 0-6.364 2.637L8.049 7.05c1.322-1.322 3.08-2.051 4.95-2.051s3.628.729 4.95 2.051S20 10.13 20 12s-.729 3.628-2.051 4.95-3.08 2.051-4.95 2.051-3.628-.729-4.95-2.051l-1.414 1.414c1.699 1.7 3.959 2.637 6.364 2.637s4.665-.937 6.364-2.637C21.063 16.665 22 14.405 22 12s-.937-4.665-2.637-6.364a8.938 8.938 0 0 0-6.364-2.637z"></path></svg></a>
        </div>
        </div>
    </div>
    <div id="Testimonial" class="section border-top-0" style="background-color:#FFA600; padding-bottom: 30px">
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
                        {{-- <div class="owl-item active" style="width: 418.667px; margin-right: 20px;">
                            <div class="oc-item">
                                <div class="testimonial"
                                    style="background-color: #ffffffa1 !important; border-radius: 9px !important">
                                    <div class="testi-image">
                                        <a href="#"><img src="" alt="Customer Testimonails"></a>
                                    </div>
                                    <div class="testi-content">
                                        <p>$t->review</p>
                                        <div class="testi-meta">
                                            $t->name
                                            <span>XYZ Inc.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
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

    <div class="section border-top-0 mb-6 mt-4">
        <div class="container text-center">
            {{-- <div class="heading-block center">
                <h2>Partner</h2>
            </div> --}}
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
            <img src="{{ asset('gambar-footer-03.png') }}" alt="">
        </div>
    </div>
        <div class="section border-top-0 mb-6 mt-4">
            <div class="container text-center">
                <div class="logo-perusahaan">
                    @if($logo_perusahaan)
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
                    @endif
                </div>
            </div>
        </div>
    </div>
    <textarea name="" id="kelas" cols="30" rows="10" hidden>{{ json_encode($o['kelas']) }}</textarea>
</section>
<!-- #content end -->

@include('front.layout.footer')
<script>
    let arrkategori = JSON.parse($('#kelas').val());
    $(document).ready(function() {
        $('#class-upcoming0').dataTable({
            pageLength:6,
            lengthChange:false,
            paging: true,
            ordering: false,
            info: false,
            searching:false,
        });
        $('#class-upcoming1').dataTable({
            pageLength:6,
            lengthChange:false,
            paging: true,
            ordering: false,
            info: false,
            searching:false,
        });
        $('#class-upcoming2').dataTable({
            pageLength:6,
            lengthChange:false,
            paging: true,
            ordering: false,
            info: false,
            searching:false,
        });
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