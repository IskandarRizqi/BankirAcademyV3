# Dokumentasi Sesudah Refactor Tahap 2

Tanggal: 2026-08-11

## Ringkasan

Tahap 2 menerapkan keputusan bahwa `backend.template` sudah tidak digunakan. Route dan MVC yang hanya melayani layout tersebut dipindahkan ke arsip, sedangkan route compact, public, member non-anggota, transactions, auth, dan integrasi tetap dipertahankan.

Tidak ada perubahan pada database, URL fitur aktif, route name fitur aktif, layout frontend publik, atau layout member non-anggota.

## Perubahan Route

`RouteServiceProvider` sekarang hanya memuat:

- `routes/api.php` dengan prefix `/api`
- `routes/web.php` sebagai loader browser

`routes/web.php` memuat modul dalam urutan stabil:

```text
routes/web/admin.php
routes/web/compact.php
routes/web/transactions.php
routes/web/auth.php
routes/web/public.php
routes/web/member-non-anggota.php
```

Pembagian tanggung jawab:

- `admin.php`: panel admin dan operasi admin
- `compact.php`: dashboard, siswa, learning, certificate, dan halaman compact
- `transactions.php`: order, payment browser, referral, dan endpoint legacy terkait
- `auth.php`: auth scaffold, social login, activation, dan endpoint activation
- `public.php`: website publik, marketing, katalog, loker publik
- `member-non-anggota.php`: ebook, video, billing, event, CV ATS, dan loker member

`routes/web/admin.php` sekarang hanya berisi route admin yang memiliki halaman compact atau operasi pendukung halaman compact: kelas, instruktur, pembayaran, order manual, loker/perusahaan, dan SOP.

File lama `routes/frontend.php` dan `routes/membernonanggota.php` dipindahkan ke modul baru. Tidak ada duplikasi route loader.

## Perubahan Legacy

Controller `Front\\LayananController` tidak memiliki referensi route atau caller internal dan dipindahkan ke:

```text
docs/legacy/mvc/controllers/Front/LayananController.php
```

Route berikut dikomentari karena action/view target tidak tersedia dan tidak memiliki caller internal:

- `/tesapi`
- `/registerinstructor`
- `/registerc`
- `/detail-kelas` legacy closure
- `/template`

Semua item dicatat pada `docs/architecture/legacy-manifest.md`.

## Controller Dan View

- `Admin\\InstructorController` sekarang menjadi controller canonical untuk operasi instruktur admin dan tidak lagi mewarisi controller backend lama.
- Controller legacy yang hanya digunakan oleh backend.template dipindahkan ke `docs/legacy/mvc/controllers`.
- Controller compatibility yang masih dipakai transaksi/member dipertahankan hanya dengan method aktifnya.
- Controller `Backend`, `Front`, dan `Loker` yang masih dirujuk route tetap berada di runtime.
- Model aktif belum di-rename massal karena terdapat risiko table inference, relasi, queued job, dan polymorphic type. `FeeModel` dan `BonusAplikasiModel` yang sudah tidak memiliki reference runtime dipindahkan ke `docs/legacy/mvc/models`.
- View compact belum diubah massal; path existing tetap dipertahankan agar controller dan AJAX tidak rusak.
- Frontend publik dan member non-anggota tetap aktif dengan layout masing-masing.

View dan partial backend.template dipindahkan ke `docs/legacy/views`, meliputi layout lama, dashboard backend, admin legacy, dan portal instructor lama. View compact pada `backend/classes`, `backend/pembayaran`, `backend/loker`, `backend/manual-class-orders`, `backend/sop`, dan `backend/instructor/instructor.blade.php` tetap aktif.

## Validasi

| Pemeriksaan | Hasil |
| --- | --- |
| PHP lint route modules | berhasil |
| PHP lint controller | berhasil |
| `php artisan route:list` | berhasil, 330 route |
| PHPUnit | berhasil, 17 test dan 127 assertion |
| `npm.cmd run build` | berhasil |
| `composer dump-autoload -o` | selesai |

## Perbaikan PSR-4

Interface `App\Contracts\WhatsAppGateway` dipindahkan dari `app/Contract` ke `app/Contracts` agar sesuai dengan namespace PSR-4. Setelah `composer dump-autoload -o`, warning tersebut tidak muncul lagi.

## Tahap Berikutnya

1. Audit dan normalisasi middleware admin tanpa mengubah hak akses secara implisit.
2. Migrasikan route admin yang masih menunjuk `Backend` ke namespace `Admin` melalui wrapper tipis.
3. Kelompokkan Blade compact berdasarkan domain dengan update seluruh `view`, `extends`, `include`, PDF, dan AJAX reference.
4. Audit model ganda dan explicit table mapping.
5. Arsipkan view/controller/model legacy setelah reference scanner bersih.
