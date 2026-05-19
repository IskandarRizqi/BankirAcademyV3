@include('front.layout.head')
@include('front.layout.topbar')
@include(env('CUSTOM_HEADER', 'front.layout.headerv3'))

{{-- <section id="page-title">
    <div class="entry-image">
        <img src="{{asset('Bg-register-01-Copy.jpg')}}" alt="{{$judul}}" style="max-height: 500px">
</div>
</section> --}}
<br>
<section id="content">
    <div class="content-wrap" style="padding: 0px !important">
        <div class="container clearfix">
            {{-- <h3 class="text-capitalize">{{ $judul }}</h3> --}}
            <div class="entry-image" style="margin-bottom:100px;">
                {{-- <img src="{{asset($banner)}}" alt="{{$judul}}" style="max-height: 200px; border-radius: 10px;"> --}}
                <img src="FE/beranda/sinergi.png" style="max-height: 250px; border-radius: 10px;">
            </div>
            {{-- <form action="/list-class" method="POST">
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
                    {{ $ctg }}
                </option>
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
                    {{ $key }}
                </option>
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

    </form> --}}
    <div class="row gutter-40 col-mb-80">
        <div class="postcontent col-lg-12">
            @if ($class['data'])
            <div class="single-event">
                <div class="row" id="listkelas">
                </div>
                <hr>
            </div>
            @endif
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
    $(document).ready(function() {
        loaddata()
        window.onscroll = function(e) {

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
            if (no_scroll >= 1200 && isLogin != 1) {
                $('#modelId').modal('show');
                $('#hidemodallogin').attr('hidden', true);
                return false;
            }
            if (page_scroll > longPage) {
                return false;
            }
            if (no_scroll > load_scoll) {
                load_scoll += 1200;
                console.log('load data ' + page_scroll);
                page_scroll++;
                loaddata();

            }
        }
        $('#btnlistkelascari').on('click', function() {
            page_scroll = 1;
            $('#sebelumnya').val(null)
            $('#listkelas').html('');
            loaddata();
        })
    })

    function loaddata() {
        const jenis = [];
        const type = [];
        $('.ini-checkbox-1').each(function(idx, el) {
            if ($(el).is(':checked')) {
                if (!($(el).val() in jenis)) {
                    jenis.push($(el).val())
                }
            }
        });
        $('.ini-checkbox-2').each(function(idx, el) {
            if ($(el).is(':checked')) {
                if (!($(el).val() in type)) {
                    type.push($(el).val())
                }
            }
        });
        // return console.log([jenis,type]);
        // return new Promise((resolve, reject) => {
        $.ajax({
            url: '/list-class',
            data: {
                page: page_scroll,
                sebelumnya: $('#sebelumnya').val(),
                titlekelas: $('#titlekelas').val(),
                kategori: $('#slcClassesCategory').val(),
                instructor: $('#instructor').val(),
                jenis: JSON.stringify(jenis),
                type: JSON.stringify(type),
            },
            type: 'GET',
            beforeSend: function() {
                $('.ajax-load').show();
            },
            success: function(response) {
    let html = '';
    console.log("res", response)
    
    if (response.data.length > 0) {
       response.data.forEach(dt => {
    // 1. LOGIKA BADGE & HARGA (Ditaruh di atas untuk efisiensi)
    let priceHtml = '';
    let badgeHtml = '';
    let btnText = 'Daftar Sekarang';
    let btnColor = '#007BFF'; // Biru default

    if (dt.pricing) {
        if (dt.pricing.gratis) {
            priceHtml = 'GRATIS';
            badgeHtml = '<span style="position:absolute; top:12px; left:12px; background:#28a745; color:white; padding:4px 10px; font-size:11px; font-weight:700; border-radius:20px; box-shadow:0 4px 16px rgba(40,167,69,0.4); text-transform:uppercase; z-index:2;">🎉 Free Class</span>';
            btnText = 'Daftar Gratis';
            btnColor = '#28a745'; // Hijau untuk kelas gratis
        } else if (dt.pricing.promo) {
            priceHtml = 'Rp ' + (dt.pricing.price - dt.pricing.promo_price).toLocaleString('id-ID');
            let potongHarga = Math.round((dt.pricing.promo_price / dt.pricing.price) * 100);
            badgeHtml = `<span style="position:absolute; top:12px; left:12px; background:#dc3545; color:white; padding:4px 10px; font-size:11px; font-weight:700; border-radius:20px; box-shadow:0 4px 16px rgba(220,53,69,0.4); z-index:2;">PROMO ${potongHarga}% OFF</span>`;
        } else {
            priceHtml = 'Rp ' + dt.pricing.price.toLocaleString('id-ID');
        }
    } else {
        priceHtml = 'Rp -';
    }

    // FORMAT TANGGAL YANG LEBIH CANTIK (Contoh: 19 Mei 2026)
    const namaBulan = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
    let tanggalCantik = (function(d){ 
        if(!d) return '-';
        const t = new Date(d); 
        return String(t.getDate()).padStart(2,'0') + ' ' + namaBulan[t.getMonth()] + ' ' + t.getFullYear(); 
    })(dt.date_end);

    // 2. GENERATE HTML STRING
    html += '<div class="col-lg-3 col-sm-6 d-flex mb-4">'; 
    // CSS class 'card-hover-effect' ditambahkan (style ditaruh di bawah)
    html += ' <div class="card shadow bg-white w-100" style="border-radius:12px; overflow:hidden; border:none; display:flex; flex-direction:column; transition:transform 0.3s ease, box-shadow 0.3s ease;">';

    // BADGE STATUS (GRATIS / PROMO)
    html += badgeHtml;

    // GAMBAR UTAMA WITH WRAPPER HOVER EFFECT
    html += `
          <div style="width:100%; height:180px; overflow:hidden; position:relative;" class="img-wrapper">
            <img src="${dt.image}" style="width:100%; height:100%; object-fit:cover; display:block; transition: transform 0.5s ease;">
          </div>
        `;

    // AREA KONTEN (ATAS)
    html += '    <div style="padding:20px; flex-grow:1; display:flex; flex-direction:column; justify-content:space-between;">';
    
    html += '      <div>';
    // TANGGAL & IKON KALENDER
    html += '        <div style="display:flex; align-items:center; margin-bottom:8px;">';
    html += '          <i class="far fa-calendar-alt" style="font-size:12px; color:#6c757d; margin-right:6px;"></i>';
    html += '          <span style="font-size:12px; color:#6c757d; font-weight:500;">' + tanggalCantik + '</span>';
    html += '        </div>';

    // JUDUL KELAS (RATA KIRI & MAX 2 BARIS)
    html += '        <h4 class="text-capitalize" style="font-size:15px; font-weight:700; font-family:\'Poppins\', sans-serif; color:#212529; margin:0; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; line-height:1.4; min-height:42px;">' + dt.title + '</h4>';
    html += '      </div>';
    
    // DETAIL NARASUMBER
    html += '      <div style="margin-top:20px; padding-top:12px; border-top:1px dashed #e9ecef;">';
    html += '        <a href="/profile-instructor/' + dt.instructor_list[0]?.id + '/' + dt.instructor_list[0]?.name + '" class="d-flex align-items-center" style="text-decoration:none; color:#212529;">';
    html += '          <img class="rounded-circle" style="width:40px; height:40px; object-fit:cover; border:2px solid #e0ebff; flex-shrink:0;"';
    html += (dt.instructor_list[0]?.picture_src) ? 'src="/Image/' + dt.instructor_list[0]?.picture_src.url + '"' : 'src="/FE/images/default-user.png"';
    html += ' alt="Foto Narasumber">';
    html += '          <div style="margin-left:12px; overflow:hidden;">';
    html += '            <small class="d-block" style="color:#007BFF; font-weight:700; font-size:9px; letter-spacing:0.5px; text-transform:uppercase;">Narasumber</small>';
    html += '            <h5 class="text-capitalize mb-0" style="font-size:13px; font-weight:600; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; color:#495057;">' + dt.instructor_list[0]?.name + '</h5>';
    html += '          </div>';
    html += '        </a>';
    html += '      </div>';
    
    html += '    </div>'; // Tutup Bagian Atas

    // AREA FOOTER (HARGA & TOMBOL)
    html += '    <div style="padding:0 20px 20px 20px; background:#fff;">';
    html += '      <div>';
    
    // TAMPILAN HARGA (Jika GRATIS diberi warna hijau mencolok)
    if(dt.pricing && dt.pricing.gratis) {
        html += '        <h3 style="color:#28a745; font-size:20px; font-weight:800; margin-bottom:12px; letter-spacing:-0.5px;">' + priceHtml + '</h3>';
    } else {
        html += '        <h3 style="color:#005CFF; font-size:18px; font-weight:800; margin-bottom:12px; letter-spacing:-0.5px;">' + priceHtml + '</h3>';
    }
    
    // TOMBOL DAFTAR
    html += '        <a href="/class/' + dt.unique_id + '/' + dt.title.replaceAll("/", "-") + '" class="btn btn-block py-25" style="background-color:' + btnColor + '; color:white; border:none; border-radius:10px; font-weight:700; font-size:14px; box-shadow:0 4px 12px ' + (dt.pricing && dt.pricing.gratis ? 'rgba(40,167,69,0.2)' : 'rgba(0,123,255,0.2)') + '; transition:all 0.2s;">' + btnText + '</a>';
    html += '      </div>';
    html += '    </div>';

    html += '  </div>'; // tutup card
    html += '</div>'; // tutup col
});
    $('#listkelas').append(html);

                    // Efek hover
                    $('#listkelas .card').hover(
                        function() {
                            $(this).css({
                                'transform': 'translateY(-5px)',
                                'box-shadow': '0 8px 20px rgba(0,0,0,0.15)'
                            });
                            $(this).find('img').first().css('transform', 'scale(1.05)');
                        },
                        function() {
                            $(this).css({
                                'transform': 'translateY(0)',
                                'box-shadow': '0 2px 10px rgba(0,0,0,0.1)'
                            });
                            $(this).find('img').first().css('transform', 'scale(1)');
                        }
                    );
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