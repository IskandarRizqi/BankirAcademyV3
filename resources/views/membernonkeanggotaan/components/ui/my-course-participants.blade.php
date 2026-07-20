@php
    $classId = (int) ($classId ?? 0);
    $participantCount = (int) ($participantCount ?? 0);
    $participants = $participants ?? [];
    $isIht = (bool) ($isIht ?? false);
    $modalId = 'participantsModal-' . $classId;
@endphp

@once
<style>
    .my-course-participants {
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px solid #eef2f7;
    }

    .my-course-participants__summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .my-course-participants__label {
        color: #6b7280;
        font-size: 12px;
        font-weight: 700;
    }

    .my-course-participants__count {
        color: #111827;
        font-size: 15px;
        font-weight: 850;
        font-variant-numeric: tabular-nums;
    }

    .my-course-participants__button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        min-height: 32px;
        padding: 7px 11px;
        border: 1px solid #e5e7eb;
        border-radius: 999px;
        background: #ffffff;
        color: #4f46e5;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }

    .my-course-participants__button:hover {
        border-color: #4f46e5;
        background: #eef0fe;
        color: #4338ca;
    }

    .my-course-participants__readonly {
        color: #9ca3af;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .my-course-participants__list {
        display: grid;
        gap: 10px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .my-course-participants__item {
        padding: 12px;
        border: 1px solid #eef2f7;
        border-radius: 10px;
        background: #f9fafb;
    }

    .my-course-participants__name {
        display: block;
        color: #111827;
        font-size: 13px;
        font-weight: 800;
    }

    .my-course-participants__contact {
        display: block;
        margin-top: 3px;
        color: #6b7280;
        font-size: 12px;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .my-course-participants__empty {
        margin: 0;
        color: #6b7280;
        font-size: 13px;
    }
</style>
@endonce

<div class="my-course-participants">
    <div class="my-course-participants__summary">
        <div>
            <span class="my-course-participants__label">Jumlah peserta</span>
            <strong class="my-course-participants__count d-block">
                {{ $participantCount > 0 ? $participantCount . ' orang' : 'Belum diisi' }}
            </strong>
        </div>

        <button type="button" class="my-course-participants__button" data-toggle="modal" data-target="#{{ $modalId }}">
            <i class="fas {{ $isIht ? ($participantCount > 0 ? 'fa-pen' : 'fa-plus') : 'fa-eye' }}"></i>
            {{ $isIht ? ($participantCount > 0 ? 'Kelola' : 'Tambah') : 'Lihat' }}
        </button>
    </div>
</div>

<div class="modal fade my-course-participants-modal" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="{{ $modalId }}Title" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title font-weight-bold" id="{{ $modalId }}Title">Daftar Peserta</h5>
                    <p class="text-muted mb-0 small">{{ $isIht ? 'Kelola data peserta kelas IHT.' : 'Data peserta kelas.' }}</p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            @if($isIht)
                <form method="POST" enctype="multipart/form-data" action="{{ route('membernonanggota.class-participants.store', $classId) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="participant-editor" data-participant-editor>
                            @foreach($participants as $participant)
                                <div class="participant-editor__row row mb-2">
                                    <div class="col-md-4 mb-2 mb-md-0">
                                        <input type="text" name="nama[]" class="form-control" placeholder="Nama" value="{{ $participant['nama'] }}" required>
                                    </div>
                                    <div class="col-md-4 mb-2 mb-md-0">
                                        <input type="email" name="email[]" class="form-control" placeholder="Email" value="{{ $participant['email'] }}" required>
                                    </div>
                                    <div class="col-md-4 d-flex">
                                        <input type="text" name="nomor_handphone[]" class="form-control" placeholder="Nomor HP" value="{{ $participant['nohp'] }}" required>
                                        <button type="button" class="btn btn-link text-danger js-remove-participant" aria-label="Hapus partisipan">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary js-add-participant">
                            <i class="fas fa-plus mr-1"></i> Tambah Partisipan
                        </button>

                        <div class="mt-4 p-3 border rounded bg-light">
                            <div class="d-flex flex-wrap align-items-center justify-content-between mb-2">
                                <strong class="text-dark">Import dari Excel</strong>
                                <a href="{{ route('membernonanggota.class-participants.template') }}" class="small text-primary">
                                    <i class="fas fa-download mr-1"></i> Unduh template
                                </a>
                            </div>
                            <p class="small text-muted mb-2">
                                Gunakan import untuk menambahkan atau memperbarui data peserta dalam jumlah banyak.
                                File harus menggunakan kolom <code>nama</code>, <code>email</code>, serta <code>nomor_handphone</code>.
                                Sheet <strong>Petunjuk</strong> pada template berisi ketentuan lengkap.
                            </p>
                            <input type="file" name="participant_file" class="form-control-file" accept=".xlsx,.xls,.csv">
                            <button type="submit"
                                formaction="{{ route('membernonanggota.class-participants.import', $classId) }}"
                                formmethod="POST"
                                name="import_participants"
                                value="1"
                                class="btn btn-sm btn-outline-success mt-3">
                                <i class="fas fa-file-import mr-1"></i> Import dan Simpan
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if($participantCount > 0)
                            <button type="submit" formaction="{{ route('membernonanggota.class-participants.destroy', $classId) }}" formmethod="POST" name="_method" value="DELETE" class="btn btn-outline-danger mr-auto" onclick="return confirm('Hapus seluruh data peserta?')">
                                Hapus Semua
                            </button>
                        @endif
                        <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            @else
                <div class="modal-body">
                    @if(count($participants) > 0)
                        <ul class="my-course-participants__list">
                            @foreach($participants as $participant)
                                <li class="my-course-participants__item">
                                    <strong class="my-course-participants__name">{{ $participant['nama'] }}</strong>
                                    <span class="my-course-participants__contact">{{ $participant['email'] }} · {{ $participant['nohp'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="my-course-participants__empty">Belum ada detail peserta yang tersimpan.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
                </div>
            @endif
        </div>
    </div>
</div>

@if($isIht)
@once
<script>
    document.addEventListener('click', function (event) {
        var addButton = event.target.closest('.js-add-participant');
        var removeButton = event.target.closest('.js-remove-participant');

        if (addButton) {
            var editor = addButton.closest('.modal-content').querySelector('[data-participant-editor]');
            var row = document.createElement('div');
            row.className = 'participant-editor__row row mb-2';
            row.innerHTML = '<div class="col-md-4 mb-2 mb-md-0"><input type="text" name="nama[]" class="form-control" placeholder="Nama" required></div>' +
                '<div class="col-md-4 mb-2 mb-md-0"><input type="email" name="email[]" class="form-control" placeholder="Email" required></div>' +
                '<div class="col-md-4 d-flex"><input type="text" name="nomor_handphone[]" class="form-control" placeholder="Nomor HP" required><button type="button" class="btn btn-link text-danger js-remove-participant" aria-label="Hapus partisipan"><i class="fas fa-trash"></i></button></div>';
            editor.appendChild(row);
        }

        if (removeButton) {
            removeButton.closest('.participant-editor__row').remove();
        }
    });

    document.addEventListener('submit', function (event) {
        var form = event.target;
        var editor = form.querySelector('[data-participant-editor]');

        if (!editor) {
            return;
        }

        if (event.submitter && ['DELETE', '1'].includes(event.submitter.value)) {
            return;
        }

        var inputs = editor.querySelectorAll('input[required]');
        var hasEmptyValue = inputs.length === 0;

        inputs.forEach(function (input) {
            if (input.value.trim() === '') {
                hasEmptyValue = true;
            }
        });

        if (hasEmptyValue) {
            event.preventDefault();

            if (window.Swal) {
                Swal.fire({
                    title: 'Data belum lengkap',
                    text: 'Silakan isi minimal satu data peserta terlebih dahulu.',
                    icon: 'warning'
                });
            } else {
                alert('Silakan isi minimal satu data peserta terlebih dahulu.');
            }
        }
    });
</script>
@endonce
@endif

@once
<script>
    $(document).on('show.bs.modal', '.my-course-participants-modal', function () {
        if (this.parentNode !== document.body) {
            document.body.appendChild(this);
        }
    });
</script>
@endonce
