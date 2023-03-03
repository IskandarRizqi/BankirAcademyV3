{{-- <div class="row">
    <div class="col-lg-6">
        <form action="/profile#tab-feeds" method="get">
            <label>Tanggal Pembayaran</label>
            <div class="input-group mb-4">
                <input type="date" class="form-control" value="{{ $param['date'][0] }}" placeholder="Date Start"
                    aria-label="Date Start" name="param_date_start">
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon5">s/d</span>
                </div>
                <input type="date" class="form-control" value="{{ $param['date'][1] }}" placeholder="Date End"
                    aria-label="Date End" name="param_date_end">
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <button class="btn btn-primary btn-block" type="submit">Cari</button>
                </div>
                <div class="col-lg-4">
                    <a href="/profile#tab-feeds" class="btn btn-warning btn-block" type="button">Reset</a>
                </div>
            </div>
        </form>
    </div>
</div> --}}
<form action="loker" method="POST" enctype="multipart/form-data">
    <fieldset class="border p-2">
@csrf
<input type="text" name="loker_id" id="loker_id" hidden>
<input type="text" name="status" id="status" hidden>
    <legend class="w-auto">Form Loker</legend>
<div class="row border-2">
    <div class="col-lg-6">
        <div class="form-group">
            <label for="">Title</label>
            <input type="text" name="loker_title" id="loker_title" class="form-control">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Minimal Gaji</label>
            <input type="number" name="loker_gaji_min" id="loker_gaji_min" class="form-control">
            <small id="labelgajimin"></small>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Maksimal Gaji</label>
            <input type="number" name="loker_gaji_max" id="loker_gaji_max" class="form-control">
            <small id="labelgajimax"></small>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label for="">Deskripsi</label>
            <textarea name="loker_deskripsi" id="loker_deskripsi" cols="30" rows="5" class="form-control"></textarea>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label for="">Jobdesk</label>
            <textarea name="loker_jobdesk" id="loker_jobdesk" cols="30" rows="5" class="form-control"></textarea>
        </div>
    </div>
    <div class="col-lg-12 d-flex">
        <div class="form-group">
            <label for="">Tanggal Awal</label>
            <input type="date" name="loker_tanggal_awal" id="loker_tanggal_awal" class="form-control">
        </div>
        <div class="form-group ml-2">
            <label for="">Tanggal Akhir</label>
            <input type="date" name="loker_tanggal_akhir" id="loker_tanggal_akhir" class="form-control">
        </div>
        <div class="form-group ml-2">
            <label for="">Skill</label><br>
            <select name="loker_skill[]" id="loker_skill" class="form-control" multiple>
                <option value="">Pilih Skill</option>
                @if($lokerskill)
                @foreach(json_decode($lokerskill[0]) as $key => $va)
                <option value="{{$va}}">{{$va}}</option>
                @endforeach
                @endif
            </select>
        </div>
        <div class="form-group ml-2">
            <label for="">type</label><br>
            <select name="loker_type[]" id="loker_type" class="form-control" multiple>
                <option value="">Pilih Type</option>
                @if($lokertype)
                @foreach(json_decode($lokertype[0]) as $key => $val)
                <option value="{{$val}}">{{$val}}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
<div class="d-flex">
    <span class="btn btn-secondary" id="loker_reset" onclick="kosong()">Reset</span>
    <button type="submit" class="btn btn-primary ml-2">Simpan</button>
</div>
</fieldset>
</form>
<div class="table-responsive">
    <table id="datatable2" class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Title</th>
                <th>Gaji Min</th>
                <th>Gaji Max</th>
                <th>Skill</th>
                <th>Type</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loker as $key => $value)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$value->title}}</td>
                    <td>Rp. {{number_format($value->gaji_min)}}</td>
                    <td>Rp. {{number_format($value->gaji_max)}}</td>
                    <td>@foreach(json_decode($value->skill) as $key => $v)
                        <span class="badge badge-info">{{$v}}</span>
                    @endforeach
                    </td>
                    <td>@foreach(json_decode($value->type) as $key => $va)
                        <span class="badge badge-info">{{$va}}</span>
                    @endforeach
                    </td>
                    <td>
                        <span class="btn btn-warning btn-sm" title="Edit" onclick="editloker({{$value}})"><i class="icon-edit"></i></span>
                        <span class="btn btn-danger btn-sm" title="Delete" onclick="deleteloker({{$value->id}})"><i class="icon-trash"></i></span>
                        <form action="#" method="post" id="formdelloker">@csrf @method('DELETE')
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Participant-->
{{-- <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/classes/review" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h3>Review</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" id="participant_id" name="participant_id" hidden>
                    <div class="col-lg-12">
                        <label>Nilai = </label><span id="nilai_val"></span><br>
                        <input type="range" class="form-range form-control p-0" id="nilai" name="nilai"
                            value="{{ old('nilai') }}" min="1" max="5">
                        @error('nilai')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-12 bottommargin">
                        <label>Pesan</label><br>
                        <textarea name="review" id="review" cols="30" rows="10" class="form-control"></textarea>
                        @error('input2')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btnReview">Save
                        changes</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}
<script>
    $(document).ready(function () {
        $('#loker_skill').select2({
            placeholder: 'Input or Select',
            tags:true
        });
        $('#loker_type').select2({
            placeholder: 'Input or Select',
            tags:true
        });

        $('#loker_gaji_min').on('change',function () {
            let v = $('#loker_gaji_min').val();
            let uang = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(v);
            $('#labelgajimin').html(uang);
        })
        $('#loker_gaji_max').on('change',function () {
            let v = $('#loker_gaji_max').val();
            let uang = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(v);
            $('#labelgajimax').html(uang);
        })
    })
    function kosong() {
        $('#status').val(null)
        $('#loker_id').val(null)
        $('#loker_title').val(null)
        $('#loker_gaji_min').val(null)
        $('#loker_gaji_max').val(null)
        $('#loker_deskripsi').val(null)
        $('#loker_jobdesk').val(null)
        $('#loker_tanggal_awal').val(null)
        $('#loker_tanggal_akhir').val(null)
        $('#loker_skill').val(null)
        $('#loker_type').val(null)
        $('#loker_skill').trigger('change')
        $('#loker_type').trigger('change')
    }
    function editloker(data) {
        kosong();
        $('#status').val(data.status)
        $('#loker_id').val(data.id)
        $('#loker_title').val(data.title)
        $('#loker_gaji_min').val(data.gaji_min)
        $('#loker_gaji_max').val(data.gaji_max)
        $('#loker_gaji_min').change()
        $('#loker_gaji_max').change()
        $('#loker_deskripsi').val(data.deskripsi)
        $('#loker_jobdesk').val(data.jobdesk)
        $('#loker_tanggal_awal').val(data.tanggal_awal)
        $('#loker_tanggal_akhir').val(data.tanggal_akhir)
        $('#loker_skill').val(JSON.parse(data.skill))
        $('#loker_type').val(JSON.parse(data.type))
        $('#loker_skill').trigger('change')
        $('#loker_type').trigger('change')
    }
    function deleteloker(id) {
		new swal({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Delete',
			padding: '2em'
		}).then(function(result) {
			if (result.value) {
				$('#formdelloker').attr('action','/loker/'+id);
				$('#formdelloker').submit();
			}else{
				$('#formdelloker').attr('action','#');
			}
		})
	}
</script>