@extends('layouts.compact')

@section('content')
<div class="py-4">
    <div class="card border-0 shadow-sm p-4" style="border-radius: 12px; background: #fff;">
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <h3 class="h4 font-weight-bold text-primary mb-0">{{ $title }}</h3>
            <a href="{{ route('cvats.index') }}" class="btn btn-outline-secondary btn-sm">← Kembali ke CV</a>
        </div>

        <form action="{{ $action }}" method="POST">
            @csrf
            @if($method === 'PUT')
                @method('PUT')
            @endif

            {{-- SECTION 1: DATA PRIBADI --}}
            <h5 class="font-weight-bold text-dark mb-3" style="color: #4f46e5;">1. Data Pribadi</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold small text-muted">Nama Lengkap *</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $lamaran->nama_lengkap) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold small text-muted">Nama Panggilan *</label>
                    <input type="text" name="nama_panggilan" class="form-control" value="{{ old('nama_panggilan', $lamaran->nama_panggilan) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold small text-muted">Tempat, Tanggal Lahir *</label>
                    <input type="text" name="tmpttgllahir" class="form-control" placeholder="Jakarta, 12 Januari 1998" value="{{ old('tmpttgllahir', $lamaran->tmpttgllahir) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold small text-muted">Agama *</label>
                    <select name="agama" class="form-control">
                        <option value="0" {{ $lamaran->agama == 0 ? 'selected' : '' }}>Islam</option>
                        <option value="1" {{ $lamaran->agama == 1 ? 'selected' : '' }}>Katholik</option>
                        <option value="2" {{ $lamaran->agama == 2 ? 'selected' : '' }}>Protestan</option>
                        <option value="3" {{ $lamaran->agama == 3 ? 'selected' : '' }}>Hindu</option>
                        <option value="4" {{ $lamaran->agama == 4 ? 'selected' : '' }}>Budha</option>
                        <option value="5" {{ $lamaran->agama == 5 ? 'selected' : '' }}>Tuhan Yang Maha Esa</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="font-weight-bold small text-muted">No. Telepon / WhatsApp *</label>
                    <input type="text" name="telpdomisili" class="form-control" value="{{ old('telpdomisili', $lamaran->telpdomisili) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="font-weight-bold small text-muted">Status Perkawinan *</label>
                    <select name="statusperkawinan" class="form-control">
                        <option value="Belum Menikah" {{ $lamaran->statusperkawinan == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                        <option value="Menikah" {{ $lamaran->statusperkawinan == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                        <option value="Duda/Janda" {{ $lamaran->statusperkawinan == 'Duda/Janda' ? 'selected' : '' }}>Duda/Janda</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="font-weight-bold small text-muted">Kode Pos *</label>
                    <input type="text" name="kodepos" class="form-control" value="{{ old('kodepos', $lamaran->kodepos) }}" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="font-weight-bold small text-muted">Alamat Domisili *</label>
                    <textarea name="alamatdomisili" class="form-control" rows="2" required>{{ old('alamatdomisili', $lamaran->alamatdomisili) }}</textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="font-weight-bold small text-muted">Ringkasan Profil / Ringkasan Keahlian</label>
                    <textarea name="pengalamanspesifik" class="form-control" rows="3" placeholder="Jelaskan ringkasan pengalaman dan keahlian utama Anda...">{{ old('pengalamanspesifik', $lamaran->pengalamanspesifik) }}</textarea>
                </div>
            </div>

            <hr class="my-4">

            {{-- SECTION 2: RIWAYAT PENDIDIKAN --}}
            <h5 class="font-weight-bold text-dark mb-3">2. Riwayat Pendidikan</h5>
            
            {{-- Perguruan Tinggi --}}
            <div class="card bg-light p-3 mb-3 border-0">
                <h6 class="font-weight-bold text-secondary">Perguruan Tinggi (S1 / D4)</h6>
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <input type="text" name="perguruannama" class="form-control" placeholder="Nama Universitas / Institut" value="{{ old('perguruannama', $lamaran->perguruannama) }}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="text" name="perguruanfakultas" class="form-control" placeholder="Fakultas / Program Studi" value="{{ old('perguruanfakultas', $lamaran->perguruanfakultas) }}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="text" name="perguruangelar" class="form-control" placeholder="Gelar (misal: S.Kom)" value="{{ old('perguruangelar', $lamaran->perguruangelar) }}">
                    </div>
                    <div class="col-md-2 mb-2">
                        <input type="text" name="perguruantahun" class="form-control" placeholder="Tahun (2018-2022)" value="{{ old('perguruantahun', $lamaran->perguruantahun) }}">
                    </div>
                </div>
            </div>

            {{-- SMA / SMK --}}
            <div class="card bg-light p-3 mb-3 border-0">
                <h6 class="font-weight-bold text-secondary">SMA / SMK / Sederajat</h6>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <input type="text" name="smanama" class="form-control" placeholder="Nama Sekolah" value="{{ old('smanama', $lamaran->smanama) }}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="text" name="smafakultas" class="form-control" placeholder="Jurusan (misal: IPA/IPS/TKJ)" value="{{ old('smafakultas', $lamaran->smafakultas) }}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="text" name="smatahun" class="form-control" placeholder="Tahun (2015-2018)" value="{{ old('smatahun', $lamaran->smatahun) }}">
                    </div>
                </div>
            </div>

            <hr class="my-4">

            {{-- SECTION 3: PENGALAMAN KERJA (DYNAMIC INPUT) --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="font-weight-bold text-dark mb-0">3. Pengalaman Kerja</h5>
                <button type="button" class="btn btn-sm btn-outline-primary" id="add-work">+ Tambah Pekerjaan</button>
            </div>

            @php
                $perusahaanList = is_array($lamaran->pekerjaanperusahaan) ? $lamaran->pekerjaanperusahaan : explode(',', $lamaran->pekerjaanperusahaan ?? '');
                $jabatanList    = is_array($lamaran->pekerjaanjabatan) ? $lamaran->pekerjaanjabatan : explode(',', $lamaran->pekerjaanjabatan ?? '');
                $tahunList      = is_array($lamaran->pekerjaantahun) ? $lamaran->pekerjaantahun : explode(',', $lamaran->pekerjaantahun ?? '');
                $tanggungJawab  = is_array($lamaran->pekerjaantanggungjawab) ? $lamaran->pekerjaantanggungjawab : explode(';', $lamaran->pekerjaantanggungjawab ?? '');
            @endphp

            <div id="work-container">
                @forelse($perusahaanList as $i => $perusahaan)
                    @if(!empty($perusahaan))
                    <div class="work-row card p-3 mb-3 border">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label class="small font-weight-bold">Nama Perusahaan</label>
                                <input type="text" name="pekerjaanperusahaan[]" class="form-control" value="{{ $perusahaan }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="small font-weight-bold">Jabatan / Posisi</label>
                                <input type="text" name="pekerjaanjabatan[]" class="form-control" value="{{ $jabatanList[$i] ?? '' }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="small font-weight-bold">Tahun / Periode</label>
                                <input type="text" name="pekerjaantahun[]" class="form-control" placeholder="2020 - 2022" value="{{ $tahunList[$i] ?? '' }}">
                            </div>
                            <div class="col-md-1 mb-2 text-right">
                                <label class="d-block">&nbsp;</label>
                                <button type="button" class="btn btn-outline-danger btn-block remove-row">✕</button>
                            </div>
                            <div class="col-md-12">
                                <label class="small font-weight-bold">Tanggung Jawab Utama</label>
                                <input type="text" name="pekerjaantanggungjawab[]" class="form-control" placeholder="Rincian singkat tugas..." value="{{ $tanggungJawab[$i] ?? '' }}">
                            </div>
                        </div>
                    </div>
                    @endif
                @empty
                    <div class="work-row card p-3 mb-3 border">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label class="small font-weight-bold">Nama Perusahaan</label>
                                <input type="text" name="pekerjaanperusahaan[]" class="form-control" placeholder="PT. ABC Indonesia">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="small font-weight-bold">Jabatan / Posisi</label>
                                <input type="text" name="pekerjaanjabatan[]" class="form-control" placeholder="Software Engineer">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="small font-weight-bold">Tahun / Periode</label>
                                <input type="text" name="pekerjaantahun[]" class="form-control" placeholder="2021 - 2023">
                            </div>
                            <div class="col-md-1 mb-2 text-right">
                                <label class="d-block">&nbsp;</label>
                                <button type="button" class="btn btn-outline-danger btn-block remove-row">✕</button>
                            </div>
                            <div class="col-md-12">
                                <label class="small font-weight-bold">Tanggung Jawab Utama</label>
                                <input type="text" name="pekerjaantanggungjawab[]" class="form-control" placeholder="Mengembangkan sistem internal...">
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <hr class="my-4">

            {{-- SECTION 4: PELATIHAN & SERTIFIKASI (DYNAMIC INPUT) --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="font-weight-bold text-dark mb-0">4. Pelatihan & Sertifikasi</h5>
                <button type="button" class="btn btn-sm btn-outline-primary" id="add-training">+ Tambah Pelatihan</button>
            </div>

            @php
                $pelatihanList     = is_array($lamaran->pelatihannama) ? $lamaran->pelatihannama : explode(',', $lamaran->pelatihannama ?? '');
                $penyelenggaraList = is_array($lamaran->pelatihanpenyelanggara) ? $lamaran->pelatihanpenyelanggara : explode(',', $lamaran->pelatihanpenyelanggara ?? '');
                $tahunPelatihan    = is_array($lamaran->pelatihantahun) ? $lamaran->pelatihantahun : explode(',', $lamaran->pelatihantahun ?? '');
            @endphp

            <div id="training-container">
                @forelse($pelatihanList as $idx => $namaPelatihan)
                    @if(!empty($namaPelatihan))
                    <div class="training-row card p-3 mb-2 bg-light border-0">
                        <div class="row">
                            <div class="col-md-5 mb-2">
                                <input type="text" name="pelatihannama[]" class="form-control" placeholder="Nama Pelatihan" value="{{ $namaPelatihan }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <input type="text" name="pelatihanpenyelanggara[]" class="form-control" placeholder="Penyelenggara" value="{{ $penyelenggaraList[$idx] ?? '' }}">
                            </div>
                            <div class="col-md-2 mb-2">
                                <input type="text" name="pelatihantahun[]" class="form-control" placeholder="Tahun" value="{{ $tahunPelatihan[$idx] ?? '' }}">
                            </div>
                            <div class="col-md-1 mb-2">
                                <button type="button" class="btn btn-outline-danger btn-block remove-row">✕</button>
                            </div>
                        </div>
                    </div>
                    @endif
                @empty
                    <div class="training-row card p-3 mb-2 bg-light border-0">
                        <div class="row">
                            <div class="col-md-5 mb-2">
                                <input type="text" name="pelatihannama[]" class="form-control" placeholder="Nama Pelatihan / Kursus">
                            </div>
                            <div class="col-md-4 mb-2">
                                <input type="text" name="pelatihanpenyelanggara[]" class="form-control" placeholder="Penyelenggara / Lembaga">
                            </div>
                            <div class="col-md-2 mb-2">
                                <input type="text" name="pelatihantahun[]" class="form-control" placeholder="Tahun (2022)">
                            </div>
                            <div class="col-md-1 mb-2">
                                <button type="button" class="btn btn-outline-danger btn-block remove-row">✕</button>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- SUBMIT BUTTON --}}
            <div class="mt-5 text-right border-top pt-3">
                <a href="{{ route('cvats.index') }}" class="btn btn-secondary px-4 mr-2">Batal</a>
                <button type="submit" class="btn btn-primary px-5 font-weight-bold">Simpan CV</button>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT DYNAMIC ROWS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Tambah Baris Pekerjaan
    document.getElementById('add-work').addEventListener('click', function () {
        let container = document.getElementById('work-container');
        let newRow = document.createElement('div');
        newRow.className = 'work-row card p-3 mb-3 border';
        newRow.innerHTML = `
            <div class="row">
                <div class="col-md-4 mb-2">
                    <label class="small font-weight-bold">Nama Perusahaan</label>
                    <input type="text" name="pekerjaanperusahaan[]" class="form-control">
                </div>
                <div class="col-md-4 mb-2">
                    <label class="small font-weight-bold">Jabatan / Posisi</label>
                    <input type="text" name="pekerjaanjabatan[]" class="form-control">
                </div>
                <div class="col-md-3 mb-2">
                    <label class="small font-weight-bold">Tahun / Periode</label>
                    <input type="text" name="pekerjaantahun[]" class="form-control">
                </div>
                <div class="col-md-1 mb-2 text-right">
                    <label class="d-block">&nbsp;</label>
                    <button type="button" class="btn btn-outline-danger btn-block remove-row">✕</button>
                </div>
                <div class="col-md-12">
                    <label class="small font-weight-bold">Tanggung Jawab Utama</label>
                    <input type="text" name="pekerjaantanggungjawab[]" class="form-control">
                </div>
            </div>`;
        container.appendChild(newRow);
    });

    // Tambah Baris Pelatihan
    document.getElementById('add-training').addEventListener('click', function () {
        let container = document.getElementById('training-container');
        let newRow = document.createElement('div');
        newRow.className = 'training-row card p-3 mb-2 bg-light border-0';
        newRow.innerHTML = `
            <div class="row">
                <div class="col-md-5 mb-2">
                    <input type="text" name="pelatihannama[]" class="form-control" placeholder="Nama Pelatihan">
                </div>
                <div class="col-md-4 mb-2">
                    <input type="text" name="pelatihanpenyelanggara[]" class="form-control" placeholder="Penyelenggara">
                </div>
                <div class="col-md-2 mb-2">
                    <input type="text" name="pelatihantahun[]" class="form-control" placeholder="Tahun">
                </div>
                <div class="col-md-1 mb-2">
                    <button type="button" class="btn btn-outline-danger btn-block remove-row">✕</button>
                </div>
            </div>`;
        container.appendChild(newRow);
    });

    // Hapus Baris
    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-row')) {
            e.target.closest('.card').remove();
        }
    });
});
</script>
@endsection