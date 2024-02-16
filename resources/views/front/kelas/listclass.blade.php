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
                <div class="row mr-1 ml-1">
                    @csrf
                    <div class="form-group col-md-2">
                        <label for="">Pencarian:</label>
                        <input type="text" name="titlekelas" id="titlekelas" class="form-control"
                            value="{{ isset($titlekelas) ? $titlekelas : '' }}" style="border-radius: 20px;">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="">Kategori:</label>
                        <select class="form-control tagging slc2tag" name="slcClassesCategory" id="slcClassesCategory"
                            style="border-radius: 20px;">
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
                        <select class="form-control tagging" name="instructor" id="instructor"
                            style="border-radius: 20px;">
                            <option value="">Pilih</option>
                            @foreach ($pencarian['instructor'] as $key => $ctg)
                            <option value="{{ $ctg }}" @if (isset($instructor)) {{ $instructor==$ctg ? 'selected' : ''
                                }} @endif>
                                {{ $key }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="accordion" id="accordionExample">
                            <div class="row">
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
                                                <input id="checkbox-{{ $key }}" class="checkbox-style ini-checkbox-1"
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
                                                <input id="jenis-{{ $key }}" class="checkbox-style ini-checkbox-1"
                                                    name="jeniss[{{ $ctg }}]" type="checkbox" @if (isset($jeniss)) {{
                                                    in_array(strtolower($ctg), $jeniss) ? 'checked' : '' }} @endif
                                                    value="{{$ctg}}">
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
                                                <input id="tipe-{{ $key }}" class="checkbox-style ini-checkbox-2"
                                                    name="tipe[{{ $ctg }}]" type="checkbox" @if (isset($tipe)) {{
                                                    in_array($ctg, $tipe) ? 'checked' : '' }} @endif value="{{$ctg}}">
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
                    <div class="col-lg-2 mt-5">
                        <span class="btn btn-primary btn-block btn-sm"
                            style="padding-left: 15px !important; padding-right: 15px !important; border-radius: 20px;"
                            id="btnlistkelascari">Telusuri</span>
                    </div>
                </div>

            </form>
            <div class="row gutter-40 col-mb-80">
                <div class="postcontent col-lg-12">
                    {{-- @if ($class['data']) --}}
                    <div class="single-event">
                        <div class="row" id="listkelas">
                        </div>
                        <hr>
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
    let page_scroll = 1;
    let load_scoll = -1;
    let isLogin = $('#isLogin').val();
    let longPage = $('#longPage').val();
    $(document).ready(function () {
        loaddata()
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
            loaddata();
            
        }
        }
        $('#btnlistkelascari').on('click',function () {
            loaddata();
        })
    })
    function loaddata() {
        const jenis = [];
        const type = [];
        $('.ini-checkbox-1').each(function(idx, el){
        if($(el).is(':checked')){
            if (!($(el).val() in jenis)) {
                jenis.push($(el).val())
            }
        }
        });
        $('.ini-checkbox-2').each(function(idx, el){
        if($(el).is(':checked')){ 
            if (!($(el).val() in type)) {
                type.push($(el).val())
            }
        }
        });
        // return console.log([jenis,type]);
            // return new Promise((resolve, reject) => {
                $.ajax({
                    url: '/list-class',
                    data:{
                        page:page_scroll,
                        titlekelas:$('#titlekelas').val(),
                        kategori:$('#slcClassesCategory').val(),
                        instructor:$('#instructor').val(),
                        jenis:JSON.stringify(jenis),
                        type:JSON.stringify(type),
                    },
                    type: 'GET',
                    beforeSend: function() {
                        $('.ajax-load').show();
                    },
                    success: function(response) {
                        let html='';
                        if (response.data.length > 0) {
                            response.data.forEach(dt => {
                                html+='<div class="col-lg-3 col-sm-6">';
                                html+='    <div class="card shadow mb-5 bg-white" style="border-radius: 8px; min-height: 708px">';
                                html+='        <img src="'+dt.image+'" width="100%" style="border-radius: 8px;">';
                                html+='        <div class="card-body" style="padding: 0.75rem">';
                                html+='        <p class="m-0">'+dt.contents+'</p>';
                                html+='            <span class="mt-4" style="border-radius: 8px;bottom: 15px; left: 15px; right: 15px; position: absolute;"';
                                html+='                style="border-radius: 8px;">';
                                html+='                <h4 class="text-left text-capitalize m-0">';
                                html+='                     '+dt.title.length>55?dt.title.substring(0,50)+'...':dt.title;
                                html+='                 </h4>';
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
                                html+='                    <div class="text-left"> <small class="d-block mb-0">Instructor</small>';
                                html+='                        <h5 class="text-capitalize d-block mb-0">'+dt.instructor_list[0].name+'</h5> <small';
                                html+='                            class="text-capitalize d-block mb-0"';
                                html+='                            style="font-size:10px !important">'+dt['instructor_list'][0].title+'</small>';
                                html+='                    </div>';
                                html+='                </a>';
                                html+='                <div class="text-center mt-2 w-100">';
                                    if (dt.pricing) {
                                        if (dt.pricing.gratis) {
                                            html+='                    <h3 class="text-primary mb-2">GRATIS</h3>';
                                        }else if (dt.pricing.promo) {
                                            html+='                    <h3 class="text-primary mb-2">Rp. '+(dt.pricing.price - dt.pricing.promo_price).toLocaleString()+'</h3>';
                                        }else{
                                            html+='                    <h3 class="text-primary mb-2">Rp.'+dt.pricing.price.toLocaleString()+'</h3>';
                                        }
                                    }else{
                                        html+='                    <h3 class="text-primary mb-2">Rp. -</h3>';
                                    }
                                html+='                    <a class="btn btn-primary btn-block btn-rounded"';
                                html+='                        style="border-radius:10px !important"';
                                html+='                        href="/class/'+dt.unique_id+'/'+dt.title.replaceAll('/','-')+'">';
                                html+='                        Detail </a>';
                                html+='                </div>';
                                html+='                <div class="row align-items-center">';
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
            // });
    }
    $('#tags').select2({
            tagging: true,
        })
</script>
@section('custom-js')
@endsection
@include(env('CUSTOM_FOOTER', 'front.layout.footer'))