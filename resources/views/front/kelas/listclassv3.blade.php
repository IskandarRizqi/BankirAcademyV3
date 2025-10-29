
@extends('front.layout.v3.main')
@section('content')
<br>
<br>
<style>
        .form-control, .btn-light, .btn-primary {
        border-radius: 20px !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        border: 1px solid #dce3f1;
        font-size: 14px;
    }

    label {
        font-weight: 600;
        font-size: 13px;
        color: #555;
    }

    .filter-panel {
        background: #ffffff;
        border-radius: 15px;
        padding: 20px;
        border: 1px solid #e0e0e0;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 20px;
    }

    .accordion-button-custom {
        background-color: #f8f9fa;
        border-radius: 20px;
        text-align: left;
        width: 100%;
        padding: 10px 15px;
        font-size: 14px;
        font-weight: 600;
        border: 1px solid #d1d1d1;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .accordion-button-custom:hover {
        background-color: #eef4ff;
        border-color: #007bff;
    }

    .accordion-body-custom {
        padding: 15px;
        background: #ffffff;
        border-radius: 10px;
        border: 1px solid #e0e0e0;
        margin-top: 8px;
    }

    .checkbox-style-1-label {
        margin-left: 5px;
        font-size: 14px;
        font-weight: normal;
        cursor: pointer;
    }

    .checkbox-style {
        width: 18px;
        height: 18px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056d2;
        border-color: #0056d2;
        transform: translateY(-1px);
    }



    .img-category-badge {
        font-size: 12px;
        border-bottom-right-radius: 8px;
        background: #0d6efd;
    }

    .instructor-img {
        width: 45px;
        height: 45px;
        object-fit: cover;  
        border-radius: 50%;
        border: 2px solid #f1f1f1;
    }

    .instructor-info small {
        font-size: 11px !important;
        color: #6c757d;
    }

    .btn-detail {
        border-radius: 8px;
        font-weight: 600;
        padding: 8px 0;
        transition: background-color 0.3s ease, transform 0.2s ease;
       
    }

    .btn-detail:hover {
        background-color: #004aad !important; /* biru lebih gelap saat hover */
        color: #ffffff !important; /* tetap putih agar jelas terbaca */
        transform: translateY(-2px);
        
    }

    .price-tag h5 {
        font-size: 18px;
        margin-bottom: 8px;
    }



   
</style>

{{-- <section id="page-title">
    <div class="entry-image">
        <img src="{{asset('Bg-register-01-Copy.jpg')}}" alt="{{$judul}}" style="max-height: 500px">
    </div>
</section> --}}
<section id="content">
            <div class="content-wrap" style="padding: 0px !important">
                <div class="container clearfix">
                    {{-- <h3 class="text-capitalize">{{ $judul }}</h3> --}}
                <div class="entry-image" style="text-align:center; width:100%;">
                <img src="{{ asset($banner) }}" alt="{{ $judul }}" style="width:100%; height:auto; display:block; object-fit:cover;">
            </div>

            <br>
           <form action="/list-class" method="POST">
                @csrf
                <div class="filter-panel">
                    <div class="row">
                        <!-- Input Pencarian -->
                        <div class="form-group col-md-2">
                            <label for="">Pencarian:</label>
                            <input type="text" name="titlekelas" id="titlekelas" class="form-control"
                                value="{{ isset($titlekelas) ? $titlekelas : '' }}">
                        </div>

                        <!-- Kategori -->
                        <div class="form-group col-md-2">
                            <label for="">Kategori:</label>
                            <select class="form-control tagging slc2tag" name="slcClassesCategory" id="slcClassesCategory">
                                <option value="">Pilih</option>
                                @foreach ($pencarian['category'] as $ctg)
                                <option value="{{ $ctg }}" @if (isset($slcClassesCategory)) {{ $slcClassesCategory==$ctg ? 'selected'
                                    : '' }} @endif>
                                    {{ $ctg }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Instructor -->
                        <div class="form-group col-md-2">
                            <label for="">Instructor:</label>
                            <select class="form-control tagging" name="instructor" id="instructor">
                                <option value="">Pilih</option>
                                @foreach ($pencarian['instructor'] as $key => $ctg)
                                <option value="{{ $ctg }}" @if (isset($instructor)) {{ $instructor==$ctg ? 'selected' : '' }} @endif>
                                    {{ $key }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        

                        <!-- Jenis & Tipe -->
                        <div class="col-md-4">
                            <label for="">Filter Tambahan:</label>
                            <div class="accordion" id="accordionExample">

                                <!-- Jenis -->
                                <div class="mb-2">
                                    <button class="accordion-button-custom" type="button" data-toggle="collapse"
                                        data-target="#collapseJenis" aria-expanded="false" aria-controls="collapseJenis">
                                        Jenis <span>▼</span>
                                    </button>
                                    <div id="collapseJenis" class="collapse" data-parent="#accordionExample">
                                        <div class="accordion-body-custom">
                                            <div class="row">
                                                @foreach ($pencarian['jenis'] as $key => $ctg)
                                                <div class="col-md-6 d-flex align-items-center mb-2">
                                                    <input id="jenis-{{ $key }}" class="checkbox-style ini-checkbox-1"
                                                        name="jeniss[{{ $ctg }}]" type="checkbox"
                                                        @if (isset($jeniss)) {{ in_array(strtolower($ctg), $jeniss) ? 'checked' : ''
                                                        }} @endif value="{{$ctg}}">
                                                    <label for="jenis-{{ $key }}" class="checkbox-style-1-label">{{ $ctg }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tipe -->
                                <div class="mb-2">
                                    <button class="accordion-button-custom" type="button" data-toggle="collapse"
                                        data-target="#collapseTipe" aria-expanded="false" aria-controls="collapseTipe">
                                        Tipe <span>▼</span>
                                    </button>
                                    <div id="collapseTipe" class="collapse" data-parent="#accordionExample">
                                        <div class="accordion-body-custom">
                                            <div class="row">
                                                @foreach ($pencarian['tipe'] as $key => $ctg)
                                                <div class="col-md-6 d-flex align-items-center mb-2">
                                                    <input id="tipe-{{ $key }}" class="checkbox-style ini-checkbox-2"
                                                        name="tipe[{{ $ctg }}]" type="checkbox"
                                                        @if (isset($tipe)) {{ in_array($ctg, $tipe) ? 'checked' : '' }} @endif
                                                        value="{{$ctg}}">
                                                    <label for="tipe-{{ $key }}" class="checkbox-style-1-label">{{ $ctg }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="col-lg-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-block btn-sm" id="btnlistkelascari">TELUSURI</button>
                        </div>
                    </div>
                </div>
            </form>
            <br>
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
        <input type="text" id="sebelumnya" value="{{$sebelumnya}}" hidden>
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
            page_scroll = 1;
            $('#sebelumnya').val(null)
            $('#listkelas').html('');
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
       
                 $.ajax({
        url: '/list-class',
        type: 'GET',
        data: {
            page: page_scroll,
            sebelumnya: $('#sebelumnya').val(),
            titlekelas: $('#titlekelas').val(),
            kategori: $('#slcClassesCategory').val(),
            instructor: $('#instructor').val(),
            jenis: JSON.stringify(jenis),
            type: JSON.stringify(type),
        },
        beforeSend: function () {
            $('.ajax-load').show();
        },
        success: function (response) {
            let html = '';

            if (response.data.length > 0) {
                response.data.forEach(dt => {
                    const titleText = dt.title.length > 55 ? dt.title.substring(0, 50) + '...' : dt.title;
                    const instructor = dt.instructor_list && dt.instructor_list.length > 0 ? dt.instructor_list[0] : null;
                    const imageSrc = dt.image ? dt.image : '/images/no-image.png';

                    html += `
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4 d-flex">
                            <div class="card class-card shadow-sm border-0 flex-fill">
                                <div class="position-relative overflow-hidden" style="height: 200px;">
                                    <img src="${imageSrc}" class="card-img-top" alt="${dt.title}" style="object-fit: cover; height: 100%; width: 100%;">
                                    <div class="position-absolute top-0 start-0 text-white px-2 py-1 img-category-badge">
                                        ${dt.category_name ?? 'Kelas'}
                                    </div>
                                </div>

                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div>
                                        <h6 class="fw-bold text-dark text-truncate mb-1" title="${dt.title}" style="font-size:20px";>
                                            ${titleText}
                                        </h6>
                                        <p class="text-muted mb-2" style="font-size: 12px;">${dt.date_end ?? ''}</p>
                                        ${!$('#sebelumnya').val() ? `<p class="text-muted small mb-2" hidden>${dt.contents ?? ''}</p>` : ''}
                                    </div>

                                    ${instructor ? `
                                        <div class="d-flex align-items-center mt-2">
                                            <img src="${instructor.picture_src ? '/Image/' + instructor.picture_src.url : '/images/default-user.png'}"
                                                alt="${instructor.name}" class="me-3 instructor-img">
                                            <div class="instructor-info">
                                                <small class="d-block">Instructor</small>
                                                <h6 class="mb-0 text-capitalize" style="font-size:20px;">${instructor.name}</h6>
                                                <small class="text-capitalize">${instructor.title ?? ''}</small>
                                            </div>
                                        </div>
                                    ` : ''}

                                    <div class="mt-3 text-center border-top pt-3 price-tag">
                                        ${dt.pricing ? (() => {
                                            if (dt.pricing.gratis) {
                                                return `<h5 class="text-success fw-bold">GRATIS</h5>`;
                                            } else if (dt.pricing.promo) {
                                                return `<h5 class="text-primary fw-bold">Rp ${(dt.pricing.price - dt.pricing.promo_price).toLocaleString()}</h5>`;
                                            } else {
                                                return `<h5 class="text-primary fw-bold">Rp ${dt.pricing.price.toLocaleString()}</h5>`;
                                            }
                                        })() : `<h5 class="text-primary fw-bold">Rp -</h5>`}

                                        <a href="/class/${dt.unique_id}/${dt.title.replaceAll('/', '-')}"
                                            class="btn btn-outline-primary w-100 btn-sm btn-detail">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });

                $('#listkelas').append(html);
            }

            $('.ajax-load').hide();
        },
        error: function () {
            $('.ajax-load').hide();
            alert('Terjadi kesalahan saat memuat data.');
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
{{-- @include(env('CUSTOM_FOOTER', 'front.layout.footer')) --}}

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    console.log('ready, load data now...');
    loaddata();
});
</script>
@endpush
