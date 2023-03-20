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
                            <div class="col-md-3 col-lg-3 text-center">
                                <img src="{{$data->image?'/image/loker/'.json_decode($data->image)->url:''}}" alt="" width="100px" height="100%">
                                {{-- @if($data->google_id)
                                    <img src="{{$data->google_id}}" alt="" width="100px" height="100%">
                                @else
                                    <img src="{{asset($data->picture)}}" alt="" width="100px" height="100%">
                                @endif --}}
                            </div>
                            <div class="col-md-8 col-lg-8">
                                <h3 style="margin: 0px">{{ $data->title }}</h3>
                                <small>{{json_decode($data->corporate)->name}}</small>
                                <div class="w-100"></div>
                                <span>Rp. {{number_format($data->gaji_min).' - '.number_format($data->gaji_max)}} /Bulan</span>
                                <div class="w-100"></div>
                                @if($data->type)
                                @foreach(json_decode($data->type) as $key => $value)
                                <span class="text-info">{{$value}}</span>
                                @endforeach
                                @endif
                            </div>
                            <div class="w-100"></div>
                            <div class="card col">
                                <div class="card-body">
                                    <div class="col-md-12" style="padding-bottom: 10px;">
                                        <h4>Skill</h4>
                                        <div class="row mb-4">
                                @if($data->skill)
                                @foreach(json_decode($data->skill) as $key => $value)
                                <span class="badge badge-info">{{$value}}</span>
                                @endforeach
                                @endif
                                        </div>
                                        <div class="mb-4">
                                            <h4>Deskripsi</h4>
                                            {{$data->deskripsi}}
                                        </div>
                                        <hr>
                                        <div class="mb-4">
                                            <h4>Tanggung Jawab</h4>
                                            {{$data->jobdesk}}
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="padding-bottom: 0px;" hidden>
                                        <form id="orderForm" action="{{ '/order' }}" method="POST">
                                            @csrf
                                            <input type="text" id="class_id" name="class_id" value="{{ $data->id }}"
                                                hidden>
                                            <button class="button button-circle btn-block text-center" hidden>Order
                                                sekarang</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <script>
                                // $('#orderForm').submit()
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('front.layout.footer')