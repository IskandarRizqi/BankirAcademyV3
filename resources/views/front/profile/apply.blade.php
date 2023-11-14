@if(!$ismember)
<img src="{{asset('front/images/A_BLM_MEMBER.jpg')}}" alt="">
@else
<h3 class="text-uppercase">Job yang sudah di Apply</h3>
<div class="title-block">
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Bank</th>
                            <th>Jabatan</th>
                            <th>Detail</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lamaran as $key => $v)
                        <td>{{$key+1}}</td>
                        <td>{{$v->lamaran->nama}}</td>
                        <td>{{$v->lamaran->title}}</td>
                        <td><a href="/loker/{{$v->lamaran->id}}/detail">Detail</a></td>
                        <td>{{$v->status_name}}</td>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-3" hidden>
            <h3>Loker</h3>
            @foreach($lokerall as $key => $value)
            <div class="card" style="min-height: auto; border-radius:20px">
                <div class="card-body">
                    <div class="d-flex">
                        <img src="{{$value->image?'/image/loker/'.json_decode($value->image)->url:''}}" alt=""
                            width="60px" height="60px" style="border-radius: 13px">
                        {{-- @if($value->google_id)
                        <img src="{{$value->picture}}" alt="" width="60px" height="60px" style="border-radius: 13px">
                        @else
                        <img src="{{asset($value->picture?$value->picture:'aki.png')}}" alt="" width="60px"
                            height="60px" style="border-radius: 13px">
                        @endif --}}
                        <div class="ml-2">
                            <h3 style="margin: 0px">{{substr($value->title,0,16)}}</h3> {{--maksimal 15 karakters--}}
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
@endif