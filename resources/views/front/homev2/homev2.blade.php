@include('front.layout.head')
@include('front.layout.topbar')
@include(env('CUSTOM_HEADER', 'front.layout.header'))
<section id="content">
    <div class="container mt-4">
        <div class="d-flex">
            <div class="mr-2 w-100">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white br-1" id="basic-addon1">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12.5 11H11.71L11.43 10.73C12.4439 9.55402 13.0011 8.0527 13 6.5C13 5.21442 12.6188 3.95772 11.9046 2.8888C11.1903 1.81988 10.1752 0.986756 8.98744 0.494786C7.79973 0.00281635 6.49279 -0.125905 5.23192 0.124899C3.97104 0.375703 2.81285 0.994767 1.90381 1.90381C0.994767 2.81285 0.375703 3.97104 0.124899 5.23192C-0.125905 6.49279 0.00281635 7.79973 0.494786 8.98744C0.986756 10.1752 1.81988 11.1903 2.8888 11.9046C3.95772 12.6188 5.21442 13 6.5 13C8.11 13 9.59 12.41 10.73 11.43L11 11.71V12.5L16 17.49L17.49 16L12.5 11ZM6.5 11C4.01 11 2 8.99 2 6.5C2 4.01 4.01 2 6.5 2C8.99 2 11 4.01 11 6.5C11 8.99 8.99 11 6.5 11Z"
                                    fill="#005CFF" />
                            </svg>
                        </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Kamu mau upgrade skill apa hari ini?"
                        aria-label="Username" aria-describedby="basic-addon1"
                        style="border-left-width: 0px; border-radius: 15px; border-top-left-radius: 0px; border-bottom-left-radius: 0px;">
                </div>
            </div>
            <div class="">
                <button class="btn btn-primary br-1 brn-block">Telusuri</button>
            </div>
        </div>
        <div id="sld1">
            @foreach($banner_slide as $key => $va)
            <div>
                <a href="{{$va->link}}">
                    <img class="d-block w-100" src="/Image/{{$va->image}}" alt="First slide">
                </a>
            </div>
            @endforeach
        </div>
        <h3 class="text-blue m-0">Kategori Terpopuler</h3>
        <div id="page-menu" class="no-sticky">
            <div id="page-menu-wrap" style="background-color: white">
                <div class="container">
                    <div class="page-menu-row">
                        <nav class="page-menu-nav">
                            <ul class="page-menu-container">
                                <li class="page-menu-item">
                                    <a onclick="loadData()" class="active " id="a_cate_semua">
                                        <div class="d-flex align-items-center">
                                            <svg width="16" height="16" viewBox="0 0 18 18" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M5.4 12.6H16.2V9.9H13.905C13.59 10.455 13.155 10.8939 12.6 11.2167C12.045 11.5395 11.445 11.7006 10.8 11.7C10.17 11.7 9.5775 11.5389 9.0225 11.2167C8.4675 10.8945 8.025 10.4556 7.695 9.9H5.4V12.6ZM10.8 9.9C11.31 9.9 11.7375 9.7239 12.0825 9.3717C12.4275 9.0195 12.6 8.5956 12.6 8.1H16.2V1.8H5.4V8.1H9C9 8.595 9.1764 9.0189 9.5292 9.3717C9.882 9.7245 10.3056 9.9006 10.8 9.9ZM5.4 14.4C4.905 14.4 4.4814 14.2239 4.1292 13.8717C3.777 13.5195 3.6006 13.0956 3.6 12.6V1.8C3.6 1.305 3.7764 0.8814 4.1292 0.5292C4.482 0.177 4.9056 0.0006 5.4 0H16.2C16.695 0 17.1189 0.1764 17.4717 0.5292C17.8245 0.882 18.0006 1.3056 18 1.8V12.6C18 13.095 17.8239 13.5189 17.4717 13.8717C17.1195 14.2245 16.6956 14.4006 16.2 14.4H5.4ZM1.8 18C1.305 18 0.8814 17.8239 0.5292 17.4717C0.177 17.1195 0.0006 16.6956 0 16.2V3.6H1.8V16.2H14.4V18H1.8Z"
                                                    fill="white" class="" id="p_cate_semua" />
                                            </svg>
                                            <label for="" class="text-white m-0 ml-1 " id="l_cate_semua">Semua</label>
                                        </div>
                                    </a>
                                </li>
                                @foreach($categori as $key => $value)
                                <li class="page-menu-item">
                                    <a onclick="loadData('{{str_replace(' ','_',$value)}}')" class=""
                                        id="a_cate_{{str_replace(' ','_',$value)}}">
                                        <div class="d-flex align-items-center">
                                            <svg width="16" height="16" viewBox="0 0 18 18" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M5.4 12.6H16.2V9.9H13.905C13.59 10.455 13.155 10.8939 12.6 11.2167C12.045 11.5395 11.445 11.7006 10.8 11.7C10.17 11.7 9.5775 11.5389 9.0225 11.2167C8.4675 10.8945 8.025 10.4556 7.695 9.9H5.4V12.6ZM10.8 9.9C11.31 9.9 11.7375 9.7239 12.0825 9.3717C12.4275 9.0195 12.6 8.5956 12.6 8.1H16.2V1.8H5.4V8.1H9C9 8.595 9.1764 9.0189 9.5292 9.3717C9.882 9.7245 10.3056 9.9006 10.8 9.9ZM5.4 14.4C4.905 14.4 4.4814 14.2239 4.1292 13.8717C3.777 13.5195 3.6006 13.0956 3.6 12.6V1.8C3.6 1.305 3.7764 0.8814 4.1292 0.5292C4.482 0.177 4.9056 0.0006 5.4 0H16.2C16.695 0 17.1189 0.1764 17.4717 0.5292C17.8245 0.882 18.0006 1.3056 18 1.8V12.6C18 13.095 17.8239 13.5189 17.4717 13.8717C17.1195 14.2245 16.6956 14.4006 16.2 14.4H5.4ZM1.8 18C1.305 18 0.8814 17.8239 0.5292 17.4717C0.177 17.1195 0.0006 16.6956 0 16.2V3.6H1.8V16.2H14.4V18H1.8Z"
                                                    fill="black" id="p_cate_{{str_replace(' ','_',$value)}}" />
                                            </svg>
                                            <label for="" class="m-0 ml-1"
                                                id="l_cate_{{str_replace(' ','_',$value)}}">{{$value}}</label>
                                        </div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="content" class="container">
    {{-- Kelas --}}
    <div class="row mt-4" id="listkelas">
        {{-- --}}
    </div>
    <h3 class="text-blue m-0">Kelas Terpopuler</h3>
    <hr style="4px solid rgba(0, 0, 0, 0.1)">
    {{-- Kelas Populer --}}
    <div class="row mt-4">
        @foreach($kelas_populer as $key => $val)
        <div class="col-lg-3 mb-2" style="max-height: 390px">
            <div class="card">
                <div class="card-body" style="padding: 1px; background-color: gold">
                    <img src="{{asset($val->image)}}" alt="" width="100%">
                </div>
            </div>
            <div class="d-flex align-items-center ml-2">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M0.605225 5.68681C0.605225 4.48076 0.605225 3.87837 0.979957 3.50364C1.35469 3.12891 1.95707 3.12891 3.16312 3.12891H10.8368C12.0429 3.12891 12.6453 3.12891 13.02 3.50364C13.3947 3.87837 13.3947 4.48076 13.3947 5.68681C13.3947 5.988 13.3947 6.13892 13.3014 6.23292C13.2074 6.32628 13.0558 6.32628 12.7552 6.32628H1.2447C0.943507 6.32628 0.792591 6.32628 0.698588 6.23292C0.605225 6.13892 0.605225 5.98736 0.605225 5.68681ZM0.605225 11.4421C0.605225 12.6481 0.605225 13.2505 0.979957 13.6252C1.35469 14 1.95707 14 3.16312 14H10.8368C12.0429 14 12.6453 14 13.02 13.6252C13.3947 13.2505 13.3947 12.6481 13.3947 11.4421V8.24471C13.3947 7.94351 13.3947 7.7926 13.3014 7.69859C13.2074 7.60523 13.0558 7.60523 12.7552 7.60523H1.2447C0.943507 7.60523 0.792591 7.60523 0.698588 7.69859C0.605225 7.7926 0.605225 7.94415 0.605225 8.24471V11.4421Z"
                        fill="#005CFF" />
                    <path d="M3.80261 1.84998V3.7684M10.1974 1.84998V3.7684" stroke="#005CFF" stroke-width="2"
                        stroke-linecap="round" />
                </svg>
                <p for="" class="text-capitalize text-blue m-0 ml-1">
                    {{\Carbon\Carbon::parse($val->date_end)->format('d-m-Y')}}</p>
            </div>
            <div class="title text-uppercase ml-1">
                <a href="/class/{{$val->unique_id}}/{{str_replace('/','-',$val->title)}}">
                    <h4 class="mb-2">
                        {{strlen($val->title)>=30?substr($val->title,0,27).' ...':$val->title}}
                    </h4>
                </a>
            </div>
            <div class="author text-uppercase ml-1">
                <a href="/profile-instructor/{{$val->instructor_list[0]->id}}/{{$val->instructor_list[0]->name}}"
                    class="mb-2">
                    {{$val->instructor_list[0]->name}}
                </a>
            </div>
            {{-- <div class="star text-uppercase ml-1 ">
                <div class="d-flex align-items-center">
                    <h4 class="m-0 mr-2">4.5</h4>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-star"
                        viewBox="0 0 16 16">
                        <path
                            d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z" />
                    </svg>
                </div>
            </div> --}}
            <div class="price text-uppercase ml-1">
                <h3 class="mb-2">
                    @if($val->pricing)
                    @if($val->pricing->promo)
                    Rp. {{number_format($val->pricing->price - $val->pricing->promo_price)}}
                    @else
                    Rp. {{number_format($val->pricing->price)}}
                    @endif
                    @else
                    -
                    @endif
                </h3>
            </div>
        </div>
        @endforeach
    </div>
    <div id="sld2">
        @foreach($banner_bawah as $key => $v)
        <div class="mr-4">
            <a href="{{$v->link}}">
                <img class="d-block w-100" src="/Image/{{$v->image}}" alt="First slide">
            </a>
        </div>
        @endforeach
    </div>
    <img src="/GambarV2/image.png" alt="" width="100%">
    {{-- lowongan kerja loker --}}
    <div id="sld3" class="mt-4">
        @foreach($loker as $key => $value)
        <div>
            <a href="/loker/{{$value->id}}/detail">
                <div class="card mr-2">
                    <div class="card-body p-2" style="font-size: 12px">
                        <p for="" class="text-blue m-0">Dibutuhkan</p>
                        <p class="m-0" style="font-size: 16px;font-weight: bold">{{substr($value->title,0,26)}}</p>
                        <p class="text-secondary m-0">
                            @if($value->nama){{$value->nama}}
                            @else{{json_decode($value->corporate)?json_decode($value->corporate)->name:'Anugrah Karya'}}
                            @endif
                        </p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    <h3 class="text-blue mt-4">Testimonial</h3>
    <div id="sld4" class="">
        @foreach($testimoni as $key => $value)
        <div class="card mr-2" style="">
            <div class="card-body" style="font-size: 10px; height: 202px;">
                <h3 class="text-blue m-0">"</h3>
                <p class="m-0" style="font-size: 12px;font-weight: bold">
                    {{strlen($value->review)>=230?substr($value->review,0,230):$value->review}}</p> {{-- maksimal 230
                huruf --}}
                <div class="d-flex align-items-center" style="position: absolute; bottom: 10px">
                    <span
                        class="button button-mini button-circle button-blue text-uppercase">{{substr($value->name,0,2)}}</span>
                    <p class="m-0 text-capitalize text-bllue" style="font-size: 12px; font-weight: 500">
                        {{strlen($value->name)>=12?substr($value->name,0,12). ' ...':$value->name}}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="end mt-4"></div>
</section>
@include('front.layout.footer')
<script>
    let page = 1;
    let category = null;
    $(document).ready(function(){
        $('#sld1').slick({
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            slidesToScroll: 1,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
        $('#sld2').slick({
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: 2,
            slidesToScroll: 2,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
        $('#sld3').slick({
            centerMode: false,
            dots: false,
            infinite: true,
            speed: 300,
            slidesToShow: 6,
            slidesToScroll: 1,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 6,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: false
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 6,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: false
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: false
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
        $('#sld4').slick({
            centerMode: true,
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 1,
            variableWidth: false,
            adaptiveHeight: true,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 6,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: false
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 6,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: false
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: false
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
        loadData(null)
    })
    function loadData(cate) {
        if (!cate) {
            cate = null;
        }
        $.get("/?carisearch="+cate+"&page=1", function(data, status){
            if (data.success) {
                const asemua = document.getElementById("a_cate_semua");
                const lsemua = document.getElementById("l_cate_semua");
                asemua.classList.add('active')
                lsemua.classList.add('text-white')
                $('#p_cate_semua').attr('fill','white')
                
                if (category) {
                    const asemua3 = document.getElementById("a_cate_"+category);
                    const lsemua3 = document.getElementById("l_cate_"+category);
                    const psemua3 = document.getElementById("p_cate_"+category);
                    asemua3.classList.remove('active')
                    lsemua3.classList.remove('text-white')
                    psemua3.setAttribute('fill','black') 
                }
                if (cate) {
                    let kategori = cate.replace(' ','_');
                    $('#p_cate_semua').attr('fill','black')
                    asemua.classList.remove('active')
                    lsemua.classList.remove('text-white')
                    
                    const asemua2 = document.getElementById("a_cate_"+kategori);
                    const lsemua2 = document.getElementById("l_cate_"+kategori);
                    const psemua2 = document.getElementById("p_cate_"+kategori);
                    asemua2.classList.add('active')
                    lsemua2.classList.add('text-white')
                    psemua2.setAttribute('fill','white')
                    category = cate;
                }
                console.log(category);
                let h = '';
                data.data.kelas.data.forEach(v => {
                    h +='<div class="col-lg-3 mb-2" style="max-height: 390px">';
                    h +='    <div class="card">';
                    h +='        <div class="card-body" style="padding: 1px; background-color: gold">';
                    h +='            <img src="'+v.image+'" alt="" width="100%" style="max-height:200px;">';
                    h +='        </div>';
                    h +='    </div>';
                    h +='    <div class="d-flex align-items-center ml-2">';
                    h +='        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">';
                    h +='            <path';
                    h +='                d="M0.605225 5.68681C0.605225 4.48076 0.605225 3.87837 0.979957 3.50364C1.35469 3.12891 1.95707 3.12891 3.16312 3.12891H10.8368C12.0429 3.12891 12.6453 3.12891 13.02 3.50364C13.3947 3.87837 13.3947 4.48076 13.3947 5.68681C13.3947 5.988 13.3947 6.13892 13.3014 6.23292C13.2074 6.32628 13.0558 6.32628 12.7552 6.32628H1.2447C0.943507 6.32628 0.792591 6.32628 0.698588 6.23292C0.605225 6.13892 0.605225 5.98736 0.605225 5.68681ZM0.605225 11.4421C0.605225 12.6481 0.605225 13.2505 0.979957 13.6252C1.35469 14 1.95707 14 3.16312 14H10.8368C12.0429 14 12.6453 14 13.02 13.6252C13.3947 13.2505 13.3947 12.6481 13.3947 11.4421V8.24471C13.3947 7.94351 13.3947 7.7926 13.3014 7.69859C13.2074 7.60523 13.0558 7.60523 12.7552 7.60523H1.2447C0.943507 7.60523 0.792591 7.60523 0.698588 7.69859C0.605225 7.7926 0.605225 7.94415 0.605225 8.24471V11.4421Z"';
                    h +='                fill="#005CFF" />';
                    h +='            <path d="M3.80261 1.84998V3.7684M10.1974 1.84998V3.7684" stroke="#005CFF" stroke-width="2"';
                    h +='                stroke-linecap="round" />';
                    h +='        </svg>';
                    h +='        <p for="" class="text-capitalize text-blue m-0 ml-1">'+new Date(v.date_end).toLocaleDateString('id-ID')+'</p>';
                    h +='    </div>';
                    h +='    <div class="title text-uppercase ml-1">';
                    h +='        <a href="/class/'+v.unique_id+'/'+v.title.replace('/', '-')+'">';
                    h +='            <h4 class="mb-2" title="'+v.title+'">';
                    h +='                '+(v.title.length>=30?v.title.substring(0,27)+' ...':v.title)+' {{-- maksimal 60 huruf --}}';
                    h +='            </h4>';
                    h +='        </a>';
                    h +='    </div>';
                    h +='    <div class="author text-uppercase ml-1">';
                    h +='        <a href="/profile-instructor/'+v.instructor_list[0].id+'/'+v.instructor_list[0].name+'" class="mb-2">';
                    h +=            v.instructor_list[0].name;
                    h +='        </a>';
                    h +='    </div>';
                    h +='    <div class="star text-uppercase ml-1 ">';
                    h +='        <div class="d-flex align-items-center">';
                    h +='            <h4 class="m-0 mr-2">4.5</h4>';
                    h +='            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-star"';
                    h +='                viewBox="0 0 16 16">';
                    h +='                <path';
                    h +='                    d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z" />';
                    h +='            </svg>';
                    h +='        </div>';
                    h +='    </div>';
                    h +='    <div class="price text-uppercase ml-1">';
                    h +='        <h3 class="mb-2">';
                        if (v.pricing) {
                            if (v.pricing.promo) {
                                h +='            Rp. '+formatCurrency((v.pricing.price - v.pricing.promo_price).toString());
                            }else{
                                h +='            Rp. '+formatCurrency(v.pricing.price.toString());
                            }
                        }else{
                            h +='-';
                        }
                    h +='        </h3>';
                    h +='    </div>';
                    h +='</div>';
                });
                if (page > 1) {
                    $('#listkelas').append(h);
                }else{
                    $('#listkelas').html(h);
                }
            }
        });
    }
    function formatCurrency(n) {
        let u = 0;
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }
</script>