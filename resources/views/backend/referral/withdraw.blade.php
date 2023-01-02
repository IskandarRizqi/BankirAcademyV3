@extends('backend.template')
@section('content')
<div class="col-lg-12">
    <div class="widget">
        <div class="widget-content">
            <div class="table-responsive">
                <table id="tblwithdraw" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Status</th>
                            <th>Tanggal Permohonan</th>
                            <th>Nama Bank</th>
                            <th>No Rekening</th>
                            <th>Nominal</th>
                            <th>Nama Member</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $d )
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>
                                @switch($d->status)
                                @case(0)
                                Permohonan
                                @break
                                @case(1)
                                Proses
                                @break
                                @case(2)
                                Gagal
                                @break
                                @case(3)
                                Selesai
                                @break
                                Tidak Ditemukan
                                @endswitch
                            </td>
                            <td>{{\Carbon\Carbon::parse($d->date)->format('d-m-Y')}}</td>
                            <td>{{$d->nama_bank}}</td>
                            <td>{{$d->no_rekening}}</td>
                            <td>Rp. {{number_format($d->acc_amount?$d->acc_amount:$d->amount)}}</td>
                            <td>{{$d->name}}</td>
                            <td>
                                <span class="btn btn-warning btn-sm" onclick="editWithdraw('{{$d}}')">
                                    Edit
                                </span>
                                {{-- <span class="btn btn-info btn-sm">
                                    Detail
                                </span> --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalWithdraw" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Withdraw</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="formWithdraw">
                        @csrf
                        <input name="user_id" id="user_id" class="form-control" hidden>
                        <div class="row">
                            <div class="form-group col">
                                <label for="">Nama Bank (Ulang)</label>
                                <input type="text" name="nama_bank" id="nama_bank" class="form-control" readonly>
                            </div>
                            <div class="form-group col">
                                <label for="">No Rekening (Ulang)</label>
                                <input type="number" name="no_rekening" id="no_rekening" class="form-control" readonly>
                            </div>
                            <div class="form-group col">
                                <label for="">Nominal Penarikan</label>
                                <small id="amount_label"></small>
                                <input type="text" name="nominal_penarikan" id="nominal_penarikan" class="form-control"
                                    readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col">
                                <label for="">Acc Amount</label>
                                <small id="acc_amount_label"></small>
                                <input type="number" name="acc_amount" id="acc_amount" class="form-control" required>
                            </div>
                            <div class="form-group col">
                                <label for="">Keterangan (optional)</label>
                                <input type="text" name="keterangan" id="keterangan" class="form-control">
                                {{-- <textarea name="keterangan" id="keterangan" class="form-control"
                                    required></textarea>
                                --}}
                            </div>
                            <div class="form-group col">
                                <label for="">Status</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="">Pilih</option>
                                    <option value="0">Menunggu</option>
                                    <option value="1">Proses</option>
                                    <option value="2">Gagal</option>
                                    <option value="3">Selesai</option>
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-sm" id="btnsave">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
<script>
    createDataTable('#tblwithdraw');
    $('#acc_amount').on('input', function () {
        let r = $('#acc_amount').val();
        $('#acc_amount_label').html(toRupiah(r));
    })
    function editWithdraw(d){
        let v = JSON.parse(d)
        $('#user_id').val(v.user_id);
        $('#status').val(v.status);
        $('#keterangan').val(v.keterangan);
        $('#acc_amount').val(v.amount);
        $('#acc_amount_label').html(toRupiah(v.amount));
        if (v.acc_amount) {
            $('#acc_amount').val(v.acc_amount);
            $('#acc_amount_label').html(toRupiah(v.acc_amount));
        }
        $('#nominal_penarikan').val(v.amount);
        $('#no_rekening').val(v.no_rekening);
        $('#nama_bank').val(v.nama_bank);
        $('#amount_label').html(toRupiah(v.amount));
        $('#formWithdraw').attr('action','withdraw/'+v.id)
        $('#formWithdraw').attr('method','PUT')
        $('#modalWithdraw').modal('show');
        if (v.status == 3) {
            $('#btnsave').attr('hidden', true)
        }else{
            $('#btnsave').removeAttr('hidden')
        }
        // console.log(toRupiah(v.amount));
    }
</script>
@endsection