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
@if (Auth::user()->email == 'root@root.root')
<button class="btn btn-primary" id="sitemap" onclick="sitemap()">Create Sitemap</button>
@endif
@endsection
@section('custom-js')
<script>
    createDataTable('#tblFee');
    function sitemap() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: "/createSitemap",
            method: 'get',
            success: function(result) {
                // iziToast.success({
                //     title: 'Success',
                //     message: 'Login Berhasil',
                //     position: 'topRight',
                // });
                console.log(result);
            },
            error: function(jqXhr, json, errorThrown) { // this are default for ajax errors
                var errors = jqXhr.responseJSON;
                var errorsHtml = '';
                $.each(errors['errors'], function(index, value) {
                    iziToast.error({
                        title: 'Error',
                        message: value,
                        position: 'topRight',
                    });
                });
            }
        })
    }
</script>
@endsection