<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Verifikasi Email Siswa</title>
    <!-- Menggunakan Bootstrap 5 CDN untuk tampilan cepat -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-custom {
            max-width: 450px;
            width: 100%;
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <div class="card card-custom p-4 text-center">
        <div class="mb-3">
            @if($status === 'success')
                <div class="text-success display-3">✓</div>
                <h4 class="fw-bold mt-2">Verifikasi Berhasil!</h4>
            @else
                <div class="text-warning display-3">i</div>
                <h4 class="fw-bold mt-2">Informasi Verifikasi</h4>
            @endif
        </div>

        <p class="text-muted mb-4">{{ $message }}</p>

        <div>
            <a href="{{ url('/') }}" class="btn btn-primary w-100 py-2" style="border-radius: 8px;">
                Kembali ke Halaman Utama
            </a>
        </div>
    </div>

</body>
</html>