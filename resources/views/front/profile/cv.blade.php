<div class="accordion" id="accordionExample">
    {{-- <div class="card">
        <div class="card-header" id="headingOne">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                    data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Data Lamaran
                </button>
            </h2>
        </div>

        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
                <form action="/simpanlamaran" method="POST">
                    @csrf
                    <h3>Curiculum Vitae</h3>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">Nama</label>
                                <input type="text" name="cvnama" id="cvnama" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">Email</label>
                                <input type="text" name="cvemail" id="cvemail" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">No. HP</label>
                                <input type="text" name="cvnohp" id="cvnohp" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">Provinsi</label>
                                <input type="text" name="cvprovinsi" id="cvprovinsi" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">Kabupaten</label>
                                <input type="text" name="cvkabupaten" id="cvkabupaten" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">deskripsi</label>
                                <input type="text" name="cvdeskripsi" id="cvdeskripsi" class="form-control">
                            </div>
                        </div>
                    </div>
                    <h3 class="text-capitalize">Riwayat Pekerjaan</h3>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">jabatan</label>
                                <input type="text" name="cvjabatan" id="cvjabatan" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">nama perusahan</label>
                                <input type="text" name="cvnamaperusahan" id="cvnamaperusahan" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">provinsi perusahan</label>
                                <input type="text" name="cvprovinsiperusahan" id="cvprovinsiperusahan"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">kota perusahan</label>
                                <input type="text" name="cvkotaperusahan" id="cvkotaperusahan" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">tanggal mulai bekerja</label>
                                <input type="text" name="cvtglmulaikerjaperusahan" id="cvtglmulaikerjaperusahan"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">tanggal selesai bekerja</label>
                                <input type="text" name="cvtglselesaikerjaperusahan" id="cvtglselesaikerjaperusahan"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">deskripsi</label>
                                <input type="text" name="cvdeskripsiperusahan" id="cvdeskripsiperusahan"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                    <h3 class="text-capitalize">Pencapaian</h3>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">deskripsi</label>
                                <input type="text" name="cvdeskripsipencapaian" id="cvdeskripsipencapaian"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                    <h3 class="text-capitalize">Keahlian</h3>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">bidang</label>
                                <input type="text" name="cvbidangkeahlian" id="cvbidangkeahlian" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">bagian</label>
                                <input type="text" name="cvbagiankeahlian" id="cvbagiankeahlian" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">ahli</label>
                                <input type="text" name="cvahlikeahlian" id="cvahlikeahlian" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">deskripsi</label>
                                <input type="text" name="cvdeskripsikeahlian" id="cvdeskripsikeahlian"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                    <h3 class="text-capitalize">Pendidikan formal</h3>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">tingkatan sekolah</label>
                                <input type="text" name="cvtingkatansekolahkeahlian" id="cvtingkatansekolahkeahlian"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">jurusan sekolah</label>
                                <input type="text" name="cvjurusansekolah" id="cvjurusansekolah" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">nama sekolah</label>
                                <input type="text" name="cvnamasekolah" id="cvnamasekolah" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">tanggal mulai sekolah</label>
                                <input type="text" name="cvtglmulaisekolah" id="cvtglmulaisekolah" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">tanggal selesai sekolah</label>
                                <input type="text" name="cvtglselesaisekolah" id="cvtglselesaisekolah"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                    <h3 class="text-capitalize">Pendidikan non formal</h3>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">nama khursus</label>
                                <input type="text" name="cvnamakursus" id="cvnamakursus" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">nama institusi khursus</label>
                                <input type="text" name="cvnamainstitusikursus" id="cvnamakursus" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">tanggal mulai khursus</label>
                                <input type="text" name="cvtglmulaikhursus" id="cvtglmulaikhursus" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="" class="text-capitalize">tanggal selesai khursus</label>
                                <input type="text" name="cvtglselesaikhursus" id="cvtglselesaikhursus"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-sm">Simpan</button>
                </form>
            </div>
        </div>
    </div> --}}
    <a href="/datalamaran" class="btn btn-primary btn-sm">Edit Form Lamaran</a>
    <a href="/datalamaran?cetak=true" class="btn btn-primary btn-sm">Cetak Form Lamaran</a>
</div>