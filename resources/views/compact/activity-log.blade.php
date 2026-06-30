@extends('layouts.compact')

@section('content')
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="d-flex justify-content-between align-items-center px-4 pt-3">
                <h5 style="font-weight: bold;">Log Aktivitas Sistem</h5>
                <span class="badge badge-primary p-2">Total: {{ $logs->count() }} Log</span>
            </div>
            <hr>

            <table id="activity-log-table" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Waktu</th>
                        <th>Event</th>
                        <th>Pelaku (Causer)</th>
                        <th>Deskripsi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $key => $log)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <small class="text-muted d-block">
                                <i class="far fa-clock mr-1"></i> {{ $log->created_at->format('d M Y') }}
                            </small>
                            <strong>{{ $log->created_at->format('H:i:s') }}</strong>
                        </td>
                        <td>
                            @if($log->event === 'created')
                                <span class="badge badge-success text-uppercase" style="padding: 5px 10px;"><i class="fas fa-plus-circle mr-1"></i> Created</span>
                            @elseif($log->event === 'updated')
                                <span class="badge badge-warning text-uppercase text-white" style="padding: 5px 10px;"><i class="fas fa-edit mr-1"></i> Updated</span>
                            @elseif($log->event === 'deleted')
                                <span class="badge badge-danger text-uppercase" style="padding: 5px 10px;"><i class="fas fa-trash-alt mr-1"></i> Deleted</span>
                            @else
                                <span class="badge badge-info text-uppercase" style="padding: 5px 10px;">{{ $log->event ?? 'Log' }}</span>
                            @endif
                        </td>
                        <td>
                            @if($log->causer)
                                <span style="font-weight: 600;" class="text-dark">{{ $log->causer->name ?? 'User ID: '.$log->causer_id }}</span>
                                <small class="text-muted d-block">{{ class_basename($log->causer_type) }}</small>
                            @else
                                <span class="text-muted"><i>System / Guest</i></span>
                            @endif
                        </td>
                        <td>
                            <p class="mb-1 text-dark">{{ $log->description }}</p>
                            @if($log->subject_type)
                                <small class="text-muted">
                                    <strong>Target:</strong> {{ class_basename($log->subject_type) }} (ID: {{ $log->subject_id ?? '-' }})
                                </small>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            @if($log->properties && $log->properties->count() > 0)
                                <button type="button" 
                                        class="btn btn-sm btn-outline-info view-details" 
                                        data-id="{{ $log->id }}"
                                        data-properties="{{ json_encode($log->properties, JSON_PRETTY_PRINT) }}">
                                    <i class="fas fa-eye mr-1"></i> Detail Perubahan
                                </button>
                            @else
                                <button class="btn btn-sm btn-light text-muted" disabled style="cursor: not-allowed;">
                                    <i class="fas fa-ban mr-1"></i> Kosong
                                </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Tidak ada log aktivitas yang tercatat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="background: #fff; border-radius: 8px;">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white" id="detailModalLabel" style="font-weight: bold;">
                    <i class="fas fa-code mr-2 text-info"></i> Detail Perubahan Log #<span id="modal-log-id"></span>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="modal-body" style="background-color: #f8f9fa;">
                <p class="text-muted small mb-2">Struktur data sebelum (old) dan sesudah (attributes) perubahan:</p>
                <pre class="bg-white p-3 border rounded" style="max-height: 400px; overflow-y: auto; font-family: 'Courier New', Courier, monospace;"><code id="modal-json-content" class="text-success"></code></pre>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Inisialisasi DataTable menggunakan fungsi bawaan template CORK milik Anda
        createtable('activity-log-table');

        // Handler klik tombol Detail Perubahan
        $('#activity-log-table').on('click', '.view-details', function() {
            const logId = $(this).data('id');
            const properties = $(this).data('properties');
            
            // Format object data JSON agar tampil rapi dan indentasi teratur
            const formattedJson = JSON.stringify(properties, null, 4);
            
            $('#modal-log-id').text(logId);
            $('#modal-json-content').text(formattedJson);
            
            // Tampilkan Modal secara manual
            $('#detailModal').modal('show');
        });
    });
</script>
@endsection