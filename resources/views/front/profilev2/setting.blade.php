<style>

</style>
<div class="row">
    <div class="col-lg-3">
        <div class="list-group" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action text-capitalize br-10 active" id="list-profile-list"
                data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">profile</a>
            <a class="list-group-item list-group-item-action text-capitalize br-10" id="list-rekening-list"
                data-toggle="list" href="#list-rekening" role="tab" aria-controls="rekening">rekening</a>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="list-profile" role="tabpanel"
                aria-labelledby="list-profile-list">
                @csrf
                <div class="form-group">
                    <label for="">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="profile_nama" id="profile_nama" class="form-control" placeholder="sitejo"
                        value="{{$pfl?$pfl->name:''}}" required>
                </div>
                <div class="form-group">
                    <label for="">No Handphone <span class="text-danger">*</span></label>
                    <input type="number" name="profile_no_hp" id="profile_no_hp" class="form-control"
                        placeholder="08312312313" value="{{$pfl?$pfl->phone:''}}" required>
                </div>
                <div class="form-group">
                    <label for="">Tanggal Lahir <span class="text-danger">*</span></label>
                    <input type="date" name="profile_tgl_lahir" id="profile_tgl_lahir" class="form-control"
                        value="{{$pfl?$pfl->tanggal_lahir:''}}" required>
                </div>
                <div class="form-group">
                    <label for="">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select name="profile_jenis_kelamin" id="profile_jenis_kelamin" class="form-control" required>
                        <option value="">Pilih</option>
                        @if($pfl)
                        <option value="0" {{$pfl->gender==0?'selected':''}}>Perempuan</option>
                        <option value="1" {{$pfl->gender==1?'selected':''}}>Laki - laki</option>
                        @else
                        <option value="0">Perempuan</option>
                        <option value="1">Laki - laki</option>
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Deskripsi <span class="text-danger">*</span></label>
                    <textarea name="profile_alamat" id="profile_alamat" class="form-control"
                        required>{{$pfl?$pfl->description:''}}</textarea>
                </div>
                <div class="form-group">
                    <label for="">Kode Referral (Optional)</label>
                    <input type="text" name="profile_kode_referral" id="profile_kode_referral" class="form-control"
                        {{$reffdisabled?'readonly':''}}value="{{$reffdisabled?$reffdisabled->code:''}}">
                </div>
                <div class="form-group">
                    <label for="">Upload Foto</label>
                    <input type="file" name="profile_gambar" id="profile_gambar" class="form-control"
                        accept="image/png, image/jpeg">
                    <img id="previewImage" src="{{$pfl?$pfl->picture:'/GambarV2/rectangle31.png'}}" alt="" width="80px">
                </div>
                <button type="submit" class="btn btn-primary" id="simpan_profile">Simpan</button>
            </div>
            <div class="tab-pane fade" id="list-rekening" role="tabpanel" aria-labelledby="list-rekening-list">
                <div class="form-group">
                    <label for="">Nama Bank <span class="text-danger">*</span></label>
                    <input type="text" name="profile_nama_bank" id="profile_nama_bank" class="form-control"
                        value="{{$pfl?$pfl->nama_bank:''}}">
                </div>
                <div class="form-group">
                    <label for="">No Rekening <span class="text-danger">*</span></label>
                    <input type="text" name="profile_no_rekening" id="profile_no_rekening" class="form-control"
                        value="{{$pfl?$pfl->rekening:''}}">
                </div>
                <button type="submit" class="btn btn-primary" id="simpan_rekening">Simpan</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#profile_gambar').change(function(e) {
        getImgData(this, '#previewImage');
    });
    $('#simpan_profile').on('click',function () {
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // loader transparant
        Swal.fire({
            background:'#0069d900',
            didOpen:()=>{
                Swal.showLoading();
            }
        })
        var fd = new FormData();
        var gambar = $('#profile_gambar')[0].files[0];
        fd.append('gambar',gambar);
        fd.append('name',$('#profile_nama').val());
        fd.append('no_hp',$('#profile_no_hp').val());
        fd.append('tgl_lahir',$('#profile_tgl_lahir').val());
        fd.append('jenis_kelamin',$('#profile_jenis_kelamin').val());
        fd.append('alamat',$('#profile_alamat').val());
        fd.append('kode_referral',$('#profile_kode_referral').val());
        $.ajax({
            processData: false,
            contentType: false,
            url: '/settingprofile',
            method: 'POST',
            data: fd,
            enctype: 'multipart/form-data',
            success:function(response)
            {
                if (response.status == 1) {
                    let msgreff = 'dan kode refferal tidak ditemukan';
                    if (response.simpanreff == 1) {
                        msgreff = '';
                        $('#profile_kode_referral').attr('readonly',true)
                    }
                    $('#profile_nama').val(response.data.name)
                    $('#profile_no_hp').val(response.data.phone)
                    $('#profile_tgl_lahir').val(response.data.tanggal_lahir)
                    $('#profile_jenis_kelamin').val(response.data.gender)
                    $('#imagebunder').attr('src',response.data.picture)
                    $('#updatedescription').html(response.data.description)
                    $('#updatename').html(response.data.name)
                    $('#profile_gambar').val('');
                    iziToast.success({
                        title: 'Berhasil',
                        message: 'Input Berhasil '+msgreff,
                        position: 'topRight',
                    });
                    Swal.close()
                }
            },
            error: function(response) {
                console.log(response);
                iziToast.warning({
                    title: 'Gagal',
                    message: 'Input Gagal',
                    position: 'topRight',
                });
                Swal.close()
            }
        });
    })
    $('#simpan_rekening').on('click',function () {
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // loader transparant
        Swal.fire({
            background:'#0069d900',
            didOpen:()=>{
                Swal.showLoading();
            }
        })
        $.ajax({
            url: '/rekeningprofile',
            method: 'POST',
            data: {
                nama_bank:$('#profile_nama_bank').val(),
                no_rekening:$('#profile_no_rekening').val(),
            },
            success:function(response)
            {
                if (response.status == 1) {
                    $('#profile_nama_bank').val(response.data.nama_bank)
                    $('#profile_no_rekening').val(response.data.rekening)
                    iziToast.success({
                        title: 'Berhasil',
                        message: 'Input Berhasil',
                        position: 'topRight',
                    });
                    Swal.close()
                }
            },
            error: function(response) {
                console.log(response);
                iziToast.warning({
                    title: 'Gagal',
                    message: 'Input Gagal',
                    position: 'topRight',
                });
                Swal.close()
            }
        });
    })
</script>