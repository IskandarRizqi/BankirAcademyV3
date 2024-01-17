<!-- Footer
  ============================================= -->
<footer id="footer" class="dark" style="background-color:#ffffff; z-index: 1000">
    <div class="container">

        <div class="footer-widgets-wrap" style="color: black">
            <div class="row col-mb-50">
                <div class="col-lg-6">
                    <div class="widget clearfix">
                        <p>{{ env('APP_NAME', 'Bankir Akademi') }} merupakan platform digital learning yang dapat
                            digunakan
                            sebagai media
                            pembelajaran untuk seluruh calon dan karyawan bank.
                        </p>
                        {{-- style="background: url('images/world-map.png') no-repeat center center;" --}}
                        <div class="py-2">
                            <div class="row col-mb-30">
                                <div class="col-md-6">
                                    <address class="mb-0">
                                        <abbr title="Headquarters"
                                            style="display: inline-block;margin-bottom: 7px;"><strong>Alamat:</strong></abbr><br>
                                        PT. Bankir Academy Indonesia <br>
                                        Jl. Jendral Sudirman 354, Semarang Barat<br> Kota Semarang<br>
                                    </address>
                                </div>
                                <div class="col-md-6">
                                    <table>
                                        <tr>
                                            <td><abbr title="Phone Number"><strong>Phone</strong></abbr></td>
                                            <td>:</td>
                                            <td>(024) 76435498</td>
                                        </tr>
                                        <tr>
                                            <td><abbr title="Fax"><strong>Whatsapp</strong></abbr></td>
                                            <td>:</td>
                                            <td>(+62) 895 3330 17060</td>
                                        </tr>
                                        <tr>
                                            <td><abbr title="Email Address"
                                                    style="display: inline-block;margin-bottom: 7px;"><strong>Email</strong></abbr>
                                            </td>
                                            <td>:</td>
                                            <td>info@bankiracademy.com</td>
                                        </tr>
                                    </table>
                                    {{-- <br> --}}
                                    {{-- <abbr title="Fax"><strong>Whatsapp 1:</strong></abbr> (+62) 895 3122 9494<br>
                                    --}}
                                    {{-- <br> --}}

                                    {{-- <br> --}}
                                </div>
                            </div>
                        </div>
                        {{-- <a href="#" class="social-icon si-small si-rounded topmargin-sm si-facebook"
                            style="color: black">
                            <i class="icon-facebook"></i>
                            <i class="icon-facebook"></i>
                        </a>
                        <a href="#" class="social-icon si-small si-rounded topmargin-sm si-twitter"
                            style="color: black">
                            <i class="icon-twitter"></i>
                            <i class="icon-twitter"></i>
                        </a>
                        <a href="#" class="social-icon si-small si-rounded topmargin-sm si-gplus" style="color: black">
                            <i class="icon-gplus"></i>
                            <i class="icon-gplus"></i>
                        </a>
                        <a href="#" class="social-icon si-small si-rounded topmargin-sm si-pinterest"
                            style="color: black">
                            <i class="icon-pinterest"></i>
                            <i class="icon-pinterest"></i>
                        </a>
                        <a href="#" class="social-icon si-small si-rounded topmargin-sm si-vimeo" style="color: black">
                            <i class="icon-vimeo"></i>
                            <i class="icon-vimeo"></i>
                        </a>
                        <a href="#" class="social-icon si-small si-rounded topmargin-sm si-github" style="color: black">
                            <i class="icon-github"></i>
                            <i class="icon-github"></i>
                        </a>
                        <a href="#" class="social-icon si-small si-rounded topmargin-sm si-yahoo" style="color: black">
                            <i class="icon-yahoo"></i>
                            <i class="icon-yahoo"></i>
                        </a>
                        <a href="#" class="social-icon si-small si-rounded topmargin-sm si-linkedin"
                            style="color: black">
                            <i class="icon-linkedin"></i>
                            <i class="icon-linkedin"></i>
                        </a> --}}
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="widget clearfix">
                        <h4 style="color: black">Bantuan & Panduan</h4>
                        {{-- <a href="/sdank" style="color: black">Register Instructor</a><br> --}}
                        <div class="form-result laman_footer" style="color: black">
                            {{-- <a href="#">Layanan Pengaduan</a><br>
                            <a href="#">Syarat & Ketentuan</a><br>
                            <a href="#">Kebijakan Privasi</a><br>
                            <a href="#">Tentang Kami</a><br>
                            <a href="#">Kontak Kami</a><br>
                            <a href="#">Press Kit</a><br>
                            <a href="#">Bantuan</a><br>
                            <a href="#">Karier</a><br> --}}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="widget quick-contact-widget form-widget clearfix" style="color: black">
                        <h4 style="color: black">Up coming</h4>
                        <img src="{{ asset('google-play-and-apple-app-store-logos-22.png') }}" alt="" width="200px">
                        <p></p>
                        <img src="{{ asset('pse-terdaftar.png') }}" alt="" width="50px">
                        {{-- <p>001922.04/DJAI.PSE/12/2022</p> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    @if(Session::has('akses'))
    <input type="text" id="is_akses" value="{{Session::get('akses')}}" hidden>
    @else
    <input type="text" id="is_akses" hidden>
    @endif
    <div id="copyrights" style="background-color:#0076f5; padding: 25px">
        <div class="container">
            <div class="w-100 text-center text-white">
                Copyright 2022 PT. Bankir Academy
            </div>
            {{-- <div class="w-100 text-center text-white">
                Management By PT. Bankir Academy Indonesia </br> Support Sistem By <a
                    href="https://akarindo.id/">Akarindo.id</a>
            </div> --}}
        </div>
    </div>
</footer><!-- #footer end -->

</div><!-- #wrapper end -->
<!-- Go To Top
 ============================================= -->
<div id="gotoTop" class="icon-angle-up"></div>
<!-- Footer Scripts
============================================= -->
<script src="{{ asset('front/js/functions.js') }}"></script>

<!-- SLIDER REVOLUTION 5.x SCRIPTS  -->
<script src="{{ asset('front/js/components/rangeslider.min.js') }}"></script>
<script src="{{ asset('front/js/components/bs-datatable.js') }}"></script>
<script src="{{ asset('front/js/components/bs-filestyle.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="{{ asset('front/toast/dist/js/iziToast.min.js') }}" type="text/javascript"></script>


<script>
    var tpj = jQuery;
    tpj.noConflict();
    var $ = jQuery.noConflict();

    tpj(document).ready(function() {
        var apiRevoSlider = tpj('#rev_slider_ishop').show().revolution({
            sliderType: "standard",
            jsFileLocation: "include/rs-plugin/js/",
            sliderLayout: "fullwidth",
            dottedOverlay: "none",
            delay: 9000,
            navigation: {},
            responsiveLevels: [1200, 992, 768, 480, 320],
            gridwidth: 1140,
            gridheight: 500,
            lazyType: "none",
            shadow: 0,
            spinner: "off",
            autoHeight: "off",
            disableProgressBar: "on",
            hideThumbsOnMobile: "off",
            hideSliderAtLimit: 0,
            hideCaptionAtLimit: 0,
            hideAllCaptionAtLilmit: 0,
            debugMode: false,
            fallbacks: {
                simplifyAll: "off",
                disableFocusListener: false,
            },
            navigation: {
                keyboardNavigation: "off",
                keyboard_direction: "horizontal",
                mouseScrollNavigation: "off",
                onHoverStop: "off",
                touch: {
                    touchenabled: "on",
                    swipe_threshold: 75,
                    swipe_min_touches: 1,
                    swipe_direction: "horizontal",
                    drag_block_vertical: false
                },
                arrows: {
                    style: "ares",
                    enable: true,
                    hide_onmobile: false,
                    hide_onleave: false,
                    tmp: '<div class="tp-title-wrap">	<span class="tp-arr-titleholder"></span> </div>',
                    left: {
                        h_align: "left",
                        v_align: "center",
                        h_offset: 10,
                        v_offset: 0
                    },
                    right: {
                        h_align: "right",
                        v_align: "center",
                        h_offset: 10,
                        v_offset: 0
                    }
                }
            }
        });

        apiRevoSlider.on("revolution.slide.onloaded", function(e) {
            SEMICOLON.slider.sliderDimensions();
        });
        $('#datatable1').dataTable();
        $('.component-datepicker.past-enabled').datepicker({
            autoclose: true,
        });
        
    }); //ready
</script>

<script>
    $('#datatable1').dataTable();
    getLaman();
    $(document).ready(function() {
        $('#loader-loading').remove();
        let akses = $('#is_akses').val();
        if (akses == 'auth') {
            $('#modelId').modal('show')
        }
        if (akses == 'member') {
            $('#modelmember').modal('show')
        }
    })
    function getImgData(fil, prv) {
		const files = fil.files[0];
		if (files) {
			const fileReader = new FileReader();
			fileReader.readAsDataURL(files);
			fileReader.addEventListener("load", function() {
				$(prv).attr('src', this.result);
			});
		}
	}
    function popc() {
        Swal.fire({
            // icon: 'info',
            // title: 'Oops...',
            // text: "<img src='coming_soon_loker-28' style='width:150px;'>",
            // html: true,
            // content:true,
            imageUrl:'<?= asset("coming_soon_loker-28.jpg") ?>',
            // showConfirmButton:false,
            footer: '<a href="https://bankiracademy.com/">By akarindo.id</a>'
        })
    }
    $('#login').removeAttr('disabled')
    let form = $('#orderForm').val()

    function funclogin(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        if (!$("#emaillogin").val()) {
            return false;
        }
        if (!$("#passwordlogin").val()) {
            return false;
        }
        let data = {
            email: $("#emaillogin").val(),
            password: $("#passwordlogin").val(),
        }
        var class_id = $("#class_id").val();
        if (class_id) {
            data.class_id = class_id
        }

        jQuery.ajax({
            url: "{{ route('login') }}",
            method: 'post',
            data: data,
            success: function(result) {
                console.log(result);
                $('#login').attr('disabled', true)
                iziToast.success({
                    title: 'Success',
                    message: 'Login Berhasil',
                    position: 'topRight',
                });
                setTimeout(() => {
                    if (result.length > 500) {
                        window.location = '/home';
                    } else {
                        var class_id = $("#class_id");
                        var _token = document.getElementsByName("_token");
                        if ((class_id.length > 0) && (_token.length > 0)) {
                            return window.location = '/ordernopost?_token=' + _token +
                                '&class_id=' + class_id;
                        } else {
                            window.location = '/profile';
                            // return location.reload();
                        }
                    }
                }, 2000);
            },
            error: function(jqXhr, json, errorThrown) { // this are default for ajax errors
                var errors = jqXhr.responseJSON;
                var errorsHtml = '';
                $.each(errors['errors'], function(index, value) {
                    iziToast.error({
                        title: 'Error',
                        message: value,
                        position: 'topRight',
                    });
                });
            }
        })
    }

    function closemodalregi() {
        $("#registerfs").modal("hide")
        $("#usernameregis").val('');
        $("#produk").val('');
        $("#emailregis").val('');
        $("#passwordregis").val('');
        $("#confpassword").val('');
    }

    function closemodallogin() {
        $("#modelId").modal("hide")
        $("#emaillogin").val('');
        $("#passwordlogin").val('');
    }

    function funcregis() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var usernameregis = $("#usernameregis").val();
        var produk = $("#produk").val();
        var emailregis = $("#emailregis").val();
        var passwordregis = $("#passwordregis").val();
        var confpassword = $("#confpassword").val();
        jQuery.ajax({
            url: "{{ route('register') }}",
            method: 'post',
            data: {
                name: usernameregis,
                produk_id: produk,
                email: emailregis,
                password: passwordregis,
                password_confirmation: confpassword
            },
            success: function(result) {
                iziToast.success({
                    title: 'Success',
                    message: 'Login Berhasil',
                    position: 'topRight',
                });
                // location.replace("/get-order?produk_id=" + produk);
                console.log(result)
            },
            error: function(jqXhr, json, errorThrown) { // this are default for ajax errors
                var errors = jqXhr.responseJSON;
                var errorsHtml = '';
                $.each(errors['errors'], function(index, value) {
                    iziToast.error({
                        title: 'Error',
                        message: value,
                        position: 'topRight',
                    });
                });
            }
        })
    }

    function getLaman() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: "/all-laman",
            method: 'get',
            success: function(result) {
                if (result.laman_footer.length > 0) {
                    result.laman_footer.forEach(el => {
                        let foo = '<a href="/u-laman/' + el.slug +
                            '" class="text-capitalize" style="color: black">' + el.title +
                            '</a><br>';
                        $('.laman_footer').append(foo);
                    });
                }
                let foo = '<a href="/pages/page/7" class="text-capitalize" style="color: black">Frequently Asked Questions (FAQ)</a><br>';
                $('.laman_footer').append(foo);
                if (result.laman_head.length > 0) {
                    result.laman_head.forEach(el => {
                        // let foo = '<a href="/u-laman/'+el.slug+'" class="text-capitalize">'+el.title+'</a><br>';
                        // $('.laman_footer').append(foo);
                    });
                }
            },
            error: function(jqXhr, json, errorThrown) { // this are default for ajax errors
                var errors = jqXhr.responseJSON;
                var errorsHtml = '';
                $.each(errors['errors'], function(index, value) {
                    iziToast.error({
                        title: 'Error',
                        message: value,
                        position: 'topRight',
                    });
                });
            }
        })
    }
</script>

</body>

</html>