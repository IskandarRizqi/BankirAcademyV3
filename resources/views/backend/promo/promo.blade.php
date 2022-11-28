@extends('backend.template')
@section('content')
<div class="col-lg-12">
    <div class="widget">
        <div class="widget-content">
            {{-- <div class="row">
                <div class="col-lg-6">
                    <form action="/admin/promo" method="post">
                        @csrf
                        <div class="input-group mb-4">
                            <input type="date" class="form-control" value="" placeholder="Date Start"
                                aria-label="Date Start" name="param_date_start">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon5">s/d</span>
                            </div>
                            <input type="date" class="form-control" value="" placeholder="Date End"
                                aria-label="Date End" name="param_date_end">
                        </div>
                        <div class="form-group">
                            <label>Status : </label>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="param_checked_lunas[]"
                                        value="">
                                    Belum Lunas
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="param_checked_lunas[]"
                                        value="">
                                    Lunas
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <button class="btn btn-primary btn-block" type="submit">Cari</button>
                            </div>
                            <div class="col-lg-4">
                                <a href="/admin/promo" class="btn btn-warning btn-block" type="button">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div> --}}
            <div class="table-responsive">
                <table id="tblpromo" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Kode</th>
                            <th>Tanggal</th>
                            <th>Nominal</th>
                            <th>Kelas</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($promo as $key=> $p)
                        <tr>
                        </tr>
                        @endforeach --}}
                    </tbody>
                </table>
                <form action="#" method="post" id="formpromo">@csrf <input type="text" name="id" id="id" hidden>
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
    createDataTable('#tblpromo');
</script>
@endsection