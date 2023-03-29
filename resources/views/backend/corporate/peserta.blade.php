@extends('backend.template')
@section('content')
<div class="col-lg-12">
    <form action="" id="formDinamis" enctype="multipart/form-data">
        @csrf
    </form>
    <div class="widget">
        <div class="widget-content">
            <div class="table-responsive">
                <table id="tblPeserta" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>No HP</th>
                            <th>Kelas</th>
                            <th>Tanggal</th>
                            <th>Existing User</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peserta as $key => $p)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            @if($p->google_id)
                                <td><img src="{{$p->picture}}" alt="" width="100px"></td>
                                @else
                                <td><img src="{{asset($p->picture)}}" alt="" width="100px"></td>
                            @endif
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->phone ? $p->phone : '' }}</td>
                            <td>{{ $p->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->created_at)->format('d-m-Y') }}</td>
                            <td>{{ $p->existing_user?'Existing':'Tidak Existing' }}</td>
                            <td><span class="btn btn-info btn-sm" onclick="existing('{{$p}}')">Existing</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <form action="#" method="post" id="formpembayaran">@csrf <input type="text" name="id" id="id" hidden>
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
    function existing(params) {
        // console.log(JSON.parse(params))
        let js = JSON.parse(params);
        if (!js.profile_id) {
            return alert('Profile ID Tidak Ditemukan');
        }
        swal.fire({
            title: 'Ganti Status Existing?',
            // icon: 'warning',
            showCancelButton: true,
            // confirmButtonColor: '#3085d6',
            // cancelButtonColor: '#d33',
            confirmButtonText: 'Ganti!'
        })
        .then((result) => {
            if (result.value) {
                $('#formDinamis').attr('action','/admin/peserta/change_existing/'+js.profile_id+'/'+js.existing_user);
                $('#formDinamis').attr('method','GET');
                $('#formDinamis').submit();
            }
        });
    }
</script>
@endsection