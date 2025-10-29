@extends('backend.template')
@section('content')
<div class="col-lg-12">
    <div class="widget">
        <div class="widget-content">
            <div class="table-responsive">
                <table id="tblreferral" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="8%">Nomor</th>
                            <th>Email</th>
                            <th>Kode Referral</th>
                            <th>Nama</th>
                            <th>Aplicator</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key=> $p)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$p->email}}</td>
                            @if ($p->code)
                            <td>{{$p->code.' | '.$p->url}}</td>
                            @else
                            <td></td>
                            @endif
                            <td>{{$p->name}}</td>
                            <td>
                                <span class="btn btn-info btn-sm" onclick="showAplicator({{$p->aplicator}})"
                                    data-toggle="modal" data-target="#modalAplicator">Lihat</span>
                            </td>
                            {{-- <td>
                                <button class="btn btn-warning" id="edit" title="Edit"
                                    onclick="editPromo('{{$p->id}}','{{$p->tgl_mulai}}','{{$p->tgl_selesai}}','{{$p->kode}}','{{$p->nominal}}','{{$p->class_title}}','{{$p->image}}')"><i
                                        class='bx bx-edit'></i></button>
                                <button class="btn btn-danger" onclick="deletePromo({{$p->id}})" title="Delete"> <i
                                        class='bx bx-trash'></i></button>
                                <form action="#" method="post" id="formdelpromo">@csrf @method('DELETE')
                                </form>
                            </td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <form action="#" method="post" id="formpromo">@csrf <input type="text" name="id" id="id" hidden>
                    <input type="text" name="certificate" id="certificate" hidden>
                    <input type="text" name="status" id="status" hidden>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalAplicator" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">List Aplicator</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Dana</th>
                            </tr>
                        </thead>
                        <tbody id="tabelAplicator">
                            {{-- <tr>
                                <td>No</td>
                                <td>Nama</td>
                                <td>Email</td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
<script>
    createDataTable('#tblreferral');
    function showAplicator(params) {
        // console.log(params);
        let x = '';
        let no = 1;
        let totalDana = 0;
        $('#tabelAplicator').html(x);
        if (params) {
            params.forEach(element => {
                // console.log(element.aplicator.name);
                x+='<tr>';
                x+='<td>'+no+'</td>';
                x+='<td>'+element.aplicator.name+'</td>';
                x+='<td>'+element.aplicator.email+'</td>';
                if (element.total) {
                    x+='<td>'+toRupiah(element.total)+'</td>';
                    totalDana += element.total;
                }else{
                    x+='<td>Rp. 0</td>';
                }
                x+='</td>';
                x+='</tr>';
                no++;
            });
        }
        x+='<tr><td class="text-center" colspan="3">Total Dana</td><td>'+toRupiah(totalDana)+'</td></td>'
        $('#tabelAplicator').html(x);
    }
</script>
@endsection