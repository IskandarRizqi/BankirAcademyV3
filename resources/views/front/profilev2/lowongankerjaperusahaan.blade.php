<style>
    .custom-loading-1 {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(16, 16, 16, 0.5);
    }
</style>
<div class="custom-loading-1" hidden></div>
<div class="container">
    <form class="mb-4" action="/loker-front" method="POST" enctype="multipart/form-data">
        <fieldset class="border p-2">
            @csrf
            <input type="text" name="loker_id" id="loker_id" hidden>
            <legend class="w-auto">Form Loker</legend>
            <div class="row border-2">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Title</label>
                        @error('loker_title')
                        <small class="text-danger">Harus Diisi</small>
                        @enderror
                        <input type="text" name="loker_title" id="loker_title" class="form-control"
                            value="{{old('loker_title')}}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Minimal Gaji</label>
                        @error('loker_gaji_min')
                        <small class="text-danger">Harus Diisi</small>
                        @enderror
                        <input type="text" name="loker_gaji_min" id="loker_gaji_min" class="form-control"
                            value="{{old('loker_gaji_min')}}">
                        <small id="labelgajimin"></small>
                    </div>
                </div>
                <div class="form-group col-lg-3">
                    <label for="">Tanggal Awal</label>
                    @error('loker_tanggal_awal')
                    <small class="text-danger">Harus Diisi</small>
                    @enderror
                    <input type="date" name="loker_tanggal_awal" id="loker_tanggal_awal" class="form-control"
                        value="{{old('loker_tanggal_awal')}}">
                </div>
                <div class="form-group col-lg-3">
                    <label for="">Tanggal Akhir</label>
                    @error('loker_tanggal_akhir')
                    <small class="text-danger">Harus Diisi</small>
                    @enderror
                    <input type="date" name="loker_tanggal_akhir" id="loker_tanggal_akhir" class="form-control"
                        value="{{old('loker_tanggal_akhir')}}">
                </div>
                <div class="form-group col-lg-3">
                    <label for="">Skill</label>
                    @error('loker_skill')
                    <small class="text-danger">Harus Diisi</small>
                    @enderror
                    <br>
                    <select name="loker_skill[]" id="loker_skill" class="form-control" multiple>
                        @if($lokerskill)
                        @foreach($lokerskill as $key => $va)
                        <option value="{{$va}}" @if(old('loker_skill')) @foreach(old('loker_skill') as $key=> $v)
                            {{$v == $va ? 'selected' : ''}}
                            @endforeach @endif>{{$va}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="">type</label>
                    @error('loker_type')
                    <small class="text-danger">Harus Diisi</small>
                    @enderror
                    <br>
                    <select name="loker_type[]" id="loker_type" class="form-control" multiple>
                        @if($lokertype)
                        @foreach($lokertype as $key => $val)
                        <option value="{{$val}}" @if(old('loker_type')) @foreach(old('loker_type') as $key=> $v)
                            {{$v == $val ? 'selected' : ''}}
                            @endforeach
                            @endif
                            >{{$val}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Deskripsi</label>
                        @error('loker_deskripsi')
                        <small class="text-danger">Harus Diisi</small>
                        @enderror
                        <textarea name="loker_deskripsi" id="loker_deskripsi" cols="30" rows="5"
                            class="form-control">{{old('loker_deskripsi')}}</textarea>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Jobdesk</label>
                        @error('loker_jobdesk')
                        <small class="text-danger">Harus Diisi</small>
                        @enderror
                        <textarea name="loker_jobdesk" id="loker_jobdesk" cols="30" rows="5"
                            class="form-control">{{old('loker_jobdesk')}}</textarea>
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
        <table class="table table-bordered" id="datatable5">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Gaji</th>
                    <th>Tanggal</th>
                    <th>Skill</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loker as $key => $value)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$value->title}}</td>
                    <td>{{$value->gaji_min}}</td>
                    <td>{{$value->tanggal_custom}}</td>
                    <td>
                        @if($value->skill)
                        @foreach(json_decode($value->skill) as $key => $v)
                        <span class="badge badge-info">{{$v}}</span>
                        @endforeach
                        @endif
                    </td>
                    <td>
                        @if($value->type)
                        @foreach(json_decode($value->type) as $key => $va)
                        <span class="badge badge-info">{{$va}}</span>
                        @endforeach
                        @endif
                    </td>
                    <td>
                        {{$value->status==1?'ACC':'Belum Acc'}}
                    </td>
                    <td>
                        <span class="btn btn-warning btn-sm" onclick="edit({{$value}})">Edit</span>
                        <span class="btn btn-danger btn-sm" onclick="busak({{$value}})">Hapus</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    var loker_deskripsi = CKEDITOR.replace("loker_deskripsi");
    var loker_jobdesk = CKEDITOR.replace("loker_jobdesk");
    $('#loker_type').select2({
        placeholder: 'Input or Select',
        tags:true,
        allowClear:true,
    });
    $('#loker_skill').select2({
        placeholder: 'Input or Select',
        tags:true,
        allowClear:true,
    });
    function edit(p) {
        let t = [];
        let s = [];
        if (p.type) {
            t = JSON.parse(p.type);
        }
        if (p.skill) {
            s = JSON.parse(p.skill);
        }
        $('#loker_type').val(t).trigger('change');
        $('#loker_skill').val(s).trigger('change');
        $('#loker_tanggal_awal').val(p.tanggal_awal);
        $('#loker_tanggal_akhir').val(p.tanggal_akhir);
        loker_deskripsi.setData(p.deskripsi)
        loker_jobdesk.setData(p.jobdesk)
        $('#loker_title').val(p.title);
        $('#loker_gaji_min').val(p.gaji_min);
        $('#loker_id').val(p.id);
    }
    function kosong() {
        $('#loker_type').val(null).trigger('change');
        $('#loker_skill').val(null).trigger('change');
        $('#loker_tanggal_awal').val(null);
        $('#loker_tanggal_akhir').val(null);
        $('#loker_jobdesk').val(null);
        $('#loker_deskripsi').val(null);
        $('#loker_title').val(null);
        $('#loker_gaji_min').val(null);
        $('#loker_id').val(null);
    }
</script>