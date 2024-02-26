<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Cetak CV</title>
    <style>
        .page-break {
            page-break-after: always;
        }

        #content {
            position: relative;
            background-color: rgb(255, 255, 255);
        }

        .content-wrap {
            position: relative;
            padding: 80px 0;
            overflow: hidden;
        }

        .container {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        .text-center {
            text-align: center;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: #444;
            font-weight: 600;
            line-height: 1.5;
            margin: 0 0 30px 0;
            font-family: 'Poppins', sans-serif;
        }

        h5,
        h6 {
            margin-bottom: 20px;
        }

        h1 {
            font-size: 36px;
        }

        h2 {
            font-size: 30px;
        }

        h3 {
            font-size: 1.5rem;
        }

        h4 {
            font-size: 18px;
        }

        h5 {
            font-size: 0.875rem;
        }

        h6 {
            font-size: 12px;
        }

        h4 {
            font-weight: 600;
        }

        h5,
        h6 {
            font-weight: bold;
        }

        form {
            display: block;
            margin-top: 0em;
        }

        .form-control {
            display: block;
            width: 80%;
            height: calc(1.5em + 0.75rem + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: transparent;
            /* border-radius: 0.25rem; */
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            border-radius: 3px;
        }

        input,
        button,
        select,
        optgroup,
        textarea {
            margin: 0;
            font-family: inherit;
            font-size: inherit;
            line-height: inherit;
        }

        button,
        input {
            overflow: visible;
        }
    </style>
</head>

<body>
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <h3 class="text-center text-uppercase">daftar riwayat hidup</h3>
                {{-- <p class="text-center">(Calon Pemegang Saham)</p> --}}
                <hr>
                <h4>I. Data Pribadi</h4>
                <table style="width: 100%">
                    <tr>
                        <td>
                            <div>1. Nama Lengkap</div>
                        </td>
                        <td style="width: 8%">:</td>
                        <td style="width: 50%">
                            <div class=""><input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control"
                                    value="{{$data?$data->nama_lengkap:old('nama_lengkap')}}">
                            </div>
                        </td>
                    </tr>
                </table>
                <table style="width: 100%">
                    <tr>
                        <td>
                            <div>2. Nama Panggilan</div>
                        </td>
                        <td style="width: 8%">:</td>
                        <td style="width: 50%">
                            <div class="col"><input type="text" name="nama_panggilan" id="nama_panggilan"
                                    class="form-control" value="{{$data?$data->nama_panggilan:old('nama_panggilan')}}">
                            </div>
                        </td>
                    </tr>
                </table>
                <table style="width: 100%">
                    <tr>
                        <td>
                            <div>3. Tempat, Tanggal Lahir</div>
                        </td>
                        <td style="width: 8%">:</td>
                        <td style="width: 50%">
                            <div class="col"><input type="text" name="tmpttgllahir" id="tmpttgllahir"
                                    class="form-control" value="{{$data?$data->tmpttgllahir:old('tmpttgllahir')}}">
                            </div>
                        </td>
                    </tr>
                </table>
                <table style="width: 100%">
                    <tr>
                        <td>
                            <div class="">4. Agama</div>
                        </td>
                        <td style="width: 8%">:</td>
                        <td style="width: 50%">
                            <div class="col"><input type="text" name="namaorangtua" id="namaorangtua"
                                    class="form-control" value="{{$data?$data->namaagama:old('namaagama')}}">
                            </div>
                        </td>
                    </tr>
                </table>
                <table style="width: 100%">
                    <tr>
                        <td>
                            <div class="">5 Telp. Rumah/Domisili</div>
                        </td>
                        <td style="width: 8%">:</td>
                        <td style="width: 50%">
                            <div class="col"><input type="text" name="namaorangtua" id="namaorangtua"
                                    class="form-control" value="{{$data?$data->telpdomisili:old('telpdomisili')}}">
                            </div>
                        </td>
                    </tr>
                </table>
                <table style="width: 100%">
                    <tr>
                        <td>
                            <div class="">6 Kode Pos</div>
                        </td>
                        <td style="width: 8%">:</td>
                        <td style="width: 50%">
                            <div class="col"><input type="text" name="namaorangtua" id="namaorangtua"
                                    class="form-control" value="{{$data?$data->kodepos:old('kodepos')}}">
                            </div>
                        </td>
                    </tr>
                </table>
                <table style="width: 100%">
                    <tr>
                        <td>
                            <div class="">7. Nama Orang Tua</div>
                        </td>
                        <td style="width: 8%">:</td>
                        <td style="width: 50%">
                            <div class="col"><input type="text" name="namaorangtua" id="namaorangtua"
                                    class="form-control" value="{{$data?$data->namaorangtua:old('namaorangtua')}}">
                            </div>
                        </td>
                    </tr>
                </table>
                <table style="width: 100%">
                    <tr>
                        <td>
                            <div class="">8. Jumlah Saudara Kandung/Angkat</div>
                        </td>
                        <td style="width: 8%">:</td>
                        <td style="width: 50%">
                            <div class="col"><input type="text" name="jmlsaudara" id="jmlsaudara" class="form-control"
                                    value="{{$data?$data->jmlsaudara:old('jmlsaudara')}}">
                            </div>
                    </tr>
                </table>
                <table style="width: 100%">
                    <tr>
                        <td>
                            <div class="">9. Status Perkawinan</div>
                        </td>
                        <td style="width: 8%">:</td>
                        <td style="width: 50%">
                            <div class="col"><input type="text" name="jmlsaudara" id="jmlsaudara" class="form-control"
                                    value="{{$data?$data->statusperkawinan:old('statusperkawinan')}}">
                            </div>
                    </tr>
                </table>
                <table style="width: 100%">
                    <tr>
                        <td>
                            <div class="">10. Nama Istri/Suami</div>
                        </td>
                        <td style="width: 8%">:</td>
                        <td style="width: 50%">
                            <div class="col"><input type="text" name="namapasangan" id="namapasangan"
                                    class="form-control" value="{{$data?$data->namapasangan:old('namapasangan')}}">
                            </div>
                    </tr>
                </table>
                <table style="width: 100%">
                    <tr>
                        <td>
                            <div class="">11. Nama Istri/Suami</div>
                        </td>
                        <td style="width: 8%">:</td>
                        <td style="width: 50%">
                            <div class="col"><input type="text" name="namapasangan" id="namapasangan"
                                    class="form-control" value="{{$data?$data->namapasangan:old('namapasangan')}}">
                            </div>
                    </tr>
                </table>
                {{-- <table style="width: 100%">
                    <tr>
                        <td>
                            <label for="">a. Orang Tua Kandung/Tiri/Angkat</label>
                        </td>
                        <td style="width: 8%">:</td>
                        <td style="width: 50%">
                            <div class="col"><input type="text" name="namapasangan" id="namapasangan"
                                    class="form-control" value="{{$data?$data->namapasangan:old('namapasangan')}}">
                            </div>
                    </tr>
                </table> --}}
                <div class=""><b>Nama Lengkap Anggota Keluarga</b></div>
                <div class="row mb-2">
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">a. Orang Tua Kandung/Tiri/Angkat</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="namaorangtuakandung" id="namaorangtuakandung"
                                    class="form-control"
                                    value="{{$data?$data->namaorangtuakandung:old('namaorangtuakandung')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">b. Orang Tua Kandung/Tiri/Angkat beserta suami atau istri</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="namaorangtuasuamiistri" id="namaorangtuasuamiistri"
                                    class="form-control"
                                    value="{{$data?$data->namaorangtuasuamiistri:old('namaorangtuasuamiistri')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">c. Anak Kandung/Tiri/Angkat</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="namaanak" id="namaanak" class="form-control"
                                    value="{{$data?$data->namaanak:old('namaanak')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">d. Kakek Kandung/Tiri/Angkat</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="namakakeknenek" id="namakakeknenek" class="form-control"
                                    value="{{$data?$data->namakakeknenek:old('namakakeknenek')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">e. Cucu Kandung/Tiri/Angkat</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="namacucu" id="namacucu" class="form-control"
                                    value="{{$data?$data->namacucu:old('namacucu')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">f. Suami/Istri</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="namasuamiistri" id="namasuamiistri" class="form-control"
                                    value="{{$data?$data->namasuamiistri:old('namasuamiistri')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">g. suami/istri dari anak kandung/tiri/angkat</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="namasuamiistrianak" id="namasuamiistrianak"
                                    class="form-control"
                                    value="{{$data?$data->namasuamiistrianak:old('namasuamiistrianak')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">h. kakek/nenek dari suami/istri</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="namakakeksuami" id="namakakeksuami" class="form-control"
                                    value="{{$data?$data->namakakeksuami:old('namakakeksuami')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">i. suami/istri dari cucu kandung/tiri/angkat</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="namasuamiistricucu" id="namasuamiistricucu"
                                    class="form-control"
                                    value="{{$data?$data->namasuamiistricucu:old('namasuamiistricucu')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">j. Saudara kandung/tiri/angkat dari suami/istri beserta
                                    suami/istrinya</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="namasuamiistrisaudara" id="namasuamiistrisaudara"
                                    class="form-control"
                                    value="{{$data?$data->namasuamiistrisaudara:old('namasuamiistrisaudara')}}">
                        </tr>
                    </table>
                    {{-- <div class="form-group col" hidden>
                        <label for="">g. Mertua</label>
                        <input type="text" name="namamertua" id="namamertua" class="form-control" value="mertua">
                    </div>
                    <div class="form-group col" hidden>
                        <label for="">h. Besan</label>
                        <input type="text" name="namabesan" id="namabesan" class="form-control" value="besan">
                    </div> --}}
                </div>
                <h4>II. Riwayat Pendidikan</h4>
                <div class="row">
                    <div class="col-md-2">
                        <h5>Sekolah Dasar</h5>
                    </div>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">Tahun</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="sdtahun" id="sdtahun" class="form-control"
                                    value="{{$data?$data->sdtahun:old('sdtahun')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">Nama Institusi</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="sdnama" id="sdnama" class="form-control"
                                    value="{{$data?$data->sdnama:old('sdnama')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">Fakultas/Jurusan</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="sdfakultas" id="sdfakultas" class="form-control"
                                    value="{{$data?$data->sdfakultas:old('sdfakultas')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">Lulus/Gelar yang Diperoleh</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="sdgelar" id="sdgelar" class="form-control"
                                    value="{{$data?$data->sdgelar:old('sdgelar')}}">
                        </tr>
                    </table>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2">
                        <h5>Sekolah Menengah Pertama</h5>
                    </div>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">Tahun</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="smptahun" id="smptahun" class="form-control"
                                    value="{{$data?$data->smptahun:old('smptahun')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">Nama Institusi</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="smpnama" id="smpnama" class="form-control"
                                    value="{{$data?$data->smpnama:old('smpnama')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">Fakultas/Jurusan</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="smpfakultas" id="smpfakultas" class="form-control"
                                    value="{{$data?$data->smpfakultas:old('smpfakultas')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">Lulus/Gelar yang Diperoleh</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="smpgelar" id="smpgelar" class="form-control"
                                    value="{{$data?$data->smpgelar:old('smpgelar')}}">
                        </tr>
                    </table>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2">
                        <h5>Sekolah Menengah Umum</h5>
                    </div>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">Tahun</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="smatahun" id="smatahun" class="form-control"
                                    value="{{$data?$data->smatahun:old('smatahun')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">Nama Institusi</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="smanama" id="smanama" class="form-control"
                                    value="{{$data?$data->smanama:old('smanama')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">Fakultas/Jurusan</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="smafakultas" id="smafakultas" class="form-control"
                                    value="{{$data?$data->smafakultas:old('smafakultas')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">Lulus/Gelar yang Diperoleh</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="smagelar" id="smagelar" class="form-control"
                                    value="{{$data?$data->smagelar:old('smagelar')}}">
                        </tr>
                    </table>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2">
                        <h5>Akademi</h5>
                    </div>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">Tahun</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="akademitahun" id="akademitahun" class="form-control"
                                    value="{{$data?$data->akademitahun:old('akademitahun')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">Nama Institusi</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="akademinama" id="akademinama" class="form-control"
                                    value="{{$data?$data->akademinama:old('akademinama')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">Fakultas/Jurusan</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="akademifakultas" id="akademifakultas" class="form-control"
                                    value="{{$data?$data->akademifakultas:old('akademifakultas')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">Lulus/Gelar yang Diperoleh</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="akademigelar" id="akademigelar" class="form-control"
                                    value="{{$data?$data->akademigelar:old('akademigelar')}}">
                        </tr>
                    </table>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2">
                        <h5>Perguruan Tinggi</h5>
                    </div>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">Tahun</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="perguruantahun" id="perguruantahun" class="form-control"
                                    value="{{$data?$data->perguruantahun:old('perguruantahun')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">Nama Institusi</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="perguruannama" id="perguruannama" class="form-control"
                                    value="{{$data?$data->perguruannama:old('perguruannama')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">Fakultas/Jurusan</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="perguruanfakultas" id="perguruanfakultas" class="form-control"
                                    value="{{$data?$data->perguruanfakultas:old('perguruanfakultas')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">Lulus/Gelar yang Diperoleh</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="perguruangelar" id="perguruangelar" class="form-control"
                                    value="{{$data?$data->perguruangelar:old('perguruangelar')}}">
                        </tr>
                    </table>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2">
                        <h5>Pasca Sarjana</h5>
                    </div>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">Tahun</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="pascasarjanatahun" id="pascasarjanatahun" class="form-control"
                                    value="{{$data?$data->pascasarjanatahun:old('pascasarjanatahun')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">Nama Institusi</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="pascasarjananama" id="pascasarjananama" class="form-control"
                                    value="{{$data?$data->pascasarjananama:old('pascasarjananama')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">Fakultas/Jurusan</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="pascasarjanafakultas" id="pascasarjanafakultas"
                                    class="form-control"
                                    value="{{$data?$data->pascasarjanafakultas:old('pascasarjanafakultas')}}">
                        </tr>
                    </table>
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <label for="">Lulus/Gelar yang Diperoleh</label>
                            </td>
                            <td style="width: 8%">:</td>
                            <td style="width: 50%">
                                <input type="text" name="pascasarjanagelar" id="pascasarjanagelar" class="form-control"
                                    value="{{$data?$data->pascasarjanagelar:old('pascasarjanagelar')}}">
                        </tr>
                    </table>
                </div>
                <hr>
                <h4>III. PELATIHAN/KURSUS YANG PERNAH DIIKUTI</h4>
                <div class="form-pelatihan">
                    @for($i = 0; $i < count(json_decode($data->pelatihannama)); $i++)
                        @php
                        $pn = json_decode($data->pelatihannama)[$i];
                        $pt = json_decode($data->pelatihantahun)[$i];
                        $pp = json_decode($data->pelatihanpenyelanggara)[$i];
                        $pl = json_decode($data->pelatihanlokasi)[$i];
                        @endphp
                        <div class="dinamicpelatihan{{$i}}">
                            <div class="row">
                                <table style="width: 100%">
                                    <tr>
                                        <td>
                                            <label for="">Nama Pelatihan/Kursus*)</label>
                                        </td>
                                        <td style="width: 8%">:</td>
                                        <td style="width: 50%">
                                            <input type="text" name="pelatihannama[]" id="pelatihannama"
                                                class="form-control" value="{{$pn}}">
                                    </tr>
                                </table>
                                <table style="width: 100%">
                                    <tr>
                                        <td>
                                            <label for="">Tahun</label>
                                        </td>
                                        <td style="width: 8%">:</td>
                                        <td style="width: 50%">
                                            <input type="text" name="pelatihantahun[]" id="pelatihantahun"
                                                class="form-control" value="{{$pt}}">
                                    </tr>
                                </table>
                                <table style="width: 100%">
                                    <tr>
                                        <td>
                                            <label for="">Penyelenggara</label>
                                        </td>
                                        <td style="width: 8%">:</td>
                                        <td style="width: 50%">
                                            <input type="text" name="pelatihanpenyelanggara[]"
                                                id="pelatihanpenyelanggara" class="form-control" value="{{$pp}}">
                                    </tr>
                                </table>
                                <table style="width: 100%">
                                    <tr>
                                        <td>
                                            <label for="">Lokasi</label>
                                        </td>
                                        <td style="width: 8%">:</td>
                                        <td style="width: 50%">
                                            <input type="text" name="pelatihanlokasi[]" id="pelatihanlokasi"
                                                class="form-control" value="{{$pl}}">
                                    </tr>
                                </table>
                                <small>*) Termasuk pelatihan sertifikasi</small>
                            </div>
                            <hr>
                        </div>

                        @endfor
                </div>
                {{-- <div class="col-md-3">
                    <div class="d-flex mt-4">
                        <span class="btn btn-info btn-sm mt-2" onclick="addpelatihan()">Tambah</span>
                    </div>
                </div> --}}
                <h4>IV. RIWAYAT PEKERJAAN</h4>
                <div class="form-pekerjaan">
                    @php
                    $pt = false;
                    $pp = false;
                    $pj = false;
                    $pa = false;
                    $pr = false;
                    $pe = false;
                    $po = false;
                    @endphp
                    @if($data->pekerjaantahun)
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
                        @endif
                        <div class="riwayat-pekerjaan{{$i}}">
                            <div class="row">
                                <table style="width: 100%">
                                    <tr>
                                        <td>
                                            <label for="">Tahun</label>
                                        </td>
                                        <td style="width: 8%">:</td>
                                        <td style="width: 50%">
                                            <input type="text" name="pekerjaantahun[]" id="pekerjaantahun"
                                                class="form-control" value="{{$pt}}">
                                    </tr>
                                </table>
                                <table style="width: 100%">
                                    <tr>
                                        <td>
                                            <label for="">Perusahaan</label>
                                        </td>
                                        <td style="width: 8%">:</td>
                                        <td style="width: 50%">
                                            <input type="text" name="pekerjaanperusahaan[]" id="pekerjaanperusahaan"
                                                class="form-control" value="{{$pp}}">
                                    </tr>
                                </table>
                                <table style="width: 100%">
                                    <tr>
                                        <td>
                                            <label for="">Jabatan</label>
                                        </td>
                                        <td style="width: 8%">:</td>
                                        <td style="width: 50%">
                                            <input type="text" name="pekerjaanjabatan[]" id="pekerjaanjabatan"
                                                class="form-control" value="{{$pj}}">
                                    </tr>
                                </table>
                                <table style="width: 100%">
                                    <tr>
                                        <td>
                                            <label for="">TanggungJawab</label>
                                        </td>
                                        <td style="width: 8%">:</td>
                                        <td style="width: 50%">
                                            <input type="text" name="pekerjaantanggungjawab[]"
                                                id="pekerjaantanggungjawab" class="form-control" value="{{$pa}}">
                                    </tr>
                                </table>
                                <table style="width: 100%">
                                    <tr>
                                        <td>
                                            <label for="">Prestasi</label>
                                        </td>
                                        <td style="width: 8%">:</td>
                                        <td style="width: 50%">
                                            <input type="text" name="pekerjaanprestasi[]" id="pekerjaanprestasi"
                                                class="form-control" value="{{$pr}}">
                                    </tr>
                                </table>
                                <table style="width: 100%">
                                    <tr>
                                        <td>
                                            <label for="">Penghargaan</label>
                                        </td>
                                        <td style="width: 8%">:</td>
                                        <td style="width: 50%">
                                            <input type="text" name="pekerjaanpenghargaan[]" id="pekerjaanpenghargaan"
                                                class="form-control" value="{{$pe}}">
                                    </tr>
                                </table>
                                <table style="width: 100%">
                                    <tr>
                                        <td>
                                            <label for="">Total Aset/Omzet</label>
                                        </td>
                                        <td style="width: 8%">:</td>
                                        <td style="width: 50%">
                                            <input type="text" name="pekerjaantotalaset[]" id="pekerjaantotalaset"
                                                class="form-control" value="{{$po}}">
                                    </tr>
                                </table>
                            </div>
                            <hr>
                        </div>
                        <table style="width: 100%">
                            <tr>
                                <td>
                                    <h4>V. PENGALAMAN SPESIFIK</h4>
                                </td>
                                <td style="width: 8%">:</td>
                                <td style="width: 50%">
                                    <textarea name="pengalamanspesifik" id="pengalamanspesifik" cols="30" rows="10"
                                        class="form-control">{{$data?$data->pengalamanspesifik:old('pengalamanspesifik')}}</textarea>
                            </tr>
                        </table>
                </div>
            </div>
        </div>
    </section>
</body>

</html>