@extends('backend.template')
@section('content')
    @if (Session::get('success'))
        <div class="alert alert-dismissible alert-success">
            <i class="icon-gift"></i><strong>Success!</strong>
            {{ Session::get('success') }}
            {{-- <button type="button" class="btn btn-close btn-sm" data-bs-dismiss="alert" aria-hidden="true">x</button> --}}
        </div>
    @endif
    @if (Session::get('error'))
        <div class="alert alert-dismissible alert-danger">
            <i class="icon-gift"></i><strong>Failed!</strong>
            {{ Session::get('error') }}
            {{-- <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-hidden="true"></button> --}}
        </div>
    @endif
    <div class="col-lg-12">
        <div class="widget">
            <div class="widget-content">
                <div class="table-responsive">
                    <table id="tblPeserta" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Nama</th>
                                <th>No HP</th>
                                <th>Kelas</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peserta as $key => $p)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $p->name }}</td>
                                    <td>{{ $p->phone ? $p->phone : '' }}</td>
                                    <td>{{ $p->title }}</td>
                                    <td>{{ \Carbon\Carbon::parse($p->created_at)->format('d-m-Y') }}</td>
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
        createDataTable('#tblPeserta');
    </script>
@endsection
