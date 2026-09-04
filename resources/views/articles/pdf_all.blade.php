<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Semua Artikel</title>
    <style>
        body {
            font-family: sans-serif;
            color: #333;
            font-size: 10pt;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #cbd5e1;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f1f5f9;
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <h2>Daftar Seluruh Artikel</h2>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Keyword</th>
                <th width="50%">Judul Artikel</th>
                <th width="20%">Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($articles as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->keyword }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->created_at ? $item->created_at->format('d M Y H:i') : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
