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

    .ribbon-wrapper {
        width: 85px;
        height: 88px;
        overflow: hidden;
        position: absolute;
        top: -3px;
        right: -3px
    }

    .ribbon {
        font-size: 12px;
        color: #FFF;
        text-transform: uppercase;
        font-family: 'Montserrat Bold', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        letter-spacing: .05em;
        line-height: 30px;
        text-align: center;
        text-shadow: 0 -1px 0 rgba(0, 0, 0, .4);
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        -o-transform: rotate(45deg);
        transform: rotate(45deg);
        position: relative;
        padding: 7px 0;
        right: -20px;
        top: -2px;
        width: 100px;
        height: 35px;
        -webkit-box-shadow: 0 0 3px rgba(0, 0, 0, .3);
        box-shadow: 0 0 3px rgba(0, 0, 0, .3);
        background-color: #007bff;
        background-image: -webkit-linear-gradient(top, #ffffff 45%, #dedede 100%);
        background-image: -o-linear-gradient(top, #ffffff 45%, #dedede 100%);
        background-image: linear-gradient(to bottom, #007bff 45%, #dedede 100%);
        background-repeat: repeat-x;
        filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffdedede', GradientType=0)
    }

    .ribbon:before,
    .ribbon:after {
        content: "";
        border-top: 3px solid #9e9e9e;
        border-left: 3px solid transparent;
        border-right: 3px solid transparent;
        position: absolute;
        bottom: -3px
    }

    .ribbon:before {
        left: 0
    }

    .ribbon:after {
        right: 0
    }

    /*  */
    .select2-container--bootstrap-5 .select2-selection--single {
        border-radius: 20px;
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
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Cari Lowongan</label>
                            <input type="text" name="cari_lowongan" id="cari_lowongan" class="form-control"
                                style="border-radius: 20px;" {{old('cari_lowongan')?old('cari_lowongan'):''}} required>
                            @error('cari_lowongan')
                            <small class="text-danger">Harus Diisi</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Provinsi</label>
                            <select name="provinsi" id="provinsi" class="form-control" onchange="getkabupaten()"
                                required style="border-radius: 20px">
                                <option>Pilih</option>
                                @foreach($provinsi as $key => $v)
                                <option value="{{$v->id}}" {{old('provinsi')==$v->id?'selected':''}}>{{$v->name}}
                                </option>
                                @endforeach
                            </select>
                            @error('provinsi')
                            <small class="text-danger">Harus Diisi</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Kabupaten</label>
                            <select name="kabupaten" id="kabupaten" class="form-control" onchange="getkecamatan()"
                                required>
                                <option>Pilih Provinsi Terlebih Dahulu</option>
                            </select>
                            @error('kabupaten')
                            <small class="text-danger">Harus Diisi</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mr-2">
                        <button class="btn btn-primary mt-3 br-20" id="cari"><svg xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" viewBox="0 0 24 24"
                                style="fill: rgb(255, 255, 255);transform: ;msFilter:;">
                                <path
                                    d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z">
                                </path>
                            </svg></button>
                    </div>
                </div>
                <div class="row mb-2" id="dataloker">
                </div>
                <div id="datalokers" class="text-center"></div>
            </div>
        </div>
    </div>
    <div class="section border-top-0" style="background-color:#ffffff; padding-bottom: 0px">
        <div class="container text-center">
            <img src="{{ asset('GambarV2/BankirAcademy.png') }}" alt="">
        </div>
    </div>
    <div class="section border-top-0 mb-6 mt-4">
        <div class="container text-center">
            <div class="logo-perusahaan">
            </div>
        </div>
    </div>
    </div>
    {{-- <textarea name="" id="kelas" cols="30" rows="10" hidden>{{ json_encode($o['kelas']) }}</textarea> --}}
</section>
<!-- #content end -->

@include('front.layout.footer')
<script>
    var page = 0;
    var load = true;
    $(document).ready(function() {
        $('#provinsi').select2({
            placeholder: 'Input or Select',
            theme: 'bootstrap-5',
            style:'border-radius:20px'
        });
        $('#kabupaten').select2({
            placeholder: 'Input or Select',
            theme: 'bootstrap-5',
        });
        $('#kelurahan').select2({
            placeholder: 'Input or Select',
            theme: 'bootstrap-5',
        });
        $('#kecamatan').select2({
            placeholder: 'Input or Select',
            theme: 'bootstrap-5',
        });
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
        $('#cari').on('click',function () {
            let p =$('#provinsi').val();
            let k =$('#kabupaten').val();
            if (p=='pilih') {
                return false;
            }
            if (k=='pilih') {
                return false;
            }
            page = 0;
            load = true;
            $("#dataloker").html('');
            loadMoreData();
        })
    })
    window.onscroll = function (e)
    {
        if(($(window).scrollTop() + $(window).height()) >= ($(document).height()*(45/100))) {
            loadMoreData();
        }
    }
    
	async function loadMoreData(){
        page++;
        if (!load) {
            return false;
        }
        let myPromise = new Promise(function(resolve, reject) {
    $.ajax(
    {
        url: '?page=' + page,
        type: "get",
        data:{
            provinsi:$('#provinsi').val(),
            kabupaten:$('#kabupaten').val()
        },
        beforeSend: function()
        {
            $('.ajax-load').show();
        }
    })
    .done(function(data)
    {
        if(data.data.data.length<=0){
            load = false;
            return;
        }
        let html = ''
        let now = new Date();
        data.data.data.forEach(e => {
            let js = null;
            if (e.perusahaan) {
                js = JSON.parse(e.perusahaan.image)
            }
            let past = new Date(e.tanggal_awal);
            let diff = new Date(now.getTime()-past.getTime());
            let rentang = diff.getUTCDate()-1;
            let img= e.image?'/image/loker/'+JSON.parse(e.image).url:'kosong';
            let t = e.title.length>23?e.title.substr(0,21):e.title;
            html += '<div class="col-lg-3 mb-4">';
            html += '    <a class="" href="/loker/'+e.id+'/detail">';
            html += '        <div class="card" style="max-height: 500px">';
                if (rentang <=4) {
                    html +='<div class="ribbon-wrapper">';
                    html +='    <div class="ribbon">New</div>';
                    html +='</div>';
                }
            html += '            <div class="card-body">';
            html += '                <small class="text-secondary">Dibutuhkan</small>';
            html += '                <h3 class="text-uppercase" title="'+e.title+'" style="margin: 0px">'+t+'</h3>';
            if (js) {
                html += '                <img class="" src="/image/loker/'+js.url+'" width="100%" style="border-radius: 13px; max-height: 170px" />';
            }else{
                html += '                <img class="" src="/image/loker/'+JSON.parse(e.image).url+'" width="100%" style="border-radius: 13px; max-height: 170px" />';
            }
            // if (e.image) {
            //     html += '                <img src="/image/loker/'+JSON.parse(e.image).url+'" width="100%" style="border-radius: 13px" />';
            // }else{
            //     html += '                <img src="/GambarV2/image-38.png" width="100%" style="border-radius: 13px" />';
            // }
            html += '                <div class="row mt-2">';
            html += '                    <div class="col-lg-12 ">';
            html += '                <div class="form-group m-0 p-2">';
            html += '                    <span><svg class="mr-2" width="16" height="16" viewBox="0 0 18 18" fill="none"';
            html += '                            xmlns="http://www.w3.org/2000/svg">';
            html += '                            <path';
            html += '                                d="M1.875 17.5H18.125M3.125 2.5V17.5M11.875 2.5V17.5M16.875 6.25V17.5M5.625 5.625H6.25M5.625 8.125H6.25M5.625 10.625H6.25M8.75 5.625H9.375M8.75 8.125H9.375M8.75 10.625H9.375M5.625 17.5V14.6875C5.625 14.17 6.045 13.75 6.5625 13.75H8.4375C8.955 13.75 9.375 14.17 9.375 14.6875V17.5M2.5 2.5H12.5M11.875 6.25H17.5M14.375 9.375H14.3817V9.38167H14.375V9.375ZM14.375 11.875H14.3817V11.8817H14.375V11.875ZM14.375 14.375H14.3817V14.3817H14.375V14.375Z"';
            html += '                                stroke="black" stroke-width="1.25" stroke-linecap="round"';
            html += '                                stroke-linejoin="round" />';
            html += '                        </svg>';
            if (js) {
                html +='                        <small>'+e.perusahaan.nama+'</small>';
            }else{
            if (e.nama) {
                html +='                        <small>'+e.nama+'</small>';
            }else{
                html +='                        <small>'+JSON.parse(e.corporate)?JSON.parse(e.corporate).name:'Anugrah Karya'+'</small>';
            }
            }
            html += '                    </span>';
            html += '                </div>';
            html += '                    </div>';
            html += '                    <div class="col-lg-12">';
            html += '                        <hr class="m-0">';
            html += '                    </div>';
            html += '                    <div class="col-lg-5">';
            html += '                        <div class="form-group m-0 p-2">';
            html += '                            <span>';
            html += '                                <svg class="mr-2" width="16" height="16" viewBox="0 0 18 18"';
            html += '                                    fill="none" xmlns="http://www.w3.org/2000/svg">';
            html += '                                    <path';
            html += '                                        d="M0.833008 7.25L9.59217 3.75L18.3513 7.25L9.59217 10.75L0.833008 7.25Z"';
            html += '                                        stroke="#2E2E2E" stroke-width="1.66667"';
            html += '                                        stroke-linejoin="round" />';
            html += '                                    <path';
            html += '                                        d="M18.3511 7.2959V11.1388M4.81445 9.09382V14.278C4.81445 14.278 6.81862 16.2501 9.59195 16.2501C12.3657 16.2501 14.3699 14.278 14.3699 14.278V9.09382"';
            html += '                                        stroke="#2E2E2E" stroke-width="1.66667"';
            html += '                                        stroke-linecap="round" stroke-linejoin="round" />';
            html += '                                </svg>';
            html += '                                S1';
            html += '                            </span>';
            html += '                        </div>';
            html += '                    </div>';
            html += '                    <div class="col-lg-7">';
            html += '                        <div class="form-group m-0 p-2">';
            html += '                            <span>';
            html += '                                <svg class="mr-2" width="16" height="16" viewBox="0 0 18 18"';
            html += '                                    fill="none" xmlns="http://www.w3.org/2000/svg">';
            html += '                                    <path';
            html += '                                        d="M7.30248 7.41754C6.68717 7.41754 6.08566 7.23507 5.57404 6.89322C5.06242 6.55137 4.66367 6.06548 4.42819 5.497C4.19272 4.92851 4.13111 4.30297 4.25115 3.69948C4.3712 3.09598 4.6675 2.54163 5.1026 2.10654C5.53769 1.67144 6.09204 1.37514 6.69554 1.25509C7.29903 1.13505 7.92457 1.19666 8.49306 1.43213C9.06154 1.66761 9.54743 2.06636 9.88928 2.57798C10.2311 3.0896 10.4136 3.69111 10.4136 4.30643C10.4136 5.13154 10.0858 5.92287 9.50237 6.50631C8.91893 7.08976 8.1276 7.41754 7.30248 7.41754ZM7.30248 2.11976C6.86297 2.11976 6.43333 2.25009 6.06788 2.49427C5.70244 2.73845 5.41761 3.08552 5.24942 3.49157C5.08122 3.89763 5.03722 4.34445 5.12296 4.77552C5.20871 5.20658 5.42035 5.60255 5.73114 5.91333C6.04192 6.22411 6.43788 6.43576 6.86895 6.5215C7.30002 6.60725 7.74683 6.56324 8.15289 6.39505C8.55895 6.22685 8.90601 5.94202 9.15019 5.57658C9.39438 5.21114 9.52471 4.7815 9.52471 4.34198C9.52471 4.05015 9.46723 3.76119 9.35555 3.49157C9.24387 3.22196 9.08018 2.97698 8.87383 2.77063C8.66748 2.56428 8.4225 2.40059 8.15289 2.28892C7.88328 2.17724 7.59431 2.11976 7.30248 2.11976ZM9.77804 7.95531C7.37289 7.41411 4.85672 7.67478 2.6136 8.69754C2.3051 8.8449 2.04482 9.07686 1.86306 9.36642C1.6813 9.65598 1.58554 9.99122 1.58693 10.3331V12.9775C1.58693 13.0359 1.59842 13.0937 1.62076 13.1476C1.6431 13.2015 1.67583 13.2505 1.7171 13.2918C1.75837 13.3331 1.80737 13.3658 1.86129 13.3882C1.91521 13.4105 1.97301 13.422 2.03137 13.422C2.08974 13.422 2.14753 13.4105 2.20145 13.3882C2.25538 13.3658 2.30437 13.3331 2.34564 13.2918C2.38691 13.2505 2.41965 13.2015 2.44199 13.1476C2.46432 13.0937 2.47582 13.0359 2.47582 12.9775V10.3331C2.47195 10.1601 2.51867 9.98968 2.61025 9.84284C2.70184 9.69599 2.83429 9.57907 2.99137 9.50643C4.3426 8.88252 5.81418 8.56241 7.30248 8.56865C8.1364 8.56758 8.96746 8.66606 9.77804 8.86198V7.95531ZM9.84026 12.182H12.5692V12.8042H9.84026V12.182Z"';
            html += '                                        fill="black" />';
            html += '                                    <path';
            html += '                                        d="M14.7424 9.54211H12.4447V10.431H14.298V14.151H8.00022V10.431H10.8002V10.6177C10.8002 10.7355 10.847 10.8486 10.9304 10.9319C11.0137 11.0153 11.1268 11.0621 11.2447 11.0621C11.3625 11.0621 11.4756 11.0153 11.5589 10.9319C11.6423 10.8486 11.6891 10.7355 11.6891 10.6177V8.88878C11.6891 8.77091 11.6423 8.65786 11.5589 8.57451C11.4756 8.49116 11.3625 8.44434 11.2447 8.44434C11.1268 8.44434 11.0137 8.49116 10.9304 8.57451C10.847 8.65786 10.8002 8.77091 10.8002 8.88878V9.54211H7.55577C7.4379 9.54211 7.32485 9.58894 7.2415 9.67229C7.15815 9.75564 7.11133 9.86868 7.11133 9.98656V14.5954C7.11133 14.7133 7.15815 14.8264 7.2415 14.9097C7.32485 14.9931 7.4379 15.0399 7.55577 15.0399H14.7424C14.8603 15.0399 14.9734 14.9931 15.0567 14.9097C15.1401 14.8264 15.1869 14.7133 15.1869 14.5954V9.98656C15.1869 9.86868 15.1401 9.75564 15.0567 9.67229C14.9734 9.58894 14.8603 9.54211 14.7424 9.54211Z"';
            html += '                                        fill="black" />';
            html += '                                </svg>';
            html += '                                Full Time';
            html += '                            </span>';
            html += '                        </div>';
            html += '                    </div>';
            html += '                    <div class="col-lg-12">';
            html += '                        <hr class="m-0">';
            html += '                    </div>';
            html += '                    <div class="col-lg-12">';
            html += '                        <div class="form-group m-0 p-2">';
            html += '                            <span>';
            html += '                                <svg class="mr-2" width="16" height="16" viewBox="0 0 18 18"';
            html += '                                    fill="none" xmlns="http://www.w3.org/2000/svg">';
            html += '                                    <path';
            html += '                                        d="M13.2812 6.90625C13.2812 5.63818 12.7775 4.42205 11.8809 3.5254C10.9842 2.62874 9.76807 2.125 8.5 2.125C7.23193 2.125 6.0158 2.62874 5.11915 3.5254C4.22249 4.42205 3.71875 5.63818 3.71875 6.90625C3.71875 8.86762 5.28806 11.424 8.5 14.4861C11.7119 11.424 13.2812 8.86762 13.2812 6.90625ZM8.5 15.9375C4.60381 12.3962 2.65625 9.38506 2.65625 6.90625C2.65625 5.35639 3.27193 3.87001 4.36784 2.77409C5.46376 1.67818 6.95014 1.0625 8.5 1.0625C10.0499 1.0625 11.5362 1.67818 12.6322 2.77409C13.7281 3.87001 14.3438 5.35639 14.3438 6.90625C14.3438 9.38506 12.3962 12.3962 8.5 15.9375Z"';
            html += '                                        fill="black" />';
            html += '                                    <path';
            html += '                                        d="M8.5 7.4375C8.78179 7.4375 9.05204 7.32556 9.2513 7.1263C9.45056 6.92704 9.5625 6.65679 9.5625 6.375C9.5625 6.09321 9.45056 5.82296 9.2513 5.6237C9.05204 5.42444 8.78179 5.3125 8.5 5.3125C8.21821 5.3125 7.94796 5.42444 7.7487 5.6237C7.54944 5.82296 7.4375 6.09321 7.4375 6.375C7.4375 6.65679 7.54944 6.92704 7.7487 7.1263C7.94796 7.32556 8.21821 7.4375 8.5 7.4375ZM8.5 8.5C7.93641 8.5 7.39591 8.27612 6.9974 7.8776C6.59888 7.47909 6.375 6.93859 6.375 6.375C6.375 5.81141 6.59888 5.27091 6.9974 4.8724C7.39591 4.47388 7.93641 4.25 8.5 4.25C9.06359 4.25 9.60409 4.47388 10.0026 4.8724C10.4011 5.27091 10.625 5.81141 10.625 6.375C10.625 6.93859 10.4011 7.47909 10.0026 7.8776C9.60409 8.27612 9.06359 8.5 8.5 8.5ZM14.2375 11.6875L15.9375 15.9375H11.1562V14.875H5.84375V15.9375H1.0625L2.7625 11.6875H14.2375ZM13.0932 11.6875H3.90681L2.63181 14.875H14.3682L13.0932 11.6875Z"';
            html += '                                        fill="black" />';
            html += '                                </svg>';
            if (js) {
                html += '                                '+e.perusahaan.kabupaten_name?e.perusahaan.kabupaten_name:'';
            }else{
                html += '                                '+e.kabupaten_name?e.kabupaten_name:'';
            }
            html += '                            </span>';
            html += '                        </div>';
            html += '                    </div>';
            html += '                    <hr>';
            html += '                </div>';
            html += '            </div>';
            html += '        </div>';
            html += '    </a>';
            html += '</div>';
        });
        $("#dataloker").append(html);
        page++;
    })
    .fail(function(jqXHR, ajaxOptions, thrownError)
    {
          alert('server not responding...');
    });
        });
	}
    function getkabupaten(){
        let v = $('#provinsi').val();
        $.ajax({
                type:'GET',
                url:'/admin/loker/getkabupaten/'+v,
                data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {
                    let t = '';
                    if (data) {
                        t+='<option>Pilih</option>';
                        data.forEach(el => {
                            t+='<option value='+el.id+'>'+el.name+'</option>';
                        });
                    }
                    $('#kabupaten').html(t);
                }
            });
    }
    function getkecamatan(){
        let v = $('#kabupaten').val();
        $.ajax({
                type:'GET',
                url:'/admin/loker/getkecamatan/'+v,
                data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {
                    let t = '';
                    if (data) {
                        t+='<option>Pilih</option>';
                        data.forEach(el => {
                            t+='<option value='+el.id+'>'+el.name+'</option>';
                        });
                    }
                    $('#kecamatan').html(t);
                }
            });
    }
    function getkelurahan(){
        let v = $('#kecamatan').val();
        $.ajax({
                type:'GET',
                url:'/admin/loker/getkelurahan/'+v,
                data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {
                    let t = '';
                    if (data) {
                        t+='<option>Pilih</option>';
                        data.forEach(el => {
                            t+='<option value='+el.id+'>'+el.name+'</option>';
                        });
                    }
                    $('#kelurahan').html(t);
                }
            });
    }
</script>