@extends('backend.template')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="applytable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pelamar</th>
                            <th>Nama Bank</th>
                            <th>Link</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key => $v)
                        <td>{{$key+1}}</td>
                        <td>{{$v->user->name}}</td>
                        <td>{{$v->lamaran->nama}}</td>
                        <td><a href="/loker/{{$v->lamaran->id}}/detail">Detail</a></td>
                        <td>{{$v->status_name}}</td>
                        <td>
                            <button class="btn btn-info btn-sm" onclick="opencv({{$v}})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    style="fill: rgb(255, 255, 255);transform: ;msFilter:;">
                                    <path
                                        d="M21 11h-3V4a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v14c0 1.654 1.346 3 3 3h14c1.654 0 3-1.346 3-3v-6a1 1 0 0 0-1-1zM5 19a1 1 0 0 1-1-1V5h12v13c0 .351.061.688.171 1H5zm15-1a1 1 0 0 1-2 0v-5h2v5z">
                                    </path>
                                    <path d="M6 7h8v2H6zm0 4h8v2H6zm5 4h3v2h-3z"></path>
                                </svg>
                            </button>
                        </td>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Curriculum Vitae</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{-- --}}
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-info btn-sm" href="" id="sendemail">Send Email</a>
                            <span type="button" class="btn btn-primary btn-sm">Save</span>
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
    createDataTable('#applytable')
    function opencv(p) {
        console.log(p);
        $('#exampleModal').modal('show');
        $('#sendemail').attr('href','mailto:'+p.lamaran.email);
    }
</script>
@endsection