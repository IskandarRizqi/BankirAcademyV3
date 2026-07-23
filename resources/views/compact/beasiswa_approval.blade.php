@extends('layouts.compact') {{-- Sesuaikan dengan master layout app Anda --}}

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm" style="border-radius: 8px;">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0" style="font-weight: bold; color: #333;">Persetujuan Beasiswa Peserta (Pending)</h5>
            <span class="badge badge-warning text-dark px-3 py-2" style="font-size: 13px;">
                {{ $pendingSiswa->count() }} Menunggu Persetujuan
            </span>
        </div>
        
        <div class="card-body">
            {{-- Flash Alert Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover table-striped alignment-middle" style="font-size: 14px;">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>NISN / Username</th>
                            <th>Nama Peserta</th>
                            <th>Merchant</th>
                            <th>Email Asli</th>
                            <th>Status</th>
                            <th width="18%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingSiswa as $index => $siswa)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $siswa->nisn }}</strong><br>
                                    <small class="text-muted">{{ $siswa->user->email }}</small>
                                </td>
                                <td>{{ $siswa->user->name }}</td>
                                <td>{{ $siswa->user->sekolah->name ?? '-' }}</td>
                                <td>{{ $siswa->email ?? '-' }}</td>
                                <td>
                                    <span class="badge badge-warning px-2 py-1 text-dark" style="font-weight: 500;">
                                        Pending Approval
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center url-actions">
                                        <!-- Tombol Approve -->
                                        <form action="{{ route('users.beasiswa.approval.process', [$siswa->id, 'approve']) }}" method="POST" class="mr-2" onsubmit="return confirm('Setujui beasiswa untuk peserta ini?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success px-3">
                                                Approve
                                            </button>
                                        </form>

                                        <!-- Tombol Reject -->
                                        <form action="{{ route('users.beasiswa.approval.process', [$siswa->id, 'reject']) }}" method="POST" onsubmit="return confirm('Tolak pengajuan beasiswa peserta ini?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger px-3">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" alt="Empty" style="width: 60px; opacity: 0.5;" class="mb-3"><br>
                                    Tidak ada data pengajuan beasiswa yang berstatus pending saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection