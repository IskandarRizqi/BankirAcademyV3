<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Kelulusan Resmi</title>
    <style>
        @page {
            margin: 0;
            size: a4 landscape;
        }
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            background-color: #ffffff;
            font-family: 'Helvetica', 'Arial', sans-serif;
        }
        .cert-container {
            padding: 30px;
            box-sizing: border-box;
            width: 100%;
            height: 100%;
        }
        .cert-outer-border {
            border: 10px double #1e3a8a;
            width: 100%;
            height: 92%; /* Menjaga batas proporsi landscape A4 */
            box-sizing: border-box;
        }
        .cert-inner-border {
            border: 2px solid #b45309;
            margin: 10px;
            height: 95%;
            background: #fafaf5;
            text-align: center;
            padding-top: 35px;
            box-sizing: border-box;
            position: relative;
        }
        .title {
            font-family: 'Georgia', serif;
            font-size: 36px;
            text-transform: uppercase;
            color: #1e3a8a;
            margin-bottom: 5px;
            font-weight: bold;
            letter-spacing: 2px;
        }
        .subtitle {
            font-size: 13px;
            color: #555;
            font-style: italic;
            margin-bottom: 35px;
        }
        .award-to {
            font-size: 13px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .student-name {
            font-family: 'Georgia', serif;
            font-size: 30px;
            color: #000;
            font-weight: bold;
            margin: 15px auto;
            border-bottom: 2px solid #92400e;
            width: 65%;
            padding-bottom: 8px;
        }
        .reason {
            font-size: 15px;
            line-height: 1.6;
            margin: 20px auto;
            width: 80%;
            color: #333;
        }
        .class-name {
            font-size: 22px;
            color: #b45309;
            font-weight: bold;
            margin-top: 8px;
        }
        
        /* Mengganti float menggunakan tabel untuk kompatibilitas penuh dompdf */
        .meta-table {
            width: 80%;
            margin: 45px auto 0 auto;
            border-collapse: collapse;
        }
        .meta-col {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }
        .meta-label {
            font-size: 11px;
            color: #666;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .meta-value {
            font-size: 16px;
            font-weight: bold;
            color: #1e3a8a;
            margin-top: 5px;
        }
    </style>
</head>
<body>

    <div class="cert-container">
        <div class="cert-outer-border">
            <div class="cert-inner-border">
                
                <div class="title">Sertifikat Kelulusan</div>
                <div class="subtitle">Sertifikat Penghargaan ini Diberikan atas Pencapaian Kompetensi Akademik</div>
                
                <div class="award-to">Diberikan Kepada :</div>
                <div class="student-name">{{ $siswaUser->name ?? 'Nama Siswa' }}</div>
                
                <div class="reason">
                    Telah dinyatakan <strong>LULUS & KOMPETEN</strong> setelah menyelesaikan rangkaian asesmen materi pembelajaran serta melewati seluruh batas kriteria kelulusan minimal (KKM) pada modul:
                    <div class="class-name">"{{ $materiAktif->nama }}"</div>
                </div>
                
                <table class="meta-table">
                    <tr>
                        <td class="meta-col">
                            <div class="meta-label">NILAI CAPAIAN</div>
                            <div class="meta-value" style="color: #16a34a;">{{ round($progressAktif->nilai_akhir) }} / 100</div>
                        </td>
                        <td class="meta-col">
                            <div class="meta-label">TANGGAL LULUS</div>
                            <div class="meta-value">{{ $tanggalLulus }}</div>
                        </td>
                    </tr>
                </table>

            </div>
        </div>
    </div>

</body>
</html>