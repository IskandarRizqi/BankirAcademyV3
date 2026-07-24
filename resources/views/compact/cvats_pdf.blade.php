<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CV {{ $lamaran->nama_lengkap ?? $user->name }}</title>
    <style>
        @page {
            margin: 15mm 15mm 15mm 15mm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10.5pt;
            line-height: 1.4;
            color: #111111;
        }
        /* HEADER ATS */
        .header {
            text-align: center;
            border-bottom: 1.5pt solid #111111;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        .fullname {
            font-size: 18pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0 0 4px 0;
        }
        .jobtitle {
            font-size: 11pt;
            font-weight: bold;
            color: #333333;
            margin: 0 0 6px 0;
        }
        .contacts {
            font-size: 9pt;
            color: #444444;
            margin: 0;
        }
        /* SECTION TITLE */
        .section-title {
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1pt solid #111111;
            padding-bottom: 2px;
            margin-top: 14px;
            margin-bottom: 8px;
            color: #000000;
        }
        /* TABLE HELPERS FOR LAYOUT */
        .table-full {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }
        .table-full td {
            vertical-align: top;
            padding: 0;
        }
        .text-right {
            text-align: right;
        }
        .bold {
            font-weight: bold;
        }
        .italic {
            font-style: italic;
        }
        .desc {
            font-size: 9.5pt;
            color: #222222;
            margin-top: 3px;
            margin-bottom: 6px;
        }
        .list-unstyled {
            padding-left: 0;
            list-style: none;
            margin: 0;
        }
        .list-unstyled li {
            margin-bottom: 3px;
        }
    </style>
</head>
<body>

    {{-- HEADER CV --}}
    <div class="header">
        <h1 class="fullname">{{ $lamaran->nama_lengkap ?? $user->name }}</h1>
        
        @php
            $jabatanUtama = 'Pelamar Kerja';
            if (!empty($lamaran->pekerjaanjabatan)) {
                $arrJabatan = is_array($lamaran->pekerjaanjabatan) 
                    ? $lamaran->pekerjaanjabatan 
                    : explode(',', $lamaran->pekerjaanjabatan);
                $jabatanUtama = trim($arrJabatan[0]) ?: 'Pelamar Kerja';
            }
        @endphp

        <div class="jobtitle">{{ $jabatanUtama }}</div>
        <div class="contacts">
            {{ $lamaran->alamatdomisili ?? '' }} 
            @if(!empty($lamaran->telpdomisili)) | Telp: {{ $lamaran->telpdomisili }} @endif
            | Email: {{ $user->siswa->email }}
        </div>
    </div>

    {{-- DATA PRIBADI --}}
    <div class="section-title">Data Pribadi</div>
    <table class="table-full" style="font-size: 9.5pt;">
        <tr>
            <td width="50%"><strong>Tempat, Tgl Lahir:</strong> {{ $lamaran->tmpttgllahir ?? '-' }}</td>
            <td width="50%"><strong>Status Perkawinan:</strong> {{ $lamaran->statusperkawinan ?? '-' }}</td>
        </tr>
        <tr>
            <td width="50%"><strong>Agama:</strong> {{ $lamaran->namaagama ?? $lamaran->agama ?? '-' }}</td>
            <td width="50%"><strong>Kode Pos:</strong> {{ $lamaran->kodepos ?? '-' }}</td>
        </tr>
    </table>

    {{-- RINGKASAN PROFIL --}}
    @if(!empty($lamaran->pengalamanspesifik))
    <div class="section-title">Ringkasan Profil</div>
    <div class="desc" style="text-align: justify;">
        {{ $lamaran->pengalamanspesifik }}
    </div>
    @endif

    {{-- PENGALAMAN KERJA --}}
    <div class="section-title">Pengalaman Kerja</div>
    @php
        $perusahaanList = is_array($lamaran->pekerjaanperusahaan ?? null) 
            ? $lamaran->pekerjaanperusahaan 
            : array_filter(explode(',', $lamaran->pekerjaanperusahaan ?? ''));
        
        $jabatanList = is_array($lamaran->pekerjaanjabatan ?? null) 
            ? $lamaran->pekerjaanjabatan 
            : explode(',', $lamaran->pekerjaanjabatan ?? '');
        
        $tahunList = is_array($lamaran->pekerjaantahun ?? null) 
            ? $lamaran->pekerjaantahun 
            : explode(',', $lamaran->pekerjaantahun ?? '');
            
        $tanggungJawabList = is_array($lamaran->pekerjaantanggungjawab ?? null) 
            ? $lamaran->pekerjaantanggungjawab 
            : explode(';', $lamaran->pekerjaantanggungjawab ?? '');
    @endphp

    @forelse($perusahaanList as $index => $perusahaan)
        <table class="table-full">
            <tr>
                <td class="bold" style="font-size: 10pt;">{{ $jabatanList[$index] ?? 'Posisi Pekerjaan' }}</td>
                <td class="text-right bold" style="font-size: 9.5pt;">{{ $tahunList[$index] ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="2" class="italic" style="font-size: 9.5pt; color: #444;">{{ $perusahaan }}</td>
            </tr>
        </table>
        @if(!empty($tanggungJawabList[$index]))
            <div class="desc">{{ $tanggungJawabList[$index] }}</div>
        @endif
    @empty
        <div class="desc italic">Belum ada riwayat pengalaman kerja.</div>
    @endforelse

    {{-- PENDIDIKAN --}}
    <div class="section-title">Pendidikan</div>
    
    @if(!empty($lamaran->pascasarjananama))
    <table class="table-full">
        <tr>
            <td class="bold">{{ $lamaran->pascasarjananama }}</td>
            <td class="text-right">{{ $lamaran->pascasarjanatahun }}</td>
        </tr>
        <tr>
            <td colspan="2" class="desc" style="margin: 0;">{{ $lamaran->pascasarjanafakultas }} (Gelar: {{ $lamaran->pascasarjanagelar }})</td>
        </tr>
    </table>
    @endif

    @if(!empty($lamaran->perguruannama))
    <table class="table-full">
        <tr>
            <td class="bold">{{ $lamaran->perguruannama }}</td>
            <td class="text-right">{{ $lamaran->perguruantahun }}</td>
        </tr>
        <tr>
            <td colspan="2" class="desc" style="margin: 0;">{{ $lamaran->perguruanfakultas }} (Gelar: {{ $lamaran->perguruangelar }})</td>
        </tr>
    </table>
    @endif

    @if(!empty($lamaran->akademinama))
    <table class="table-full">
        <tr>
            <td class="bold">{{ $lamaran->akademinama }}</td>
            <td class="text-right">{{ $lamaran->akademitahun }}</td>
        </tr>
        <tr>
            <td colspan="2" class="desc" style="margin: 0;">{{ $lamaran->akademifakultas }} (Gelar: {{ $lamaran->akademigelar }})</td>
        </tr>
    </table>
    @endif

    @if(!empty($lamaran->smanama))
    <table class="table-full">
        <tr>
            <td class="bold">{{ $lamaran->smanama }}</td>
            <td class="text-right">{{ $lamaran->smatahun }}</td>
        </tr>
        <tr>
            <td colspan="2" class="desc" style="margin: 0;">{{ $lamaran->smafakultas ?? 'SMA / SMK' }}</td>
        </tr>
    </table>
    @endif

    {{-- PELATIHAN & SERTIFIKASI --}}
    @php
        $pelatihanList = is_array($lamaran->pelatihannama ?? null) 
            ? $lamaran->pelatihannama 
            : array_filter(explode(',', $lamaran->pelatihannama ?? ''));
        
        $penyelenggaraList = is_array($lamaran->pelatihanpenyelanggara ?? null) 
            ? $lamaran->pelatihanpenyelanggara 
            : explode(',', $lamaran->pelatihanpenyelanggara ?? '');
        
        $tahunPelatihanList = is_array($lamaran->pelatihantahun ?? null) 
            ? $lamaran->pelatihantahun 
            : explode(',', $lamaran->pelatihantahun ?? '');
    @endphp

    @if(count($pelatihanList) > 0)
    <div class="section-title">Pelatihan & Sertifikasi</div>
    @foreach($pelatihanList as $idx => $namaPelatihan)
        <table class="table-full" style="margin-bottom: 4px;">
            <tr>
                <td style="font-size: 9.5pt;">
                    <strong>{{ $namaPelatihan }}</strong> 
                    @if(!empty($penyelenggaraList[$idx])) - {{ $penyelenggaraList[$idx] }} @endif
                </td>
                <td class="text-right" style="font-size: 9.5pt;">{{ $tahunPelatihanList[$idx] ?? '-' }}</td>
            </tr>
        </table>
    @endforeach
    @endif

</body>
</html>