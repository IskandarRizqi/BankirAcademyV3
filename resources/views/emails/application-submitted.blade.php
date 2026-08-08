<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }

        .header {
            background-color: #4f46e5;
            color: #ffffff;
            padding: 15px;
            border-radius: 6px 6px 0 0;
            text-align: center;
        }

        .content {
            padding: 20px 0;
        }

        .table-info {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table-info td {
            padding: 8px;
            border-bottom: 1px solid #f3f4f6;
        }

        .table-info td:first-child {
            font-weight: bold;
            width: 35%;
            color: #4b5563;
        }

        .attachment-note {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            padding: 12px;
            border-radius: 6px;
            color: #166534;
            font-size: 13px;
            margin-top: 15px;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #9ca3af;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0;">Lamaran Pekerjaan Baru</h2>
        </div>
        <div class="content">
            <p>Halo Tim HRD <strong>{{ $loker->perusahaan->nama ?? 'Perusahaan' }}</strong>,</p>
            <p>Ada lamaran baru yang masuk untuk posisi <strong>{{ $loker->title }}</strong>. Berikut ringkasan data
                pelamar:</p>

            <table class="table-info">
                <tr>
                    <td>Nama Lengkap</td>
                    <td>{{ $applicant->nama_lengkap }}</td>
                </tr>
                <tr>
                    <td>Email Pelamar</td>
                    <td>{{ $applicant->user->email ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Nomor Telepon</td>
                    <td>{{ $applicant->telpdomisili ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Alamat Domisili</td>
                    <td>{{ $applicant->alamatdomisili ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Pendidikan Terakhir</td>
                    <td>{{ $applicant->perguruannama ?? ($applicant->smanama ?? '-') }}</td>
                </tr>
            </table>

            <div class="attachment-note">
                📎 <strong>Lampiran Berkas:</strong> File CV ATS format PDF milik kandidat telah dilampirkan pada email
                ini.
            </div>
        </div>
        <div class="footer">
            <p>Email ini dikirimkan secara otomatis oleh sistem lowongan kerja.</p>
        </div>
    </div>
</body>

</html>
