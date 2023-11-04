@extends('backend.template')
@section('content')
<div class="col-lg-12">
    <div class="widget">
        <div class="widget-content">
            {{-- <form action="/admin/user" method="POST" enctype="multipart/form-data">
                @csrf
                <input name="id" id="id" value="{{old('id')}}" hidden>
                <div class="row">
                    <div class="form-group col">
                        <label for="">Tanggal Mulai</label>
                        <input type="date" name="tgl_mulai" id="tgl_mulai" value="{{old('tgl_mulai')}}"
                            class="form-control">
                        @error('tgl_mulai')
                        <small class="text-danger">Harus Diisi</small>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label for="">Tanggal Selesai</label>
                        <input type="date" name="tgl_selesai" id="tgl_selesai" value="{{old('tgl_selesai')}}"
                            class="form-control">
                        @error('tgl_selesai')
                        <small class="text-danger">Harus Diisi</small>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label for="">Kode user</label>
                        <input type="text" name="kode" id="kode" value="{{old('kode')}}" class="form-control">
                        @error('kode')
                        <small class="text-danger">Harus Diisi</small>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label for="">Nominal (%)</label>
                        <input type="number" step="any" name="nominal" id="nominal" value="{{old('nominal')}}"
                            class="form-control">
                        @error('nominal')
                        <small class="text-danger">Harus Diisi</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label>Image: <b class="text-danger">*</b></label>
                        <input type="file" class="form-control" name="image" id="image" accept="image/*">
                        <img src="/Backend/assets/img/90x90.jpg" alt="Image Preview" id="prvImage" class="previewImage"
                            style="max-width: 100%;max-height:97px;">
                        @error('image')
                        <small class="text-danger">Harus Diisi</small>
                        @enderror
                    </div>
                </div>
                <button class="btn btn-primary">Simpan</button>
                <span class="btn btn-danger" id="reset" onclick="reset()">Reset</span>
            </form> --}}
            <div class="table-responsive">
                <table id="tbluser" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Corporate</th>
                            <th>No HP</th>
                            <th>Member</th>
                            <th>Masa Aktif Member</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $key=> $p)
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
                            @if($p->profile)
                            <td>{{$p->profile->phone_region}}{{$p->profile->phone}}</td>
                            <td>
                                @if($p->profile->status_membership == 1)
                                Aktif
                                @elseif($p->profile->status_membership == 2)
                                Proses
                                @else
                                Tidak Aktif
                                @endif
                            </td>
                            <td>{{$p->profile->masa_aktif_membership}}</td>
                            <td>
                                {{-- <button class="btn btn-warning" id="edit" title="Edit"
                                    onclick="edituser('{{$p}}')"><i class='bx bx-edit'></i></button>
                                <button class="btn btn-danger" onclick="deleteuser({{$p->id}})" title="Delete"> <i
                                        class='bx bx-trash'></i></button>
                                <form action="#" method="post" id="formdeluser">@csrf @method('DELETE')
                                </form> --}}
                                <button class="btn btn-info btn-sm" onclick="member({{$p}})">Member</button>
                            </td>
                            @else
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <form action="#" method="post" id="formuser">@csrf <input type="text" name="id" id="id" hidden>
                    <input type="text" name="certificate" id="certificate" hidden>
                    <input type="text" name="status" id="status" hidden>
                </form>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="user" method="POST">
                                @csrf
                                <input type="text" id="user_id" name="user_id" hidden>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Membership</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <a href="" id="imagelink">
                                                <img src="" alt="" id="imagemembership" width="100%">
                                            </a>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="">Status</label>
                                            <select name="status_membership" id="status_membership"
                                                class="form-control">
                                                <option value="0">Tidak AKtif</option>
                                                <option value="1">Aktif</option>
                                                <option value="2">Proses</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="">Masa AKtif</label>
                                            <input type="date" name="masa_aktif_membership" id="masa_aktif_membership"
                                                class="form-control" />
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
    $('#image').change(function (e) { 
		getImgData(this,'#prvImage');
	});
    $('#kelas').select2({
			tags: true,
		});
        function deleteuser(id) {
		swal({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Delete',
			padding: '2em'
		}).then(function(result) {
			if (result.value) {
				$('#formdeluser').attr('action','/admin/user/'+id);
				$('#formdeluser').submit();
			}else{
				$('#formdeluser').attr('action','#');
			}
		})
	}
    function edituser(data) {
        let j = JSON.parse(data)
        console.log(j.profile.phone);
    }
    function reset() {
        $('#id').val(null);
        $('#tgl_mulai').val(null);
        $('#tgl_selesai').val(null);
        $('#kode').val(null);
        $('#nominal').val(null);
        $("#kelas").val(null).trigger('change');
        
    }
    function member(d) {
        $('#exampleModal').modal('show');
        $('#imagemembership').attr('src','/'+d.profile.image_bukti_pembayaran);
        $('#imagelink').attr('href','/'+d.profile.image_bukti_pembayaran);
        $('#masa_aktif_membership').val(d.profile.masa_aktif_membership);
        $('#status_membership').val(d.profile.status_membership);
        $('#user_id').val(d.profile.id);
    }
</script>
@endsection