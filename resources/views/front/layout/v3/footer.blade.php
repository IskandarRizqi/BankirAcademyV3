  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
.contact-info p {
    display: flex;
    align-items: flex-start;
    margin: 7px 0;
    color: black;
}

.contact-info i {
    margin-right: 8px;
    margin-top: 3px; /* biar ikon sejajar atas teks */
    color: black;
    min-width: 18px; /* supaya semua ikon rata kiri */
}



</style>
        <footer class="footer-light p-0 position-relative">
                        <div id="particles-04" class="position-absolute h-100 top-0 left-0 z-index-minus-1 w-100" data-particle="true" data-particle-options='{"particles": {"number": {"value": 5,"density": {"enable": true,"value_area": 1000}},"color":{"value":["#b7b9be", "#dd6531"]},"shape": {"type": "circle","stroke":{"width":0,"color":"#000000"}},"opacity": {"value": 0.5,"random": false,"anim": {"enable": false,"speed": 1,"sync": false}},"size": {"value": 8,"random": true,"anim": {"enable": false,"sync": true}},"move": {"enable": true,"speed":2,"direction": "right","random": false,"straight": false}},"interactivity": {"detect_on": "canvas","events": {"onhover": {"enable": false,"mode": "repulse"},"onclick": {"enable": false,"mode": "push"},"resize": true}},"retina_detect": false}'></div>
                        <div class="container"> 
                            <div class="row justify-content-center pt-7 sm-pt-50px">
                                <!-- start footer column -->
                            <div class="col-lg-4 col-md-4 col-sm-12 text-md-center text-lg-start md-mb-30px">
                <img src="/logo bankir-12-2.png" alt="" width="80%" style="margin-bottom:15px;">
                <p class="mb-2 text-justify" style="color: black">
                    <b>{{ env('APP_NAME', 'Bankir Akademi') }}</b> merupakan platform digital learning
                    yang dapat digunakan sebagai media pembelajaran untuk seluruh calon dan karyawan bank.
                </p>
                <br>
                <div class="contact-info" style="text-align: left;">
                    <p><i class="fas fa-map-marker-alt"></i> PT. Bankir Academy Indonesia<br>
                        Jl. Jendral Sudirman 354, Semarang Barat<br>
                        Kota Semarang
                    </p>
                    <p><i class="fas fa-phone"></i> (024) 76435498</p>
                    <p><i class="fab fa-whatsapp"></i> 0895 3330 17060</p>
                    <p><i class="fas fa-envelope"></i> info@bankiracademy.com</p>
                </div>
            </div>

            <!-- Kolom 2 -->
            <div class="col-lg-4 col-md-4 col-sm-12 md-mb-30px">
                <!-- Judul Layanan -->
                <span class="alt-font d-block text-dark-gray fw-600 mb-10px fs-19 ">
                    Layanan
                </span>
                <div class="form-result layanan_footer mb-4" style="color: black">
                    <a href="#">Syarat & Ketentuan</a><br>
                    <a href="#">Kebijakan Privasi</a><br>
                    <a href="#">Tentang Kami</a><br>
                    <a href="#">Kontak Kami</a><br>
                    <a href="#">Press Kit</a><br>
                    <a href="#">Karier</a><br>
                </div>

                <!-- Judul Bantuan & Panduan -->
                <span class="alt-font d-block text-dark-gray fw-600 mb-10px fs-19 ">
                    Bantuan & Panduan
                </span>
                <div class="form-result bantuan_footer mb-4" style="color: black">
                    <a href="#">Frequently Asked Questions (FAQ)</a><br>
                </div>
            </div>

            <!-- Kolom 3 -->
            <div class="col-lg-4 col-md-4 col-sm-12">
                <span class="alt-font d-block text-dark-gray fw-600 mb-10px fs-19">Up Coming</span>
                <img src="{{ asset('google-play-and-apple-app-store-logos-22.png') }}" alt="" width="200px">
                <br>
                <br>
                <p class="m-0" style="color: black">Terdaftar di Kominfo</p>
                <b style="color: black">001922.04/DJAI.PSE/12/2022</b>
            </div>

                   
                    <!-- end footer column -->
                </div> 
                <br>
            </div> 
            <div id="copyrights" style="background-color:#0076f5; padding: 25px">
                <div class="container">
                    <div class="w-100 text-center text-white">
                        Copyright 2022 PT. Bankir Academy Indonesia
                    </div>
                    {{-- <div class="w-100 text-center text-white">
                        Management By PT. Bankir Academy Indonesia </br> Support Sistem By <a
                            href="https://akarindo.id/">Akarindo.id</a>
                    </div> --}}
                </div>
            </div>
        </footer>

        

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
        $('.component-datepicker.past-enabled').datepicker({
            autoclose: true,
        });
        
    }); //ready
</script>

<script>
    $('#datatable1').dataTable();
    $('#datatable2').dataTable();
    $('#datatable3').dataTable();
    $('#datatable4').dataTable();
    $('#datatable5').dataTable();
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
    function triggerresize() {
        setTimeout(() => {
            window.dispatchEvent(new Event('resize'));
        }, 500);
    }
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
                $('#login').attr('disabled', true)
                
                Swal.fire({
                    icon: 'success',
                    title: 'Login Berhasil',
                    text: "Silahkan tunggu, anda akan redirect otomatis",
                })
                // iziToast.success({
                //     title: 'Success',
                //     message: 'Login Berhasil',
                //     position: 'topRight',
                // });
                setTimeout(() => {
                    if (result.length > 500) {
                        window.location = '/';
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
                if (result.layanan.length > 0) {
                    result.layanan.forEach(el => {
                        let foo = '<a href="/pages/blog/'+el.id+'/'+createslug(el.title)+'" class="text-capitalize" style="color: black">' + el.title +
                            '</a><br>';
                        $('.layanan_footer').append(foo);
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
    function createslug(string) {
        return string.toLowerCase()
    .trim()
    .replace(/[^\w\s-]/g, '')
    .replace(/[\s_-]+/g, '-')
    .replace(/^-+|-+$/g, '');
    }
</script>