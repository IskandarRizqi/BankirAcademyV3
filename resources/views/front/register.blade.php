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
    <link rel="icon" type="image/x-icon" href="{{env('CUSTOM_FAVICON','/Backend/logo_12.png')}}" />
    <link rel="stylesheet" href="{{asset('front/css/bootstrap.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/style.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/css/dark.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/css/font-icons.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/css/animate.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('front/css/magnific-popup.css')}}" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{asset('Backend/plugins/select2/select2.min.css')}}">

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
                <div class="section dark p-0 m-0 h-100 position-absolute"
                    style="background-size: 100%; background-image: url('{{asset('Bg-register-01.jpg')}}')"></div>
                <div class="section bg-transparent min-vh-100 p-0 m-0 d-flex">
                    <div class="vertical-middle">
                        <div class="container py-5">
                            <div class="card mx-auto rounded-0 border-0" style="max-width: 400px;">
                                <div class="card-body" style="padding: 40px;">
                                    @if (Session::has('error'))
                                    <p class="text-danger">{{Session::get('error')}}</p>
                                    @endif
                                    <div class="tabs tabs-bb clearfix ui-tabs ui-corner-all ui-widget ui-widget-content"
                                        id="tab-9">
                                        <ul class="tab-nav clearfix ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header"
                                            role="tablist">
                                            <li role="tab" tabindex="-1"
                                                class="ui-tabs-tab ui-corner-top ui-state-default ui-tab"
                                                aria-controls="tabs-33" aria-labelledby="ui-id-17" aria-selected="false"
                                                aria-expanded="false"><a href="#tabs-33" tabindex="-1"
                                                    class="ui-tabs-anchor" id="ui-id-17">Perorangan</a></li>
                                            <li role="tab" tabindex="-1"
                                                class="ui-tabs-tab ui-corner-top ui-state-default ui-tab"
                                                aria-controls="tabs-34" aria-labelledby="ui-id-18" aria-selected="false"
                                                aria-expanded="false"><a href="#tabs-34" tabindex="-1"
                                                    class="ui-tabs-anchor" id="ui-id-18">Corporate</a></li>
                                        </ul>
                                        <div class="tab-container">
                                            <div class="tab-content clearfix ui-tabs-panel ui-corner-bottom ui-widget-content"
                                                id="tabs-33" aria-labelledby="ui-id-17" role="tabpanel"
                                                aria-hidden="true" style="display: none;">
                                                <div class="col-12 form-group">
                                                    <label class="font-body text-capitalize"
                                                        for="login-form-modal-username">USERNAME</label>
                                                    <input type="text" id="usernameregis" name="name"
                                                        class="form-control" />
                                                </div>
                                                <div class="col-12 form-group">
                                                    <label class="font-body text-capitalize"
                                                        for="login-form-modal-username">EMAIL</label>
                                                    <input type="email" id="emailregis" name="email"
                                                        class="form-control" />

                                                </div>

                                                <div class="col-12 form-group">
                                                    <label class="font-body text-capitalize"
                                                        for="login-form-modal-password">PASSWORD</label>
                                                    <input type="password" id="passwordregis" name="password"
                                                        class="form-control" required />

                                                </div>
                                                <div class="col-12 form-group">
                                                    <label class="font-body text-capitalize"
                                                        for="login-form-modal-password">CONFIRM
                                                        PASSWORD</label>
                                                    <input type="password" id="confpassword"
                                                        name="password_confirmation" class="form-control" required />
                                                </div>
                                                <div class="col-12 form-group">
                                                    <label class="font-body text-capitalize"
                                                        for="login-form-modal-password">REFERRAL (optional)</label>
                                                    <input type="text" id="referral" name="referral"
                                                        class="form-control" />
                                                </div>

                                                <div class="col-12 form-group">
                                                    <button class="button button-rounded m-0" onclick="funcregis()"
                                                        type="submit">REGISTER</button>
                                                </div>
                                                {{-- <a href="{{url('/auth/google')}}"
                                                    class="button button-rounded btn-block font-weight-normal center text-capitalize si-gplus si-colored m-0">Login
                                                    with Google</a> --}}
                                            </div>
                                        </div>
                                        <div class="tab-content clearfix ui-tabs-panel ui-corner-bottom ui-widget-content"
                                            id="tabs-34" aria-labelledby="ui-id-18" role="tabpanel" aria-hidden="true"
                                            style="display: none;">
                                            <form action="/registercorporate" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="col-12 form-group">
                                                    <label for="form-control">Jenis Corporate</label>
                                                    <select name="jenis_corporate" class="form-control"
                                                        id="jenis_corporate" required>
                                                        <option value="">Pilih</option>
                                                        <option value="bankumum">Bank Umum</option>
                                                        <option value="bpr">BPR</option>
                                                        <option value="koperasi">Koperasi</option>
                                                        <option value="lkm">Lembaga Keuangan Mikro</option>
                                                    </select>
                                                    @error('jenis_corporate')
                                                    <small class="text-danger">Harus Diisi</small>
                                                    @enderror
                                                </div>
                                                <div class="col-12 form-group">
                                                    <label class="font-body text-capitalize"
                                                        for="login-form-modal-username">Corporate</label>
                                                    <select name="corporate" id="corporate" class="form-control">
                                                        <option value="">Select</option>
                                                        {{-- @foreach ($lokasi as $d)
                                                        <option value="{{$d}}">{{$d}}</option>
                                                        @endforeach --}}
                                                    </select>
                                                    @error('corporate')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-12 form-group">
                                                    <label class="font-body text-capitalize"
                                                        for="login-form-modal-username">USERNAME</label>
                                                    <input type="text" id="usernameregis" name="name"
                                                        class="form-control" />
                                                    @error('name')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-12 form-group">
                                                    <label class="font-body text-capitalize"
                                                        for="login-form-modal-username">EMAIL</label>
                                                    <input type="email" id="emailregis" name="email"
                                                        class="form-control" />
                                                    @error('email')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-12 form-group">
                                                    <label class="font-body text-capitalize"
                                                        for="login-form-modal-password">PASSWORD</label>
                                                    <input type="password" id="passwordregis" name="password"
                                                        class="form-control" required />
                                                    @error('password')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-12 form-group">
                                                    <label class="font-body text-capitalize"
                                                        for="login-form-modal-password">CONFIRM
                                                        PASSWORD</label>
                                                    <input type="password" id="confpassword"
                                                        name="password_confirmation" class="form-control" required />
                                                    @error('password')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-12 form-group">
                                                    <label class="font-body text-capitalize"
                                                        for="login-form-modal-password">REFERRAL (optional)</label>
                                                    <input type="text" id="referral" name="referral"
                                                        class="form-control" />
                                                </div>

                                                <div class="col-12 form-group">
                                                    <button class="button button-rounded m-0"
                                                        type="submit">REGISTER</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        have an account? &nbsp;
                                        <a href="{{url('/')}}"> Login</a>
                                    </div>
                                </div>
                            </div>
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
    <script src="{{asset('Backend/plugins/select2/select2.min.js')}}"></script>

    <!-- Footer Scripts
============================================= -->
    <script src="{{asset('front/js/functions.js')}}"></script>
    <script src="{{asset('front/toast/dist/js/iziToast.min.js')}}" type="text/javascript"></script>
    <script>
        // $('#corporate').select2({
        //     tags: "false",
        // placeholder: "Select an option",
        // })
        $('#jenis_corporate').on('change', function () {
            let val = $('#jenis_corporate').val();
            $('#corporate').val(null);
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "/admin/corporates/"+val,
                method: 'get',
                success: function(result) {
                    console.log(result);
                    let h = '';
                    result.forEach(element => {
                        h+='<option value="'+element.id+'">'+element.nama+'</option>';
                    });
                    $('#corporate').html(h);
                },
                error: function(jqXhr, json, errorThrown) { // this are default for ajax errors 
                    var errors = jqXhr.responseJSON;
                    console.log(errors);
    
                }
            })
        })
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
                // url: "{{ route('register') }}",
                url: "/registerUser",
                method: 'post',
                data: {
                    name: usernameregis,
                    email: emailregis,
                    password: passwordregis,
                    password_confirmation: confpassword,
                    referral : $('#referral').val()
                },
                success: function(result) {
                    // location.replace("/get-order?produk_id=" + produk);
                    // console.log(result)
                    if (result.status == 200) {
                        iziToast.success({
                            title: 'Success',
                            message: 'Register Berhasil, Tunggu Hingga Redirect',
                            position: 'topRight',
                        });
                        location.replace("/");
                    }
                },
                error: function(jqXhr, json, errorThrown) { // this are default for ajax errors 
                    var errors = jqXhr.responseJSON;
                    var errorsHtml = '';
                    $.each(errors['error'], function(index, value) {
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