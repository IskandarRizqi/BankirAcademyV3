<style>
    .br-black {
        border-color: darkgrey;
    }

    .form-control {
        margin-bottom: 22px;
    }
</style>
<div class="container">
    <div class="row" id="cvmenuutama">
        <div class="col-lg-4">
            <div class="d-flex">
                <div class="img-responsive mr-2">
                    <img src="/GambarV2/pana.png" alt="" width="100%">
                </div>
                <div class="form-group">
                    <h5>Buat Curriculum Vitae dengan cepat & mudah!</h5>
                    <button class="btn btn-outline-info btn-sm" id="btnbuatsekarang">Buat Sekarang</button>
                </div>
            </div>
        </div>
        <div class="">
        </div>
        <div class="col-lg-4">
            <div class="d-flex">
                <div class="img-responsive mr-2">
                    <img src="/GambarV2/amico.png" alt="" width="100%">
                </div>
                <div class="form-group">
                    <h5>Cetak Curriculum Vitae anda dengan mudah</h5>
                    <a href="/datalamaran?cetak=true">
                        <button class="btn btn-outline-info btn-sm">Cetak CV</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="" id="cvform1">
        <form id="cvform">
            <input type="text" name="cvuserid" id="cvuserid" value="{{Auth::user()->id}}" hidden>
            <div class="text-left">
                <span class="btn btn-primary br-10" id="btnkembali" onclick="btnback()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        style="fill: rgb(255, 255, 255);transform: ;msFilter:;">
                        <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                    </svg>
                    Kembali
                </span>
            </div>
            <h3 class="text-center"><b>DAFTAR RIWAYAT HIDUP</b></h3>
            <hr>
            <div id="cvdatadiri" hidden>
                <h4><b>I. DATA PRIBADI</b></h4>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="" class="text-capitalize">Nama Lengkap</label>
                        <input type="text" name="cvnamalengkap" id="cvnamalengkap" class="form-control br-10 br-black"
                            value="{{$datalamaran?$datalamaran->nama_lengkap:''}}">
                    </div>
                    <div class="col-lg-6">
                        <label for="" class="text-capitalize">Nama panggilan</label>
                        <input type="text" name="cvnamapanggilan" id="cvnamapanggilan"
                            class="form-control br-10 br-black"
                            value="{{$datalamaran?$datalamaran->nama_panggilan:''}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="" class="text-capitalize">Tempat, Tanggal Lahir</label>
                        <input type="text" name="cvntempattanggallahir" id="cvntempattanggallahir"
                            class="form-control br-10 br-black" value="{{$datalamaran?$datalamaran->tmpttgllahir:''}}">
                    </div>
                    <div class="col-lg-6">
                        <label for="" class="text-capitalize">Agama</label>
                        <input type="text" name="cvagama" id="cvagama" class="form-control br-10 br-black"
                            value="{{$datalamaran?$datalamaran->agama:''}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="" class="text-capitalize">Alamat Rumah</label>
                        <textarea type="text" name="cvalamatrumah" id="cvalamatrumah"
                            class="form-control br-10 br-black"
                            rows="5">{{$datalamaran?$datalamaran->alamatdomisili:''}}</textarea>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="" class="text-capitalize">Telp. Rumah</label>
                            <input type="text" name="cvtelprumah" id="cvtelprumah" class="form-control br-10 br-black"
                                value="{{$datalamaran?$datalamaran->telpdomisili:''}}">
                        </div>
                        <div class="form-group">
                            <label for="" class="text-capitalize">Kode POS</label>
                            <input type="text" name="cvkodepos" id="cvkodepos" class="form-control br-10 br-black"
                                value="{{$datalamaran?$datalamaran->kodepos:''}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="" class="text-capitalize">Nama Orang Tua</label>
                        <input type="text" name="cvnamaorangtua" id="cvnamaorangtua" class="form-control br-10 br-black"
                            value="{{$datalamaran?$datalamaran->namaorangtua:''}}">
                    </div>
                    <div class="col-lg-6">
                        <label for="" class="text-capitalize">Jumlah Saudara Kandung/Angkat</label>
                        <input type="text" name="cvjumlahsaudarakandung" id="cvjumlahsaudarakandung"
                            class="form-control br-10 br-black" value="{{$datalamaran?$datalamaran->jmlsaudara:''}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="" class="text-capitalize">Status Perkawinan</label>
                        <input type="text" name="cvstatusperkawinan" id="cvstatusperkawinan"
                            class="form-control br-10 br-black"
                            value="{{$datalamaran?$datalamaran->statusperkawinan:''}}">
                    </div>
                    <div class="col-lg-6">
                        <label for="" class="text-capitalize">Nama Istri/Suami</label>
                        <input type="text" name="cvnamaistri" id="cvnamaistri" class="form-control br-10 br-black"
                            value="{{$datalamaran?$datalamaran->namapasangan:''}}">
                    </div>
                </div>
                <h4 class="m-0 mt-4">Nama Lengkap Anggota Keluarga</h4>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="" class="text-capitalize">A. Orang Tua Kandung/Angkat/Tiri</label>
                        <input type="text" name="cvorangtuakandung" id="cvorangtuakandung"
                            class="form-control br-10 br-black"
                            value="{{$datalamaran?$datalamaran->namaorangtuakandung:''}}">
                    </div>
                    <div class="col-lg-6">
                        <label for="" class="text-capitalize">B. Orang Tua Kandung/Angkat/Tiri Beserta
                            Suami/Istri</label>
                        <input type="text" name="cvorangtuakandungistri" id="cvorangtuakandungistri"
                            class="form-control br-10 br-black"
                            value="{{$datalamaran?$datalamaran->namaorangtuasuamiistri:''}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="" class="text-capitalize">C. Anak Kandung/Angkat/Tiri</label>
                        <input type="text" name="cvanakkandung" id="cvanakkandung" class="form-control br-10 br-black"
                            value="{{$datalamaran?$datalamaran->namaanak:''}}">
                    </div>
                    <div class="col-lg-6">
                        <label for="" class="text-capitalize">D. Kakek Kandung/Angkat/Tiri</label>
                        <input type="text" name="cvkakekkandung" id="cvkakekkandung" class="form-control br-10 br-black"
                            value="{{$datalamaran?$datalamaran->namakakeknenek:''}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="" class="text-capitalize">E. Cucu Kandung/Angkat/Tiri</label>
                        <input type="text" name="cvcucukandung" id="cvcucukandung" class="form-control br-10 br-black"
                            value="{{$datalamaran?$datalamaran->namacucu:''}}">
                    </div>
                    <div class="col-lg-6">
                        <label for="" class="text-capitalize">F. Suami/Istri Kandung/Angkat/Tiri</label>
                        <input type="text" name="cvistrikandung" id="cvistrikandung" class="form-control br-10 br-black"
                            value="{{$datalamaran?$datalamaran->namasuamiistri:''}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="" class="text-capitalize">G. Suami/Istri Dari Anak Kandung/Angkat/Tiri</label>
                        <input type="text" name="cvistrianakkandung" id="cvistrianakkandung"
                            class="form-control br-10 br-black"
                            value="{{$datalamaran?$datalamaran->namasuamiistrianak:''}}">
                    </div>
                    <div class="col-lg-6">
                        <label for="" class="text-capitalize">H. Kakek/Nenek Dari Suami/Istri</label>
                        <input type="text" name="cvnenekistri" id="cvnenekistri" class="form-control br-10 br-black"
                            value="{{$datalamaran?$datalamaran->namakakeksuami:''}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label for="" class="text-capitalize">I. Suami/Istri Dari Cucu Kandung/Angkat/Tiri</label>
                        <input type="text" name="cvistricucukandung" id="cvistricucukandung"
                            class="form-control br-10 br-black"
                            value="{{$datalamaran?$datalamaran->namasuamiistricucu:''}}">
                    </div>
                    <div class="col-lg-6">
                        <label for="" class="text-capitalize">J. Saudara Kandung/Angkat/Tiri Dari Suami/Istri Beserta
                            Suami/Istri</label>
                        <input type="text" name="cvsaudaraistri" id="cvsaudaraistri" class="form-control br-10 br-black"
                            value="{{$datalamaran?$datalamaran->namasuamiistrisaudara:''}}">
                    </div>
                </div>
                <div class="text-right">
                    <span class="btn btn-primary br-10" id="btnselanjutnya">
                        Simpan & Selanjutnya
                    </span>
                </div>
            </div>
            <div id="datapendidikan" hidden>
                <h4><b>II. Riwayat Pendidikan</b></h4>
                <h5><b>Sekolah Dasar</b></h5>
                <div class="row">
                    <div class="col-lg-3">
                        <label for="" class="text-uppercase">Tahun</label>
                        <input type="text" name="cvsdtahun" value="{{$datalamaran?$datalamaran->sdtahun:''}}"
                            id="cvsdtahun" class="form-control br-black br-10">
                    </div>
                    <div class="col-lg-3">
                        <label for="" class="text-uppercase">Institusi</label>
                        <input type="text" name="cvsdinstitusi" value="{{$datalamaran?$datalamaran->sdnama:''}}"
                            id="cvsdinstitusi" class="form-control br-black br-10">
                    </div>
                    <div class="col-lg-3">
                        <label for="" class="text-uppercase">Fakultas/Jurusan</label>
                        <input type="text" name="cvsdfakultas" value="{{$datalamaran?$datalamaran->sdfakultas:''}}"
                            id="cvsdfakultas" class="form-control br-black br-10">
                    </div>
                    <div class="col-lg-3">
                        <label for="" class="text-uppercase">Lulus/Gelar Yang Diperoleh</label>
                        <input type="text" name="cvsdgelar" value="{{$datalamaran?$datalamaran->sdgelar:''}}"
                            id="cvsdgelar" class="form-control br-black br-10">
                    </div>
                </div>
                <h5><b>Sekolah Menengah Pertama</b></h5>
                <div class="row">
                    <div class="col-lg-3">
                        <label for="" class="text-uppercase">Tahun</label>
                        <input type="text" name="cvsmptahun" value="{{$datalamaran?$datalamaran->smptahun:''}}"
                            id="cvsmptahun" class="form-control br-black br-10">
                    </div>
                    <div class="col-lg-3">
                        <label for="" class="text-uppercase">Institusi</label>
                        <input type="text" name="cvsmpinstitusi" value="{{$datalamaran?$datalamaran->smpnama:''}}"
                            id="cvsmpinstitusi" class="form-control br-black br-10">
                    </div>
                    <div class="col-lg-3">
                        <label for="" class="text-uppercase">Fakultas/Jurusan</label>
                        <input type="text" name="cvsmpfakultas" value="{{$datalamaran?$datalamaran->smpfakultas:''}}"
                            id="cvsmpfakultas" class="form-control br-black br-10">
                    </div>
                    <div class="col-lg-3">
                        <label for="" class="text-uppercase">Lulus/Gelar Yang Diperoleh</label>
                        <input type="text" name="cvsmpgelar" value="{{$datalamaran?$datalamaran->smpgelar:''}}"
                            id="cvsmpgelar" class="form-control br-black br-10">
                    </div>
                </div>
                <h5><b>Sekolah Menengah Umum</b></h5>
                <div class="row">
                    <div class="col-lg-3">
                        <label for="" class="text-uppercase">Tahun</label>
                        <input type="text" name="cvsmutahun" value="{{$datalamaran?$datalamaran->smatahun:''}}"
                            id="cvsmutahun" class="form-control br-black br-10">
                    </div>
                    <div class="col-lg-3">
                        <label for="" class="text-uppercase">Institusi</label>
                        <input type="text" name="cvsmuinstitusi" value="{{$datalamaran?$datalamaran->smanama:''}}"
                            id="cvsmuinstitusi" class="form-control br-black br-10">
                    </div>
                    <div class="col-lg-3">
                        <label for="" class="text-uppercase">Fakultas/Jurusan</label>
                        <input type="text" name="cvsmufakultas" value="{{$datalamaran?$datalamaran->smafakultas:''}}"
                            id="cvsmufakultas" class="form-control br-black br-10">
                    </div>
                    <div class="col-lg-3">
                        <label for="" class="text-uppercase">Lulus/Gelar Yang Diperoleh</label>
                        <input type="text" name="cvsmugelar" value="{{$datalamaran?$datalamaran->smagelar:''}}"
                            id="cvsmugelar" class="form-control br-black br-10">
                    </div>
                </div>
                <h5><b>Akademi</b></h5>
                <div class="row">
                    <div class="col-lg-3">
                        <label for="" class="text-uppercase">Tahun</label>
                        <input type="text" name="cvakademitahun" value="{{$datalamaran?$datalamaran->akademitahun:''}}"
                            id="cvakademitahun" class="form-control br-black br-10">
                    </div>
                    <div class="col-lg-3">
                        <label for="" class="text-uppercase">Institusi</label>
                        <input type="text" name="cvakademiinstitusi"
                            value="{{$datalamaran?$datalamaran->akademinama:''}}" id="cvakademiinstitusi"
                            class="form-control br-black br-10">
                    </div>
                    <div class="col-lg-3">
                        <label for="" class="text-uppercase">Fakultas/Jurusan</label>
                        <input type="text" name="cvakademifakultas"
                            value="{{$datalamaran?$datalamaran->akademifakultas:''}}" id="cvakademifakultas"
                            class="form-control br-black br-10">
                    </div>
                    <div class="col-lg-3">
                        <label for="" class="text-uppercase">Lulus/Gelar Yang Diperoleh</label>
                        <input type="text" name="cvakademigelar" value="{{$datalamaran?$datalamaran->akademigelar:''}}"
                            id="cvakademigelar" class="form-control br-black br-10">
                    </div>
                </div>
                <h5><b>Perguruan Tinggi</b></h5>
                <div class="row">
                    <div class="col-lg-3">
                        <label for="" class="text-uppercase">Tahun</label>
                        <input type="text" name="cvperguruantinggitahun"
                            value="{{$datalamaran?$datalamaran->perguruantahun:''}}" id="cvperguruantinggitahun"
                            class="form-control br-black br-10">
                    </div>
                    <div class="col-lg-3">
                        <label for="" class="text-uppercase">Institusi</label>
                        <input type="text" name="cvperguruantinggiinstitusi"
                            value="{{$datalamaran?$datalamaran->perguruannama:''}}" id="cvperguruantinggiinstitusi"
                            class="form-control br-black br-10">
                    </div>
                    <div class="col-lg-3">
                        <label for="" class="text-uppercase">Fakultas/Jurusan</label>
                        <input type="text" name="cvperguruantinggifakultas"
                            value="{{$datalamaran?$datalamaran->perguruanfakultas:''}}" id="cvperguruantinggifakultas"
                            class="form-control br-black br-10">
                    </div>
                    <div class="col-lg-3">
                        <label for="" class="text-uppercase">Lulus/Gelar Yang Diperoleh</label>
                        <input type="text" name="cvperguruantinggigelar"
                            value="{{$datalamaran?$datalamaran->perguruangelar:''}}" id="cvperguruantinggigelar"
                            class="form-control br-black br-10">
                    </div>
                </div>
                <h5><b>Parca Sarjana</b></h5>
                <div class="row">
                    <div class="col-lg-3">
                        <label for="" class="text-uppercase">Tahun</label>
                        <input type="text" name="cvpascasarjanatahun"
                            value="{{$datalamaran?$datalamaran->pascasarjanatahun:''}}" id="cvpascasarjanatahun"
                            class="form-control br-black br-10">
                    </div>
                    <div class="col-lg-3">
                        <label for="" class="text-uppercase">Institusi</label>
                        <input type="text" name="cvpascasarjanainstitusi"
                            value="{{$datalamaran?$datalamaran->pascasarjananama:''}}" id="cvpascasarjanainstitusi"
                            class="form-control br-black br-10">
                    </div>
                    <div class="col-lg-3">
                        <label for="" class="text-uppercase">Fakultas/Jurusan</label>
                        <input type="text" name="cvpascasarjanafakultas"
                            value="{{$datalamaran?$datalamaran->pascasarjanafakultas:''}}" id="cvpascasarjanafakultas"
                            class="form-control br-black br-10">
                    </div>
                    <div class="col-lg-3">
                        <label for="" class="text-uppercase">Lulus/Gelar Yang Diperoleh</label>
                        <input type="text" name="cvpascasarjanagelar"
                            value="{{$datalamaran?$datalamaran->pascasarjanagelar:''}}" id="cvpascasarjanagelar"
                            class="form-control br-black br-10">
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <span class="btn btn-outline-secondary br-black br-10 mr-2" id="btnsebelumya"
                        onclick="btnback()">Sebelumnya</span>
                    <span class="btn btn-primary br-10" id="btnselanjutnya2">Simpan & Selanjutnya</span>
                </div>
            </div>
            <div id="datapelatihan" hidden>
                <h4><b>III. PELATIHAN/KURSUS YANG PERNAH DIIKUTI</b></h4>
                <div id="daftarpelatihan">
                </div>
                <div class="d-flex justify-content-between">
                    <small class="text-secondary">* Termasuk pelatihan sertifikasi</small>
                    <span class="btn btn-sm br-10 br-black btn-primary mt-2" onclick="addpelatihan()">Tambah</span>
                </div>
                <h4><b>IV. RIWAYAT PEKERJAAN</b></h4>
                <div id="riwayatpekerjaan">
                </div>
                <div class="d-flex justify-content-end">
                    <span class="btn btn-sm br-10 br-black btn-primary mt-2" onclick="addpekerjaan()">Tambah</span>
                </div>
                <h4><b>V. PENGALAMAN SPESIFIK</b></h4>
                <textarea name="cvpengalamanspesifik" id="cvpengalamanspesifik" cols="30" rows="10"
                    class="form-control br-10 br-black"
                    placeholder="Pengalaman Spesifik">{{$datalamaran?$datalamaran->pengalamanspesifik:''}}</textarea>
                <div class="d-flex justify-content-end">
                    <span class="btn btn-outline-secondary br-black br-10 mr-2" id="btnsebelumya"
                        onclick="btnback()">Sebelumnya</span>
                    <span class="btn btn-primary br-10" id="btnselanjutnya3">Simpan</span>
                </div>
            </div>
        </form>
    </div>
    <textarea name="cvdatalamaran" id="cvdatalamaran" cols="30" rows="10"
        hidden>{{$datalamaran?$datalamaran:null}}</textarea>
</div>
<script>
    let kembali = 0;
    let x = 0;
    let z = 0;
    allclosed();
    let dl = $('#cvdatalamaran').val();
    setpelatihan(dl);
    $('#cvmenuutama').removeAttr('hidden');
    $('#btnbuatsekarang').click(function () {
        allclosed();
        $('#cvform1').removeAttr('hidden');
        $('#cvdatadiri').removeAttr('hidden');
        scrollingtop();
    })
    $('#btnselanjutnya').click(function () {
        let dataform = $('#cvform').serialize();
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
            url: '/simpancv',
            method: 'POST',
            data:dataform,
            success:function(response){
                Swal.close()
                if (response.status == true) {
                    kembali = 1;
                    allclosed();
                    $('#cvform1').removeAttr('hidden');
                    $('#datapendidikan').removeAttr('hidden');
                    scrollingtop();
                    iziToast.success({
                        title: 'Berhasil',
                        message: 'Data tersimpan',
                        position: 'topRight',
                    });
                }
                if (response.status == false) {
                    console.log(response);
                    iziToast.warning({
                        title: 'Gagal',
                        message: 'Harap reload atau kontak admin',
                        position: 'topRight',
                    });
                    Swal.close()
                }
            },
            error: function(response) {
                console.log(response);
                iziToast.warning({
                    title: 'Gagal',
                    message: 'Harap reload atau kontak admin',
                    position: 'topRight',
                });
                Swal.close()
            }
        })
    })
    $('#btnselanjutnya2').click(function () {
        let dataform = $('#cvform').serialize();
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
            url: '/simpancv',
            method: 'POST',
            data:dataform,
            success:function(response){
                Swal.close()
                if (response.status == true) {
                    kembali = 2;
                    allclosed();
                    $('#cvform1').removeAttr('hidden');
                    $('#datapelatihan').removeAttr('hidden');
                    scrollingtop();
                    iziToast.success({
                        title: 'Berhasil',
                        message: 'Data tersimpan',
                        position: 'topRight',
                    });
                }
                if (response.status == false) {
                    console.log(response);
                    iziToast.warning({
                        title: 'Gagal',
                        message: 'Harap reload atau kontak admin',
                        position: 'topRight',
                    });
                    Swal.close()
                }
            },
            error: function(response) {
                console.log(response);
                iziToast.warning({
                    title: 'Gagal',
                    message: 'Harap reload atau kontak admin',
                    position: 'topRight',
                });
                Swal.close()
            }
        })
    })
    $('#btnselanjutnya3').click(function () {
        let dataform = $('#cvform').serialize();
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
            url: '/simpancv',
            method: 'POST',
            data:dataform,
            success:function(response){
                Swal.close()
                if (response.status == true) {
                    kembali = 2;
                    allclosed();
                    $('#cvform1').removeAttr('hidden');
                    $('#datapelatihan').removeAttr('hidden');
                    scrollingtop();
                    iziToast.success({
                        title: 'Berhasil',
                        message: 'Data tersimpan',
                        position: 'topRight',
                    });
                }
                if (response.status == false) {
                    console.log(response);
                    iziToast.warning({
                        title: 'Gagal',
                        message: 'Harap reload atau kontak admin',
                        position: 'topRight',
                    });
                    Swal.close()
                }
            },
            error: function(response) {
                console.log(response);
                iziToast.warning({
                    title: 'Gagal',
                    message: 'Harap reload atau kontak admin',
                    position: 'topRight',
                });
                Swal.close()
            }
        })
    })
    function allclosed() {
        $('#cvmenuutama').attr('hidden',true);
        $('#cvform1').attr('hidden',true);
        $('#cvdatadiri').attr('hidden',true);
        $('#datapendidikan').attr('hidden',true);
        $('#datapelatihan').attr('hidden',true);
    }
    function btnback() {
        $('#gotoTop').attr('data-scrolltop',320)
        allclosed();
        if (kembali == 0) {
            $('#cvmenuutama').removeAttr('hidden');
        }
        if (kembali == 1) {
            $('#cvform1').removeAttr('hidden');
            $('#cvdatadiri').removeAttr('hidden');
        }
        if (kembali == 2) {
            $('#cvform1').removeAttr('hidden');
            $('#datapendidikan').removeAttr('hidden');
        }
        if (kembali > 0) {
            kembali--;
        }
        scrollingtop()
    }
    function scrollingtop() {
		$('body,html').stop(true).animate({
			'scrollTop': 320
		}, Number(700), 'easeOutQuad');
		return false;
    }

    function setpelatihan(data) {
        if (!data) {
            return false;
        }
        let js = JSON.parse(data);
        console.log(js);
        // Pelatihan
        let nama = JSON.parse(js.pelatihannama);
        let lokasi = JSON.parse(js.pelatihanlokasi);
        let penyelanggara = JSON.parse(js.pelatihanpenyelanggara);
        let tahun = JSON.parse(js.pelatihantahun);
        let no =0;
        if (nama.length > 0) {
            nama.forEach(el => {
                addpelatihan();
                $('#cvpelatihannama'+no).val(el);
                $('#cvpelatihantahun'+no).val(tahun[no]);
                $('#cvpelatihanpenyelengara'+no).val(penyelanggara[no]);
                $('#cvpelatihanlokasi'+no).val(lokasi[no]);
                no++;
            });
        }

        let pekerjaanpenghargaan = JSON.parse(js.pekerjaanpenghargaan);
        let pekerjaanperusahaan = JSON.parse(js.pekerjaanperusahaan);
        let pekerjaanprestasi = JSON.parse(js.pekerjaanprestasi);
        let pekerjaantahun = JSON.parse(js.pekerjaantahun);
        let pekerjaantanggungjawab = JSON.parse(js.pekerjaantanggungjawab);
        let pekerjaantotalaset = JSON.parse(js.pekerjaantotalaset);
        let pekerjaanjabatan = JSON.parse(js.pekerjaanjabatan);
        let n = 0;
        if (pekerjaanpenghargaan) {
            if (pekerjaanpenghargaan.length > 0) {
                pekerjaanpenghargaan.forEach(e => {
                    addpekerjaan();
                    $('#cvpekerjaanpenghargaan'+n).val(pekerjaanpenghargaan[n]);
                    $('#cvpekerjaanperusahaan'+n).val(pekerjaanperusahaan[n]);
                    $('#cvpekerjaanprestasi'+n).val(pekerjaanprestasi[n]);
                    $('#cvpekerjaantahun'+n).val(pekerjaantahun[n]);
                    $('#cvpekerjaantanggungjawab'+n).val(pekerjaantanggungjawab[n]);
                    $('#cvpekerjaanaset'+n).val(pekerjaantotalaset[n]);
                    $('#cvpekerjaanjabatan'+n).val(pekerjaanjabatan[n]);
                });
                n++;
            }
        }
    }
    function addpelatihan() {
        let h = '';
        h+='<div id="pelatihan'+x+'">';
        h+='<div class="row">';
        h+='    <div class="col-lg-3">';
        h+='        <label for="">Nama Pelatihan/Kursus</label>';
        h+='        <input type="text" name="cvpelatihannama[]" id="cvpelatihannama'+x+'"';
        h+='            class="form-control br-black br-10">';
        h+='    </div>';
        h+='    <div class="col-lg-3">';
        h+='        <label for="">Tahun</label>';
        h+='        <input type="text" name="cvpelatihantahun[]" id="cvpelatihantahun'+x+'"';
        h+='            class="form-control br-black br-10">';
        h+='    </div>';
        h+='    <div class="col-lg-3">';
        h+='        <label for="">Penyelenggara</label>';
        h+='        <input type="text" name="cvpelatihanpenyelengara[]" id="cvpelatihanpenyelengara'+x+'"';
        h+='            class="form-control br-black br-10">';
        h+='    </div>';
        h+='    <div class="col-lg-3">';
        h+='        <label for="">Lokasi</label>';
        h+='        <input type="text" name="cvpelatihanlokasi[]" id="cvpelatihanlokasi'+x+'"';
        h+='            class="form-control br-black br-10">';
        h+='    </div>';
        h+='</div>';
        h+='<div class="d-flex justify-content-end">';
        h+='    <span';
        h+='        class="text-right btn btn-sm br-10 br-black btn-outline-secondary mr-2 remove_button" onclick="hapuspelatihan('+x+')">Hapus</span>';
        h+='</div>';
        h+='</div>';

        x++;
        $('#daftarpelatihan').append(h);
    }
    function hapuspelatihan(index) {
        console.log(index);
        $('#pelatihan'+index).remove();
        x--;
    }

    function addpekerjaan() {
        let q = ''
        q+='<div id="pekerjaan'+z+'">';
        q+='    <div class="row">';
        q+='        <div class="col-lg-4">';
        q+='            <label for="">Perusahaan</label>';
        q+='            <input type="text" name="cvpekerjaanperusahaan[]" id="cvpekerjaanperusahaan'+z+'"';
        q+='                class="form-control br-black br-10">';
        q+='        </div>';
        q+='        <div class="col-lg-4">';
        q+='            <label for="">Jabatan</label>';
        q+='            <input type="text" name="cvpekerjaanjabatan[]" id="cvpekerjaanjabatan'+z+'"';
        q+='                class="form-control br-black br-10">';
        q+='        </div>';
        q+='        <div class="col-lg-4">';
        q+='            <label for="">Tanggung Jawab</label>';
        q+='            <input type="text" name="cvpekerjaantanggungjawab[]" id="cvpekerjaantanggungjawab'+z+'"';
        q+='                class="form-control br-black br-10">';
        q+='        </div>';
        q+='        <div class="col-lg-3">';
        q+='            <label for="">Tahun</label>';
        q+='            <input type="text" name="cvpekerjaantahun[]" id="cvpekerjaantahun'+z+'"';
        q+='                class="form-control br-black br-10">';
        q+='        </div>';
        q+='        <div class="col-lg-3">';
        q+='            <label for="">Prestasi</label>';
        q+='            <input type="text" name="cvpekerjaanprestasi[]" id="cvpekerjaanprestasi'+z+'"';
        q+='                class="form-control br-black br-10">';
        q+='        </div>';
        q+='        <div class="col-lg-3">';
        q+='            <label for="">Penghargaan</label>';
        q+='            <input type="text" name="cvpekerjaanpenghargaan[]" id="cvpekerjaanpenghargaan'+z+'"';
        q+='                class="form-control br-black br-10">';
        q+='        </div>';
        q+='        <div class="col-lg-3">';
        q+='            <label for="">Total Aset/Omzet</label>';
        q+='            <input type="text" name="cvpekerjaanaset[]" id="cvpekerjaanaset'+z+'"';
        q+='                class="form-control br-black br-10">';
        q+='        </div>';
        q+='    </div>';
        q+='    <div class="d-flex justify-content-end">';
        q+='        <span class="btn btn-sm br-10 br-black btn-outline-secondary mr-2" onclick="hapuspekerjaan('+z+')">Hapus</span>';
        q+='    </div>';
        q+='</div>';
        $('#riwayatpekerjaan').append(q);
        z++;
    }
    function hapuspekerjaan(index) {
        $('#pekerjaan'+index).remove();
        z--;
    }
</script>