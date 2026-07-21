@component('mail::message')
# Halo, {{ $user->name }}!

Akun siswa kamu di **Bankir Academy** telah berhasil dibuat. Silakan klik tombol di bawah ini untuk memverifikasi alamat email pribadi kamu.

@component('mail::button', ['url' => $url])
Verifikasi Email
@endcomponent

*Link verifikasi ini hanya berlaku selama 24 jam.*

Jika kamu tidak merasa mendaftar, abaikan email ini.

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent