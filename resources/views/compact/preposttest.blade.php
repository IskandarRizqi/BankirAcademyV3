@extends('layouts.compact')
@section('content')
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="d-flex justify-content-between align-items-center px-4 pt-3">
                <h5 style="font-weight: bold;">Pre Post Test ( PPT )</h5>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userModal"
                    onclick="editUser(null)">
                    Tambah
                </button>
            </div>
            <hr>

            <table id="invoice-list" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th class="checkbox-column"> No. </th>
                        <th>Materi</th>
                        <th>Sub Materi</th>
                        <th>Judul</th>
                        <th>Jumlah Soal</th>
                        <th>Pre Post Test</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $key => $x)
                    <tr>
                        <td class="checkbox-column"> {{ $key+1 }} </td>
                        <td>
                            <p class="align-self-center mb-0 user-name" style="font-weight: 600;"> {{ $x->materi?->nama
                                }}
                            </p>
                        </td>
                        <td>
                            <p class="align-self-center mb-0 user-name" style="font-weight: 600;"> {{
                                $x->submateri?->nama }}
                            </p>
                        </td>
                        <td>
                            <p class="align-self-center mb-0 user-name" style="font-weight: 600;"> {{ $x->judul }}
                            </p>
                        </td>
                        <td>
                            <p class="align-self-center mb-0 user-name" style="font-weight: 600;"> {{
                                count(json_decode($x->soal)) }}
                                Soal
                            </p>
                        </td>
                        <td>
                            @if($x->tipe_prepost == 0)
                            <span class="badge badge-info">Pre</span>
                            @else
                            <span class="badge badge-primary">Post</span>
                            @endif
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
                                        onclick="editUser({{ $x }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit-3">
                                            <path d="M12 20h9"></path>
                                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                        </svg> Edit
                                    </a>

                                    <form action="/ppt/{{$x->id}}" method="POST"
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
                <h5 class="modal-title" id="userModalLabel" style="font-weight: bold;">Tambah Pre Post Test</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <form id="userForm" action="/ppt" method="POST">
                @csrf
                <input type="text" name="id" id="id" hidden>
                <div id="method-container"></div>

                <div class="modal-body">
                    <div class="row layout-top-spacing">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Judul <span class="text-danger">*</span></label>
                                <input type="text" id="judul" name="judul" class="form-control"
                                    placeholder="Masukkan judul">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Kompetensi <span class="text-danger">*</span></label>
                                <select name="id_materi" id="id_materi" class="form-control">
                                    <option value="">Pilih Kompetensi</option>
                                    @foreach($materi as $key => $v)
                                    <option value="{{$v->id}}">{{$v->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3" hidden>
                            <div class="form-group">
                                <label>Sub Materi</label>
                                <select name="id_submateri" id="id_submateri" class="form-control">
                                    <option value="">Pilih Sub Materi</option>
                                    @foreach($submateri as $key => $v)
                                    <option value="{{$v->id}}">{{$v->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Pre / Post Test <span class="text-danger">*</span></label>
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <input type="radio" name="tipe_prepost" id="tipe_prepost0" class="form-control"
                                            value="0">
                                    </div>
                                    <div class="col-md-4 pl-0">
                                        <label for="">Pre</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="radio" name="tipe_prepost" id="tipe_prepost1" class="form-control"
                                            value="1">
                                    </div>
                                    <div class="col-md-4 pl-0">
                                        <label for="">Post</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <button type="button" class="btn btn-success mb-3" id="btnTambahSoal">
                        + Tambah Soal
                    </button>
                    <div id="soalContainer">
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

<script type="text/template" id="template-soal">
    <div class="card mb-3 soal-item">

    <div class="card-header">

        <div class="d-flex justify-content-between align-items-center">

            <button
                class="btn btn-link text-left p-0"
                type="button"
                data-toggle="collapse"
                data-target="#collapseSoalINDEX">

                <strong>Soal <span class="nomor-soal"></span></strong>
            </button>

            <button
                type="button"
                class="btn btn-danger btn-sm hapus-soal">
                Hapus
            </button>

        </div>

    </div>

    <div id="collapseSoalINDEX" class="collapse show">

        <div class="card-body">

            <div class="form-group">
                <label>Pertanyaan <span class="text-danger">*</span></label>
                <input class="form-control pertanyaan"
                    name="soal[INDEX][pertanyaan]"
                    id="soal[INDEX][pertanyaan]"
                    >
            </div>

            <div class="form-group" hidden>
                <label>Tipe Pertanyaan <span class="text-danger">*</span></label>
                <select
                    class="form-control tipe-soal tipe_pertanyaan"
                    name="soal[INDEX][tipe_pertanyaan]"
                    id="soal[INDEX][tipe_pertanyaan]"
                    >
                    <option value="1" selected>Pilihan Ganda</option>
                    <option value="2">Essay</option>
                </select>
            </div>

            <div class="pilihan-ganda">

                <label class="mb-3">
                    Pilih jawaban yang benar
                </label>

                <input
                            type="text"
                            name="soal[INDEX][jawaban]"
                            id="soal[INDEX][jawaban]"
                            class="jawaban"
                            value="" 
                            hidden
                            >

                <div class="row align-items-center mb-2">
                    <div class="col-md-1">
                        <input
                            type="radio"
                            class="jawaban-radio"
                            name="soal[INDEX][jawaban]"
                            id="soal[INDEX][jawaban]"
                            value="A">
                    </div>

                    <div class="col-md-11">
                        <input
                            type="text"
                            class="form-control opsi-a"
                            name="soal[INDEX][opsi][A]"
                            id="soal[INDEX][opsi][A]"
                            placeholder="Opsi A">
                    </div>
                </div>

                <div class="row align-items-center mb-2">
                    <div class="col-md-1">
                        <input
                            type="radio"
                            class="jawaban-radio"
                            name="soal[INDEX][jawaban]"
                            id="soal[INDEX][jawaban]"
                            value="B">
                    </div>

                    <div class="col-md-11">
                        <input
                            type="text "
                            class="form-control opsi-b"
                            name="soal[INDEX][opsi][B]"
                            id="soal[INDEX][opsi][B]"
                            placeholder="Opsi B">
                    </div>
                </div>

                <div class="row align-items-center mb-2">
                    <div class="col-md-1">
                        <input
                            type="radio"
                            class="jawaban-radio"
                            name="soal[INDEX][jawaban]"
                            id="soal[INDEX][jawaban]"
                            value="C">
                    </div>

                    <div class="col-md-11">
                        <input
                            type="text "
                            class="form-control opsi-c"
                            name="soal[INDEX][opsi][C]"
                            id="soal[INDEX][opsi][C]"
                            placeholder="Opsi C">
                    </div>
                </div>

                <div class="row align-items-center mb-2">
                    <div class="col-md-1">
                        <input
                            type="radio"
                            class="jawaban-radio"
                            name="soal[INDEX][jawaban]"
                            id="soal[INDEX][jawaban]"
                            value="D">
                    </div>

                    <div class="col-md-11">
                        <input
                            type="text "
                            class="form-control opsi-d"
                            name="soal[INDEX][opsi][D]"
                            id="soal[INDEX][opsi][D]"
                            placeholder="Opsi D">
                    </div>
                </div>

                <div class="row align-items-center mb-2">
                    <div class="col-md-1">
                        <input
                            type="radio"
                            class="jawaban-radio"
                            name="soal[INDEX][jawaban]"
                            id="soal[INDEX][jawaban]"
                            value="E">
                    </div>

                    <div class="col-md-11">
                        <input
                            type="text "
                            class="form-control opsi-e"
                            name="soal[INDEX][opsi][E]"
                            id="soal[INDEX][opsi][E]"
                            placeholder="Opsi E">
                    </div>
                </div>

            </div>

            <div class="essay-section d-none">

                <label>Jawaban Essay <span class="text-danger">*</span></label>

                <textarea
                    class="form-control essay"
                    rows="4"
                    name="soal[INDEX][essay]"
                    id="soal[INDEX][essay]"
                    >
                </textarea>

            </div>

            <div class="form-group mt-3">

                <label>Keterangan</label>

                <textarea
                    class="form-control keterangan"
                    rows="4"
                    name="soal[INDEX][keterangan]"
                    id="soal[INDEX][keterangan]"
                    >
                </textarea>

            </div>

        </div>

    </div>

    </div>
</script>

<script>
    let nomorSoal = 0;

    function tambahSoal() {

    $('.collapse').collapse('hide');

    let html = $('#template-soal').html();
    html = html.replaceAll('INDEX', nomorSoal);

    $('#soalContainer').append(html);

    $('#collapseSoal' + nomorSoal).collapse('show');

    updateNomor();

    nomorSoal++;
    }

    function updateNomor() {

        $('.soal-item').each(function(index) {
            $(this).find('.nomor-soal').text(index + 1);
        });
    }

    $('#btnTambahSoal').on('click', function() {
        tambahSoal();
    });

    $(document).on('click', '.hapus-soal', function() {

        $(this).closest('.soal-item').remove();

        updateNomor();

    });

    $(document).on('change', '.tipe-soal', function() {

        let card = $(this).closest('.soal-item');

        if ($(this).val() == '2') {

            card.find('.pilihan-ganda').hide();
            card.find('.essay-section').removeClass('d-none');

        } else {

            card.find('.pilihan-ganda').show();
            card.find('.essay-section').addClass('d-none');

        }

    });

    tambahSoal();

    
    $(document).on('input', '.pertanyaan', function () {
    let text = $(this).val().trim();

    $(this)
        .closest('.soal-item')
        .find('.judul-soal')
        .text(text || 'Soal Baru');
    });
</script>
<script>
    $(document).ready(function () {
        createtable('invoice-list')
        
        $('#pilihan-ganda').attr('hidden', true)
        $('#essay').attr('hidden', true)

        $('#mySelect2').select2({
            dropdownParent: $('#userModal')
        });
    })

    // Fungsi ketika tombol 'Edit' diklik
    function editUser(user) {
        console.log('data', user.soal);
        
        $('#id').val = null;
        $('#soalContainer').html(null);
        $('#tipe_prepost0').removeAttr('checked')
        $('#tipe_prepost1').removeAttr('checked')
        if (user) {
            $('#id').val(user.id);
            $('#id_materi').val(user.id_materi);
            $('#id_submateri').val(user.id_submateri);
            $('#judul').val(user.judul);
            if (user.tipe_prepost == 0) {
                $('#tipe_prepost0').attr('checked', true)
            }else{
                $('#tipe_prepost1').attr('checked', true)
            }

            JSON.parse(user.soal).forEach((soal,i) => {
                tambahSoal();
                console.log('e.pertanyaan',soal.pertanyaan,i);
                let card = $('#soalContainer .soal-item').last();
                card.find('.pertanyaan').val(soal.pertanyaan);
                card.find('.tipe-soal')
                    .val(soal.tipe_pertanyaan)
                    .trigger('change');
                card.find('.essay').val(soal.essay);
                card.find('.keterangan').val(soal.keterangan);
                if (soal.opsi) {
                    card.find('.opsi-a').val(soal.opsi.A);
                    card.find('.opsi-b').val(soal.opsi.B);
                    card.find('.opsi-c').val(soal.opsi.C);
                    card.find('.opsi-d').val(soal.opsi.D);
                    card.find('.opsi-e').val(soal.opsi.E);
                }

                card.find(
                    `.jawaban-radio[value="${soal.jawaban}"]`
                ).prop('checked', true);

            });
        }else{
            tambahSoal();
        }
        // Tampilkan Modal secara terprogram
        $('#userModal').modal('show');
    }

    function changepertanyaan() {
        let p = $('#tipe_pertanyaan').val();
        $('#pilihan-ganda').attr('hidden', true)
        $('#essay').attr('hidden', true)
        
        if (p == 1) {
            $('#pilihan-ganda').removeAttr('hidden')
        }
        if (p == 2) {
            $('#essay').removeAttr('hidden')
        }
    }
</script>
@endsection