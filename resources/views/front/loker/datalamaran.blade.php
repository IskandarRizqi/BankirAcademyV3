@include('front.layout.head')
@include('front.layout.topbar')
@include(env('CUSTOM_HEADER', 'front.layout.header'))
<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">
            <h3 class="text-center text-uppercase">daftar riwayat hidup</h3>
            <p class="text-center">(Calon Pemegang Saham)</p>
            <hr>
            <form action="simpanlamaran" method="POST">
                @csrf
                <input type="text" name="id" id="id" hidden>
                <input type="text" name="user_id" id="user_id" hidden>
                <div class="form-group">
                    <h4>I. Data Pribadi</h4>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">1. Nama Lengkap</div>
                        <div class="col"><input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control"
                                value="{{old('nama_lengkap')}}">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">2. Nama Panggilan</div>
                        <div class="col"><input type="text" name="nama_panggilan" id="nama_panggilan"
                                class="form-control" value="{{old('nama_panggilan')}}"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">3. Tempat, Tanggal Lahir</div>
                        <div class="col"><input type="text" name="tmpttgllahir" id="tmpttgllahir" class="form-control"
                                value="{{old('tmpttgllahir')}}">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">4. Agama</div>
                        <div class="col">
                            <select name="agama" id="agama" class="form-control">
                                <option value="0" value="{{old('agama')==0?'selected':''}}">Islam</option>
                                <option value="1" value="{{old('agama')==1?'selected':''}}">Katholik</option>
                                <option value="2" value="{{old('agama')==2?'selected':''}}">Protestan</option>
                                <option value="3" value="{{old('agama')==3?'selected':''}}">Hindu</option>
                                <option value="4" value="{{old('agama')==4?'selected':''}}">Budha</option>
                                <option value="5" value="{{old('agama')==5?'selected':''}}">Tuhan Tang Maha Esa</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">5. Alamat Rumah/Domisili</div>
                        <div class="col">
                            <input type="text" name="alamatdomisili" id="alamatdomisili" class="form-control">
                            <div class="row ml-2">
                                <div>Telp. Rumah/Domisili <input type="text" name="telpdomisili" id="telpdomisili"
                                        class="form-control" value="{{old('telpdomisili')}}"></div>
                                <div>Kode Pos <input type="text" name="kodepos" id="kodepos" class="form-control"
                                        value="{{old('telpdomisili')}}"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">6. Nama Orang Tua</div>
                        <div class="col"><input type="text" name="namaorangtua" id="namaorangtua" class="form-control"
                                value="{{old('namaorangtua')}}">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">7. Jumlah Saudara Kandung/Angkat</div>
                        <div class="col"><input type="text" name="jmlsaudara" id="jmlsaudara" class="form-control"
                                value="{{old('jmlsaudara')}}">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">8. Status Perkawinan</div>
                        <div class="col"><input type="text" name="statusperkawinan" id="statusperkawinan"
                                class="form-control" value="{{old('statusperkawinan')}}"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">9. Nama Istri/Suami</div>
                        <div class="col"><input type="text" name="namapasangan" id="namapasangan" class="form-control"
                                value="{{old('namapasangan')}}">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">10. Nama Lengkap Anggota Keluarga</div>
                        <div class="form-group col-md-4">
                            <label for="">a. Orang Tua Kandung/Tiri/Angkat</label>
                            <input type="text" name="namaorangtuakandung" id="namaorangtuakandung" class="form-control"
                                value="{{old('namaorangtuakandung')}}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">b. Orang Tua Kandung/Tiri/Angkat beserta suami atau istri</label>
                            <input type="text" name="namaorangtuasuamiistri" id="namaorangtuasuamiistri"
                                class="form-control" value="{{old('namaorangtuasuamiistri')}}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">c. Anak Kandung/Tiri/Angkat</label>
                            <input type="text" name="namaanak" id="namaanak" class="form-control"
                                value="{{old('namaanak')}}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">d. Kakek Kandung/Tiri/Angkat</label>
                            <input type="text" name="namakakeknenek" id="namakakeknenek" class="form-control"
                                value="{{old('namakakeknenek')}}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">e. Cucu Kandung/Tiri/Angkat</label>
                            <input type="text" name="namacucu" id="namacucu" class="form-control"
                                value="{{old('namacucu')}}">
                        </div>
                        <div class="form-group col">
                            <label for="">f. Suami/Istri</label>
                            <input type="text" name="namasuamiistri" id="namasuamiistri" class="form-control"
                                value="{{old('namasuamiistri')}}">
                        </div>
                        <div class="form-group col">
                            <label for="">g. Mertua</label>
                            <input type="text" name="namamertua" id="namamertua" class="form-control"
                                value="{{old('namamertua')}}">
                        </div>
                        <div class="form-group col">
                            <label for="">h. Besan</label>
                            <input type="text" name="namabesan" id="namabesan" class="form-control"
                                value="{{old('namabesan')}}">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">i. suami/istri dari anak kandung/tiri/angkat</label>
                            <input type="text" name="namasuamiistrianak" id="namasuamiistrianak" class="form-control"
                                value="{{old('namasuamiistrianak')}}">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">j. kakek/nenek dari suami/istri</label>
                            <input type="text" name="namakakeksuami" id="namakakeksuami" class="form-control"
                                value="{{old('namakakeksuami')}}">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">k. suami/istri dari cucu kandung/tiri/angkat</label>
                            <input type="text" name="namasuamiistricucu" id="namasuamiistricucu" class="form-control"
                                value="{{old('namasuamiistricucu')}}">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">l. Saudara kandung/tiri/angkat dari suami/istri beserta
                                suami/istrinya</label>
                            <input type="text" name="namasuamiistrisaudara" id="namasuamiistrisaudara"
                                class="form-control" value="{{old('namasuamiistrisaudara')}}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <h4>II. Riwayat Pendidikan</h4>
                    <div class="row">
                        <div class="col-md-2">
                            <h5>Sekolah Dasar</h5>
                        </div>
                        <div class="col">
                            <label for="">Tahun</label>
                            <input type="text" name="sdtahun" id="sdtahun" class="form-control"
                                value="{{old('sdtahun')}}">
                        </div>
                        <div class="col">
                            <label for="">Nama Institusi</label>
                            <input type="text" name="sdnama" id="sdnama" class="form-control" value="{{old('sdnama')}}">
                        </div>
                        <div class="col">
                            <label for="">Fakultas/Jurusan</label>
                            <input type="text" name="sdfakultas" id="sdfakultas" class="form-control"
                                value="{{old('sdfakultas')}}">
                        </div>
                        <div class="col">
                            <label for="">Lulus/Gelar yang Diperoleh</label>
                            <input type="text" name="sdgelar" id="sdgelar" class="form-control"
                                value="{{old('sdgelar')}}">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-2">
                            <h5>Sekolah Menengah Pertama</h5>
                        </div>
                        <div class="col">
                            <label for="">Tahun</label>
                            <input type="text" name="smptahun" id="smptahun" class="form-control"
                                value="{{old('smptahun')}}">
                        </div>
                        <div class="col">
                            <label for="">Nama Institusi</label>
                            <input type="text" name="smpnama" id="smpnama" class="form-control"
                                value="{{old('smpnama')}}">
                        </div>
                        <div class="col">
                            <label for="">Fakultas/Jurusan</label>
                            <input type="text" name="smpfakultas" id="smpfakultas" class="form-control"
                                value="{{old('smpfakultas')}}">
                        </div>
                        <div class="col">
                            <label for="">Lulus/Gelar yang Diperoleh</label>
                            <input type="text" name="smpgelar" id="smpgelar" class="form-control"
                                value="{{old('smpgelar')}}">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-2">
                            <h5>Sekolah Menengah Umum</h5>
                        </div>
                        <div class="col">
                            <label for="">Tahun</label>
                            <input type="text" name="smatahun" id="smatahun" class="form-control"
                                value="{{old('smatahun')}}">
                        </div>

                        <div class="col">
                            <label for="">Nama Institusi</label>
                            <input type="text" name="smanama" id="smanama" class="form-control"
                                value="{{old('smanama')}}">
                        </div>
                        <div class="col">
                            <label for="">Fakultas/Jurusan</label>
                            <input type="text" name="smafakultas" id="smafakultas" class="form-control"
                                value="{{old('smafakultas')}}">
                        </div>
                        <div class="col">
                            <label for="">Lulus/Gelar yang Diperoleh</label>
                            <input type="text" name="smagelar" id="smagelar" class="form-control"
                                value="{{old('smagelar')}}">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-2">
                            <h5>Akademi</h5>
                        </div>
                        <div class="col">
                            <label for="">Tahun</label>
                            <input type="text" name="akademitahun" id="akademitahun" class="form-control"
                                value="{{old('akademitahun')}}">
                        </div>
                        <div class="col">
                            <label for="">Nama Institusi</label>
                            <input type="text" name="akademinama" id="akademinama" class="form-control"
                                value="{{old('akademinama')}}">
                        </div>
                        <div class="col">
                            <label for="">Fakultas/Jurusan</label>
                            <input type="text" name="akademifakultas" id="akademifakultas" class="form-control"
                                value="{{old('akademifakultas')}}">
                        </div>
                        <div class="col">
                            <label for="">Lulus/Gelar yang Diperoleh</label>
                            <input type="text" name="akademigelar" id="akademigelar" class="form-control"
                                value="{{old('akademigelar')}}">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-2">
                            <h5>Perguruan Tinggi</h5>
                        </div>
                        <div class="col">
                            <label for="">Tahun</label>
                            <input type="text" name="perguruantahun" id="perguruantahun" class="form-control"
                                value="{{old('perguruantahun')}}">
                        </div>
                        <div class="col">
                            <label for="">Nama Institusi</label>
                            <input type="text" name="perguruannama" id="perguruannama" class="form-control"
                                value="{{old('perguruannama')}}">
                        </div>
                        <div class="col">
                            <label for="">Fakultas/Jurusan</label>
                            <input type="text" name="perguruanfakultas" id="perguruanfakultas" class="form-control"
                                value="{{old('perguruanfakultas')}}">
                        </div>
                        <div class="col">
                            <label for="">Lulus/Gelar yang Diperoleh</label>
                            <input type="text" name="perguruangelar" id="perguruangelar" class="form-control"
                                value="{{old('perguruangelar')}}">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-2">
                            <h5>Pasca Sarjana</h5>
                        </div>
                        <div class="col">
                            <label for="">Tahun</label>
                            <input type="text" name="pascasarjanatahun" id="pascasarjanatahun" class="form-control"
                                value="{{old('pascasarjanatahun')}}">
                        </div>
                        <div class="col">
                            <label for="">Nama Institusi</label>
                            <input type="text" name="pascasarjananama" id="pascasarjananama" class="form-control"
                                value="{{old('pascasarjananama')}}">
                        </div>
                        <div class="col">
                            <label for="">Fakultas/Jurusan</label>
                            <input type="text" name="pascasarjanafakultas" id="pascasarjanafakultas"
                                class="form-control" value="{{old('pascasarjanafakultas')}}">
                        </div>
                        <div class="col">
                            <label for="">Lulus/Gelar yang Diperoleh</label>
                            <input type="text" name="pascasarjanagelar" id="pascasarjanagelar" class="form-control"
                                value="{{old('pascasarjanagelar')}}">
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="form-group">
                    <h4>III. PELATIHAN/KURSUS YANG PERNAH DIIKUTI</h4>
                    <div class="form-pelatihan"></div>
                    <div class="col-md-3">
                        <div class="d-flex mt-4">
                            <span class="btn btn-info btn-sm mt-2" onclick="addpelatihan()">Tambah</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <h4>IV. RIWAYAT PEKERJAAN</h4>
                    <div class="form-pekerjaan"></div>
                    <span class="btn btn-info btn-sm mt-2" onclick="addpekerjaan()">Tambah</span>
                </div>
                <div class="form-group mt-2">
                    <h4>V. PENGALAMAN SPESIFIK</h4>
                    <textarea name="pengalamanspesifik" id="pengalamanspesifik" cols="30" rows="10"
                        class="form-control"></textarea>
                </div>
                <button class="btn btn-primary">Simpan</button>

            </form>
        </div>
    </div>
</section>
@include('front.layout.footer')
<script>
    let no = 0;
    let nom = 0;
    $(document).ready(function () {
        addpelatihan();
        addpekerjaan();
    })
    function addpelatihan() {
        let h = '';
        h+='<div class="dinamicpelatihan'+no+'">';
        h+='<div class="row">';
        h+='    <div class="col-md-3">';
        h+='        <label for="">Nama Pelatihan/Kursus*)</label>';
        h+='        <input type="text" name="pelatihannama[]" id="pelatihannama" class="form-control">';
        h+='    </div>';
        h+='    <div class="col-md-3">';
        h+='        <label for="">Tahun</label>';
        h+='        <input type="text" name="pelatihantahun[]" id="pelatihantahun" class="form-control">';
        h+='    </div>';
        h+='    <div class="col-md-3">';
        h+='        <label for="">Penyelenggara</label>';
        h+='        <input type="text" name="pelatihanpenyelanggara[]" id="pelatihanpenyelanggara"';
        h+='            class="form-control">';
        h+='    </div>';
        h+='    <div class="col-md-3">';
        h+='        <label for="">Lokasi</label>';
        h+='        <input type="text" name="pelatihanlokasi[]" id="pelatihanlokasi" class="form-control">';
        h+='    </div>';
        h+='<small>*) Termasuk pelatihan sertifikasi</small>';
        h+='<span class="btn btn-danger btn-sm mt-2 ml-4" onclick="delpelatihan('+no+')">Hapus</span>';
        h+='</div>';
        h+='<hr>';
        h+='</div>';
        $('.form-pelatihan').append(h);
        no++;
    }
    function delpelatihan(no) {
        $('.dinamicpelatihan'+no).remove();
    }
    function addpekerjaan() {
        let x = '';
        x+='<div class="riwayat-pekerjaan'+nom+'">';
        x+='<div class="row">';
        x+='    <div class="col-md-3">';
        x+='        <label for="">Tahun</label>';
        x+='        <input type="text" name="pekerjaantahun[]" id="pekerjaantahun" class="form-control">';
        x+='    </div>';
        x+='    <div class="col-md-3">';
        x+='        <label for="">Perusahaan</label>';
        x+='        <input type="text" name="pekerjaanperusahaan[]" id="pekerjaanperusahaan" class="form-control">';
        x+='    </div>';
        x+='    <div class="col-md-3">';
        x+='        <label for="">Jabatan</label>';
        x+='        <input type="text" name="pekerjaanjabatan[]" id="pekerjaanjabatan" class="form-control">';
        x+='    </div>';
        x+='    <div class="col-md-3">';
        x+='        <label for="">TanggungJawab</label>';
        x+='        <input type="text" name="pekerjaantanggungjawab[]" id="pekerjaantanggungjawab"';
        x+='            class="form-control">';
        x+='    </div>';
        x+='    <div class="col-md-3">';
        x+='        <label for="">Prestasi</label>';
        x+='        <input type="text" name="pekerjaanprestasi[]" id="pekerjaanprestasi" class="form-control">';
        x+='    </div>';
        x+='    <div class="col-md-3">';
        x+='        <label for="">Penghargaan</label>';
        x+='        <input type="text" name="pekerjaanpenghargaan[]" id="pekerjaanpenghargaan"';
        x+='            class="form-control">';
        x+='    </div>';
        x+='    <div class="col-md-3">';
        x+='        <label for="">Total Aset/Omzet</label>';
        x+='        <input type="text" name="pekerjaantotalaset[]" id="pekerjaantotalaset" class="form-control">';
        x+='    </div>';
        x+='    <div class="col-md-3">';
        x+='        <div class="d-flex mt-4">';
        x+='            <span class="btn btn-danger btn-sm" onclick="delpekerjaan('+nom+')">Hapus</span>';
        x+='        </div>';
        x+='    </div>';
        x+='</div>';
        x+='<hr>';
        x+='</div>';
        nom++;
        $('.form-pekerjaan').append(x);
    }
    function delpekerjaan(nom) {
        console.log(nom);
        $('.riwayat-pekerjaan'+nom).remove();
    }
</script>