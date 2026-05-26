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
            <form action="/list-class" method="POST" id="formCariKelas">
    @csrf
    <div class="row align-items-end px-2">
        
        <div class="form-group col-md-2">
            <label for="titlekelas" class="font-weight-bold text-secondary text-sm">Pencarian:</label>
            <input type="text" name="titlekelas" id="titlekelas" class="form-control shadow-sm"
                value="{{ isset($titlekelas) ? $titlekelas : '' }}" style="border-radius: 10px;" placeholder="Cari nama kelas...">
        </div>

        <div class="form-group col-md-2">
            <label for="slcClassesCategory" class="font-weight-bold text-secondary text-sm">Kategori:</label>
            <select class="form-control tagging slc2tag shadow-sm" name="slcClassesCategory" id="slcClassesCategory" style="border-radius: 10px;">
                <option value="">Pilih Kategori</option>
                @foreach ($pencarian['category'] as $ctg)
                    <option value="{{ $ctg }}" @if (isset($slcClassesCategory)) {{ $slcClassesCategory == $ctg ? 'selected' : '' }} @endif>
                        {{ $ctg }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-2">
            <label for="instructor" class="font-weight-bold text-secondary text-sm">Instructor:</label>
            <select class="form-control tagging shadow-sm" name="instructor" id="instructor" style="border-radius: 10px;">
                <option value="">Pilih Instructor</option>
                @foreach ($pencarian['instructor'] as $key => $ctg)
                    <option value="{{ $ctg }}" @if (isset($instructor)) {{ $instructor == $ctg ? 'selected' : '' }} @endif>
                        {{ $key }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <div class="row">
                <div class="form-group col-6 position-relative">
                    <label class="font-weight-bold text-secondary text-sm">Jenis:</label>
                    <button class="btn btn-light btn-block text-left border shadow-sm d-flex justify-content-between align-items-center" 
                        type="button" data-toggle="collapse" data-target="#collapseJenis" aria-expanded="false" aria-controls="collapseJenis" style="border-radius: 10px;">
                        <span>Pilih Jenis</span>
                        <small class="text-muted">▼</small>
                    </button>
                    
                    <div id="collapseJenis" class="collapse position-absolute bg-white border rounded shadow p-3 mt-1" style="z-index: 1050; width: 90%; max-height: 200px; overflow-y: auto;">
                        <div class="custom-scrollbar">
                            @foreach ($pencarian['jenis'] as $key => $ctg)
                                <div class="custom-control custom-checkbox mb-2">
                                    <input id="jenis-{{ $key }}" class="custom-control-input ini-checkbox-1"
                                        name="jeniss[{{ $ctg }}]" type="checkbox" 
                                        @if (isset($jeniss)) {{ in_array(strtolower($ctg), $jeniss) ? 'checked' : '' }} @endif
                                        value="{{ $ctg }}">
                                    <label for="jenis-{{ $key }}" class="custom-control-label text-sm pointer">{{ $ctg }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="form-group col-6 position-relative">
                    <label class="font-weight-bold text-secondary text-sm">Tipe:</label>
                    <button class="btn btn-light btn-block text-left border shadow-sm d-flex justify-content-between align-items-center" 
                        type="button" data-toggle="collapse" data-target="#collapseTipe" aria-expanded="false" aria-controls="collapseTipe" style="border-radius: 10px;">
                        <span>Pilih Tipe</span>
                        <small class="text-muted">▼</small>
                    </button>
                    
                    <div id="collapseTipe" class="collapse position-absolute bg-white border rounded shadow p-3 mt-1" style="z-index: 1050; width: 90%; max-height: 200px; overflow-y: auto;">
                        <div class="custom-scrollbar">
                            @foreach ($pencarian['tipe'] as $key => $ctg)
                                <div class="custom-control custom-checkbox mb-2">
                                    <input id="tipe-{{ $key }}" class="custom-control-input ini-checkbox-2"
                                        name="tipe[{{ $ctg }}]" type="checkbox" 
                                        @if (isset($tipe)) {{ in_array($ctg, $tipe) ? 'checked' : '' }} @endif 
                                        value="{{ $ctg }}">
                                    <label for="tipe-{{ $key }}" class="custom-control-label text-sm pointer">{{ $ctg }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group col-md-2">
            <button type="submit" id="btnlistkelascari" class="btn btn-primary btn-block shadow" 
                style="border-radius: 10px; height: calc(1.5em + .75rem + 2px);">
                <i class="fas fa-search mr-1"></i> Telusuri
            </button>
        </div>

    </div>
</form>
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
                // sebelumnya: $('#sebelumnya').val(),
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
    let html = ''; // Pastikan variabel html terdefinisi

    response.data.forEach(dt => {
        // 1. LOGIKA BADGE, HARGA, & TOMBOL
        let priceHtml = 'Rp -';
        let badgeHtml = '';
        let btnText = 'Daftar Sekarang';
        let btnColor = '#007BFF'; // Biru default
        
        // Cek apakah judul mengandung kata 'upcoming'
        const isUpcoming = dt.title ? dt.title.toLowerCase().includes('upcoming') : false;

        // Ambil data instruktur/narasumber pertama
        const instructor = dt.instructor_list && dt.instructor_list.length > 0 ? dt.instructor_list[0] : null;
        const instructorName = instructor ? instructor.name : 'Instruktur Belum Tersedia';
        const instructorId = instructor ? instructor.id : null;

        let avatarUrl = '/FE/images/default-user.png';
        if (instructor && instructor.picture_src && instructor.picture_src.url) {
            avatarUrl = '/Image/' + instructor.picture_src.url;
        }

        if (dt.pricing) {
            if (dt.pricing.gratis) {
                priceHtml = 'GRATIS';
                badgeHtml = '<span style="display:inline-block; background:#28a745; color:white; padding:4px 10px; font-size:11px; font-weight:700; border-radius:20px; box-shadow:0 4px 16px rgba(40,167,69,0.4); text-transform:uppercase;">🎉 Free Class</span>';
                btnText = 'Daftar Gratis';
                btnColor = '#28a745'; // Hijau untuk kelas gratis
            } else if (dt.pricing.promo) {
                let realPrice = dt.pricing.price - dt.pricing.promo_price;
                priceHtml = 'Rp ' + realPrice.toLocaleString('id-ID');
                
                // Menghitung persentase potongan harga
                let potongHarga = dt.pricing.price > 0 ? Math.round((dt.pricing.promo_price / dt.pricing.price) * 100) : 0;
                badgeHtml = '<span style="display:inline-block; background:#dc3545; color:white; padding:4px 10px; font-size:11px; font-weight:700; border-radius:20px; box-shadow:0 4px 16px rgba(220,53,69,0.4);">PROMO ' + potongHarga + '% OFF</span>';
            } else {
                priceHtml = 'Rp ' + dt.pricing.price.toLocaleString('id-ID');
            }
        }

        // Jika statusnya OVERWRITE UNTUK UPCOMING CLASS
        if (isUpcoming) {
            badgeHtml = '<span style="display:inline-block; background:#6c757d; color:white; padding:4px 10px; font-size:11px; font-weight:700; border-radius:20px; box-shadow:0 4px 16px rgba(108,117,125,0.4); text-transform:uppercase;">⏳ Upcoming</span>';
            btnText = 'Belum Tersedia';
            btnColor = '#6c757d';
        }

        // 2. LOGIKA FIX DATA SUB KATEGORI
        let subCategoryHtml = '';
        if (dt.jenis) {
            let subCategoryText = dt.jenis;
            
            if (typeof dt.jenis === 'string' && dt.jenis.trim().startsWith('[')) {
                try {
                    let parsed = JSON.parse(dt.jenis);
                    if (Array.isArray(parsed)) {
                        subCategoryText = parsed.join(', ');
                    }
                } catch (e) {
                    // Biarkan string asli jika gagal parse
                }
            } else if (Array.isArray(dt.jenis)) {
                subCategoryText = dt.jenis.join(', ');
            }

            // Helper escape HTML (seperti e() di Laravel)
            let escapedText = String(subCategoryText)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
            if (escapedText == 'BANKIR') {
                subCategoryHtml = '<span style="display:inline-block; background:#17a2b8; color:white; padding:4px 10px; font-size:11px; font-weight:700; border-radius:20px; box-shadow:0 4px 16px rgba(23,162,184,0.4); max-width: 130px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="' + escapedText + '">🏷️ ' + escapedText + '</span>';
            } else {
                subCategoryHtml = '<span style="display:inline-block; background:rgba(188, 31, 68, 0.9); color:white; padding:4px 10px; font-size:11px; font-weight:700; border-radius:20px; box-shadow:0 4px 16px rgba(158, 31, 35, 0.4); max-width: 130px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="' + escapedText + '">🏷️ ' + escapedText + '</span>';
            }
        }

        // FORMAT TANGGAL
        const namaBulan = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
        let tanggalCantik = (function(d){ 
            if(!d) return '-';
            const t = new Date(d); 
            return String(t.getDate()).padStart(2,'0') + ' ' + namaBulan[t.getMonth()] + ' ' + t.getFullYear(); 
        })(dt.date_end);

        // 3. GENERATE HTML STRING
        html += '<div class="col-lg-3 col-sm-6 d-flex mb-4">'; 
        html += '  <div class="card shadow border bg-white w-100 custom-card-hover" style="border-radius:12px; overflow:hidden; border:none; display:flex; flex-direction:column; transition:transform 0.3s ease, box-shadow 0.3s ease; position:relative;">';

        // HEADER BADGE CONTAINER (Sama persis dengan versi Blade)
        html += '    <div style="background: #f8f9fa; padding: 12px 16px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #edf2f7; min-height: 48px;">';
        html += '      <div style="flex-shrink: 0;">' + badgeHtml + '</div>';
        html += '      <div style="flex-shrink: 0; margin-left: 8px;">' + subCategoryHtml + '</div>';
        html += '    </div>';

        // GAMBAR UTAMA WITH WRAPPER HOVER EFFECT
        let imgUrl = dt.image ? dt.image : '/FE/images/images-demo-consulting-03.jpg';
        html += '    <div style="width:100%; height:180px; overflow:hidden; position:relative;" class="img-wrapper">';
        html += '      <img src="' + imgUrl + '" style="width:100%; height:100%; object-fit:cover; display:block; transition: transform 0.5s ease;" alt="' + (dt.title || '') + '">';
        html += '    </div>';

        // AREA KONTEN (ATAS)
        html += '    <div style="padding:20px; flex-grow:1; display:flex; flex-direction:column; justify-content:space-between;">';
        html += '      <div>';
        html += '        <div style="display:flex; align-items:center; margin-bottom:8px;">';
        html += '          <span style="font-size:12px; color:#6c757d; font-weight:500;">' + tanggalCantik + '</span>';
        html += '        </div>';
        html += '        <h4 class="text-capitalize" style="font-size:15px; text-align:left; font-weight:700; font-family:\'Poppins\', sans-serif; color:#212529; margin:0; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; line-height:1.4; min-height:42px;">' + (dt.title || '') + '</h4>';
        html += '      </div>';
        
        // DETAIL NARASUMBER
        let profileUrl = '/profile-instructor/' + (instructorId || '#') + '/' + encodeURIComponent(instructorName);
        html += '      <div style="margin-top:20px; padding-top:12px; border-top:1px dashed #e9ecef;">';
        html += '        <a href="' + profileUrl + '" class="d-flex align-items-center" style="text-decoration:none; color:#212529;">';
        html += '          <img class="rounded-circle" style="width:40px; height:40px; object-fit:cover; border:2px solid #e0ebff; flex-shrink:0;" src="' + avatarUrl + '" alt="Foto Narasumber">';
        html += '          <div style="margin-left:12px; text-align:left; overflow:hidden;">';
        html += '            <small class="d-block" style="color:#007BFF; font-weight:700; font-size:9px; letter-spacing:0.5px; text-transform:uppercase;">Narasumber</small>';
        html += '            <h5 class="text-capitalize mb-0" style="font-size:13px; font-weight:600; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; color:#495057;">' + instructorName + '</h5>';
        html += '          </div>';
        html += '        </a>';
        html += '      </div>';
        html += '    </div>'; // Tutup Area Konten Atas

        // AREA FOOTER (HARGA & TOMBOL)
        html += '    <div style="padding:0 20px 20px 20px; background:#fff;">';
        html += '      <div>';
        
        // TAMPILAN HARGA
        if (dt.pricing && dt.pricing.gratis) {
            html += '        <h3 style="color:#28a745; font-size:20px; font-weight:800; margin-bottom:12px; letter-spacing:-0.5px;">' + priceHtml + '</h3>';
        } else {
            html += '        <h3 style="color:#005CFF; font-size:18px; font-weight:800; margin-bottom:12px; letter-spacing:-0.5px;">' + priceHtml + '</h3>';
        }
        
        // TOMBOL DAFTAR
        if (isUpcoming) {
            html += '        <button class="btn btn-block py-25" style="background-color:' + btnColor + '; color:white; border:none; border-radius:10px; font-weight:700; font-size:14px; width: 100%; cursor: not-allowed;" disabled>' + btnText + '</button>';
        } else {
            let shadowColor = (dt.pricing && dt.pricing.gratis ? 'rgba(40,167,69,0.2)' : 'rgba(0,123,255,0.2)');
            let cleanTitle = dt.title ? dt.title.replace(/\//g, "-") : '';
            let classUrl = '/class/' + dt.unique_id + '/' + cleanTitle;
            html += '        <a href="' + classUrl + '" class="btn btn-block py-25" style="background-color:' + btnColor + '; color:white; border:none; border-radius:10px; font-weight:700; font-size:14px; box-shadow:0 4px 12px ' + shadowColor + '; transition:all 0.2s; display: block; text-align: center; text-decoration: none;">' + btnText + '</a>';
        }
        html += '      </div>';
        html += '    </div>';

        html += '  </div>'; // Tutup Card
        html += '</div>'; // Tutup Col
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