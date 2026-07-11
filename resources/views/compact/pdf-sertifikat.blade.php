<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Resmi</title>
    <style>
        /* Mengatur kertas PDF tanpa margin */
        @page {
            margin: 0px;
        }
        html, body {
            margin: 0px;
            padding: 0px;
            width: 100%;
            height: 100%;
            font-family: 'Helvetica', 'Arial', sans-serif;
            
            /* STRATEGI BARU: Pasang gambar langsung sebagai background halaman body */
            background-image: url('{{ $imageSrc }}');
            background-size: 100% 100%; /* Memaksa gambar pas menutupi 1 halaman penuh */
            background-repeat: no-repeat;
        }
        
        /* Kotak pembungkus teks yang memenuhi halaman body */
        .certificate-wrapper {
            position: relative;
            width: 100%;
            height: 100%;
        }

        /* Penempatan Nama Siswa secara dinamis berdasarkan koordinat DB */
        .student-name {
            position: absolute;
            left: {{ $coordinateX }}px;
            top: {{ $coordinateY }}px;
            font-size: {{ $fontSize }}px;
            font-weight: bold;
            color: #000000;
            text-align: center;
            
            /* Teknik Center Alignment pengganti transform translate */
            width: 800px; 
            margin-left: -400px; /* Setengah dari width agar as tengah teks sejajar dengan coordinateX */
        }
    </style>
</head>
<body>

    <div class="certificate-wrapper">
        <div class="student-name">
            {{ $namaSiswa }}
        </div>
    </div>

</body>
</html>