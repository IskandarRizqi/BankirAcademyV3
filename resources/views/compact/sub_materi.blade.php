@extends('layouts.compact')
@section('content')
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="d-flex justify-content-between align-items-center px-4 pt-3">
                <h5 style="font-weight: bold;">Sub Materi</h5>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userModal"
                    onclick="resetForm()">
                    Tambah
                </button>
            </div>
            <hr>

            <table id="invoice-list" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th class="checkbox-column"> No. </th>
                        <th>Nama Materi</th>
                        <th class="text-capitalize">nama sub materi</th>
                        <th class="text-capitalize">urutan</th>
                        <th class="text-capitalize">link</th>
                        <th class="text-capitalize">tipe_link</th>
                        <th class="text-capitalize">tipe_beasiswa</th>
                        <th class="text-capitalize">masa_aktif</th>
                        <th class="text-capitalize">harga</th>
                        <th class="text-capitalize">diskon</th>
                        <th class="text-capitalize">harga final</th>
                        <th class="text-capitalize">keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $key => $x)
                    <tr>
                        <td class="checkbox-column"> {{ $key+1 }} </td>
                        <td>
                            <p class="align-self-center mb-0 user-name" style="font-weight: 600;"> {{ $x->materi->nama
                                }}
                            </p>
                        </td>
                        <td>
                            <p class="align-self-center mb-0 user-name" style="font-weight: 600;"> {{ $x->nama
                                }}
                            </p>
                        </td>
                        <td>
                            <p class="align-self-center mb-0 user-name" style="font-weight: 600;"> {{ $x->urutan
                                }}
                            </p>
                        </td>
                        <td>
                            @if($x->tipe_link == 1)
                            <a href="{{$x->link}}" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#e7515a"
                                    viewBox="0 0 24 24">
                                    <!--Boxicons v3.0.8 https://boxicons.com | License  https://docs.boxicons.com/free-->
                                    <path
                                        d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2M5 19V5h14v14z">
                                    </path>
                                    <path
                                        d="M8.5 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 1 0 0-3m2.5.5h6v2h-6zM7 7h10v2H7zm0 8h10v2H7z">
                                    </path>
                                </svg>
                            </a>
                            @else
                            <a href="{{$x->link}}" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#4361ee"
                                    viewBox="0 0 24 24">
                                    <!--Boxicons v3.0.8 https://boxicons.com | License  https://docs.boxicons.com/free-->
                                    <path
                                        d="M20 3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2M9.54 9 6.87 5h2.6l2.67 4zm5 0-2.67-4h2.6l2.67 4zM4 5h.46l2.67 4H4zm0 14v-8h16V9h-.46l-2.67-4H20v14z">
                                    </path>
                                    <path d="m10 18 5-3-5-3z"></path>
                                </svg>
                            </a>
                            @endif
                        </td>
                        <td>
                            <p class="align-self-center mb-0 user-name" style="font-weight: 600;">
                                @if($x->tipe_link == 1)
                            <div class="badge badge-pills badge-danger">PDF</div>
                            @else
                            <div class="badge badge-pills badge-primary">Video</div>
                            @endif
                            </p>
                        </td>
                        <td>
                            <p class="align-self-center mb-0 user-name" style="font-weight: 600;">
                                @if($x->tipe_beasiswa == 0)
    <div class="badge badge-pills badge-primary">Semua</div>
@endif
@if($x->tipe_beasiswa == 1)
    <div class="badge badge-pills badge-primary">Beasiswa</div>
@endif
@if($x->tipe_beasiswa == 2)
    <div class="badge badge-pills badge-primary">Non Beasiswa</div>
@endif
                            </p>
                        </td>
                        <td>
                            <p class="align-self-center mb-0 user-name" style="font-weight: 600;"> {{
                                \Carbon\Carbon::parse($x->masa_aktif)->format('d-m-Y')
                                }}
                            </p>
                        </td>
                        <td>
                            <p class="align-self-center mb-0 user-name" style="font-weight: 600;">Rp {{
                                number_format($x->harga)
                                }}
                            </p>
                        </td>
                        <td>
                            <p class="align-self-center mb-0 user-name" style="font-weight: 600;"> {{ $x->diskon
                                }} %
                            </p>
                        </td>
                        <td>
                            <p class="align-self-center mb-0 user-name" style="font-weight: 600;"> Rp {{
                                number_format($x->harga_final)
                                }}
                            </p>
                        </td>
                        <td>
                            <p class="align-self-center mb-0 user-name" style="font-weight: 600;"> {{ $x->keterangan
                                }}
                            </p>
                        </td>
                        <td>
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink{{ $x->id }}"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-more-horizontal">
                                        <circle cx="12" cy="12" r="1"></circle>
                                        <circle cx="19" cy="12" r="1"></circle>
                                        <circle cx="5" cy="12" r="1"></circle>
                                    </svg>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink{{ $x->id }}">
                                    <a class="dropdown-item action-edit" href="javascript:void(0);"
                                        onclick="editUser({{ json_encode($x) }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit-3">
                                            <path d="M12 20h9"></path>
                                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                        </svg> Edit
                                    </a>

                                    <form action="/kategori-materi/{{$x->id}}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item action-delete text-danger pl-3"
                                            style="border: none; background: none; width: 100%;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-trash">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path
                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                </path>
                                            </svg> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data pengguna.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content" style="background: #fff; border-radius: 8px;">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel" style="font-weight: bold;">Tambah Sub Materi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <form id="userForm" action="/sub-materi" method="POST">
                @csrf
                <input type="text" name="id" id="id" hidden>
                <div id="method-container"></div>

                <div class="modal-body">
                    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('info') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong class="d-block mb-1">Gagal Menyimpan Data:</strong>
            <ul class="pl-3 mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
                    <div class="row">
                        <div class="form-group col-lg-12 mb-3">
                            <label for="name" style="font-weight: 600;">Nama Materi</label>
                            <select name="id_materi" id="id_materi" class="form-control" required>
                                <option value="" disabled selected>-- Pilih --</option>
                                @foreach($materi as $key => $v)
                                <option value="{{$v->id}}">{{$v->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-6 mb-3">
                            <label for="urutan" style="font-weight: 600;">Urutan</label>
                            <input type="number" min="0" name="urutan" id="urutan" class="form-control" required>
                        </div>
                        <div class="form-group col-lg-6 mb-3">
                            <label for="nama" style="font-weight: 600;">Nama Sub Materi</label>
                            <input type="text" min="0" name="nama" id="nama" class="form-control" required>
                        </div>
                        <div class="form-group col-lg-6 mb-3">
                            <label for="nama" style="font-weight: 600;">Link Materi</label>
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="tipe_link" id="tipe_link0"
                                        value="0" checked>
                                    <span class="new-control-indicator"></span>Video
                                </label>
                                <label class="new-control new-radio radio-classic-warning">
                                    <input type="radio" class="new-control-input" name="tipe_link" id="tipe_link1"
                                        value="1">
                                    <span class="new-control-indicator"></span>PDF
                                </label>
                            </div>
                            <input type="text" name="link" id="link" class="form-control" required>
                        </div>
                        <div class="form-group col-lg-6 mb-3">
                            <label for="" style="font-weight: 600;">Tipe Sub Materi</label>
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input type="radio" class="new-control-input" name="tipe_beasiswa"
                                        id="tipe_beasiswa0" value="0" checked>
                                    <span class="new-control-indicator"></span>Semua
                                </label>
                                <label class="new-control new-radio radio-classic-warning">
                                    <input type="radio" class="new-control-input" name="tipe_beasiswa"
                                        id="tipe_beasiswa1" value="1">
                                    <span class="new-control-indicator"></span>Beasiswa
                                </label>
                                <label class="new-control new-radio radio-classic-warning">
                                    <input type="radio" class="new-control-input" name="tipe_beasiswa"
                                        id="tipe_beasiswa2" value="2">
                                    <span class="new-control-indicator"></span>Non Beasiswa
                                </label>
                            </div>
                        </div>
                    <div class="form-group col-lg-3 mb-3">
    <label for="harga_format" style="font-weight: 600;">Harga</label>
    <div class="input-group">
        <div class="input-group-append">
            <span class="input-group-text">Rp</span>
        </div>
        <input type="text" name="harga" id="harga_format" class="form-control" required>
    </div>
</div>
<div class="form-group col-lg-3 mb-3">
    <label for="diskon" style="font-weight: 600;">Diskon <small id="harga_final">harga final :</small></label>
    <div class="input-group">
        <input type="number" min="0" max="100" name="diskon" id="diskon" class="form-control" required>
        <div class="input-group-append">
            <span class="input-group-text">%</span>
        </div>
    </div>
</div>
                        <div class="form-group col-lg-6 mb-3">
                            <label for="" style="font-weight: 600;">Masa Aktif</label>
                            <input type="date" name="masa_aktif" id="masa_aktif" class="form-control" required>
                        </div>
                        <div class="form-group col-lg-12 mb-3">
                            <label for="nama" style="font-weight: 600;">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" cols="30" rows="2"
                                class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        if (typeof createtable === 'function') {
            createtable('invoice-list');
        }
        
        $('#id_materi').select2({
            dropdownParent: $('#userModal')
        });

        // 1. FORMAT TYPING: Ubah input ke format ribuan saat diketik
        $('#harga_format').on('input', function() {
            let value = $(this).val().replace(/[^0-9]/g, '');
            $(this).val(formatRupiah(value));
            hitunghargafinal();
        });

        // 2. DISKON TYPING: Hitung ulang harga final
        $('#diskon').on('input', function() {
            hitunghargafinal();
        });

        // 3. SANITASI SEBELUM SUBMIT (Kunci agar tidak NULL/Error di Laravel)
        $('#userForm').on('submit', function() {
            // Ambil input harga_format
            let hargaInput = $('#harga_format');
            // Hapus semua titik sebelum terkirim ke backend (misal: 150.000 menjadi 150000)
            let angkaMurni = hargaInput.val().replace(/[^0-9]/g, '');
            hargaInput.val(angkaMurni); 
        });
    });

    // Fungsi format ribuan standar
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

    function resetForm() {
        document.getElementById('id').value = '';
        $('#id_materi').val('').trigger('change'); 
        $('#urutan').val('');
        $('#nama').val('');
        $('#link').val('');
        
        $('#harga_format').val('');
        $('#diskon').val('');
        $('#masa_aktif').val('');
        $('#keterangan').val('');
        $('#harga_final').text('harga final :');

        $('#tipe_link0').prop('checked', true);
        $('#tipe_beasiswa0').prop('checked', true);
    }

    function editUser(user) {
        resetForm();

        if (user) {
            document.getElementById('id').value = user.id;
            $('#id_materi').val(user.id_materi).trigger('change');
            $('#urutan').val(user.urutan);
            $('#nama').val(user.nama);
            
            if (user.tipe_link == 0) $('#tipe_link0').prop('checked', true);
            if (user.tipe_link == 1) $('#tipe_link1').prop('checked', true);
            
            $('#link').val(user.link);
            
            if (user.tipe_beasiswa == 0) $('#tipe_beasiswa0').prop('checked', true);
            if (user.tipe_beasiswa == 1) $('#tipe_beasiswa1').prop('checked', true);
            if (user.tipe_beasiswa == 2) $('#tipe_beasiswa2').prop('checked', true);
            
            // Masukkan harga asli dari database dan langsung format ke ribuan
            if (user.harga) {
                $('#harga_format').val(formatRupiah(user.harga));
            }
            
            $('#diskon').val(user.diskon);
            
            if (user.masa_aktif) {
                $('#masa_aktif').val(dayjs(user.masa_aktif).format('YYYY-MM-DD'));
            }
            $('#keterangan').val(user.keterangan);
            
            hitunghargafinal();
        }
        $('#userModal').modal('show');
    }

    function hitunghargafinal() {
        // Ambil nilai dari harga_format lalu buang titiknya untuk kalkulasi matematika
        let hargaTeks = $('#harga_format').val() || '';
        let harga = parseInt(hargaTeks.replace(/[^0-9]/g, '')) || 0; 
        let diskon = parseFloat($('#diskon').val()) || 0;
        
        let potongan = (diskon / 100) * harga;
        let hargaFinal = harga - potongan;
        
        // Tampilkan hasil kalkulasi secara realtime
        $('#harga_final').text('harga final : Rp ' + formatRupiah(Math.round(hargaFinal)));
    }
</script>
@endsection