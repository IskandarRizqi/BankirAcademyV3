@include("front.layout.head")
<section id="content">
    <div class="content-wrap py-0">

        <div class="section dark p-0 m-0 h-100 position-absolute"
            style="background-image: url('{{asset('bg-example.jpg')}}')"></div>

        <div class="section bg-transparent min-vh-100 p-0 m-0 d-flex">
            <div class="vertical-middle">
                <div class="container py-5">
                    <form action="/inputinstructor" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card mx-auto rounded-0 border-0" style="max-width: 800px;">
                            <div class="card-body" style="padding: 40px;">
                                <h3>Register Instructor</h3>
                                {{-- <a href="/" class="btn btn-secondary btn-rounded"
                                    style="border-radius:10px !important">Batal</a> --}}
                                {{-- <div class="row">
                                    <div class="col-6 form-group">
                                        <label class="font-body text-capitalize"
                                            for="login-form-modal-username">Nama</label>
                                        <input type="text" id="nama" name="nama" class="form-control"
                                            value="{{old('nama')}}" />
                                        @error('nama')
                                        <small class="text-danger">Harus Diisi</small>
                                        @enderror
                                    </div>
                                    <div class="col-6 form-group">
                                        <label class="font-body text-capitalize"
                                            for="login-form-modal-username">EMAIL</label>
                                        <input type="email" id="email" name="email" class="form-control"
                                            value="{{old('email')}}" />
                                        @error('email')
                                        <small class="text-danger">Harus Diisi</small>
                                        @enderror
                                    </div>
                                    <div class="col-6 form-group">
                                        <label class="font-body text-capitalize" for="login-form-modal-username">No.
                                            HP</label>
                                        <input type="number" id="nohp" name="nohp" class="form-control"
                                            value="{{old('nohp')}}" />
                                        <small>628123456789</small>
                                        @error('nohp')
                                        <small class="text-danger">Harus Diisi</small>
                                        @enderror
                                    </div>
                                    <div class="col-6 form-group">
                                        <label class="font-body text-capitalize"
                                            for="login-form-modal-username">Alamat</label>
                                        <textarea type="text" id="alamat" name="alamat"
                                            class="form-control">{{old('alamat')}}</textarea>
                                        @error('alamat')
                                        <small class="text-danger">Harus Diisi</small>
                                        @enderror
                                    </div>
                                    <div class="col-6 form-group">
                                        <label class="font-body text-capitalize"
                                            for="login-form-modal-username">Deskripsi</label>
                                        <textarea type="text" id="deskripsi" name="deskripsi"
                                            class="form-control"> {{old('deskripsi')}}</textarea>
                                        @error('deskripsi')
                                        <small class="text-danger">Harus Diisi</small>
                                        @enderror
                                    </div>
                                    <div class="col-6 form-group">
                                        <label class="font-body text-capitalize" for="login-form-modal-username">Upload
                                            Dokumen (zip)</label>
                                        <input type="file" id="dokumen" name="dokumen" class="form-control"
                                            accept=".zip,.rar,.7zip,.7z,.tar.gz" />
                                        @error('dokumen')
                                        <small class="text-danger">Harus Diisi</small>
                                        @enderror
                                        @if (Session::has('error'))
                                        <small class="text-danger">{{Session::get('error')}}</small>
                                        @endif
                                    </div>
                                    <div class="col-6 form-group">
                                        <label>Foto</label><br>
                                        <input id="input-3" name="foto" type="file" class="file"
                                            data-show-upload="false" data-show-caption="true" data-show-preview="true"
                                            accept="image/*">
                                        @error('foto')
                                        <small class="text-danger">Harus Diisi</small>
                                        @enderror
                                    </div>
                                </div> --}}

                                <div class="col-6 form-group">
                                    {{-- <button class="btn btn-success btn-rounded"
                                        style="border-radius:10px !important" type="submit">REGISTER</button> --}}
                                </div>
                    </form>
                    {{-- <div class="d-flex justify-content-center">
                        have an account? &nbsp;
                        <a href="{{url('/')}}"> Login</a>
                    </div>
                    <div class="line line-sm"></div> --}}
                    <a href="/" class="btn btn-secondary btn-rounded" style="border-radius:10px !important">Kembali</a>
                    <a href="{{url('/auth/google?ins=true')}}"
                        class="button button-rounded font-weight-normal center text-capitalize si-gplus si-colored m-0">Login
                        with Google</a>
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
<!-- Go To Top
 ============================================= -->
<div id="gotoTop" class="icon-angle-up"></div>


<!-- Footer Scripts
============================================= -->
<script src="{{ asset('front/js/functions.js') }}"></script>

<!-- SLIDER REVOLUTION 5.x SCRIPTS  -->
<script src="{{ asset('front/js/components/bs-filestyle.js') }}"></script>
<!-- JavaScripts
============================================= -->
{{-- <script src="https://code.jquery.com/jquery-3.6.1.js"
    integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<script src="{{asset('front/js/plugins.min.js')}}"></script> --}}

<!-- Footer Scripts
============================================= -->
{{-- <script src="{{asset('front/js/functions.js')}}"></script>
<script src="{{asset('front/toast/dist/js/iziToast.min.js')}}" type="text/javascript"></script> --}}
{{-- <script>
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
</script> --}}
</body>

</html>