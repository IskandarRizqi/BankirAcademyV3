<!-- Footer
  ============================================= -->
<footer id="footer" class="dark">
    <div id="copyrights">
        <div class="container">
            <div class="w-100 text-center">
				<span class="float-left">
					Copyrights &copy; 2022 By <a href="https://lucas.akarindo.id/">Lucas Sulaiman Mulyawan</a>
				</span>
				<span class="float-right">
					Supported By <a href="https://ehr.co.id/">EHR System</a>
				</span>
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
<script src="{{ asset('front/js/functions.js') }}"></script>

<!-- SLIDER REVOLUTION 5.x SCRIPTS  -->
<script src="{{ asset('front/include/rs-plugin/js/jquery.themepunch.tools.min.js') }}"></script>
<script src="{{ asset('front/include/rs-plugin/js/jquery.themepunch.revolution.min.js') }}"></script>

<script src="{{ asset('front/include/rs-plugin/js/extensions/revolution.extension.video.min.js') }}"></script>
<script src="{{ asset('front/include/rs-plugin/js/extensions/revolution.extension.slideanims.min.js') }}"></script>
<script src="{{ asset('front/include/rs-plugin/js/extensions/revolution.extension.actions.min.js') }}"></script>
<script src="{{ asset('front/include/rs-plugin/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
<script src="{{ asset('front/include/rs-plugin/js/extensions/revolution.extension.kenburn.min.js') }}"></script>
<script src="{{ asset('front/include/rs-plugin/js/extensions/revolution.extension.navigation.min.js') }}"></script>
<script src="{{ asset('front/include/rs-plugin/js/extensions/revolution.extension.migration.min.js') }}"></script>
<script src="{{ asset('front/include/rs-plugin/js/extensions/revolution.extension.parallax.min.js') }}"></script>
<script src="{{ asset('front/js/components/rangeslider.min.js') }}"></script>
<script src="{{ asset('front/js/components/bs-datatable.js') }}"></script>
<script src="{{ asset('front/js/components/bs-filestyle.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="{{ asset('front/toast/dist/js/iziToast.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('front/js/components/moment.js') }}"></script>
<script src="{{ asset('front/js/components/timepicker.js') }}"></script>
<script src="{{ asset('front/js/components/datepicker.js') }}"></script>
<script src="{{ asset('front/js/components/daterangepicker.js') }}"></script>


<script>
    console.log('27-10-2022 20:25');
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
    $('#login').removeAttr('disabled')
    let form = $('#orderForm').val()
    function funclogin(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // var emaillogin = ;
        // var passwordlogin = ;
        let data = {
            email : $("#emaillogin").val(),
            password : $("#passwordlogin").val(),
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
                $('#login').attr('disabled',true)
                setTimeout(() => {
                    if (result.role == 0 || result.role == 1) {
                        location.replace("/home")
                    } else {
                        var class_id = $("#class_id").val();
                        var _token = document.getElementsByName("_token");
                        if (class_id && _token) {
                            return window.location = '/ordernopost?_token='+_token+'&class_id='+class_id;
                        }
                    }
                    location.reload();
                }, 2000);
                iziToast.success({
                    title: 'Success',
                    message: 'Login Berhasil',
                    position: 'topRight',
                });
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
</script>

</body>

</html>