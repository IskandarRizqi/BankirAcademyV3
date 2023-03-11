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
                                @if($data->google_id)
                                    <img src="{{$data->google_id}}" alt="" width="100px" height="100%">
                                    @else
                                    <img src="{{asset($data->picture)}}" alt="" width="100px" height="100%">
                                @endif
                                {{-- <div class="entry-image mb-0">
                                </div> --}}
                            </div>
                            <div class="col-md-8 col-lg-8">
                                <h3 style="margin: 0px">{{ $data->title }}</h3>
                                <small>{{json_decode($data->corporate)->name}}</small>
                                <div class="w-100"></div>
                                <span>Rp. {{number_format($data->gaji_min).' - '.number_format($data->gaji_max)}} /Bulan</span>
                                <div class="w-100"></div>
                                <span class="badge badge-info">a</span>
                                <span class="badge badge-info">b</span>
                            </div>
                            <div class="w-100"></div>
                            <div class="card col">
                                <div class="card-body">
                                    <div class="col-md-12" style="padding-bottom: 10px;">
                                        <h4>Kelas Timeline</h4>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                {{--  --}}
                                            </div>
                                            <div class="col">
                                                <label for="">Category</label>
                                                <p>{{ '$data->category' }}</p>
                                            </div>
                                            <div class="col">
                                                {{--  --}}
                                            </div>
                                            <div class="col">
                                                <p for="" style="margin: 0px">Tanggal</p>
                                                <span class="badge badge-info">
                                                    {{--  --}}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="">
                                                    {{--  --}}
                                                </label>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="mb-4">
                                            {{--  --}}
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered" id="datatable1"
                                                cellspacing="0" width="100%">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>No</th>
                                                        <th>Waktu</th>
                                                        <th>Deskripsi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>2</td>
                                                        <td>3</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="padding-bottom: 0px;">
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