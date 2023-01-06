@include('front.layout.head')
@include('front.layout.topbar')
@include(env('CUSTOM_HEADER', 'front.layout.header'))
@error('error')
{{ $message }}
@enderror
<style>
    /* .badge {
        display: inline-block;
        background-color: lighten(red, 20%);
        border-radius: 50%;
        color: #fff;
        padding: 0.5em 0.75em;
        position: relative;
    } */

    .pulsate::before {
        content: '';
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        animation: pulse 1s ease infinite;
        border-radius: 50%;
        border: 4px double lighten(red, 20%);
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        60% {
            transform: scale(1.3);
            opacity: 0.4;
        }

        100% {
            transform: scale(1.4);
            opacity: 0;
        }
    }
</style>
<section id="content">
    <div class="content-wrap" style="padding: 24px;">
        <div class="container clearfix">
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="heading-block border-0">
                        <h3>{{ Auth::user()->name }}</h3>
                        <span>Your Profile Bio</span>
                    </div>
                    <div class="clear"></div>
                    <div class="row clearfix">
                        <div class="col-lg-12">
                            <div class="tabs tabs-alt clearfix" id="tabs-profile">
                                <ul class="tab-nav clearfix">
                                    <li><a href="#tab-postss"><i class="icon-line-book-open"></i> Kelas Anda</a></li>
                                    <li><a href="#tab-pnpt"><i class="icon-line-book-open"></i> Pre & Pos Tes</a></li>
                                    <li><a href="#tab-absen"><i class="icon-fingerprint"></i> Absen</a></li>
                                    <li><a href="#tab-affiliate"><i class="icon-users1"></i> Affiliate</a></li>
                                    <li><a href="#tab-feeds"><i class="icon-credit-cards"></i> Billing Kelas
                                            <span class="badge bg-danger text-white">
                                                <div class="spinner-grow spinner-grow-sm">
                                                </div>
                                                {{ $count_payment }}
                                            </span>
                                        </a></li>
                                    <li><a href="#tab-posts"><i class="icon-cog"></i> Setting</a></li>
                                </ul>
                                <div class="tab-container">
                                    <div class="tab-content clearfix" id="tab-feeds">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <form action="/profile#tab-feeds" method="get">
                                                    <label>Tanggal Pembayaran</label>
                                                    <div class="input-group mb-4">
                                                        <input type="date" class="form-control"
                                                            value="{{ $param['date'][0] }}" placeholder="Date Start"
                                                            aria-label="Date Start" name="param_date_start">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon5">s/d</span>
                                                        </div>
                                                        <input type="date" class="form-control"
                                                            value="{{ $param['date'][1] }}" placeholder="Date End"
                                                            aria-label="Date End" name="param_date_end">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Status : </label>
                                                        <div class="form-check form-check-inline">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="param_checked_lunas[]" value="0" {{
                                                                    in_array(0, $param['status']) ? 'checked' : '' }}>
                                                                Belum Lunas
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="param_checked_lunas[]" value="1" {{
                                                                    in_array(1, $param['status']) ? 'checked' : '' }}>
                                                                Lunas
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-8">
                                                            <button class="btn btn-primary btn-block"
                                                                type="submit">Cari</button>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <a href="/profile#tab-feeds"
                                                                class="btn btn-warning btn-block"
                                                                type="button">Reset</a>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div>
                                                    <span onclick="invoiceAjax()"><button
                                                            class="btn btn-warning">Invoice</button></span>
                                                    <span class="btn btn-info" id="buktiMulti">Upload Bukti</span>
                                                    <p class="m-0">Pilih Checkbox Lalu Klik Button</p>
                                                </div>
                                            </div>
                                        </div>
                                        <form id="formmultiinvoice" action="/classes/multiinvoice" method="POST"
                                            location.reload(); target="_blank">
                                            @csrf
                                            <textarea name="dataInvoice" id="dataInvoice" cols="30" rows="10"
                                                hidden></textarea>
                                        </form>
                                        <div class="table-responsive">
                                            <table id="datatable1" class="table table-striped table-bordered"
                                                cellspacing="0" width="100%">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th></th>
                                                        <th>No</th>
                                                        <th>Status</th>
                                                        <th>Nama Kelas</th>
                                                        <th>Jatuh Tempo</th>
                                                        <th>Jml Order</th>
                                                        <th>Bukti</th>
                                                        <th>Kode Promo</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($payment as $key => $d)
                                                    <p hidden>
                                                        @if ($d->expired < \Carbon\Carbon::now()) {{ $expired=true }}
                                                            @else {{ $expired=false }} @endif <tr class="text-center">
                                                    </p>
                                                    <td>
                                                        <div>
                                                            <input id="checkbox-{{ $key }}" class="checkbox-style"
                                                                name="checkbox" type="checkbox" {{ $expired ? 'disabled'
                                                                : '' }} onclick="checkedBilling({{ $d }},{{ $key }})">
                                                            <label for="checkbox-{{ $key }}"
                                                                class="checkbox-style-3-label"></label>
                                                        </div>
                                                    </td>
                                                    <td width="1%">{{ $key + 1 }}</td>
                                                    <td>
                                                        @if ($expired)
                                                        <span class="badge badge-danger text-uppercase">
                                                            Expired
                                                        </span>
                                                        @else
                                                        @if (!$d->file && $d->status == 0)
                                                        <span class="badge badge-danger text-uppercase">
                                                            Belum Lunas
                                                        </span>
                                                        @elseif ($d->file && $d->status == 0)
                                                        <span class="badge badge-secondary text-uppercase">
                                                            Sedang Diproses
                                                        </span>
                                                        @else
                                                        <span class="badge badge-primary text-uppercase">
                                                            Lunas
                                                        </span>
                                                        @endif
                                                        @endif
                                                    </td>
                                                    <td class="longtextoverflow" title="{{ $d->title }}">
                                                        {{ $d->title }}
                                                    </td>
                                                    <td class="text-danger">
                                                        <b>{{ \Carbon\Carbon::parse($d->expired)->format('d-m-Y
                                                            H:i:s') }}</b>
                                                    </td>
                                                    <td class="longtextoverflow">
                                                        @if ($expired)
                                                        <input type="number" name="jmlPeserta[]" class="form-control"
                                                            value="{{ $d->jumlah }}" readonly>
                                                        @else
                                                        @if ($d->file)
                                                        {{ $d->jumlah }} Order Peserta
                                                        @else
                                                        <input type="number" name="jmlPeserta[]" class="form-control"
                                                            onchange="tambahPeserta('{{ $d->id }}','{{ $d->participant_limit }}','{{ $d->class_id }}',$(this).val(),@if (isset($pfl)){{ $pfl['referral'] ? $pfl['referral'] : '' }}@endif)"
                                                            value="{{ $d->jumlah }}">
                                                        @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->file)
                                                        <a href="/getBerkas?rf={{ $d->file }}" target="_blank"
                                                            data-lightbox="gallery-item"><img
                                                                src="/getBerkas?rf={{ $d->file }}" width="110px"></a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($d->kode_promo || $d->file)
                                                        {{ $d->kode_promo }}
                                                        @else
                                                        <input type="text" name="kode_promo[]" class="form-control"
                                                            onchange="kodePromo('{{ urlencode($d->title) }}',$(this).val(),'{{ $d->id }}')"
                                                            @if ($expired) readonly @endif>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-warning dropdown-toggle btn-sm"
                                                                type="button" data-toggle="dropdown"
                                                                aria-expanded="false" title="Opsi">
                                                                <i class="icon-cog"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="btn btn-primary dropdown-item"
                                                                    href="/classes/getinvoice/{{ $d->id }}"
                                                                    target="_blank" title="Invoice">Invoice</a>
                                                                @if ($d->status == 0)
                                                                <button id="btnModal" type="button"
                                                                    class="btn btn-primary dropdown-item"
                                                                    data-toggle="modal" data-target="#bayarModal"
                                                                    onclick="bukti({{ $d->class_id }},{{ $d->id }},{{ $reff ? $reff->code : '' }})"
                                                                    title="Upload Bukti" @if ($d->expired <=
                                                                        Carbon\Carbon::now()) disabled @endif>
                                                                        Upload Bukti
                                                                </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <!-- Modal Multi Bukti-->
                                            <div class="modal fade" id="bayarMultiModal" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="/multi-bayar" method="POST"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <textarea name="dataInvoiceMulti" id="dataInvoiceMulti"
                                                                    cols="30" rows="10" required hidden></textarea>
                                                                <div class="col-lg-12 bottommargin">
                                                                    <label>Upload Bukti Multi Pembayaran:</label><br>
                                                                    <input id="inputimagebukti" name="imageBuktiMulti"
                                                                        type="file" class="file"
                                                                        data-show-upload="false"
                                                                        data-show-caption="true"
                                                                        data-show-preview="true" accept="image/*">
                                                                    @error('imageBuktiMulti')
                                                                    <span class="text-danger" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save
                                                                    changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal Bukti-->
                                            <div class="modal fade" id="bayarModal" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="bayar" method="POST"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="text" id="class_id" name="class_id" hidden>
                                                                <input type="text" id="payment_id" name="payment_id"
                                                                    hidden>
                                                                <input type="text" id="ref" name="ref" hidden>
                                                                <div class="form-group" hidden>
                                                                    <label for="">Jumlah Peserta</label>
                                                                    <input class="form-control" type="number"
                                                                        id="jml_peserta" name="jml_peserta">
                                                                </div>
                                                                <div class="col-lg-12 bottommargin">
                                                                    <label>Upload Bukti Pembayaran:</label><br>
                                                                    <input id="input-3" name="input2[]" type="file"
                                                                        class="file" data-show-upload="false"
                                                                        data-show-caption="true"
                                                                        data-show-preview="true" accept="image/*">
                                                                    @error('input2')
                                                                    <span class="text-danger" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save
                                                                    changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-content clearfix" id="tab-postss">
                                        @include('front.profile.kelasanda')
                                    </div>
                                    <div class="tab-content clearfix" id="tab-posts">
                                        @include('front.profile.setting')
                                    </div>
                                    <div class="tab-content clearfix" id="tab-pnpt">
                                        <img src="{{asset('upcoming_absen_post_test_Cara pakai_promo_copy_2.jpg')}}"
                                            alt="">
                                    </div>
                                    <div class="tab-content clearfix" id="tab-affiliate">
                                        @include('front.profile.tabAffiliate')
                                    </div>
                                    <div class="tab-content clearfix" id="tab-absen">
                                        <img src="{{asset('upcoming_absen_post_test_Cara pakai_promo_copy_2.jpg')}}"
                                            alt="">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="w-100 line d-block d-md-none"></div> -->
            </div>
        </div>
    </div>
    <div class="modal fade" id="reviewFormModal" tabindex="-1" role="dialog" aria-labelledby="reviewFormModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="reviewFormModalLabel">Submit a
                        Review
                    </h4>
                    <button type="button" class="btn-close btn-sm" data-dismiss="modal" aria-hidden="true">x</button>
                </div>
                <div class="modal-body">
                    <form class="row mb-0" id="template-reviewform" name="template-reviewform"
                        action="/addreviewinstructor" method="post">
                        @csrf
                        <input type="text" name="instructor_id" id="instructor_id" hidden>
                        <div class="col-12 mb-3">
                            <label for="template-reviewform-rating">Rating</label>
                            <span id="nilai_value" class="ml-1"></span>
                            <input type="range" class="form-range form-control p-0" id="nilai_review" name="nilai"
                                value="1" min="1" max="5" required>

                        </div>
                        <div class="w-100"></div>
                        <div class="col-12 mb-3">
                            <label for="template-reviewform-comment">Comment
                                <small>*</small></label>
                            <textarea class="required form-control" id="template-reviewform-comment" name="comment"
                                rows="6" cols="30" required></textarea>
                        </div>
                        @auth
                        <div class="col-12">
                            <button class="button button-3d m-0" type="submit" id="template-reviewform-submit"
                                name="template-reviewform-submit" value="submit">Submit
                                Review</button>
                        </div>
                        @else
                        <div class="col-12">
                            <p class="text-danger">Pastikan Sudah Login!</p>
                        </div>
                        @endauth
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalCorporate" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
        aria-labelledby="reviewFormModalLabel" aria-hidden="true" style="background-color: #000000cc">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <a href="/" type="button" class="btn btn-secondary btn-sm">Beranda</a>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body">
                    <div id="pilihGambar" class="row">
                        <div class="col">
                            <img src="perorangan.jpg" alt="" id="peroranganPilih">
                        </div>
                        <div class="col">
                            <img src="corporate.jpg" alt="" id="corporatePilih">
                        </div>
                    </div>
                    <div id="formPerorangan" hidden>
                        <h4>Perorangan</h4>
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
                                                    <input type="text" name="rekening" id="rekening"
                                                        class="form-control" value="1">
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
                                                    <input type="text" id="referral" name="referral"
                                                        class="form-control"
                                                        onchange="referralKode('{{ isset($pfl['user_id'])?$pfl['user_id']:'' }}',$(this).val())"
                                                        value="@if (isset($pfl['user_id'])){{ $pfl['referral'] ? $pfl['referral']['code'] : '' }}@endif"
                                                        @if (isset($pfl['user_id'])){{ $pfl['referral'] ? 'readonly'
                                                        : '' }}@endif>
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
                        <h4>Corporate</h4>
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
                                                <option value="koperasi">Koperasi</option>
                                                <option value="lkm">Lembaga Keuangan Mikro</option>
                                            </select>
                                        </div>
                                        <div class="col-md-9">
                                            <label for="form-control">Nama Corporate</label>
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
                                                    <input type="text" name="rekening" id="rekening"
                                                        class="form-control" value="1">
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
                                                    <input type="text" id="referral" name="referral"
                                                        class="form-control"
                                                        onchange="referralKode('{{ isset($pfl['user_id'])?$pfl['user_id']:'' }}',$(this).val())"
                                                        value="@if (isset($pfl['user_id'])){{ $pfl['referral'] ? $pfl['referral']['code'] : '' }}@endif"
                                                        @if (isset($pfl['user_id'])){{ $pfl['referral'] ? 'readonly'
                                                        : '' }}@endif>
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
    <textarea id="corporateUser" cols="30" rows="10" hidden>{{$user->corporate}}</textarea>
</section><!-- #content end -->
<script>
    let checkedData = [];
    $(document).ready(function() {
        $('#datatable1').dataTable();
        $('#datatable2').dataTable();
        $('#affiliate').dataTable();
        $('#withdraw1').dataTable();
        // let setting = {};
        // new TomSelect("#nama_lengkaps",setting);
        $('#nilai').change(function() {
            let nilai = $('#nilai').val();
            $('#nilai_val').html(nilai);
        })
        $('#destroy').click(function(event) {
            var form = $(this).closest("form");
            event.preventDefault();
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire(
                        'Deleted!',
                        'Your data has been deleted.',
                        'success'
                    )
                }
            });
        });

        $('#kembali').click(function () {
            $('#pilihGambar').removeAttr('hidden');
            $('#formCorporate').attr('hidden', true);
            $('#formPerorangan').attr('hidden',true)
        })
        $('#kembali2').click(function () {
            $('#pilihGambar').removeAttr('hidden');
            $('#formCorporate').attr('hidden', true);
            $('#formPerorangan').attr('hidden',true)
        })
        $('#peroranganPilih').click(function () {
            $('#pilihGambar').attr('hidden', true);
            $('#formCorporate').attr('hidden', true);
            $('#formPerorangan').removeAttr('hidden')
        })
        $('#corporatePilih').click(function () {
            $('#pilihGambar').attr('hidden', true);
            $('#formCorporate').removeAttr('hidden', true);
            $('#formPerorangan').attr('hidden')
        })
            
        let corporate = $('#corporateUser').val();
        if (corporate && corporate != 'perorangan') {
            try {
                let js = JSON.parse(corporate)
            } catch (error) {
                $('#modalCorporate').modal('show');
                
            }
        }
        if (!corporate) {
            try {
                let js = JSON.parse(corporate)
            } catch (error) {
                $('#modalCorporate').modal('show');
                
            }
        }
    })
    $('#picture').change(function(e) {
        getImgData(this, '#pictureprv');
    });
    $('#picture2').change(function(e) {
        getImgData(this, '#pictureprv2');
    });
    $('#picture3').change(function(e) {
        getImgData(this, '#pictureprv3');
    });
    $('#nilai_review').change(function() {
        let nilai = $('#nilai_review').val();
        $('#nilai_value').html(nilai);
    })
    $('#buktiMulti').on('click',function () {
        if ($('#dataInvoiceMulti').val() == '[null]') {
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: 'Data Tidak Ditemukan',
            })
            return
        }
        if (!$('#dataInvoiceMulti').val()) {
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: 'Data Tidak Ditemukan',
            })
            return
        }
        $('#bayarMultiModal').modal('show');
    })
    $('#jenis_corporates').on('change', function () {
            let val = $('#jenis_corporates').val();
            $('#nama_lengkaps').removeAttr('class');
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
                    new TomSelect("#nama_lengkaps",{
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
	                    		return '<div title="' + escape(data.id) + '" value="'+escape(data.id)+'">' + escape(data.nama) + '</div>';
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

    function tambahPeserta(params, limit, classid, val, ref) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: "bayar",
            method: 'post',
            data: {
                payment_id: params,
                limit: limit,
                classid: classid,
                jumlah: val,
                ref: ref,
            },
            success: function(result) {
                if (result.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: result.message,
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: result.message,
                    })
                }
                // setTimeout(() => {
                //     location.reload();
                // }, 1000);
            },
            error: function(jqXhr, json, errorThrown) { // this are default for ajax errors
                // var errors = jqXhr.responseJSON;
                // var errorsHtml = '';
                // console.log(errors['errors']);
            }
        })
    }

    function kodePromo(id, kode_promo, idpaymnet) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: "/kode-promo",
            method: 'post',
            data:{
                id:id,
                kode:kode_promo,
                idpayment:idpaymnet
            },
            success: function(result) {
                if (result.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: result.message,
                    })
                    location.reload()
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Maaf',
                        text: result.message,
                    })
                }
                // setTimeout(() => {
                //     location.reload();
                // }, 1000);
            },
            error: function(jqXhr, json, errorThrown) { // this are default for ajax errors
                // var errors = jqXhr.responseJSON;
                // var errorsHtml = '';
                // console.log(errors['errors']);
            }
        })
    }

    function referralKode(id_user, referral) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: "/join/referral/" + id_user + '/' + referral,
            method: 'get',
            success: function(result) {
                console.log(result);
                if (result.status == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: result.message,
                    })
                    // location.reload()
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Maaf',
                        text: result.message,
                    })
                }
                // setTimeout(() => {
                //     location.reload();
                // }, 1000);
            },
            error: function(jqXhr, json, errorThrown) { // this are default for ajax errors
                // var errors = jqXhr.responseJSON;
                // var errorsHtml = '';
                // console.log(errors['errors']);
            }
        })
    }

    function reviewIns(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: "review-instructor",
            method: 'get',
            data: {
                id_instructor: e,
                tujuan: 'get'
            },
            success: function(result) {
                $('#instructor_id').val(e);
                $('#reviewFormModal').modal('show');
                console.log(result);
                $('#nilai_review').val(result[0].review_val)
                $('#template-reviewform-comment').val(result[0].review_msg)
            },
            error: function(jqXhr, json, errorThrown) { // this are default for ajax errors
                var errors = jqXhr.responseJSON;
                var errorsHtml = '';
                console.log(errors['errors']);
            }
        })
    }

    function bukti(class_id, payment, ref) {
        $('#class_id').val(class_id);
        $('#payment_id').val(payment);
        $('#ref').val(ref);
    }

    function onEvent(event) {
        let html = '<td colspan="4" class="text-center"> Tidak Ditemukan</td>';
        if (event.length > 0) {
            html = '';
            no = 1;
            event.forEach(el => {
                html += '<tr class="text-center">';
                html += '<td>' + no++ + '</td>'
                if (el.type == 0) {
                    html += '    <td><a class="btn btn-success" href="' + el.link +
                        '" target="_blank"><i class="icon-link"></i></a></td>';
                } else {
                    html += '    <td>' + el.location + '</td>';
                }
                html += '<td>'
                html += '<span class="badge badge-info">';
                html += new Date(el.time_start).toLocaleDateString();
                html += '<br>' + new Date(el.time_start).toLocaleTimeString() + ' - ' + new Date(el.time_end)
                    .toLocaleTimeString();
                html += '</span>';
                html += '</td>'
                html += '    <td class="longtextoverflow">' + el.description + '</td>';
                html += '</tr>';
            });
        }
        $('#tableEvent').html(html);
    }

    function review(participant_id) {
        $('#reviewModal').modal('show');
        $('#participant_id').val(participant_id);
        $('#btnReview').removeAttr('disabled');
    }

    function onReview(review, point) {
        $('#reviewModal').modal('show');
        $('#nilai').val(point);
        $('#nilai_val').html(point);
        $('#review').val(review);
        $('#btnReview').attr('disabled', 'disabled');
    }

    function onContent(content) {
        $('#contentModal').modal('show');
        let html = 'Tidak Ditemukan';
        if (content.length > 0) {
            html = '';
            no = 1;
            content.forEach(el => {
                html += '<tr class="text-center">';
                html += '<td>' + no++ + '</td>'
                html += '    <td>' + el.title + '</td>';
                if (el.type != 3) {
                    html += '    <td><a href=/getBerkas?rf=' + el.url +
                        ' target=_blank><i class="icon-link"></i></a></td>';
                } else {
                    html += '    <td><a href=' + el.url + ' target=_blank><i class="icon-link"></i></a></td>';
                }
                html += '</tr>';
            });
        }
        $('#tableContent').html(html);
    }

    function checkedBilling(d, key) {
        let check = false;
        if ($('#checkbox-' + key).is(':checked')) {
            check = true;
        }

        if (check) {
            if (key in checkedData) {
                checkedData[key] = d;
            } else {
                checkedData.push(d);
            }
        } else {
            checkedData[key] = null;
        }

        $('#dataInvoice').val(JSON.stringify(checkedData));
        $('#dataInvoiceMulti').val(JSON.stringify(checkedData));
    }

    function invoiceAjax() {
        if (!$('#dataInvoice').val()) {
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: 'Data Tidak Ditemukan',
            })
            return
        }
        if ($('#dataInvoice').val() == '[null]') {
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: 'Data Tidak Ditemukan',
            })
            return
        }
        $('#formmultiinvoice').submit();
        location.reload();
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });
        // jQuery.ajax({
        //     url: "/classes/multiinvoice" ,
        //     method: 'post',
        //     data: {data:data},
        //     success: function(result) {
        //         console.log(result);
        //         if (result.status == 200) {
        //             Swal.fire({
        //                 icon: 'success',
        //                 title: 'Berhasil',
        //                 text: result.message,
        //             })
        //             // location.reload()
        //         } else {
        //             Swal.fire({
        //                 icon: 'error',
        //                 title: 'Maaf',
        //                 text: result.message,
        //             })
        //         }
        //     },
        //     error: function(jqXhr, json, errorThrown) { // this are default for ajax errors
        //         // var errors = jqXhr.responseJSON;
        //         // var errorsHtml = '';
        //         console.log(errors['errors']);
        //     }
        // })
    }
</script>
@include(env('CUSTOM_FOOTER', 'front.layout.footer'))