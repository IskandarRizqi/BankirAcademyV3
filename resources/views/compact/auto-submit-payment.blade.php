<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Mengarahkan ke Pembayaran...</title>
</head>
<body>
    <div style="text-align: center; margin-top: 50px; font-family: sans-serif;">
        <p>Mengarahkan Anda ke halaman pembayaran, mohon tunggu...</p>
    </div>

    {{-- Form tersembunyi dengan Method POST --}}
    <form id="autoPaymentForm" action="{{ route('payment.order.ebook') }}" method="POST">
        @csrf
        <input type="hidden" name="class_id" value="{{ $subMateri->id }}">
        <input type="hidden" name="price" value="{{ $hargaFinal }}">
        <input type="hidden" name="nama" value="{{ $user->name }}">
        <input type="hidden" name="email" value="{{ $user->email }}">
        <input type="hidden" name="nomor_handphone" value="{{ $user->siswa->no_telp ?? '08123456789' }}">
    </form>

    <script>
        // Jalankan form submit secara otomatis begitu halaman dimuat
        document.getElementById('autoPaymentForm').submit();
    </script>
</body>
</html>