<section id="content">
    <div class="content-wrap" style="padding: 0px !important">
        <div class="container clearfix">


            <div class="row gutter-40 col-mb-80">
                <div class="postcontent col-lg-12">
                    {{-- @if ($kelas['data']) --}}
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
            console.log('no_scroll : ' + no_scroll);
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
                console.log('response', response.data)
                let html = '';
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
            badgeHtml = '<span style="position:absolute; top:14px; left:14px; background:linear-gradient(135deg, #28a745, #218838); color:white; padding:6px 14px; font-size:11px; font-weight:700; border-radius:30px; box-shadow:0 4px 10px rgba(40,167,69,0.3); text-transform:uppercase; z-index:2; letter-spacing: 0.5px;">🎉 Free Class</span>';
            btnText = 'Daftar Gratis';
            btnColor = '#28a745'; // Hijau untuk kelas gratis
        } else if (dt.pricing.promo) {
            priceHtml = 'Rp ' + (dt.pricing.price - dt.pricing.promo_price).toLocaleString('id-ID');
            let potongHarga = Math.round((dt.pricing.promo_price / dt.pricing.price) * 100);
            badgeHtml = `<span style="position:absolute; top:14px; left:14px; background:linear-gradient(135deg, #dc3545, #bd2130); color:white; padding:6px 14px; font-size:11px; font-weight:700; border-radius:30px; box-shadow:0 4px 10px rgba(220,53,69,0.3); z-index:2; letter-spacing: 0.5px;">PROMO ${potongHarga}% OFF</span>`;
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
    // PERBAIKAN: Menggunakan shadow yang lebih smooth, border subtle, dan transform transisi yang lebih responsif
    html += '  <div class="card shadow bg-white w-100" style="border-radius:12px; overflow:hidden; border:none; display:flex; flex-direction:column; transition:transform 0.3s ease, box-shadow 0.3s ease;">';

    // BADGE STATUS (GRATIS / PROMO)
    html += badgeHtml;
    html += `
          <div style="width:100%; height:190px; overflow:hidden; position:relative;" class="img-wrapper">
            <img src="${dt.image}" style="width:100%; height:100%; object-fit:cover; display:block; transition: transform 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);">
          </div>
        `;

    // AREA KONTEN (ATAS)
    html += '    <div style="padding:24px 24px 16px 24px; flex-grow:1; display:flex; flex-direction:column; justify-content:space-between;">';
    
    html += '      <div>';
    // TANGGAL & IKON KALENDER
    html += '        <div style="display:flex; align-items:center; margin-bottom:10px;">';
    html += '          <i class="far fa-calendar-alt" style="font-size:12px; color:#3b82f6; margin-right:6px;"></i>'; // Ikon diubah ke biru agar pop-out
    html += '          <span style="font-size:12px; color:#6b7280; font-weight:600; letter-spacing:0.3px;">' + tanggalCantik + '</span>';
    html += '        </div>';

    // JUDUL KELAS (RATA KIRI & MAX 2 BARIS)
    html += '        <h4 class="text-capitalize" style="font-size:16px; font-weight:700; font-family:\'Poppins\', sans-serif; color:#1f2937; margin:0; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; line-height:1.5; min-height:48px;">' + dt.title + '</h4>';
    html += '      </div>';
    
    // DETAIL NARASUMBER
    html += '      <div style="margin-top:20px; padding-top:14px; border-top:1px dashed #e5e7eb;">';
    html += '        <a href="/profile-instructor/' + dt.instructor_list[0]?.id + '/' + dt.instructor_list[0]?.name + '" class="d-flex align-items-center" style="text-decoration:none; color:#212529;">';
    html += '          <img class="rounded-circle" style="width:42px; height:42px; object-fit:fill; border:2px solid #eff6ff; flex-shrink:0;"';
    html += (dt.instructor_list[0]?.picture_src) ? 'src="/Image/' + dt.instructor_list[0]?.picture_src.url + '"' : 'src="/FE/images/default-user.png"';
    html += ' alt="Foto Narasumber">';
    html += '          <div style="margin-left:12px; overflow:hidden;">';
    html += '            <small class="d-block" style="color:#007BFF; font-weight:700; font-size:9px; letter-spacing:0.8px; text-transform:uppercase;">Narasumber</small>';
    html += '            <h5 class="text-capitalize mb-0" style="font-size:13px; font-weight:600; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; color:#374151;">' + dt.instructor_list[0]?.name + '</h5>';
    html += '          </div>';
    html += '        </a>';
    html += '      </div>';
    
    html += '    </div>'; // Tutup Bagian Atas

    // AREA FOOTER (HARGA & TOMBOL)
    html += '    <div style="padding:0 24px 24px 24px; background:#fff;">';
    html += '      <div>';
    
    // TAMPILAN HARGA (Jika GRATIS diberi warna hijau mencolok)
    if(dt.pricing && dt.pricing.gratis) {
        html += '        <h3 style="color:#28a745; font-size:22px; font-weight:800; margin-bottom:14px; letter-spacing:-0.5px;">' + priceHtml + '</h3>';
    } else {
        html += '        <h3 style="color:#005CFF; font-size:20px; font-weight:800; margin-bottom:14px; letter-spacing:-0.5px;">' + priceHtml + '</h3>';
    }
    
    // TOMBOL DAFTAR
    html += '        <a href="/class/' + dt.unique_id + '/' + dt.title.replaceAll("/", "-") + '" class="btn btn-block py-25" style="background-color:' + btnColor + '; color:white; border:none; border-radius:12px; font-weight:700; font-size:14px; box-shadow:0 4px 14px ' + (dt.pricing && dt.pricing.gratis ? 'rgba(40,167,69,0.25)' : 'rgba(0,123,255,0.25)') + '; transition:all 0.2s; display: block; text-align: center; text-decoration: none;">' + btnText + '</a>';
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