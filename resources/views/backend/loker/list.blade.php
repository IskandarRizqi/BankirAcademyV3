@extends('layouts.compact')

@section('content')
    <div class="container-fluid px-4 py-4">
        <!-- Header Page -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-2 border-bottom">
            <div class="mb-2 mb-md-0">
                <h4 class="fw-bold text-dark mb-1">Rekapitulasi Pelamar Kerja</h4>
                <p class="text-muted small mb-0">Kelola dan tinjau berkas lamaran masuk secara efisien.</p>
            </div>
        </div>

        <!-- Cards Summary Stat -->
        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div
                            class="avatar-stat bg-primary-subtle text-primary rounded-3 p-3 me-3 d-flex align-items-center justify-content-center">
                            <i class="bx bx-file fs-2"></i>
                        </div>
                        <div>
                            <span class="text-muted fw-medium small d-block">Total Lamaran</span>
                            <h3 class="fw-bold text-dark mb-0 mt-1">{{ $data->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div
                            class="avatar-stat bg-warning-subtle text-warning rounded-3 p-3 me-3 d-flex align-items-center justify-content-center">
                            <i class="bx bx-time-five fs-2"></i>
                        </div>
                        <div>
                            <span class="text-muted fw-medium small d-block">Menunggu Tinjauan</span>
                            <h3 class="fw-bold text-dark mb-0 mt-1">{{ $data->where('status', '!=', 1)->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div
                            class="avatar-stat bg-success-subtle text-success rounded-3 p-3 me-3 d-flex align-items-center justify-content-center">
                            <i class="bx bx-check-circle fs-2"></i>
                        </div>
                        <div>
                            <span class="text-muted fw-medium small d-block">Terkirim / Diproses</span>
                            <h3 class="fw-bold text-dark mb-0 mt-1">{{ $data->where('status', 1)->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Data Table Card -->
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                <h6 class="fw-bold text-dark mb-0">Daftar Berkas Masuk</h6>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="applytable" class="table table-hover align-middle w-100">
                        <thead class="table-light text-secondary">
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="30%">Informasi Pelamar</th>
                                <th width="30%">Posisi & Perusahaan</th>
                                <th width="15%">Tanggal Apply</th>
                                <th width="10%">Status</th>
                                <th width="10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $v)
                                <tr>
                                    <td class="text-center fw-medium text-muted">{{ $key + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-initial rounded-circle bg-primary-subtle text-primary fw-bold me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                                                style="width: 42px; height: 42px; font-size: 1.1rem;">
                                                {{ strtoupper(substr($v->user->name ?? 'P', 0, 1)) }}
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold text-dark">{{ $v->user->name ?? 'N/A' }}</h6>
                                                <small class="text-muted">{{ $v->user->email ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="fw-semibold text-dark d-block">{{ $v->lamaran->title ?? 'Tidak Ada Posisi' }}</span>
                                        <small class="text-muted d-flex align-items-center mt-1">
                                            <i
                                                class="bx bx-buildings me-1 text-secondary"></i>{{ $v->lamaran->perusahaan->nama ?? 'Perusahaan N/A' }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="small text-secondary fw-medium">
                                            <i
                                                class="bx bx-calendar me-1"></i>{{ $v->created_at ? $v->created_at->format('d M Y, H:i') : '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($v->status == 1)
                                            <span
                                                class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2 fw-medium">
                                                <i class="bx bx-check-circle me-1 align-middle"></i>{{ $v->status_name }}
                                            </span>
                                        @else
                                            <span
                                                class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-3 py-2 fw-medium">
                                                <i class="bx bx-time me-1 align-middle"></i>{{ $v->status_name }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <button
                                                class="btn btn-primary btn-sm rounded-2 me-1 d-inline-flex align-items-center"
                                                onclick="opencv({{ json_encode($v) }})" title="Lihat Detail Pelamar">
                                                <i class="bx bx-show me-1"></i> Detail
                                            </button>
                                            {{-- <a href="/loker/{{ $v->lamaran->id ?? '#' }}/detail"
                                                class="btn btn-outline-secondary btn-sm rounded-2 d-inline-flex align-items-center"
                                                title="Lihat Detail Lowongan" target="_blank">
                                                <i class="bx bx-link-external"></i>
                                            </a> --}}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Curriculum Vitae -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg rounded-3">
                <div class="modal-header bg-light border-0 py-3 px-4">
                    <h5 class="modal-title fw-bold text-dark d-flex align-items-center" id="exampleModalLabel">
                        <i class="bx bx-id-card me-2 text-primary fs-4"></i>Detail Ringkasan Pelamar
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <!-- Ringkasan Pelamar -->
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border h-100">
                                <h6 class="fw-bold text-primary mb-3 d-flex align-items-center">
                                    <i class="bx bx-user me-2"></i>Data Pelamar
                                </h6>
                                <div class="mb-2">
                                    <small class="text-muted d-block">Nama Lengkap</small>
                                    <span class="fw-semibold text-dark" id="modal-user-name">-</span>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted d-block">Alamat Email</small>
                                    <span class="fw-semibold text-dark" id="modal-user-email">-</span>
                                </div>
                                <div>
                                    <small class="text-muted d-block mb-1">Status Lamaran</small>
                                    <span id="modal-status"
                                        class="badge bg-info-subtle text-info border border-info-subtle px-3 py-1">-</span>
                                </div>
                            </div>
                        </div>
                        <!-- Ringkasan Job -->
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border h-100">
                                <h6 class="fw-bold text-primary mb-3 d-flex align-items-center">
                                    <i class="bx bx-briefcase me-2"></i>Informasi Lowongan
                                </h6>
                                <div class="mb-2">
                                    <small class="text-muted d-block">Posisi Dituju</small>
                                    <span class="fw-semibold text-dark" id="modal-job-title">-</span>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted d-block">Nama Perusahaan</small>
                                    <span class="fw-semibold text-dark" id="modal-job-company">-</span>
                                </div>
                                {{-- <div>
                                    <small class="text-muted d-block">Lokasi</small>
                                    <span class="fw-semibold text-dark" id="modal-job-location">-</span>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3 px-4">
                    {{-- <a class="btn btn-primary btn-sm rounded-2 d-inline-flex align-items-center" href=""
                        id="sendemail" target="_blank">
                        <i class="bx bx-envelope me-1"></i> Hubungi via Email
                    </a> --}}
                    <button type="button" class="btn btn-secondary btn-sm rounded-2" data-bs-dismiss="modal"
                        data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script>
        $(document).ready(function() {
            if (typeof createDataTable === 'function') {
                createDataTable('#applytable');
            } else {
                $('#applytable').DataTable({
                    responsive: true,
                    language: {
                        searchPlaceholder: "Cari pelamar / posisi..."
                    }
                });
            }
        });

        function opencv(data) {
            // Populate modal data
            $('#modal-user-name').text(data.user ? data.user.name : '-');
            $('#modal-user-email').text(data.user ? data.user.email : '-');
            $('#modal-status').text(data.status_name || '-');

            if (data.lamaran) {
                $('#modal-job-title').text(data.lamaran.title || data.lamaran.nama || '-');
                $('#modal-job-company').text(data.lamaran.perusahaan.nama || '-');

                var lokasi = [];
                if (data.lamaran.kabupaten_name) lokasi.push(data.lamaran.kabupaten_name);
                if (data.lamaran.provinsi_name) lokasi.push(data.lamaran.provinsi_name);
                $('#modal-job-location').text(lokasi.length > 0 ? lokasi.join(', ') : '-');

                var mailTarget = data.user ? data.user.email : data.lamaran.email;
                var subject = encodeURIComponent('Tindak Lanjut Lamaran: ' + (data.lamaran.title || ''));
                $('#sendemail').attr('href', 'mailto:' + mailTarget + '?subject=' + subject);
            }

            // Tampilkan Modal (Dukungan penuh Bootstrap 4 & 5)
            if (typeof $('#exampleModal').modal === 'function') {
                $('#exampleModal').modal('show');
            } else if (typeof bootstrap !== 'undefined') {
                var modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                modal.show();
            }
        }
    </script>
@endsection
