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
                        html += '<div class="col-lg-3 col-sm-6 d-flex">'; // d-flex biar semua card sejajar tinggi
                        html += '  <div class="card shadow mb-5 bg-white w-100" style="border-radius:12px; overflow:hidden; border:none; min-height:640px; display:flex; flex-direction:column; justify-content:space-between; transition:transform 0.3s ease, box-shadow 0.3s ease;">';

                        // GAMBAR UTAMA (tinggi proporsional dan tidak terpotong)
                        html += `
                              <div style="width:100%; overflow:hidden;">
                                <img src="${dt.image}" style="width:100%; height:300px; object-fit:fill; display:block; transition:transform 0.4s ease;">
                              </div>
                            `;


                        // BAGIAN ATAS (TANGGAL & JUDUL)
                        html += '    <div style="padding:15px; flex-grow:1;">';
                        html += '      <div style="text-align:center; margin-top:8px;">';
                        html += '        <p style="margin:4px 0 0 0; font-size:12px; color:#777;">' + dt.date_end + '</p>';
                        html += '        <h4 class="text-capitalize m-0" style="font-size:15px; font-weight:600; color:#000; font-family:Arial, sans-serif ; ">' + dt.title + '</h4>';
                        html += '      </div>';
                        html += '    </div>';

                        // BAGIAN BAWAH (NARASUMBER, HARGA, TOMBOL)
                        html += '    <div style="padding:15px; margin-bottom:10px;">';

                        // NARASUMBER
                        html += '      <a href="/profile-instructor/' + dt.instructor_list[0].id + '/' + dt.instructor_list[0].name + '" class="d-flex align-items-center justify-content-start" style="text-decoration:none; color:#000; margin-bottom:10px;">';
                        html += '        <img class="mr-3 rounded-circle" style="width:55px; height:55px; object-fit:cover; border:3px solid #007BFF; flex-shrink:0;"';
                        if (dt.instructor_list[0].picture_src) {
                            html += 'src="/Image/' + dt.instructor_list[0].picture_src.url + '"';
                        } else {
                            html += 'src="/FE/images/default-user.png"';
                        }
                        html += ' alt="Foto Narasumber">';
                        html += '        <div class="text-left" style="margin-left:10px;">';
                        html += '          <small class="d-block mb-0" style="color:#007BFF; font-weight:600;">NARASUMBER</small>';
                        html += '          <h5 class="text-capitalize mb-0" style="font-size:14px; font-weight:600; font-family:Arial, sans-serif ;  color:#000;">' + dt.instructor_list[0].name + '</h5>';
                        html += '          <small class="d-block mb-0" style="font-size:11px; font-family:Arial, sans-serif ;  color:#666;">' + dt.instructor_list[0].title + '</small>';
                        html += '        </div>';
                        html += '      </a>';

                        // HARGA / GRATIS
                        html += '      <div class="text-center mt-2 w-100">';
                        if (dt.pricing) {
                            if (dt.pricing.gratis) {
                                html += '        <h3 style="color:#007BFF; font-size:20px; margin-bottom:10px;">GRATIS</h3>';
                            } else if (dt.pricing.promo) {
                                html += '        <h3 style="color:#007BFF; font-size:20px; margin-bottom:10px;">Rp. ' + (dt.pricing.price - dt.pricing.promo_price).toLocaleString() + '</h3>';
                            } else {
                                html += '        <h3 style="color:#007BFF; font-size:20px; margin-bottom:10px;">Rp. ' + dt.pricing.price.toLocaleString() + '</h3>';
                            }
                        } else {
                            html += '        <h3 style="color:#007BFF; font-size:20px; margin-bottom:10px;">Rp. -</h3>';
                        }

                        // TOMBOL DAFTAR
                        html += '        <a href="/class/' + dt.unique_id + '/' + dt.title.replaceAll("/", "-") + '" class="btn btn-primary btn-block"';
                        html += '           style="background-color:#007BFF; border:none; border-radius:10px; padding:8px 0; font-weight:600; font-size:14px; transition:background-color 0.3s ease;">Daftar</a>';
                        html += '      </div>';

                        html += '    </div>'; // tutup bagian bawah
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