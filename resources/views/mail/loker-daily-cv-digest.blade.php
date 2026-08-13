<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kandidat Terbaru</title>
</head>

<body
    style="margin: 0; padding: 0; background-color: #f4f7fa; color: #334155; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; line-height: 1.5; -webkit-font-smoothing: antialiased;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
        style="background-color: #f4f7fa; padding: 32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
                    style="max-width: 640px; background-color: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">

                    <!-- Header Banner -->
                    <tr>
                        <td
                            style="background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%); padding: 32px; text-align: left;">
                            <span
                                style="display: inline-block; background-color: rgba(255, 255, 255, 0.18); color: #ffffff; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; padding: 4px 10px; border-radius: 20px; margin-bottom: 12px;">
                                Daily Digest
                            </span>
                            <h1 style="margin: 0; color: #ffffff; font-size: 22px; font-weight: 700; line-height: 1.3;">
                                Rekap Kandidat & CV ATS
                            </h1>
                            <p style="margin: 6px 0 0; color: #e0e7ff; font-size: 14px;">
                                {{ $companyName }} • {{ $sendDate }}
                            </p>
                        </td>
                    </tr>

                    <!-- Content Area -->
                    <tr>
                        <td style="padding: 28px 32px 16px;">
                            <p style="margin: 0 0 20px; color: #475569; font-size: 14px; line-height: 1.6;">
                                Halo Tim HR <strong>{{ $companyName }}</strong>,<br>
                                Berikut adalah rekap lamaran masuk terbaru. Lampiran file CV ATS terpisah telah
                                disertakan pada email ini untuk masing-masing posisi.
                            </p>

                            <!-- Candidate Cards Loop -->
                            @foreach ($candidates as $index => $candidate)
                                <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
                                    style="margin-bottom: 16px; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; border-left: 4px solid #4f46e5;">
                                    <tr>
                                        <td style="padding: 16px 20px;">
                                            <!-- Top Row: Name + Position Badge -->
                                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td style="vertical-align: top;">
                                                        <span
                                                            style="color: #64748b; font-size: 12px; font-weight: 600; text-transform: uppercase;">
                                                            #{{ $index + 1 }} Kandidat
                                                        </span>
                                                        <h3
                                                            style="margin: 2px 0 0; color: #0f172a; font-size: 16px; font-weight: 700;">
                                                            {{ $candidate['name'] }}
                                                        </h3>
                                                    </td>
                                                </tr>
                                            </table>

                                            <!-- Metadata List -->
                                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
                                                style="margin-top: 12px; border-top: 1px solid #f1f5f9; padding-top: 10px;">
                                                <tr>
                                                    <td style="padding: 3px 0; font-size: 13px; color: #475569;"
                                                        width="100">
                                                        <strong>Posisi Dilamar</strong>
                                                    </td>
                                                    <td
                                                        style="padding: 3px 0; font-size: 13px; color: #0f172a; font-weight: 600;">
                                                        : {{ $candidate['jobs'] }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 3px 0; font-size: 13px; color: #475569;">
                                                        <strong>Email</strong>
                                                    </td>
                                                    <td style="padding: 3px 0; font-size: 13px; color: #2563eb;">
                                                        : <a href="mailto:{{ $candidate['email'] }}"
                                                            style="color: #2563eb; text-decoration: none;">{{ $candidate['email'] ?: '-' }}</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 3px 0; font-size: 13px; color: #475569;">
                                                        <strong>Waktu Melamar</strong>
                                                    </td>
                                                    <td style="padding: 3px 0; font-size: 13px; color: #64748b;">
                                                        : {{ $candidate['applied_at'] }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            @endforeach

                            <!-- Information Box -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
                                style="margin-top: 20px; background-color: #eff6ff; border: 1px dashed #93c5fd; border-radius: 8px;">
                                <tr>
                                    <td
                                        style="padding: 12px 16px; font-size: 13px; color: #1e40af; text-align: center;">
                                        📎 <strong>{{ count($candidates) }} File PDF CV ATS</strong> dilampirkan pada
                                        email ini sesuai dengan posisi di atas.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="padding: 24px 32px; background-color: #f8fafc; border-top: 1px solid #e2e8f0; text-align: center;">
                            <p style="margin: 0; color: #64748b; font-size: 13px; line-height: 1.5;">
                                Pesan ini dikirim secara otomatis oleh sistem
                                <strong>{{ config('app.name') }}</strong>.<br>
                                Harap tidak membalas email ini secara langsung.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
