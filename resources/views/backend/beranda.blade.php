@extends('backend.template')
@section('content')
<div class="col-lg-12">
    <div class="widget">
        <div class="widget-header">
            <h3>Fee</h3>
        </div>
        <div class="widget-content">
            <div class="table-responsive">
                <table id="tblFee" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Fee</th>
                            <th>Harga Awal</th>
                            <th>Jumlah Peserta</th>
                            <th>Promo</th>
                            <th>Harga Akhir</th>
                            <th>User</th>
                            <th>Title</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fee as $key => $p)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $p->fee }}</td>
                            <td>{{ $p->price_final }}</td>
                            <td>{{ $p->jumlah }} Peserta</td>
                            <td>{{ $p->promo?$p->promo:'0' }}</td>
                            <td>{{ ($p->price_final*$p->jumlah)-$p->promo }}</td>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->title }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
<script>
    createDataTable('#tblFee');
</script>
@endsection