@extends('backend.template')
@section('content')
    <div class="col-lg-12">
        <div class="widget">
            <div class="widget-content">
                <div class="row">
                    <div class="col-lg-6">
                        <form action="/admin/pembayaran" method="get">
                            <div class="input-group mb-4">
                                <input type="date" class="form-control" value="{{ $param['date'][0] }}"
                                    placeholder="Date Start" aria-label="Date Start" name="param_date_start">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon5">s/d</span>
                                </div>
                                <input type="date" class="form-control" value="{{ $param['date'][1] }}"
                                    placeholder="Date End" aria-label="Date End" name="param_date_end">
                            </div>
                            <div class="form-group">
                                <label>Status : </label>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="param_checked_lunas[]"
                                            value="0" {{ in_array(0, $param['status']) ? 'checked' : '' }}>
                                        Belum Lunas
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="param_checked_lunas[]"
                                            value="1" {{ in_array(1, $param['status']) ? 'checked' : '' }}>
                                        Lunas
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8">
                                    <button class="btn btn-primary btn-block" type="submit">Cari</button>
                                </div>
                                <div class="col-lg-4">
                                    <a href="/admin/pembayaran" class="btn btn-warning btn-block" type="button">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tblPembayaran" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Status</th>
                                <th>No Invoice</th>
                                <th>Bukti</th>
                                <th>Price</th>
                                <th>Date</th>
                                <th>Class</th>
                                <th>Category</th>
                                <th>User</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembayaran as $key => $p)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        @if (!$p->file && $p->status == 0)
                                            <span class="badge badge-danger text-uppercase">
                                                Belum Lunas
                                            </span>
                                        @elseif ($p->file && $p->status == 0)
                                            <span class="badge badge-secondary text-uppercase">
                                                Sedang Diproses
                                            </span>
                                        @else
                                            <span class="badge badge-primary text-uppercase">
                                                Lunas
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $p->no_invoice }}</td>
                                    <td>
                                        <a class="grid-item" href="/getBerkas?rf={{ $p->file }}" target="_blank"
                                            data-lightbox="gallery-item"><img src="/getBerkas?rf={{ $p->file }}"
                                                width="110px"></a>
                                    </td>
                                    <td>{{ numfmt_format_currency(numfmt_create('id_ID', \NumberFormatter::CURRENCY), $p->price_final, 'IDR') }}
                                    </td>
                                    <td>
                                        @if (Carbon\Carbon::parse($p->date_start)->format('d-m-Y') == Carbon\Carbon::parse($p->date_end)->format('d-m-Y'))
                                            {{ Carbon\Carbon::parse($p->date_start)->format('d-m-Y') }}
                                        @else
                                            {{ Carbon\Carbon::parse($p->date_start)->format('d-m-Y') }}
                                            s/d
                                            {{ Carbon\Carbon::parse($p->date_end)->format('d-m-Y') }}
                                        @endif
                                    </td>
                                    <td class="text-truncate" style="max-width: 150px;" title="{{ $p->title }}">
                                        {{ $p->title }} </td>
                                    <td>{{ $p->category }}</td>
                                    <td>{{ $p->name }}</td>
                                    <td>
                                        @if ($p->status == 1)
                                            @if ($p->certificate == 1)
                                                <button class="btn bs-tooltip btn-warning" title="Unpublish Certificate"
                                                    onclick="publichCertificate({{ $p->id }},{{ $p->certificate }})"><i
                                                        class='bx bxs-file-doc'></i></button>
                                            @else
                                                <button class="btn bs-tooltip btn-success" title="Publish Certificate"
                                                    onclick="publichCertificate({{ $p->id }},{{ $p->certificate }})"><i
                                                        class='bx bxs-file-doc'></i></button>
                                            @endif
                                            <button class="btn bs-tooltip btn-warning" title="Batal Lunas"
                                                onclick="approved({{ $p->id }},{{ $p->status }})"><i
                                                    class='bx bx-wallet'></i></button>
                                        @else
                                            <button class="btn bs-tooltip btn-info" title="Lunas"
                                                onclick="approved({{ $p->id }},{{ $p->status }})"><i
                                                    class='bx bx-wallet'></i></button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <form action="#" method="post" id="formpembayaran">@csrf <input type="text" name="id"
                            id="id" hidden>
                        <input type="text" name="certificate" id="certificate" hidden>
                        <input type="text" name="status" id="status" hidden>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom-js')
    <script>
        createDataTable('#tblPembayaran');

        function viewimage(image) {
            swal.fire({
                imageUrl: '/image/' + image,
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'Custom image',
                animation: false,
                padding: '2em'
            })
        }

        function approved(id, status) {
            var s = {
                title: 'Are you sure?',
                text: "Mark this payment as completed!",
                type: 'info',
                showCancelButton: true,
                confirmButtonText: 'Done',
                padding: '2em'
            }
            if (status == 1) {
                s = {
                    title: 'Are you sure?',
                    text: "Mark this payment as unpaid!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Done',
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
                title: 'Are you sure?',
                text: "Publish certificate for this user!",
                type: 'info',
                showCancelButton: true,
                confirmButtonText: 'Done',
                padding: '2em'
            }
            if (certificate == 1) {
                s = {
                    title: 'Are you sure?',
                    text: "Unublish certificate for this user!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Done',
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
    </script>
@endsection
