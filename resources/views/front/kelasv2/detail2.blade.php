@include('front.layout.head')
@include('front.layout.topbar')
@include(env('CUSTOM_HEADER', 'front.layout.headerv3'))
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

{{-- @extends('front.layout.v3.main')
@section('content')
<br>
<br> --}}
<style>
    .text-white {
        color: white;
    }

    .card-body ul {
        margin-left: 15px;
    }
</style>
<section class="content">
    <div class="" style="background-image: url(/GambarV2/maskgroup.jpg); background-position: center; width: 100%;">
        <div class="container">
            <div class="d-flex">
                <a href="{{ URL::previous() }}" class="mt-4 mr-2"><svg class="m-2" width="10" height="10"
                        viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 6.125H3.35125L8.2425 1.23375L7 0L0 7L7 14L8.23375 12.7663L3.35125 7.875H14V6.125Z"
                            fill="white" />
                    </svg>
                    <b class="text-white" style="font-size: 12px;">Beranda</b>
                </a>
                <a href="/list-class" class="mt-4 mr-2"><svg class="m-2" width="10" height="10" viewBox="0 0 8 14"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 1.25152L1.22022 0L8 7L1.21337 14L0 12.7485L5.57326 7L0 1.25152Z" fill="white" />
                    </svg>
                    <b class="text-white" style="font-size: 12px;">Semua Kategori</b>
                </a>
                <a href="#" class="mt-4 mr-2"><svg class="m-2" width="10" height="10" viewBox="0 0 8 14" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 1.25152L1.22022 0L8 7L1.21337 14L0 12.7485L5.57326 7L0 1.25152Z" fill="white" />
                    </svg>
                    <b class="text-white" style="font-size: 12px;">{{$title}}</b>
                </a>
                <a href="" class="mt-4 ml-auto"><b class="text-white mr-2">Bagikan</b> <svg width="10" height="10"
                        viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M11.6667 11.3092C11.0756 11.3092 10.5467 11.5502 10.1422 11.9277L4.59667 8.59438C4.63556 8.40964 4.66667 8.2249 4.66667 8.03213C4.66667 7.83936 4.63556 7.65462 4.59667 7.46988L10.08 4.16867C10.5 4.57028 11.0522 4.81928 11.6667 4.81928C12.9578 4.81928 14 3.74297 14 2.40964C14 1.07631 12.9578 0 11.6667 0C10.3756 0 9.33333 1.07631 9.33333 2.40964C9.33333 2.60241 9.36444 2.78715 9.40333 2.97189L3.92 6.27309C3.5 5.87149 2.94778 5.62249 2.33333 5.62249C1.04222 5.62249 0 6.69879 0 8.03213C0 9.36546 1.04222 10.4418 2.33333 10.4418C2.94778 10.4418 3.5 10.1928 3.92 9.79116L9.45778 13.1325C9.41889 13.3012 9.39556 13.4779 9.39556 13.6546C9.39556 14.9478 10.4144 16 11.6667 16C12.9189 16 13.9378 14.9478 13.9378 13.6546C13.9378 12.3614 12.9189 11.3092 11.6667 11.3092Z"
                            fill="white" />
                    </svg>
                </a>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <button class="btn btn-success mt-4 br-20"
                        style="font-size: 12px; margin-bottom: 20px;">{{$class->category}}</button>
                    <h1 class="text-white" style="font-size: 23px;">{{$title}}</h1>
                    {{-- <div class="bintang text-white"><b>4.5</b> <svg width="18" height="16" viewBox="0 0 18 16"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M4.09812 15.6437L5.42894 9.99138L0.965576 6.18966L6.86213 5.68678L9.15523 0.356323L11.4483 5.68678L17.3449 6.18966L12.8815 9.99138L14.2123 15.6437L9.15523 12.6466L4.09812 15.6437Z"
                                fill="#FF9900" />
                        </svg>
                    </div> --}}
                    {{-- <div class="d-flex">
                        <div class="form-group mr-auto">
                            <label for="" class="m-0 text-white text-capitalize">Narasumber</label>
                            @if(count($class->instructor_list) > 0)
                            <p class="m-0 text-white text-capitalize"><b>{{$class->instructor_list[0]->name}}</b></p>
                            @else
                            <span class="badge badge-danger">Instructor belum tersedia</span>
                            @endif
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
                    </div> --}}
                    {{-- <span class="text-white">
                        @if($class->sub_category)
                        Sub Kategori : <b>{{implode(', ',json_decode($class->sub_category))}}</b>
                        @endif
                    </span> --}}
                    <div class="row text-white text-capitalize">

                        <div class="col-md-4 col-12 mb-2">
                            <div class="form-group m-0">
                                <label class="m-0"
                                    style="color: white; font-size: 12px; font-weight: normal;">Narasumber</label>
                                @if(count($class->instructor_list) > 0)
                                <p class="m-0"><b style="font-size: 17px;">{{$class->instructor_list[0]->name}}</b></p>
                                @else
                                <span class="badge badge-danger">Instructor belum tersedia</span>
                                @endif
                            </div>
                        </div>


                        <div class="col-md-4 col-12 mb-2">
                            <div class="form-group m-0">
                                <label class="m-0"
                                    style="color: white; font-size: 12px; font-weight: normal;">Kategori</label>
                                @if($class->tags)
                                <p class="m-0"><b style="font-size: 17px;">{{implode(', ',
                                        json_decode($class->tags))}}</b></p>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4 col-12 mb-2">
                            <div class="form-group m-0">
                                <label class="m-0 text-white;"
                                    style="color: white; font-size: 12px; font-weight: normal;">Sub Kategori</label>
                                @if($class->sub_category)
                                <p class="m-0 text-white"><b style="font-size: 17px;">{{implode(', ',
                                        json_decode($class->sub_category))}}</b></p>
                                @else
                                <span class="badge badge-danger">Sub Kategori belum tersedia</span>
                                @endif
                            </div>

                        </div>
                    </div>

                    <div class="row text-white text-capitalize" style="margin-top: 20px;">
                        <div class="col-md-4 col-12 mb-2">
                            <div class="form-group m-0">
                                <label class="m-0" style="color: white; font-size: 12px; font-weight: normal;">Tanggal
                                    Kelas</label>
                                <p class="m-0"><b
                                        style=" font-size: 17px;">{{\Carbon\Carbon::parse($class->date_start)->format('d-F-Y')}}</b>
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4 col-12 mb-2">
                            <div class="form-group m-0">
                                <label class="m-0" style="color: white; font-size: 12px; font-weight: normal;">Jam
                                </label>
                                @if ($class->jam_acara)
                                <p class="m-0" style="font-size: 17px;">
                                    <b>{{ \Carbon\Carbon::parse($class->jam_acara)->format('H:i') }} WIB</b>
                                </p>
                                @else
                                <p class="m-0" style="font-size: 13px;">
                                    <b>Jam belum ada</b>
                                </p>
                                @endif

                            </div>
                        </div>

                        @if($class->kategori == 0)
                        <div class="col-md-4 col-12 mb-2">
                            <div class="form-group m-0">
                                <label class="m-0"
                                    style="color: white; font-size: 12px; font-weight: normal;">ONLINE</label>
                                <p class="m-0" style="font-size: 17px;">
                                    <i class="fa fa-video" aria-hidden="true"></i> GOOGLE MEET
                                </p>

                            </div>
                        </div>
                        @endif

                    </div>
                    {{-- <br> --}}
                    @if($class->kategori == 1)
                    <div class="row text-white text-capitalize" style="margin-top: 20px;">
                        <div class="col-md-12 col-12 mb-2">
                            <div class="form-group m-0">
                                <label class="m-0"
                                    style="color: white; font-size: 12px; font-weight: normal;">OFFLINE</label>
                                <p class="m-0" style="font-size: 17px;">
                                    @if($class->lokasi != null)
                                    <a href="https://www.google.com/maps/place/{{$class->lokasi}}" target="_blank"
                                        style="color: inherit; text-decoration: none;font-size: 17px;">
                                        <i class="fa fa-map-marker-alt" aria-hidden="true" style="font-size: 17px;"></i>
                                        {{$class->lokasi}}
                                    </a>
                                    @else
                                    <span class="badge badge-danger">Lokasi belum di tentukan</span>
                                    @endif

                                </p>

                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-lg-4">
                    <div class="card mt-4"
                        style="border-top-left-radius: 10px; border-top-right-radius:10px; border-color: transparent;">
                        <div class="card-body p-2">
                            <!-- <iframe width="100%" height="90%"
                                src="https://www.youtube.com/embed/Dt1PGv-toHU?si=G_8_3vfrY9mrBYaP">
                            </iframe> -->
                            <div style="width:100%; height:200px; flex-shrink:0;">
                                <img
                                    src="{{ $class->image ? asset($class->image) : asset('FE/images/images-demo-consulting-03.jpg') }}"
                                    alt="{{ $class->title }}"
                                    style="width:100%; height:100%; object-fit:fill; display:block; border:none;">
                            </div>
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
                <!-- <div class="card">
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
                </div> -->
            </div>
            <div class="col-lg-4">
    <!-- Membungkus komponen ke dalam Card agar lebih rapi dan kokoh -->
    <div class="card h-100 border-0 shadow-sm p-4">
        
        <!-- BAGIAN HARGA -->
        <div class="d-flex align-items-center mb-2">
            @if($class->pricing)
                @if($class->pricing->promo)
                    <div>
                        <h3 class="font-weight-bold text-primary m-0">
                            Rp {{ number_format($class->pricing->price - $class->pricing->promo_price) }}
                        </h3>
                        <div class="d-flex align-items-center mt-1">
                            <span class="text-muted small text-decoration-through mr-2">
                                Rp {{ number_format($class->pricing->price) }}
                            </span>
                            <span class="badge badge-danger">
                                {{ round(($class->pricing->promo_price / $class->pricing->price) * 100) }}% OFF
                            </span>
                        </div>
                    </div>
                @elseif ($class->pricing->gratis)
                    <!-- UI KETIKA GRATIS (DITONJOLKAN) -->
                    <div class="w-100 py-2 px-3 bg-success-light rounded d-flex align-items-center justify-content-between" style="background-color: #e8f5e9; border: 1px dashed #2e7d32;">
                        <span class="text-success font-weight-bold" style="font-size: 1.1rem;">Biaya Pendaftaran:</span>
                        <h2 class="m-0 font-weight-black text-success animate-pulse" style="letter-spacing: 1px; font-weight: 800;">
                            GRATIS
                        </h2>
                    </div>
                @else
                    <h3 class="font-weight-bold m-0">
                        Rp {{ number_format($class->pricing->price) }}
                    </h3>
                @endif
            @else
                <!-- UI KETIKA Rp 0 (DIANGGAP GRATIS JUGA) -->
                <div class="w-100 py-2 px-3 bg-success-light rounded d-flex align-items-center justify-content-between" style="background-color: #e8f5e9; border: 1px dashed #2e7d32;">
                    <span class="text-success font-weight-bold" style="font-size: 1.1rem;">Biaya Pendaftaran:</span>
                    <h2 class="m-0 font-weight-black text-success" style="letter-spacing: 1px; font-weight: 800;">
                        GRATIS
                    </h2>
                </div>
            @endif
        </div>

        <!-- BAGIAN TOMBOL AKSI / STATUS KELAS -->
        <div class="action-buttons mb-4">
            @if($class->custom_jadwal > 0)
                <button class="btn btn-danger btn-block py-2 font-weight-bold rounded-pill" disabled>Kelas sudah penuh</button>
            @else
                @if(!$class->date_end)
                    <button class="btn btn-secondary btn-block py-2 font-weight-bold rounded-pill" disabled>Kelas Belum Tersedia</button>
                @elseif(\Carbon\Carbon::parse($class->date_end) < \Carbon\Carbon::now())
                    <button class="btn btn-danger btn-block py-2 font-weight-bold rounded-pill" disabled>Kelas Sudah Tidak Aktif</button>
                @else
                    @if(!$class->is_open)
                        <button class="btn btn-danger btn-block py-2 font-weight-bold rounded-pill" disabled>Kelas Sudah Tidak Aktif</button>
                    @else
                        <input hidden type="text" id="kode_reff" name="kode_reff" class="form-control">
                        
                        @auth
                            @if(!$kelas)
                                <button class="btn btn-primary btn-lg btn-block font-weight-bold py-3 shadow" data-toggle="modal" data-target="#invoiceModal" onclick="modalinvoice(' + v.id + ')">
                                    Daftar Kelas Ini
                                </button>
                            @else
                                <button class="btn btn-success btn-lg btn-block font-weight-bold py-3" disabled>
                                    <i class="fas fa-check-circle mr-2"></i>Terdaftar
                                </button>
                            @endif
                        @else
                            <button class="btn btn-primary btn-lg btn-block font-weight-bold py-3 shadow" data-toggle="modal" data-target="#modelId" data-backdrop="static" data-keyboard="false">
                                Order Sekarang
                            </button>
                        @endauth
                    @endif
                @endif
            @endif
        </div>

        <!-- BAGIAN BONUS TAMBAHAN -->
        <div class="tambahan pt-3 border-top">
            <p class="mb-3 text-dark font-weight-bold">Bonus Tambahan :</p>
            
            <div class="d-flex flex-column" style="gap: 10px;">
                <!-- <div class="d-flex align-items-center">
                    <span class="mr-2">
                        <svg width="14" height="14" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.14545 11L3.10909 9.32381L1.14545 8.90476L1.33636 6.96667L0 5.5L1.33636 4.03333L1.14545 2.09524L3.10909 1.67619L4.14545 0L6 0.759524L7.85455 0L8.89091 1.67619L10.8545 2.09524L10.6636 4.03333L12 5.5L10.6636 6.96667L10.8545 8.90476L8.89091 9.32381L7.85455 11L6 10.2405L4.14545 11ZM5.42727 7.35952L8.50909 4.4L7.74545 3.64048L5.42727 5.86667L4.25455 4.76667L3.49091 5.5L5.42727 7.35952Z" fill="#2e7d32" />
                        </svg>
                    </span>
                    <span class="text-secondary small font-weight-medium">Sertifikat</span>
                </div> -->
                
                <div class="d-flex align-items-center">
                    <span class="mr-2">
                        <svg width="14" height="14" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.14545 11L3.10909 9.32381L1.14545 8.90476L1.33636 6.96667L0 5.5L1.33636 4.03333L1.14545 2.09524L3.10909 1.67619L4.14545 0L6 0.759524L7.85455 0L8.89091 1.67619L10.8545 2.09524L10.6636 4.03333L12 5.5L10.6636 6.96667L10.8545 8.90476L8.89091 9.32381L7.85455 11L6 10.2405L4.14545 11ZM5.42727 7.35952L8.50909 4.4L7.74545 3.64048L5.42727 5.86667L4.25455 4.76667L3.49091 5.5L5.42727 7.35952Z" fill="#2e7d32" />
                        </svg>
                    </span>
                    <span class="text-secondary small font-weight-medium">Online Free Konsultasi</span>
                </div>
                
                <div class="d-flex align-items-center">
                    <span class="mr-2">
                        <svg width="14" height="14" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.14545 11L3.10909 9.32381L1.14545 8.90476L1.33636 6.96667L0 5.5L1.33636 4.03333L1.14545 2.09524L3.10909 1.67619L4.14545 0L6 0.759524L7.85455 0L8.89091 1.67619L10.8545 2.09524L10.6636 4.03333L12 5.5L10.6636 6.96667L10.8545 8.90476L8.89091 9.32381L7.85455 11L6 10.2405L4.14545 11ZM5.42727 7.35952L8.50909 4.4L7.74545 3.64048L5.42727 5.86667L4.25455 4.76667L3.49091 5.5L5.42727 7.35952Z" fill="#2e7d32" />
                        </svg>
                    </span>
                    <span class="text-secondary small font-weight-medium">Materi Pelatihan & Form Pendukung</span>
                </div>
            </div>
        </div>

    </div>
</div>        </div>
        {{--
        <hr class="mt-5 mb-5">
        <h3>Kelas Terpopuler</h3>

        <div id="sld3" class="mt-4">
            @foreach($kelas_populer as $key => $val)
            <div>
                <div class="card mr-2" style="border-color: transparent;">
                    <div class="card-body br-10" style="padding: 1px; border-color: transparent;">
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
                        {{\Carbon\Carbon::parse($val->date_end)->format('d-m-Y')}}
                    </p>
                </div>
                <div class="title text-uppercase ml-1">
                    <a href="/class/{{$val->unique_id}}/{{str_replace('/','-',$val->title)}}">
                        <h6 class="mb-2">
                            {{strlen($val->title)>=90?substr($val->title,0,87).' ...':$val->title}}
                        </h6>
                    </a>
                </div>
                <div class="author text-uppercase ml-1">
                    @if(count($val->instructor_list) > 0)
                    <a href="/profile-instructor/{{$val->instructor_list[0]->id}}/{{$val->instructor_list[0]->name}}"
                        class="mb-2">
                        {{$val->instructor_list[0]->name}}
                    </a>
                    @else
                    <span class="badge badge-danger">Instructor belum tersedia</span>
                    @endif
                </div>
                hrs disble
                <div class="star text-uppercase ml-1 ">
                    <div class="d-flex align-items-center">
                        <h4 class="m-0 mr-2">4.5</h4>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-star"
                            viewBox="0 0 16 16">
                            <path
                                d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z" />
                        </svg>
                    </div>
                </div>
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
        </div> --}}
    </div>
<!-- Modal Invoice -->
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <form action="" method="POST" enctype="multipart/form-data" id="formInvoice">
                @csrf
                
                <!-- Hidden Inputs (Tetap Dipertahankan) -->
                <input type="text" id="payment_invoice" name="payment_invoice" hidden>
                <input type="text" id="sertifikat_invoice" name="sertifikat_invoice" hidden>
                <input type="text" id="jmlp" name="jml_peserta" hidden>
                <input type="text" id="class_id" name="class_id" value="{{ $class->id }}" hidden>

                <!-- Modal Header -->
                <div class="modal-header bg-light style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <div>
                        <h4 class="modal-title font-weight-bold text-dark" id="exampleModalLabel">Formulir Invoice</h4>
                        <small class="text-muted">Silakan lengkapi data peserta dan opsi sertifikat Anda</small>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="font-size: 1.8rem;">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body p-4">
                    
                    <!-- Section 1: Konfigurasi Utama -->
                    <div class="row mb-4">
                        <!-- Kolom Jumlah Peserta -->
                        <div class="col-md-5 mb-3 mb-md-0">
                            <div class="card border-0 bg-light p-3 h-100" style="border-radius: 8px;">
                                <label for="jml_pesertas" class="font-weight-600 text-dark mb-2">Jumlah Peserta</label>
                                <div class="input-group my-auto">
                                    <input class="form-control form-control-lg border-right-0" min="1" type="number" id="jml_pesertas" name="jml_peserta" required onchange="qtyjumlahpeserta()" placeholder="Contoh: 2">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-white text-muted border-left-0"><i class="fa fa-users"></i> Orang</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Kolom Pemilihan Sertifikat -->
                        <div class="col-md-7">
                            <div class="card border-0 bg-light p-3 h-100" style="border-radius: 8px;">
                                <label class="font-weight-600 text-dark mb-2">Apakah Anda membutuhkan Sertifikat?</label>
                                
                                <div class="d-flex style-radio-group" style="gap: 12px;">
                                    <!-- Opsi Ya -->
                                    <label class="flex-fill m-0 position-relative" style="cursor: pointer;">
                                        <input type="radio" name="sertifikat_invoice" value="1" checked class="card-radio-input d-none">
                                        <div class="card-radio-box text-center p-2 border rounded bg-white">
                                            <span class="font-weight-bold d-block text-success" style="font-size: 0.95rem;">Ya</span>
                                            <span class="badge badge-info mt-1">+ Rp. {{ $sertif?->nominal ?? 100000 }} / peserta</span>
                                        </div>
                                    </label>

                                    <!-- Opsi Tidak -->
                                    <label class="flex-fill m-0 position-relative" style="cursor: pointer;">
                                        <input type="radio" name="sertifikat_invoice" value="0" class="card-radio-input d-none">
                                        <div class="card-radio-box text-center p-2 border rounded bg-white">
                                            <span class="font-weight-bold d-block text-secondary" style="font-size: 0.95rem;">Tidak</span>
                                            <span class="badge badge-secondary mt-1">Rp. 0</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Container Dinamis Detail Peserta -->
                    <div id="detailpeserta"></div>

                </div>

                <!-- Modal Footer -->
                <div class="modal-footer bg-light d-flex justify-content-between py-3" style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal" style="border-radius: 6px;">Batal</button>
                    <button type="button" class="btn btn-primary px-4 font-weight-bold" onclick="cetakInvoiceSertifikat()" style="border-radius: 6px; box-shadow: 0 4px 6px rgba(0,123,255,0.2);">
                        Lanjut ke Pembayaran <i class="fa fa-arrow-right ml-1"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</section>
<script>
    $(document).ready(function() {
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
            ]
        });
    })
function modalinvoice(id) {
        $('#payment_invoice').val(id);
    }
 function qtyjumlahpeserta() {
    $('#detailpeserta').html('');
    let jmlpsrt = $('#jml_pesertas').val();
    let detail = '';
    
    if (jmlpsrt > 0) {
        detail += '<h5 class="font-weight-bold text-dark mb-3 mt-2">Data Biodata Peserta</h5>';
        
        for (let i = 0; i < jmlpsrt; i++) {
            let urutan = i + 1;
            detail += '    <div class="card border mb-3 shadow-sm" style="border-radius: 8px; overflow: hidden;">';
            // Header Card Peserta
            detail += '        <div class="card-header bg-white py-2 border-bottom-0" style="background-color: #f8f9fa !important;">';
            detail += '            <span class="badge badge-primary px-2 py-1">Peserta #' + urutan + '</span>';
            detail += '        </div>';
            // Body Card Input
            detail += '        <div class="card-body pt-1 pb-3">';
            detail += '            <div class="row">';
            
            // Kolom Nama
            detail += '                <div class="col-lg-4 mb-2 mb-lg-0">';
            detail += '                    <input type="text" required class="form-control" name="nama[]" placeholder="Nama Peserta">';
            detail += '                </div>';
            
            // Kolom Email
            detail += '                <div class="col-lg-4 mb-2 mb-lg-0">';
            detail += '                    <input type="email" required class="form-control" name="email[]" placeholder="Email Peserta">';
            detail += '                </div>';
            
            // Kolom Nomor HP
            detail += '                <div class="col-lg-4">';
            detail += '                    <input type="number" required class="form-control" name="nomor_handphone[]" placeholder="Nomor HP Peserta">';
            detail += '                </div>';
            
            detail += '            </div>';
            detail += '        </div>';
            detail += '    </div>';
        }
    }
    $('#detailpeserta').html(detail);
}
    let classId = $('#class_id').val()
  function cetakInvoiceSertifikat() {
    let classId = $('#class_id').val();
    
    // JANGAN gunakan || 1 di sini agar nilai aslinya yang kosong ("") bisa divalidasi
    let jumlahPeserta = $('#jml_pesertas').val(); 
    
    // Mengambil nilai radio yang sedang aktif (0 atau 1)
    let sertifikatInvoice = $('input[name="sertifikat_invoice"]:checked').val();

    // Validasi jika jumlah peserta kosong, nol, atau negatif
    if (jumlahPeserta === "" || parseInt(jumlahPeserta) < 1) {
        Swal.fire({ title: "Pemberitahuan", text: "Jumlah peserta anda belum di isi atau tidak valid", icon: "info" });
        return false;
    }

    let semuaInputTerisi = true;
    // Validasi input di dalam detail peserta (hanya jika container detailpeserta sudah terisi)
    $('#detailpeserta input').each(function() {
        if ($(this).val().trim() === "") {
            semuaInputTerisi = false;
            $(this).addClass('is-invalid'); 
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    if (!semuaInputTerisi) {
        Swal.fire({ title: "Pemberitahuan", text: "Mohon lengkapi semua data biodata peserta sebelum melanjutkan.", icon: "warning" });
        return false;
    }

    // Mengambil semua value asli ke dalam bentuk Array
    let namaArray = $("input[name='nama[]']").map(function(){ return $(this).val().trim(); }).get();
    let emailArray = $("input[name='email[]']").map(function(){ return $(this).val().trim(); }).get();
    let nohpArray = $("input[name='nomor_handphone[]']").map(function(){ return $(this).val().trim(); }).get();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    jQuery.ajax({
        url: "/order",
        method: 'post',
        data: {
            class_id: classId,
            jml_peserta: jumlahPeserta,
            sertifikat_invoice: sertifikatInvoice, // Nilai "0" atau "1" akan terkirim dengan benar
            nama: JSON.stringify(namaArray),
            email: JSON.stringify(emailArray),
            nomor_handphone: JSON.stringify(nohpArray)
        },
        success: function(result) {
            if (result.rc == '00') {
                Swal.fire({ title: "Pemberitahuan", text: result.msg, icon: "success" });
                localStorage.setItem("menu", "li-tabs-33");
                if (typeof clearmenu === "function") clearmenu(); 
                $('#li-tabs-33').removeClass('ui-state-active ui-tabs-active').removeAttr('aria-selected').removeAttr('aria-expanded');
                setTimeout(() => { window.location.href = '/profile'; }, 3000);
            } else if (result.rc == '07' || result.rc == '03' || result.rc == '04') {
                Swal.fire({ title: "Pemberitahuan", text: result.msg, icon: (result.rc == '07' ? "info" : "warning") });
                if (result.rc == '03' || result.rc == '04') {
                    setTimeout(() => { window.location.href = '/profile'; }, 2000);
                }
            }
        },
        error: function(xhr) {
            Swal.fire({ title: "Error", text: "Terjadi kesalahan pada server.", icon: "error" });
        }
    });
}
    function clearmenu() {
        $('#li-tabs-32').removeClass('ui-state-active ui-tabs-active');
        $('#li-tabs-32').attr('aria-selected', true);
        $('#li-tabs-32').attr('aria-expanded', true);
        $('#tabs-32').attr('aria-hidden', true);
        $('#tabs-32').css('display', 'none');

        $('#li-tabs-33').removeClass('ui-state-active ui-tabs-active');
        $('#li-tabs-33').attr('aria-selected', true);
        $('#li-tabs-33').attr('aria-expanded', true);
        $('#tabs-33').attr('aria-hidden', true);
        $('#tabs-33').css('display', 'none');

        $('#li-tabs-34').removeClass('ui-state-active ui-tabs-active');
        $('#li-tabs-34').attr('aria-selected', true);
        $('#li-tabs-34').attr('aria-expanded', true);
        $('#tabs-34').attr('aria-hidden', true);
        $('#tabs-34').css('display', 'none');

        $('#li-tabs-35').removeClass('ui-state-active ui-tabs-active');
        $('#li-tabs-35').attr('aria-selected', true);
        $('#li-tabs-35').attr('aria-expanded', true);
        $('#tabs-35').attr('aria-hidden', true);
        $('#tabs-35').css('display', 'none');

        $('#li-tabs-36').removeClass('ui-state-active ui-tabs-active');
        $('#li-tabs-36').attr('aria-selected', true);
        $('#li-tabs-36').attr('aria-expanded', true);
        $('#tabs-36').attr('aria-hidden', true);
        $('#tabs-36').css('display', 'none');

        $('#li-tabs-37').removeClass('ui-state-active ui-tabs-active');
        $('#li-tabs-37').attr('aria-selected', true);
        $('#li-tabs-37').attr('aria-expanded', true);
        $('#tabs-37').attr('aria-hidden', true);
        $('#tabs-37').css('display', 'none');

        $('#li-tabs-38').removeClass('ui-state-active ui-tabs-active');
        $('#li-tabs-38').attr('aria-selected', true);
        $('#li-tabs-38').attr('aria-expanded', true);
        $('#tabs-38').attr('aria-hidden', true);
        $('#tabs-38').css('display', 'none');

        $('#li-tabs-39').removeClass('ui-state-active ui-tabs-active');
        $('#li-tabs-39').attr('aria-selected', true);
        $('#li-tabs-39').attr('aria-expanded', true);
        $('#tabs-39').attr('aria-hidden', true);
        $('#tabs-39').css('display', 'none');
    }
</script>
<style>
  /* Style untuk interaksi satu kali klik pada pilihan sertifikat */
.card-radio-input:checked + .card-radio-box {
    border-color: #007bff !important;
    background-color: #f1f7ff !important;
    box-shadow: 0 0 0 1px #007bff;
}

.card-radio-input:checked + .card-radio-box .text-secondary {
    color: #007bff !important;
}

.card-radio-box {
    transition: all 0.2s ease-in-out;
    border: 2px solid #e2e8f0 !important;
    border-radius: 6px;
}

.card-radio-box:hover {
    border-color: #cbd5e1 !important;
    background-color: #f8fafc;
}

.font-weight-600 {
    font-weight: 600;
}
.d-flex {
    display: flex !important;
}
.flex-fill {
    flex: 1 1 auto !important;
}
</style>
@include(env('CUSTOM_FOOTER', 'front.layout.footer'))