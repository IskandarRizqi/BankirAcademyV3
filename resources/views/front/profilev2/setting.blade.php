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
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="profile_nama" id="profile_nama" class="form-control"
                            placeholder="sitejo">
                    </div>
                    <div class="form-group">
                        <label for="">No Handphone <span class="text-danger">*</span></label>
                        <input type="number" name="profile_no_hp" id="profile_no_hp" class="form-control"
                            placeholder="08312312313">
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" name="profile_tgl_lahir" id="profile_tgl_lahir" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="profile_jenis_kelamin" id="profile_jenis_kelamin" class="form-control">
                            <option value="">Pilih</option>
                            <option value="0">Perempuan</option>
                            <option value="1">Laki - laki</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat <span class="text-danger">*</span></label>
                        <textarea name="profile_alamat" id="profile_alamat" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Kode Referral (Optional)</label>
                        <input type="text" name="profile_kode_referral" id="profile_kode_referral" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Upload Foto</label>
                        <input type="file" name="profile_kode_referral" id="profile_kode_referral" class="form-control">
                        <div id="previewImage"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
            <div class="tab-pane fade" id="list-rekening" role="tabpanel" aria-labelledby="list-rekening-list">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="">Nama Bank <span class="text-danger">*</span></label>
                        <input type="text" name="profile_nama_bank" id="profile_nama_bank" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">No Rekeking <span class="text-danger">*</span></label>
                        <input type="text" name="profile_no_rekening" id="profile_no_rekening" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>