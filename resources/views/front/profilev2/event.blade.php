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
                let html = '';
                if (response.data.length > 0) {
    response.data.forEach(dt => {
        html += '<div class="col-lg-3 col-sm-6 d-flex mb-4">'; 
        html += '  <div class="card shadow bg-white w-100" style="border-radius:12px; overflow:hidden; border:none; display:flex; flex-direction:column; transition:transform 0.3s ease, box-shadow 0.3s ease;">';

        // GAMBAR UTAMA
        html += `
              <div style="width:100%; height:200px; overflow:hidden;">
                <img src="${dt.image}" style="width:100%; height:100%; object-fit:cover; display:block; transition:transform 0.4s ease;">
              </div>
            `;

        // AREA KONTEN (ATAS) - Menggunakan flex-grow agar mendorong footer ke bawah
        html += '    <div style="padding:15px; flex-grow:1; display:flex; flex-direction:column;">';
        
        // TANGGAL
        html += '      <div style="text-align:center;">';
        html += '        <p style="margin:0 0 4px 0; font-size:12px; color:#777;">' 
                      + (function(d){ 
                            const t=new Date(d); 
                            return String(t.getDate()).padStart(2,'0')+'-'+String(t.getMonth()+1).padStart(2,'0')+'-'+t.getFullYear(); 
                        })(dt.date_end) 
                      + '</p>';

        html += '        <h4 class="text-capitalize" style="font-size:15px; font-weight:600; font-family:Arial, sans-serif; color:#000; margin:0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4; min-height: 42px;">' + dt.title + '</h4>';
        html += '      </div>';
        
        html += '      <div style="margin-top:15px;">';
        html += '        <a href="/profile-instructor/' + dt.instructor_list[0].id + '/' + dt.instructor_list[0].name + '" class="d-flex align-items-center" style="text-decoration:none; color:#000;">';
        html += '          <img class="rounded-circle" style="width:45px; height:45px; object-fit:cover; border:2px solid #007BFF; flex-shrink:0;"';
        html += (dt.instructor_list[0].picture_src) ? 'src="/Image/' + dt.instructor_list[0].picture_src.url + '"' : 'src="/FE/images/default-user.png"';
        html += ' alt="Foto Narasumber">';
        html += '          <div style="margin-left:10px; overflow:hidden;">';
        html += '            <small class="d-block" style="color:#007BFF; font-weight:600; font-size:10px;">NARASUMBER</small>';
        html += '            <h5 class="text-capitalize mb-0" style="font-size:13px; font-weight:600; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">' + dt.instructor_list[0].name + '</h5>';
        html += '          </div>';
        html += '        </a>';
        html += '      </div>';
        html += '    </div>'; // Tutup Bagian Atas

        // AREA FOOTER (HARGA & TOMBOL) - Selalu di bawah
        html += '    <div style="padding:15px; border-top:1px solid #f0f0f0; background:#fafafa;">';
        html += '      <div class="text-center">';
        
        // HARGA
        let priceHtml = '';
        if (dt.pricing) {
            if (dt.pricing.gratis) {
                priceHtml = 'GRATIS';
            } else if (dt.pricing.promo) {
                priceHtml = 'Rp. ' + (dt.pricing.price - dt.pricing.promo_price).toLocaleString();
            } else {
                priceHtml = 'Rp. ' + dt.pricing.price.toLocaleString();
            }
        } else {
            priceHtml = 'Rp. -';
        }
        
        html += '        <h3 style="color:#007BFF; font-size:18px; font-weight:700; margin-bottom:12px;">' + priceHtml + '</h3>';
        html += '        <a href="/class/' + dt.unique_id + '/' + dt.title.replaceAll("/", "-") + '" class="btn btn-primary btn-block" style="background-color:#007BFF; border:none; border-radius:8px; padding:10px 0; font-weight:600; font-size:14px;">Daftar Sekarang</a>';
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