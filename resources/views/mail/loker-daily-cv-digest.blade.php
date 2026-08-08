<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kandidat Terbaru</title>
</head>
<body style="margin:0;background:#f3f4f6;color:#111827;font-family:Arial,Helvetica,sans-serif;line-height:1.6;">
    <div style="max-width:680px;margin:0 auto;padding:28px 16px;">
        <div style="background:#ffffff;border:1px solid #e5e7eb;border-radius:14px;padding:28px;">
            <p style="margin:0 0 8px;color:#4f46e5;font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;">
                Kandidat terbaru
            </p>
            <h1 style="margin:0 0 8px;font-size:24px;line-height:1.3;">Daftar CV Pelamar</h1>
            <p style="margin:0 0 22px;color:#4b5563;">
                Berikut maksimal lima kandidat pertama yang melamar lowongan di {{ $companyName }} sampai {{ $sendDate }}.
            </p>

            @foreach($candidates as $index => $candidate)
                <div style="padding:16px 0;border-top:1px solid #e5e7eb;">
                    <p style="margin:0;color:#111827;font-size:16px;font-weight:700;">
                        {{ $index + 1 }}. {{ $candidate['name'] }}
                    </p>
                    <p style="margin:4px 0 0;color:#4b5563;font-size:14px;">
                        Email: {{ $candidate['email'] ?: '-' }}<br>
                        Lowongan: {{ $candidate['jobs'] }}<br>
                        Melamar: {{ $candidate['applied_at'] }}
                    </p>
                </div>
            @endforeach

            <p style="margin:22px 0 0;color:#4b5563;font-size:14px;">
                CV ATS setiap kandidat terlampir dalam email ini.
            </p>
            <p style="margin:22px 0 0;color:#4b5563;font-size:14px;">
                Terima kasih,<br>
                {{ config('app.name') }}
            </p>
        </div>
    </div>
</body>
</html>
