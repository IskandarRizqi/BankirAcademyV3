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
                            <td>{{$p->code.' | '.$p->url}}</td>
                            <td>{{$p->name}}</td>
                            <td>
                                <span class="btn btn-info btn-sm" onclick=""></span>
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
</div>
@endsection
@section('custom-js')
<script>
    createDataTable('#tblreferral');
</script>
@endsection