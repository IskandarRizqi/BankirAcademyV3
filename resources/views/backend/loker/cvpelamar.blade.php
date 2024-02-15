@extends('backend.template')
@section('content')
<div class="col-lg-12">
    <div class="widget">
        <div class="widget-content">
            <div class="table-responsive">
                <table id="tbluser" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Corporate</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key=> $p)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$p->name}}</td>
                            <td>{{$p->email}}</td>
                            <td>@if($p->corporates)
                                {{$p->corporates->name}}
                                @else
                                Perorangan
                                @endif
                            </td>
                            <td>{{$p->is_approved==1?'Approved':'Belum Approved'}}</td>
                            <td>
                                <a href="/datalamaran?cetak=true&auth_id={{$p->user_id}}">
                                    <button class="btn btn-outline-info btn-sm">Cetak CV</button>
                                </a>
                                <button class="btn btn-outline-info btn-sm" onclick="approveds({{$p}})">Approve
                                    CV</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="/admin/approvecvpelamar" method="POST">
                                @csrf
                                <input type="text" id="id" name="id" hidden>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">CV Pelamar</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="">Approve</label>
                                            <select name="approved" id="approved" class="form-control">
                                                <option value="0">Tidak Approve</option>
                                                <option value="1">Approved</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="">Message</label>
                                            <input name="approved_message" id="approved_message" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-sm" data-dismiss="modal"><i class="flaticon-cancel-12"></i>
                                        Close</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
<script>
    createDataTable('#tbluser');
    function approveds(data) {
        console.log(data);
        $('#exampleModal').modal('show');
        $('#id').val(data.id);
        $('#approved').val(data.is_approved);
        $('#approved_message').val(data.is_approved_message)
    }
</script>
@endsection