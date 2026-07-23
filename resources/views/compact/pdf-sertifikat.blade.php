<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Resmi</title>
    <style>
        @page {
            margin: 0px;
        }
        html, body {
            margin: 0px;
            padding: 0px;
            width: 1122px;
            height: 793px;
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-image: url('{{ $imageSrc }}');
            background-size: 100% 100%;
            background-repeat: no-repeat;
        }
        
        .certificate-wrapper {
            position: relative;
            width: 1122px;
            height: 793px;
        }

        /* Base style untuk teks tersentralisasi */
        .text-element {
            position: absolute;
            left: {{ ($coordinateX / 1122) * 100 }}%;
            width: 1000px;
            margin-left: -500px; 
            text-align: center;
            line-height: 1;
        }

        /* 1. Nomor Seri Sertifikat */
        .serial-number {
            top: {{ (($serialY ?? 330) / 793) * 100 }}%;
            font-size: {{ $serialFontSize ?? 18 }}px;
            color: #444444;
            letter-spacing: 1px;
        }

        /* 2. Label Teks Diberikan Kepada */
        .given-to-label {
            top: {{ (($labelY ?? 390) / 793) * 100 }}%;
            font-size: {{ $labelFontSize ?? 16 }}px;
            font-style: italic;
            color: #333333;
        }

        /* 3. Nama Siswa / Peserta */
        .student-name {
            top: {{ ($coordinateY / 793) * 100 }}%;
            font-size: {{ $fontSize }}px;
            font-weight: bold;
            color: #000000;
        }
    </style>
</head>
<body>

    <div class="certificate-wrapper">
        <!-- Nomor Seri Unik Peserta -->
        <div class="text-element serial-number">
            No. Sertifikat: {{ $noSertifikat }}
        </div>

        <!-- Teks Keterangan -->
        <div class="text-element given-to-label">
            Diberikan Kepada :
        </div>

        <!-- Nama Peserta -->
        <div class="text-element student-name">
            {{ $namaSiswa }}
        </div>
    </div>

</body>
</html>