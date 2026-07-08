@extends('layouts.compact')
@section('content')
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="d-flex justify-content-between align-items-center px-4 pt-3">
                <h5 style="font-weight: bold;">Sub Materi</h5>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userModal" onclick="resetForm()">
                    Tambah
                </button>
            </div>
            <hr>

            <table id="invoice-list" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th class="checkbox-column"> No. </th>
                        <th>Nama Kompetensi</th>
                        <th>Nama Materi</th>
                        <th>Urutan</th>
                        <th>Media / Link File (Judul)</th>
                        <th>Tipe Beasiswa</th>
                        <th>Masa Aktif</th>
                        <th>Harga</th>
                        <th>Diskon</th>
                        <th>Harga Final</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $key => $x)
                    <tr>
                        <td class="checkbox-column"> {{ $key+1 }} </td>
                        <td><p class="mb-0" style="font-weight: 600;">{{ $x->materi->nama }}</p></td>
                        <td><p class="mb-0" style="font-weight: 600;">{{ $x->nama }}</p></td>
                        <td><p class="mb-0" style="font-weight: 600;">{{ $x->urutan }}</p></td>
                        <td>
                            <!-- LOOPING MULTIPLE MEDIA ITEMS -->
                            <ul class="pl-3 mb-0">
                                @foreach($x->items as $item)
                                    <li class="mb-1">
                                        @if($item->tipe_link_item == 1)
                                            <span class="badge badge-danger mr-1">PDF</span>
                                        @else
                                            <span class="badge badge-primary mr-1">Video</span>
                                        @endif
                                        <a href="{{ $item->link_item }}" target="_blank" style="font-weight:600; color:#4361ee;">
                                            {{ $item->judul_item }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            @if($x->tipe_beasiswa == 0)
                                <div class="badge badge-pills badge-info">Semua</div>
                            @elseif($x->tipe_beasiswa == 1)
                                <div class="badge badge-pills badge-success">Beasiswa</div>
                            @elseif($x->tipe_beasiswa == 2)
                                <div class="badge badge-pills badge-warning text-white">Non Beasiswa</div>
                            @endif
                        </td>
                        <td><p class="mb-0" style="font-weight: 600;">{{ \Carbon\Carbon::parse($x->masa_aktif)->format('d-m-Y') }}</p></td>
                        <td><p class="mb-0" style="font-weight: 600;">Rp {{ number_format($x->harga) }}</p></td>
                        <td><p class="mb-0" style="font-weight: 600;">{{ $x->diskon }} %</p></td>
                        <td><p class="mb-0" style="font-weight: 600;">Rp {{ number_format($x->harga_final) }}</p></td>
                        <td><p class="mb-0" style="font-weight: 600;">{{ $x->keterangan }}</p></td>
                        <td>
                            <div class="dropdown">
                                   <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink{{ $x->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
  <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0"/>
  <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z"/>
</svg>
                                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink{{ $x->id }}">
                                    <!-- Parsing data ke editUser lengkap beserta items-nya -->
                                    <a class="dropdown-item action-edit" href="javascript:void(0);" onclick="editUser({{ json_encode($x->load('items')) }})">
                                        Edit
                                    </a>
                                    <form action="/sub-materi/{{ $x->id }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sub materi ini beserta seluruh filenya?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="dropdown-item action-delete text-danger">Delete</button>
</form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12" class="text-center">Tidak ada data sub materi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL FORM -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content" style="background: #fff; border-radius: 8px;">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel" style="font-weight: bold;">Form Materi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="userForm" action="/sub-materi" method="POST">
                @csrf
                <input type="text" name="id" id="id" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-12 mb-3">
                            <label style="font-weight: 600;">Nama Kompetensi</label>
                            <select name="id_materi" id="id_materi" class="form-control" required>
                                <option value="" disabled selected>-- Pilih --</option>
                                @foreach($materi as $v)
                                <option value="{{$v->id}}">{{$v->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-6 mb-3">
                            <label style="font-weight: 600;">Urutan</label>
                            <input type="number" min="0" name="urutan" id="urutan" class="form-control" required>
                        </div>
                        <div class="form-group col-lg-6 mb-3">
                            <label style="font-weight: 600;">Nama  Materi</label>
                            <input type="text" name="nama" id="nama" class="form-control" required>
                        </div>

                        <!-- SELEKSI UTAMA MULTIPLE ITEMS -->
                        <div class="col-lg-12 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label style="font-weight: bold; color: #4361ee;">Daftar File / Video Materi</label>
                                <button type="button" class="btn btn-sm btn-success" onclick="addItemRow()">+ Tambah Link</button>
                            </div>
                            <div id="media-items-container">
                                <!-- Baris Input Dinamis akan di-inject lewat JS di sini -->
                            </div>
                        </div>

                        <div class="form-group col-lg-6 mb-3">
                            <label style="font-weight: 600;">Tipe Sub Materi</label>
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="tipe_beasiswa" id="tipe_beasiswa0" value="0" checked>
                                    <span class="new-control-indicator"></span>Semua
                                </label>
                                <label class="new-control new-radio radio-classic-warning">
                                    <input type="radio" class="new-control-input" name="tipe_beasiswa" id="tipe_beasiswa1" value="1">
                                    <span class="new-control-indicator"></span>Beasiswa
                                </label>
                                <label class="new-control new-radio radio-classic-warning">
                                    <input type="radio" class="new-control-input" name="tipe_beasiswa" id="tipe_beasiswa2" value="2">
                                    <span class="new-control-indicator"></span>Non Beasiswa
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-lg-3 mb-3">
                            <label style="font-weight: 600;">Harga</label>
                            <div class="input-group">
                                <div class="input-group-append"><span class="input-group-text">Rp</span></div>
                                <input type="text" name="harga" id="harga_format" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group col-lg-3 mb-3">
                            <label style="font-weight: 600;">Diskon <small id="harga_final">harga final :</small></label>
                            <div class="input-group">
                                <input type="number" min="0" max="100" name="diskon" id="diskon" class="form-control" required>
                                <div class="input-group-append"><span class="input-group-text">%</span></div>
                            </div>
                        </div>
                        <div class="form-group col-lg-6 mb-3">
                            <label style="font-weight: 600;">Masa Aktif</label>
                            <input type="date" name="masa_aktif" id="masa_aktif" class="form-control" required>
                        </div>
                        <div class="form-group col-lg-12 mb-3">
                            <label style="font-weight: 600;">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" cols="30" rows="2" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        if (typeof createtable === 'function') { createtable('invoice-list'); }
        $('#id_materi').select2({ dropdownParent: $('#userModal') });

        $('#harga_format').on('input', function() {
            let value = $(this).val().replace(/[^0-9]/g, '');
            $(this).val(formatRupiah(value));
            hitunghargafinal();
        });

        $('#diskon').on('input', function() { hitunghargafinal(); });

        $('#userForm').on('submit', function() {
            let hargaInput = $('#harga_format');
            let angkaMurni = hargaInput.val().replace(/[^0-9]/g, '');
            hargaInput.val(angkaMurni); 
        });
    });

    function formatRupiah(angka) {
        if (!angka) return '';
        let numberString = angka.toString().replace(/[^0-9]/g, ''),
            sisa = numberString.length % 3,
            rupiah = numberString.substr(0, sisa),
            ribuan = numberString.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        return rupiah;
    }

    // FUNGSI UNTUK GENERATE BARIS ITEM BARU (VIDEO / PDF)
    function addItemRow(judul = '', link = '', tipe = '0') {
        let timestamp = Date.now() + Math.floor(Math.random() * 100);
        let html = `
            <div class="row media-item-row align-items-end mb-2" id="row_${timestamp}">
                <div class="col-md-4">
                    <input type="text" name="judul_item[]" class="form-control" placeholder="Contoh: Video Pengantar" value="${judul}" required>
                </div>
                <div class="col-md-5">
                    <input type="text" name="link_item[]" class="form-control" placeholder="http://link-materi.com" value="${link}" required>
                </div>
                <div class="col-md-2">
                    <select name="tipe_link_item[]" class="form-control">
                        <option value="0" ${tipe == 0 ? 'selected' : ''}>Video</option>
                        <option value="1" ${tipe == 1 ? 'selected' : ''}>PDF</option>
                    </select>
                </div>
                <div class="col-md-1 text-right">
                    <button type="button" class="btn btn-danger btn-sm p-2" onclick="removeItemRow('${timestamp}')">Hapus</button>
                </div>
            </div>
        `;
        $('#media-items-container').append(html);
    }

    function removeItemRow(id) {
        // Sisakan minimal 1 baris input agar tidak kosong sama sekali saat disubmit
        if($('.media-item-row').length > 1) {
            $(`#row_${id}`).remove();
        } else {
            alert('Minimal harus memiliki 1 link media/materi.');
        }
    }

    function resetForm() {
        document.getElementById('id').value = '';
        $('#id_materi').val('').trigger('change'); 
        $('#urutan').val('');
        $('#nama').val('');
        
        // Kosongkan container lalu isi dengan 1 baris kosong default
        $('#media-items-container').html('');
        addItemRow();

        $('#harga_format').val('');
        $('#diskon').val('');
        $('#masa_aktif').val('');
        $('#keterangan').val('');
        $('#harga_final').text('harga final :');
        $('#tipe_beasiswa0').prop('checked', true);
    }

    function editUser(user) {
        resetForm();
        if (user) {
            document.getElementById('id').value = user.id;
            $('#id_materi').val(user.id_materi).trigger('change');
            $('#urutan').val(user.urutan);
            $('#nama').val(user.nama);
            
            if (user.tipe_beasiswa == 0) $('#tipe_beasiswa0').prop('checked', true);
            if (user.tipe_beasiswa == 1) $('#tipe_beasiswa1').prop('checked', true);
            if (user.tipe_beasiswa == 2) $('#tipe_beasiswa2').prop('checked', true);
            
            if (user.harga) { $('#harga_format').val(formatRupiah(user.harga)); }
            $('#diskon').val(user.diskon);
            if (user.masa_aktif) { $('#masa_aktif').val(dayjs(user.masa_aktif).format('YYYY-MM-DD')); }
            $('#keterangan').val(user.keterangan);
            
            // ISI DENGAN DATA ITEMS DARI DATABASE
            if (user.items && user.items.length > 0) {
                $('#media-items-container').html(''); // hapus row default
                user.items.forEach(function(item) {
                    addItemRow(item.judul_item, item.link_item, item.tipe_link_item);
                });
            }

            hitunghargafinal();
        }
        $('#userModal').modal('show');
    }

    function hitunghargafinal() {
        let hargaTeks = $('#harga_format').val() || '';
        let harga = parseInt(hargaTeks.replace(/[^0-9]/g, '')) || 0; 
        let diskon = parseFloat($('#diskon').val()) || 0;
        
        let potongan = (diskon / 100) * harga;
        let hargaFinal = harga - potongan;
        
        $('#harga_final').text('harga final : Rp ' + formatRupiah(Math.round(hargaFinal)));
    }
</script>
@endsection