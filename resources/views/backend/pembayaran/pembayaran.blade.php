@extends('layouts.compact')

@section('content')
    <div class="container-fluid py-4">

        {{-- Header Halaman --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="font-weight-bold text-dark mb-1">Kelola Pembayaran</h4>
                <p class="text-muted small mb-0">Pantau transaksi masuk, verifikasi bukti transfer, dan kelola sertifikat
                    siswa.</p>
            </div>
        </div>

        {{-- Filter Card --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
            <div class="card-body p-4">
                <form action="/admin/pembayaran" method="get">
                    <div class="row align-items-end">

                        {{-- Input Filter Tanggal --}}
                        <div class="col-lg-5 col-md-6 mb-3 mb-lg-0">
                            <label class="font-weight-bold text-dark small mb-2"><i class="bx bx-calendar mr-1"></i> Rentang
                                Tanggal Transaction</label>
                            <div class="input-group">
                                <input type="date" class="form-control border-right-0" value="{{ $param['date'][0] }}"
                                    name="param_date_start" style="border-radius: 10px 0 0 10px;">
                                <div class="input-group-append">
                                    <span
                                        class="input-group-text bg-light text-muted border-left-0 border-right-0">s/d</span>
                                </div>
                                <input type="date" class="form-control border-left-0" value="{{ $param['date'][1] }}"
                                    name="param_date_end" style="border-radius: 0 10px 10px 0;">
                            </div>
                        </div>

                        {{-- Filter Checkbox Status --}}
                        <div class="col-lg-4 col-md-6 mb-3 mb-lg-0">
                            <label class="font-weight-bold text-dark small mb-2 d-block"><i
                                    class="bx bx-filter-alt mr-1"></i> Filter Status Payment</label>
                            <div class="d-flex align-items-center pt-1">
                                <div class="custom-control custom-checkbox mr-4">
                                    <input type="checkbox" class="custom-control-input" id="checkBelumLunas"
                                        name="param_checked_lunas[]" value="0"
                                        {{ in_array(0, $param['status']) ? 'checked' : '' }}>
                                    <label class="custom-control-label small text-secondary font-weight-bold"
                                        for="checkBelumLunas">Belum Lunas</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkLunas"
                                        name="param_checked_lunas[]" value="1"
                                        {{ in_array(1, $param['status']) ? 'checked' : '' }}>
                                    <label class="custom-control-label small text-secondary font-weight-bold"
                                        for="checkLunas">Lunas</label>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Submit / Reset --}}
                        <div class="col-lg-3 col-md-12">
                            <div class="row no-gutters">
                                <div class="col-8 pr-1">
                                    <button
                                        class="btn btn-primary btn-block font-weight-bold d-flex align-items-center justify-content-center"
                                        type="submit"
                                        style="border-radius: 10px; background: #4f46e5; border: none; height: 42px;">
                                        <i class="bx bx-search mr-1 font-size-18"></i> Cari
                                    </button>
                                </div>
                                <div class="col-4 pl-1">
                                    <a href="/admin/pembayaran"
                                        class="btn btn-light btn-block font-weight-bold text-muted d-flex align-items-center justify-content-center"
                                        style="border-radius: 10px; height: 42px;">
                                        Reset
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- Tabel Data Pembayaran --}}
        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 16px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="tblPembayaran" class="table table-hover align-middle mb-0" style="width:100%;">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="border-top-0 pl-4" style="width: 50px;">#</th>
                                <th class="border-top-0">Status</th>
                                <th class="border-top-0">No Invoice</th>
                                <th class="border-top-0">Bukti Transfer</th>
                                <th class="border-top-0">Total Harga</th>
                                <th class="border-top-0">Tanggal Kelas</th>
                                <th class="border-top-0">Modul Kelas</th>
                                <th class="border-top-0">Kategori</th>
                                <th class="border-top-0">Nama User</th>
                                <th class="border-top-0 text-center">Cetak</th>
                                <th class="border-top-0 text-center pr-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="small text-dark">
                            @foreach ($pembayaran as $key => $p)
                                <tr>
                                    <td class="pl-4 font-weight-bold align-middle">{{ $key + 1 }}</td>

                                    {{-- Status Badge --}}
                                    <td class="align-middle">
                                        @if (!$p->file && $p->status == 0)
                                            <span class="badge badge-soft-danger px-2 py-1 font-weight-bold"><i
                                                    class="bx bx-x-circle mr-1"></i>Belum Lunas</span>
                                        @elseif ($p->file && $p->status == 0)
                                            <span class="badge badge-soft-warning px-2 py-1 font-weight-bold"><i
                                                    class="bx bx-time-five mr-1"></i>Diproses</span>
                                        @else
                                            <span class="badge badge-soft-success px-2 py-1 font-weight-bold"><i
                                                    class="bx bx-check-circle mr-1"></i>Lunas</span>
                                        @endif
                                    </td>

                                    <td class="align-middle font-weight-bold text-primary">{{ $p->no_invoice }}</td>

                                    {{-- Preview Bukti --}}
                                    <td class="align-middle">
                                        @if ($p->file)
                                            <a class="grid-item" href="/getBerkas?rf={{ $p->file }}" target="_blank"
                                                data-lightbox="gallery-item">
                                                <img src="/getBerkas?rf={{ $p->file }}"
                                                    class="rounded border shadow-sm" width="60" height="40"
                                                    style="object-fit: cover;">
                                            </a>
                                        @else
                                            <span class="text-muted font-italic">- Tidak Ada -</span>
                                        @endif
                                    </td>

                                    <td class="align-middle font-weight-bold text-dark">
                                        {{ numfmt_format_currency(numfmt_create('id_ID', \NumberFormatter::CURRENCY), $p->price_final, 'IDR') }}
                                    </td>

                                    <td class="align-middle">
                                        @if (Carbon\Carbon::parse($p->date_start)->format('d-m-Y') == Carbon\Carbon::parse($p->date_end)->format('d-m-Y'))
                                            {{ Carbon\Carbon::parse($p->date_start)->format('d/m/Y') }}
                                        @else
                                            {{ Carbon\Carbon::parse($p->date_start)->format('d/m/Y') }} <br>
                                            <small class="text-muted">s/d
                                                {{ Carbon\Carbon::parse($p->date_end)->format('d/m/Y') }}</small>
                                        @endif
                                    </td>

                                    <td class="align-middle text-truncate" style="max-width: 160px;"
                                        title="{{ $p->title }}">
                                        {{ $p->title }}
                                    </td>
                                    <td class="align-middle"><span
                                            class="badge badge-light border text-secondary">{{ $p->category }}</span>
                                    </td>
                                    <td class="align-middle font-weight-bold">{{ $p->name }}</td>
                                    <td class="align-middle text-center">
                                        @if ($p->sudah_cetak == 1)
                                            <span class="badge badge-soft-info"><i class="bx bx-check"></i> Sudah</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    {{-- Tombol Aksi --}}
                                    <td class="align-middle pr-4 text-center">
                                        <div class="btn-group shadow-sm" role="group"
                                            style="border-radius: 8px; overflow: hidden;">

                                            {{-- Undo Cetak --}}
                                            @if ($p->sudah_cetak == 1)
                                                <button class="btn btn-sm btn-light border-0 text-warning bs-tooltip"
                                                    title="Undo Status Cetak"
                                                    onclick="cancelsudahcetak({{ $p->id }},{{ $p->sudah_cetak }})">
                                                    <i class='bx bx-undo font-size-16'></i>
                                                </button>
                                            @endif

                                            {{-- Certificate Status --}}
                                            @if ($p->status == 1)
                                                @if ($p->certificate == 1)
                                                    <button class="btn btn-sm btn-light border-0 text-warning bs-tooltip"
                                                        title="Unpublish Certificate"
                                                        onclick="publichCertificate({{ $p->id }},{{ $p->certificate }})">
                                                        <i class='bx bxs-file-doc font-size-16'></i>
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-light border-0 text-success bs-tooltip"
                                                        title="Publish Certificate"
                                                        onclick="publichCertificate({{ $p->id }},{{ $p->certificate }})">
                                                        <i class='bx bxs-file-doc font-size-16'></i>
                                                    </button>
                                                @endif

                                                {{-- Batal Lunas --}}
                                                <button class="btn btn-sm btn-light border-0 text-danger bs-tooltip"
                                                    title="Batal Lunas"
                                                    onclick="approved('{{ $p->no_invoice }}',{{ $p->status }})">
                                                    <i class='bx bx-x-circle font-size-16'></i>
                                                </button>
                                            @else
                                                {{-- Set Lunas --}}
                                                <button class="btn btn-sm btn-light border-0 text-success bs-tooltip"
                                                    title="Set Lunas"
                                                    onclick="approved('{{ $p->no_invoice }}',{{ $p->status }})">
                                                    <i class='bx bx-check-circle font-size-16'></i>
                                                </button>
                                            @endif

                                            {{-- Edit Bukti --}}
                                            <button class="btn btn-sm btn-light border-0 text-primary bs-tooltip"
                                                title="Edit Bukti Transfer"
                                                onclick="updatebukti('{{ json_encode($p) }}')">
                                                <i class='bx bx-edit-alt font-size-16'></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <form action="#" method="post" id="formpembayaran">
                        @csrf
                        <input type="text" name="id" id="id" hidden>
                        <input type="text" name="certificate" id="certificate" hidden>
                        <input type="text" name="status" id="status" hidden>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal Update Bukti Transfer --}}
        <div class="modal fade" id="cardupdateprofile" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title font-weight-bold text-dark" id="modalLabel">
                            <i class="bx bx-upload text-primary mr-1"></i> Update Bukti Transfer
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/admin/pembayaran/updatebukti" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body py-4">
                            <input type="text" name="idpembayaran" id="idpembayaran" hidden>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-muted small mb-2">Upload File Foto Bukti Baru</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="foto" id="foto"
                                        accept="image/*" onchange="loadFile(event)" required>
                                    <label class="custom-file-label" for="foto">Pilih berkas gambar...</label>
                                </div>
                            </div>

                            <div class="text-center mt-3 p-3 bg-light rounded border" style="border-radius: 12px;">
                                <label class="d-block text-muted small mb-2">Pratinjau Gambar:</label>
                                <img id="output" class="img-fluid rounded border shadow-sm"
                                    style="max-height: 250px; width: auto;">
                            </div>
                        </div>
                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-light font-weight-bold" data-dismiss="modal"
                                style="border-radius: 10px;">Batal</button>
                            <button class="btn btn-primary font-weight-bold px-4" type="submit"
                                style="border-radius: 10px; background: #4f46e5; border: none;">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('custom-js')
    <script>
        createDataTable('#tblPembayaran');

        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src)
            }
        };

        function updatebukti(params) {
            let j = typeof params === 'string' ? JSON.parse(params) : params;
            $('#cardupdateprofile').modal('show');
            $('#idpembayaran').val(j.id);
            if (j.file) {
                $('#output').attr('src', '/getBerkas?rf=' + j.file);
            } else {
                $('#output').attr('src', '');
            }
        }

        function viewimage(image) {
            swal.fire({
                imageUrl: '/image/' + image,
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'Bukti Pembayaran',
                animation: false,
                padding: '2em'
            })
        }

        function approved(id, status) {
            var s = {
                title: 'Konfirmasi Status?',
                text: "Tandai pembayaran ini sebagai Lunas!",
                type: 'info',
                showCancelButton: true,
                confirmButtonText: 'Ya, Proses',
                cancelButtonText: 'Batal',
                padding: '2em'
            }
            if (status == 1) {
                s = {
                    title: 'Konfirmasi Batalkan Lunas?',
                    text: "Tandai pembayaran ini kembali menjadi Belum Lunas!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Batalkan',
                    cancelButtonText: 'Batal',
                    padding: '2em'
                }
            }
            swal(s).then(function(result) {
                if (result.value) {
                    $('#formpembayaran').attr('action', '/admin/pembayaran/approved');
                    $('#id').val(id);
                    $('#status').val(status);
                    $('#formpembayaran').submit();
                }
            })
        }

        function publichCertificate(id, certificate) {
            var s = {
                title: 'Publikasi Sertifikat?',
                text: "Terbitkan sertifikat untuk user ini!",
                type: 'info',
                showCancelButton: true,
                confirmButtonText: 'Ya, Terbitkan',
                cancelButtonText: 'Batal',
                padding: '2em'
            }
            if (certificate == 1) {
                s = {
                    title: 'Batalkan Sertifikat?',
                    text: "Sembunyikan sertifikat untuk user ini!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Sembunyikan',
                    cancelButtonText: 'Batal',
                    padding: '2em'
                }
            }
            swal(s).then(function(result) {
                if (result.value) {
                    $('#formpembayaran').attr('action', '/admin/pembayaran/certificate');
                    $('#id').val(id);
                    $('#certificate').val(certificate);
                    $('#formpembayaran').submit();
                }
            })
        }

        function cancelsudahcetak(id, certificate) {
            var s = {
                title: 'Reset Status Cetak?',
                text: "Ubah status cetak menjadi 0, user dapat memilih ulang opsi cetak.",
                type: 'info',
                showCancelButton: true,
                confirmButtonText: 'Ya, Reset',
                cancelButtonText: 'Batal',
                padding: '2em'
            }
            swal(s).then(function(result) {
                if (result.value) {
                    $('#formpembayaran').attr('action', '/admin/pembayaran/setsudahcetak');
                    $('#id').val(id);
                    $('#certificate').val(certificate);
                    $('#formpembayaran').submit();
                }
            })
        }
    </script>
@endsection
