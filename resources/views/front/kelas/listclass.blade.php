@include('front.layout.head')
@include('front.layout.topbar')
@include(env('CUSTOM_HEADER', 'front.layout.header'))

{{-- <section id="page-title">
    <div class="entry-image">
        <img src="{{asset('Bg-register-01-Copy.jpg')}}" alt="{{$judul}}" style="max-height: 500px">
    </div>
</section> --}}
<section id="content">
    <div class="content-wrap" style="padding: 0px !important">
        <div class="container clearfix">
            {{-- <h3 class="text-capitalize">{{ $judul }}</h3> --}}
            <div class="entry-image">
                <img src="{{asset($banner)}}" alt="{{$judul}}" style="max-height: auto">
            </div>
            <form action="/list-class" method="POST">
                <div class="row">
                    @csrf
                    <div class="form-group col-md-2">
                        <label for="">Pencarian:</label>
                        <input type="text" name="title" id="title" class="form-control"
                            value="{{ isset($title) ? $title : '' }}">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="">Kategori:</label>
                        <select class="form-control tagging slc2tag" name="slcClassesCategory" id="slcClassesCategory">
                            <option value="">Pilih</option>
                            @foreach ($pencarian['category'] as $ctg)
                            <option value="{{ $ctg }}" @if (isset($slcClassesCategory)) {{ $slcClassesCategory==$ctg
                                ? 'selected' : '' }} @endif>
                                {{ $ctg }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="">Instructor:</label>
                        <select class="form-control tagging" name="instructor" id="instructor">
                            <option value="">Pilih</option>
                            @foreach ($pencarian['instructor'] as $key => $ctg)
                            <option value="{{ $ctg }}" @if (isset($instructor)) {{ $instructor==$ctg ? 'selected' : ''
                                }} @endif>
                                {{ $key }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="accordion" id="accordionExample">
                            <div class="row">
                                {{-- <div class="form-group col">
                                    <label for="">Tag:</label>
                                    <button class="btn btn-light btn-block text-left" type="button"
                                        data-toggle="collapse" data-target="#collapseTag" aria-expanded="true"
                                        aria-controls="collapseTag">
                                        <label for="">Pilih</label>
                                    </button>
                                </div> --}}
                                <div class="form-group col">
                                    <label for="">Jenis:</label>
                                    <button class="btn btn-light btn-block text-left" type="button"
                                        data-toggle="collapse" data-target="#collapseJenis" aria-expanded="true"
                                        aria-controls="collapseJenis">
                                        <label for="">Pilih</label>
                                    </button>
                                </div>
                                <div class="form-group col">
                                    <label for="">Tipe:</label>
                                    <button class="btn btn-light btn-block text-left" type="button"
                                        data-toggle="collapse" data-target="#collapseTipe" aria-expanded="true"
                                        aria-controls="collapseTipe">
                                        <label for="">Pilih</label>
                                    </button>
                                </div>
                            </div>
                            <div id="collapseTag" class="collapse" aria-labelledby="headingOne"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($pencarian['tags'] as $key => $ctg)
                                        <div>
                                            <div class="col d-flex">
                                                <input id="checkbox-{{ $key }}" class="checkbox-style"
                                                    name="checkbox[{{ $ctg }}]" type="checkbox" @if (isset($tags)) {{
                                                    array_key_exists($ctg, $tags) ? 'checked' : '' }} @endif>
                                                <label for="checkbox-{{ $key }}" class="checkbox-style-1-label">{{ $ctg
                                                    }}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div id="collapseJenis" class="collapse" aria-labelledby="headingOne"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($pencarian['jenis'] as $key => $ctg)
                                        <div>
                                            <div class="col d-flex">
                                                <input id="jenis-{{ $key }}" class="checkbox-style"
                                                    name="jeniss[{{ $ctg }}]" type="checkbox" @if (isset($jeniss)) {{
                                                    array_key_exists($ctg, $jeniss) ? 'checked' : '' }} @endif>
                                                <label for="jenis-{{ $key }}" class="checkbox-style-1-label">{{ $ctg
                                                    }}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div id="collapseTipe" class="collapse" aria-labelledby="headingOne"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($pencarian['tipe'] as $key => $ctg)
                                        <div>
                                            <div class="col d-flex">
                                                <input id="tipe-{{ $key }}" class="checkbox-style"
                                                    name="tipe[{{ $ctg }}]" type="checkbox" @if (isset($tipe)) {{
                                                    array_key_exists($ctg, $tipe) ? 'checked' : '' }} @endif>
                                                <label for="tipe-{{ $key }}" class="checkbox-style-1-label">{{ $ctg
                                                    }}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-sm mt-2"
                        style="padding-left: 15px !important; padding-right: 15px !important">Cari</button>
                </div>

            </form>
            <div class="row gutter-40 col-mb-80">
                <div class="postcontent col-lg-12">
                    {{-- @if ($class['data']) --}}
                    <div class="single-event">
                        <div class="row" id="listkelas">
                            {{-- @foreach ($class['data'] as $v) --}}
                            {{-- <div class="col-lg-3 col-sm-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card" style="min-height: 0px !important">
                                            <img src="{{ $v['image'] }}" width="100%">
                                        </div>
                                        <p class="mt-2 text-overflow" style="line-height: 1 !important;">
                                            {{ substr($v['title'], 0, 115) }}... </p>
                                        <h6 style="margin: 0px !important; font-weight: normal;">
                                            @if ($v['date_start'] == $v['date_end'])
                                            {{ \Carbon\Carbon::parse($v['date_start'])->format('d-m-Y') }}
                                            @else
                                            {{ \Carbon\Carbon::parse($v['date_start'])->format('d-m-Y') }}
                                            s/d
                                            {{ \Carbon\Carbon::parse($v['date_end'])->format('d-m-Y') }}
                                            @endif
                                        </h6>
                                        <a href="/profile-instructor/3/Dani" class="d-flex mt-2">
                                            <img class="mr-3 rounded-circle" src="@if (json_decode($v['instructor_list'][0]->picture)){{ asset('Image/' . json_decode($v['instructor_list'][0]->picture)->url) }}
                                                @else{{$v['instructor_list'][0]->picture}} @endif" alt="Generic"
                                                placeholder="" image="" style="max-width:50px; max-height:50px;">
                                            <div class="">
                                                <label class="d-block mb-0">{{ $v['instructor_list'][0]->name }}
                                                </label>
                                                @if ($v['pricing'])
                                                @if ($v['pricing']->promo)
                                                <span class="d-block mb-0"> Harga</span>
                                                <del>Rp.
                                                    {{ number_format($v['pricing']->price) }}</del>
                                                @else
                                                <span class="d-block mb-0"> Harga</span>
                                                <small>{{ $v['pricing']->price }}</small>
                                                @endif
                                                @endif
                                            </div>
                                        </a>
                                        <div class="text-center mt-2 w-100">
                                            @if ($v['pricing'])
                                            @if ($v['pricing']->promo)
                                            @endif
                                            <h3 style=" color:#139700 !important;">Rp.
                                                {{ number_format($v['pricing']->price - $v['pricing']->promo_price)
                                                }}<span class="badge badge-danger badge-sm ml-2">{{
                                                    ($v['pricing']->promo_price / $v['pricing']->price) * 100 }}
                                                    %</span></h3>
                                            @endif
                                            <a class="btn btn-primary btn-block btn-rounded"
                                                style="border-radius:10px !important"
                                                href="/class/{{ $v['unique_id'] }}/{{ str_replace('/', '-', $v['title']) }}">
                                                Detail </a>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <div class="col-lg-4 col-sm-6">
                                <div class="card shadow mb-5 bg-white" style="border-radius: 8px; min-height: 708px">
                                    <img src="{{ $v['image'] }}" width="100%" style="border-radius: 8px;">
                                    <div class="card-body" style="padding: 0.75rem">
                                        <span class="btn mt-4"
                                            style="border-radius: 8px;position: absolute; bottom: 10px; left: 10px; right: 10px;">
                                            <h4 class="text-left text-capitalize m-0">{{$v['title']}}</h4>
                                            <p class="text-left"
                                                style="margin: 0px !important; font-size:10px !important;">
                                                {{$v['date_end']}}
                                            </p>
                                            <a href="/profile-instructor/{{$v['instructor_list'][0]->id}}/{{$v['instructor_list'][0]->name}}"
                                                class="d-flex mt-2"> <img class="mr-3 rounded-circle"
                                                    @if(json_decode($v['instructor_list'][0]->picture))
                                                src="/Image/{{json_decode($v['instructor_list'][0]->picture)->url}}"
                                                @else
                                                src=""
                                                @endif
                                                alt="Generic" placeholder="" image=""
                                                style="max-width:50px; max-height:50px;">
                                                <div class="text-left"> <small class="d-block mb-0">INSTRUCTOR</small>
                                                    <h5 class="text-uppercase d-block mb-0">
                                                        {{$v['instructor_list'][0]->name}}</h5> <small
                                                        class="text-uppercase d-block mb-0"
                                                        style="font-size:10px !important">{{$v['instructor_list'][0]->title}}</small>
                                                </div>
                                                <div class="ml-2 flex-fill text-center">
                                                    <label class="d-block mb-0">Harga </label>
                                                    @if ($v['pricing'])
                                                    @if ($v['pricing']->promo)
                                                    <del> Rp.
                                                        {{number_format($v['pricing']->price)}}</del>
                                                    <sup class="badge badge-danger"
                                                        style="font-size: 8px">{{number_format(($v['pricing']->promo_price
                                                        / $v['pricing']->price) * 100)}} %</sup>
                                                    @else
                                                    <del> Rp.
                                                        {{number_format($v['pricing']->price)}}</del>
                                                    <sup class="badge badge-danger"
                                                        style="font-size: 8px">{{number_format(($v['pricing']->promo_price
                                                        / $v['pricing']->price) * 100)}} %</sup>
                                                    @endif
                                                    @else
                                                    <small class="text-primary mb-2">Rp. -</small>
                                                    @endif
                                                </div>
                                            </a>
                                            <div class="text-center mt-2 w-100">
                                                @if ($v['pricing'])
                                                @if ($v['pricing']->promo)
                                                <h3 class="text-primary mb-2">Rp. {{number_format($v['pricing']->price -
                                                    $v['pricing']->promo_price)}}</h3>
                                                @else
                                                <h3 class="text-primary mb-2">Rp.
                                                    {{number_format($v['pricing']->price)}}</h3>
                                                @endif
                                                @else
                                                <h3 class="text-primary mb-2">Rp. -</h3>
                                                @endif
                                            </div>
                                            <div class="row align-items-center">
                                                <a class="btn btn-primary btn-block btn-rounded"
                                                    style="border-radius:10px !important"
                                                    href="/class/{{ $v['unique_id'] }}/{{ str_replace('/', '-', $v['title']) }}">
                                                    Detail </a>
                                                <div class="col text-left ml-2">
                                                    <small class="fs-2">Kode Promo</small>
                                                    <h4 class=""
                                                        style="margin-bottom: 0px !important; font-weight: bold">
                                                        {{ $v['kode']?$v['kode']:'-' }}</h4>
                                                </div>
                                                <div class="col">
                                                    <span class="btn btn-outline-primary btn-sm float-right"
                                                        style="border-radius: 8px"
                                                        onclick="handleCopyTextFromParagraph('{{ $v['kode'] }}')">Copy</span>
                                                </div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- @endforeach --}}
                        </div>
                        <hr>
                        {{-- <div class="row">
                            <div class="col-lg-12 text-center">
                                <nav aria-label="Page navigation blog">
                                    <ul class="pagination justify-content-center">
                                        @foreach ($class['links'] as $k => $p)
                                        <li class="page-item {{ $p['active'] ? 'active' : '' }}"><a class="page-link"
                                                href="{{ $p['url'] }}">
                                                @if(strpos( $p['label'], 'pagination' ) !== false)
                                                <?= str_replace('pagination.','',$p['label']) ?>
                                                @else
                                                <?= $p['label'] ?>
                                                @endif
                                            </a></li>
                                        @endforeach
                                    </ul>
                                </nav>
                            </div>
                        </div> --}}
                    </div>
                    {{-- @endif --}}
                </div>
            </div>
        </div>
        <input type="text" id="isLogin" value="@auth 1 @endauth" hidden>
        <input type="text" id="longPage" value="{{$class['last_page']}}" hidden>
    </div>
</section><!-- #content end -->
<script>
    let no_scroll = 0;
    let page_scroll = 0;
    let load_scoll = -1;
    let isLogin = $('#isLogin').val();
    let longPage = $('#longPage').val();
    $(document).ready(function () {
        window.onscroll = function (e) {
            if (window.pageYOffset != undefined) {
                no_scroll = pageYOffset;
            } else {
                let x_axis, y_axis, doc = document,
                    ele = doc.documentElement,
                    b = doc.body;
                x_axis = ele.scrollLeft || b.scrollLeft || 0;
                y_axis = ele.scrollTop || b.scrollTop || 0;
                no_scroll = y_axis;
            }
            console.log('no_scroll : '+no_scroll);
            if (no_scroll >= 1200 && isLogin != 1) {
                $('#modelId').modal('show');
                $('#hidemodallogin').attr('hidden',true);
                return false;
            }
            if (page_scroll > longPage) {
                return false;
            }
            if (no_scroll > load_scoll) {
                load_scoll+=1200;
                console.log('load data '+page_scroll);
            page_scroll++;
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: '/list-class?page='+page_scroll,
                    type: 'GET',
                    beforeSend: function() {
                        $('.ajax-load').show();
                        // console.log('getData');
                    },
                    success: function(response) {
                        // Object.keys(response).forEach(key => {
                        //     console.log(key.replace(/[^a-zA-Z0-9]/g,''));
                        //     $('#' + key.replace(/[^a-zA-Z0-9]/g,'')).append(response[key]);
                        // });
                        // $('#halaman').val(null)
                        // if (response.next_page_url) {
                        //     $('#halaman').val(response.next_page_url)
                        // }
                        // resolve();
                        console.log(response.data);
                        let html='';
                        if (response.data) {
                            response.data.forEach(dt => {
                                html+='<div class="col-lg-4 col-sm-6">';
                                html+='    <div class="card shadow mb-5 bg-white" style="border-radius: 8px; min-height: 708px">';
                                html+='        <img src="'+dt.image+'" width="100%" style="border-radius: 8px;">';
                                html+='        <div class="card-body" style="padding: 0.75rem">';
                                html+='            <span class="btn mt-4"';
                                html+='                style="border-radius: 8px;position: absolute; bottom: 10px; left: 10px; right: 10px;">';
                                html+='                <h4 class="text-left text-capitalize m-0">'+dt.title+'</h4>';
                                html+='                <p class="text-left"';
                                html+='                    style="margin: 0px !important; font-size:10px !important;">'+dt.date_end;
                                html+='                </p>';
                                html+='                <a href="/profile-instructor/'+dt.instructor_list[0].id+'/'+dt.instructor_list[0].name+'}}"';
                                html+='                    class="d-flex mt-2"> <img class="mr-3 rounded-circle"';
                                if (dt.instructor_list[0].picture_src) {
                                    html+='                    src="/Image/'+dt.instructor_list[0].picture_src.url+'"';
                                }else{
                                    html+='                    src=""';
                                }
                                html+='                    alt="Generic" placeholder="" image=""';
                                html+='                    style="max-width:50px; max-height:50px;">';
                                html+='                    <div class="text-left"> <small class="d-block mb-0">INSTRUCTOR</small>';
                                html+='                        <h5 class="text-uppercase d-block mb-0">'+dt.instructor_list[0].name+'</h5> <small';
                                html+='                            class="text-uppercase d-block mb-0"';
                                html+='                            style="font-size:10px !important">'+dt['instructor_list'][0].title+'</small>';
                                html+='                    </div>';
                                // html+='                    {{-- <div class="ml-2 flex-fill text-center">';
                                // html+='                        <label class="d-block mb-0">Harga </label>';
                                // html+='                        @if ($v['pricing'])';
                                // html+='                        @if ($v['pricing']->promo)';
                                // html+='                        <del> Rp.';
                                // html+='                            {{number_format($v['pricing']->price)}}</del>';
                                // html+='                        <sup class="badge badge-danger"';
                                // html+='                            style="font-size: 8px">{{number_format(($v['pricing']->promo_price';
                                // html+='                            / $v['pricing']->price) * 100)}} %</sup>';
                                // html+='                        @else';
                                // html+='                        <del> Rp.';
                                // html+='                            {{number_format($v['pricing']->price)}}</del>';
                                // html+='                        <sup class="badge badge-danger"';
                                // html+='                            style="font-size: 8px">{{number_format(($v['pricing']->promo_price';
                                // html+='                            / $v['pricing']->price) * 100)}} %</sup>';
                                // html+='                        @endif';
                                // html+='                        @else';
                                // html+='                        <small class="text-primary mb-2">Rp. -</small>';
                                // html+='                        @endif';
                                // html+='                    </div> --}}';
                                html+='                </a>';
                                html+='                <div class="text-center mt-2 w-100">';
                                    if (dt.pricing) {
                                        if (dt.pricing.promo) {
                                            html+='                    <h3 class="text-primary mb-2">Rp. '+dt.pricing.price+' - '+dt.pricing.promo_price+'</h3>';
                                        }else{
                                            html+='                    <h3 class="text-primary mb-2">Rp.'+dt.pricing.price+'</h3>';
                                        }
                                    }else{
                                        html+='                    <h3 class="text-primary mb-2">Rp. -</h3>';
                                    }
                                html+='                </div>';
                                html+='                <div class="row align-items-center">';
                                html+='                    <a class="btn btn-primary btn-block btn-rounded"';
                                html+='                        style="border-radius:10px !important"';
                                html+='                        href="/class/'+dt.unique_id+'/'+dt.title.replace('/','-')+'">';
                                html+='                        Detail </a>';
                                // html+='                    {{-- <div class="col text-left ml-2">';
                                // html+='                        <small class="fs-2">Kode Promo</small>';
                                // html+='                        <h4 class=""';
                                // html+='                            style="margin-bottom: 0px !important; font-weight: bold">';
                                // html+='                            {{ $v['kode']?$v['kode']:'-' }}</h4>';
                                // html+='                    </div>';
                                // html+='                    <div class="col">';
                                // html+='                        <span class="btn btn-outline-primary btn-sm float-right"';
                                // html+='                            style="border-radius: 8px"';
                                // html+='                            onclick="handleCopyTextFromParagraph('{{ $v['kode'] }}')">Copy</span>';
                                // html+='                    </div> --}}';
                                html+='                </div>';
                                html+='            </span>';
                                html+='        </div>';
                                html+='    </div>';
                                html+='</div>';
                            });
                            $('#listkelas').append(html);
                        }
                    }
                });
            });
            }
            
        }
    })
    $('#tags').select2({
            tagging: true,
        })
</script>
@section('custom-js')
@endsection
@include(env('CUSTOM_FOOTER', 'front.layout.footer'))