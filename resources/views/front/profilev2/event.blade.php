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
        // return console.log([jenis,type]);
            // return new Promise((resolve, reject) => {
                $.ajax({
                    url: '/list-class',
                    data:{
                        page:page_scroll,
                        sebelumnya:$('#sebelumnya').val(),
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
                                html+='    <div class="card shadow mb-5 bg-white" style="border-radius: 8px; min-height: 640px">';
                                html+='        <img src="'+dt.image+'" width="100%" style="border-radius: 8px; max-height: 300px;">';


                                html+='            <span class="mt-0" style="border-radius: 8px;bottom: 15px; left: 15px; right: 15px; position: absolute;"';
                                html+='                style="border-radius: 8px;">';
                                // html += '                <h4 class="text-center text-capitalize m-0" style="font-size:16px;">';
                                // html += '                     ' + dt.title;
                                // html += '                </h4>';


                                html += '                <div style="text-align:center; margin-top:8px;">';
                                html += '                    <h4 class="text-capitalize m-0" style="font-size:15px;">' + dt.title + '</h4>';
                                html += '                    <p style="margin:4px 0 0 0; font-size:12px !important;">' + dt.date_end + '</p>';
                                html += '                </div>';

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
                                html+='                        Daftar </a>';
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