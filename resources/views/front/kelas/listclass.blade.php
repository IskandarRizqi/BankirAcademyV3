@include('front.layout.head')
@include('front.layout.topbar')
@include(env('CUSTOM_HEADER', 'front.layout.header'))

<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">
            <h3>Kelas</h3>
            @if ($class['data'])

            <div class="row gutter-40 col-mb-80">
                <div class="postcontent col-lg-12">
                    <div class="single-event">
                        <div class="row">
                            @foreach ($class['data'] as $v)
                            <div class="col-lg-3 col-sm-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card" style="min-height: 0px !important">
                                            <img src="{{ $v['image'] }}" width="100%">
                                        </div>
                                        <h5 class="text-uppercase mt-2" style="margin-bottom: 0px !important">
                                            {{$v['title'] }}</h5>
                                        <h6 style="margin: 0px !important;">
                                            @if ($v['date_start'] == $v['date_end'])
                                            {{\Carbon\Carbon::parse($v['date_start'])->format('d-m-Y')}}
                                            @else
                                            {{\Carbon\Carbon::parse($v['date_start'])->format('d-m-Y')}} s/d
                                            {{\Carbon\Carbon::parse($v['date_end'])->format('d-m-Y')}}
                                            @endif
                                        </h6>
                                        <a href="/profile-instructor/3/Dani" class="d-flex mt-2">
                                            <img class="mr-3 rounded-circle"
                                                src="/Image/{{json_decode($v['instructor_list'][0]->picture)->url}}"
                                                alt="Generic" placeholder="" image=""
                                                style="max-width:50px; max-height:50px;">
                                            <div class="">
                                                <label class="d-block mb-0">{{$v['instructor_list'][0]->name}}
                                                    {{-- <small>{{$v['instructor_list'][0]->title}}</small> --}}
                                                </label>
                                            </div>
                                            <div class="ml-2 flex-fill text-right">
                                                @if ($v['pricing'])
                                                @if ($v['pricing']->promo)
                                                <label class="d-block mb-0"> Harga</label>
                                                <del>Rp. {{number_format($v['pricing']->price)}}</del>
                                                @else
                                                <label class="d-block mb-0"> Harga</label>
                                                <small>{{$v['pricing']->price}}</small>
                                                @endif
                                                @endif
                                            </div>
                                        </a>
                                        <div class="text-center mt-2 w-100">
                                            @if ($v['pricing'])
                                            @if ($v['pricing']->promo)
                                            @endif
                                            <h3 style=" color:#139700 !important;">Rp. {{
                                                number_format($v['pricing']->price-$v['pricing']->promo_price)}}<span
                                                    class="badge badge-danger badge-sm ml-2">{{($v['pricing']->promo_price/$v['pricing']->price)*100}}
                                                    %</span></h3>
                                            @endif
                                            <a class="btn btn-primary btn-block btn-rounded"
                                                style="border-radius:10px !important"
                                                href="/class/{{$v['unique_id']}}/{{str_replace('/','-',$v['title'])}}">
                                                Detail </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card" style="min-height: 0px !important">
                                            <img src="{{ $v['image'] }}" width="100%">
                                        </div>
                                        <h5 class="text-uppercase mt-2" style="margin-bottom: 0px !important">
                                            {{$v['title'] }}</h5>
                                        <h6 style="margin: 0px !important;">
                                            @if ($v['date_start'] == $v['date_end'])
                                            {{\Carbon\Carbon::parse($v['date_start'])->format('d-m-Y')}}
                                            @else
                                            {{\Carbon\Carbon::parse($v['date_start'])->format('d-m-Y')}} s/d
                                            {{\Carbon\Carbon::parse($v['date_end'])->format('d-m-Y')}}
                                            @endif
                                        </h6>
                                        <a href="/profile-instructor/3/Dani" class="d-flex mt-2">
                                            <img class="mr-3 rounded-circle"
                                                src="/Image/{{json_decode($v['instructor_list'][0]->picture)->url}}"
                                                alt="Generic" placeholder="" image=""
                                                style="max-width:50px; max-height:50px;">
                                            <div class="">
                                                <label class="d-block mb-0">{{$v['instructor_list'][0]->name}}
                                                    {{-- <small>{{$v['instructor_list'][0]->title}}</small> --}}
                                                </label>
                                            </div>
                                            <div class="ml-2 flex-fill text-right">
                                                @if ($v['pricing'])
                                                @if ($v['pricing']->promo)
                                                <label class="d-block mb-0"> Harga</label>
                                                <del>Rp. {{number_format($v['pricing']->price)}}</del>
                                                @else
                                                <label class="d-block mb-0"> Harga</label>
                                                <small>{{$v['pricing']->price}}</small>
                                                @endif
                                                @endif
                                            </div>
                                        </a>
                                        <div class="text-center mt-2 w-100">
                                            @if ($v['pricing'])
                                            @if ($v['pricing']->promo)
                                            @endif
                                            <h3 style=" color:#139700 !important;">Rp. {{
                                                number_format($v['pricing']->price-$v['pricing']->promo_price)}}<span
                                                    class="badge badge-danger badge-sm ml-2">{{($v['pricing']->promo_price/$v['pricing']->price)*100}}
                                                    %</span></h3>
                                            @endif
                                            <a class="btn btn-primary btn-block btn-rounded"
                                                style="border-radius:10px !important"
                                                href="/class/{{$v['unique_id']}}/{{str_replace('/','-',$v['title'])}}">
                                                Detail </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <a href="/class/{{ $v['unique_id'] }}/{{ urlencode($v['title']) }}">
                                <div class="card">
                                    <div class="card-body">
                                        <img src="" alt="Thumbnail" style="width: 130px;max-height:75px;">
                                        &nbsp;&nbsp;&nbsp;<span style="font-size: 19px; font-weight: bold;"></span>
                                        <span class="text-secondary float-right">{{
                                            Carbon\Carbon::parse($v['created_at'])->format('d-m-Y
                                            H:i:s') }}</span>
                                    </div>
                                </div>
                            </a> --}}
                            @endforeach
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <nav aria-label="Page navigation blog">
                                    <ul class="pagination justify-content-center">
                                        @foreach ($class['links'] as $k => $p)
                                        <li class="page-item {{ $p['active'] ? 'active' : '' }}"><a class="page-link"
                                                href="{{ $p['url'] }}">
                                                <?= $p['label'] ?>
                                            </a></li>
                                        @endforeach
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</section><!-- #content end -->
@include(env('CUSTOM_FOOTER', 'front.layout.footer'))