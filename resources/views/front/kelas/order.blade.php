@include("front.layout.head")
@include("front.layout.topbar")
@include("front.layout.header")
<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">
            <div class="row gutter-40 col-mb-80">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Status</th>
                                <th>Nama Class</th>
                                <th>Expired</th>
                                <th>Price Final</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payment as $key => $d)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td><span class="badge badge-primary">
                                        {{$d->status?'lunas':'belum lunas'}}
                                    </span>
                                </td>
                                <td>{{$d->status}}</td>
                                <td>{{$d->expired}}</td>
                                <td>{{ numfmt_format_currency(numfmt_create('id_ID',
                                    \NumberFormatter::CURRENCY),$d->price_final,"IDR") }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm">Bayar</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@include("front.layout.footer")