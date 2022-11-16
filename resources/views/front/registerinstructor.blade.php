<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="SemiColonWeb" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Stylesheets
	============================================= -->
    <link
        href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Poppins:300,400,500,600,700|PT+Serif:400,400i&display=swap"
        rel="stylesheet" type="text/css" />
    <link rel="icon" type="image/x-icon" href="{{asset('admin/fav06.png')}}" />
    <link rel="stylesheet" href="{{asset('front/css/bootstrap.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/style.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/css/dark.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/css/font-icons.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/css/animate.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/css/magnific-popup.css')}}" type="text/css" />

    <link rel="stylesheet" href="{{asset('front/css/custom.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/toast/dist/css/iziToast.min.css')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Document Title
	============================================= -->
    <title>REGISTER</title>

</head>

<body class="stretched">

    <!-- Document Wrapper
	============================================= -->
    <div id="wrapper" class="clearfix">

        <!-- Content
		============================================= -->
        <section id="content">
            <div class="content-wrap py-0">

                <div class="section dark p-0 m-0 h-100 position-absolute"></div>

                <div class="section bg-transparent min-vh-100 p-0 m-0 d-flex">
                    <div class="vertical-middle">
                        <div class="container py-5">

                            <form action="/inputinstructor" method="POST">
                                @csrf
                                <div class="card mx-auto rounded-0 border-0" style="max-width: 400px;">
                                    <div class="card-body" style="padding: 40px;">
                                        <div class="col-12 form-group">
                                            <label class="font-body text-capitalize"
                                                for="login-form-modal-username">Nama</label>
                                            <input type="text" id="nama" name="nama" class="form-control" />
                                        </div>
                                        <div class="col-12 form-group">
                                            <label class="font-body text-capitalize"
                                                for="login-form-modal-username">EMAIL</label>
                                            <input type="email" id="email" name="email" class="form-control" />
                                        </div>
                                        <div class="col-12 form-group">
                                            <label class="font-body text-capitalize" for="login-form-modal-username">No.
                                                HP</label>
                                            <input type="number" id="nohp" name="nohp" class="form-control" />
                                            <small>628123456789</small>
                                        </div>
                                        <div class="col-12 form-group">
                                            <label class="font-body text-capitalize"
                                                for="login-form-modal-username">Alamat</label>
                                            <textarea type="text" id="alamat" name="alamat"
                                                class="form-control"></textarea>
                                        </div>
                                        <div class="col-12 form-group">
                                            <label class="font-body text-capitalize"
                                                for="login-form-modal-username">Deskripsi</label>
                                            <textarea type="text" id="deskripsi" name="deskripsi"
                                                class="form-control"></textarea>
                                        </div>

                                        <div class="col-12 form-group">
                                            <button class="button button-rounded m-0" type="submit">REGISTER</button>
                                        </div>
                            </form>
                            {{-- <div class="d-flex justify-content-center">
                                have an account? &nbsp;
                                <a href="{{url('/')}}"> Login</a>
                            </div>
                            <div class="line line-sm"></div>
                            <a href="{{url('/auth/google')}}"
                                class="button button-rounded btn-block font-weight-normal center text-capitalize si-gplus si-colored m-0">Login
                                with Google</a> --}}
                        </div>
                    </div>

                    <!-- <div class="text-center text-muted mt-3"><small>Copyrights &copy; All Rights Reserved by Canvas Inc.</small></div> -->

                </div>
            </div>
    </div>

    </div>
    </section><!-- #content end -->

    </div><!-- #wrapper end -->

    <!-- Go To Top
	============================================= -->
    <div id="gotoTop" class="icon-angle-up"></div>

    <!-- JavaScripts
============================================= -->
    <script src="https://code.jquery.com/jquery-3.6.1.js"
        integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="{{asset('front/js/plugins.min.js')}}"></script>
    <!-- <script src="{{asset('front/js/jquery.js')}}"></script> -->

    <!-- Footer Scripts
============================================= -->
    <script src="{{asset('front/js/functions.js')}}"></script>
    <script src="{{asset('front/toast/dist/js/iziToast.min.js')}}" type="text/javascript"></script>
    <script>
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
                    email: emailregis,
                    password: passwordregis,
                    password_confirmation: confpassword
                },
                success: function(result) {
                    // location.replace("/get-order?produk_id=" + produk);
                    location.replace("/");
                    // console.log(result)
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