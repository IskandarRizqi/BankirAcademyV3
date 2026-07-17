<x-mail::message>
    # Aktivasi Akun

    Halo {{ $userName }},

    Akun Anda telah dibuat. Silakan melakukan konfirmasi email melalui tombol berikut.

    <x-mail::button :url="$activationUrl">
        Aktivasi Akun
    </x-mail::button>

    Link ini berlaku sampai **{{ $expiredAt }}**.

    Setelah akun diaktifkan, password sementara akan dikirim ke nomor WhatsApp yang telah terdaftar.

    Apabila Anda tidak merasa meminta aktivasi ini, abaikan email tersebut.

    Terima kasih,<br>
    {{ config('app.name') }}
</x-mail::message>