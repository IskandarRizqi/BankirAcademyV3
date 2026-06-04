@include('front.layout.head')
@include('front.layout.topbar')
@include(env('CUSTOM_HEADER', 'front.layout.headerv3'))
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

    @media (max-width:768px) {
        #content .row.clearfix {
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
        }

        #content .col-md-3,
        #content .col-md-9 {
            margin-left: 10px !important;
            width: 100% !important;
            display: flex !important;
            justify-content: center !important;
            text-align: center !important;
        }

        #content .col-md-9 {
            margin-top: 15px !important;
            /* jarak antara gambar & nama */
        }

        #content #imagebunder {
            width: 100px !important;
            /* diperkecil */
            height: 100px !important;
            /* diperkecil */
        }
    }
</style>
<section id="content" style="background-color:#005CFF; height:220px; display:flex; align-items:center;">
    <div class="content-wrap w-100" style="display:flex; align-items:center;">
        <div class="container clearfix" style="display:flex; align-items:center;">
            <div class="row clearfix" style="display:flex; align-items:center; width:100%;">
                <div class="col-md-3 text-center" style="display:flex; justify-content:center;">
                    <img id="imagebunder"
                        src="{{$pfl?$pfl->picture:'/GambarV2/rectangle31.png'}}"
                        alt="..."
                        class="rounded-circle"
                        height="150px" width="150px"
                        style="object-fit:cover;">
                </div>
                <div class="col-md-9 text-white" style="display:flex; align-items:center; margin-left:-40px;">
                    <br>
                    <h5 class="text-white" id="updatename" style="margin:0; font-size:25px;">{{$pfl?$pfl->name:''}}</h5>
                    {{-- <button class="text-white" data-toggle="modal" data-target="#modaleditprofile"
                       style="background-color: transparent; border: 0px;"><svg xmlns="http://www.w3.org/2000/svg"
                           width="24" height="24" viewBox="0 0 24 24"
                           style="fill: rgb(255, 255, 255);transform: ;msFilter:;">
                           <path
                               d="M19.045 7.401c.378-.378.586-.88.586-1.414s-.208-1.036-.586-1.414l-1.586-1.586c-.378-.378-.88-.586-1.414-.586s-1.036.208-1.413.585L4 13.585V18h4.413L19.045 7.401zm-3-3 1.587 1.585-1.59 1.584-1.586-1.585 1.589-1.584zM6 16v-1.585l7.04-7.018 1.586 1.586L7.587 16H6zm-2 4h16v2H4z">
                           </path>
                       </svg> Edit Profile</button> --}}
                </div>
            </div>
        </div>
    </div>
</section>
<!-- @if(session('success_payment'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> {{ session('success_payment') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif -->


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
<div class="container" style="margin-top: 10px;">
    <div class="tabs tabs-bb clearfix ui-tabs ui-corner-all ui-widget ui-widget-content" id="tab-9">
        <ul class="tab-nav clearfix ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header"
            role="tablist" style="flex-wrap: nowrap; overflow-x: auto; width: 100%; overflow-y: hidden; margin-bottom: 20px;">
            <li role="tab" id="li-tabs-32" tabindex="-1"
                class="ui-tabs-tab ui-corner-top ui-state-default ui-state-active ui-tab"
                aria-controls="tabs-32" aria-labelledby="ui-id-16"
                aria-selected="true" aria-expanded="true">
                <a href="#tabs-32" role="presentation" tabindex="-1"
                    class="ui-tabs-anchor" id="ui-id-16"
                    style="color:#007bff; display:inline-flex; gap: 6px; align-items:center;">
                    <!-- <img src="https://img.icons8.com/?size=100&id=25167&format=png&color=000000"
                        style="max-height:17px; margin-right:5px; vertical-align:middle;"> -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-event" viewBox="0 0 16 16">
                        <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z" />
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z" />
                        <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5z" />
                    </svg>
                    Event
                </a>
            </li>

            <li role="tab" id="li-tabs-33" tabindex="-1"
                class="ui-tabs-tab ui-corner-top ui-state-default ui-tab"
                aria-controls="tabs-33" aria-labelledby="ui-id-17"
                aria-selected="true" aria-expanded="true">
                <a href="#tabs-33" role="presentation" tabindex="-1"
                    class="ui-tabs-anchor" id="ui-id-17"
                    style="color:#007bff; margin-left:5px; gap:6px; display:inline-flex; align-items:center;">
                    <!-- <img src="https://img.icons8.com/?size=100&id=jeWB7CBGFP4p&format=png&color=000000"
                        style="max-height:20px; margin-right:5px; vertical-align:middle;"> -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-cash-stack" viewBox="0 0 16 16">
                        <path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4" />
                        <path d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2z" />
                    </svg>
                    Billing Kelas
                </a>
            </li>

            <li id="li-tabs-34" role="tab" tabindex="-1"
                class="ui-tabs-tab ui-corner-top ui-state-default ui-tab"
                aria-controls="tabs-34" aria-labelledby="ui-id-18"
                aria-selected="false" aria-expanded="false">
                <a href="#tabs-34" role="presentation" tabindex="-1"
                    class="ui-tabs-anchor" id="ui-id-18"
                    style="color:#007bff; margin-left:5px; gap:6px; display:inline-flex; align-items:center;">
                    <!-- <img src="https://img.icons8.com/?size=100&id=3651&format=png&color=000000"
                        style="max-height:20px; margin-right:5px; vertical-align:middle;"> -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-person-video3" viewBox="0 0 16 16">
                        <path d="M14 9.5a2 2 0 1 1-4 0 2 2 0 0 1 4 0m-6 5.7c0 .8.8.8.8.8h6.4s.8 0 .8-.8-.8-3.2-4-3.2-4 2.4-4 3.2" />
                        <path d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h5.243c.122-.326.295-.668.526-1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v7.81c.353.23.656.496.91.783Q16 12.312 16 12V4a2 2 0 0 0-2-2z" />
                    </svg>
                    Kelas Anda
                </a>
            </li>

            <li id="li-tabs-35" role="tab" tabindex="0"
                class="ui-tabs-tab ui-corner-top ui-state-default ui-tab"
                aria-controls="tabs-35" aria-labelledby="ui-id-19"
                aria-selected="false" aria-expanded="false">
                <a href="#tabs-35" role="presentation" tabindex="-1"
                    class="ui-tabs-anchor" id="ui-id-19"
                    style="color:#007bff; margin-left:5px;gap: 6px; display:inline-flex; align-items:center;">
                    <!-- <img src="https://img.icons8.com/?size=100&id=5dSgwauapeOo&format=png&color=000000"
                        style="max-height:20px; margin-right:5px; vertical-align:middle;"> -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-wallet2" viewBox="0 0 16 16">
                        <path d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5z" />
                    </svg>
                    Dompet
                </a>
            </li>

            <li id="li-tabs-36" class="hidden-phone ui-tabs-tab ui-corner-top ui-state-default ui-tab" role="tab"
                tabindex="-1" aria-controls="tabs-36" aria-labelledby="ui-id-20" aria-selected="false"
                aria-expanded="false">
                <a href="#tabs-36" role="presentation" tabindex="-1" class="ui-tabs-anchor"
                    id="ui-id-20"
                    style="color:#007bff; margin-left:5px; display:inline-flex; gap: 6px; align-items:center;">
                    <!-- <img src="https://img.icons8.com/?size=100&id=47269&format=png&color=000000"
                        style="max-height:20px; margin-right:5px; vertical-align:middle;"> -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-person-badge" viewBox="0 0 16 16">
                        <path d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                        <path d="M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5v10.795a4.2 4.2 0 0 0-.776-.492C11.392 12.387 10.063 12 8 12s-3.392.387-4.224.803a4.2 4.2 0 0 0-.776.492z" />
                    </svg>
                    Membership
                </a>
            </li>

            <!-- @if(!$isperusahaan)
            <li id="li-tabs-37" class="hidden-phone ui-tabs-tab ui-corner-top ui-state-default ui-tab" role="tab"
                tabindex="-1" aria-controls="tabs-37" aria-labelledby="ui-id-21" aria-selected="false"
                aria-expanded="false">
                <a href="#tabs-37" role="presentation" tabindex="-1" class="ui-tabs-anchor"
                    id="ui-id-21"
                    style="color:#007bff; margin-left:5px; display:inline-flex; align-items:center;">
                    <img src="https://img.icons8.com/?size=100&id=46171&format=png&color=000000"
                        style="max-height:20px; margin-right:5px; vertical-align:middle;">
                    Buat CV
                </a>
            </li>

            @endif
            <li id="li-tabs-38" class="hidden-phone ui-tabs-tab ui-corner-top ui-state-default ui-tab" role="tab"
                tabindex="-1" aria-controls="tabs-38" aria-labelledby="ui-id-22" aria-selected="false"
                aria-expanded="false">
                <a href="#tabs-38" role="presentation" tabindex="-1" class="ui-tabs-anchor"
                    id="ui-id-22" onclick="triggerresize()"
                    style="color:#007bff; margin-left:5px; display:inline-flex; align-items:center;">
                    <img src="https://img.icons8.com/?size=100&id=20318&format=png&color=000000"
                        style="max-height:20px; margin-right:5px; vertical-align:middle;">
                    Lowongan Kerja
                </a>
            </li> -->

            <li id="li-tabs-39" class="hidden-phone ui-tabs-tab ui-corner-top ui-state-default ui-tab" role="tab"
                tabindex="-1" aria-controls="tabs-39" aria-labelledby="ui-id-23" aria-selected="false"
                aria-expanded="false">
                <a href="#tabs-39" role="presentation" tabindex="-1" class="ui-tabs-anchor"
                    id="ui-id-23"
                    style="color:#007bff; margin-left:5px; display:inline-flex; gap:6px; align-items:center;">
                    <!-- <img src="https://img.icons8.com/?size=100&id=364&format=png&color=000000"
                        style="max-height:20px; margin-right:5px; vertical-align:middle;"> -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-sliders" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M11.5 2a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M9.05 3a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0V3zM4.5 7a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M2.05 8a2.5 2.5 0 0 1 4.9 0H16v1H6.95a2.5 2.5 0 0 1-4.9 0H0V8zm9.45 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m-2.45 1a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0v-1z" />
                    </svg>
                    Setting
                </a>
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
            <div class="tab-content clearfix ui-tabs-panel ui-corner-bottom ui-widget-content" id="tabs-32"
                aria-labelledby="ui-id-16" role="tabpanel" aria-hidden="true" style="display: block;">
                @include('front.profilev2.event')
            </div>
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
                @include('front.profilev2.newmembership')
            </div>
            <div class="tab-content clearfix ui-tabs-panel ui-corner-bottom ui-widget-content" id="tabs-37"
                aria-labelledby="ui-id-21" role="tabpanel" aria-hidden="true" style="display: none;">
                @include('front.profilev2.cv')
            </div>
            <div class="tab-content clearfix ui-tabs-panel ui-corner-bottom ui-widget-content" id="tabs-38"
                aria-labelledby="ui-id-22" role="tabpanel" aria-hidden="true" style="display: none;">
                @if(!$isperusahaan)
                @include('front.profilev2.lowongankerja')
                @else
                @include('front.profilev2.lowongankerjaperusahaan')
                @endif
            </div>
            <div class="tab-content clearfix ui-tabs-panel ui-corner-bottom ui-widget-content" id="tabs-39"
                aria-labelledby="ui-id-23" role="tabpanel" aria-hidden="true" style="display: none;">
                @include('front.profilev2.setting')
            </div>

        </div>

    </div>
</div>
<div class="modal fade" id="modalCorporate" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="reviewFormModalLabel" aria-hidden="true" style="background-color: #000000cc">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" id="kembaliBeranda">
                <span>
                    <a href="/" type="button" class="btn btn-secondary btn-sm">x</a>
                </span>
            </div>
            <div class="modal-body">
                <div id="pilihGambar" class="row">
                    <div class="col">
                        <img src="/a_peorangan.jpg" alt="" id="peroranganPilih">
                        <p class="text-center">( Pelajar, Mahasiswa, Pencari Kerja )</p>
                    </div>
                    <div class="col">
                        <img src="/a_perusahaan.jpg" alt="" id="corporatePilih">
                        <p class="text-center">( Perusahaan )</p>
                    </div>
                </div>
                <div id="formPerorangan" hidden>
                    <h4>Calon Bankir</h4>
                    <button class="btn btn-secondary btn-sm" id="kembali" title="kembali">
                        < Kembali </button>
                            <form action="{{ route('profile.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="text" name="iscorporate" hidden>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <label for="form-control">Nama lengkap</label>
                                        <input type="text" class="form-control" name="nama_lengkap"
                                            value="{{ isset($pfl['name'])?$pfl['name']:'' }}">
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                        @if ($errors->has('nama_lengkap'))
                                        <div class="error" style="color: red; display:block;">
                                            {{ $errors->first('nama_lengkap') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="form-control">Nomor
                                            handphone</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">+62</span>
                                            </div>
                                            <input type="text" class="form-control" name="nomor_handphone"
                                                value="{{ isset($pfl['phone'])?$pfl['phone']:'' }}">
                                        </div>
                                        @if ($errors->has('nomor_handphone'))
                                        <div class="error" style="color: red; display:block;">
                                            {{ $errors->first('nomor_handphone') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-lg-4" hidden>
                                        <label for="form-control">Company</label>
                                        <input type="text" class="form-control" name="company" {{--
                                            value="{{ isset($pfl['instansi'])?$pfl['instansi']:'' }}" --}}
                                            value="perorangan">
                                        <small class="text-danger">Jika mempunyai wajib
                                            di
                                            isi</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label for="form-control">Tanggal
                                                    lahir</label>
                                                <input type="date" name="tanggal_lahir" class="form-control"
                                                    value="{{ isset($pfl['tanggal_lahir'])?$pfl['tanggal_lahir']:'' }}">
                                                @if ($errors->has('tanggal_lahir'))
                                                <div class="error" style="color: red; display:block;">
                                                    {{ $errors->first('tanggal_lahir') }}
                                                </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6" hidden>
                                                <label for="">No.
                                                    Rekening</label>
                                                <input type="text" name="rekening" id="rekening" class="form-control"
                                                    value="1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label for="form-control">Jenis
                                                    Kelamin</label>
                                                <select name="jenis_kelamin" class="form-control" id="jkl">
                                                    <option value="">Pilih salah
                                                        satu
                                                    </option>
                                                    <option value="0" {{ isset($pfl['gender'])&&$pfl['gender']==0
                                                        ? 'selected' : null }}>
                                                        Perempuan</option>
                                                    <option value="1" {{ isset($pfl['gender'])&&$pfl['gender']==1
                                                        ? 'selected' : null }}>
                                                        Laki-laki</option>
                                                </select>
                                                @if ($errors->has('jenis_kelamin'))
                                                <div class="error" style="color: red; display:block;">
                                                    {{ $errors->first('jenis_kelamin') }}
                                                </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="form-control">Referral
                                                    (optional)</label>
                                                <input type="text" id="referral" name="referral" class="form-control"
                                                    onchange="referralKode('{{ isset($pfl['user_id'])?$pfl['user_id']:'' }}',$(this).val())"
                                                    value="@if (isset($pfl['user_id'])){{ $pfl['referral'] ? $pfl['referral']['code'] : '' }}@endif"
                                                    @if (isset($pfl['user_id'])){{ $pfl['referral'] ? 'readonly' : ''
                                                    }}@endif>
                                                @if (Session::has('referral'))
                                                <div class="error" style="color: red; display:block;">
                                                    {{ Session::get('referral') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-9">
                                        <label for="form-control">Alamat</label>
                                        <textarea class="form-control"
                                            name="alamat">{{ isset($pfl['description'])?$pfl['description']:'' }}</textarea>
                                        @if ($errors->has('alamat'))
                                        <div class="error" style="color: red; display:block;">
                                            {{ $errors->first('alamat') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="form-control">Foto</label>
                                        <input type="file" class="form-control" name="picture" id="picture2">
                                        <img id="pictureprv2" src="{{ isset($pfl['picture'])?$pfl['picture']:'' }}"
                                            alt="" width="80px">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button class="button button-small" type="submit">Simpan</button>
                                    </div>
                                </div>
                            </form>
                </div>
                <div id="formCorporate" hidden>
                    <h4>Bankir</h4>
                    <button class="btn btn-secondary btn-sm" id="kembali2" title="kembali2">
                        < Kembali </button>
                            <form action="{{ route('profile.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="text" name="iscorporate" value="ada" hidden>
                                {{-- Tabel di User --}}
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="form-control">Jenis Corporate</label>
                                        <select name="jenis_corporate" class="form-control jc" id="jenis_corporates"
                                            data-show-subtext="true" data-live-search="true" required>
                                            <option value="">Pilih</option>
                                            <option value="bankumum">Bank Umum</option>
                                            <option value="bpr">BPR</option>
                                            <option value="bprs">BPRS</option>
                                            <option value="koperasi">Koperasi</option>
                                            <option value="lkm">Lembaga Keuangan Mikro</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="col-md-9 select-custom">
                                        <label for="form-control nama_lengkaps">Nama Corporate</label>
                                        <select name="nama_lengkap" autocomplete="off" id="nama_lengkaps"
                                            class="form-control" required>
                                            <option value="">Pilih</option>
                                        </select>
                                        {{-- <label for="form-control">Nama Perusahaan</label>
                                        <input type="text" class="form-control" name="nama_lengkap"
                                            value="{{ isset($pfl['name'])?$pfl['name']:'' }}">
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}"> --}}
                                        @if ($errors->has('nama_lengkap'))
                                        <div class="error" style="color: red; display:block;">
                                            {{ $errors->first('nama_lengkap') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col-lg-12" hidden>
                                                <label for="form-control">Tanggal
                                                    lahir</label>
                                                <input type="date" name="tanggal_lahir" class="form-control"
                                                    value="{{ isset($pfl['tanggal_lahir'])?$pfl['tanggal_lahir']:'' }}">
                                                @if ($errors->has('tanggal_lahir'))
                                                <div class="error" style="color: red; display:block;">
                                                    {{ $errors->first('tanggal_lahir') }}
                                                </div>
                                                @endif
                                            </div>
                                            <div class="col" hidden>
                                                <label for="">No.
                                                    Rekening</label>
                                                <input type="text" name="rekening" id="rekening" class="form-control"
                                                    value="1">
                                            </div>
                                            <div class="col-lg-12">
                                                <label for="">Email</label>
                                                <input type="text" name="email" id="email" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                <label for="form-control">Nomor Telepon</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">+62</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="nomor_handphone"
                                                        value="{{ isset($pfl['phone'])?$pfl['phone']:'' }}">
                                                </div>
                                                @if ($errors->has('nomor_handphone'))
                                                <div class="error" style="color: red; display:block;">
                                                    {{ $errors->first('nomor_handphone') }}
                                                </div>
                                                @endif
                                            </div>
                                            <div class="col" hidden>
                                                <label for="form-control">Jenis
                                                    Kelamin</label>
                                                <select name="jenis_kelamin" class="form-control" id="jkl">
                                                    <option value="">Pilih salah
                                                        satu
                                                    </option>
                                                    <option value="0" {{ isset($pfl['gender'])&&$pfl['gender']==0
                                                        ? 'selected' : null }}>
                                                        Perempuan</option>
                                                    <option value="1" {{ isset($pfl['gender'])&&$pfl['gender']==1
                                                        ? 'selected' : null }}>
                                                        Laki-laki</option>
                                                </select>
                                                @if ($errors->has('jenis_kelamin'))
                                                <div class="error" style="color: red; display:block;">
                                                    {{ $errors->first('jenis_kelamin') }}
                                                </div>
                                                @endif
                                            </div>
                                            <div class="col">
                                                <label for="form-control">Referral
                                                    (optional)</label>
                                                <input type="text" id="referral" name="referral" class="form-control"
                                                    onchange="referralKode('{{ isset($pfl['user_id'])?$pfl['user_id']:'' }}',$(this).val())"
                                                    value="@if (isset($pfl['user_id'])){{ $pfl['referral'] ? $pfl['referral']['code'] : '' }}@endif"
                                                    @if (isset($pfl['user_id'])){{ $pfl['referral'] ? 'readonly' : ''
                                                    }}@endif>
                                                @if (Session::has('referral'))
                                                <div class="error" style="color: red; display:block;">
                                                    {{ Session::get('referral') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-9">
                                        <label for="form-control">Alamat</label>
                                        <textarea class="form-control"
                                            name="alamat">{{ isset($pfl['description'])?$pfl['description']:'' }}</textarea>
                                        @if ($errors->has('alamat'))
                                        <div class="error" style="color: red; display:block;">
                                            {{ $errors->first('alamat') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="form-control">Logo</label>
                                        <input type="file" class="form-control" name="picture" id="picture3">
                                        <img id="pictureprv3" src="{{ isset($pfl['picture'])?$pfl['picture']:'' }}"
                                            alt="" width="80px">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button class="button button-small" type="submit">Simpan</button>
                                    </div>
                                </div>
                            </form>
                </div>
            </div>
        </div>
    </div>
</div>
<textarea id="corporateUser" cols="30" rows="10" hidden>
{{$user->corporate}}
</textarea>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(Session::has('success_payment'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // 1. Jalankan SweetAlert (Swal) untuk pesan sukses
        // Swal.fire({
        //     title: 'Pembayaran Berhasil!',
        //     text: "{{ Session::get('success_payment') }}",
        //     icon: 'success',
        //     confirmButtonColor: '#007bff',
        //     confirmButtonText: 'Mantap'
        // });
        alert("{{ Session::get('success_payment') }}")

        // 2. Pindahkan tab aktif ke "Kelas Anda" (#tabs-34)
        // Karena menggunakan jQuery UI Tabs, kita cari link yang mengarah ke #tabs-34 lalu picu event click
        setTimeout(function() {
            var tabKelasAnda = jQuery('a[href="#tabs-34"]');
            if (tabKelasAnda.length > 0) {
                tabKelasAnda.trigger('click');

                // Opsional: Jika jQuery UI tabs di web Anda di-inisialisasi manual, 
                // Anda juga bisa mengaktifkannya lewat index tab-nya (Tab ke-3 artinya index 2 jika dihitung dari 0)
                // jQuery("#tab-9").tabs("option", "active", 2); 
            }
        }, 100); // Diberi delay 100ms agar DOM jQuery UI Tabs selesai melakukan inisialisasi awal
    });
</script>
@endif
<script>
    // localStorage.clear();
    // localStorage.setItem("menu", "li-tabs-32");
    // clearmenu();
    // activemenu();
    $(document).ready(function() {
        loadbillingkelas('semua-billing')
        getkelasanda('semua-ka-billing')
        let ls = localStorage.getItem("menu");
        $('#li-tabs-32').click(function() {
            localStorage.setItem("menu", "li-tabs-32");
            clearmenu();
            activemenu();
        })
        $('#li-tabs-33').click(function() {
            localStorage.setItem("menu", "li-tabs-33");
            clearmenu();
            activemenu();
        })
        $('#li-tabs-34').click(function() {
            localStorage.setItem("menu", "li-tabs-34");
            clearmenu();
            activemenu();
        })
        $('#li-tabs-35').click(function() {
            localStorage.setItem("menu", "li-tabs-35");
            clearmenu();
            activemenu();
        })
        $('#li-tabs-36').click(function() {
            localStorage.setItem("menu", "li-tabs-36");
            clearmenu();
            activemenu();
        })
        $('#li-tabs-37').click(function() {
            localStorage.setItem("menu", "li-tabs-37");
            clearmenu();
            activemenu();
        })
        $('#li-tabs-38').click(function() {
            localStorage.setItem("menu", "li-tabs-38");
            clearmenu();
            activemenu();
        })
        $('#li-tabs-39').click(function() {
            localStorage.setItem("menu", "li-tabs-39");
            clearmenu();
            activemenu();
        })

        // Set menu auto
        setTimeout(() => {
            clearmenu();
            activemenu();


        }, 1500);

        $('#kembali').click(function() {
            $('#pilihGambar').removeAttr('hidden');
            $('#formCorporate').attr('hidden', true);
            $('#formPerorangan').attr('hidden', true);
        })
        $('#kembali2').click(function() {
            $('#pilihGambar').removeAttr('hidden');
            $('#formCorporate').attr('hidden', true);
            $('#formPerorangan').attr('hidden', true);
        })
        $('#peroranganPilih').click(function() {
            $('#pilihGambar').attr('hidden', true);
            $('#formCorporate').attr('hidden', true);
            $('#formPerorangan').removeAttr('hidden');
        })
        $('#corporatePilih').click(function() {
            $('#pilihGambar').attr('hidden', true);
            $('#formCorporate').removeAttr('hidden', true);
            $('#formPerorangan').attr('hidden');
        })
        let corporate = $('#corporateUser').val();
        if (corporate) {
            if (corporate.replace(/[^a-zA-Z0-9]/g, '') !== 'perorangan') {
                try {
                    let js = JSON.parse(corporate)
                } catch (error) {
                    $('#modalCorporate').modal('show');
                }
            }
        } else {
            try {
                let js = JSON.parse(corporate)
            } catch (error) {
                $('#modalCorporate').modal('show');
            }
        }
        $('#jenis_corporates').on('change', function() {
            let val = $('#jenis_corporates').val();
            $('#nama_lengkaps').remove();
            $('.nama_lengkaps').remove();
            let z = '';
            z += '<label for="form-control nama_lengkaps">Nama Corporate</label>';
            z += '<select name="nama_lengkap" autocomplete="off" id="nama_lengkaps" class="form-control" required>';
            z += '<option value="">Pilih</option>';
            z += '</select>';
            $('.select-custom').html(z)
            $('#nama_lengkaps').removeAttr('class');
            $('#corporate').val(null);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "/admin/corporates/" + val,
                method: 'get',
                success: function(result) {
                    new TomSelect("#nama_lengkaps", {
                        valueField: 'nama',
                        searchField: 'nama',
                        persist: false,
                        createOnBlur: true,
                        create: true,
                        // options: [
                        // 	{id: 1, title: 'DIY', url: 'https://diy.org'},
                        // 	{id: 2, title: 'Google', url: 'http://google.com'},
                        // 	{id: 3, title: 'Yahoo', url: 'http://yahoo.com'},
                        // ],
                        options: result,
                        render: {
                            option: function(data, escape) {
                                return '<div>' +
                                    '<span class="title">' + escape(data.nama) + '</span>' +
                                    '</div>';
                            },
                            item: function(data, escape) {
                                return '<div title="' + escape(data.id) + '" value="' + escape(data.id) + '">' + escape(data.nama) + '</div>';
                            }
                        }
                    });
                    // console.log(result);
                    // let h = '';
                    // result.forEach(element => {
                    //     h+='<option value="'+element.id+'">'+element.nama+'</option>';
                    // });
                    // $('#nama_lengkaps').html(h);
                },
                error: function(jqXhr, json, errorThrown) { // this are default for ajax errors 
                    var errors = jqXhr.responseJSON;
                    console.log(errors);

                }
            })
        })
    })
    $('.trigger-swal').on('click', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // loader transparant
        Swal.fire({
            background: '#0069d900',
            didOpen: () => {
                Swal.showLoading();
            }
        })
        $.ajax({
            url: '/updateprofile',
            method: 'POST',
            data: {
                name: $('#editprofilenama').val(),
                description: $('#editprofiledeskripsi').val(),
            },
            success: function(response) {
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


    function clearmenu() {
        $('#li-tabs-32').removeClass('ui-state-active ui-tabs-active');
        $('#li-tabs-32').attr('aria-selected', true);
        $('#li-tabs-32').attr('aria-expanded', true);
        $('#tabs-32').attr('aria-hidden', true);
        $('#tabs-32').css('display', 'none');

        $('#li-tabs-33').removeClass('ui-state-active ui-tabs-active');
        $('#li-tabs-33').attr('aria-selected', true);
        $('#li-tabs-33').attr('aria-expanded', true);
        $('#tabs-33').attr('aria-hidden', true);
        $('#tabs-33').css('display', 'none');

        $('#li-tabs-34').removeClass('ui-state-active ui-tabs-active');
        $('#li-tabs-34').attr('aria-selected', true);
        $('#li-tabs-34').attr('aria-expanded', true);
        $('#tabs-34').attr('aria-hidden', true);
        $('#tabs-34').css('display', 'none');

        $('#li-tabs-35').removeClass('ui-state-active ui-tabs-active');
        $('#li-tabs-35').attr('aria-selected', true);
        $('#li-tabs-35').attr('aria-expanded', true);
        $('#tabs-35').attr('aria-hidden', true);
        $('#tabs-35').css('display', 'none');

        $('#li-tabs-36').removeClass('ui-state-active ui-tabs-active');
        $('#li-tabs-36').attr('aria-selected', true);
        $('#li-tabs-36').attr('aria-expanded', true);
        $('#tabs-36').attr('aria-hidden', true);
        $('#tabs-36').css('display', 'none');

        $('#li-tabs-37').removeClass('ui-state-active ui-tabs-active');
        $('#li-tabs-37').attr('aria-selected', true);
        $('#li-tabs-37').attr('aria-expanded', true);
        $('#tabs-37').attr('aria-hidden', true);
        $('#tabs-37').css('display', 'none');

        $('#li-tabs-38').removeClass('ui-state-active ui-tabs-active');
        $('#li-tabs-38').attr('aria-selected', true);
        $('#li-tabs-38').attr('aria-expanded', true);
        $('#tabs-38').attr('aria-hidden', true);
        $('#tabs-38').css('display', 'none');

        $('#li-tabs-39').removeClass('ui-state-active ui-tabs-active');
        $('#li-tabs-39').attr('aria-selected', true);
        $('#li-tabs-39').attr('aria-expanded', true);
        $('#tabs-39').attr('aria-hidden', true);
        $('#tabs-39').css('display', 'none');
    }

    function activemenu() {
        let ls = localStorage.getItem("menu");
        if (ls) {
            $('#li-tabs-32').removeClass('ui-state-active ui-tabs-active');
            $('#li-tabs-32').removeAttr('aria-selected', true);
            $('#li-tabs-32').removeAttr('aria-expanded', true);

            $('#li-tabs-33').removeClass('ui-state-active ui-tabs-active');
            $('#li-tabs-33').removeAttr('aria-selected', true);
            $('#li-tabs-33').removeAttr('aria-expanded', true);

            let a = $('#' + ls);
            let s = ls.split('-');
            a.addClass('ui-state-active ui-tabs-active');
            a.attr('aria-selected', true);
            a.attr('aria-expanded', true);
            $('#tabs-' + s[2]).attr('aria-hidden', false);
            $('#tabs-' + s[2]).css('display', 'block');
        }
    }
</script>

@include(env('CUSTOM_FOOTER', 'front.layout.footer'))