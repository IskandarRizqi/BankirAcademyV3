@include('front.layout.head')
@include('front.layout.topbar')
@include(env('CUSTOM_HEADER', 'front.layout.header'))
<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">
            <h3 class="text-center text-uppercase">daftar riwayat hidup</h3>
            <p class="text-center">(Calon Pemegang Saham)</p>
            <hr>
                <div class="form-group">
                    <h4>I. Data Pribadi</h4>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">1. Nama Lengkap</div>
                        <div class="col"><input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">2. Nama Panggilan</div>
                        <div class="col"><input type="text" name="nama_panggilan" id="nama_panggilan" class="form-control" required></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">3. Tempat, Tanggal Lahir</div>
                        <div class="col"><input type="text" name="tmpttgllahir" id="tmpttgllahir" class="form-control" required></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">4. Agama</div>
                        <div class="col">
                            <select name="agama" id="agama" class="form-control">
                                <option value="0">Islam</option>
                                <option value="1">Katholik</option>
                                <option value="2">Protestan</option>
                                <option value="3">Hindu</option>
                                <option value="4">Budha</option>
                                <option value="5">Tuhan Tang Maha Esa</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">5. Alamat Rumah/Domisili</div>
                        <div class="col">
                            <input type="text" name="alamatdomisili" id="alamatdomisili" class="form-control" required>
                        <div class="row ml-2">
                            <div>Telp. Rumah/Domisili  <input type="text" name="telpdomisili" id="telpdomisili" class="form-control"></div>
                            <div>Kode Pos  <input type="text" name="kodepos" id="kodepos" class="form-control"></div>
                        </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">6. Nama Orang Tua</div>
                        <div class="col"><input type="text" name="namaorangtua" id="namaorangtua" class="form-control" required></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">7. Jumlah Saudara Kandung/Angkat</div>
                        <div class="col"><input type="text" name="jmlsaudara" id="jmlsaudara" class="form-control" required></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">8. Status Perkawinan</div>
                        <div class="col"><input type="text" name="statusperkawinan" id="statusperkawinan" class="form-control" required></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">9. Nama Istri/Suami</div>
                        <div class="col"><input type="text" name="namapasangan" id="namapasangan" class="form-control" required></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">10. Nama Lengkap Anggota Keluarga</div>
                        <div class="row">
                            <div class="form-group">
                                <label for="">a. Orang Tua Kandung/Tiri/Angkat</label>
                                <input type="text" name="" id="" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row gutter-40 col-mb-80">
            </div>
        </div>
    </div>
</section>
@include('front.layout.footer')