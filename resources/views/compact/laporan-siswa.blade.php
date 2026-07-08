@extends('layouts.compact')

@section('content')
<div class=" py-4" style="background-color: #f8fafc; min-height: 100vh;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="font-weight-bold text-dark mb-1">
                <i class="fas fa-chart-line text-primary mr-2"></i> Monitor Pelatihan
            </h3>
            <p class="text-muted mb-0">
                Akses manajemen data untuk Role: <span class="badge badge-primary text-uppercase px-2 py-1">{{ $role }}</span>
            </p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-left: 5px solid #3b82f6 !important;">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-primary-light p-3 mr-3 text-primary" style="background: #eff6ff;">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <div>
                        <small class="text-muted font-weight-bold text-uppercase d-block">Siswa Belajar</small>
                        <h4 class="font-weight-bold text-dark mb-0">{{ $stats['total_siswa_aktif'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-left: 5px solid #10b981 !important;">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-success-light p-3 mr-3 text-success" style="background: #ecfdf5;">
                        <i class="fas fa-book-reader fa-2x"></i>
                    </div>
                    <div>
                        <small class="text-muted font-weight-bold text-uppercase d-block">Modul Terpilih</small>
                        <h4 class="font-weight-bold text-dark mb-0">{{ $stats['total_modul_diikuti'] }} Modul</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-left: 5px solid #f59e0b !important;">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-warning-light p-3 mr-3 text-warning" style="background: #fffbe6;">
                        <i class="fas fa-id-card fa-2x"></i>
                    </div>
                    <div>
                        <small class="text-muted font-weight-bold text-uppercase d-block">Siswa Beasiswa</small>
                        <h4 class="font-weight-bold text-dark mb-0">{{ $stats['total_beasiswa'] }} Orang</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-left: 5px solid #64748b !important;">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-secondary-light p-3 mr-3 text-secondary" style="background: #f1f5f9;">
                        <i class="fas fa-user-friends fa-2x"></i>
                    </div>
                    <div>
                        <small class="text-muted font-weight-bold text-uppercase d-block">Non-Beasiswa</small>
                        <h4 class="font-weight-bold text-dark mb-0">{{ $stats['total_non_beasiswa'] }} Orang</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('warning'))
        <div class="alert alert-warning border-0 shadow-sm mb-4" style="border-radius: 10px;">
            <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('warning') }}
        </div>
    @endif

    @forelse($siswaModulGrouped as $groupName => $items)
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden;">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="font-weight-bold text-dark mb-0">
                    <i class="fas {{ $role === 'root' ? 'fa-university text-info' : 'fa-school text-success' }} mr-2"></i>
                    {{ $groupName }}
                </h5>
                <span class="badge badge-pill badge-light border text-muted px-3 py-1 font-weight-bold">
                    {{ $items->count() }} Record Terdaftar
                </span>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0" style="background-color: white;">
                        <thead class="bg-light text-secondary small font-weight-bold">
                            <tr>
                                <th width="5%" class="pl-4">No</th>
                                <th>Nama Siswa</th>
                                <th>Email</th>
                                <th>Kategori Program</th>
                                <th>Modul / Kelas yang Dipilih</th>
                                <th width="20%" class="text-center pr-4">Aksi Laporan Test</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $index => $item)
                                @php
                                    $isBeasiswa = optional($item->user->siswa)->beasiswa == 1;
                                @endphp
                                <tr>
                                    <td class="pl-4 text-muted">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="font-weight-bold text-dark">{{ $item->user->name ?? 'N/A' }}</div>
                                        <!-- <small class="text-muted">ID User: #{{ $item->user_id }}</small> -->
                                    </td>
                                    <td>{{ $item->user->email ?? '-' }}</td>
                                    <td>
                                        @if($isBeasiswa)
                                            <span class="badge badge-warning text-dark font-weight-bold px-2 py-1" style="border-radius: 6px;">
                                                <i class="fas fa-star mr-1"></i> Jalur Beasiswa
                                            </span>
                                        @else
                                            <span class="badge badge-secondary px-2 py-1" style="border-radius: 6px;">
                                                Reguler (Non-Beasiswa)
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="p-2 bg-info-light rounded mr-2 text-info" style="background: #e0f2fe; border-radius: 6px !important;">
                                                <i class="fas fa-book-open small"></i>
                                            </div>
                                            <span class="font-weight-semibold text-secondary">
                                                {{ $item->materi->nama ?? 'Modul Tidak Diketahui' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-center pr-4">
                                        @if($isBeasiswa)
                                            <a href="{{ route('manajemen.siswa.report', ['user_id' => $item->user_id, 'materi_id' => $item->class_id]) }}" 
                                               class="btn btn-sm btn-primary font-weight-bold px-3 btn-block shadow-sm" 
                                               style="border-radius: 8px;">
                                                <i class="fas fa-file-invoice mr-1"></i> Lihat Nilai Kuis
                                            </a>
                                        @else
                                            <button class="btn btn-sm btn-light text-muted btn-block border" style="border-radius: 8px; cursor: not-allowed;" disabled>
                                                <i class="fas fa-ban mr-1 text-danger"></i> Tidak Ada Test
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5 bg-white shadow-sm border rounded" style="border-radius: 12px;">
            <i class="fas fa-box-open fa-3x text-muted mb-3 d-block"></i>
            <h5 class="text-secondary font-weight-bold">Belum Ada Rekapitulasi Data</h5>
            <p class="text-muted small mb-0">Tidak ditemukan siswa aktif yang mengunci kelas saat ini.</p>
        </div>
    @endif
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection