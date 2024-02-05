@include('front.layout.head')
@include('front.layout.topbar')
@include(env('CUSTOM_HEADER', 'front.layout.header'))
<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">
            <div class="row gutter-40 col-mb-80">
                <div class="postcontent col-lg-9">
                    <div class="single-event">
                        <div class="row col-mb-50">
                            <div class="col-md-7 col-lg-7 text-center">
                                @if($data->perusahaan)
                                @php
                                $js = json_decode($data->perusahaan->image)
                                @endphp
                                <img src="{{$js?'/image/loker/'.$js->url:''}}" alt="" width="100%" height="100%">
                                @else
                                <img src="{{$data->image?'/image/loker/'.json_decode($data->image)->url:''}}" alt=""
                                    width="100%" height="100%">
                                @endif
                            </div>
                            <div class="col-md-5 col-lg-5">
                                <h3 style="margin: 0px">{{ $data->title }}</h3>
                                @if($data->perusahaan)
                                <small>{{$data->perusahaan->nama}}</small>
                                @else
                                @if($data->nama)
                                <small>{{$data->nama}}</small>
                                @else
                                <small>{{json_decode($data->corporate)?json_decode($data->corporate)->name:'Anugrah
                                    Karya'}}</small>
                                @endif
                                @endif
                                <div class="w-100"></div>
                                <span><i class="icon-wallet mr-2"></i>{{$data->gaji_min?'Rp.
                                    '.number_format($data->gaji_min):'Gaji
                                    Competitive'}}</span>
                                <div class="w-100"></div>
                                {{-- @if($data->type)
                                <i class="icon-medal mr-2"></i>
                                @foreach(json_decode($data->type) as $key => $value)
                                <span class="text-info">{{$value}}</span>
                                @endforeach
                                @endif --}}
                                <div class="w-100"></div>
                                <span>
                                    <i class="icon-calendar-plus mr-2"></i>
                                    {{-- {{\Carbon\Carbon::parse($data->tanggal_awal)->format('d-m-Y')}} - --}}
                                    {{\Carbon\Carbon::parse($data->tanggal_akhir)->format('d-m-Y')}}
                                </span>
                            </div>
                            <div class="w-100"></div>
                            <div class="card col" style="border-radius: 20px">
                                <div class="card-body">
                                    <div class="col-md-12" style="padding-bottom: 10px;">
                                        {{-- <h4>Skill</h4>
                                        <div class="row mb-4">
                                            @if($data->skill)
                                            @foreach(json_decode($data->skill) as $key => $value)
                                            <span class="badge badge-info">{{$value}}</span>
                                            @endforeach
                                            @endif
                                        </div> --}}
                                        <div class="mb-4">
                                            <h4>Syarat</h4>
                                            {!!$data->deskripsi!!}
                                        </div>
                                        <hr>
                                        <div class="mb-4">
                                            <h4>Jobdesk</h4>
                                            {!!$data->jobdesk!!}
                                        </div>
                                        <div class="mb-4">
                                            <h4>Alamat</h4>
                                            @if($data->perusahaan)
                                            {{$data->perusahaan->alamat}}
                                            @else
                                            {{$data->alamat}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="padding-bottom: 0px;">
                                        <form id="orderForm" action="{{ '/loker/apply' }}" method="POST">
                                            @csrf
                                            <input type="text" id="class_id" name="class_id" value="{{ $data->id }}"
                                                hidden>
                                            <button class="button button-circle btn-block text-center">Kirim
                                                Lamaran</button>
                                        </form>
                                    </div>
                                    {{-- <a href="mailto:{{$data->email}}">
                                        <button class="button button-circle btn-block text-center">Kirim
                                            Lamaran</button>
                                    </a> --}}
                                </div>
                            </div>
                            <script>
                                // $('#orderForm').submit()
                            </script>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    @foreach($lain as $key => $value)
                    <div class="card" style="min-height: auto; border-radius:20px">
                        <div class="card-body">
                            <div class="d-flex">
                                <img src="{{$value->image?'/image/loker/'.json_decode($value->image)->url:''}}" alt=""
                                    width="60px" height="60px" style="border-radius: 13px">
                                {{-- @if($value->google_id)
                                <img src="{{$value->picture}}" alt="" width="60px" height="60px"
                                    style="border-radius: 13px">
                                @else
                                <img src="{{asset($value->picture?$value->picture:'aki.png')}}" alt="" width="60px"
                                    height="60px" style="border-radius: 13px">
                                @endif --}}
                                <div class="ml-2">
                                    <h3 style="margin: 0px">{{substr($value->title,0,16)}}</h3> {{--maksimal 15
                                    karakters--}}
                                    @if($value->nama)
                                    <small>{{$value->nama}}</small>
                                    @else
                                    <small>{{json_decode($value->corporate)?json_decode($value->corporate)->name:'Anugrah
                                        Karya'}}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-2">
                                <p style="margin: 0px"><i class="icon-suitcase mr-2"></i>
                                    @if($value->skill)
                                    @foreach(json_decode($value->skill) as $key => $v)
                                    <span class="badge badge-info">{{$v}}</span>
                                    @endforeach
                                    @endif
                                </p>
                                @if($value->gaji_min > 0)
                                <p style="margin: 0px"><i class="icon-print mr-2"></i>{{$value->gaji_min}}</p>
                                @else
                                <p style="margin: 0px"><i class="icon-print mr-2"></i>Gaji Tidak Ditampilkan</p>
                                @endif
                                <p class="text-center text-secondary mb-2">
                                    {{\Carbon\Carbon::parse($value->tanggal_awal)->format('d-m-Y')}} -
                                    {{\Carbon\Carbon::parse($value->tanggal_akhir)->format('d-m-Y')}}
                                </p>
                            </div>

                            <a class="btn btn-primary btn-sm btn-block" href="/loker/{{$value->id}}/detail">Detail</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@include('front.layout.footer')