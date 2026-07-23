@extends('layouts.compact')
@section('content')
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing">
        <div class="widget-content widget-content-area br-6 shadow-sm bg-white p-4">
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h4 class="mb-1" style="font-weight: 700; color: #3b3f5c;">materi</h4>
                    <p class="text-muted mb-0" style="font-size: 13px;">Kelola materi perkuliahan, tipe akses, harga, dan file lampiran.</p>
                </div>
                <button type="button" class="btn btn-primary px-4" data-toggle="modal" data-target="#userModal" onclick="resetForm()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    Tambah Data
                </button>
            </div>
            <hr class="mb-4">

            <div class="table-responsive">
                <table id="invoice-list" class="table table-hover table-striped spec-table" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 5%">No.</th>
                            <th style="width: 25%">Materi & Kompetensi</th>
                            <th style="width: 25%">Media / Link File</th>
                            <th style="width: 15%">Akses & Masa Aktif</th>
                            <th style="width: 15%">Detail Harga</th>
                            <th style="width: 10%">Keterangan</th>
                            <th class="text-center" style="width: 5%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $key => $x)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            
                            <td>
                                <div style="font-weight: 600; color: #3b3f5c; font-size: 14px;">{{ $x->nama }}</div>
                                <small class="text-muted d-block mt-1">
                                    <span class="badge badge-light-dark">Urutan: {{ $x->urutan }}</span>
                                    <span class="ml-1">Komp: {{ $x->materi->nama }}</span>
                                </small>
                            </td>
                            
                            <td>
                                <ul class="list-unstyled mb-0">
                                    @foreach($x->items as $item)
                                        <li class="mb-2 d-flex align-items-center">
                                            @if($item->tipe_link_item == 1)
                                                <span class="badge badge-danger mr-2 text-uppercase" style="font-size: 9px; padding: 2px 5px; font-weight: 700;">PDF</span>
                                            @else
                                                <span class="badge badge-primary mr-2 text-uppercase" style="font-size: 9px; padding: 2px 5px; font-weight: 700;">Video</span>
                                            @endif
                                            <a href="{{ $item->link_item }}" target="_blank" style="font-weight: 500; color: #4361ee; text-decoration: none; font-size: 13px;" class="text-hover-underline">
                                                {{ Str::limit($item->judul_item, 25) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            
                            <td>
                                @if($x->tipe_beasiswa == 0)
                                    <span class="badge badge-pills badge-info mb-1" style="font-size: 11px;">Semua</span>
                                @elseif($x->tipe_beasiswa == 1)
                                    <span class="badge badge-pills badge-success mb-1" style="font-size: 11px;">Beasiswa</span>
                                @elseif($x->tipe_beasiswa == 2)
                                    <span class="badge badge-pills badge-warning text-white mb-1" style="font-size: 11px;">Non Beasiswa</span>
                                @endif
                                <small class="text-muted d-block mt-1" style="font-size: 12px;">
                                    Exp: {{ \Carbon\Carbon::parse($x->masa_aktif)->format('d-m-Y') }}
                                </small>
                            </td>
                            
                            <td>
                                <div style="font-weight: 700; color: #1abc9c; font-size: 14px;">Rp {{ number_format($x->harga_final) }}</div>
                                @if($x->diskon > 0)
                                    <div class="d-flex align-items-center mt-1" style="gap: 5px;">
                                        <small class="text-muted text-strikethrough" style="text-decoration: line-through; font-size: 11px;">Rp {{ number_format($x->harga) }}</small>
                                        <span class="badge badge-light-danger" style="font-size: 9px; padding: 1px 4px; font-weight: bold;">-{{ $x->diskon }}%</span>
                                    </div>
                                @endif
                            </td>
                            
                            <td>
                                <small class="text-muted d-block" title="{{ $x->keterangan }}">
                                    {{ $x->keterangan ? Str::limit($x->keterangan, 30) : '-' }}
                                </small>
                            </td>
                            
                            <td class="text-center">
                                <div class="dropdown custom-dropdown">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink{{ $x->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal text-muted"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink{{ $x->id }}">
                                        <a class="dropdown-item action-edit" href="javascript:void(0);" onclick="editUser({{ json_encode($x->load('items')) }})">
                                            ⚙️ Edit Data
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <form action="/sub-materi/{{ $x->id }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini beserta seluruh filenya?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">🗑️ Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted p-5">Tidak ada data materi ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content" style="background: #fff; border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header" style="border-bottom: 1px solid #f1f2f3;">
                <h5 class="modal-title" id="userModalLabel" style="font-weight: 700; color: #3b3f5c;">Form Pengisian Materi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="userForm" action="/sub-materi" method="POST">
                @csrf
                <input type="text" name="id" id="id" hidden>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="form-group col-lg-5 mb-3">
                            <label style="font-weight: 600; color: #515365;">Nama Kompetensi</label>
                            <select name="id_materi" id="id_materi" class="form-control" style="width:100%;" required>
                                <option value="" disabled selected>-- Pilih Kompetensi --</option>
                                @foreach($materi as $v)
                                <option value="{{$v->id}}">{{$v->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-5 mb-3">
                            <label style="font-weight: 600; color: #515365;">Nama Materi</label>
                            <input type="text" name="nama" id="nama" class="form-control" placeholder="Contoh: Pengenalan Algoritma" required>
                        </div>
                        <div class="form-group col-lg-2 mb-3">
                            <label style="font-weight: 600; color: #515365;">Urutan</label>
                            <input type="number" min="0" name="urutan" id="urutan" class="form-control" placeholder="1" required>
                        </div>

                        <div class="col-lg-12 mb-4 mt-2">
                            <div class="d-flex justify-content-between align-items-center p-3 mb-3" style="background-color: #f4f6fd; border-radius: 8px; border-left: 4px solid #4361ee;">
                                <div>
                                    <label class="mb-0" style="font-weight: 700; color: #4361ee; font-size: 14px;">Daftar File / Video Materi</label>
                                    <small class="text-muted d-block">Sematkan dokumen PDF atau URL video pembelajaran terkait.</small>
                                </div>
                                <button type="button" class="btn btn-sm btn-primary px-3" onclick="addItemRow()">+ Tambah Baris Link</button>
                            </div>
                            <div id="media-items-container">
                                </div>
                        </div>

                        <div class="form-group col-lg-12 mb-4">
                            <label style="font-weight: 600; color: #515365; display: block;" class="mb-2">Tipe Akses materi</label>
                            <div class="d-flex align-items-center" style="gap: 20px;">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="tipe_beasiswa0" name="tipe_beasiswa" class="custom-control-input" value="0" checked>
                                    <label class="custom-control-label" for="tipe_beasiswa0" style="cursor: pointer;">Terbuka Untuk Semua</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="tipe_beasiswa1" name="tipe_beasiswa" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="tipe_beasiswa1" style="cursor: pointer;">Khusus Beasiswa</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="tipe_beasiswa2" name="tipe_beasiswa" class="custom-control-input" value="2">
                                    <label class="custom-control-label" for="tipe_beasiswa2" style="cursor: pointer;">Non Beasiswa (Mandiri)</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group col-lg-4 mb-3">
                            <label style="font-weight: 600; color: #515365;">Harga Jual</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text bg-light" style="border-right: none;">Rp</span></div>
                                <input type="text" name="harga" id="harga_format" class="form-control" placeholder="0" required>
                            </div>
                        </div>
                        <div class="form-group col-lg-4 mb-3">
                            <label style="font-weight: 600; color: #515365;">Diskon Potongan</label>
                            <div class="input-group">
                                <input type="number" min="0" max="100" name="diskon" id="diskon" class="form-control" placeholder="0" required>
                                <div class="input-group-append"><span class="input-group-text bg-light">%</span></div>
                            </div>
                            <small id="harga_final" class="form-text text-success mt-1" style="font-weight: 700; font-size: 12px;">harga final : Rp 0</small>
                        </div>
                        <div class="form-group col-lg-4 mb-3">
                            <label style="font-weight: 600; color: #515365;">Batas Masa Aktif</label>
                            <input type="date" name="masa_aktif" id="masa_aktif" class="form-control" required>
                        </div>
                        <div class="form-group col-lg-12 mb-0">
                            <label style="font-weight: 600; color: #515365;">Keterangan / Deskripsi Tambahan</label>
                            <textarea name="keterangan" id="keterangan" cols="30" rows="3" class="form-control" placeholder="Catatan internal singkat mengenai materi ini..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f1f2f3;">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
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
        if (!angka) return '0';
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

    // GENERATE BARIS MEDIA BARU (PENYELARASAN GRID VERTikal)
    function addItemRow(judul = '', link = '', tipe = '0') {
        let timestamp = Date.now() + Math.floor(Math.random() * 100);
        let html = `
            <div class="row media-item-row align-items-center mb-2" id="row_${timestamp}">
                <div class="col-md-4">
                    <input type="text" name="judul_item[]" class="form-control form-control-sm" placeholder="Judul File / Video" value="${judul}" required>
                </div>
                <div class="col-md-5">
                    <input type="url" name="link_item[]" class="form-control form-control-sm" placeholder="https://url-alamat-file.com" value="${link}" required>
                </div>
                <div class="col-md-2">
                    <select name="tipe_link_item[]" class="form-control form-control-sm">
                        <option value="0" ${tipe == 0 ? 'selected' : ''}>📹 Video</option>
                        <option value="1" ${tipe == 1 ? 'selected' : ''}>📄 PDF</option>
                    </select>
                </div>
                <div class="col-md-1 text-center">
                    <button type="button" class="btn btn-outline-danger btn-sm border-0 py-1 px-2" onclick="removeItemRow('${timestamp}')" title="Hapus">
                        ✕
                    </button>
                </div>
            </div>
        `;
        $('#media-items-container').append(html);
    }

    function removeItemRow(id) {
        if($('.media-item-row').length > 1) {
            $(`#row_${id}`).remove();
        } else {
            alert('Minimal harus menyertakan 1 baris lampiran media.');
        }
    }

    function resetForm() {
        document.getElementById('id').value = '';
        $('#id_materi').val('').trigger('change'); 
        $('#urutan').val('');
        $('#nama').val('');
        
        $('#media-items-container').html('');
        addItemRow();

        $('#harga_format').val('');
        $('#diskon').val('');
        $('#masa_aktif').val('');
        $('#keterangan').val('');
        $('#harga_final').text('harga final : Rp 0');
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
            
            if (user.items && user.items.length > 0) {
                $('#media-items-container').html('');
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