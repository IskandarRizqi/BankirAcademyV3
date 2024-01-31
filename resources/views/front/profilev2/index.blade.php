@include('front.layout.head')
@include('front.layout.topbar')
@include(env('CUSTOM_HEADER', 'front.layout.header'))
<style>
    .loader {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -50px;
        margin-left: -50px;
        border: 16px solid #f3f3f3;
        /* Light grey */
        border-top: 16px solid #3498db;
        /* Blue */
        border-radius: 50%;
        width: 80px;
        height: 80px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .hide-loader {
        display: none;
    }

    .tabs-bb .tab-nav li.ui-tabs-active a {
        border-bottom: 5px solid #1d1abc;
    }

    .tab-nav li a {
        color: #0011ff;
    }

    .progress {
        height: 10px;
        border-radius: 10px;
    }

    .progress-bar {
        background-color: #00D789;
    }
</style>
<section id="content" style="background-color: #005CFF">
    <div class="content-wrap">
        <div class="container clearfix">
            <div class="row clearfix">
                <div class="col-md-3 text-center">
                    <img id="imagebunder" src="{{$pfl?$pfl->picture:'/GambarV2/rectangle31.png'}}" alt="..."
                        class="rounded-circle" height="150px" width=150px>
                </div>
                <div class="col-md-9 text-white">
                    <h5 class="text-white" id="updatename">{{$pfl?$pfl->name:''}}</h5>
                    <p id="updatedescription">{{$pfl?$pfl->description:''}}</p>
                    <button class="text-white" data-toggle="modal" data-target="#modaleditprofile"
                        style="background-color: transparent; border: 0px;"><svg xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24"
                            style="fill: rgb(255, 255, 255);transform: ;msFilter:;">
                            <path
                                d="M19.045 7.401c.378-.378.586-.88.586-1.414s-.208-1.036-.586-1.414l-1.586-1.586c-.378-.378-.88-.586-1.414-.586s-1.036.208-1.413.585L4 13.585V18h4.413L19.045 7.401zm-3-3 1.587 1.585-1.59 1.584-1.586-1.585 1.589-1.584zM6 16v-1.585l7.04-7.018 1.586 1.586L7.587 16H6zm-2 4h16v2H4z">
                            </path>
                        </svg> Edit Profile</button>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal Edit Profile -->
<div class="modal fade" id="modaleditprofile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="exampleModalLabel">Edit Profile</h5>
                <span class="btn-close" data-dismiss="modal" aria-label="Close">x</span>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Nama</label>
                    <input type="text" name="editprofilenama" id="editprofilenama" class="form-control"
                        value="{{$pfl?$pfl->name:''}}">
                </div>
                <div class="form-group">
                    <label for="">Deskripsi</label>
                    <textarea name="editprofiledeskripsi" id="editprofiledeskripsi"
                        class="form-control">{{$pfl?$pfl->description:''}}</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary trigger-swal">Simpan</button>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="tabs tabs-bb clearfix ui-tabs ui-corner-all ui-widget ui-widget-content" id="tab-9">
        <ul class="tab-nav clearfix ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header"
            role="tablist" style="flex-wrap: nowrap; overflow-x: auto; width: 100%; overflow-y: hidden;">
            <li role="tab" tabindex="-1"
                class="ui-tabs-tab ui-corner-top ui-state-default ui-tabs-active ui-state-active ui-tab"
                aria-controls="tabs-33" aria-labelledby="ui-id-17" aria-selected="true" aria-expanded="true"><a
                    href="#tabs-33" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-17">
                    Billing Kelas</a></li>
            <li role="tab" tabindex="-1" class="ui-tabs-tab ui-corner-top ui-state-default ui-tab"
                aria-controls="tabs-34" aria-labelledby="ui-id-18" aria-selected="false" aria-expanded="false"><a
                    href="#tabs-34" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-18">Kelas
                    Anda</a></li>
            <li role="tab" tabindex="0" class="ui-tabs-tab ui-corner-top ui-state-default ui-tab"
                aria-controls="tabs-35" aria-labelledby="ui-id-19" aria-selected="false" aria-expanded="false"><a
                    href="#tabs-35" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-19">Affiliate</a>
            </li>
            <li class="hidden-phone ui-tabs-tab ui-corner-top ui-state-default ui-tab" role="tab" tabindex="-1"
                aria-controls="tabs-36" aria-labelledby="ui-id-20" aria-selected="false" aria-expanded="false"><a
                    href="#tabs-36" role="presentation" tabindex="-1" class="ui-tabs-anchor"
                    id="ui-id-20">Membership</a></li>
            <li class="hidden-phone ui-tabs-tab ui-corner-top ui-state-default ui-tab" role="tab" tabindex="-1"
                aria-controls="tabs-37" aria-labelledby="ui-id-21" aria-selected="false" aria-expanded="false"><a
                    href="#tabs-37" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-21">Buat CV</a>
            </li>
            <li class="hidden-phone ui-tabs-tab ui-corner-top ui-state-default ui-tab" role="tab" tabindex="-1"
                aria-controls="tabs-38" aria-labelledby="ui-id-22" aria-selected="false" aria-expanded="false"><a
                    href="#tabs-38" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-22">Lowongan
                    Kerja</a>
            </li>
            <li class="hidden-phone ui-tabs-tab ui-corner-top ui-state-default ui-tab" role="tab" tabindex="-1"
                aria-controls="tabs-39" aria-labelledby="ui-id-23" aria-selected="false" aria-expanded="false"><a
                    href="#tabs-39" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-23">Setting</a>
            </li>
        </ul>

        @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show text-center m-0" role="alert">
            {{ Session::get('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        @endif

        <div class="tab-container">
            <div class="tab-content clearfix ui-tabs-panel ui-corner-bottom ui-widget-content" id="tabs-33"
                aria-labelledby="ui-id-17" role="tabpanel" aria-hidden="true" style="display: block;">
                @include('front.profilev2.billingkelas')
            </div>
            <div class="tab-content clearfix ui-tabs-panel ui-corner-bottom ui-widget-content" id="tabs-34"
                aria-labelledby="ui-id-18" role="tabpanel" aria-hidden="true" style="display: none;">
                @include('front.profilev2.kelasanda')
            </div>
            <div class="tab-content clearfix ui-tabs-panel ui-corner-bottom ui-widget-content" id="tabs-35"
                aria-labelledby="ui-id-19" role="tabpanel" aria-hidden="true" style="display: none;">
                @include('front.profilev2.affiliate')
            </div>
            <div class="tab-content clearfix ui-tabs-panel ui-corner-bottom ui-widget-content" id="tabs-36"
                aria-labelledby="ui-id-20" role="tabpanel" aria-hidden="true" style="display: none;">
                @include('front.profilev2.membership')
            </div>
            <div class="tab-content clearfix ui-tabs-panel ui-corner-bottom ui-widget-content" id="tabs-37"
                aria-labelledby="ui-id-21" role="tabpanel" aria-hidden="true" style="display: none;">
                @include('front.profilev2.cv')
            </div>
            <div class="tab-content clearfix ui-tabs-panel ui-corner-bottom ui-widget-content" id="tabs-38"
                aria-labelledby="ui-id-22" role="tabpanel" aria-hidden="true" style="display: none;">
                @include('front.profilev2.lowongankerja')
            </div>
            <div class="tab-content clearfix ui-tabs-panel ui-corner-bottom ui-widget-content" id="tabs-39"
                aria-labelledby="ui-id-23" role="tabpanel" aria-hidden="true" style="display: none;">
                @include('front.profilev2.setting')
            </div>

        </div>

    </div>
</div>
<script>
    $(document).ready(function () {
        loadbillingkelas('semua-billing')
        getkelasanda('semua-ka-billing')
    })
    $('.trigger-swal').on('click', function () {        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // loader transparant
        Swal.fire({
            background:'#0069d900',
            didOpen:()=>{
                Swal.showLoading();
            }
        })
        $.ajax({
            url: '/updateprofile',
            method: 'POST',
            data: {
                name:$('#editprofilenama').val(),
                description:$('#editprofiledeskripsi').val(),
            },
            success:function(response)
            {
                if (response.status == 1) {
                    $('#editprofilenama').val(response.data.name),
                    $('#editprofiledeskripsi').val(response.data.description),

                    $('#profile_nama').val(response.data.name),
                    $('#profile_alamat').val(response.data.description),

                    $('#updatename').html(response.data.name),
                    $('#updatedescription').html(response.data.description),
                    iziToast.success({
                        title: 'Berhasil',
                        message: 'Input Berhasil',
                        position: 'topRight',
                    });
                    Swal.close()
                    $('#modaleditprofile').modal('hide')
                }
            },
            error: function(response) {
                console.log(response);
                iziToast.warning({
                    title: 'Gagal',
                    message: 'Input Gagal',
                    position: 'topRight',
                });
                Swal.close()
            }
        });
})
</script>
@include(env('CUSTOM_FOOTER', 'front.layout.footer'))