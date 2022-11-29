@include("front.layout.head")
@include("front.layout.topbar")
@include(env("CUSTOM_HEADER","front.layout.header"))
@error('error')
{{$message}}
@enderror
<section id="content">
    <div class="content-wrap" style="padding: 24px;">
        <div class="container clearfix">
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="heading-block border-0">
                        <h3>{{Auth::user()->name}}</h3>
                        <span>Your Profile Bio</span>
                    </div>
                    <div class="clear"></div>
                    <div class="row clearfix">
                        <div class="col-lg-12">
                            <div class="tabs tabs-alt clearfix" id="tabs-profile">
                                <ul class="tab-nav clearfix">
                                    <li><a href="#tab-feeds"><i class="icon-credit-cards"></i> Billing kelas</a></li>
                                    <li><a href="#tab-postss"><i class="icon-line-book-open"></i> Kelas anda</a></li>
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
                                                            value="{{$param['date'][0]}}" placeholder="Date Start"
                                                            aria-label="Date Start" name="param_date_start">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon5">s/d</span>
                                                        </div>
                                                        <input type="date" class="form-control"
                                                            value="{{$param['date'][1]}}" placeholder="Date End"
                                                            aria-label="Date End" name="param_date_end">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Status : </label>
                                                        <div class="form-check form-check-inline">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="param_checked_lunas[]" value="0"
                                                                    {{(in_array(0,$param['status'])?'checked':'')}}>
                                                                Belum Lunas
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="param_checked_lunas[]" value="1"
                                                                    {{(in_array(1,$param['status'])?'checked':'')}}>
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
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="datatable1" class="table table-striped table-bordered"
                                                cellspacing="0" width="100%">
                                                <thead>
                                                    <tr class="text-center">
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
                                                    @if ($d->expired < \Carbon\Carbon::now()) {{$expired=true}} @else
                                                        {{$expired=false}} @endif <tr class="text-center">
                                                        <td width="1%">{{$key+1}}</td>
                                                        <td>
                                                            @if ($expired) <span
                                                                class="badge badge-danger text-uppercase">
                                                                Expired
                                                            </span>
                                                            @else
                                                            @if (!$d->file && $d->status==0)
                                                            <span class="badge badge-danger text-uppercase">
                                                                Belum Lunas
                                                            </span>
                                                            @elseif ($d->file && $d->status==0)
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
                                                        <td class="longtextoverflow" title="{{$d->title}}">{{$d->title}}
                                                        </td>
                                                        <td class="text-danger"><b>{{
                                                                \Carbon\Carbon::parse($d->expired)->format('d-m-Y
                                                                H:i:s') }}</b></td>
                                                        <!-- <td>{{ numfmt_format_currency(numfmt_create('id_ID',
                                                            \NumberFormatter::CURRENCY),$d->price_final,"IDR") }}</td> -->
                                                        <td class="longtextoverflow">
                                                            @if ($expired)
                                                            <input type="number" name="jmlPeserta[]"
                                                                class="form-control" value="{{$d->jumlah}}" readonly>
                                                            @else
                                                            @if ($d->file)
                                                            {{$d->jumlah}} Order Peserta
                                                            @else
                                                            <input type="number" name="jmlPeserta[]"
                                                                class="form-control"
                                                                onchange="tambahPeserta('{{$d->id}}','{{$d->participant_limit}}','{{$d->class_id}}',$(this).val())"
                                                                value="{{$d->jumlah}}">
                                                            @endif
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($d->file)
                                                            <a href="/getBerkas?rf={{$d->file}}" target="_blank"
                                                                data-lightbox="gallery-item"><img
                                                                    src="/getBerkas?rf={{$d->file}}" width="110px"></a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($d->kode_promo)
                                                            {{$d->kode_promo}}
                                                            @else
                                                            <input type="text" name="kode_promo[]" class="form-control"
                                                                onchange="kodePromo('{{$d->title}}',$(this).val(),'{{$d->id}}')">
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
                                                                        href="/classes/getinvoice/{{$d->id}}"
                                                                        target="_blank" title="Invoice">Invoice</a>
                                                                    @if ($d->status == 0)
                                                                    <button id="btnModal" type="button"
                                                                        class="btn btn-primary dropdown-item"
                                                                        data-toggle="modal" data-target="#bayarModal"
                                                                        onclick="bukti({{$d->class_id}},{{$d->id}})"
                                                                        title="Upload Bukti" @if ($d->expired <=
                                                                            Carbon\Carbon::now()) disabled @endif>
                                                                            Upload Bukti
                                                                    </button>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </td>
                                                        </tr>
                                                        @endforeach
                                                </tbody>
                                            </table>
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
                                                                        <strong>{{$message}}</strong>
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
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <form action="/profile#tab-feeds" method="get">
                                                    <label>Tanggal Pembayaran</label>
                                                    <div class="input-group mb-4">
                                                        <input type="date" class="form-control"
                                                            value="{{$param['date'][0]}}" placeholder="Date Start"
                                                            aria-label="Date Start" name="param_date_start">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon5">s/d</span>
                                                        </div>
                                                        <input type="date" class="form-control"
                                                            value="{{$param['date'][1]}}" placeholder="Date End"
                                                            aria-label="Date End" name="param_date_end">
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
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="datatable2" class="table table-bordered">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>No</th>
                                                        <th>Kelas</th>
                                                        <th>Instruktor</th>
                                                        <th>Tanggal</th>
                                                        <th>Rincian Kelas</th>
                                                        <th>Unduhan</th>
                                                        <th>Review</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($class as $key=> $c )
                                                    @foreach ($c->class as $cl)
                                                    <tr class="text-center">
                                                        <td width="1%">{{$key+1}}</td>
                                                        <td class="longtextoverflow">{{$cl->title}}</td>
                                                        <td>
                                                            @foreach ($cl->instructor_list as $instructor_list)
                                                            <span
                                                                class="badge badge-primary">{{$instructor_list->name}}</span>
                                                            @endforeach
                                                        </td>
                                                        <td><span class="badge badge-info">
                                                                @if(\Carbon\Carbon::parse($cl->date_start)->format('d-m-Y')==\Carbon\Carbon::parse($cl->date_end)->format('d-m-Y'))
                                                                {{\Carbon\Carbon::parse($cl->date_start)->format('d-m-Y')}}
                                                                @else
                                                                {{\Carbon\Carbon::parse($cl->date_start)->format('d-m-Y')
                                                                .' -
                                                                '.
                                                                \Carbon\Carbon::parse($cl->date_end)->format('d-m-Y')}}
                                                                @endif
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <button id="evModal"
                                                                class="button button-circle button-mini"
                                                                data-toggle="modal" data-target="#eventModal"
                                                                onclick="onEvent({{$c->event}})" title="Event">
                                                                Open
                                                            </button>
                                                            <button
                                                                class="button button-mini button-circle">Link</button>
                                                        </td>
                                                        <td width="5%">
                                                            <div class="dropdown">
                                                                <button class="btn btn-warning dropdown-toggle btn-sm"
                                                                    type="button" data-toggle="dropdown"
                                                                    aria-expanded="false" title="Opsi">
                                                                    <i class="icon-cog"></i>
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item"
                                                                        href="/classes/getcertificate/{{$c->class_id}}"
                                                                        target="_blank">
                                                                        Get Certificate
                                                                    </a>
                                                                    <span class="dropdown-item"
                                                                        onclick="onContent({{$cl->content_list}})">Content/Material</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <button class="button button-circle button-mini" {{-- --}}
                                                                @if ($c->review)
                                                                onclick="onReview('{{$c->review}}','{{$c->review_point}}')"
                                                                @else
                                                                onclick="review({{$c->participant_id}})"
                                                                @endif
                                                                >Class</button>
                                                            <button class="button button-circle button-mini" {{-- --}}
                                                                onclick="reviewIns({{$c->class[0]->instructor_list[0]->id}})">Intructor</button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Modal Participant-->
                                        <div class="modal fade" id="reviewModal" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="/classes/review" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h3>Review</h3>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="text" id="participant_id" name="participant_id"
                                                                hidden>
                                                            <div class="col-lg-12">
                                                                <label>Nilai = </label><span id="nilai_val"></span><br>
                                                                <input type="range" class="form-range form-control p-0"
                                                                    id="nilai" name="nilai" value="{{old('nilai')}}"
                                                                    min="1" max="5">
                                                                @error('nilai')
                                                                <span class="text-danger" role="alert">
                                                                    <strong>{{$message}}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-lg-12 bottommargin">
                                                                <label>Pesan</label><br>
                                                                <textarea name="review" id="review" cols="30" rows="10"
                                                                    class="form-control"></textarea>
                                                                @error('input2')
                                                                <span class="text-danger" role="alert">
                                                                    <strong>{{$message}}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary"
                                                                id="btnReview">Save
                                                                changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal Content-->
                                        <div class="modal fade" id="contentModal" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <form action="#" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h3>Content</h3>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr class="text-center">
                                                                        <th width="1%">No</th>
                                                                        <th>Title</th>
                                                                        <th>Url</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="tableContent">
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal Event-->
                                        <div class="modal fade" id="eventModal" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <form action="#" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h3>Rincian kelas</h3>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr class="text-center">
                                                                        <th width="1%">No</th>
                                                                        <th>Link/Lokasi</th>
                                                                        <th>Waktu</th>
                                                                        <th>Keterangan</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="tableEvent">
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-content clearfix" id="tab-posts">
                                        <!-- <div class="title-block">
                                            <h4>Update User Akses</h4>
                                            <form action="" method="post">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label for="form-control">Name</label>
                                                        <input type="text" class="form-control" value="">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label for="form-control">Email</label>
                                                        <input type="email" class="form-control" value="" readonly>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label for="form-control">Password</label>
                                                        <input type="text" class="form-control" name="password">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <button class="button button-small" type="submit">Update akses login</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div> -->
                                        <div class="title-block">
                                            <h4>Update Profile</h4>
                                            <form action="{{ route('profile.store') }}" method="post">
                                                @csrf
                                                @if(isset($pfl))
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label for="form-control">Nama lengkap</label>
                                                        <input type="text" class="form-control" name="nama_lengkap"
                                                            value="{{$pfl['name']}}">
                                                        <input type="hidden" name="user_id"
                                                            value="{{Auth::user()->id}}">
                                                        @if($errors->has('nama_lengkap'))
                                                        <div class="error" style="color: red; display:block;">
                                                            {{ $errors->first('nama_lengkap') }}
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label for="form-control">Nomor handphone</label>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">+62</span>
                                                            </div>
                                                            <input type="text" class="form-control"
                                                                name="nomor_handphone" value="{{$pfl['phone']}}">
                                                        </div>
                                                        @if($errors->has('nomor_handphone'))
                                                        <div class="error" style="color: red; display:block;">
                                                            {{ $errors->first('nomor_handphone') }}
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label for="form-control">Company</label>
                                                        <input type="text" class="form-control" name="company"
                                                            value="{{$pfl['instansi']}}">
                                                        <small class="text-danger">Jika mempunyai wajib di isi</small>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <label for="form-control">Tanggal lahir</label>
                                                        <input type="date" name="tanggal_lahir" class="form-control"
                                                            value="{{$pfl['tanggal_lahir']}}">
                                                        @if($errors->has('tanggal_lahir'))
                                                        <div class="error" style="color: red; display:block;">
                                                            {{ $errors->first('tanggal_lahir') }}
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label for="form-control">Jenis kelamin</label>
                                                        <select name="jenis_kelamin" class="form-control" id="jkl">
                                                            <option value="">Pilih salah satu</option>
                                                            <option value="0" {{($pfl['gender']==0)?'selected':null}}>
                                                                Perempuan</option>
                                                            <option value="1" {{($pfl['gender']==1)?'selected':null}}>
                                                                Laki-laki</option>
                                                        </select>
                                                        @if($errors->has('jenis_kelamin'))
                                                        <div class="error" style="color: red; display:block;">
                                                            {{ $errors->first('jenis_kelamin') }}
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <label for="form-control">Alamat</label>
                                                        <textarea class="form-control"
                                                            name="alamat">{{$pfl['description']}}</textarea>
                                                        @if($errors->has('alamat'))
                                                        <div class="error" style="color: red; display:block;">
                                                            {{ $errors->first('alamat') }}
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                @else
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label for="form-control">Nama lengkap</label>
                                                        <input type="text" class="form-control" name="nama_lengkap">
                                                        <input type="hidden" name="user_id"
                                                            value="{{Auth::user()->id}}">
                                                        @if($errors->has('nama_lengkap'))
                                                        <div class="error" style="color: red; display:block;">
                                                            {{ $errors->first('nama_lengkap') }}
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label for="form-control">Nomor handphone</label>
                                                        <input type="text" class="form-control" name="nomor_handphone">
                                                        @if($errors->has('nomor_handphone'))
                                                        <div class="error" style="color: red; display:block;">
                                                            {{ $errors->first('nomor_handphone') }}
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label for="form-control">Company</label>
                                                        <input type="text" class="form-control" name="company">
                                                        <small class="text-danger">Jika mempunyai wajib di isi</small>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <label for="form-control">Tanggal lahir</label>
                                                        <input type="date" name="tanggal_lahir" class="form-control">
                                                        @if($errors->has('tanggal_lahir'))
                                                        <div class="error" style="color: red; display:block;">
                                                            {{ $errors->first('tanggal_lahir') }}
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label for="form-control">Jenis kelamin</label>
                                                        <select name="jenis_kelamin" class="form-control">
                                                            <option value="">Pilih salah satu</option>
                                                            <option value="0">Perempuan</option>
                                                            <option value="1">Laki-laki</option>
                                                        </select>
                                                        @if($errors->has('jenis_kelamin'))
                                                        <div class="error" style="color: red; display:block;">
                                                            {{ $errors->first('jenis_kelamin') }}
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <label for="form-control">Alamat</label>
                                                        <textarea class="form-control" name="alamat"></textarea>
                                                        @if($errors->has('alamat'))
                                                        <div class="error" style="color: red; display:block;">
                                                            {{ $errors->first('alamat') }}
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <button class="button button-small" type="submit">Update
                                                            profile</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="divider divider-border divider-center"><i class="icon-email2"></i>
                                        </div>
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
</section><!-- #content end -->

<script>
    $(document).ready(function() {
        $('#datatable2').dataTable();
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
    })
    
    $('#nilai_review').change(function() {
        let nilai = $('#nilai_review').val();
        $('#nilai_value').html(nilai);
    })

    function tambahPeserta(params,limit,classid,val) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: "bayar",
            method: 'post',
            data: {
                payment_id:params,
                limit:limit,
                classid:classid,
                jumlah:val,
            },
            success: function(result) {
                if (result.status) {
                    Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: result.message,
                    })
            }else{
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
    function kodePromo(id,kode_promo,idpaymnet) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: "/kode-promo/"+id+'/'+kode_promo+'/'+idpaymnet,
            method: 'post',
            success: function(result) {
                if (result.status) {
                    Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: result.message,
                    })
                    location.reload()
            }else{
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

    function reviewIns(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: "review-instructor",
            method: 'get',
            data: {id_instructor:e,tujuan:'get'},
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

    function bukti(class_id, payment) {
        $('#class_id').val(class_id);
        $('#payment_id').val(payment);
    }

    function onEvent(event) {
        let html = 'Tidak Ditemukan';
        if (event.length > 0) {
            html = '';
            no = 1;
            event.forEach(el => {
                html += '<tr class="text-center">';
                html += '<td>' + no++ + '</td>'
                if (el.type == 0) {
                    html += '    <td><a class="btn btn-success" href="' + el.link + '" target="_blank"><i class="icon-link"></i></a></td>';
                } else {
                    html += '    <td>' + el.location + '</td>';
                }
                html += '<td>'
                html +='<span class="badge badge-info">';
                    html += new Date(el.time_start).toLocaleDateString();
                    html += '<br>'+ new Date(el.time_start).toLocaleTimeString() +' - '+ new Date(el.time_end).toLocaleTimeString();
                html +='</span>';
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
                    html += '    <td><a href=/getBerkas?rf=' + el.url + ' target=_blank><i class="icon-link"></i></a></td>';
                } else {
                    html += '    <td><a href=' + el.url + ' target=_blank><i class="icon-link"></i></a></td>';
                }
                html += '</tr>';
            });
        }
        $('#tableContent').html(html);
    }
</script>
@include(env("CUSTOM_FOOTER","front.layout.footer"))