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
                <input type="text" name="id" id="id" value="{{$data?$data->id:old('id')}}" hidden>
                <input type="text" name="user_id" id="user_id" value="{{$data?$data->user_id:old('user_id')}}" hidden>
                <div class="form-group">
                    <h4>I. Data Pribadi</h4>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">1. Nama Lengkap</div>
                        <div class="col"><input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control"
                                value="{{$data?$data->nama_lengkap:old('nama_lengkap')}}">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">2. Nama Panggilan</div>
                        <div class="col"><input type="text" name="nama_panggilan" id="nama_panggilan"
                                class="form-control" value="{{$data?$data->nama_panggilan:old('nama_panggilan')}}">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">3. Tempat, Tanggal Lahir</div>
                        <div class="col"><input type="text" name="tmpttgllahir" id="tmpttgllahir" class="form-control"
                                value="{{$data?$data->tmpttgllahir:old('tmpttgllahir')}}">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">4. Agama</div>
                        <div class="col">
                            <select name="agama" id="agama" class="form-control">
                                <option value="0"
                                    value="{{$data?($data->agama==0?'selected':''):(old('agama')==0?'selected':'')}}">
                                    Islam</option>
                                <option value="1"
                                    value="{{$data?($data->agama==1?'selected':''):(old('agama')==1?'selected':'')}}">
                                    Katholik</option>
                                <option value="2"
                                    value="{{$data?($data->agama==2?'selected':''):(old('agama')==2?'selected':'')}}">
                                    Protestan</option>
                                <option value="3"
                                    value="{{$data?($data->agama==3?'selected':''):(old('agama')==3?'selected':'')}}">
                                    Hindu</option>
                                <option value="4"
                                    value="{{$data?($data->agama==4?'selected':''):(old('agama')==4?'selected':'')}}">
                                    Budha</option>
                                <option value="5"
                                    value="{{$data?($data->agama==5?'selected':''):(old('agama')==5?'selected':'')}}">
                                    Tuhan Tang Maha Esa</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">5. Alamat Rumah/Domisili</div>
                        <div class="col">
                            <input type="text" name="alamatdomisili" id="alamatdomisili" class="form-control"
                                value="{{$data?$data->alamatdomisili:old('alamatdomisili')}}">
                            <div class="row ml-2">
                                <div>Telp. Rumah/Domisili <input type="text" name="telpdomisili" id="telpdomisili"
                                        class="form-control" value="{{$data?$data->telpdomisili:old('telpdomisili')}}">
                                </div>
                                <div>Kode Pos <input type="text" name="kodepos" id="kodepos" class="form-control"
                                        value="{{$data?$data->kodepos:old('kodepos')}}"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">6. Nama Orang Tua</div>
                        <div class="col"><input type="text" name="namaorangtua" id="namaorangtua" class="form-control"
                                value="{{$data?$data->namaorangtua:old('namaorangtua')}}">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">7. Jumlah Saudara Kandung/Angkat</div>
                        <div class="col"><input type="text" name="jmlsaudara" id="jmlsaudara" class="form-control"
                                value="{{$data?$data->jmlsaudara:old('jmlsaudara')}}">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">8. Status Perkawinan</div>
                        <div class="col">
                            <select name="statusperkawinan" id="statusperkawinan" class="form-control">
                                <option value="belum kawin"
                                    value="{{$data?($data->statusperkawinan=='belum kawin'?'selected':''):(old('statusperkawinan')=='belum kawin'?'selected':'')}}">
                                    Belum Kawin</option>
                                <option value="kawin"
                                    value="{{$data?($data->statusperkawinan=='kawin'?'selected':''):(old('statusperkawinan')=='kawin'?'selected':'')}}">
                                    Kawin</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-3 ml-2">9. Nama Istri/Suami</div>
                        <div class="col"><input type="text" name="namapasangan" id="namapasangan" class="form-control"
                                value="{{$data?$data->namapasangan:old('namapasangan')}}">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">10. Nama Lengkap Anggota Keluarga</div>
                        <div class="form-group col-md-4">
                            <label for="">a. Orang Tua Kandung/Tiri/Angkat</label>
                            <input type="text" name="namaorangtuakandung" id="namaorangtuakandung" class="form-control"
                                value="{{$data?$data->namaorangtuakandung:old('namaorangtuakandung')}}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">b. Orang Tua Kandung/Tiri/Angkat beserta suami atau istri</label>
                            <input type="text" name="namaorangtuasuamiistri" id="namaorangtuasuamiistri"
                                class="form-control"
                                value="{{$data?$data->namaorangtuasuamiistri:old('namaorangtuasuamiistri')}}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">c. Anak Kandung/Tiri/Angkat</label>
                            <input type="text" name="namaanak" id="namaanak" class="form-control"
                                value="{{$data?$data->namaanak:old('namaanak')}}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">d. Kakek Kandung/Tiri/Angkat</label>
                            <input type="text" name="namakakeknenek" id="namakakeknenek" class="form-control"
                                value="{{$data?$data->namakakeknenek:old('namakakeknenek')}}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">e. Cucu Kandung/Tiri/Angkat</label>
                            <input type="text" name="namacucu" id="namacucu" class="form-control"
                                value="{{$data?$data->namacucu:old('namacucu')}}">
                        </div>
                        <div class="form-group col">
                            <label for="">f. Suami/Istri</label>
                            <input type="text" name="namasuamiistri" id="namasuamiistri" class="form-control"
                                value="{{$data?$data->namasuamiistri:old('namasuamiistri')}}">
                        </div>
                        <div class="form-group col" hidden>
                            <label for="">g. Mertua</label>
                            <input type="text" name="namamertua" id="namamertua" class="form-control" value="mertua">
                            {{-- value="{{$data?$data->namamertua:old('namamertua')}}"> --}}
                        </div>
                        <div class="form-group col" hidden>
                            <label for="">h. Besan</label>
                            <input type="text" name="namabesan" id="namabesan" class="form-control" value="besan">
                            {{-- value="{{$data?$data->namabesan:old('namabesan')}}"> --}}
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">g. suami/istri dari anak kandung/tiri/angkat</label>
                            <input type="text" name="namasuamiistrianak" id="namasuamiistrianak" class="form-control"
                                value="{{$data?$data->namasuamiistrianak:old('namasuamiistrianak')}}">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">h. kakek/nenek dari suami/istri</label>
                            <input type="text" name="namakakeksuami" id="namakakeksuami" class="form-control"
                                value="{{$data?$data->namakakeksuami:old('namakakeksuami')}}">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">i. suami/istri dari cucu kandung/tiri/angkat</label>
                            <input type="text" name="namasuamiistricucu" id="namasuamiistricucu" class="form-control"
                                value="{{$data?$data->namasuamiistricucu:old('namasuamiistricucu')}}">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">j. Saudara kandung/tiri/angkat dari suami/istri beserta
                                suami/istrinya</label>
                            <input type="text" name="namasuamiistrisaudara" id="namasuamiistrisaudara"
                                class="form-control"
                                value="{{$data?$data->namasuamiistrisaudara:old('namasuamiistrisaudara')}}">
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
                                value="{{$data?$data->sdtahun:old('sdtahun')}}">
                        </div>
                        <div class="col">
                            <label for="">Nama Institusi</label>
                            <input type="text" name="sdnama" id="sdnama" class="form-control"
                                value="{{$data?$data->sdnama:old('sdnama')}}">
                        </div>
                        <div class="col">
                            <label for="">Fakultas/Jurusan</label>
                            <input type="text" name="sdfakultas" id="sdfakultas" class="form-control"
                                value="{{$data?$data->sdfakultas:old('sdfakultas')}}">
                        </div>
                        <div class="col">
                            <label for="">Lulus/Gelar yang Diperoleh</label>
                            <input type="text" name="sdgelar" id="sdgelar" class="form-control"
                                value="{{$data?$data->sdgelar:old('sdgelar')}}">
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
                                value="{{$data?$data->smptahun:old('smptahun')}}">
                        </div>
                        <div class="col">
                            <label for="">Nama Institusi</label>
                            <input type="text" name="smpnama" id="smpnama" class="form-control"
                                value="{{$data?$data->smpnama:old('smpnama')}}">
                        </div>
                        <div class="col">
                            <label for="">Fakultas/Jurusan</label>
                            <input type="text" name="smpfakultas" id="smpfakultas" class="form-control"
                                value="{{$data?$data->smpfakultas:old('smpfakultas')}}">
                        </div>
                        <div class="col">
                            <label for="">Lulus/Gelar yang Diperoleh</label>
                            <input type="text" name="smpgelar" id="smpgelar" class="form-control"
                                value="{{$data?$data->smpgelar:old('smpgelar')}}">
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
                                value="{{$data?$data->smatahun:old('smatahun')}}">
                        </div>

                        <div class="col">
                            <label for="">Nama Institusi</label>
                            <input type="text" name="smanama" id="smanama" class="form-control"
                                value="{{$data?$data->smanama:old('smanama')}}">
                        </div>
                        <div class="col">
                            <label for="">Fakultas/Jurusan</label>
                            <input type="text" name="smafakultas" id="smafakultas" class="form-control"
                                value="{{$data?$data->smafakultas:old('smafakultas')}}">
                        </div>
                        <div class="col">
                            <label for="">Lulus/Gelar yang Diperoleh</label>
                            <input type="text" name="smagelar" id="smagelar" class="form-control"
                                value="{{$data?$data->smagelar:old('smagelar')}}">
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
                                value="{{$data?$data->akademitahun:old('akademitahun')}}">
                        </div>
                        <div class="col">
                            <label for="">Nama Institusi</label>
                            <input type="text" name="akademinama" id="akademinama" class="form-control"
                                value="{{$data?$data->akademinama:old('akademinama')}}">
                        </div>
                        <div class="col">
                            <label for="">Fakultas/Jurusan</label>
                            <input type="text" name="akademifakultas" id="akademifakultas" class="form-control"
                                value="{{$data?$data->akademifakultas:old('akademifakultas')}}">
                        </div>
                        <div class="col">
                            <label for="">Lulus/Gelar yang Diperoleh</label>
                            <input type="text" name="akademigelar" id="akademigelar" class="form-control"
                                value="{{$data?$data->akademigelar:old('akademigelar')}}">
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
                                value="{{$data?$data->perguruantahun:old('perguruantahun')}}">
                        </div>
                        <div class="col">
                            <label for="">Nama Institusi</label>
                            <input type="text" name="perguruannama" id="perguruannama" class="form-control"
                                value="{{$data?$data->perguruannama:old('perguruannama')}}">
                        </div>
                        <div class="col">
                            <label for="">Fakultas/Jurusan</label>
                            <input type="text" name="perguruanfakultas" id="perguruanfakultas" class="form-control"
                                value="{{$data?$data->perguruanfakultas:old('perguruanfakultas')}}">
                        </div>
                        <div class="col">
                            <label for="">Lulus/Gelar yang Diperoleh</label>
                            <input type="text" name="perguruangelar" id="perguruangelar" class="form-control"
                                value="{{$data?$data->perguruangelar:old('perguruangelar')}}">
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
                                value="{{$data?$data->pascasarjanatahun:old('pascasarjanatahun')}}">
                        </div>
                        <div class="col">
                            <label for="">Nama Institusi</label>
                            <input type="text" name="pascasarjananama" id="pascasarjananama" class="form-control"
                                value="{{$data?$data->pascasarjananama:old('pascasarjananama')}}">
                        </div>
                        <div class="col">
                            <label for="">Fakultas/Jurusan</label>
                            <input type="text" name="pascasarjanafakultas" id="pascasarjanafakultas"
                                class="form-control"
                                value="{{$data?$data->pascasarjanafakultas:old('pascasarjanafakultas')}}">
                        </div>
                        <div class="col">
                            <label for="">Lulus/Gelar yang Diperoleh</label>
                            <input type="text" name="pascasarjanagelar" id="pascasarjanagelar" class="form-control"
                                value="{{$data?$data->pascasarjanagelar:old('pascasarjanagelar')}}">
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="form-group">
                    <h4>III. PELATIHAN/KURSUS YANG PERNAH DIIKUTI</h4>
                    <div class="form-pelatihan">
                        @if($datax)
                        @for($i = 0; $i < count(json_decode($data->pelatihannama)); $i++)
                            @php
                            $pn = json_decode($data->pelatihannama)[$i];
                            $pt = json_decode($data->pelatihantahun)[$i];
                            $pp = json_decode($data->pelatihanpenyelanggara)[$i];
                            $pl = json_decode($data->pelatihanlokasi)[$i];
                            @endphp
                            <div class="dinamicpelatihan{{$i}}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">Nama Pelatihan/Kursus*)</label>
                                        <input type="text" name="pelatihannama[]" id="pelatihannama"
                                            class="form-control" value="{{$pn}}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Tahun</label>
                                        <input type="text" name="pelatihantahun[]" id="pelatihantahun"
                                            class="form-control" value="{{$pt}}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Penyelenggara</label>
                                        <input type="text" name="pelatihanpenyelanggara[]" id="pelatihanpenyelanggara"
                                            class="form-control" value="{{$pp}}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Lokasi</label>
                                        <input type="text" name="pelatihanlokasi[]" id="pelatihanlokasi"
                                            class="form-control" value="{{$pl}}">
                                    </div>
                                    <small>*) Termasuk pelatihan sertifikasi</small>
                                    <span class="btn btn-danger btn-sm mt-2 ml-4"
                                        onclick="delpelatihan({{$i}})">Hapus</span>
                                </div>
                                <hr>
                            </div>
                            @endfor
                            @endif
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex mt-4">
                            <span class="btn btn-info btn-sm mt-2" onclick="addpelatihan()">Tambah</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <h4>IV. RIWAYAT PEKERJAAN</h4>
                    <div class="form-pekerjaan">
                        @if($datax)
                        @for($i = 0; $i < count(json_decode($data->pekerjaantahun)); $i++)
                            @php
                            $pt = json_decode($data->pekerjaantahun)[$i];
                            $pp = json_decode($data->pekerjaanperusahaan)[$i];
                            $pj = json_decode($data->pekerjaanjabatan)[$i];
                            $pa = json_decode($data->pekerjaantanggungjawab)[$i];
                            $pr = json_decode($data->pekerjaanprestasi)[$i];
                            $pe = json_decode($data->pekerjaanpenghargaan)[$i];
                            $po = json_decode($data->pekerjaantotalaset)[$i];
                            @endphp
                            @endfor
                            <div class="riwayat-pekerjaan{{$i}}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="">Tahun</label>
                                        <input type="text" name="pekerjaantahun[]" id="pekerjaantahun"
                                            class="form-control" value="{{$pt}}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Perusahaan</label>
                                        <input type="text" name="pekerjaanperusahaan[]" id="pekerjaanperusahaan"
                                            class="form-control" value="{{$pp}}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Jabatan</label>
                                        <input type="text" name="pekerjaanjabatan[]" id="pekerjaanjabatan"
                                            class="form-control" value="{{$pj}}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">TanggungJawab</label>
                                        <input type="text" name="pekerjaantanggungjawab[]" id="pekerjaantanggungjawab"
                                            class="form-control" value="{{$pa}}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Prestasi</label>
                                        <input type="text" name="pekerjaanprestasi[]" id="pekerjaanprestasi"
                                            class="form-control" value="{{$pr}}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Penghargaan</label>
                                        <input type="text" name="pekerjaanpenghargaan[]" id="pekerjaanpenghargaan"
                                            class="form-control" value="{{$pe}}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Total Aset/Omzet</label>
                                        <input type="text" name="pekerjaantotalaset[]" id="pekerjaantotalaset"
                                            class="form-control" value="{{$po}}">
                                    </div>
                                    <div class="col-md-3">
                                        <div class="d-flex mt-4">
                                            <span class="btn btn-danger btn-sm"
                                                onclick="delpekerjaan({{$i}})">Hapus</span>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            @endif
                    </div>
                    <span class="btn btn-info btn-sm mt-2" onclick="addpekerjaan()">Tambah</span>
                </div>
                <div class="form-group mt-2">
                    <h4>V. PENGALAMAN SPESIFIK</h4>
                    <textarea name="pengalamanspesifik" id="pengalamanspesifik" cols="30" rows="10"
                        class="form-control">{{$data?json_decode($data->pengalamanspesifik):old('pengalamanspesifik')}}</textarea>
                </div>
                <button class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
    <input type="text" id="inidatax" value="{{$datax}}" hidden>
    @if($data)
    <input type="text" id="no" value="{{count(json_decode($data->pelatihannama))}}" hidden>
    <input type="text" id="nom" value="{{count(json_decode($data->pekerjaantahun))}}" hidden>
    @endif
</section>
@include('front.layout.footer')
<script>
    let no = 0;
    let nom = 0;
    if ($('#no').val() > 0) {
        no = $('#no').val();
    }
    if ($('#nom').val() > 0) {
        nom = $('#nom').val();
    }
    $(document).ready(function () {
        if (no == 0) {
            addpelatihan();
        }
        if (nom == 0) {
            addpekerjaan();
        }
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