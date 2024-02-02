@include('front.layout.head')
@include('front.layout.topbar')
@include(env('CUSTOM_HEADER', 'front.layout.header'))
<style>
    .text-white {
        color: white;
    }
</style>
<section class="content">
    <div class="" style="background-image: url(/GambarV2/maskgroup.jpg); background-position: center; width: 100%;">
        <div class="container">
            <div class="d-flex">
                <a href="{{ URL::previous() }}" class="mt-4 mr-2"><svg class="m-2" width="14" height="14"
                        viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 6.125H3.35125L8.2425 1.23375L7 0L0 7L7 14L8.23375 12.7663L3.35125 7.875H14V6.125Z"
                            fill="white" />
                    </svg>
                    <b class="text-white">Beranda</b>
                </a>
                <a href="/list-class" class="mt-4 mr-2"><svg class="m-2" width="8" height="14" viewBox="0 0 8 14"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 1.25152L1.22022 0L8 7L1.21337 14L0 12.7485L5.57326 7L0 1.25152Z" fill="white" />
                    </svg>
                    <b class="text-white">Semua Kategori</b>
                </a>
                <a href="#" class="mt-4 mr-2"><svg class="m-2" width="8" height="14" viewBox="0 0 8 14" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 1.25152L1.22022 0L8 7L1.21337 14L0 12.7485L5.57326 7L0 1.25152Z" fill="white" />
                    </svg>
                    <b class="text-white">{{$title}}</b>
                </a>
                <a href="" class="mt-4 ml-auto"><b class="text-white mr-2">Bagikan</b> <svg width="14" height="16"
                        viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M11.6667 11.3092C11.0756 11.3092 10.5467 11.5502 10.1422 11.9277L4.59667 8.59438C4.63556 8.40964 4.66667 8.2249 4.66667 8.03213C4.66667 7.83936 4.63556 7.65462 4.59667 7.46988L10.08 4.16867C10.5 4.57028 11.0522 4.81928 11.6667 4.81928C12.9578 4.81928 14 3.74297 14 2.40964C14 1.07631 12.9578 0 11.6667 0C10.3756 0 9.33333 1.07631 9.33333 2.40964C9.33333 2.60241 9.36444 2.78715 9.40333 2.97189L3.92 6.27309C3.5 5.87149 2.94778 5.62249 2.33333 5.62249C1.04222 5.62249 0 6.69879 0 8.03213C0 9.36546 1.04222 10.4418 2.33333 10.4418C2.94778 10.4418 3.5 10.1928 3.92 9.79116L9.45778 13.1325C9.41889 13.3012 9.39556 13.4779 9.39556 13.6546C9.39556 14.9478 10.4144 16 11.6667 16C12.9189 16 13.9378 14.9478 13.9378 13.6546C13.9378 12.3614 12.9189 11.3092 11.6667 11.3092Z"
                            fill="white" />
                    </svg>
                </a>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <button class="btn btn-success mt-4 br-20">{{$class->category}}</button>
                    <h1 class="text-white">{{$title}}</h1>
                    {{-- <div class="bintang text-white"><b>4.5</b> <svg width="18" height="16" viewBox="0 0 18 16"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M4.09812 15.6437L5.42894 9.99138L0.965576 6.18966L6.86213 5.68678L9.15523 0.356323L11.4483 5.68678L17.3449 6.18966L12.8815 9.99138L14.2123 15.6437L9.15523 12.6466L4.09812 15.6437Z"
                                fill="#FF9900" />
                        </svg>
                    </div> --}}
                    <div class="d-flex">
                        <div class="form-group mr-auto">
                            <label for="" class="m-0 text-white text-capitalize">Speaker</label>
                            <p class="m-0 text-white text-capitalize"><b>{{$class->instructor_list[0]->name}}</b></p>
                        </div>
                        <div class="form-group mr-auto">
                            <label for="" class="m-0 text-white text-capitalize">Kategori</label>
                            @if($class->tags)
                            <p class="m-0 text-white text-capitalize"><b>{{implode(', ',json_decode($class->tags))}}</b>
                            </p>
                            @endif
                        </div>
                        <div class="form-group mr-auto">
                            <label for="" class="m-0 text-white text-capitalize">Tanggal Kelas</label>
                            <p class="m-0 text-white text-capitalize">
                                <b>{{\Carbon\Carbon::parse($class->date_start)->format('d-F-Y')}}</b>
                            </p>
                        </div>
                    </div>
                    <span class="text-white">
                        @if($class->sub_category)
                        Sub Kategori : <b>{{implode(', ',json_decode($class->sub_category))}}</b>
                        @endif
                    </span>
                </div>
                <div class="col-lg-4">
                    <div class="card mt-4"
                        style="border-top-left-radius: 10px; border-top-right-radius:10px; border-color: transparent;">
                        <div class="card-body p-2">
                            <iframe width="100%" height="90%"
                                src="https://www.youtube.com/embed/Dt1PGv-toHU?si=G_8_3vfrY9mrBYaP">
                            </iframe>
                            <h5 class="m-2">{{$title}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="mt-4"></div>
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-primary mb-2">Deskripsi</h3>
                        {!!$class->content!!}
                    </div>
                </div>
                <div class="mt-4"></div>
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-primary mb-2">Point Pelatihan</h3>
                        <div class="row">
                            @foreach($class->event_list as $key => $v)
                            <div class="col-lg-6">
                                <svg class="mr-2" width="13" height="10" viewBox="0 0 13 10" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M4.54601 10L0 5.25988L1.1365 4.07484L4.54601 7.62994L11.8635 0L13 1.18503L4.54601 10Z"
                                        fill="black" />
                                </svg>
                                {{$v->description}}
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                @if($class->pricing)
                <div class="d-flex">
                    @if($class->pricing->promo)
                    <h3 class="ml-3">
                        <b>Rp.
                            {{number_format($class->pricing->promo_price)}}</b>
                    </h3>
                    <span class="ml-2" style="text-decoration: line-through; color:grey">Rp
                        {{number_format($class->pricing->price)}}</span>
                    <span class="ml-2" style="color:grey">{{($class->pricing->promo_price/$class->pricing->price)*100}}
                        %</span>
                    @else
                    <h3 class="ml-3">
                        <b>Rp.
                            {{number_format($class->pricing->price)}}</b>
                    </h3>
                    @endif
                </div>
                @else
                <h3 class="ml-3">
                    <b>Rp 0</b>
                </h3>
                @endif
                {{-- Bila Date End Lebih Kecil Dari Sekarang --}}
                @if(!$class->date_end)
                <button class="button button-circle btn-block text-center" disabled>Kelas Belum Tersedia</button>
                @elseif(\Carbon\Carbon::parse($class->date_end) < \Carbon\Carbon::now()) <button
                    class="button button-circle btn-block text-center" disabled>Kelas Sudah
                    Penuh</button>
                    @else
                    @if(!$class->is_open)
                    <button class="button button-circle btn-block text-center" disabled>Kelas Sudah
                        Penuh</button>
                    @else
                    <form id="orderForm" action="{{ '/order' }}" method="POST">
                        @csrf
                        <input type="text" id="class_id" name="class_id" value="{{ $class->id }}" hidden>
                        <label hidden for="">Kode Referral ( optional )</label>
                        <input hidden type="text" id="kode_reff" name="kode_reff" class="form-control">
                        @auth
                        <button class="btn btn-primary btn-lg btn-block">Daftar Kelas Ini</button>
                        @else
                        <span class="button button-circle btn-block text-center" data-toggle="modal"
                            data-target="#modelId" data-backdrop="static" data-keyboard="false">Order
                            sekarang</span>
                        @endauth
                    </form>
                    @endif
                    @endif
                    <div class="tambahan">
                        <p class="mt-4 mb-2"><b>Bonus Tambahan :</b></p>
                        <p class="m-0"><svg width="12" height="11" viewBox="0 0 12 11" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4.14545 11L3.10909 9.32381L1.14545 8.90476L1.33636 6.96667L0 5.5L1.33636 4.03333L1.14545 2.09524L3.10909 1.67619L4.14545 0L6 0.759524L7.85455 0L8.89091 1.67619L10.8545 2.09524L10.6636 4.03333L12 5.5L10.6636 6.96667L10.8545 8.90476L8.89091 9.32381L7.85455 11L6 10.2405L4.14545 11ZM5.42727 7.35952L8.50909 4.4L7.74545 3.64048L5.42727 5.86667L4.25455 4.76667L3.49091 5.5L5.42727 7.35952Z"
                                    fill="#065FFF" />
                            </svg>
                            Free Sertifikat
                        </p>
                        <p class="m-0"><svg width="12" height="11" viewBox="0 0 12 11" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4.14545 11L3.10909 9.32381L1.14545 8.90476L1.33636 6.96667L0 5.5L1.33636 4.03333L1.14545 2.09524L3.10909 1.67619L4.14545 0L6 0.759524L7.85455 0L8.89091 1.67619L10.8545 2.09524L10.6636 4.03333L12 5.5L10.6636 6.96667L10.8545 8.90476L8.89091 9.32381L7.85455 11L6 10.2405L4.14545 11ZM5.42727 7.35952L8.50909 4.4L7.74545 3.64048L5.42727 5.86667L4.25455 4.76667L3.49091 5.5L5.42727 7.35952Z"
                                    fill="#065FFF" />
                            </svg>
                            Online Free konsultasi
                        </p>
                        <p class="m-0"><svg width="12" height="11" viewBox="0 0 12 11" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4.14545 11L3.10909 9.32381L1.14545 8.90476L1.33636 6.96667L0 5.5L1.33636 4.03333L1.14545 2.09524L3.10909 1.67619L4.14545 0L6 0.759524L7.85455 0L8.89091 1.67619L10.8545 2.09524L10.6636 4.03333L12 5.5L10.6636 6.96667L10.8545 8.90476L8.89091 9.32381L7.85455 11L6 10.2405L4.14545 11ZM5.42727 7.35952L8.50909 4.4L7.74545 3.64048L5.42727 5.86667L4.25455 4.76667L3.49091 5.5L5.42727 7.35952Z"
                                    fill="#065FFF" />
                            </svg>
                            Materi Pelatihan & Form pendukung
                        </p>
                    </div>
            </div>
        </div>
        <hr class="mt-5 mb-5">
        <h3>Kelas Terpopuler</h3>
        {{-- Kelas Populer --}}
        <div id="sld3" class="mt-4">
            @foreach($kelas_populer as $key => $val)
            <div>
                <div class="card mr-2">
                    <div class="card-body br-10" style="padding: 1px;">
                        <img src="{{asset($val->image)}}" alt="" width="100%" class="br-10">
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
                        <h6 class="mb-2">
                            {{strlen($val->title)>=90?substr($val->title,0,87).' ...':$val->title}}
                        </h6>
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
    </div>
</section>
<script>
    $(document).ready(function () {
        $('#sld3').slick({
            centerMode: false,
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: 3,
            slidesToScroll: 3,
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
    })
</script>
@include(env('CUSTOM_FOOTER', 'front.layout.footer'))