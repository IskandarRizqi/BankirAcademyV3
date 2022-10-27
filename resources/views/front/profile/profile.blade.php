@include("front.layout.head")
@include("front.layout.topbar")
@include("front.layout.header")
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
                                        <div class="table-responsive">
                                            <table id="datatable1" class="table table-striped table-bordered"
                                                cellspacing="0" width="100%">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>No</th>
                                                        <th>Status</th>
                                                        <th>Nama kelas</th>
                                                        <th>Expired</th>
                                                        <th>Price Final</th>
                                                        <th>Bukti</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($payment as $key => $d)
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td><span class="badge badge-primary text-uppercase">
                                                                {{$d->status?'lunas':'belum lunas'}}
                                                            </span>
                                                        </td>
                                                        <td>{{$d->title}}</td>
                                                        <td>{{$d->expired}}</td>
                                                        <td>{{ numfmt_format_currency(numfmt_create('id_ID',
                                                            \NumberFormatter::CURRENCY),$d->price_final,"IDR") }}</td>
                                                        <td>
                                                            @if ($d->file)
                                                            <img src="/getBerkas?rf={{$d->file}}" alt="" width="130px">
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
                                                                    <a class="dropdown-item"
                                                                        href="/classes/getcertificate/{{$d->class_id}}"
                                                                        target="_blank">Get
                                                                        Certificate</a>
                                                                    <button id="btnModal" type="button"
                                                                        class="btn btn-primary dropdown-item"
                                                                        data-toggle="modal" data-target="#bayarModal"
                                                                        onclick="bukti({{$d->class_id}},{{$d->id}})"
                                                                        title="Upload Bukti">
                                                                        Upload Bukti
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <!-- Modal -->
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
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>kelas</th>
                                                    <th>Instruktor</th>
                                                    <th>Tanggal</th>
                                                    <th>Link kelas</th>
                                                    <th>Unduhan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>

                                                </tr>
                                            </tbody>
                                        </table>
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
                                                        <input type="text" class="form-control" name="nomor_handphone"
                                                            value="{{$pfl['phone']}}">
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
</section><!-- #content end -->

<script>
    $(document).ready(function() {
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
    function bukti(class_id, payment) {
        $('#class_id').val(class_id);
        $('#payment_id').val(payment);
    }
    
</script>
@include("front.layout.footer")