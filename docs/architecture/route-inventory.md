# Route Inventory

Status: hasil refactor tahap 1. Baseline sebelum refactor tersedia pada `BEFORE_REFACTOR.md`; hasil sesudah tersedia pada `AFTER_REFACTOR.md`.

Dokumen ini menjadi indeks route setelah route browser dipisahkan berdasarkan konteks. URI dan route name dipertahankan untuk kompatibilitas.

## Konteks Route

| File | Scope |
| --- | --- |
| `routes/web.php` | Loader route browser |
| `routes/web/public.php` | Website publik, halaman marketing, social login |
| `routes/web/auth.php` | Authentication dan activation |
| `routes/web/admin.php` | Panel admin dan operasi admin |
| `routes/web/compact.php` | Dashboard, siswa, dan halaman compact |
| `routes/web/member-non-anggota.php` | Fitur member non-anggota |
| `routes/web/transactions.php` | Order dan endpoint transaksi browser |
| `routes/api.php` | API dan webhook |

## Prinsip Pemeliharaan

- Tambahkan route pada file berdasarkan konteks fitur, bukan berdasarkan kapan route dibuat.
- Gunakan import controller di bagian atas file; hindari FQCN panjang di dalam deklarasi route.
- Gunakan group untuk middleware yang sama.
- Jangan mengubah URI atau route name hanya untuk merapikan folder.
- Route legacy yang dinonaktifkan harus diberi komentar alasan dan dicatat pada `legacy-manifest.md`.
