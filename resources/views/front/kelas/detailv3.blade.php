@extends('front.layout.v3.main')
@section('content')
<br>
<br>
<style>
    .text-white {
        color: white;
    }
    
    .card-body ul {
        margin-left: 15px;
    }
    
    .course-header {
        background-image: url(/GambarV2/maskgroup.jpg);
        background-position: center;
        background-size: cover;
        padding: 3rem 0;

    }
    
    .breadcrumb-nav {
        background-color: rgba(0, 0, 0, 0.3);
        padding: 1rem;
        border-radius: 8px;
    }
    
    .course-card {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    
    .course-card:hover {
        transform: translateY(-5px);
    }
    
    .price-tag {
        font-size: 1.5rem;
        font-weight: bold;
    }
    
    .bonus-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    
    .popular-course-card {
        height: 100%;
        transition: transform 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
    }
    
    .popular-course-card:hover {
        transform: translateY(-5px);
    }
    
    .section-title {
        position: relative;
        padding-bottom: 0px;
        margin-bottom: 0px;
    }
    
    .section-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background-color: #005CFF;
    }
    
    .btn-primary {
        background-color: #005CFF;
        border-color: #005CFF;
        border: 20px;
    }
    
    .btn-primary:hover {
        background-color: #0047CC;
        border-color: #0047CC;
    }
    
    .badge-danger {
        background-color: #FF4757;
    }
</style>

<section class="content">
  
    <div class="course-header">
        <div class="container">
           
            {{-- <div class="breadcrumb-nav d-flex flex-wrap">
                <a href="{{ URL::previous() }}" class="mt-2 mr-3 text-white">
                    <svg class="mr-1" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 6.125H3.35125L8.2425 1.23375L7 0L0 7L7 14L8.23375 12.7663L3.35125 7.875H14V6.125Z" fill="white" />
                    </svg>
                    <b>Beranda</b>
                </a>
                <a href="/list-class" class="mt-2 mr-3 text-white">
                    <svg class="mr-1" width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 1.25152L1.22022 0L8 7L1.21337 14L0 12.7485L5.57326 7L0 1.25152Z" fill="white" />
                    </svg>
                    <b>Semua Kategori</b>
                </a>
                <a href="#" class="mt-2 mr-3 text-white">
                    <svg class="mr-1" width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 1.25152L1.22022 0L8 7L1.21337 14L0 12.7485L5.57326 7L0 1.25152Z" fill="white" />
                    </svg>
                    <b>{{$title}}</b>
                </a>
                <a href="" class="mt-2 ml-auto text-white">
                    <b class="mr-2">Bagikan</b> 
                    <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.6667 11.3092C11.0756 11.3092 10.5467 11.5502 10.1422 11.9277L4.59667 8.59438C4.63556 8.40964 4.66667 8.2249 4.66667 8.03213C4.66667 7.83936 4.63556 7.65462 4.59667 7.46988L10.08 4.16867C10.5 4.57028 11.0522 4.81928 11.6667 4.81928C12.9578 4.81928 14 3.74297 14 2.40964C14 1.07631 12.9578 0 11.6667 0C10.3756 0 9.33333 1.07631 9.33333 2.40964C9.33333 2.60241 9.36444 2.78715 9.40333 2.97189L3.92 6.27309C3.5 5.87149 2.94778 5.62249 2.33333 5.62249C1.04222 5.62249 0 6.69879 0 8.03213C0 9.36546 1.04222 10.4418 2.33333 10.4418C2.94778 10.4418 3.5 10.1928 3.92 9.79116L9.45778 13.1325C9.41889 13.3012 9.39556 13.4779 9.39556 13.6546C9.39556 14.9478 10.4144 16 11.6667 16C12.9189 16 13.9378 14.9478 13.9378 13.6546C13.9378 12.3614 12.9189 11.3092 11.6667 11.3092Z" fill="white" />
                    </svg>
                </a>
            </div>
         --}}
          
            <div class="row mt-4">
                <div class="col-lg-8">
                    <button class="btn btn-success mt-2 br-20">{{$class->category}}</button>
                    <h1 class="text-white mt-3" style="font-size: 30px;">{{$title}}</h1>
                    
                 
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="text-white text-capitalize">Speaker</label>
                                <p class="text-white text-capitalize mb-0"><b>{{$class->instructor_list[0]->name}}</b></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="text-white text-capitalize">Kategori</label>
                                @if($class->tags)
                                <p class="text-white text-capitalize mb-0"><b>{{implode(', ',json_decode($class->tags))}}</b></p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="text-white text-capitalize">Tanggal Kelas</label>
                                <p class="text-white text-capitalize mb-0">
                                    <b>{{\Carbon\Carbon::parse($class->date_start)->format('d-F-Y')}}</b>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    @if($class->sub_category)
                    <div class="mt-3">
                        <span class="text-white">
                            Sub Kategori : <b>{{implode(', ',json_decode($class->sub_category))}}</b>
                        </span>
                    </div>
                    @endif
                </div>
                
               
                <div class="col-lg-4">
                    <div class="card course-card mt-4">
                        <div class="card-body p-0">
                            <iframe width="100%" height="250" src="https://www.youtube.com/embed/Dt1PGv-toHU?si=G_8_3vfrY9mrBYaP" frameborder="0" allowfullscreen></iframe>
                            <div class="p-3">
                                <h5 class="mb-0" style="font-size: 20px;">{{$title}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
   
    <div class="container mt-5">
        <div class="row">
      
            <div class="col-lg-8">
           
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="text-primary section-title" style="font-size: 20px;">Deskripsi</h3>
                        <div class="course-description">
                            {!!$class->content!!}
                        </div>
                    </div>
                </div>
                
         
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="text-primary section-title" style="font-size: 20px;">Point Pelatihan</h3>
                        <div class="row">
                            @foreach($class->event_list as $key => $v)
                            <div class="col-lg-6 mb-2">
                                <div class="d-flex">
                                    <svg class="mr-2 mt-1" width="13" height="10" viewBox="0 0 13 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.54601 10L0 5.25988L1.1365 4.07484L4.54601 7.62994L11.8635 0L13 1.18503L4.54601 10Z" fill="black" />
                                    </svg>
                                    <span>{{$v->description}}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                     
                        <div class="price-section mb-4">
                            @if($class->pricing)
                            @if($class->pricing->promo)
                            <div class="d-flex align-items-center">
                                <h3 class="price-tag text-primary">
                                    Rp. {{number_format($class->pricing->price-$class->pricing->promo_price)}}
                                </h3>
                                <span class="ml-2 text-muted" style="text-decoration: line-through;">
                                    Rp {{number_format($class->pricing->price)}}
                                </span>
                                <span class="ml-2 badge badge-danger">
                                    {{round(($class->pricing->promo_price/$class->pricing->price)*100)}}%
                                </span>
                            </div>
                            @else
                            <h3 class="price-tag text-primary">
                                Rp. {{number_format($class->pricing->price)}}
                            </h3>
                            @endif
                            @else
                            <h3 class="price-tag text-primary">
                                Rp 0
                            </h3>
                            @endif
                        </div>
                        
                       
                        <div class="registration-section mb-4">
                            @if($class->custom_jadwal>0)
                            <button class="btn btn-lg btn-block btn-secondary" disabled>Kelas Belum Tersedia</button>
                            @else
                            @if(!$class->date_end)
                            <button class="btn btn-lg btn-block btn-secondary" disabled>Kelas Belum Tersedia</button>
                            @elseif(\Carbon\Carbon::parse($class->date_end) < \Carbon\Carbon::now())
                            <button class="btn btn-lg btn-block btn-secondary" disabled>Kelas Sudah Penuh</button>
                            @else
                            @if(!$class->is_open)
                            <button class="btn btn-lg btn-block btn-secondary" disabled>Kelas Sudah Penuh</button>
                            @else
                            <form id="orderForm" action="{{ '/order' }}" method="POST">
                                @csrf
                                <input type="text" id="class_id" name="class_id" value="{{ $class->id }}" hidden>
                                <label hidden for="">Kode Referral ( optional )</label>
                                <input hidden type="text" id="kode_reff" name="kode_reff" class="form-control">
                                @auth
                                <button type="submit" class="btn btn-primary btn-lg btn-block" style="font-size: 20px;">Daftar Kelas Ini</button>
                                @else
                                <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#modelId" data-backdrop="static" data-keyboard="false">Order sekarang</button>
                                @endauth
                            </form>
                            @endif
                            @endif
                            @endif
                        </div>
                       
                        <div class="bonus-section">
                            <h5 class="mb-3" style="font-size: 20px;">Bonus Tambahan :</h5>
                            <div class="bonus-item">
                                <svg width="16" height="16" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.14545 11L3.10909 9.32381L1.14545 8.90476L1.33636 6.96667L0 5.5L1.33636 4.03333L1.14545 2.09524L3.10909 1.67619L4.14545 0L6 0.759524L7.85455 0L8.89091 1.67619L10.8545 2.09524L10.6636 4.03333L12 5.5L10.6636 6.96667L10.8545 8.90476L8.89091 9.32381L7.85455 11L6 10.2405L4.14545 11ZM5.42727 7.35952L8.50909 4.4L7.74545 3.64048L5.42727 5.86667L4.25455 4.76667L3.49091 5.5L5.42727 7.35952Z" fill="#065FFF" />
                                </svg>
                                <span class="ml-2">Free Sertifikat</span>
                            </div>
                            <div class="bonus-item">
                                <svg width="16" height="16" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.14545 11L3.10909 9.32381L1.14545 8.90476L1.33636 6.96667L0 5.5L1.33636 4.03333L1.14545 2.09524L3.10909 1.67619L4.14545 0L6 0.759524L7.85455 0L8.89091 1.67619L10.8545 2.09524L10.6636 4.03333L12 5.5L10.6636 6.96667L10.8545 8.90476L8.89091 9.32381L7.85455 11L6 10.2405L4.14545 11ZM5.42727 7.35952L8.50909 4.4L7.74545 3.64048L5.42727 5.86667L4.25455 4.76667L3.49091 5.5L5.42727 7.35952Z" fill="#065FFF" />
                                </svg>
                                <span class="ml-2">Online Free konsultasi</span>
                            </div>
                            <div class="bonus-item">
                                <svg width="16" height="16" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.14545 11L3.10909 9.32381L1.14545 8.90476L1.33636 6.96667L0 5.5L1.33636 4.03333L1.14545 2.09524L3.10909 1.67619L4.14545 0L6 0.759524L7.85455 0L8.89091 1.67619L10.8545 2.09524L10.6636 4.03333L12 5.5L10.6636 6.96667L10.8545 8.90476L8.89091 9.32381L7.85455 11L6 10.2405L4.14545 11ZM5.42727 7.35952L8.50909 4.4L7.74545 3.64048L5.42727 5.86667L4.25455 4.76667L3.49091 5.5L5.42727 7.35952Z" fill="#065FFF" />
                                </svg>
                                <span class="ml-2">Materi Pelatihan & Form pendukung</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
      
        <div class="popular-courses-section mt-5">
            <hr>
            <h3 class="mt-5 mb-4 section-title" style="font-size: 20px; color: #005CFF;">Kelas Terpopuler</h3>
            
            <div class="row">
                @foreach($kelas_populer as $key => $val)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card popular-course-card h-100">
                        <div class="card-body p-0">
                            <img src="{{asset($val->image)}}" alt="{{$val->title}}" class="card-img-top">
                            <div class="p-3">
                                
                                <h5 class="card-title">
                                    <a href="/class/{{$val->unique_id}}/{{str_replace('/','-',$val->title)}}" class="text-dark" style="font-size: 18px;">
                                        {{strlen($val->title)>=50?substr($val->title,0,47).' ...':$val->title}}
                                    </a>
                                </h5>
                                <div class="d-flex align-items-center mb-2">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.605225 5.68681C0.605225 4.48076 0.605225 3.87837 0.979957 3.50364C1.35469 3.12891 1.95707 3.12891 3.16312 3.12891H10.8368C12.0429 3.12891 12.6453 3.12891 13.02 3.50364C13.3947 3.87837 13.3947 4.48076 13.3947 5.68681C13.3947 5.988 13.3947 6.13892 13.3014 6.23292C13.2074 6.32628 13.0558 6.32628 12.7552 6.32628H1.2447C0.943507 6.32628 0.792591 6.32628 0.698588 6.23292C0.605225 6.13892 0.605225 5.98736 0.605225 5.68681ZM0.605225 11.4421C0.605225 12.6481 0.605225 13.2505 0.979957 13.6252C1.35469 14 1.95707 14 3.16312 14H10.8368C12.0429 14 12.6453 14 13.02 13.6252C13.3947 13.2505 13.3947 12.6481 13.3947 11.4421V8.24471C13.3947 7.94351 13.3947 7.7926 13.3014 7.69859C13.2074 7.60523 13.0558 7.60523 12.7552 7.60523H1.2447C0.943507 7.60523 0.792591 7.60523 0.698588 7.69859C0.605225 7.7926 0.605225 7.94415 0.605225 8.24471V11.4421Z" fill="#005CFF" />
                                        <path d="M3.80261 1.84998V3.7684M10.1974 1.84998V3.7684" stroke="#005CFF" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                    <span class="text-blue ml-1" >{{\Carbon\Carbon::parse($val->date_end)->format('d-m-Y')}}</span>
                                </div>
                                <p class="card-text text-muted">
                                    <a href="/profile-instructor/{{$val->instructor_list[0]->id}}/{{$val->instructor_list[0]->name}}" class="text-muted">
                                        {{$val->instructor_list[0]->name}}
                                    </a>
                                </p>
                                <div class="price mt-3">
                                    @if($val->pricing)
                                    @if($val->pricing->promo)
                                    <span class="text-primary font-weight-bold">Rp. {{number_format($val->pricing->price - $val->pricing->promo_price)}}</span>
                                    <span class="text-muted ml-2" style="text-decoration: line-through; font-size: 0.8rem;">Rp. {{number_format($val->pricing->price)}}</span>
                                    @else
                                    <span class="text-primary font-weight-bold">Rp. {{number_format($val->pricing->price)}}</span>
                                    @endif
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
        
                @if(($key+1) % 4 == 0)
                <div class="w-100 d-none d-lg-block"></div>
                @endif
                
         
                @if(($key+1) % 2 == 0)
                <div class="w-100 d-none d-md-block d-lg-none"></div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {

    });
</script>

@endsection