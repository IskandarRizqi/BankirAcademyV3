@include('front.layout.head')
@include('front.layout.topbar')
@include(env('CUSTOM_HEADER', 'front.layout.header'))
<section id="content">
    <div class="container mt-4">
        <form action="/list-class" method="POST">
            @csrf
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
                        <input type="text" name="titlekelas" class="form-control"
                            placeholder="Kamu mau upgrade skill apa hari ini?" aria-label="Username"
                            aria-describedby="basic-addon1"
                            style="border-left-width: 0px; border-radius: 15px; border-top-left-radius: 0px; border-bottom-left-radius: 0px;">
                    </div>
                </div>
                <div class="">
                    <button class="btn btn-primary br-1 btn-block br-20">Telusuri</button>
                </div>
            </div>
        </form>
        <div id="sld1">
            @foreach($banner_slide as $key => $va)
            <div>
                <a href="{{$va->link}}">
                    <img class="d-block w-100" src="/Image/{{$va->image}}" alt="First slide" style="border-radius:30px">
                </a>
            </div>
            @endforeach
        </div>
        <h3 class="text-blue m-0">Kategori Terpopuler</h3>
        <div id="page-menu" class="no-sticky" style="overflow-y: auto">
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
                <div class="card-body br-10" style="padding: 1px;">
                    <img src="{{asset($val->image)}}" alt="" width="100%" style="border-radius:18px">
                    {{-- <img src="/GambarV2/rectangle31.png" alt="" width="100%" style="border-radius:18px"> --}}
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
                        <small for="" class="text-blue m-0">Dibutuhkan</small>
                        <p class="m-0" style="font-size: 16px;font-weight: bold">{{substr($value->title,0,26)}}</p>
                        @if($value->image)
                        <img src="image/loker/{{json_decode($value->image)->url}}" alt="" width="100%" height="103px">
                        @endif
                        <div class="form-group m-0 p-2">
                            <span><svg class="mr-2" width="16" height="16" viewBox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1.875 17.5H18.125M3.125 2.5V17.5M11.875 2.5V17.5M16.875 6.25V17.5M5.625 5.625H6.25M5.625 8.125H6.25M5.625 10.625H6.25M8.75 5.625H9.375M8.75 8.125H9.375M8.75 10.625H9.375M5.625 17.5V14.6875C5.625 14.17 6.045 13.75 6.5625 13.75H8.4375C8.955 13.75 9.375 14.17 9.375 14.6875V17.5M2.5 2.5H12.5M11.875 6.25H17.5M14.375 9.375H14.3817V9.38167H14.375V9.375ZM14.375 11.875H14.3817V11.8817H14.375V11.875ZM14.375 14.375H14.3817V14.3817H14.375V14.375Z"
                                        stroke="black" stroke-width="1.25" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                @if($value->nama) {{$value->nama}}
                                @else {{json_decode($value->corporate)?json_decode($value->corporate)->name:'Anugrah
                                Karya'}}
                                @endif
                            </span>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <hr class="m-0">
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-0 p-2">
                                    <span>
                                        <svg class="mr-2" width="16" height="16" viewBox="0 0 18 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.833008 7.25L9.59217 3.75L18.3513 7.25L9.59217 10.75L0.833008 7.25Z"
                                                stroke="#2E2E2E" stroke-width="1.66667" stroke-linejoin="round" />
                                            <path
                                                d="M18.3511 7.2959V11.1388M4.81445 9.09382V14.278C4.81445 14.278 6.81862 16.2501 9.59195 16.2501C12.3657 16.2501 14.3699 14.278 14.3699 14.278V9.09382"
                                                stroke="#2E2E2E" stroke-width="1.66667" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        S1
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-0 p-2">
                                    <span>
                                        <svg class="mr-2" width="16" height="16" viewBox="0 0 18 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M7.30248 7.41754C6.68717 7.41754 6.08566 7.23507 5.57404 6.89322C5.06242 6.55137 4.66367 6.06548 4.42819 5.497C4.19272 4.92851 4.13111 4.30297 4.25115 3.69948C4.3712 3.09598 4.6675 2.54163 5.1026 2.10654C5.53769 1.67144 6.09204 1.37514 6.69554 1.25509C7.29903 1.13505 7.92457 1.19666 8.49306 1.43213C9.06154 1.66761 9.54743 2.06636 9.88928 2.57798C10.2311 3.0896 10.4136 3.69111 10.4136 4.30643C10.4136 5.13154 10.0858 5.92287 9.50237 6.50631C8.91893 7.08976 8.1276 7.41754 7.30248 7.41754ZM7.30248 2.11976C6.86297 2.11976 6.43333 2.25009 6.06788 2.49427C5.70244 2.73845 5.41761 3.08552 5.24942 3.49157C5.08122 3.89763 5.03722 4.34445 5.12296 4.77552C5.20871 5.20658 5.42035 5.60255 5.73114 5.91333C6.04192 6.22411 6.43788 6.43576 6.86895 6.5215C7.30002 6.60725 7.74683 6.56324 8.15289 6.39505C8.55895 6.22685 8.90601 5.94202 9.15019 5.57658C9.39438 5.21114 9.52471 4.7815 9.52471 4.34198C9.52471 4.05015 9.46723 3.76119 9.35555 3.49157C9.24387 3.22196 9.08018 2.97698 8.87383 2.77063C8.66748 2.56428 8.4225 2.40059 8.15289 2.28892C7.88328 2.17724 7.59431 2.11976 7.30248 2.11976ZM9.77804 7.95531C7.37289 7.41411 4.85672 7.67478 2.6136 8.69754C2.3051 8.8449 2.04482 9.07686 1.86306 9.36642C1.6813 9.65598 1.58554 9.99122 1.58693 10.3331V12.9775C1.58693 13.0359 1.59842 13.0937 1.62076 13.1476C1.6431 13.2015 1.67583 13.2505 1.7171 13.2918C1.75837 13.3331 1.80737 13.3658 1.86129 13.3882C1.91521 13.4105 1.97301 13.422 2.03137 13.422C2.08974 13.422 2.14753 13.4105 2.20145 13.3882C2.25538 13.3658 2.30437 13.3331 2.34564 13.2918C2.38691 13.2505 2.41965 13.2015 2.44199 13.1476C2.46432 13.0937 2.47582 13.0359 2.47582 12.9775V10.3331C2.47195 10.1601 2.51867 9.98968 2.61025 9.84284C2.70184 9.69599 2.83429 9.57907 2.99137 9.50643C4.3426 8.88252 5.81418 8.56241 7.30248 8.56865C8.1364 8.56758 8.96746 8.66606 9.77804 8.86198V7.95531ZM9.84026 12.182H12.5692V12.8042H9.84026V12.182Z"
                                                fill="black" />
                                            <path
                                                d="M14.7424 9.54211H12.4447V10.431H14.298V14.151H8.00022V10.431H10.8002V10.6177C10.8002 10.7355 10.847 10.8486 10.9304 10.9319C11.0137 11.0153 11.1268 11.0621 11.2447 11.0621C11.3625 11.0621 11.4756 11.0153 11.5589 10.9319C11.6423 10.8486 11.6891 10.7355 11.6891 10.6177V8.88878C11.6891 8.77091 11.6423 8.65786 11.5589 8.57451C11.4756 8.49116 11.3625 8.44434 11.2447 8.44434C11.1268 8.44434 11.0137 8.49116 10.9304 8.57451C10.847 8.65786 10.8002 8.77091 10.8002 8.88878V9.54211H7.55577C7.4379 9.54211 7.32485 9.58894 7.2415 9.67229C7.15815 9.75564 7.11133 9.86868 7.11133 9.98656V14.5954C7.11133 14.7133 7.15815 14.8264 7.2415 14.9097C7.32485 14.9931 7.4379 15.0399 7.55577 15.0399H14.7424C14.8603 15.0399 14.9734 14.9931 15.0567 14.9097C15.1401 14.8264 15.1869 14.7133 15.1869 14.5954V9.98656C15.1869 9.86868 15.1401 9.75564 15.0567 9.67229C14.9734 9.58894 14.8603 9.54211 14.7424 9.54211Z"
                                                fill="black" />
                                        </svg>
                                        Full Time
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <hr class="m-0">
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group m-0 p-2">
                                    <span>
                                        <svg class="mr-2" width="16" height="16" viewBox="0 0 18 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M13.2812 6.90625C13.2812 5.63818 12.7775 4.42205 11.8809 3.5254C10.9842 2.62874 9.76807 2.125 8.5 2.125C7.23193 2.125 6.0158 2.62874 5.11915 3.5254C4.22249 4.42205 3.71875 5.63818 3.71875 6.90625C3.71875 8.86762 5.28806 11.424 8.5 14.4861C11.7119 11.424 13.2812 8.86762 13.2812 6.90625ZM8.5 15.9375C4.60381 12.3962 2.65625 9.38506 2.65625 6.90625C2.65625 5.35639 3.27193 3.87001 4.36784 2.77409C5.46376 1.67818 6.95014 1.0625 8.5 1.0625C10.0499 1.0625 11.5362 1.67818 12.6322 2.77409C13.7281 3.87001 14.3438 5.35639 14.3438 6.90625C14.3438 9.38506 12.3962 12.3962 8.5 15.9375Z"
                                                fill="black" />
                                            <path
                                                d="M8.5 7.4375C8.78179 7.4375 9.05204 7.32556 9.2513 7.1263C9.45056 6.92704 9.5625 6.65679 9.5625 6.375C9.5625 6.09321 9.45056 5.82296 9.2513 5.6237C9.05204 5.42444 8.78179 5.3125 8.5 5.3125C8.21821 5.3125 7.94796 5.42444 7.7487 5.6237C7.54944 5.82296 7.4375 6.09321 7.4375 6.375C7.4375 6.65679 7.54944 6.92704 7.7487 7.1263C7.94796 7.32556 8.21821 7.4375 8.5 7.4375ZM8.5 8.5C7.93641 8.5 7.39591 8.27612 6.9974 7.8776C6.59888 7.47909 6.375 6.93859 6.375 6.375C6.375 5.81141 6.59888 5.27091 6.9974 4.8724C7.39591 4.47388 7.93641 4.25 8.5 4.25C9.06359 4.25 9.60409 4.47388 10.0026 4.8724C10.4011 5.27091 10.625 5.81141 10.625 6.375C10.625 6.93859 10.4011 7.47909 10.0026 7.8776C9.60409 8.27612 9.06359 8.5 8.5 8.5ZM14.2375 11.6875L15.9375 15.9375H11.1562V14.875H5.84375V15.9375H1.0625L2.7625 11.6875H14.2375ZM13.0932 11.6875H3.90681L2.63181 14.875H14.3682L13.0932 11.6875Z"
                                                fill="black" />
                                        </svg>
                                        {{$value->kota_name?$value->kota_name->name:''}}
                                    </span>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    <h3 class="text-blue m-0 mt-4">Kelas Sebelumnya</h3>
    <hr style="4px solid rgba(0, 0, 0, 0.1)">
    {{-- Kelas Sebelumnya --}}
    <div class="mt-4">
        <div id="sld5">
            @foreach($kelas_lama as $key => $val)
            <div>
                <div class="card mr-2">
                    <div class="card-body br-10" style="padding: 1px;">
                        <img src="{{asset($val->image)}}" alt="" width="100%" style="border-radius: 18px">
                        {{-- <img src="/GambarV2/rectangle31.png" alt="" width="100%" style="border-radius: 18px"> --}}
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
            </div>
            @endforeach
        </div>
    </div>
    <div class="text-right">
        <a href="/list-class">
            <h5 class="text-blue">Kelas Selanjutnya</h5>
        </a>
    </div>
    <h3 class="text-blue mt-4">Testimonial</h3>
    <div id="sld4" class="">
        @foreach($testimoni as $key => $value)
        <div class="card mr-2" style="">
            <div class="card-body" style="font-size: 12px; height: 202px;">
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
            slidesToShow: 4,
            slidesToScroll: 4,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: false
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: false
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
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
        $('#sld5').slick({
            centerMode: false,
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
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: false
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 4,
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
                        h +='        <a href="/class/'+v.unique_id+'/'+v.title.replace('/', '-')+'">';
                    h +='    <div class="card">';
                    h +='        <div class="card-body br-10" style="padding: 1px;;">';
                    h +='            <img src="'+v.image+'" alt="" width="100%" style="border-radius:18px">';
                    // h +='            <img src="/GambarV2/rectangle31.png" alt="" width="100%" style="border-radius:18px">';
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
                    if (v.date_end) {
                        h +='        <p for="" class="text-capitalize text-blue m-0 ml-1">'+new Date(v.date_end).toLocaleDateString('id-ID')+'</p>';
                    } else {
                        h +='        <p for="" class="text-capitalize text-blue m-0 ml-1">Akan Datang</p>';
                    }
                    h +='    </div>';
                    h +='    <div class="title text-uppercase ml-1">';
                    h +='            <h6 class="mb-2" title="'+v.title+'">';
                    h +='                '+(v.title.length>=60?v.title.substring(0,57)+' ...':v.title)+' {{-- maksimal 60 huruf --}}';
                    h +='            </h6>';
                    h +='    </div>';
                    h +='        </a>';
                    h +='    <div class="author text-uppercase ml-1">';
                    h +='        <a href="/profile-instructor/'+v.instructor_list[0].id+'/'+v.instructor_list[0].name+'" class="mb-2">';
                    h +=            v.instructor_list[0].name;
                    h +='        </a>';
                    h +='    </div>';
                    h +='    <div class="star text-uppercase ml-1" hidden>';
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