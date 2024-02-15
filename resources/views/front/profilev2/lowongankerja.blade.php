<div class="container">
    @foreach($lamaran as $key => $value)
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-2 text-center">
                    <div class="card br-10">
                        @if($value->lamaran->image)
                        <img src="image/loker/{{json_decode($value->lamaran->image)->url}}" alt="" width="100%">
                        @endif
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="d-flex justify-content-between">
                        <div class="kiri">
                            <h5 class="m-0">{{$value->lamaran->title}}</h5>
                            <p>{{$value->lamaran->nama}}</p>
                            <span>
                                <svg width="12" height="18" viewBox="0 0 12 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.08357 8.42836C7.34593 8.42836 8.36928 7.40501 8.36928 6.14265C8.36928 4.88028 7.34593 3.85693 6.08357 3.85693C4.8212 3.85693 3.79785 4.88028 3.79785 6.14265C3.79785 7.40501 4.8212 8.42836 6.08357 8.42836Z"
                                        stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M10.6553 8.42857C8.94099 12.4286 6.08384 17 6.08384 17C6.08384 17 3.2267 12.4286 1.51242 8.42857C-0.201869 4.42857 2.65527 1 6.08384 1C9.51242 1 12.3696 4.42857 10.6553 8.42857Z"
                                        stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                {{$value->lamaran->alamat}}
                            </span>
                        </div>
                        <div class="tengah"></div>
                        <div class="kanan text-right">
                            <h5 class="m-0">{{$value->lamaran->tanggal_akhir}}</h5>
                            <p class="m-0">
                                <span class="badge badge-pill badge-info">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5.88173 9.74554L3.18164 7.04482L4.08146 6.145L5.88173 7.94464L9.481 4.34473L10.3815 5.24518L5.88173 9.74554Z"
                                            fill="#0059F6" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0 7C0 3.13409 3.13409 0 7 0C10.8659 0 14 3.13409 14 7C14 10.8659 10.8659 14 7 14C3.13409 14 0 10.8659 0 7ZM7 12.7273C6.24788 12.7273 5.50313 12.5791 4.80827 12.2913C4.1134 12.0035 3.48203 11.5816 2.95021 11.0498C2.41838 10.518 1.99651 9.8866 1.70869 9.19173C1.42087 8.49687 1.27273 7.75212 1.27273 7C1.27273 6.24788 1.42087 5.50313 1.70869 4.80827C1.99651 4.1134 2.41838 3.48203 2.95021 2.95021C3.48203 2.41838 4.1134 1.99651 4.80827 1.70869C5.50313 1.42087 6.24788 1.27273 7 1.27273C8.51897 1.27273 9.97572 1.87613 11.0498 2.95021C12.1239 4.02428 12.7273 5.48103 12.7273 7C12.7273 8.51897 12.1239 9.97572 11.0498 11.0498C9.97572 12.1239 8.51897 12.7273 7 12.7273Z"
                                            fill="#0059F6" />
                                    </svg>
                                    Dilamar
                                </span>
                            </p>
                            @if(\Carbon\Carbon::now() > \Carbon\Carbon::parse($value->lamaran->tanggal_akhir))
                            <span class="text-secondary">
                                Lamaran Sudah Tutup
                            </span>
                            @else
                            <span class="text-secondary">
                                Lamaran Masih Terbuka
                            </span>
                            @endif
                            <a href="/loker/{{$value->loker_id}}/detail" target="_blank"
                                class="btn btn-primary btn-sm btn-block br-10 mt-4">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <h3 class="mt-5">Daftar Lowongan Kerja</h3>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable3" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Perusahaan</th>
                            <th>Jabatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loker as $key => $value)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$value->nama?$value->nama:'PT. Anugrah Karya'}}</td>
                            <td>{{$value->title}}</td>
                            <td>
                                <div class="row">
                                    <form id="orderForm" action="{{ '/loker/apply' }}" method="POST">
                                        @csrf
                                        <input type="text" id="class_id" name="class_id" value="{{ $value->id }}"
                                            hidden>
                                        <button class="button button-circle">Kirim
                                            Lamaran</button>
                                    </form>
                                    <a href="/loker/{{$value->id}}/detail">
                                        <button class="button button-circle button-aqua">Detail
                                            Loker</button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>