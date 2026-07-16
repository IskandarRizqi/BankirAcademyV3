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
            /* Mengunci dimensi tepat pada ukuran A4 Landscape di DomPDF */
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

       .student-name {
        position: absolute;
        left: {{ ($coordinateX / 1122) * 100 }}%;
        top: {{ ($coordinateY / 793) * 100 }}%;
        font-size: {{ $fontSize }}px;
        font-weight: bold;
        color: #000000;
        text-align: center;
        width: 1000px;
        margin-left: -500px; 
        
        /* KUNCI PERBAIKAN PDF: Hapus ruang kosong/padding bawaan teks */
        line-height: 1; 
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