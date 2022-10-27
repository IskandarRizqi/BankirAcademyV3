<!-- Footer
		============================================= -->
<footer id="footer" class="dark">
    <div class="container">

        <div class="footer-widgets-wrap">
            <div class="row col-mb-50">
                <div class="col-lg-6">
                    <div class="widget clearfix">
                        <p>Bankir Akademi merupakan platform digital learning yang dapat digunakan sebagai media
                            pembelajaran untuk seluruh calon dan karyawan bank.
                        </p>
                        <div class="py-2" style="background: url('images/world-map.png') no-repeat center center;">
                            <div class="row col-mb-30">
                                <div class="col-6">
                                    <address class="mb-0">
                                        <abbr title="Headquarters"
                                            style="display: inline-block;margin-bottom: 7px;"><strong>Alamat:</strong></abbr><br>
                                        Jl. Jendral Sudirman 354, Semarang Barat<br> Kota Semarang<br>
                                    </address>
                                </div>
                                <div class="col-6">
                                    <abbr title="Phone Number"><strong>Phone:</strong></abbr> (1) 8547 632521<br>
                                    <abbr title="Fax"><strong>Fax:</strong></abbr> (1) 11 4752 1433<br>
                                    <abbr title="Email Address"><strong>Email:</strong></abbr> info@akarindo.id
                                </div>
                            </div>
                        </div>
                        <a href="#" class="social-icon si-small si-rounded topmargin-sm si-facebook">
                            <i class="icon-facebook"></i>
                            <i class="icon-facebook"></i>
                        </a>
                        <a href="#" class="social-icon si-small si-rounded topmargin-sm si-twitter">
                            <i class="icon-twitter"></i>
                            <i class="icon-twitter"></i>
                        </a>
                        <a href="#" class="social-icon si-small si-rounded topmargin-sm si-gplus">
                            <i class="icon-gplus"></i>
                            <i class="icon-gplus"></i>
                        </a>
                        <a href="#" class="social-icon si-small si-rounded topmargin-sm si-pinterest">
                            <i class="icon-pinterest"></i>
                            <i class="icon-pinterest"></i>
                        </a>
                        <a href="#" class="social-icon si-small si-rounded topmargin-sm si-vimeo">
                            <i class="icon-vimeo"></i>
                            <i class="icon-vimeo"></i>
                        </a>
                        <a href="#" class="social-icon si-small si-rounded topmargin-sm si-github">
                            <i class="icon-github"></i>
                            <i class="icon-github"></i>
                        </a>
                        <a href="#" class="social-icon si-small si-rounded topmargin-sm si-yahoo">
                            <i class="icon-yahoo"></i>
                            <i class="icon-yahoo"></i>
                        </a>
                        <a href="#" class="social-icon si-small si-rounded topmargin-sm si-linkedin">
                            <i class="icon-linkedin"></i>
                            <i class="icon-linkedin"></i>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="widget clearfix">
                        <h4>Recent Posts</h4>
                        <div class="posts-sm row col-mb-30" id="post-list-footer">
                            @foreach ($pop as $key => $p)
                            @if ($key <= 2) <div class="entry col-12">
                                <div class="grid-inner row">
                                    <div class="col">
                                        <div class="entry-title">
                                            <h4><a href="class/{{$p->unique_id}}/{{$p->title}}">{{$p->title}}</a></h4>
                                        </div>
                                        <div class="entry-meta">
                                            <ul>
                                                <li>{{\Carbon\Carbon::parse($p->date_start)->format('F d, Y')}}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="widget quick-contact-widget form-widget clearfix">
                    <h4>Bantuan & Panduan</h4>
                    <div class="form-result"></div>
                    <a href="#">Layanan Pengaduan</a><br>
                    <a href="#">Syarat & Ketentuan</a><br>
                    <a href="#">Kebijakan Privasi</a><br>
                    <a href="#">Tentang Kami</a><br>
                    <a href="#">Kontak Kami</a><br>
                    <a href="#">Press Kit</a><br>
                    <a href="#">Bantuan</a><br>
                    <a href="#">Karier</a><br>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div id="copyrights">
        <div class="container">
            <div class="w-100 text-center">
                Copyrights &copy; 2022 By <a href="https://akarindo.id/">Akarindo.id</a>
            </div>
        </div>
    </div>
</footer><!-- #footer end -->

</div><!-- #wrapper end -->
<!-- Go To Top
	============================================= -->
<div id="gotoTop" class="icon-angle-up"></div>


<!-- Footer Scripts
============================================= -->
<script src="{{asset('front/js/functions.js')}}"></script>

<!-- SLIDER REVOLUTION 5.x SCRIPTS  -->
<script src="{{asset('front/include/rs-plugin/js/jquery.themepunch.tools.min.js')}}"></script>
<script src="{{asset('front/include/rs-plugin/js/jquery.themepunch.revolution.min.js')}}"></script>

<script src="{{asset('front/include/rs-plugin/js/extensions/revolution.extension.video.min.js')}}"></script>
<script src="{{asset('front/include/rs-plugin/js/extensions/revolution.extension.slideanims.min.js')}}"></script>
<script src="{{asset('front/include/rs-plugin/js/extensions/revolution.extension.actions.min.js')}}"></script>
<script src="{{asset('front/include/rs-plugin/js/extensions/revolution.extension.layeranimation.min.js')}}"></script>
<script src="{{asset('front/include/rs-plugin/js/extensions/revolution.extension.kenburn.min.js')}}"></script>
<script src="{{asset('front/include/rs-plugin/js/extensions/revolution.extension.navigation.min.js')}}"></script>
<script src="{{asset('front/include/rs-plugin/js/extensions/revolution.extension.migration.min.js')}}"></script>
<script src="{{asset('front/include/rs-plugin/js/extensions/revolution.extension.parallax.min.js')}}"></script>
<script src="{{asset('front/js/components/rangeslider.min.js')}}"></script>
<script src="{{asset('front/js/components/bs-datatable.js')}}"></script>
<script src="{{asset('front/js/components/bs-filestyle.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="{{asset('front/toast/dist/js/iziToast.min.js')}}" type="text/javascript"></script>
<script src="{{asset('front/js/components/moment.js')}}"></script>
<script src="{{asset('front/js/components/timepicker.js')}}"></script>
<script src="{{asset('front/js/components/datepicker.js')}}"></script>
<script src="{{asset('front/js/components/daterangepicker.js')}}"></script>


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
    function funclogin(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var emaillogin = $("#emaillogin").val();
        var passwordlogin = $("#passwordlogin").val();
        jQuery.ajax({
            url: "{{ route('login') }}",
            method: 'post',
            data: {
                email: emaillogin,
                password: passwordlogin
            },
            success: function(result) {
                if (result.role == 0 || result.role == 1) {
                    location.replace("/home")
                } else {
                    location.reload();
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
</script>

</body>

</html>